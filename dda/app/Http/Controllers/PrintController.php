<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PrintController extends Controller
{
	public $PHPWord, $section, $header,$table,$footer;

	public function printController(){
		
	}

	public function setSection(){
		$section = $PHPWord->createSection();
		$section->addTextBreak();
		$section->addText('Some text...');
	}

	public function setHeader(){
		$header = $section->createHeader();
		$table = $header->addTable();
		$table->addRow();
		$table->addCell(4500)->addText('This is the header.');
	}

	public function setFooter(){
		$footer = $section->createFooter();
		$footer->addPreserveText('Page {PAGE} of {NUMPAGES}.', array('align'=>'center'));
	}

    public function print2file($id)
    {
    	$PHPWord = new \PhpOffice\PhpWord\PHPWord();
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($PHPWord, 'Word2007');
		$objWriter->save('word/'.$id.'.docx');
    }
}
