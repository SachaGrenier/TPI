<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App;
use PDF;

class PDFController extends Controller
{
    //

    public  function toPDF(Request $request)
    {
       	$html = $request->input("html_content");
        try
        {  
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML($html)->setPaper('a3', 'landscape');
            return $pdf->stream();   
        }
        catch(\Exception $er)
        { 
            return response('Une erreur est intervenue' ,400);
        }       
    }
}
