<?php

namespace App\Http\Controllers;

use Request;
use App\Worker;
use App\msp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;


class WorkersController extends Controller
{

    private $default_general_error_message = "Un problème est intervenu, contactez l'administrateur du système";

    /**
    * Creates an array with the Workers Data and adds a form at the last line of the array
    *
    * @return  array with workers data formated
    */
    public function getWorkersArray()
    {
    	$workers = Worker::all();

    	setLocale(LC_TIME,config('app.locale'));

        $form = new \stdClass();
        
        $form->id = "";
        $form->firstname = "<input class='form-control' type='text' placeholder='Prénom' id='firstname'>";
        $form->lastname = "<input class='form-control' type='text' placeholder='Nom' id='lastname'>";
        $form->username = "<input class='form-control' type='text' id='username' placeholder=\"Nom d'utilisateur\">";
        $form->percentage = "<input class='form-control percentage' type='text' placeholder='%' id='percentage'>";
        $form->MSP_initials = $this->getMSPSelection();
        $form->created_at = Carbon::now()->formatLocalized('%d %B %Y');
        $form->delete_link = '<p id="_token" style="display:none">'. csrf_token().'</p><button class="btn btn-secondary middle-button" id="confirm">Ajouter</button>';

        $array[] = $form;

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
                
    	return $array;
    }

    /**
    * Deletes worker from the database
    *
    * @param $request : Has the csrf token and the planning as html string
    *
    * @return http response, with error message if something went wrong
    */
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
            return response($default_general_error_message,500);
       
    }

    /**
    * Adds a worker into the database
    *
    * @param Data given my ajax post
    *
    * @return  http response, with error message if something went wrong
    */
    public function addWorker()
    {
        if(Request::ajax()) 
        {
            //Getting all post data
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
            return response($default_general_error_message,500);
        
    }

    /**
    * Generates html select for MSP, using MSPs from the database
    *
    * @param $request : Has the csrf token and the planning as html string
    *
    * @return  select as html string
    */
    private function getMSPSelection()
    {
        $MSPs = msp::all();
        $select = "<select class='form-control' id='msp'>";
        $options = "<option disabled selected>Séléctionner MSP</option>";
        foreach ($MSPs as $MSP) 
        {
            $options .= "<option value='".$MSP->id."'>".$MSP->firstname ." ". $MSP->lastname ." (".$MSP->initials .")</option>";
        }
        $select .= $options;
        $select .= "</select>";

        return $select;
    }
    /**
    * Creates an array with the workers, using their usernames and their ids
    *
    * @return  JSON encoded array
    */
    public function getWorkers()
    {
        $workers = Worker::all();

        $output_array = array();

        foreach ($workers as $row) 
        {
             $output_array[] = array( 
            'value' => $row['username'],
            'id' => $row['id']);
        }

        return json_encode($output_array);
    }
}
