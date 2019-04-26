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

Route::get('/', 'HomeController@index');

Route::group(['middleware' => 'jwt.auth'], function(){
   Route::post('auth/logout', 'AuthController@logout');
   Route::get('auth/user', 'AuthController@user');
   
});

Route::group(['middleware' => 'jwt.refresh'], function(){
    Route::post('authrefresh', 'AuthController@getAuthenticatedUser');

});

Route::group(['as' => 'product.', 'namespace' => 'Product'], function () {
    Route::get('/', 'ProductController@index')->name('product.index');
    Route::get('/{id}', 'ProductController@show')->name('product.show');
    Route::post('/', 'PostsCoProductControllerntroller@store')->name('product.create');
	Route::delete('/{id}', 'PostsCoProductControllerntroller@destroy')->name('product.delete');
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('me', 'AuthController@me');

});