<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Dda;
use App\Template;
use Redirect;
use App\master_provs;
use App\master_kabs;
use App\master_kecs;
use Input;
use Auth;
use App\Levels;
use App\dda_temp;

class LayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
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
        $tahun = $dda->tahun;
        return view('layout', compact('dda', 'daerah', 'templates', 'lvl', 'tahun'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('allform');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Dda::where('id', $id)->update([
        //     'isi' => $request->get('selected_templates')
        // ]);
        // return Redirect::back();
        dd(Input::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
