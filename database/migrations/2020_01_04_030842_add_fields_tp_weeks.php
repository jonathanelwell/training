<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsTpWeeks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('training_plan_weeks', function (Blueprint $table)
		{
            $table->integer('week_goal');
			$table->integer('week_actual');
			$table->text('comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('training_plan_weeks', function (Blueprint $table)
		{
            $table->dropColumn(['week_goal', 'week_actual', 'comment']);
        });
    }
}
