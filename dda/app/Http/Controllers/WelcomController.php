<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class WelcomController extends Controller
{
    /**
 * Show the application welcome screen to the user.
 *
 * @return Response
 */
public function index()
{   
    // adds to main xml /App attributte name template with value  = hello
    \View::addAttribute('name template ', 'hello');
    // create child template to /App with value hello and add aaa and zzz atribute to template.
    \View::addChild('template', 'hello', false)->addAttribute('aaaa', 'zzz');
    // creates parent example and adds childs foo and bar to it 
    \View::addArrayToXmlByChild(['foo', 'bar'], 'example', false); 
    // add to parent App child bar and zzz
    \View::addArrayToXml(['bar', 'zzz'], false);

    return view('welcom');
}
}
