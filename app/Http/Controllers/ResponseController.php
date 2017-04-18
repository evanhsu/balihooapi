<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ResponseController extends Controller
{
    protected $answers = [
    	'ping'			=> 'OK',
    	'phone'			=> '541-728-3826',
    	'resume'		=> 'www.smirksoftware.com/resume.pdf',
    	'puzzle'		=> " ABCD\nA=>>>\nB<=<<\nC<>=>\nD<><=",
    	'email address'		=> 'evanhsu@gmail.com',
    	'degree'		=> 'BSEE - University of Michigan College of Engineering',
    	'source'		=> 'https://github.com/evanhsu/balihooapi',
    	'name'			=> 'Evan Hsu',
    	'referrer'		=> 'whoishiring.io',
    	'position'		=> 'Software Engineer',
    	'years'			=> 'Since 2003',
    	'status'		=> 'Yes',
    ];


    public function index(Request $request)
    {
    	$this->logRequest($request);

    	$q = strtolower(urldecode($request->get('q')));
    	$d = strtolower(urldecode($request->get('d')));

    	return response($this->answers[$q], 200);
    }


    public function logRequest($request)
    {
    	Log::info($request->fullUrl());
    }
}
