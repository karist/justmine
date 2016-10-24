<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Stubattr;
use App\Template;

use App\Http\Requests\TablePropertiesRequest;

class ContentController extends Controller
{
  public function show($content_name){
    if($content_name=='tabletemplate'||$content_name=='template-json'){
      $stubattrs = Stubattr::all();
      return view('tabletemplate', compact('stubattrs'));
    } else{
      return view($content_name);
    }
  }

  public function postTableProperties(TablePropertiesRequest $request){
    echo $request;
  }
}
