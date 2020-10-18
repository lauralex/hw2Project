<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHw2PostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hw2_posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("post_title");
            $table->string("post_url");
            $table->dateTime("date");
            $table->integer("likes");
            $table->string("url_yt");
            $table->string("url_an");
            $table->foreignId("hw2_user_id")->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hw2_posts');
    }
}
