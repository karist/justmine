<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use DB;

use PDF;


class ItemController extends Controller

{


    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Http\Response

     */

    public function pdfview(Request $request)

    {

        $items = DB::table("users")->get();
        $cek = DB::table("articles")->get();

        view()->share(['items' => $items, 'cek' => $cek]);


        // if($request->has('download')){

        $pdf = PDF::loadView('pdfview');

        return $pdf->download('pdfview');

        // }


        // return view('pdfview');

    }

}
