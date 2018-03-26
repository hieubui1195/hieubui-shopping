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
Route::group(['middleware' => 'locale'], function() {
    
    Route::get('change-language/{language}', 'HomeController@changeLanguage')->name('change-language');

    Auth::routes();
    
    Route::group(['namespace' => 'User'], function() {

        Route::get('/', [
            'as' => 'home',
            'uses' => 'HomeController@getHome'
        ]);

        Route::get('/search', [
            'as' => 'search',
            'uses' => 'HomeController@getSearch'
        ]);

        Route::get('/category/{type}', [
            'as' => 'category',
            'uses' => 'HomeController@getCategory'
        ]);

        Route::get('/buyproduct/{id}', [
            'as' => 'buyproduct',
            'uses' => 'HomeController@getBuyProduct'
        ]);

        Route::get('/latestproduct', [
            'as' => 'latestproduct',
            'uses' => 'HomeController@getLatestProduct'
        ]);

        Route::get('/promotionproduct', [
            'as' => 'promotionproduct',
            'uses' => 'HomeController@getPromotionProduct'
        ]);

        Route::get('/product/{id}', [
            'as' => 'product',
            'uses' => 'HomeController@getProd'
        ]);

        Route::post('/cart', 'CartController@cart');
        Route::post('/remove-item', 'CartController@removeItem');
        Route::post('/update-cart', 'CartController@updateCart');
        Route::get('/checkout', [
            'uses' => 'CartController@getCheckout',
            'as' => 'checkout',
        ]);
        Route::post('/checkout', 'CartController@checkout');
        Route::post('/extract-pdf', 'CartController@extractPdf')->name('extract-pdf');
        Route::get('/pdfview',array('as'=>'pdfview','uses'=>'CartController@pdfview'));

        Route::post('/check-qty', 'HomeController@checkQty');

        Route::post('/check-review', ['uses' => 'HomeController@checkReview']);
        Route::post('/review', ['uses' => 'HomeController@sendReview']);
        Route::post('/get-review/{id}', [
            'uses' => 'HomeController@getReview',
            'as' => 'get-review',
        ]);
        Route::post('/edit-review', [
            'uses' => 'HomeController@editReview',
            'as' => 'edit-review',
        ]);
        Route::delete('/delete-review/{id}', [
            'uses' => 'HomeController@deleteReview',
            'as' => 'delete-review',
        ]);

        Route::post('/load-data','HomeController@loadReviewAjax');

        Route::get('/information/{id}', [
            'as' => 'information',
            'uses' => 'HomeController@getInformation'
        ]);

        Route::put('/user-update/{id}', [
            'as' => 'userupdate',
            'uses' => 'HomeController@getUserUpdate'
        ]);

    });

    Route::group(['prefix'=>'admin', 'as'=>'admin.', 'namespace' => 'Admin'], function() {
        
        Route::get('login', 'AdminLoginController@getLogin')->name('getLogin');
        Route::post('login', 'AdminLoginController@postLogin')->name('postLogin');
        Route::post('logout', 'AdminLoginController@getLogout')->name('getLogout');

        Route::group(['middleware' => 'CheckAdminLogin'], function() {

            Route::get('/', 'HomeController@index')->name('home');
            
            Route::resource('category', 'CategoryController', ['except' => ['show']]);

            Route::resource('product', 'ProductController');
            Route::post('reuse-product', 'ProductController@reuse')->name('product.reuse');

            Route::resource('order', 'OrderController', ['only' => ['index', 'show', 'destroy']]);
            Route::post('approve-order', 'OrderController@approveOrder');
            Route::post('reject-item', 'OrderController@rejectItem');

            Route::resource('promotion', 'PromotionController');
            Route::post('reject-promotion-item', 'PromotionController@rejectItem');

            Route::resource('user', 'UserController', ['except' => ['edit']]);

        });
    });
});
