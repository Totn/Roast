<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Web\AppController@getApp');
// 移除认证中间件
// ->middleware('auth');

// 移除旧登陆路由
// Route::get('/login', 'Web\AppController@getLogin')
// ->name('login')
// ->middleware('guest');

// 退出登陆
Route::get('/logout', 'Web\AppController@getLogout');

// 登录证认证路由
Route::get('auth/{social}', 'Web\AuthenticationController@getSocialRedirect')
->middleware('guest');

Route::get('/auth/{social}/callback', 'Web\AuthenticationController@getSocialCallback')
->middleware('guest');

// test getcode
Route::get('geocode', function ()
{
    return \App\Utilities\GaodeMaps::geocodeAddress('滨海大道15号', '海口', '海南');
});

// test cafe
Route::get('/cafe/{id}', 'API\CafesController@getCafe');

// test tags
Route::get('/set-tags/{id}/{tags}', function ($id, $tags)
{
    $cafe = \App\Models\Cafe::find($id);
    $tags = preg_split("/[\s,，]+/", $tags);

    return \App\Utilities\Tagger::tagCafe($cafe, $tags, 1);
});

// test photos
Route::get('/photos/{id}', function ($id)
{
    $photo = \App\Models\CafePhoto::where('id', '=', $id)
        ->with('cafe')
        ->with('user')
        ->first();
    return print_r($photo->toArray(), true);
});