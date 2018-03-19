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

        Route::get('/category/{type}', [
                                'as' => 'category',
                                'uses' => 'HomeController@getCate'
                                ]);

        Route::get('/product/{id}', [
                                'as' => 'product',
                                'uses' => 'HomeController@getProd'
                                ]);

        Route::get('/buyproduct/{id}', [
                                'as' => 'buyproduct',
                                'uses' => 'HomeController@getBuyProd'
                                ]);

        Route::get('/cart', [
                                'as' => 'cart',
                                'uses' => 'HomeController@getCart'
                                ]);

        Route::post('/check-review', ['uses' => 'HomeController@checkReview']);
        Route::post('/review', ['uses' => 'HomeController@sendReview']);
        Route::post('/get-review/{id}', [
            'uses' => 'HomeController@getReview',
            'as' => 'get-review',
        ]);
        Route::put('/edit-review', [
            'uses' => 'HomeController@editReview',
            'as' => 'edit-review',
        ]);
        Route::delete('/delete-review/{id}', [
            'uses' => 'HomeController@deleteReview',
            'as' => 'delete-review',
        ]);

        Route::post('/load-data','HomeController@loadReviewAjax');
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
