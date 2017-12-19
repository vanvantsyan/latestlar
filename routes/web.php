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

Auth::routes();

Route::get('logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'auth'], function() {
    Route::group(['middleware' => 'isAdmin', 'prefix' => 'admin'], function() {

        Route::resource('visa', 'Admin\VisaController');

        Route::post('upload-images', 'ImageController@uploadImages');

        Route::resource('services', 'Admin\ServicesController');

        Route::get('blog/upload-images', 'Admin\BlogController@uploadImages');
        Route::get('blog/categories/{id}/delete', 'Admin\BlogController@deleteCategory');
        Route::post('blog/categories/{id}/update', 'Admin\BlogController@updateCategory');
        Route::get('blog/categories/{id}/edit', 'Admin\BlogController@editCategory');
        Route::post('blog/categories', 'Admin\BlogController@saveCategory');
        Route::resource('blog', 'Admin\BlogController');

        Route::get('news/category-delete', 'Admin\NewsController@deleteCategory');
        Route::post('news/category-update', 'Admin\NewsController@updateCategory');
        Route::get('news/categories/{id}/edit', 'Admin\NewsController@editCategory');
        Route::post('news/categories', 'Admin\NewsController@saveCategory');
        Route::resource('news', 'Admin\NewsController');

        Route::post('menu/item-delete', 'Admin\MenuController@deleteItem');
        Route::post('menu/update-item', 'Admin\MenuController@updateItem');
        Route::post('menu/save-item', 'Admin\MenuController@saveItem');
        Route::resource('menu', 'Admin\MenuController');

        Route::resource('pages', 'Admin\PagesController');
        Route::get('geo/city/{id}/delete', 'Admin\GeoController@deleteCity');
        Route::post('geo/city/{id}', 'Admin\GeoController@updateCity');
        Route::get('geo/city/{id}', 'Admin\GeoController@showCity');
        Route::resource('geo', 'Admin\GeoController');
        Route::resource('users', 'Admin\UsersController');
        Route::resource('roles', 'Admin\RolesController');
        Route::resource('permissions', 'Admin\PermissionsController');
        Route::resource('/', 'Admin\AdminController');

        Route::resource('tours', 'Admin\ToursController');
    });
});

