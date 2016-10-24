<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Dda;
use App\Baku;
use App\User;
use App\Bab;
use App\Subbab;
use App\Levels;
use App\master_provs;
use App\master_kabs;
use App\master_kecs;
use App\master_desas;
use App\Stubattr;
use Input;
use Validator;
use Redirect;
use App\Template;
use App\TabTemplate;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = User::count();
        return view('admin/admin', compact('count'));
    }

    public function showDDA()
    {
        $ddas = Dda::where('status','=',1)->get();
        $count = User::count();
        return view('admin/dda', compact('ddas', 'count'));
    }

    public function showUser()
    {
        $users = User::all();
        $count = User::count();
        return view('admin/users', compact('users', 'count'));
    }

    public function editUser($id)
    {
        $user = User::where('id',$id)->first();
        $levels = Levels::all();
        $count = User::count();
        $provinsis = master_provs::all();
        return view('auth/profile-edit', compact('user', 'count', 'levels', 'provinsis'));
    }

    public function showDaerah()
    {
        $count = User::count();
        $provinsis = master_provs::all();
        $kabs = master_kabs::all();
        $kecs = master_kecs::all();
        return view('admin/daerah', compact('count', 'provinsis', 'kabs', 'kecs'));
    }

    public function addDaerah(Request $request){
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'kode' => 'required',
            'tingkat' => 'required'
        ]);
        if($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            try{
                $tingkat = $request->get('tingkat');
                $kode = $request->get('kode');
                if($tingkat === '1'){
                    $daerah = new master_provs();
                    $daerah->kode_prov = $kode;
                    $daerah->nama_prov = $request->get('nama');
                } else if($tingkat === '2'){
                    $daerah = new master_kabs();
                    $daerah->id = $kode;
                    $daerah->id_kabkot = substr($kode,-1,2);
                    $daerah->prov = substr($kode,0,2);
                    $daerah->nama_kabkot = $request->get('nama');
                } else if($tingkat === '3'){
                    $daerah = new master_kecs();
                    $daerah->id = $kode;
                    $daerah->id_kec = substr($kode,-1,3);
                    $daerah->prov = substr($kode,0,2);
                    $daerah->kabkot = substr($kode,2,2);
                    $daerah->nama_kec = $request->get('nama');
                } else if($tingkat === '4'){
                    $daerah = new master_desas();
                    $daerah->id = $kode;
                    $daerah->id_kel = substr($kode,-1,3);
                    $daerah->nama_kel = $request->get('nama');
                    $daerah->prov = substr($kode, 0, 2);
                    $daerah->kabkot = substr($kode,2,2);
                    $daerah->kecamatan = substr($kode, -1, 3);
                }
                $daerah->save();
                return Redirect::back()->with('success', 'Berhasil menambahkan daerah baru'); 
            } catch (\Illuminate\Database\QueryException $e) {
                return Redirect::back()->withErrors($e);
            }catch (PDOException $e) {
                return Redirect::back()->withErrors('Kesalahan pada basis data');
            } 
        }
    }

    public function createTemplates(){
        $bakus = Baku::paginate(10);
        $count = User::count();
        $babs = Bab::all();
        $stubs = Stubattr::all();
        return view('admin/template-create', compact('bakus','count', 'babs', 'stubs'));
    }

    public function showTemplates(){
        $count = User::count();
        $templates = TabTemplate::paginate(10);
        return view('admin/template',compact('count','templates'));
    }

    public function storeTemplates(Request $request){
        try{
            $new = new TabTemplate;
            $new->baku = $request->get('baku');
            $new->kolom = json_encode($request->get('kolom'));
            $new->judul = $request->get('judul_id');
            $new->title = $request->get('judul_en');
            $new->sumber = $request->get('sumber_id');
            $new->source = $request->get('sumber_en');
            $new->subbab = $request->get('subbab');
            $new->stubname = $request->get('judul_stub');
            $new->save();
            return Redirect::back()->with('success', 'Berhasil'); 
        } catch(Exception $e) {
            return Redirect::back()->withErrors($e->getMessage());
        }
    }
}
