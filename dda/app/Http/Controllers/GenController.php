<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Narasi;
use App\Bab;
use App\Subbab;
use App\Anades;
use App\Dda;
use App\dda_temp;
use App\Levels;
use App\master_kecs;
use App\master_kabs;
use App\master_provs;
use App\Publikasi;
use App\Template;
use Input;
use DB;
use Redirect;
use App\HTMLtoOpenXML\HTMLtoOpenXML;
use Com\Tecnick\Pdf\TCPDF;

class GenController extends Controller
{
	public function createTCPDF(){
		$pdf = new TCPDF();

	    $pdf->SetPrintHeader(false);
	    $pdf->SetPrintFooter(false);
	    $pdf->AddPage();
	    $pdf->Text(90, 140, 'This is a test');
	    $filename = storage_path() . '/test.pdf';
	    $pdf->output($filename, 'F');

	    return Response::download($filename);
	}

    public function createPDF ( Request $request, $id ) {
    	\PhpOffice\PhpWord\Settings::setPdfRendererPath('../vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $dda = Dda::where('id', '=', $id)->first();
        $arr_babs = array();
        $arr_sub = array();
        $arr_temp = array();
        $dt = dda_temp::where('ddaname', '=', $id)->get();
        foreach($dt as $d){
            array_push($arr_temp, $d->temp_id);
            $temp = Template::where('id', $d->temp_id)->first();
            array_push($arr_babs, $temp->idbab);
            array_push($arr_sub, $temp->idsubbab);
        }
        $arr_babs = array_unique($arr_babs);
        $babs = DB::table('babs') ->whereIn('id', $arr_babs)->orderBy('nomorbab', 'asc')->get();
        $len = count($babs);
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('word/MTemplate4.docx');
		$templateProcessor->cloneBlock('CLONEME', $len);

		foreach($babs as $key=>$bab){
        	// echo $key;
        	$index = $key + 1;
    		$templateProcessor->setValue('daerah', 'Jakarta', 1);
    		$templateProcessor->setValue('tahun','2016', 1);
        	$templateProcessor->setValue('judul', $bab->nama_bab, 1);
			$templateProcessor->setValue('no', $index, 1);
			$templateProcessor->setValue('title', $bab->nama_eng, 1);

			$narasi = Narasi::where('ddaname','=',$id)->where('bab', '=', $index)->first();
			if($narasi){
				// $toOpenXML = new HTMLtoOpenXML::getInstance();
				$templateProcessor->setValue('narasi', htmlentities($narasi->teks), 1);
				$templateProcessor->setValue('narration', htmlentities($narasi->text), 1);	
			}

			$anades = Anades::where('ddaname','=',$id)->where('bab','=', $index)->get();
			if(count($anades)>=1){
				$len2 = count($anades);
				// $templateProcessor->cloneBlock('CLONE2', $len2);
				// Table with a spanned cell
				// $templateProcessor->cloneRow('nama_sub', 1);
				$templateProcessor->cloneRow('teks', $len2);
				foreach($anades as $key2=>$a){
					// $templateProcessor->setValue('teks', htmlentities($a->teks), 1);
					// $templateProcessor->setValue('text', htmlentities($a->text), 1);
					$sub=$a->subbab;
					$subbabs = DB::table('subbabs')->whereIn('id', $arr_sub)->get();
					// $subbab = Subbab::where('id','=',$sub)->first();
					foreach($subbabs as $key3=>$subbab){
						if($subbab->id === $a->subbab){
							$templateProcessor->setValue('nama_sub',$subbab->nama_sub);
	    					$templateProcessor->setValue('sub_name',$subbab->sub_name);
						}
						$templateProcessor->setValue('teks#'.$key2, htmlentities($a->teks));
						$templateProcessor->setValue('text#'.$key2, htmlentities($a->text));
					}
				}	
			} else {
				$templateProcessor->deleteBlock('CLONE2');
			}
        }
        $title = time().'result';
		$templateProcessor->saveAs('word/'.$title.'.docx');

		// Load temp file
		$phpWord = \PhpOffice\PhpWord\IOFactory::load('word/'.$title.'.docx'); 

		// Save it
		$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
		$xmlWriter->save('pdf/'.$title.'.pdf'); 

        // table
  //   	$table_array = explode(',',$request->get('tabel'));
  //   	$table_num = count($table_array);
  //   	$phpWord = new \PhpOffice\PhpWord\PhpWord();
    	
  //   	$html = '';
  //   	foreach($table_array as $tab){
		// 	$html .= $tab;
		// 	$section = $phpWord->addSection();
			
  //   	}
    	
		// \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);

		// // Saving the document as OOXML file...
		// $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		// $objWriter->save('word/file.docx');

		// $dompdf = new \domPDF();
		// $dompdf->set_paper("A5");
		// $dompdf->load_html($html);
		// $dompdf->render();

		// $output = $dompdf->output();
		// file_put_contents("pdf/file.pdf", $output);

		// $obj2Writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
		// $obj2Writer->save('helloWorld.html');
		
		return Redirect::back()->with('success', 'Generated Successfully'); 

    }
}
