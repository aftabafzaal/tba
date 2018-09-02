<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayflowProfilesTable extends Migration {

    public function up() {
        Schema::dropIfExists('payflow_profiles');
        Schema::create('payflow_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id');
            $table->string('profileId');
            $table->string('rpref');
            $table->string('message');
            $table->integer('status')->default(1);
            $table->integer('deleted')->default(0);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    public function down() {
        //
    }

}
