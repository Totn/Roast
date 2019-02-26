<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;

class CitiesController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Get All The Cities's Data
    |--------------------------------------------------------------------------
    | URL:  /api/v1/cities
    | Controller: API\UsersController@getCities
    | Method: GET
    | Description:  Get All The Cities's Data
    */
    public function getCities()
    {
        $cities = City::all();
        return response()->json($cities);
    }

    /*
    |--------------------------------------------------------------------------
    | Get The Special City Data
    |--------------------------------------------------------------------------
    | URL:  /api/v1/cities/{slug}
    | Controller: API\UsersController@getCity
    | Method: GET
    | Description:  Get The Special City Data About Slug
    */
    public function getCity($slug)
    {
        $city = City::where('slug', '=', $slug)
            // 取出城市所有的咖啡店，及其对应的公司
            ->with(['cafes' => function ($query)
            {
                $query->with('company');
            }])
            ->first();

        if ($city != null) {
            return response()->json($city);
        }

        return response()->json(null, 404);
    }
}
