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

    Route::group(['prefix' => 'products', 'namespace' => 'Product'], function () {
        Route::get('/','ProductController@store')->name('products.show');
    });

    //
    // this auth routes
    //

    Route::group(['middleware' => 'jwt.refresh'], function(){
        Route::post('authrefresh', 'AuthController@getAuthenticatedUser');

    });

    Route::group(['middleware' => 'jwt.auth'], function(){

        Route::group(['prefix' => 'products', 'namespace' => 'Product', 'middleware' => 'jwt.auth'], function () {
            
            Route::post('/','ProductController@store')->name('products.store');
            Route::delete('/{id}','ProductController@destroy')->name('products.delete');
            Route::put('/','ProductController@update')->name('products.update');

            Route::group(['prefix' => 'product-attribute'], function () {
                
                Route::get('/', 'AttributeController@index')->name('attribute.index');
                Route::get('/{id}', 'AttributeController@show')->name('attribute.show');
                Route::post('/', 'AttributeController@store')->name('attribute.store');
                Route::delete('/{id}', 'AttributeController@destroy')->name('attribute.destroy');
                Route::put('/', 'AttributeController@update')->name('attribute.update');

            });

            Route::group(['prefix' => 'product-option'], function () {
                
                Route::get('/', 'OptionController@index')->name('option.index');
                Route::get('/{id}', 'OptionController@show')->name('option.show');
                Route::post('/', 'OptionController@store')->name('option.store');
                Route::delete('/{id}', 'OptionController@destroy')->name('option.destroy');
                Route::put('/', 'OptionController@update')->name('option.update');

            });

        });

        Route::group(['prefix' => 'cabinet', 'namespace' => 'Cabinet'], function () {
            
            Route::group(['prefix' => 'payment', 'namespace' => 'Payment'], function () {
                Route::get('/','PaymentController@index')->name('payment.show');  
            });

        });


    });
    
});






