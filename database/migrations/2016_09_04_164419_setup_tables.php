<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('fighters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('fights', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fighter1_id')->unsigned();
            $table->integer('fighter2_id')->unsigned();
            $table->integer('rounds');
            $table->dateTime('start_date');
            $table->foreign('fighter1_id')->references('id')->on('fighters')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('fighter2_id')->references('id')->on('fighters')
                ->onUpdate('cascade')->onDelete('cascade');
            
            $table->timestamps();
        });

        Schema::create('outcomes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('description')->unique();
            $table->string('abbr')->unique();
            $table->timestamps();
        });

        Schema::create('fight_result', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fight_id')->unsigned();
            $table->foreign('fight_id')->references('id')->on('fights')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('round_no');
            $table->integer('fighter1_score');
            $table->integer('fighter2_score');
            $table->integer('outcome_id')->unsigned();
            $table->integer('winner')->unsigned();
            $table->foreign('outcome_id')->references('id')->on('outcomes')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('winner')->references('id')->on('fighters')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('predictions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->unique();
            $table->timestamps();
        });

        Schema::create('user_prediction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('fight_id')->unsigned();
            $table->integer('prediction_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('fight_id')->references('id')->on('fights')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('prediction_id')->references('id')->on('predictions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
        Schema::drop('fighters');
        Schema::drop('fights');
        Schema::drop('fight_result');
        Schema::drop('predictions');
        Schema::drop('user_prediction');
    }
}
