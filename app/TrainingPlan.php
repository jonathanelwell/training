<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingPlan extends Model
{
    public function weeks()
    {
        return $this->hasMany('App\TrainingPlanWeek')->orderBy('start_date');
    }
}
