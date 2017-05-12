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

    //table intérmiédiaire
    public function ahok()
    {
    	//return $this->belongsToMany('App\Contact','ticket_contact', 'contact_id', 'ticket_id');
    }
}
