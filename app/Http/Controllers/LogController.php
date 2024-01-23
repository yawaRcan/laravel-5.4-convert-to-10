<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;

class LogController extends Controller
{
    public function index() {
    	$activities = Log::orderBy('created_at','desc')->paginate(100);
    	return view('logs.index', ['logs'=>$activities]);
    }
}