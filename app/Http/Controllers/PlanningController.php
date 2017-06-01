<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\workshop_level_3;
use App\Worker;
use View;
use DateTime;
use Illuminate\Support\Facades\Input;
use Request;



class PlanningController extends Controller
{
    /**
    * Returns the planning view with parameters
    *
    * @param $weeknb, number of the week
    *
    * @param $year
    *
    *
    * @return view "planning" with week data given by getWeek and year
    */
    public function index($weeknb = null,$year = null)
    {

        //if values are null, takes the date of the day
        if($weeknb == null || $year == null)
        {
            $date = Carbon::now();
            $year = $date->year; 
            $weeknb = $date->startOfWeek();
        }
        else
        {   
            //creates DateTime object from year and week number and transforms it to a Carbon date 
            $date = new DateTime();
            $date->setISODate($year,$weeknb);
            $date = Carbon::instance($date);
        }

        return View::make('planning', [
            'week' => $this->getWeek($date),
            'year' => $year
        ]);
    }

    /**
    * Returns an array of week data from given date
    *
    * @param Carbon object $date from wich I take all the elements I need
    *
    * @return $weeks
    */
    static public function getWeek($date)
    {
	  	$start_date = $date->startOfWeek();
		$end_date = $date->copy()->endOfWeek()->subDay(2); ;

		$weeks = array(
			"start_end" => array("start" => $start_date,"end" => $end_date,"week" => $start_date->copy()->weekOfYear),
			"days" => array("monday" => $start_date,"tuesday" => $start_date->copy()->addDay(),"wednesday" => $start_date->copy()->addDay(2),"thursday" => $start_date->copy()->addDay(3),"friday" => $start_date->copy()->addDay(4))
			);

		return $weeks;
    }
    /**
    * Insert Worker in a Workshop
    *
    * @return response code (with message if the response is negative)
    */
    public function	AddWorkerAtWorkshop()
    {
        if(Request::ajax()) 
        {
            // Getting all post data
            $data = Input::all();

            try
            {   
                $worker = Worker::find($data["worker_id"]);
                //first checks if the worker is already doing something at this moment
                $isFree = true;

                foreach ($worker->workshop_level_3 as $task)
                {                    
                    if($task->pivot->date == $data["date"] && $task->pivot->isMorning == $data["ismorning"])
                        $isFree = false;
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
            return response($default_general_error_message,500);
        
    }
    /**
    * Remove worker in workshop from ajax array
    *
    * @return response code (with message if the response is negative)
    */
    public function RemoveWorkerAtWorkshop()
    {
         if(Request::ajax()) 
        {
            // Getting all post data
            $data = Input::all();
            try
            {  
                $worker = Worker::where('username',$data["worker_username"])->get();
                 
                $worker[0]->workshop_level_3()->wherePivot('date', '=', $data["date"])->wherePivot('isMorning', '=', $data["ismorning"])->detach($data["workshop_level_3"]);
               return response(200);
            }
            catch(\Exception $er)
            { 
                return response(" Une erreur est intervenue" ,400);
            }       
        }
        else
            return response($default_general_error_message,500);
        
    }

    /**
    * Format data about each task (worker doing workshop)
    *
    * @return array in JSON
    */
    static public function	getPlanningCells()
    {
        $workshops = workshop_level_3::all();

        $array = array();
        
        foreach ($workshops as $workshop) 
        {    
            foreach ($workshop->worker as $task) 
            {
            	$cell = array(
                    "workshop_level_3" => $workshop->id,
                    "isMorning"        => $task->pivot->isMorning,
                    "date"             => $task->pivot->date,
                    "text"             => $task->username,
                    );

                $array[] = $cell;  
            }
        }
        return json_encode($array);
    }

    


}

