<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use snappyPDF;
use App;
use Response;
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
// use Prince;
// use App\Prince\Prince;
use Jtoler\Prince\Prince;

class PDFController extends Controller
{
    public function github(){
    	$id = '201631';
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

        $data = [
            'templates' => $templates, 
            'id'        => $id,
            'babs'      => $babs,
            'subbabs'   => $subbabs,
            'narasis'   => $narasis,
            'anades'    => $anades,
            'daerah'    => $daerah,
            'lvl'       => $lvl,
            'tahun'     => $tahun
        ];

		$pdf = snappyPDF::loadView('result', $data);
		$pdf->setTimeout(300);
		$pdf->setOption('enable-javascript', true);
		$pdf->setOption('javascript-delay', 13500);
		$pdf->setOption('enable-smart-shrinking', true);
		$pdf->setOption('no-stop-slow-scripts', true);
		return $pdf->download('invoice.pdf');

    }

   	public function tcpdf(){
		tcPDF::SetTitle('Hello World');
	    tcPDF::AddPage();
	    tcPDF::Write(0, 'Hello World');
	    tcPDF::Output('hello_world.pdf');
   	}

    public function prince(){
        $prince = new Prince(App::make('Bab'));
        $prince->view(View::make('someview',['somevar' => $somevalue]));

        // $prince->setHTML('<html><body><div><h1>Appending more content.</h1></div></body></html>');
        return $prince->download();
    }
}
