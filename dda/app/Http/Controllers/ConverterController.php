<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Narasi;
use App\Bab;
use App\Anades;

class ConverterController extends Controller
{
    public function convert(){
    	try {
			$html = file_get_contents('example_files/example_html.html');
			// $html = file_get_contents('test/table.html');
			 
			// New Word Document:
			$phpword_object = new \htmltodocx\phpword\PHPWord\PHPWord();
			$section = $phpword_object->createSection();
			// HTML Dom object:
			$html_dom = new simple_html_dom();
			$html_dom->load('<html><body>' . $html . '</body></html>');
			// Note, we needed to nest the html in a couple of dummy elements.
			// Create the dom array of elements which we are going to work on:
			$html_dom_array = $html_dom->find('html',0)->children();
			// We need this for setting base_root and base_path in the initial_state array
			// (below). We are using a function here (derived from Drupal) to create these
			// paths automatically - you may want to do something different in your
			// implementation. This function is in the included file 
			// documentation/support_functions.inc.
			$paths = htmltodocx_paths();
			// Provide some initial settings:
			$initial_state = array(
			  // Required parameters:
			  'phpword_object' => &$phpword_object, // Must be passed by reference.
			  // 'base_root' => 'http://test.local', // Required for link elements - change it to your domain.
			  // 'base_path' => '/htmltodocx/documentation/', // Path from base_root to whatever url your links are relative to.
			  'base_root' => $paths['base_root'],
			  'base_path' => $paths['base_path'],
			  // Optional parameters - showing the defaults if you don't set anything:
			  'current_style' => array('size' => '11'), // The PHPWord style on the top element - may be inherited by descendent elements.
			  'parents' => array(0 => 'body'), // Our parent is body.
			  'list_depth' => 0, // This is the current depth of any current list.
			  'context' => 'section', // Possible values - section, footer or header.
			  'pseudo_list' => TRUE, // NOTE: Word lists not yet supported (TRUE is the only option at present).
			  'pseudo_list_indicator_font_name' => 'Wingdings', // Bullet indicator font.
			  'pseudo_list_indicator_font_size' => '7', // Bullet indicator size.
			  'pseudo_list_indicator_character' => 'l ', // Gives a circle bullet point with wingdings.
			  'table_allowed' => TRUE, // Note, if you are adding this html into a PHPWord table you should set this to FALSE: tables cannot be nested in PHPWord.
			  'treat_div_as_paragraph' => TRUE, // If set to TRUE, each new div will trigger a new line in the Word document.
			      
			  // Optional - no default:    
			  'style_sheet' => htmltodocx_styles_example(), // This is an array (the "style sheet") - returned by htmltodocx_styles_example() here (in styles.inc) - see this function for an example of how to construct this array.
			  );    
			// Convert the HTML and put it into the PHPWord object
			htmltodocx_insert_html($section, $html_dom_array[0]->nodes, $initial_state);
			// Clear the HTML dom object:
			$html_dom->clear(); 
			unset($html_dom);
			// Save File
			$h2d_file_uri = tempnam('', 'htd');
			$objWriter = PHPWord_IOFactory::createWriter($phpword_object, 'Word2007');
			$objWriter->save($h2d_file_uri);
			// Download the file:
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename=example.docx');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($h2d_file_uri));
			ob_clean();
			flush();
			$status = readfile($h2d_file_uri);
			unlink($h2d_file_uri);
			exit;

	        echo $len;
		} catch (Exception $e) {
		    echo 'Error occured. File failed to converted.';
		} 
    }

    public function two(){
    	\PhpOffice\PhpWord\Settings::setPdfRendererPath('../vendor/dompdf/dompdf');
        	\PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        	$narasis = Narasi::all();
	        $len = Bab::count();
	        $babs = Bab::all();

	        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('word/MTemplate3.docx');
			$templateProcessor->cloneBlock('CLONEME', $len);

			foreach($babs as $key=>$bab){
	        	echo $key;
	        	$index = $key + 1;
        		$templateProcessor->setValue('daerah', 'Jakarta', 1);
        		$templateProcessor->setValue('tahun','2016', 1);
	        	$templateProcessor->setValue('judul', $bab->nama_bab, 1);
				$templateProcessor->setValue('no', $index, 1);
				$templateProcessor->setValue('title', $bab->nama_eng, 1);

				$narasi = Narasi::where('bab', '=', $index)->first();
				if($narasi){
					$templateProcessor->setValue('narasi', $narasi->teks, 1);
					$templateProcessor->setValue('narration', $narasi->text, 1);	
				}

				$anades = Anades::where('bab','=', $index)->get();
				if(count($anades)>=1){
					$len2 = count($anades);
					$templateProcessor->cloneBlock('CLONE2', $len2);
					foreach($anades as $key2=>$a){
						$templateProcessor->setValue('teks', $a->teks, 1);
						$templateProcessor->setValue('text', $a->text, 1);
					}	
				} else {
					$templateProcessor->deleteBlock('CLONE2');
				}
	        }

			$templateProcessor->saveAs('word/result3.docx');

			//Load temp file
			$phpWord = \PhpOffice\PhpWord\IOFactory::load('word/result3.docx'); 

			//Save it
			$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
			$xmlWriter->save('pdf/result3.pdf'); 
    }

    public function one(){
    	\PhpOffice\PhpWord\Settings::setPdfRendererPath('../vendor/dompdf/dompdf');
    	\PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

    	$narasis = Narasi::all();
        $len = Bab::count();
        $babs = Bab::all();

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('word/ManualTemplate.docx');    
        $templateProcessor->cloneRow('no', $len);
        $templateProcessor->setValue('daerah', 'Jakarta');
        $templateProcessor->setValue('tahun','2016');
        foreach($babs as $key=>$bab){
        	echo $key;
        	$templateProcessor->setValue('judul#'.($key+1), $bab->nama_bab);
			$templateProcessor->setValue('no#'.($key+1), $bab->nomorbab);
			$templateProcessor->setValue('title#'.($key+1), $bab->nama_eng);
        }
		$templateProcessor->saveAs('word/result.docx');

		//Load temp file
		$phpWord = \PhpOffice\PhpWord\IOFactory::load('word/result.docx'); 

		//Save it
		$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
		$xmlWriter->save('pdf/result.pdf'); 
    }
}
