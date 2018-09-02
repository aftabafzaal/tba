<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMessagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('messages', function ($table) {
            $table->dropColumn('ambassador_id');
        });
         Schema::table('messages', function ($table) {
            $table->dropColumn('athlete_id');
        });
        Schema::table('messages', function ($table) {
            $table->string('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
