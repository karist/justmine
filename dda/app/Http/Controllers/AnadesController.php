<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Anades;
use Input;
use Auth;
use Redirect;
use Session;
use DB;

class AnadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            $sub = $request->get('dd_sub');
            $exists = DB::table('anades')->where('ddaname', '=' ,$id)->where('subbab', '=' , $sub)->first();
            $teks = $request->get('anades_id');
            $text = $request->get('anades_eng');
            if($exists){
                DB::table('anades')
                ->where('ddaname', $id)
                ->where('subbab', $sub)
                ->update([
                    'teks' => $teks,
                    'text' => $text
                    ]);
            } else {
                $anades = new Anades;
                $anades->ddaname = $id;
                $anades->subbab = $sub;
                $anades->teks = $teks;
                $anades->text = $text;
                $anades->save();
            }
            return Redirect::back()->with('anades_success', 'Saved');
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
        $dda_id = Input::get('dda_id');
        $result = DB::table('anades')->where('ddaname', '=' ,$dda_id)->where('subbab', '=' , $id)->first();
        return Response::json($result);
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
