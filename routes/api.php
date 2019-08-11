<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('register', 'Api\UserController@register'); 
Route::post('login', 'Api\UserController@login'); 




Route::middleware('auth:api')->group( function () { 
    Route::resource('groups', 'API\GroupController');
    Route::post('listgroups', 'Api\UserController@listgroup'); 
    Route::post('allgroups', 'Api\UserController@listallgroup');
    Route::resource('memberdeposits', 'Api\MemberDepositController');
    Route::post('addusergroups', 'Api\UserController@addusertogroup'); 
    
 
});