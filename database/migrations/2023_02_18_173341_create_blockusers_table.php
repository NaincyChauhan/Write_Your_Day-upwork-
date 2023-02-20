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
        Schema::create('blockusers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blocked_user_id');
            $table->unsignedBigInteger('block_by_user_id');
            $table->foreign('blocked_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('block_by_user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('blockusers');
    }
};
