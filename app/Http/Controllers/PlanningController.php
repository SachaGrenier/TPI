<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\workshop_level_3;
use App\Worker;
use Request;
use Illuminate\Support\Facades\Input;


class PlanningController extends Controller
{
    //

    static public function getWeek($date)
    {
		//$date = $date->setISODate($date->year,$date->weekOfYear);
	  	$start_date = $date->startOfWeek();
		$end_date = $date->copy()->endOfWeek()->subDay(2); ;

		$weeks = array(
			"start_end" => array("start" => $start_date,"end" => $end_date),
			"days" => array("monday" => $start_date,"tuesday" => $start_date->copy()->addDay(),"wednesday" => $start_date->copy()->addDay(2),"thursday" => $start_date->copy()->addDay(3),"friday" => $start_date->copy()->addDay(4))
			);

		return $weeks;
    }

    public function	addWorkerAtWorkshop()
    {
    	// Getting all post data
        if(Request::ajax()) 
        {
            $data = Input::all();

            try
            {   
                
                $worker = Worker::find($data["worker_id"]);

                //first checks if the worker is already doing something at this moment
                $isFree = true;
                foreach ($worker->workshop_level_3 as $task)
                {                    
                    if($task->pivot->date == $data["date"] && $task->pivot->isMorning == $data["ismorning"])
                    {
                        $isFree = false;
                    }
                }

                if($isFree)
                {      
                    $worker->workshop_level_3()->attach($data["workshop_id"], ['date' => $data["date"],'isMorning' => $data["ismorning"]]);

                    return response(200);
                }
                else
                {
                    return response(" Le travailleur semble déjà faire quelque chose..." ,400);
                }
            }
            catch(\Exception $er)
            { 
                return response(" Veuillez vérifier que le nom d'utilisateur est correct" ,400);
            }
                        
        }
        else
        {
            return response($default_general_error_message,500);
        }
    }

    static public function	getPlanningCells()
    {
        $workshops = workshop_level_3::all();

        $tablo = array();
        
        foreach ($workshops as $workshop) 
        {    
            foreach ($workshop->worker as $task) 
            {
            	$cell = array(
                    "workshop_level_3" => $workshop->id,
                    "isMorning"        => $task->pivot->isMorning,
                    "date"             => $task->pivot->date,
                    "text"             =>$task->username,
                    );

                $tablo[] = $cell;  
            }
        }
        return json_encode($tablo);

    }

}

