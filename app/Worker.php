<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $table = 'worker';
    
 	public function msp()
    {
        return $this->belongsTo('App\msp');       
    }

    public function workshop_level_3()
    {
    	return $this->belongsToMany('App\Workshop_level_3','task', 'worker_id', 'workshop_level_3_id')
    	->withPivot('date', 'isMorning');
    }
}
