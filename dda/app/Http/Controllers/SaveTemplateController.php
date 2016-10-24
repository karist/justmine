<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SaveTemplateController extends Controller
{
    public function view()
    {
        return view('template/tab-create');
    }

    public function store(Request $request)
    {
        $stub_nama = $request->get('stub_nama');
        $stubattr = new Stubattr;
        $stubattr->stubname = $stub_nama;
        $stubattr->stubindo = $request->get('stub_label');
        $stubattr->stubeng = $request->get('stub_english');
        $stubattr->save();

        $rincians = $request->get('field_indo');
        $details = $request->get('field_eng');
        for ($i=0; $i < count($rincians); $i++) { 
            $stub = new Stub;
            $stub->stubname = $stub_nama;
            $stub->rincian = $rincians[$i];
            $stub->details = $details[$i];
            $stub->save();
        }
        
        return 'Success';
      }
}
