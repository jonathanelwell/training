<?php

	use Carbon\Carbon;
	
	
	
	$start_date = Carbon::parse( $training_plan->start_date );
	$end_date   = Carbon::parse( $training_plan->start_date );
	$end_date->addDays(6);
	
	for( $wt=1; $wt<=$training_plan->weeks_transition; $wt++ )
	{
		$training_plan_week = new App\TrainingPlanWeek;
		$training_plan_week->training_plan_id = $training_plan->id;
		$training_plan_week->training_plan_week_type_id = 1;
		$training_plan_week->start_date = $start_date;
		$training_plan_week->end_date   = $end_date;
		
		$training_plan_week->save();
		
		//increments the start dates for the next loop
		$start_date->addDays(7);
		$end_date->addDays(7);
	}
	for( $wb=1; $wb<=$training_plan->weeks_base; $wb++ )
	{
		$training_plan_week = new App\TrainingPlanWeek;
		$training_plan_week->training_plan_id = $training_plan->id;
		$training_plan_week->training_plan_week_type_id = 2;
		$training_plan_week->start_date = $start_date;
		$training_plan_week->end_date   = $end_date;
		
		$training_plan_week->save();
		
		//increments the start dates for the next loop
		$start_date->addDays(7);
		$end_date->addDays(7);
	}
	for( $ws=1; $ws<=$training_plan->weeks_specific; $ws++ )
	{
		$training_plan_week = new App\TrainingPlanWeek;
		$training_plan_week->training_plan_id = $training_plan->id;
		$training_plan_week->training_plan_week_type_id = 3;
		$training_plan_week->start_date = $start_date;
		$training_plan_week->end_date   = $end_date;
		
		$training_plan_week->save();
		
		//increments the start dates for the next loop
		$start_date->addDays(7);
		$end_date->addDays(7);
	}
	for( $wtp=1; $wtp<=$training_plan->weeks_taper; $wtp++ )
	{
		$training_plan_week = new App\TrainingPlanWeek;
		$training_plan_week->training_plan_id = $training_plan->id;
		$training_plan_week->training_plan_week_type_id = 4;
		$training_plan_week->start_date = $start_date;
		$training_plan_week->end_date   = $end_date;
		
		$training_plan_week->save();
		
		//increments the start dates for the next loop
		$start_date->addDays(7);
		$end_date->addDays(7);
	}
	
?>