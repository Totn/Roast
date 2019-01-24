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

Route::get('/', 'Web\AppController@getApp')
->middleware('auth');

Route::get('/login', 'Web\AppController@getLogin')
->name('login')
->middleware('guest');

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