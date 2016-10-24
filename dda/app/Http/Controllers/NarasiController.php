<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Bab;
use Input;
use App\Narasi;
use Redirect;
use Session;
use Validator;
use DB;

class NarasiController extends Controller
{
    public function index()
    {
    	$babs = Bab::all();
        $narasis = Narasi::paginate(10);
        return view('narasi', compact('babs', 'narasis'));
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
    public function store(Request $request, $id)
    {
    	try{
            $bab = $request->get('dd_bab');
            $exists = DB::table('narasis')->where('ddaname', '=' ,$id)->where('bab', '=' , $bab)->first();
            $teks = $request->get('narr_in');
            $text = $request->get('narr_eng');
            if($exists){
                DB::table('narasis')
                ->where('ddaname', $id)
                ->where('bab', $bab)
                ->update([
                    'teks' => $teks,
                    'text' => $text
                    ]);
            } else {
                $narasi = new Narasi;
                $narasi->ddaname = $id;
                $narasi->bab = $request->get('dd_bab');
                $narasi->teks = $request->get('narr_in');
                $narasi->text = $request->get('narr_eng');
                $narasi->save();    
            }
	        return Redirect::back()->with('narr_success', 'Saved'); 
            dd(Input::all());
    	} catch (Exception $e) {
		    echo 'Error occured. Failed to save data.';
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
