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

// Route::get('/', function () {
//     return view('layout.app');
// });

Route::get('/{any}', 'SpaController@index')->where('any', '.*');
// Auth::routes();

Route::get('/cache-clear', function() {
    $exitCode = Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::get('/db-migrate', function() {
    $exitCode = Artisan::call('migrate');
    return "migrate";
});

Route::get('/db-seed', function() {
    $exitCode = Artisan::call('db:seed');
    return "db seeding";
});

Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return "View is cleared";
});