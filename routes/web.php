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

Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes

    Route::get('/chats', 'ChatController@index');

    Route::get('/chat/{chat}', 'ChatController@show');

    Route::post('/chat/{chat}/message', 'ChatMessageController@create');

    Route::get('/chat/{chat}/print', 'PrintChatController@index');

    Route::get('/chat/{chat}/pdf', 'DownloadChatAsPDFController@index');

    Route::get('/statistics', 'MonthlyStatisticController@show');

});

// Push Subscriptions
Route::post('subscriptions', 'PushSubscriptionController@update');
Route::post('subscriptions/delete', 'PushSubscriptionController@destroy');