<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Stub;
use App\Stubattr;
use App\Template;
use App\Bab;
use App\Subbab;
use Validator;
use Redirect;
use Session;
use Response;
use Auth;

class TemplatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = Template::paginate(5);
        $kd = Auth::user()->kode_daerah;
        $vars = array(
          // '$provinsi'     => $provinsi,
          // '$tahun'        => $tahun
        );
        return view('template', compact('templates', 'vars', 'kd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stubattrs = Stubattr::all();
        $templates = Template::paginate(5);
        $babs = Bab::all();
        $kd = Auth::user()->kode_daerah;
        return view('template/tab-create', compact('stubattrs', 'templates', 'babs', 'kd'));
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
            'tabno' => 'required',
            'tabname' => 'required',
            'tabtemplate' => 'required'
        ]);
        if($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            try{
                $template = new Template;
                $template->tabno = $request->get('tabno');
                $template->tabtitle = $request->get('tabname');
                $template->tabtemplate = $request->get('tabtemplate');
                $template->stubname = $request->get('stubname');
                $template->idbab = $request->get('idbab');
                $template->idsubbab = $request->get('idsubbab');
                $template->save();

                $stubattrs = Stubattr::all();
                $templates = Template::paginate(10);
                $babs = Bab::all();
                return view('template/tab-create', compact('stubattrs', 'templates', 'babs')); 
            } catch (\Illuminate\Database\QueryException $e) {
                return Redirect::back()->withErrors('Please choose a stub');
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
        Template::where('id',$id)->delete();
        // redirect
        Session::flash('message','Successfully deleted');
        return Redirect::to('templates');
    }
}
