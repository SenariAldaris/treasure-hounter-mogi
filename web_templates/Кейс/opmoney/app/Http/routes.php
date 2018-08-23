<?php

get('/', ['as' => 'index', 'uses' => 'PagesController@index']);
get('/login', 'LoginController@vklogin');
get('/cases/{id}', 'PagesController@cases');
get('/profile/{id}', 'PagesController@profile');
get('/faq', 'PagesController@faq');
get('/guarantee', 'PagesController@guarantee');
get('/reviews', 'PagesController@reviews');
get('/terms', 'PagesController@terms');
post('/payment/accept', 'PagesController@acceptkassa');
get('/success', 'PagesController@success');
get('/api/addbonus', ['as' => 'inventory', 'uses' => 'BonusController@addbonus']);
Route::group(['middleware' => 'auth'], function () {
    get('/logout', 'LoginController@logout');
    get('/account', 'PagesController@account');
    get('/support', 'PagesController@support');
    post('/opencase/{id}/{chance}', 'PagesController@opencase');
    post('/refuse', 'PagesController@refuse');
    post('/vivod/{price}/{koshelek}', 'PagesController@vivod');
});

Route::group(['middleware' => 'admin', 'middleware' => 'access:admin', 'prefix' => 'admin'], function () {
    get('/', 'AdminController@index');
    get('/addCase', 'AdminController@addCase');
    post('/addCase', 'AdminController@addCasePost');
    get('/addItem', 'AdminController@addItem');
    post('/addItem', 'AdminController@addItemPost');
    get('/lastvvod', 'AdminController@lastvvod');
    get('/lastvivod', 'AdminController@vivod');
    get('/vivodclose/{id}', 'AdminController@close');
});


Route::group(['prefix' => 'api'], function () {
    post('/stats', 'PagesController@stats');
    post('/last_drop', 'PagesController@last_drop');
    post('/last_drop_get', 'PagesController@last_gift_get');
});
