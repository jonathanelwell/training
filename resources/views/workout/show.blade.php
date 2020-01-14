<?php
	use Carbon\Carbon;
	
	$workout = App\Workout::find($id);
	$display_time = "";
	$workout_type_image = "";

	$workout_type = $workout->workout_type;
	if( isset( $workout->duration_goal ) )
	{
		$display_time = $workout->duration_goal;
	}
	if( isset( $workout->duration_actual ) )
	{
		$display_time = $workout->duration_actual;
	}
	$scheduled = "";
	if( !isset( $workout->recorded ) )
	{
		$scheduled = " scheduled";
	}
	if( isset( $workout_type) )
	{
		$workout_type_image = $workout_type->image;
	}
?>
<div class="col-sm-4">
	<div class="workout_container {!! $workout_type->color . " " . $scheduled !!}" onclick="workout_edit('{!! $id !!}');">
		<div class="workout_image"><img src="{!! $workout_type_image !!}" class="{!! $workout_type->color !!}"></img></div>
		<div class="workout_content">
			<div class="workout_title">{!! $workout->title !!}</div>
			<div class="workout_duration">({!! $display_time !!})</div>
		</div>
		<div style="clear:both"></div>
	</div>
</div>