<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditUserRequest;


class UsersController extends Controller
{
    /*
     |-------------------------------------------------------------------------------
     | 获取当前认证用户的信息
     |-------------------------------------------------------------------------------
     | URL:            /api/v1/user
     | Method:         GET
     | Description:    获取当前认证用户的信息
    */
    public function getUser()
    {
        return Auth::guard('api')->user();
    }

    /*
     |-------------------------------------------------------------------------------
     | 更新用户数据
     |-------------------------------------------------------------------------------
     | URL:            /api/v1/user
     | Method:         PUT
     | Description:    更新认证用户的信息
    */
    public function putUpdateUser(EditUserRequest $request)
    {
        $user = Auth::user();

        $favorite_coffee = $request->input('favorite_coffee');
        $flavor_notes = $request->input('flavor_notes');
        $profile_visibility = $request->input('profile_visibility');
        $city = $request->input('city');
        $state = $request->input('state');

        if ($favorite_coffee) {
            $user->favorite_coffee = $favorite_coffee;
        }

        if ($flavor_notes) {
            $user->flavor_notes = $flavor_notes;
        }

        if (!is_null($profile_visibility)) {
            $user->profile_visibility = $profile_visibility;
        }

        if ($city) {
            $user->city = $city;
        }

        if ($state) {
            $user->state = $state;
        }

        $user->save();
        
        return response()->json(['user_updated' => true], 201);
    }
}
