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
    何か変更が会った時も、最初のprefixの部分だけ変更すればOK
    */
    
Route::group(['prefix' => 'admin'],function(){
    Route::get('news/create','Admin\NewsController@add');
    Route::get('profile/create','Admin\ProfileController@add');
    Route::get('profile/edit','Admin\ProfileController@edit');
});
    
    
/*http://XXXXXX.jp/XXX というアクセスが来たときに、 
AAAControllerのbbbというAction に渡すRoutingの設定    
*/
    Route::get('XXX','AAAController@bbb');



