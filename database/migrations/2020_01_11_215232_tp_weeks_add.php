<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TpWeeksAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('training_plan_weeks', function (Blueprint $table) {
            $table->integer('week_scheduled')->after('week_goal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('training_plan_weeks', function (Blueprint $table) {
            $table->dropColumn('week_scheduled');
        });
    }
}
