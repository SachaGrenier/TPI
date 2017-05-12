<?php

namespace App\Http\Controllers;

use Request;
use App\Worker;
use App\msp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;


class WorkersController extends Controller
{

    public $default_general_error_message = "Un problème est intervenu, contactez l'administrateur du système";

    public function getWorkersArray()
    {
    	$workers = Worker::all();

    	$array = [];

    	setLocale(LC_TIME,config('app.locale'));

    	foreach ($workers as $key => $value)
        {
        	$worker = new \stdClass();
        	$worker->id = $value->id;
        	$worker->firstname = $value->firstname;
            $worker->lastname = $value->lastname;
        	$worker->username = $value->username;
        	$worker->percentage = $value->percentage;
        	$worker->MSP_initials = "".$value->msp['firstname']." ". $value->msp['lastname'] ." (".$value->msp['initials'] .")";
            $worker->created_at = $value->created_at->formatLocalized('%d %B %Y');
        	$worker->delete_link = "<button onclick='deleteRow(". $value->id .",this)' value='". csrf_token()."' class='btn btn-danger middle-button'>X</button>";

            $array[] = $worker;
        }
        $form = new \stdClass();
        
        $form->id = "";
        $form->firstname = "<input class='table-input' type='text' placeholder='Prénom' id='firstname'>";
        $form->lastname = "<input class='table-input' type='text' placeholder='Nom' id='lastname'>";
        $form->username = "<input class='table-input' type='text' id='username' placeholder=\"Nom d'utilisateur\">";
        $form->percentage = "<input class='table-input percentage' type='text' placeholder='%' id='percentage'>";
        $form->MSP_initials = $this->getMSPSelection();
        $form->created_at = Carbon::now()->formatLocalized('%d %B %Y');
        $form->delete_link = '<p id="_token" style="display:none">'. csrf_token().'</p><button class="btn btn-secondary middle-button" id="confirm">Ajouter</button>';

        $array[] = $form;
    	return $array;
    }
    //a tester
    public function deleteWorker()
    {
        if(Request::ajax()) 
        {
            $data = Input::all();
            $worker = Worker::find($data["worker_id"]);
            try
            {
                $worker->delete();
                return response(200);
            }
            catch(\Exception $er)
            { 
                return response(" Impossible de supprimer cet utilisateur" ,400);
            }
        }
        else
        {
            return response($default_general_error_message,500);
        }
       
    }
    public function addWorker()
    {
         // Getting all post data
        if(Request::ajax()) 
        {
            $data = Input::all();
            try
            {
                $worker = new Worker;      
                $worker->firstname = $data["firstname"];
                $worker->lastname = $data["lastname"];
                $worker->username = $data["username"];
                $worker->percentage = $data["percentage"];
                $worker->msp_id = $data["msp"];

                $worker->save();
                return response(200);
            }
            catch(\Exception $er)
            { 
                return response(" Veuillez vérifier que tous les champs aient bien étés remplis correctement" ,400);
            }
        }
        else
        {
            return response($default_general_error_message,500);
        }
    }

    private function getMSPSelection()
    {
        $MSPs = msp::all();
        $select = "<select class='table-input' id='msp'>";
        $options = "<option disabled selected>Séléctionner MSP</option>";
        foreach ($MSPs as $MSP) 
        {
            $options .= "<option value='".$MSP->id."'>".$MSP->firstname ." ". $MSP->lastname ." (".$MSP->initials .")</option>";
        }
        $select .= $options;
        $select .= "</select>";

        return $select;
    }

    

}
