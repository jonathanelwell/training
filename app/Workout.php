<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{

	protected $fillable = ['workout_type_id','scheduled','recorded','title','duration_goal','duration_actual','data','rating','comments'];
	
    public function workout_type()
    {
        return $this->belongsTo('App\WorkoutType');
    }
}
