<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Template;
use App\Dda;
use Input;
use Redirect;
use Schema;
use DB;
use App\Bab;
use App\Subbab;
use App\Narasi;
use App\dda_temp;
use App\Anades;
use Auth;

class EntryTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $dda = Dda::where('id', '=', $id)->first();
        // $isi = explode(',', $dda->isi);
        // $babs = Bab::all();
        $arr_babs = array();
        // $subbabs = Subbab::all();
        $arr_sub = array();
        $arr_temp = array();
        $kd = Auth::user()->kode_daerah;
        $narasis = Narasi::where('ddaname', '=', $id)->get();
        $anades = Anades::where('ddaname', '=', $id)->get();
        $tahun = $dda->tahun;
        // foreach($isi as $i){
        //     $t = Template::where('id', '=', $i)->first();    
        //     array_push($templates, $t);
        // }
        $dt = dda_temp::where('ddaname', '=', $id)->get();
        foreach($dt as $d){
            array_push($arr_temp, $d->temp_id);
            $temp = Template::where('id', $d->temp_id)->first();
            array_push($arr_babs, $temp->idbab);
            array_push($arr_sub, $temp->idsubbab);
        }
        $arr_babs = array_unique($arr_babs);
        $templates = Template::whereIn('id', $arr_temp)->get();
        $babs = DB::table('babs') ->whereIn('id', $arr_babs)->get();
        $subbabs = DB::table('subbabs')->whereIn('id', $arr_sub)->get();
        return view('entry', compact('templates', 'id', 'babs', 'subbabs', 'narasis', 'anades', 'tahun', 'kd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        // Managing Database Table and Column
        $tab_id = $request->get('table_id');
        $column = explode(',', $request->get('table_column'));
        $joined_column = empty($column)?"":"`".implode('`, `', $column)."`";
        $data = html_entity_decode($request->get('table_data')); // json_encode to change make it into string json
        $stub = $request->get('table_stub');
        $ddaname = $id;
        $column2 = array_splice($column, 1, count($column));
        
        if(Schema::hasTable($stub)){
            foreach($column2 as $col){
                if(Schema::hasColumn($stub, $tab_id.$col)){
                } else {
                    Schema::table($stub, function($table) use ($col, $tab_id){
                        $table->string($tab_id.$col);
                    });
                }
            }
        } else {
            Schema::create($stub, function($table) use($stub){
                $table->increments('id')->unique();
                $table->string('ddaname');
                $table->string($stub);
            });
            Schema::table($stub, function($table) use ($column2, $tab_id){
                foreach($column2 as $col){
                    $table->string($tab_id.$col);
                }
            });
        }

        // Saving to Database
        $json_data = json_decode($data);
        for($i = 0 ; $i < count($json_data) ; $i++){
            $jd = $json_data[$i]->$stub;
            for($j = 0 ; $j < count($column2) ; $j++){
                $key = $column2[$j];
                $data = $json_data[$i]->$key;

                $exists = DB::table($stub)->where('ddaname', '=' ,$ddaname)->where($stub, '=' ,$jd)->first();
                if($exists){
                } else {
                    DB::insert("insert into `$stub` (`id`, `ddaname`, `$stub` ) values ('','$ddaname','$jd')");    
                }
                DB::table($stub)
                    ->where('ddaname', $ddaname)
                    ->where($stub, $jd)
                    ->update([$tab_id.$key => $data]);
            }
        }
        return Redirect::back()->with('tab_success', 'Data telah disimpan'); 
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
