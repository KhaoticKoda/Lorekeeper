<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRewardKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('object_rewards', function (Blueprint $table) {
            $table->string('reward_key')->default('objectRewards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('object_rewards', function (Blueprint $table) {
            $table->dropColumn('reward_key');
        });
    }
}
