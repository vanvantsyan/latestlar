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
Route::get('/', 'Front\ToursController@countryMain');

Auth::routes();

Route::get('logout', 'Auth\LoginController@logout');

View::composer(
    'front.tours.modules.hotWays', function ($view) {
    $view->with('hotWays', App\Models\Ways::hotWays());
}
);

View::composer(
    'front.modules.infoCompany', function ($view) {
    $view->with('news', App\Models\News::take(6)->get());
}
);
View::composer(
    'front.modules.subscription', function ($view) {
    $view->with('countries', App\Models\Ways::where('status', 'country')->get());
}
);
View::composer(
    'front.tours.modules.popularTypes', function ($view) {
    $view->with('tourCategories', App\Models\ToursTagsValues::whereIn('id', [19, 25, 30, 24])->where('tag_id', 4)->get());
}
);
View::composer(
    'front.tours.modules.articles', function ($view) {
    $view->with('articles', App\Models\Articles::take(3)->orderBy('id', 'DESC')->get());
}
);
View::composer(
    'front.tours.modal.types', function ($view) {
    $view->with('types', App\Models\ToursTagsValues::where('tag_id', 4)->get());
}
);
View::composer(
    'front.tours.modal.cities', function ($view) {
    $view->with('cities', App\Models\Points::popular());
}
);
View::composer(
    'front.tours.modal.goldens', function ($view) {
    $view->with('cities', App\Models\Points::goldens());
}
);
View::composer(
    'front.tours.modal.countries', function ($view) {
    $view->with('countries', App\Models\Geo::all());
}
);

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'isAdmin', 'prefix' => 'admin'], function () {

        Route::resource('visa', 'Admin\VisaController');

        Route::post('upload-images', 'ImageController@uploadImages')->name('image.upload');

        Route::post('saveFor', 'ImageController@saveFor')->name('image.save.for');
        Route::post('removeImage', 'ImageController@removeImage')->name('image.remove');
        Route::post('get-images', 'ImageController@getImages')->name('image.get');

        //Route::resource('services', 'Admin\ServicesController');

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

        Route::post('geo/setImage', 'Admin\GeoController@setImage')->name('geo.set.image');
        Route::post('geo/removeImage', 'Admin\GeoController@removeImage')->name('geo.remove.image');

        Route::post('geo/setFlag', 'Admin\GeoController@setFlag')->name('geo.set.flag');
        Route::post('geo/uploadFlag', 'Admin\GeoController@uploadFlag')->name('geo.upload.flag');
        Route::post('geo/removeFlag', 'Admin\GeoController@setFlag')->name('geo.remove.flag');

        Route::post('geo/setBanner', 'Admin\GeoController@setBanner')->name('geo.set.banner');
        Route::post('geo/uploadBanner', 'Admin\GeoController@uploadBanner')->name('geo.upload.banner');
        Route::post('geo/removeBanner', 'Admin\GeoController@setBanner')->name('geo.remove.banner');


        
        Route::resource('geo', 'Admin\GeoController');
        Route::resource('users', 'Admin\UsersController');
        Route::resource('roles', 'Admin\RolesController');
        Route::resource('permissions', 'Admin\PermissionsController');
        Route::resource('/', 'Admin\AdminController');

        Route::get('tours/{id}/edit', 'Admin\ToursController@edit');
        Route::get('tours/parser', 'Admin\ToursController@parser');
        Route::resource('tours', 'Admin\ToursController');
        Route::any('tours/search', 'Admin\ToursController@search'); // Search in admin form by tour name

        Route::resource('ways', 'Admin\WaysController');
        Route::resource('types', 'Admin\TypesController');
        Route::get('types/insert/{id?}', 'Admin\TypesController@insert')->name('types.insert');
        Route::resource('articles', 'Admin\ArticlesController');

        Route::resource('seo', 'Admin\SeoController');
        Route::resource('periods', 'Admin\PeriodsController');

        /**
         * Points Routes.
         */
        Route::resource('points', 'Admin\PointsController');
        Route::post('points/search', 'Admin\PointsController@search');

        Route::get('cases', 'Admin\CaseController@list');
        Route::get('cases/{id}/edit', 'Admin\CaseController@edit');
        Route::post('cases/store', 'Admin\CaseController@store');

        Route::post('tours/dates/destroy', 'Admin\ToursController@destroyDate')->name('dates.remove');
        Route::post('tours/dates/add', 'Admin\ToursController@addDate')->name('dates.add');

        Route::post('tour/getImage', 'Admin\ToursController@getImages')->name('getTourImages');
        Route::post('tour/uploadImage', 'Admin\ToursController@uploadImage')->name('uploadTourImage');
        Route::post('tour/removeImage', 'Admin\ToursController@removeImage')->name('removeTourImage');

    });
});

//Route::get('pages', 'Front\PagesController@index');

/* Tour routes*/

/* Pages */

Route::get('/sanatorii-i-pansionatyi', 'Front\PagesController@sanatorii')->name('pages.sanatorii');

/* sletat api */

Route::get('sletat', 'Front\SletatController@index')->name('sletat');
Route::post('sletat/getTours', 'Front\SletatController@getTours')->name('sletat.tours');
Route::post('sletat/getStatus', 'Front\SletatController@getStatus')->name('sletat.status');

/* tours */

Route::get('search/autocomplete', 'Front\ToursController@autocomplete');

Route::get('{country}/{action}/{url}', 'Front\ToursController@unit')->where('url', '.+-?-\d{2,8}');
Route::get('{country}/{url}', 'Front\ToursController@unitCountry')->where('url', '.+-?-\d{2,8}');

Route::any('tury/{slug2?}/{slug3?}', 'Front\ToursController@list')->name('tour.list')->middleware('redirect-dirty-urls');
Route::get('{country}', 'Front\ToursController@countryMain')->name('countryMain')->middleware('redirect-dirty-urls');
Route::get('{country}/{slug2?}/{slug3?}', 'Front\ToursController@list')->name('tourCountry')->where('slug3','[^./]*')->where('slug2','[^./]*')->middleware('redirect-dirty-urls'); //->where('country', 'russia')

Route::post('moreTours', 'Front\ToursController@getMore')->name('moreTours');
Route::post('filterTours', 'Front\ToursController@filters')->name('filterTours');
Route::post('getCountTours', 'Front\ToursController@getCount')->name('getCountTours');

Route::post('tour/order', 'Front\MailController@sendOrder')->name('mail.order');
Route::post('tour/phone', 'Front\MailController@sendPhone')->name('mail.phone');

Route::post('tours/seo', 'Front\ToursController@getSeoTours')->name('tours.seo');

Route::post('modals/getAll', 'Front\ToursController@getModals')->name('modal.all');






