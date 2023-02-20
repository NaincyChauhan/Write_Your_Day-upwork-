<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followusers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('follower_user_id'); // jo user follow kar rha hain
            $table->unsignedBigInteger('following_user_id'); // jo user follow hua hain
            $table->foreign('follower_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('following_user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('followusers');
    }
};
