<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Request $request)
    {
        $data = $request->all(); // This will get all the request data.
		return response()->json($data );
    }
}
