<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Dda;
use App\Template;
use DB;
use Response;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id='201631';
        $table = '39';
        $dda = Dda::where('id', '=', $id)->first();
        // $isi = explode(',', $dda->isi);
        // $arr = array();
        // foreach($isi as $i){
        //     $t = Template::where('id', '=', $i)->first();
        //     $e = json_decode($t->tabtemplate, true);
        //     $kol = $e['table']['column'];
        //     $stub = $e['table']['stubname'][0];
        //     $results = DB::table($stub)
        //         ->where('ddaname', '=', $id)
        //         ->get();
        //     array_push($arr, $results);
        // }

          $t = Template::where('id', '=', $table)->first();
          $e = json_decode($t->tabtemplate, true);
          $stub = $e['table']['stubname'][0];
          $kol = $e['table']['column'];
          // $nama_kolom = array();
          // foreach($kol as $k){
          //   array_push($nama_kolom, '`'.$table.$k . '` as `' . $k .'`');
          // }
          // echo implode(',', $nama_kolom);
          $nama_kolom = array_merge(array($stub),explode(',',$table.implode(','.$table, $kol)));
          $arr = DB::table($stub)
              ->select($nama_kolom)
              ->where('ddaname', '=', $id)
              ->get();

            for($k=0;$k<count($kol);$k++){
                $key_replace = $kol[$k];
                $key_find = $nama_kolom[$k+1];
                for($l=0;$l<count($arr);$l++){    
                    $arr[$l]->$key_replace = $arr[$l]->$key_find;
                    // echo 'replace '.$key_find.' with '.$key_replace;
                    unset($arr[$l]->key_replace);
                }
            }
            dd($arr);
          // foreach ($kol as $key => $value) {
          //     echo (str_replace($kol[$key],$nama_kolom[$key+1],$arr));
          // }
    //            $obj = new \stdclass();
    // $fi = 'a';
    // $obj->$fi = 10;  // will be renamed
    // $rep = 'b';
    
    // $obj->$rep = $obj->$fi; // rename "a" to "b", somehow!
    // unset($obj->a); // remove the original one
    //           dd($obj);
        // return Response::json(json_encode($arr));
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
    public function store(Request $request)
    {
        //
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
