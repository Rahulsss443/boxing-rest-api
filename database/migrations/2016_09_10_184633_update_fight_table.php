<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFightTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fights', function (Blueprint $table) {
            $table->integer('custome')->unsigned()->default(0);
            $table->integer('user_id')->nullable();
        });
        Schema::table('fight_result', function ($table) {
             $table->dropForeign('fight_result_outcome_id_foreign');
             $table->dropForeign('fight_result_winner_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
