<?php /*
|--------------------------------------------------------------------------
| Web Routes 
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These 
| routes are loaded by the RouteServiceProvider within a group which 
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(); Route::get('/home', 
'HomeController@index')->name('home'); Route::get('/', function () {
    return view('home');
});
Route::get('/profile', function () {
	 return view('profile');
})->name('profile');

Route::get('/integrations', function () {
	 return view('integrations');
})->name('integrations');

Route::get('/fitness-tests', function () {
	 return view('fitness_tests');
})->name('fitness-tests');



Route::post( '/test-ajax', 'TestController@test'); 
Route::resource('training-plan', 'TrainingPlanController');

Route::get( '/training_plan_week/{id}', 'TrainingPlanWeekController@show');
Route::post( '/training_plan_week/update', 'TrainingPlanWeekController@update');
//Route::resource('training-plan-week', 'TrainingPlanWeekController');

Route::post( '/workout/import', 'WorkoutController@import');
Route::post( '/workout/{id}', 'WorkoutController@update');
Route::resource('workout', 'WorkoutController');



Route::get('/test', function () {
	 return view('test');
})->name('test');

Route::get('/debug-sentry', function () {
    
});

?>

