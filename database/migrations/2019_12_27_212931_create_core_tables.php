<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {	
		//drops core tables if they already exist
		drop_core_tables();
		
		//user metrics
        Schema::create('user_metrics', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
			$table->integer('user_id');
			$table->integer('height');
			$table->char('height_unit', 100);
			$table->integer('weight');
			$table->char('weight_unit', 100);
			$table->integer('bmi');
        });
		Schema::table('user_metrics', function (Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users');
		});
		
		//fitness tests
		Schema::create('fitness_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
			$table->integer('user_id');
			$table->integer('box_step');
			$table->integer('climb');
			$table->integer('dips');
			$table->integer('sit_ups');
			$table->integer('pull_ups');
			$table->integer('push_ups');
			$table->integer('box_jumps');
			
        });
		Schema::table('fitness_tests', function (Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users');
		});
		
		//training plans
		Schema::create('training_plans', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id');
			$table->timestamps();
			$table->text('name');
			$table->text('description');
			$table->date('start_date');
			$table->date('end_date');
			$table->integer('weeks_transition');
			$table->integer('weeks_base');
			$table->integer('weeks_specific');
			$table->integer('weeks_taper');
        });
		Schema::table('training_plans', function (Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users');
		});
		
		//training plan weeks
		Schema::create('training_plan_week_types', function (Blueprint $table) {
            $table->increments('id');
			$table->text('name');
			$table->timestamps();
        });
		Schema::create('training_plan_week', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('training_plan_id');
			$table->integer('training_plan_week_type_id');
			$table->date('start_date');
			$table->date('end_date');
            $table->timestamps();
        });
		Schema::table('training_plan_week', function (Blueprint $table) {
			$table->foreign('training_plan_id')->references('id')->on('training_plans');
			$table->foreign('training_plan_week_type_id')->references('id')->on('training_plan_week_types');
		});

		//workouts
		Schema::create('workout_types', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id');
			$table->text('name');
			$table->text('image');
			$table->boolean('aerobic');
            $table->timestamps();
        });
		Schema::table('workout_types', function (Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users');
		});
		Schema::create('workouts', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id');
			$table->integer('integration_id');
			$table->timestamp('entered');
			$table->text('title');
			$table->integer('duration');
			$table->longtext('data');
			$table->integer('rating')->nullable();
			$table->text('comments')->nullable();
            $table->timestamps();
        });
		Schema::table('workouts', function (Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('integration_id')->references('id')->on('integrations');
		});
		
		//events
		Schema::create('event_types', function (Blueprint $table) {
            $table->increments('id');
			$table->text('name');
			$table->text('image');
			$table->timestamps();
        });
		Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('event_type_id');
			$table->integer('user_id');
			$table->text('name');
			$table->text('description');
			$table->text('image');
			$table->date('start_date');
			$table->date('end_date');
			$table->timestamps();
        });
		Schema::table('events', function (Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('event_type_id')->references('id')->on('event_types');
		});
		
		
		//integrations
		Schema::create('integration_types', function (Blueprint $table) {
            $table->increments('id');
			$table->text('name');
			$table->text('image');
			$table->timestamps();
        });
		Schema::create('integrations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
			$table->integer('user_id');
			$table->integer('integration_type_id');
			$table->text('auth_token');
			$table->integer('sync_interval');
			$table->timestamp('last_sync')->nullable();
        });
		Schema::table('integrations', function (Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('integration_type_id')->references('id')->on('integration_types');
		});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		drop_core_tables();
    }
}
function drop_core_tables()
{
	Schema::dropIfExists('user_metrics');
	Schema::dropIfExists('fitness_tests');
	
	Schema::dropIfExists('training_plans');
	Schema::dropIfExists('training_plan_week_types');
	Schema::dropIfExists('training_plan_week');
	
	Schema::dropIfExists('workout_types');
	Schema::dropIfExists('workouts');
	
	Schema::dropIfExists('event_types');
	Schema::dropIfExists('events');
	
	Schema::dropIfExists('integration_types');
	Schema::dropIfExists('integrations');
}