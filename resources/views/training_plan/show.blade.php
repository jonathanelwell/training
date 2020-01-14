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
	$weeks 	= $training_plan->weeks;
	$week_count = count($weeks);
	
	foreach( $weeks as $week )
	{
		$week->week_scheduled = App\Workout::whereBetween('scheduled', [Carbon::parse($week->start_date), Carbon::parse($week->end_date)->setTime(23,59,59)] )->sum('duration_goal');
		$week->week_actual = App\Workout::whereBetween('recorded', [Carbon::parse($week->start_date), Carbon::parse($week->end_date)->setTime(23,59,59)] )->sum('duration_actual');
		$week->save();
	}
	
	
?>
<div class="page_title"><?php echo $training_plan->name ?></div>
<div id="training_plan_container" class="panel panel-default scrollbar-primary" style="width:95%;margin-left:auto;margin-right:auto;overflow-x:scroll">
	<div class="training_plan_content" style="width:<?php echo (300 * $week_count);?>px">
		<?php
			foreach( $week_types as $week_type )
			{
				$weeks_section 	= $training_plan->weeks->where("training_plan_week_type_id", $week_type->id );
				$week_number = 1;
				if (count($weeks_section) > 0 )
				{
					?>
					<div class="training_plan_week_section_container" style="width:<?php echo (300 * count($weeks_section));?>px">
						<div class="training_plan_week_section_header" style="background:<?php echo $week_type->color;?>">
							<span class="title">{!! $week_type->name !!}</span>
						</div>
						<div class="training_plan_week_section_content">
							<?php
								foreach( $weeks_section as $week )
								{
									$position = "";
									echo view('training_plan_week.show',[ "id" => $week->id, "summary" => false, "position" => $position, "week_number" => $week_number ])->render();
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
<div id="workout_dialog"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="workout_dialog_title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" syle="width: 90%" id="workout_dialog_title">Workout</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="modal_save btn btn-primary">Save</button>
		<button type="button" class="modal_delete btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>
<script>
	$( document ).ready(function()
	{
		var training_plan_container = $("#training_plan_container");
		var week_position = $(".week_container.current").position();
		
		training_plan_container.scroll(function()
		{
			var center_h = Math.floor( training_plan_container.scrollLeft() / 2);
			//$( ".training_plan_week_section_header .title" ).animate( {left: center_h - 200}, 0 );
		});
		
		training_plan_container.animate({scrollLeft: week_position.left - 300}, 500);
		
		$(".week_time_value").click(function ()
		{
			var value_node = $(this);
			var input_node = value_node.parent().find(".week_time_input");

			value_node.hide();
			input_node.show();
			input_node.find("input").focus();
		});
		$(".week_comment").click(function ()
		{
			var value_node = $(this);
			var input_node = value_node.parent().find(".week_comment_input");

			value_node.hide();
			input_node.show();
			input_node.find("input").focus();
		});
		
		$(".week_comment_input input").blur(function ()
		{
			var input_node = $(this);
			var value_node = input_node.parent().parent().find(".week_comment");
			
			input_node.parent().hide();
			value_node.show();
			
			training_plan_week_save( value_node.closest(".week_form") );
		});
		
		
		$(".week_time_input input").blur(function ()
		{
			var input_node = $(this);
			var value_node = input_node.parent().parent().find(".week_time_value");
			
			input_node.parent().hide();
			value_node.show();
			
			training_plan_week_save( value_node.closest(".week_form") );
		});
		
	});
	
</script>
@endsection


