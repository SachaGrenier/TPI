<?php

namespace App\Http\Controllers;

use Request;
use App\Worker;
use App\msp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class WorkersController extends Controller
{
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
            $worker->updated_at = $value->updated_at->formatLocalized('%d %B %Y');
        	$worker->delete_link = "<button onclick='deleteRow(". $value->id .",this)' value='". csrf_token()."' class='btn btn-danger delete-button'>X</button>";

            $array[] = $worker;
        }
        $form = new \stdClass();
        
        $form->id = "";
        $form->firstname = "<input class='table-input' type='text' placeholder='Prénom' id='firstname'>";
        $form->lastname = "<input class='table-input' type='text' placeholder='Nom' id='lastname'>";
        $form->username = "<input class='table-input' type='text' id='username' placeholder=\"Nom d'utilisateur\">";
        $form->percentage = "<input class='table-input percentage' type='text' placeholder='%' id='percentage'>";
        $form->MSP_initials = $this->getMSPSelection();
        $form->created_at = "<button class='btn btn-secondary' id='confirm'>Ajouter</button>";
        $form->updated_at = '<p id="_token" style="display:none">'. csrf_token().'</p>';
        $form->delete_link = "";

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

            if($worker->delete())
                return response(200);
        }
        else
        {
            return response(500);
        }
       
    }
    public function addWorker()
    {
         // Getting all post data
        if(Request::ajax()) 
        {
          $data = Input::all();
          
          $worker = new Worker;
          $worker->firstname = $data["firstname"];
          $worker->lastname = $data["lastname"];
          $worker->username = $data["username"];
          $worker->percentage = $data["percentage"];
          $worker->msp_id = $data["msp"];

          if($worker->save())
            return response(200);
        }
        else
        {
            return response(500);
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
