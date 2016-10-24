<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ColumnController extends Controller
{
    public function show(){
	    return view('index');
	 }

	public function send(Request $request){
	    echo $request;
	}
}
