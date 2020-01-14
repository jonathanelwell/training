@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
	<pre>
	<?php

	$garmin_FFA = new adriangibbons\phpFITFileAnalysis( public_path() . "/4432470053.fit");

	//print_r($garmin_FFA->data_mesgs);
	
	$activity = $garmin_FFA->data_mesgs['session'];
	
	$data = array
	(
		"distance"			=> $activity["total_distance"],
		"calories"			=> $activity["total_calories"],
		"hr_average"		=> $activity["avg_heart_rate"],
		"hr_max"			=> $activity["max_heart_rate"],
		"elevation_gain"	=> $activity["total_distance"]
	);
	
	echo json_encode($data);
	
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
	</pre>
	
	<script type="text/javascript">
	$(document).ready( function()
	{
	});
	
</script>
</div>
@endsection
