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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('book/search', 'BookController@search');
Route::post('note/search', 'NoteController@search');

Route::resource('book', 'BookController',[
    'except' => ['edit', 'create']
]);

Route::resource('note', 'NoteController',[
    'except' => ['edit', 'create']
]);

Route::post('upvote', 'NoteController@upvote');
Route::post('downvote', 'NoteController@downvote');

Route::post('buy', 'BookController@buy');

Route::post('request', 'BookController@request');

Route::post('update/token', 'UserController@updateToken');

Route::post('user', 'AuthController@store');
Route::post('user/login', 'AuthController@login');