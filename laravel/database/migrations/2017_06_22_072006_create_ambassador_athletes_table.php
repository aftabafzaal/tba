<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmbassadorAthletesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::dropIfExists('ambassador_athletes');
        Schema::create('ambassador_athletes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ambassador_id')->nullable();
            $table->integer('athlete_id')->nullable();
            $table->integer('subscriptionStatus')->default(0);
            $table->integer('status')->default(1);
            $table->integer('deleted')->default(0);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('ambassador_athletes');
    }

}
