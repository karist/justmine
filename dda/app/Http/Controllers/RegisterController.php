<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use Redirect;
use Input;
use App\User;
use App\Levels;
use App\master_provs;
use DB;

class RegisterController extends Controller
{

    public function index()
    {   
        $count = User::count();
        $levels = Levels::all();
        $provinsis = master_provs::all();
        return view('auth/register', compact('levels', 'provinsis', 'count'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'surel' => 'required',
            'sandi' => 'required',
            'konfirmasi_sandi' => 'required',
            'tingkat' => 'required'
        ]);
        if($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            try{
                $level = $request->get('tingkat');
                if($level == 1){
                    $daerah = $request->get('select_prov');    
                } else if ($level == 2 || $level == 3){
                    $daerah = $request->get('select_kab');    
                } else {
                    $daerah = $request->get('select_kec');    
                }
                $user = new User();
                $user->name = $request->get('nama');
                $user->email = $request->get('surel');
                $user->password = bcrypt($request->get('sandi'));
                $user->id_level = $level;
                $user->kode_daerah = $daerah;
                $user->avatar = 'images.png';
                $user->isAdmin = '0';
                $user->save();
                return Redirect::back()->with('success', 'Berhasil menambahkan pengguna baru'); 
            } catch (\Illuminate\Database\QueryException $e) {
                return Redirect::back()->withErrors('Harap gunakan nama yang unik');
            }catch (PDOException $e) {
                return Redirect::back()->withErrors('Kesalahan pada basis data');
            } 
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'surel' => 'required',
            'sandi' => 'required',
            'konfirmasi_sandi' => 'required',
            'tingkat' => 'required',
            'admin' => 'required'
        ]);
        if($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            try{
                $level = $request->get('tingkat');
                if($level == 1){
                    $daerah = $request->get('select_prov');    
                } else if ($level == 2 || $level == 3){
                    $daerah = $request->get('select_kab');    
                } else {
                    $daerah = $request->get('select_kec');    
                }
                $user = User::where('id',$id)->first();
                $user->name = $request->get('nama');
                $user->email = $request->get('surel');
                $user->password = bcrypt($request->get('sandi'));
                $user->id_level = $level;
                $user->kode_daerah = $daerah;
                $user->isAdmin = $request->get('admin');
                $user->save();
                return Redirect::back()->with('success', 'Berhasil menambahkan pengguna baru'); 
            } catch (\Illuminate\Database\QueryException $e) {
                return Redirect::back()->withErrors('Harap gunakan nama yang unik');
            }catch (PDOException $e) {
                return Redirect::back()->withErrors('Kesalahan pada basis data');
            } 
        }
    }
}
