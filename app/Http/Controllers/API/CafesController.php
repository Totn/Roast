<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cafe;
use App\Http\Requests\StoreCafeRequest;
use App\Utilities\GaodeMaps;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Utilities\Tagger;
use Illuminate\Support\Facades\DB;


class CafesController extends Controller
{
    /*
     |-------------------------------------------------------------------------------
     | Get All Cafes
     |-------------------------------------------------------------------------------
     | URL:            /api/v1/cafes
     | Method:         GET
     | Description:    Gets all of the cafes in the application
    */
    public function getCafes()
    {
        $cafes = Cafe::with('brewMethods')->get();
        return response()->json($cafes);
    }

    /*
     |-------------------------------------------------------------------------------
     | Get An Individual Cafe
     |-------------------------------------------------------------------------------
     | URL:            /api/v1/cafes/{id}
     | Method:         GET
     | Description:    Gets all of the cafes in the application
    */
    public function getCafe($id)
    {
        $cafe = Cafe::where('id', '=', $id)
            ->with('brewMethods')
            ->with('likes')
            ->first();
        return response()->json($cafe);
    }

    /*
     |-------------------------------------------------------------------------------
     | Adds a New Cafe
     |-------------------------------------------------------------------------------
     | URL:            /api/v1/cafes
     | Method:         POST
     | Description:    Adds a new cafe to the application
    */
    public function postNewCafe(StoreCafeRequest $request)
    {
        // 已添加的咖啡店
        $added_cafes = [];
        $locations = $request->input('locations');

        // 总店/父节点
        $parent_cafe = new Cafe();
        
        // 咖啡店名称
        $parent_cafe->name = $request->input('name');
        // 分店位置名称
        $parent_cafe->location_name = $locations[0]['name'] ?: '';
        // 分店地址
        $parent_cafe->address = $locations[0]['address'] ?: '';
        // 分店所在城市
        $parent_cafe->city = $locations[0]['city'];
        // 分店所在省份
        $parent_cafe->state = $locations[0]['state'];
        // 分店邮政编码
        $parent_cafe->zip = $locations[0]['zip'];
        $coordinates = GaodeMaps::geocodeAddress($parent_cafe->address, $parent_cafe->city, $parent_cafe->state);
        // 纬度
        $parent_cafe->latitude = $coordinates['lat'];
        // 经度
        $parent_cafe->longitude = $coordinates['lng'];
        // 咖啡烘焙师
        $parent_cafe->roaster = $request->input('roaster') ? 1 : 0;
        // 咖啡店网址
        $parent_cafe->website = $request->input('website') ?: '';
        // 咖啡店描述信息
        $parent_cafe->description = $request->input('description') ?: '';
        // 添加者
        $parent_cafe->added_by = $request->user()->id;
        $parent_cafe->save();

        // 冲泡方法
        $brew_methods = $locations[0]['methodsAvailable'];
        // 标签信息
        $tags = $locations[0]['tags'];
        // 保存与此咖啡店关联的所有冲泡方法（保存关联关系）
        $parent_cafe->brewMethods()->sync($brew_methods);
        Tagger::tagCafe($parent_cafe, $tags, $request->user()->id);
        // 当前咖啡店数据推送到已添加咖啡店数组
        array_push($added_cafes, $parent_cafe->toArray());

        // 第一个索引的位置已经使用，从第2个开始
        if (count($locations) > 1) {
            // 从索引值1开始，0位置已使用
            for ($i = 1; $i < count($locations); $i++) { 
                $cafe = new Cafe();

                $cafe->parent = $parent_cafe->id;
                $cafe->name = $request->input('name');
                $cafe->location_name = $locations[$i]['name'] ?: '';
                $cafe->address = $locations[$i]['address'];
                $cafe->city = $locations[$i]['city'];
                $cafe->state = $locations[$i]['state'];
                $cafe->zip = $locations[$i]['zip'];

                // 经纬度
                $coordinates = GaodeMaps::geocodeAddress($cafe->address, $cafe->city, $cafe->state);
                $cafe->latitude = $coordinates['lat'];
                $cafe->longitude = $coordinates['lng'];
                $cafe->roaster = $request->input('roaster') != '' ? 1 : 0;
                $cafe->website = $request->input('website');
                $cafe->description = $request->input('description');
                $cafe->added_by = $request->user()->id;

                $cafe->save();
                // 同步添加冲泡方法
                $cafe->brewMethods()->sync($locations[$i]['methodsAvailable']);
                // 同步添加标签
                $cafe->tags()->sync($locations[$i]['tags']);
                array_push($added_cafes, $cafe->toArray());
            }
        }
        
        return response()->json($added_cafes, 201);
    }

    /*
    |--------------------------------------------------------------------------
    | Add a like to the cafe
    |--------------------------------------------------------------------------
    | URL:  /api/v1/cafes/{id}/like
    | Controller: API\CafesController@postLikeCafe
    | Method: POST
    | Description: Add a like to the cafe
    */
    public function postLikeCafe($cafe_id)
    {
        $cafe = Cafe::where('id', '=', $cafe_id)->first();
        $cafe->likes()->attach(Auth::user()->id, [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return response()->json(['cafe_liked' => true], 201);
    }
   
    /*
    |--------------------------------------------------------------------------
    | Cancle the like to the cafe
    |--------------------------------------------------------------------------
    | URL:  /api/v1/cafes/{id}/like
    | Controller: API\CafesController@postLikeCafe
    | Method: DELETE
    | Description: Cancle the like to the cafe
    */
    public function deleteLikeCafe($cafe_id)
    {
        $cafe = Cafe::where('id', '=', $cafe_id)->first();
        $cafe->likes()->detach(Auth::user()->id);

        return response()->json(null, 204);
    }

    /*
    |--------------------------------------------------------------------------
    | Add one tag to the cafe
    |--------------------------------------------------------------------------
    | URL:  /api/v1/cafes/{id}/tags
    | Controller: API\CafesController@postLikeCafe
    | Method: POST
    | Description: Cancle the like to the cafe
    */
    public function postAddTags(Request $request, $cafe_id)
    {
        // 从请求中获取标签信息
        $tags = $request->input('tags');
        $cafe = Cafe::find('$cafe_id');

        // 处理新增标签并建立标签与咖啡店之间的关联
        Tagger::tagCafe($cafe, $tags, Auth::user()->id);

        // 返回标签
        $cafe = Cafe::where('id', '=', $cafe_id)
            ->with('brewMethods')
            ->with('likes')
            ->with('tags')
            ->first();

        return response()->json($cafe, 201);
    }

    /*
    |--------------------------------------------------------------------------
    | D the like to the cafe
    |--------------------------------------------------------------------------
    | URL:  /api/v1/cafes/{id}/{$tag_id}
    | Controller: API\CafesController@deleteCafeTag
    | Method: DELETE
    | Description: Cancle the like to the cafe
    */
    public function deleteCafeTag($cafe_id, $tag_id)
    {
        // 直接删除中间表中的关联记录
        DB::table('cafes_users_tags')->where('cafe_id', $cafe_id)
            ->where('tag_id', $tag_id)
            ->where('user_id', Auth::user()->id)
            ->delete();

        return response(null, 204);
    }
}
