<?php
	//=================== TRAINING PLAN WEEK - SHOW ========================
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

<div id="week_{!! $week->id !!}" class="week_container <?php echo "$position";if( $week->start_date <= $current_date && $week->end_date >= $current_date && !$summary){echo "current";}if( $summary ){echo " summary";}?>">
	<div class="week_header" style="<?php echo $header_color; ?>">
		<div class="week_title"><?php echo $title; ?></div>
		<form class="week_form">
			<div class="week_time_container">
				<input style="display:none" name="week_id" value="{!! $week->id !!}" />
				<div class="week_time goal">
					<div class="week_time_label">Goal</div>
					<div class="week_time_value">{!! $week->week_goal !!}</div>
					<div class="week_time_input"><input name="week_goal" class="form-control" value="{!! $week->week_goal !!}" /></div>
				</div>
				<div class="week_time scheduled">
					<div class="week_time_label">Scheduled</div>
					<div class="week_time_value">{!! $week->week_scheduled !!}</div>
				</div>
				<div class="week_time actual">
					<div class="week_time_label">Actual</div>
					<div class="week_time_value">{!! $week->week_actual !!}</div>
				</div>
				<div style="clear:both"></div>
			</div>
			<div class="week_comment">{!! $week->comment !!}</div>
			<div class="week_comment_input"><input name="comment" class="form-control" value="{!! $week->comment !!}" /></div>
		</form>
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
			
			//gets all workouts with the recorded date today, or if the recorded date is null the scheduled date
			$workouts = App\Workout::whereDate( 'recorded', "=", $day->toDateString() )->orWhere( function ($query) use ($day) {
											$query->whereNull('recorded')->whereDate( 'scheduled', '=', $day->toDateString() );
										})->get();
	?>		
			<div class="day_container" >
				<div class="day_title <?php echo "$day_is_current_class"; ?>"><?php echo $day->format('D n-j'); ?></div>
				<div class="day_content">
					<div class="row" style="padding-top:3px;padding-left:10px;">
						<?php
							foreach( $workouts as $workout )
							{
								echo view('workout.show',["id" => $workout->id, "as_badge" => true])->render();
							}
						?>
						<div class="col-sm-4 workout_add" onclick="workout_create('<?php echo $day->toString(); ?>');"><span class="fa fa-plus" style="font-size:30px;padding-top:6px;"></span></div>
					</div>
					<div style="clear:both"></div>
				</div>
				<div style="clear:both"></div>
			</div>
	<?php		
		}
	?>
		
	</div>
</div>
<script type="text/javascript">
	$(document).ready( function()
	{
		
	});
</script>