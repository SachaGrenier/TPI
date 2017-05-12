<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\msp;
use Illuminate\Support\Facades\Session;

class MSPController extends Controller
{
    static public function getAllMSPs()
    {
        return msp::all();
    }
    public function addMSP(request $request)
    {
        $MSP = new msp;
        try
        {
        	$MSP->firstname = $request->input('msp_firstname');
    	    $MSP->lastname = $request->input('msp_lastname');
	        $MSP->initials = $request->input('msp_initials');
	        $MSP->save();
	        Session::flash('status', 'Le Maître Sociaux Professionnel <strong>'.$MSP->firstname.' '.$MSP->lastname.'</strong> à bien été crée.'); 
	            Session::flash('class', 'alert-success'); 
        }
        catch(\Exception $ex)
        {
        	Session::flash('status', 'Une erreur est intervenue : veuillez remplir tous les champs svp');
        	Session::flash('class', 'alert-danger');
        }
               
        return redirect('workers');
    }
    public function deleteMSP(request $request)
    {
    	$MSP = msp::find($request->input('msp_id'));

    	try
    	{
    		$MSP->delete();
    		 Session::flash('status', 'Le Maître Sociaux Professionnel <strong>'.$MSP->firstname.' '.$MSP->lastname.'</strong> à bien été supprimé.'); 
            Session::flash('class', 'alert-success'); 
    	}
    	catch(\Exception $ex)
    	{
            Session::flash('status', 'Une erreur est intervenue'); 
            Session::flash('class', 'alert-danger');
        }
        return redirect('workers');
    }
}
