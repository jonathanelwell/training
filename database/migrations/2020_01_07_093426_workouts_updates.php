<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WorkoutsUpdates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workouts', function (Blueprint $table) {
			$table->integer('workout_type_id')->after('user_id');
            $table->timestamp('scheduled')->after('integration_id')->nullable();
			$table->renameColumn('entered', 'recorded')->nullable();
			
			$table->foreign('workout_type_id')->references('id')->on('workout_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workouts', function (Blueprint $table) {
			$table->renameColumn('recorded', 'entered');
            $table->dropColumn(['workout_type_id', 'scheduled']);
        });
    }
}
