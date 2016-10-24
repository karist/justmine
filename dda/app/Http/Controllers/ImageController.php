<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Image;
use Input;
use Validator;
use Redirect;
use Carbon\Carbon;

class ImageController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::all();
        return view('image', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('upload');
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
            'image' => 'required|mimes:jpg,jpeg|max:100'
            ));
        if($validation->fails()){
            return Redirect::back()->withErrors($validation);
        } else {
            $image = new Image;
            $image->title = $request->Input('title');
            $image->description = $request->Input('description');
            if($request->hasFile('image')){
                $file = Input::file('image');
                $timestamp = str_replace([' ',':'], '-', Carbon::now()->toDateTimeString());
                $name = $timestamp. '-' .$file->getClientOriginalName();
                $image->filePath = $name;
                $file->move(public_path().'/images/', $name);   
            }
            
            $image->save();
            return Redirect::back()->with('success', 'Uploaded Successfully');
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
