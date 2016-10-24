<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;

class LoginController extends Controller
{
	public function getLogin(){
		return view('auth/login');
	}   

	public function postLogin(Request $request){
		if(Auth::attempt([
			'email'	=> $request->get('surel'),
			'password' => $request->get('sandi')
		])){
			return redirect('/');
		} elseif (Auth::attempt([
			'name'	=> $request->get('surel'),
			'password' => $request->get('sandi')
		])){
			return redirect('/');
		}
	}
}
