<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Levels;
use App\Template;
use App\Dda;
use App\master_kecs;
use App\master_kabs;
use App\master_provs;
use App\dda_temp;
use Input;
use Validator;
use Redirect;
use Session;
use Auth;
use File;
use Blade;

class DDAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $directory = 'published';
        $files = File::allFiles($directory);
        return view('dda', compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $level = Auth::user()->id_level;
        $kd = Auth::user()->kode_daerah;
        $lvl = Levels::where('id', '=', $level)->first()->keterangan;
        if($level == 1){
            $daerah = master_provs::where('kode_prov', '=', $kd)->first()->nama_prov;
        } else if ($level == 2 || $level == 3){
            $daerah = master_kabs::where('id', '=', $kd)->first()->nama_kabkot;
        } else {
            $daerah = master_kecs::where('id', '=', $kd)->first()->nama_kec;
        }
        $templates = Template::all();
        $tahun = $dda->tahun;
        $provinsis = master_provs::all();
        $levels = Levels::all();
        return view('dda/dda-create', compact('lvl', 'daerah', 'templates', 'tahun', 'provinsis', 'levels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $current_year = date('Y');
            $validator = Validator::make($request->all(), [
                'tahun' => 'required|min:$current_year',
                'tingkat' => 'required'
            ]);
            if($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            } else {
                // $id = Auth::user()->id;
                $level = $request->get('tingkat');
                // $level = Auth::user()->id_level;
                // $daerah = Auth::user()->kode_daerah;
                $id = Auth::user()->kode_daerah;

                if($level == 1){
                    $daerah = $request->get('select_prov');    
                } else if ($level == 2 || $level == 3){
                    $daerah = $request->get('select_kab');    
                } else {
                    $daerah = $request->get('select_kec');    
                }
                $y = $request->get('tahun');
                $dda = new Dda();
                $dda->id = $y.$daerah;
                $dda->level = $level;
                $dda->tahun = $y;
                $dda->kode_daerah = $daerah;
                $dda->status = '0';
                $dda->user_id = $id;
                $dda->save();
                // dd(Input::all());

                $isi = explode(',', $request->get('selected_templates'));
                foreach ($isi as $key => $value) {
                    $dt = new dda_temp();
                    $dt->ddaname = $y.$daerah;
                    $dt->temp_id = $value;
                    $dt->position = $key;
                    $dt->save();
                }
                return Redirect::back()->with('success', 'New DDA Created Successfully'); 
            }
        } catch (Illuminate\Database\QueryException $e) {
            dd($e);

        } catch (PDOException $e) {
            dd($e);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dda = Dda::where('id', '=', $id)->first();
        $kd = $dda->kode_daerah;
        $level = Auth::user()->id_level;
        $lvl = Levels::where('id', '=', $level)->first()->keterangan;
        if($level == 1){
            $daerah = master_provs::where('kode_prov', '=', $kd)->first()->nama_prov;
        } else if ($level == 2 || $level == 3){
            $daerah = master_kabs::where('id', '=', $kd)->first()->nama_kabkot;
        } else {
            $daerah = master_kecs::where('id', '=', $kd)->first()->nama_kec;
        }
        $arr_temp = array();
        $dt = dda_temp::where('ddaname', '=', $id)->get();
        foreach($dt as $d){
            array_push($arr_temp, $d->temp_id);
            $temp = Template::where('id', $d->temp_id)->first();
        }
        $templates = Template::whereIn('id', $arr_temp)->get();
        // dd($templates);
        // $templates = Template::all();
        $tahun = $dda->tahun;
        return view('dda/dda-show', compact('dda', 'daerah', 'templates', 'lvl', 'tahun', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $templates = Template::all();
        $dda = Dda::where('id','=', $id)->first();
        $level = Auth::user()->id_level;
        $lvl = Levels::where('id', '=', $level)->first()->keterangan;
        $kd = $dda->kode_daerah;
        if($level == 1){
            $daerah = master_provs::where('kode_prov', '=', $kd)->first()->nama_prov;
        } else if ($level == 2 || $level == 3){
            $daerah = master_kabs::where('id', '=', $kd)->first()->nama_kabkot;
        } else {
            $daerah = master_kecs::where('id', '=', $kd)->first()->nama_kec;
        }
        return view('dda/dda-edit', compact('dda', 'daerah', 'templates', 'lvl'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $isi = explode(',', $request->get('selected_templates'));
        // foreach ($isi as $key => $value) {
        //     $dt = new dda_temp();
        //     $dt->ddaname = $y.$daerah;
        //     $dt->temp_id = $value;
        //     $dt->position = $key;
        //     $dt->save();
        // }
        dda_temp::where('ddaname', $id)->delete();
        foreach ($isi as $key => $value) {
            $dt = new dda_temp();
            $dt->ddaname = $id;
            $dt->temp_id = $value;
            $dt->position = $key;
            $dt->save();
        }
        // Dda::where('id', $id)->update([
        //     'isi' => $request->get('selected_templates')
        // ]);
        return Redirect::to('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete
        Dda::where('id',$id)->delete();
        
        // redirect
        Session::flash('message','Successfully deleted');
        return Redirect::to('home');
    }
}
