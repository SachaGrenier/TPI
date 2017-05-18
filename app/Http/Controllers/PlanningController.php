<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

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

}
//"days" => array("monday" => $date->startOfWeek(),"tuesday" => $date->startOfWeek(+1),"wednesday" => $date->startOfWeek(+2),"thursday" => $date->startOfWeek(+3),"friday" => $date->startOfWeek(+4)));

