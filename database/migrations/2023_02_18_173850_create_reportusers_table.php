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
        Schema::create('reportusers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reported_user_id');
            $table->unsignedBigInteger('report_by_user_id');
            $table->string('report',600);
            $table->foreign('reported_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('report_by_user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('reportusers');
    }
};
