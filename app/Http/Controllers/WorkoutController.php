<?php
use Adriangibbons\phpFITFileAnalysis;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class WorkoutController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		echo "workout index endpoint";
		die;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Request $request )
    {
        return view('workout.edit',["id" => null, "date" => $request->input('date')])->render();
    }
	/**
     * Import workout from a Garmin FIT file.
     *
     * @param  \Illuminate\Http\Request  $request
	 * @param  $id
     * @return \Illuminate\Http\Response
     */
	public function import(Request $request, $id)
    {
		$import_file = $request->import_file;
		$garmin_FFA = new \adriangibbons\phpFITFileAnalysis( $import_file );
		$activity = $garmin_FFA->data_mesgs->session;
		
		//if ID null, create new workout based on file
		if( $id == null )
		{
			
		}
		else //otherwise update existing workout with file data
		{
			//$activity->total_timer_time;
			$data = array
			(
				"distance"			=> $activity->total_distance,
				"calories"			=> $activity->total_calories,
				"hr_average"		=> $activity->avg_heart_rate,
				"hr_max"			=> $activity->max_heart_rate,
				"elevation_gain"	=> $activity->total_distance
			);
		}

		/*
		$result = "";
		$name = $request->input('name');
		$result = "Hello $name";
        $data = $request->all(); // This will get all the request data.
		$activities_file = $request->activities_file;
		$activities_file_handle = fopen( $activities_file->path(), "r");
		
		while (($data = fgetcsv($activities_file_handle, 0, ",")) !== FALSE)
		{
			$num = count($data);
			echo "<p> $num fields in line $row: <br /></p>\n";
			$row++;
			for ($c=0; $c < $num; $c++)
			{
					echo $data[$c] . "<br />\n";
			}
		}
		fclose($activities_file_handle);
		
		return response()->json( $result );
		*/
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {	
		$input = $request->all();
		
		$workout = new \App\Workout;
		$workout->user_id 			= Auth::user()->id;
		$workout->integration_id 	= 0;
		
		$workout->fill($input);
		$workout->save();
		
		return "Workout Saved";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $as_badge)
    {
        return view('workout.show',["id" => $id, "as_badge" => $as_badge])->render();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('workout.edit', [ "id" => $id ])->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$input = $request->all();
		$workout = \App\Workout::findOrFail($id);
		
		//processes FIT file if preset - needs check for type
		$import_file = $request->import_file;
		if(isset( $import_file ) )
		{
			$garmin_FFA = new \adriangibbons\phpFITFileAnalysis( $import_file );
			$activity = $garmin_FFA->data_mesgs['session'];
			
			$data = array
			(
				"distance"			=> $activity["total_distance"],
				"calories"			=> $activity["total_calories"],
				"hr_average"		=> $activity["avg_heart_rate"],
				"hr_max"			=> $activity["max_heart_rate"],
				"elevation_gain"	=> ""
			);
			
			$workout->data = json_encode( $data );
		}
		$workout->fill($input)->save();
		return "Workout Saved";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $workout = \App\Workout::findOrFail($id);
		$workout->delete();
		return "Workout Deleted";
    }
}
