<?php

get('/', ['as' => 'index', 'uses' => 'PagesController@index']);
get('/login', 'LoginController@vklogin');
get('/cases/{id}', 'PagesController@cases');
get('/gifts/{id}', 'PagesController@gifts');
get('/ticket/{id}', 'BonusController@ticket');
get('/profile/{id}', 'PagesController@profile');
get('/faq', 'PagesController@faq');
get('/guarantee', 'PagesController@guarantee');
get('/reviews', 'PagesController@reviews');
get('/terms', 'PagesController@terms');
post('/payment/accept', 'PagesController@acceptkassa');
get('/success', 'PagesController@success');
get('/contests', 'PagesController@konkurs');
get('/konkurs', 'PagesController@konkurs');
post('/getContestants', 'BonusController@getContestants');

get('/bonus', 'BonusController@bonus');
get('/contest', 'BonusController@contests');
post('/pay', 'PagesController@pay');
post('/getPayment', 'PagesController@getPayment');
post('/join', 'BonusController@hour_join');
post('/hour', 'BonusController@hour');
get('/api/addbonus', ['as' => 'inventory', 'uses' => 'BonusController@addbonus']);
post('/opencase/{id}/{chance}', 'PagesController@opencase');
post('/api/setplace', 'BonusController@setplace');
Route::group(['middleware' => 'auth'], function () {
    get('/logout', 'LoginController@logout');
    get('/account', 'PagesController@account');
    get('/support', 'PagesController@support');
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
    get('/vivodgifts', 'AdminController@vivodgifts');
    get('/users', 'AdminController@users');
    get('/cases', 'AdminController@cases');
    get('/tickets', 'AdminController@tickets');
    get('/cases/{id}', ['as' => 'cases', 'uses' => 'AdminController@caseid']);
    get('/ticket/{id}', ['as' => 'ticket', 'uses' => 'AdminController@ticket']);
    post('/ticketsave', ['as' => 'ticket', 'uses' => 'AdminController@ticketsave']);
    post('/casedit', ['as' => 'case', 'uses' => 'AdminController@casedit']);
    get('/searchusers', ['as' => 'search', 'uses' => 'AdminController@search2']);
    get('/searchusersname', ['as' => 'search', 'uses' => 'AdminController@searchusersname']);
    get('/user/{id}', ['as' => 'users', 'uses' => 'AdminController@userid']);
    post('/userdit', ['as' => 'user', 'uses' => 'AdminController@userdit']);
  Route::match(['get', 'post'], '/givemoney/{id}', ['as' => 'givemoney', 'uses' => 'AdminController@givemoney']);
    get('/vivodclose/{id}', 'AdminController@close');
    get('/vivodclosegift/{id}', 'AdminController@closegift');
});


Route::group(['prefix' => 'api'], function () {
    post('/stats', 'PagesController@stats');
    post('/last_drop', 'PagesController@last_drop');
    post('/last_drop_get', 'PagesController@last_gift_get');
    post('/sell', 'PagesController@sell');
    post('/send', 'PagesController@send');
});
