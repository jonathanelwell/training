@extends('layouts.app')

@section('content')
<?php
	use Carbon\Carbon;
	
	$training_plan = App\TrainingPlan::find($id);
	
	if( Auth::user()->id != $training_plan->user_id )
	{
		die("Sorry, you do not have permission to access this training plan");
	}
	
	$start_date = Carbon::parse( $training_plan->start_date );
	$end_date   = Carbon::parse( $training_plan->start_date );
	
	$weeks = $training_plan->weeks;
	$current_date = Carbon::now()->toDateString();
?>
<div class="page_title"><?php echo $training_plan->name ?></div>
<div class="panel panel-default scrollbar-primary" style="width:95%;margin-left:auto;margin-right:auto;overflow-x:scroll;padding-bottom:20px">
	<div class="panel-body training_plan_container" style="width:<?php echo (302 * count($weeks));?>px">
		<?php
			foreach( $weeks as $week_number=>$week )
			{			
				switch( $week_number )
				{
					case 0:
						$index_class = "first";
					break;
					case ( count($weeks) - 1 ):
						$index_class = "last";
					break;
					default:
						$index_class = "";
					break;
				}
				$week_is_current_class = "";
				if( $week->start_date <= $current_date && $week->end_date >= $current_date)
				{
					$week_is_current_class = "current";
				}
				
				//generates an array of days within the week
				$days = array();
				$current_day = Carbon::parse( $week->start_date );
				$end_date    = Carbon::parse( $week->end_date );
				while ( $current_day <= $end_date )
				{
					array_push( $days, $current_day->copy() );
					$current_day->addDays(1);
				}
		?>
				<div class="week_container <?php echo "$week_is_current_class $index_class"; ?>">
					<div class="week_header">
						<div class="week_title">Week <?php echo $week_number + 1; ?></div>
						<div class="week_goal"><?php echo "Goal|Actual: " . $week->week_goal . "|" . $week->week_actual; ?></div>
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
							
							$workouts = App\Workout::whereDate( 'recorded', '=', $day->toDateString() )->whereNotNull('recorded')->get()
					?>		
							<div class="day_container <?php echo "$day_is_current_class"; ?>" >
								<div class="day_title"><?php echo $day->format('D n-j'); ; ?></div>
								<div class="day_content">
									<?php
										foreach( $workouts as $workout )
										{
											$display_time = "";
											$workout_type_image = "";
											
											$workout_type = $workout->workout_type;
											if( isset( $workout->duration ) )
											{
												$display_time = $workout->duration;
												//$display_time = Carbon::createFromTime(0, $workout->duration, 0)->toTimeString();
											}
											if( isset( $workout_type) )
											{
												$workout_type_image = $workout_type->image;
											}
										
									?>		
										<div class="workout_container">
											<div class="workout_image"><img src="<?php echo $workout_type_image; ?>"></img></div>
											<div class="workout_content">
												<div class="workout_title"><?php echo $workout->title; ?></div>
												<div class="workout_duration"><?php echo "(" . $display_time . ")"; ?></div>
											</div>
											<div style="clear:both"></div>
										</div>
									<?php
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
		<?php
			}
		?>
	</div>
</div>

@endsection


