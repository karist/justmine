<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;
use Image;
use Input;
use Validator;
use Redirect;

class UserController extends Controller
{
    public function profile(){
    	return view('auth/profile', array('user' => Auth::user() ));
    }

    public function update_avatar(Request $request){
    	if($request->hasFile('avatar')){
                $avatar = $request->file('avatar');
                $filename = time().'.'.$avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(300,300)->save(public_path('/avatar/' . $filename));
                $user = Auth::user();
                $user->avatar = $filename;
                $user->save();
            }
        return view('auth/profile', array('user' => Auth::user() ));
    }

    public function update_password(Request $request){
        $validator = Validator::make($request->all(), [
            'sandi' => 'required',
            'konfirmasi_sandi' => 'required'
        ]);
        if($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            try{
                User::where('id', Auth::user()->id)->update([
                    'password' => bcrypt($request->get('sandi'))
                ]);
                return Redirect::back()->with('success', 'Berhasil mengganti kata sandi'); 
            } catch (\Illuminate\Database\QueryException $e) {
                return Redirect::back()->withErrors('Harap gunakan nama yang unik');
            }catch (PDOException $e) {
                return Redirect::back()->withErrors('Kesalahan pada basis data');
            } 
        }
    }

    public function getHelp(){
        return view ('help');
    }
}
