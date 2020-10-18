<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHw2UserFollowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hw2_user_follow', function (Blueprint $table) {
            $table->id();
            $table->foreignId('follower')->references('id')->on('hw2_users');
            $table->foreignId('followed')->references('id')->on('hw2_users');
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
        Schema::dropIfExists('hw2_user_follow');
    }
}
