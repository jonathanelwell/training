<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WorkoutsChangeDuration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workouts', function (Blueprint $table) {
			$table->integer('duration_goal')->before('duration')->nullable();
			$table->renameColumn('duration', 'duration_actual')->nullable();
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
             $table->dropColumn('duration_goal');
			 $table->renameColumn('duration_actual', 'duration');
        });
    }
}
