@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
	<?php
	$training_plan = App\TrainingPlan::find(1);
	$weeks_section 	= $training_plan->weeks->where("training_plan_week_type_id", 4 );
	var_dump($weeks_section);
	
	/*
		use Carbon\Carbon;
		if ( ( $activities_file_handle = fopen( public_path() . "/activities.csv", "r") ) !== FALSE )
		{
			while ( ($data = fgetcsv( $activities_file_handle, 0, "," ) ) !== FALSE)
			{
				//echo "<pre>";
				$workout = new App\Workout;
				$workout->user_id 			= Auth::user()->id;
				$workout->workout_type_id 	= $data[0];
				$workout->integration_id 	= 0;
				$workout->recorded 			= Carbon::parse( $data[1] );
				$workout->title 			= $data[2];
				
				$time_parts = explode( ":", $data[5] );
				//$time_parts = explode( ":", "1:06:27" );
				$minutes = ( intval($time_parts[0]) * 60 ) + ( intval($time_parts[1]) );
				$workout->duration  		= $minutes;
				
				$workout_data = array
				(
					"distance" 		 => $data[3],
					"calories" 		 => $data[4],
					"hr_average" 	 => $data[6],
					"hr_max" 		 => $data[7],
					"elevation_gain" => $data[8],
				);
				$workout->data = json_encode( $workout_data );
				
				//print_r($workout);
				$workout->save();
				//echo "</pre>";
			}
			fclose($activities_file_handle);
		}
		*/
	?>

	<form id="form_workout_import" class="form-horizontal" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="input-row">
			<input type="text" name="name"></input>
			<label class="col-md-4 control-label">Choose CSV File</label>
			<input type="file" name="activities_file" id="activities_file" accept=".csv">
			<button type="button" id="submit" name="import" class="btn-submit" onclick="workouts_import()">Import AJAX</button>
			<br />
		</div>
	</form>
	<script type="text/javascript">
	$(document).ready( function()
	{
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	});
	function workouts_import()
	{
		var import_form = document.getElementById('form_workout_import');
		var import_form_data = new FormData(import_form);
		
		//submits the ticket
		$.ajax
		({ 
			url: "/workout/import",
			data: import_form_data,
			processData: false,
			contentType: false,
			type: 'POST',
			success: function( result )
			{
				console.log("RESULTS\n");
				console.log( result );
				console.log( "END\n" );
			}
		});
	}
</script>
</div>
@endsection
