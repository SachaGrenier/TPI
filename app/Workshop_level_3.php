<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workshop_level_3 extends Model
{
     protected $table = 'workshop_level_3';
     public $timestamps = false;

    public function workshop_level_2()
    {
        return $this->belongsTo('App\Workshop_level_2');       
    }
}
