<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Stub;
use App\Stubattr;
use App\Template;
use App\Bab;

class TimeController extends Controller
{
    public function index(){
    	$stubattrs = Stubattr::all();
        $babs = Bab::all();
        $tahun = 2016;
    	return view('time', compact('babs', 'stubattrs', 'tahun'));
    }
}
