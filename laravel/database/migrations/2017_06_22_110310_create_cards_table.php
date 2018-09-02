<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration {

    public function up() {
        Schema::dropIfExists('cards');
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->nullable();
            $table->integer('user_id');
            $table->string('cc');
            $table->string('name');
            $table->string('cvc');
            $table->string('expDate');
            $table->integer('status')->default(1);
            $table->integer('deleted')->default(0);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

}
