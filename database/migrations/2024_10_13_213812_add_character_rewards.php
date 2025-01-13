<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCharacterRewards extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('object_rewards', function (Blueprint $table) {
            $table->string('earner_type')->default('User');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() {
        //
    }
}
