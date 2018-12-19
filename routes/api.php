<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    /*
    |--------------------------------------------------------------------------
    | Get All Cafes
    |--------------------------------------------------------------------------
    | URL:  /api/v1/cafes
    | Controller: API\CafesController@getCafes
    | Method: GET
    | Description: Gets all of the cafes in the application
    */
    Route::get('/cafes', 'API\CafesController@getCafes');

    /*
    |--------------------------------------------------------------------------
    | Add a New Cafe
    |--------------------------------------------------------------------------
    | URL:  /api/v1/cafes
    | Controller: API\CafesController@postNewCafe
    | Method: POST
    | Description: Adds a new cafe to the application
    */
    Route::post('/cafes', 'API\CafesController@postNewCafe');

    /*
    |--------------------------------------------------------------------------
    | Get An Individual Cafe
    |--------------------------------------------------------------------------
    | URL:  /api/v1/cafes/{id}
    | Controller: API\CafesController@getCafe
    | Method: GET
    | Description: Get An Individual Cafe
    */
    Route::get('/cafes/{id}', "API\CafesController@getCafe");

    /*
    |--------------------------------------------------------------------------
    | Get ALL The Count of The Methods With Cafes
    |--------------------------------------------------------------------------
    | URL:  /api/v1/brew-methods
    | Controller: API\BrewMethodsController@getBrewMethods
    | Method: GET
    | Description: Get ALL The Count of The Methods With Cafes
    */
    Route::get('/brew-methods', "API\BrewMethodsController@getBrewMethods");

    /*
    |--------------------------------------------------------------------------
    | Add a like to the cafe
    |--------------------------------------------------------------------------
    | URL:  /api/v1/cafes/{id}/like
    | Controller: API\CafesController@postLikeCafe
    | Method: POST
    | Description: Add a like to the cafe
    */
    Route::post('/cafes/{id}/like', "API\CafesController@postLikeCafe");    
    
    /*
    |--------------------------------------------------------------------------
    | Cancle the like to the cafe
    |--------------------------------------------------------------------------
    | URL:  /api/v1/cafes/{id}/like
    | Controller: API\CafesController@postLikeCafe
    | Method: DELETE
    | Description: Cancle the like to the cafe
    */
    Route::delete('/cafes/{id}/like', "API\CafesController@deleteLikeCafe");


});
