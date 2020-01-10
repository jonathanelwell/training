<?php
	use Carbon\Carbon;
	$current_date = Carbon::now()->toDateString();
		
	$week 		   = App\TrainingPlanWeek::find($id);
	$training_plan = App\TrainingPlan::find( $week->training_plan_id );
	
	//generates an array of days within the week
	$days = array();
	$current_day = Carbon::parse( $week->start_date );
	$end_date    = Carbon::parse( $week->end_date );
	while ( $current_day <= $end_date )
	{
		array_push( $days, $current_day->copy() );
		$current_day->addDays(1);
	}
	//$week_number = 0;
	
	$header_color = "";
	$title = "Week " . ($week_number);
	if( $summary )
	{
		$title = $week->training_plan_week_type->name . " " . $title;
		$header_color = " background: " . $week->training_plan_week_type->color;
	}
?>

<div class="week_container <?php echo "$position";if( $week->start_date <= $current_date && $week->end_date >= $current_date && !$summary){echo "current";}if( $summary ){echo " summary";}?>">
	<div class="week_header" style="<?php echo $header_color; ?>">
		<div class="week_title"><?php echo $title; ?></div>
		<div class="week_goal"><?php echo "Goal | Actual:   " . $week->week_goal . " | " . $week->week_actual; ?></div>
		<div class="week_comment"><?php echo $week->comment; ?></div>
	</div>
	<div class="week_content">
	<?php
		foreach( $days as $day_number=>$day )
		{
			$day_is_current_class = "";
			if( $day->toDateString() == $current_date)
			{
				$day_is_current_class = "current";
			}
			
			$workouts = App\Workout::whereDate( 'scheduled', '=', $day->toDateString() )->orWhereDate('recorded', '=', $day->toDateString())->get()
	?>		
			<div class="day_container" >
				<div class="day_title <?php echo "$day_is_current_class"; ?>"><?php echo $day->format('D n-j'); ; ?></div>
				<div class="day_content">
					<?php
						foreach( $workouts as $workout )
						{
							echo view('workout',["id" => $workout->id])->render();
						}
					?>
					<div style="clear:both"></div>
				</div>
				<div style="clear:both"></div>
			</div>
	<?php		
		}
	?>
		
	</div>
</div>