<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    public function workout_type()
    {
        return $this->belongsTo('App\WorkoutType');
    }
}
