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
	
	$week_types = App\TrainingPlanWeekType::orderBy('id', 'asc')->get();
	$week_count = $training_plan->weeks->count();
?>
<div class="page_title"><?php echo $training_plan->name ?></div>
<div class="panel panel-default scrollbar-primary" style="width:95%;margin-left:auto;margin-right:auto;overflow-x:scroll">
	<div class="training_plan_container" style="width:<?php echo (300 * $week_count);?>px">
		<?php
			foreach( $week_types as $week_type )
			{
				$weeks_section 	= $training_plan->weeks->where("training_plan_week_type_id", $week_type->id );
				$week_number = 1;
				if (count($weeks_section) > 0 )
				{
					?>
					<div class="training_plan_week_section_container" style="width:<?php echo (300 * count($weeks_section));?>px">
						<div class="training_plan_week_section_header" style="background:<?php echo $week_type->color;?>"><?php echo $week_type->name; ?></div>
						<div class="training_plan_week_section_content">
							<?php
								foreach( $weeks_section as $week )
								{
									$position = "";
									echo view('training_plan_week',[ "id" => $week->id, "summary" => false, "position" => $position, "week_number" => $week_number ])->render();
									$week_number++;
								}
							?>
							<div style="clear:both"></div>
						</div>
					</div>
					<?php
				}
			}
		?>
	</div>
</div>

@endsection


