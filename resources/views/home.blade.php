@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
				<?php  
					use Carbon\Carbon;
					$week = DB::table('training_plan_weeks')
					->join('training_plans', 'training_plan_weeks.training_plan_id', '=', 'training_plans.id')
					->join('training_plan_week_types', 'training_plan_weeks.training_plan_week_type_id', '=', 'training_plan_week_types.id')
					->select('training_plan_weeks.*', 'training_plans.name AS training_plan_name','training_plan_week_types.name AS week_type_name')
					->where
					([
						['training_plan_weeks.start_date', '<=',  Carbon::now()->toDateString() ],
						['training_plan_weeks.end_date', '>=',  Carbon::now()->toDateString() ]
					])->first();
					
					$training_plan_url = route('training-plan', ['id' => $week->training_plan_id]);
					
				?>
                <div class="panel-heading">Training Plan: <?php echo $week->training_plan_name; ?><div style="margin-left: 20px;" class="btn btn-sm btn-primary" onclick="location='<?php echo $training_plan_url; ?>'">View Plan</div></div>
                <div class="panel-body">
                   <?php
						if( isset($week) )
						{
							//print_r( $week );
							?>
								<div class="week_container summary">
									<div class="week_header">
										
										<div class="week_title"><?php echo $week->week_type_name . " - Week " . "1"; ?></div>
										<div class="week_goal"><?php echo "Goal|Actual: " . $week->week_goal . "|" . $week->week_actual; ?></div>
										<div class="week_comment"><?php echo $week->comment; ?></div>
									</div>
								</div>
							
							<?
							
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
                <div class="panel-heading">Recent Workouts</div>
                <div class="panel-body">
					<div class="workouts_actions">
						<div class="btn btn-primary">Add Workout</div>
					</div>
					<div class="workouts_listing">
						<?php
							$workouts = App\Workout::orderBy('recorded', 'desc')->take(5)->get();
							foreach ($workouts as $workout)
							{
								echo $workout->title;
							}
						?>
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
