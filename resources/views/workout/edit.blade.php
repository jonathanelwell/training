<?php
	use Carbon\Carbon;
	$recorded = "";
	if( $id == "new" || $id == null || $id == "")
	{
		if( !isset($date) )
		{
			$date = date("Y-m-d");
		}
		$workout = new \App\Workout;
		$scheduled = Carbon::parse( $date );
		echo Form::open(['route' => ['workout.store'], 'files' => true, 'id' => 'workout_form', 'class' => 'form-horizontal']);
	}
	else
	{
		$workout = \App\Workout::findOrFail($id);
		$scheduled = Carbon::parse( $workout->scheduled );
		if( isset($workout->recorded) )
		{
			$recorded = Carbon::parse( $workout->recorded );
		}
		echo Form::model($workout, ['route' => ['workout.update', $workout->id], 'files' => true, 'id' => 'workout_form', 'class' => 'form-horizontal']);
	}
?>
	<div class="form-group">
		{!! Form::label('workout_type_id', 'Type', ['class' => 'col-lg-3 control-label']) !!}
		<div class="col-lg-8">
			{!! Form::select('workout_type_id', App\WorkoutType::select('id', 'name')->pluck('name', 'id'), $workout->workout_type_id ,['class' => 'form-control', 'placeholder' => 'Choose workout type']) !!}
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-6">
			{!! Form::label('scheduled', 'Scheduled', ['class' => 'control-label']) !!}
			{!! Form::date('scheduled', $scheduled, ['class' => 'form-control'] ) !!}
		</div>
		<div class="form-group col-md-6">
			{!! Form::label('recorded', 'Recorded', ['class' => 'control-label']) !!}
			{!! Form::date('recorded', $recorded, ['class' => 'form-control'] ) !!}
		</div>
	</div>
	
	<div class="form-group">
		{!! Form::label('title', 'Title', ['class' => 'col-lg-3 control-label']) !!}
		<div class="col-lg-8">
			{!! Form::text('title', $workout->title,['class' => 'form-control']) !!}
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-6">
			{!! Form::label('duration_goal', 'Goal Duration', ['class' => 'control-label']) !!}
			{!! Form::number('duration_goal', $workout->duration_goal, ['class' => 'form-control']) !!}
		</div>
		<div class="form-group col-md-6">
			{!! Form::label('duration_actual', 'Actual Duration', ['class' => 'control-label']) !!}
			{!! Form::number('duration_actual', $workout->duration_actual, ['class' => 'form-control']) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('rating', 'Rating', ['class' => 'col-lg-3 control-label']) !!}
		<div class="col-lg-8">
			{!! Form::text('rating', $workout->rating, ['class' => 'form-control']) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('comments', 'Comments', ['class' => 'col-lg-3 control-label']) !!}
		<div class="col-lg-8">
			{!! Form::textArea('comments', $workout->comments, ['class' => 'form-control']) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('import_file', 'Import FIT file', ['class' => 'col-lg-3 control-label']) !!}
		<div class="col-lg-8">
			{!! Form::file('import_file', ['class' => 'form-control-file']) !!}
		</div>
	</div>
	{!! Form::close() !!}
	<script>
		$( document ).ready(function()
		{
			var save_button = $("#workout_dialog .modal_save");
			save_button.off();
			save_button.click( function()
			{
				workout_save( {!! $workout->id !!}); 
			});
			
			var delete_button = $("#workout_dialog .modal_delete");
			delete_button.off();
			delete_button.click( function()
			{
				workout_delete( {!! $workout->id !!}); 
			});
		});
	</script>