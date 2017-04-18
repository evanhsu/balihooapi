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

Route::get('/', 'ResponseController@index');
Route::get('/resume', function() {
	return response()->file('../public/resume_evan_hsu.pdf');
});

Route::get('/{anything}', 'ResponseController@index')->where('anything', '.*');
