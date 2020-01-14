<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrainingPlanWeekController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Request $request )
    {
        return view('training_plan_week.create')->render();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('training_plan_week.show',["id" => $id])->render();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
		$input = $request->all();

		$training_plan_week = \App\TrainingPlanWeek::find( $input["week_id"] );
	
		$training_plan_week->week_goal = $input["week_goal"];
		$training_plan_week->comment   = $input["comment"];
		
		$training_plan_week->save();
		
		return "Week Updated";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
