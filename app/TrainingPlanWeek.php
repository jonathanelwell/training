<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TrainingPlanWeek extends Model
{
	public function training_plan_week_type()
    {
        return $this->belongsTo('App\TrainingPlanWeekType');
    }
}
