<?php
	//=================== WORKOUT - CREATE ========================
	use Carbon\Carbon;
?>
	{!! Form::open(['url' => 'workout', 'files' => true, 'id' => 'workout_form', 'class' => 'form-horizontal']) !!}

	<div class="form-group">
		{!! Form::label('workout_type_id', 'Type', ['class' => 'col-lg-3 control-label']) !!}
		<div class="col-lg-8">
			{!! Form::select('workout_type_id', App\WorkoutType::select('id', 'name')->pluck('name', 'id'), null, ['class' => 'form-control', 'placeholder' => 'Choose workout type']) !!}
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-6">
			{!! Form::label('scheduled', 'Scheduled', ['class' => 'control-label']) !!}
			{!! Form::date('scheduled', Carbon::parse($date), ['class' => 'form-control'] ) !!}
		</div>
		<div class="form-group col-md-6">
			{!! Form::label('recorded', 'Recorded', ['class' => 'control-label']) !!}
			{!! Form::date('recorded', null, ['class' => 'form-control'] ) !!}
		</div>
	</div>
	
	<div class="form-group">
		{!! Form::label('title', 'Title', ['class' => 'col-lg-3 control-label']) !!}
		<div class="col-lg-8">
			{!! Form::text('title', null, ['class' => 'form-control']) !!}
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-6">
			{!! Form::label('duration_goal', 'Goal Duration', ['class' => 'control-label']) !!}
			{!! Form::number('duration_goal', null, ['class' => 'form-control']) !!}
		</div>
		<div class="form-group col-md-6">
			{!! Form::label('duration_actual', 'Actual Duration', ['class' => 'control-label']) !!}
			{!! Form::number('duration_actual', null, ['class' => 'form-control']) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('rating', 'Rating', ['class' => 'col-lg-3 control-label']) !!}
		<div class="col-lg-8">
			{!! Form::text('rating', null, ['class' => 'form-control']) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('comments', 'Comments', ['class' => 'col-lg-3 control-label']) !!}
		<div class="col-lg-8">
			{!! Form::textArea('comments', null, ['class' => 'form-control']) !!}
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
			var save_button = $("#modal_save");
			save_button.off();
			save_button.click( function()
			{
				workout_save(); 
			});
		});
	</script>