<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use GuzzleHttp;

class FOPController extends Controller
{
    function savePDF(){
        // input xml data
        $xml="<?xml version=\"1.0\" encoding=\"iso-8859-1\"?> <departments><department><departmentName>R&amp;D</departmentName> <person> <name>John Schmidt</name> ";
        $xml=$xml . "<address>Red street 3</address> <status>A</status> </person> <person> <name>Paul Bones</name> <address>White street 5</address> <status>A</status> ";
        $xml=$xml . "</person> <person> <name>Mark Mayer</name> <address>Blue street 5</address> <status>A</status> </person> <person> <name>Janet Black</name> ";
        $xml=$xml . "<address>Black street 8</address> <status>I</status> </person></department><department> <departmentName>Sales</departmentName> <person> ";
        $xml=$xml . "<name>Juan Gomez</name> <address>Green street 3</address> <status>A</status> </person> <person> <name>Juliet Bones</name> <address>White street 5</address> ";
        $xml=$xml . " <status>A</status> </person></department></departments>";

        $template = "departmentEmployees.fo";
        $data = $xml;

        $client = new GuzzleHttp\Client();
        $request = $client->createRequest( 'POST', 'http://localhost');
        $request->setPath('/J4LFOPServer');
        $request->setPort(8087);
        $request->setHeader('Content-type', 'text/xml');
        $request->setHeader('Content-length',strlen($data));
        $request->setHeader('Connection', 'close');

        try { 
            $response = $client->send( $request ); 
            dd($response);
        } catch (\GuzzleHttp\Exception\ClientException $e) { 
            echo 'Caught response: ' . $e->getResponse()->getStatusCode(); 
        }
    }
}