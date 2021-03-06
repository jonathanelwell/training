@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
				<?php  
					use Carbon\Carbon;
					
					$week = App\TrainingPlanWeek::where
					([
						['start_date', '<=',  Carbon::now()->toDateString() ],
						['end_date', '>=',  Carbon::now()->toDateString() ]
					])->first();
					
					$weeks_in_section = App\TrainingPlanWeek::where([
						['training_plan_id', 		   $week->training_plan_id],
						['training_plan_week_type_id', $week->training_plan_week_type_id]
						])->orderBy("start_date")->get();
					
					$week_number = 1;
					foreach( $weeks_in_section as $week_to_check )
					{
						if( $week_to_check->is( $week_to_check ) )
						{
							break;
						}
						$week_number++;
					}
						
					$training_plan_url = route('training-plan.show', ['id' => $week->training_plan_id]);
					
				?>
                <div class="panel-heading">Training Plan: <?php echo $week->training_plan_name; ?><div style="margin-left: 20px;" class="btn btn-sm btn-primary" onclick="location='<?php echo $training_plan_url; ?>'">View Plan</div></div>
                <div class="panel-body">
                   <?php
						if( isset($week) )
						{
							echo view('training_plan_week.show',[ "id" => $week->id, "summary" => true, "position" => "", "week_number" => $week_number ])->render();
						}
						else
						{
							echo "No current week found";
						}
					?>
                </div>
            </div>
        </div>
		<div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
					Recent Workouts
					<div class="btn btn-sm btn-primary"  style="margin-left: 20px;">Add Workout</div>
				</div>
                <div class="panel-body">
					<div class="workouts_actions">
						
					</div>
					<div class="workouts_listing">
						<div class="row1">
							<?php
								$workouts = App\Workout::orderBy('recorded', 'desc')->take(5)->get();
								foreach ($workouts as $workout)
								{
									echo view('workout.show',["id" => $workout->id, "as_badge" => true])->render();
								}
							?>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
	<div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading"></div>
                <div class="panel-body">
                    
					
                </div>
            </div>
        </div>
		<div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">Upcoming Events</div>
                <div class="panel-body">
                    

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
