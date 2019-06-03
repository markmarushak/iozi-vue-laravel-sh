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


        //
    // this auth routes
    //

    Route::group(['middleware' => 'api'], function(){
        Route::post('authrefresh', 'AuthController@getAuthenticatedUser');

    });

    Route::group(['middleware' => ['jwt']], function(){

        Route::get('/get-user', 'AuthController@user')->name('get.user');


        Route::group(['prefix' => 'products', 'namespace' => 'Product', 'middleware' => 'jwt.auth'], function () {
            
            Route::post('/','ProductController@store')->name('products.store');
            Route::put('/','ProductController@update')->name('products.update');
            Route::get('/products','ProductController@cabinet')->name('products.cabinet');
            Route::post('/image','ProductController@saveImage')->name('products.image');
            Route::post('/image/upload','ProductController@uploadImage')->name('products.image.upload');
            Route::post('/confirm','ProductController@confirm')->name('products.confirm');
            Route::post('/pay','ProductController@pay')->name('products.pay');
            Route::get('/confirm-list','ProductController@confirmList')->name('products.confirm.list');
            Route::delete('/{id}','ProductController@destroy')->name('products.destroy');


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

Route::post('/login', 'AuthController@login')->name('login');
Route::post('/register', 'AuthController@register')->name('register');
Route::post('/logout', 'AuthController@logout')->name('logout');

Route::get('/', 'HomeController@index')->name('home');


Route::group(['namespace' => 'Product'], function () {
    Route::get('/products','ProductController@index')->name('products.index');
    Route::get('/products/{id}','ProductController@show')->name('products.show');
    Route::post('/search','ProductController@search')->name('products.search');
});

Route::group(['namespace' => 'Attribute'], function () {
    Route::get('/attribute/{type}', 'AttributeController@index')->name('attribute.index');
    Route::get('/attribute{id}', 'AttributeController@show')->name('attribute.show');
});






