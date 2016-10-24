<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Stub;
use App\Stubattr;
use App\Template;
use App\Bab;
use App\User;
use App\Subbab;
use Validator;
use Redirect;
use Session;
use Response;
use Input;
use App\Baku;

class BakuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bakus = Baku::paginate(10);
        $count = User::count();
        return view('baku-info', compact('bakus', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $count = User::count();
        $stubattrs = Stubattr::all();
        $templates = Template::paginate(10);
        $babs = Bab::all();
        return view('baku', compact('stubattrs', 'templates', 'babs', 'count'));
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
            'name_baku' => 'required',
            'tabtemplate' => 'required'
        ]);
        if($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            try{
                $baku = new Baku;
                $baku->name = $request->get('name_baku');
                $baku->tabel_baku = $request->get('tabtemplate');
                $baku->save();
                return Redirect::back()->with('success', 'New Stub Added Successfully');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $template = Template::where('id','=', $id)->first();
        $babs = Bab::all();
        return view('template/tab-edit', compact('template','babs'))->with('template', $template);
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
        $validator = Validator::make($request->all(), [
            'idbab'         => 'required',
            'idsubbab'      => 'required',
            'tabno'         => 'required',
            'tabname'       => 'required',
            'tabtemplate'   => 'required'
        ]);
        if($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            try{
                $stubname = $request->get('stubname');
                Template::where('id', $id)->update([
                    'tabno'         => $request->get('tabno'),
                    'tabtitle'      => $request->get('tabname'),
                    'tabtemplate'   => $request->get('tabtemplate'),
                    'stubname'      => $stubname,
                    'idbab'         => $request->get('idbab'),
                    'idsubbab'      => $request->get('idsubbab')
                ]);
                return Redirect::back()->with('success', 'Templates Updated');    
            } catch (\Illuminate\Database\QueryException $e) {
                return Redirect::back()->withErrors('Please choose a stub');
            }catch (PDOException $e) {
                return Redirect::back()->withErrors('Error in Database');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Baku::where('id',$id)->delete();
        // redirect
        Session::flash('message','Successfully deleted');
        return Redirect::to('admin/baku');
    }
}
