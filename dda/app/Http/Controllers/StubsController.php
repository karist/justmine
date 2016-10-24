<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Stub;
use App\Stubattr;
use App\Template;
use Validator;
use Redirect;
use Session;

class StubsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stubattrs = Stubattr::paginate(10);
        $stubs = Stub::all();
        return view('stub/info', compact('stubattrs', 'stubs'));
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
            'stub_nama' => 'required',
            'stub_label' => 'required',
            'field_indo' => 'required',
            'tipe' => 'required'
        ]);
        if($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            try{
                $stub_nama = $request->get('stub_nama');
                $rincians = $request->get('field_indo');
                if($request->get('tipe') == "Static"){
                    $rincians = array_filter($rincians);
                }
                $details = $request->get('field_eng');

                $stubattr = new Stubattr;
                $stubattr->stubname = $stub_nama;
                $stubattr->stubindo = $request->get('stub_label');
                $stubattr->stubeng = $request->get('stub_english');
                $stubattr->type = $request->get('tipe');
                $stubattr->length = count($rincians);
                $stubattr->save();   

                for ($i=0; $i < count($rincians); $i++) { 
                    $stub = new Stub;
                    $stub->stubname = $stub_nama;
                    $stub->rincian = $rincians[$i];
                    $stub->details = $details[$i];
                    $stub->save();
                }
                return Redirect::back()->with('success', 'New Stub Added Successfully'); 
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $stubname
     * @return \Illuminate\Http\Response
     */
    public function edit($stubname)
    {
        $stubattr = Stubattr::where('stubname','=', $stubname)->first();
        $stubs = Stub::where('stubname','=',$stubname)->get();
        return view('stub/edit', compact('stubattr', 'stubs'));
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
        $validator = Validator::make($request->all(), [
            'stub_label' => 'required',
            'field_indo' => 'required',
            'tipe' => 'required'
        ]);
        if($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            try{
                $rincians = array_filter($request->get('field_indo'));
                $details = $request->get('field_eng');

                Stubattr::where('stubname', $stubname)->update([
                    'stubindo' => $request->get('stub_label'),
                    'stubeng' => $request->get('stub_english'),
                    'type' => $request->get('tipe'),
                    'length' => count($rincians)
                ]);

                Stub::where('stubname',$stubname)->delete();
                for ($i=0; $i < count($rincians); $i++) { 
                    $stub = new Stub;
                    $stub->stubname = $stubname;
                    $stub->rincian = $rincians[$i];
                    $stub->details = $details[$i];
                    $stub->save();
                }
                return Redirect::back()->with('success', 'Updating Stub Success'); 
            } catch (\Illuminate\Database\QueryException $e) {
                return Redirect::back()->withErrors('Please use a unique name');
            }catch (PDOException $e) {
                return Redirect::back()->withErrors('Error in Database');
            } 
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $stubname
     * @return \Illuminate\Http\Response
     */
    public function destroy($stubname)
    {
        // delete
        Stub::where('stubname',$stubname)->delete();
        Stubattr::where('stubname',$stubname)->delete();
        
        // redirect
        Session::flash('message','Successfully deleted');
        return Redirect::to('stubs');
    }
}
