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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
    

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {

    Route::get('/', 'HomeController@index');
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('register', 'AuthController@register');    

    Route::post('logout', 'AuthController@logout');
    Route::post('me', 'AuthController@me');

   Route::group(['prefix' => 'products'], function () {
        Route::get('/','ProductController@store')->name('products.show');
   });

   Route::group(['middleware' => 'jwt.refresh'], function(){
    Route::post('authrefresh', 'AuthController@getAuthenticatedUser');

    });

    Route::group(['middleware' => 'jwt.auth'], function(){

       Route::post('auth/logout', 'AuthController@logout');
       Route::get('auth/user', 'AuthController@user');

       Route::group(['prefix' => 'auth/products', 'middleware' => 'jwt.auth'], function () {
        Route::post('/store','ProductController@store')->name('products.create');
        Route::delete('/destroy','ProductController@destroy')->name('products.delete');
        Route::put('/update','ProductController@update')->name('products.update');
       });

    });
    
});






