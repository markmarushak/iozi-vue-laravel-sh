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
// this auth routes
    Route::get('/', 'HomeController@index')->name('home');

    Route::group([ 'prefix' => 'home'], function (){

        Route::group(['namespace' => 'Product', 'prefix' => 'home'], function () {
            Route::get('/products','ProductController@cabinet')->name('products.index');
            Route::get('/products/{id}','ProductController@show')->name('products.show');
            Route::post('/search','ProductController@search')->name('products.search');
        });

        Route::group(['namespace' => 'Attribute'], function () {
            Route::get('/attribute/{type}', 'AttributeController@index')->name('attribute.index');
            Route::get('/attribute{id}', 'AttributeController@show')->name('attribute.show');
        });
    });

    Route::post('refresh', 'AuthController@getAuthenticatedUser')->name('auth.refresh');
    Route::post('login', 'AuthController@login')->name('auth.login');
    Route::post('register', 'AuthController@register')->name('auth.register');
    Route::post('logout', 'AuthController@logout')->name('auth.logout');
    Route::post('role', 'AuthController@role')->name('auth.role');



    Route::group(['middleware' => ['jwt'], 'prefix' => 'auth'], function(){
        Route::get('current', 'AuthController@user')->name('get.user');
        Route::get('current-role', 'AuthController@role')->name('get.role');

        Route::group(['prefix' => 'products', 'namespace' => 'Product', 'middleware' => 'jwt'], function () {
            Route::post('/','ProductController@store')->name('products.store');
            Route::put('/','ProductController@update')->name('products.update');
            Route::get('/','ProductController@cabinet')->name('products.cabinet');
            Route::post('/image','ProductController@saveImage')->name('products.image');
            Route::post('/image/upload','ProductController@uploadImage')->name('products.image.upload');
            Route::post('/pay','ProductController@pay')->name('products.pay');

            Route::delete('/{id}','ProductController@destroy')->name('products.destroy');

            Route::group(['prefix' => 'confirm'], function (){
                Route::post('/','ProductController@confirm')->name('confirm.store');
                Route::post('/success','ProductController@confirmSuccess')->name('confirm.success');
                Route::get('/list','ProductController@confirmList')->name('confirm.list');
            });

        });

        Route::group(['prefix' => 'product-attribute', 'namespace' => 'Attribute'], function () {

            Route::post('/', 'AttributeController@store')->name('attribute.store');
            Route::delete('/{id}', 'AttributeController@destroy')->name('attribute.destroy');
            Route::put('/', 'AttributeController@update')->name('attribute.update');

        });

        Route::group(['prefix' => 'payment', 'namespace' => 'Payment'], function () {
            Route::get('/','PaymentController@index')->name('payment.show');
        });
    });







