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

// 公有路由，无需登陆即可访问
Route::group(['prefix' => 'v1'], function ()
{
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
    | Search The Tags
    |--------------------------------------------------------------------------
    | URL:  /api/v1/tags
    | Controller: API\TagsController@tags
    | Method: GET
    | Description:  provide support to Tags's Search
    */
    Route::get('/tags', "API\TagsController@getTags");

    Route::get('/user', 'API\UsersController@getUser');
    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // });
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {

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
    | Viste The Page of Editing Coffee(TODO)
    |--------------------------------------------------------------------------
    | URL:  /api/v1/cafes/{id}/edit
    | Controller: API\CafesController@postNewCafe
    | Method: GET
    | Description: Adds a new cafe to the application
    */
    Route::get('/cafes/{id}/edit', 'API\CafesController@getEditCafe');

    /*
    |--------------------------------------------------------------------------
    | Commit The New Edition Of Coffee(TODO)
    |--------------------------------------------------------------------------
    | URL:  /api/v1/cafes/{id}
    | Controller: API\CafesController@postNewCafe
    | Method: PUT
    | Description: Adds a new cafe to the application
    */
    Route::put('/cafes/{id}/edit', 'API\CafesController@putEditCafe');

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
    | Controller: API\CafesController@deleteLikeCafe
    | Method: DELETE
    | Description: Cancle the like to the cafe
    */
    Route::delete('/cafes/{id}/like', "API\CafesController@deleteLikeCafe");
    
    /*
    |--------------------------------------------------------------------------
    | Add a Tag To The Cafe
    |--------------------------------------------------------------------------
    | URL:  /api/v1/cafes/{id}/tags
    | Controller: API\CafesController@postAddTags
    | Method: POST
    | Description: User Add a Tag To The Cafe
    */
    Route::post('/cafes/{id}/tags', "API\CafesController@postAddTags");

    /*
    |--------------------------------------------------------------------------
    | Delete The Tag Of The Cafe
    |--------------------------------------------------------------------------
    | URL:  /api/v1/cafes/{id}/tags/{tagID}
    | Controller: API\CafesController@deleteCafeTag
    | Method: DELETE
    | Description: User Delete One Of He's Tags To The Cafe
    */
    Route::delete('/cafes/{id}/tags/{tagID}', "API\CafesController@deleteCafeTag");

});
