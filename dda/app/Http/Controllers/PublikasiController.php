<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Publikasi;
use Auth;
use Input;
use Validator;
use Redirect;
use App\Dda;
use Carbon\Carbon;

class PublikasiController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publikasi = Publikasi::all();
        $ddas = Dda::where('status','1')->get();
        return view('publikasi', compact('publikasi','ddas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$daerah = Auth::user()->kode_daerah;
        return view('upload2', compact('daerah'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),array(
            'title' => 'required',
            'image' => 'required|mimes:pdf|max:100000'
            ));
        if($validation->fails()){
            return Redirect::back()->withErrors($validation);
        } else {
            $image = new Publikasi;
            $image->title = $request->Input('title');
            $image->description = $request->Input('description');
            if($request->hasFile('image')){
                $file = Input::file('image');
                $timestamp = str_replace([' ',':'], '-', Carbon::now()->toDateTimeString());
                $name = $timestamp. '-' .$file->getClientOriginalName();
                $image->filePath = $name;
                $file->move(public_path().'/published/', $name);   
            }
            
            $image->save();
            return Redirect::back()->with('success', 'Berhasil Diunggah');
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $stubname
     * @return \Illuminate\Http\Response
     */
    public function edit($stubname)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $stubname
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $stubname)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $stubname
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete
        Image::where('id',$id)->delete();
        
        // redirect
        Session::flash('message','Successfully deleted');
        return Redirect::back();
    }
}
