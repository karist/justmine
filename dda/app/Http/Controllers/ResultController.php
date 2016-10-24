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
use App\Levels;
use App\master_kecs;
use App\master_kabs;
use App\master_provs;
use App\Publikasi;
use PDF;
use Carbon\Carbon;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $dda = Dda::where('id', '=', $id)->first();
        $arr_babs = array();
        $arr_sub = array();
        $arr_temp = array();
        $narasis = Narasi::where('ddaname', '=', $id)->get();
        $anades = Anades::where('ddaname', '=', $id)->get();

        $dt = dda_temp::where('ddaname', '=', $id)->get();
        foreach($dt as $d){
            array_push($arr_temp, $d->temp_id);
            $temp = Template::where('id', $d->temp_id)->first();
            array_push($arr_babs, $temp->idbab);
            array_push($arr_sub, $temp->idsubbab);
        }
        $arr_babs = array_unique($arr_babs);
        $templates = Template::whereIn('id', $arr_temp)->orderBy('idbab', 'asc')->get();
        $babs = DB::table('babs') ->whereIn('id', $arr_babs)->orderBy('nomorbab', 'asc')->get();

        $level = $dda->level;
        $kd = $dda->kode_daerah;
        if($level == 1){
            $daerah = master_provs::where('kode_prov', '=', $kd)->first()->nama_prov;
        } else if ($level == 2 || $level == 3){
            $daerah = master_kabs::where('id', '=', $kd)->first()->nama_kabkot;
        } else {
            $daerah = master_kecs::where('id', '=', $kd)->first()->nama_kec;
        }

        $subbabs = DB::table('subbabs')->whereIn('id', $arr_sub)->get();
        $lvl = Levels::where('id', '=', $level)->first()->keterangan;
        $tahun = $dda->tahun;
        // $tables = json_decode($request->get('amp;tab'));
        // dd($tables);

        view()->share([
            'templates' => $templates, 
            'id'        => $id,
            'babs'      => $babs,
            'subbabs'   => $subbabs,
            'narasis'   => $narasis,
            'anades'    => $anades,
            'daerah'    => $daerah,
            'lvl'       => $lvl,
            'tahun'     => $tahun,
            'tables'    => $tables
        ]);


        if($request->has('download')){

            // dd($request->get('amp;tab'));

            $pdf = PDF::loadView('result');
            $pdf->SetJS('<script>showTable();</script>');
            $pdf->save('pdf/'.$dda->kode_daerah.'_'.$dda->tahun.'.pdf'); 
            return $pdf->download('result');

            $pdf->Output('pdf/'.$dda->kode_daerah.'_'.$dda->tahun.'.pdf','F');
            return $pdf->stream('document.pdf');
        }
        return view('result');
    }

    public function publish(Request $request, $id)
    {
        $dda = Dda::where('id', '=', $id)->first();
        // $isi = explode(',', $dda->isi);
        // $babs = Bab::all();
        $arr_babs = array();
        // $subbabs = Subbab::all();
        $arr_sub = array();
        $arr_temp = array();
        $narasis = Narasi::where('ddaname', '=', $id)->get();
        $anades = Anades::where('ddaname', '=', $id)->get();
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
        $templates = Template::whereIn('id', $arr_temp)->orderBy('idbab', 'asc')->get();
        $babs = DB::table('babs') ->whereIn('id', $arr_babs)->orderBy('nomorbab', 'asc')->get();

        $level = $dda->level;
        $kd = $dda->kode_daerah;
        if($level == 1){
            $daerah = master_provs::where('kode_prov', '=', $kd)->first()->nama_prov;
        } else if ($level == 2 || $level == 3){
            $daerah = master_kabs::where('id', '=', $kd)->first()->nama_kabkot;
        } else {
            $daerah = master_kecs::where('id', '=', $kd)->first()->nama_kec;
        }

        $subbabs = DB::table('subbabs')->whereIn('id', $arr_sub)->get();
        $lvl = Levels::where('id', '=', $level)->first()->keterangan;
        $tahun = $dda->tahun;

        view()->share([
            'templates' => $templates, 
            'id'        => $id,
            'babs'      => $babs,
            'subbabs'   => $subbabs,
            'narasis'   => $narasis,
            'anades'    => $anades,
            'daerah'    => $daerah,
            'lvl'       => $lvl,
            'tahun'     => $tahun
        ]);

        $image = new Publikasi;
        $image->title = $id;
        $image->description = $lvl.' '.$daerah.' dalam angka '.$tahun;
        $file = 'pdf/'.$dda->kode_daerah.'_'.$dda->tahun.'.pdf';
        $timestamp = str_replace([' ',':'], '-', Carbon::now()->toDateTimeString());
        $name = $timestamp. '-' .$dda->kode_daerah.'_'.$dda->tahun.'.pdf';
        $image->filePath = $name;
        $image->save();

         $dda = Dda::where('id', '=', $id)->first()->update([
            'status' => '1',
            'lokasi' => 'pdf/'.$dda->kode_daerah.'_'.$dda->tahun.'.pdf'
        ]);

        $pdf = PDF::loadView('result');
        $pdf->save('pdf/'.$name); 
        return Redirect::to('home');
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