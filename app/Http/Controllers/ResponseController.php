<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ResponseController extends Controller
{
    //
    public function index(Request $request)
    {
    	Log::info("=============================");
    	Log::info(var_export($request, true));
    	return response('message received', 200);
    }
}
