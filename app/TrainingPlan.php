<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingPlan extends Model
{
    public function weeks()
    {
        return $this->hasMany('App\TrainingPlanWeek')->orderBy('start_date');
    }
	public function scopeTransition(Builder $query)
	{
		return $query->where('training_plan_week_type_id', 1);
	}
	public function scopeBase(Builder $query)
	{
		return $query->where('training_plan_week_type_id', 2);
	}
	public function scopeSpecific(Builder $query)
	{
		return $query->where('training_plan_week_type_id', 3);
	}
	public function scopeTaper(Builder $query)
	{
		return $query->where('training_plan_week_type_id', 4);
	}
}
