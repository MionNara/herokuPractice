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
Route::get('/', function () {
 return view('welcome');
});
    /*
    グループ化することで、何度もadmin/news...,admin/Profile...と書かなくてすむ
    何か変更があった時も、最初のprefixの部分だけ変更すればOK
    */
    
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('news/create','Admin\NewsController@add')->middleware('auth');
    //PHP13追記
    Route::post('news/create','Admin\NewsController@create')->middleware('auth');
    Route::get('news','Admin\NewsController@index')->middleware('auth');
    Route::get('news/edit', 'Admin\NewsController@edit')->middleware('auth');//PHP16追記
    Route::post('news/edit', 'Admin\NewsController@update')->middleware('auth');//PHP16追記
    Route::get('news/delete', 'Admin\NewsController@delete')->middleware('auth');
    Route::post('profile/create', 'Admin\ProfileController@create');
    //Route::post('profile/edit' , 'Admin\ProfileController@update');
    Route::get('profile/create','Admin\ProfileController@add')->middleware('auth');
    Route::get('profile/edit','Admin\ProfileController@edit')->middleware('auth');
});
    
    
/*http://XXXXXX.jp/XXX というアクセスが来たときに、 
AAAControllerのbbbというAction に渡すRoutingの設定    
*/
    Route::get('XXX','AAAController@bbb');

//下記を追記したらエラー解消    
Auth::routes();

//↓勝手に追加されていた　
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

