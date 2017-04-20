<?php

use Illuminate\Http\Request;


Route::get('/', 'ResponseController@index');
Route::get('/resume', function() {
	return response()->file('../public/resume_evan_hsu.pdf');
});

Route::get('/{anything}', 'ResponseController@index')->where('anything', '.*');
