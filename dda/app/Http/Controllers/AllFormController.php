<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\LayoutMasterSet;
use Input;
use Validator;
use Redirect;
use File;

class AllFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('allform');
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
        $validator = Validator::make($request->all(), [
            // 'paper-sz' => 'required',
            // 'margin-tp' => 'required',
            // 'margin-btm' => 'required',
            // 'margin-insd' => 'required',
            // 'margin-osd' => 'required',
            // 'header-margin' => 'required',
            // 'footer-margin' => 'required'
        ]);
        if($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            // return Redirect::back()->with('success', 'Configuration Saved');
            // $papersize = $request->get('paper-sz');
            // $headermargin = $request->get('header-margin');
            // $footermargin = $request->get('footer-margin');
            // $outside = $request->get('margin-osd');
            // $inside = $request->get('margin-insd');
            // $bottom = $request->get('margin-btm');
            // $top = $request->get('margin-tp');
            // $mirror = $request->get('mirror');
            // $master = new LayoutMasterSet($top, $bottom, $inside, $outside, $mirror, $headermargin, $footermargin, $papersize);
            // dd($master->getLayoutMaster());
            // dd(Input::all());
            // echo getcwd();
            // chdir('C:\FOP');
            // exec('fop -xml name.xml -xsl name2fo.xsl -pdf name.pdf');
            $master = new \SimpleXMLElement("<xsl:template></xsl:template>");
            $master->addProcessingInstruction('xml-stylesheet', 'type="text/xsl" href="xsl/xsl.xsl"'); 
            $master->addAttribute('match', '/');
            $root->$master->addChild('fo:root');
            $layout->$root->addChild('fo:layout-master-set');
            $standard = $layout->addChild('fo:simple-page-master');
            $standard->addAttribute('master-name', 'standard');
            $standard->addAttribute('margin-left', '2cm');
            $standard->addAttribute('margin-right', '1.5cm');
            $standard->addAttribute('margin-top', '1cm');
            $standard->addAttribute('margin-bottom', '1cm');
            $standard->addAttribute('page-height', '21cm');
            $standard->addAttribute('page-width', '14.8cm');
            $filename = "file.xml";
            $bytes_written = File::put('xml/'.$filename, $master->asXML());
            if($bytes_written === false){
                die("Error writing to file");
            } else {
                echo $master;
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
