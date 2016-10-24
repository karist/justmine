<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Articles;
use App\UserModel;
use Auth;
use DB;
use Input;
use Redirect;
use Session;
use Validator;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = DB::table('articles')->orderBy('created_at', 'desc')->paginate(10);
        // $articles = Articles::orderBy('created_at', 'desc')->paginate(10);
        return view('articles/art-view', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles/art-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);
        if($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            try{
                $article = new Articles;
                $article->title = $request->get('title');
                $article->text = $request->get('description');
                $article->author = Auth::user()->id;
                $article->save();

                // require_once 'vendor/phpoffice/phpword/src/PhpWord/Autoloader.php';
                // \PhpOffice\PhpWord\Autoloader::register();
                \PhpOffice\PhpWord\Settings::setPdfRendererPath('../vendor/dompdf/dompdf');
                \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
                // dd(\PhpOffice\PhpWord\Settings::getPdfRendererPath());

                // New Word Document
                $PHPWord = new \PhpOffice\PhpWord\PHPWord();
                $section = $PHPWord->addSection(
                    array('paperSize' => 'A5', 'marginLeft' => '2cm', 'marginRight' => '2cm', 'marginTop' => '2cm', 'marginBottom' => '2cm')
                );

                $header = $section->addHeader();
                $header->firstPage();
                $header->addText(htmlspecialchars('First', ENT_COMPAT, 'UTF-8'), null);
                $header = $section->addHeader();
                $header->evenPage();
                $header->addText(htmlspecialchars('Even', ENT_COMPAT, 'UTF-8'), null);
                $header = $section->addHeader();
                $header->addText(htmlspecialchars('Odd', ENT_COMPAT, 'UTF-8'), null);

                $footer = $section->addFooter( \PhpOffice\PhpWord\Element\Header::AUTO);
                $footer->addPreserveText('{PAGE}', null, ['align' => 'right']);

                $footerEven = $section->addFooter(\PhpOffice\PhpWord\Element\Header::EVEN);
                $footerEven->addPreserveText('{PAGE}');

                // Write some text
                $section->addTextBreak();
                $section->addText($request->get('description'));

                $html = '<h1>Adding element via HTML</h1>';
                $html .= '<p>Some well formed HTML snippet needs to be used</p>';
                $html .= '<p>With for example <strong>some<sup>1</sup> <em>inline</em> formatting</strong><sub>1</sub></p>';
                $html .= '<p>Unordered (bulleted) list:</p>';
                $html .= '<ul><li>Item 1</li><li>Item 2</li><ul><li>Item 2.1</li><li>Item 2.1</li></ul></ul>';
                $html .= '<p>Ordered (numbered) list:</p>';
                $html .= '<ol><li>Item 1</li><li>Item 2</li></ol>';
                \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);

                $section->addPageBreak();
                $section->addText('I am placed on a default section.');
                $section->addTextBreak();
                $section->addText('I am placed on a landscape section. Every page starting from this section will be landscape style.');
                $section->addPageBreak();
                $section->addText('This section uses other margins with folio papersize.');
                $section->addPageBreak();
                $section->addText('This section and we play with header/footer height.');
                $section->addHeader()->addText('Header');
                $section->addFooter()->addText('Footer');

                $phpw = new \PhpOffice\PhpWord\PHPWord();
                $document = $phpw->loadTemplate('Template.docx');
                $document->setValue('Value1', 'Sun');
                $document->setValue('Value2', 'Mercury');
                $document->setValue('Value3', 'Venus');
                $document->setValue('Value4', 'Earth');
                $document->setValue('Value5', 'Mars');
                $document->setValue('Value6', 'Jupiter');
                $document->setValue('Value7', 'Saturn');
                $document->setValue('Value8', 'Uranus');
                $document->setValue('Value9', 'Neptun');
                $document->setValue('Value10', 'Pluto');
                $document->setValue('weekday', date('l'));
                $document->setValue('time', date('H:i'));
                $document->saveAs('Solarsystem.docx');

                // Save File
                $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($PHPWord, 'Word2007');
                $objWriter->save('word/HeaderFooterHTML.docx');

                $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($PHPWord , 'PDF');
                $xmlWriter->setPaperSize(11); // 11 untuk A5
                $xmlWriter->save('pdf/faktur.pdf', TRUE);

                return Redirect::back()->with('success', 'New Articles Successfully Created'); 
            } catch (\Illuminate\Database\QueryException $e) {
                return Redirect::back()->withErrors('Please use a unique name');
            }catch (PDOException $e) {
                return Redirect::back()->withErrors('Error in Database');
            } 
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
        $articles = DB::table('articles')->orderBy('created_at', 'desc')->paginate(10);
        $article = Articles::where('id', '=', $id)->first();
        $auth = $article->author;
        $author = UserModel::where('id',$auth)->first();
        return view('articles/art-show', compact('article', 'articles', 'author'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $article = Articles::where('id',$id)->first();
        return view('articles/art-edit');
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
        // delete
        Articles::where('id',$id)->delete();

        // redirect
        Session::flash('message','Artikel dihapus');
        return Redirect::to('articles');
    }
}
