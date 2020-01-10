<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WorkoutAdds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workouts', function (Blueprint $table) {
            $table->text('sync_id')->after('integration_id')->nullable();
			$table->integer('integration_id')->nullable()->change();
			$table->dateTime('scheduled')->nullable()->change();
			$table->longText('data')->nullable()->change();
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
            $table->dropColumn(['sync_id']);
			$table->integer('integration_id')->nullable($value = false)->change();
			$table->dateTime('scheduled')->nullable($value = false)->change();
			$table->longText('data')->nullable($value = false)->change();
        });
    }
}
