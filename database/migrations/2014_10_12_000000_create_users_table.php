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
        Schema::create('users', function (Blueprint $table) {
            // Basice Informations
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('username')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->date('dob')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->tinyInteger('status')->default(1);

            $table->string('image',300)->nullable();
            $table->string('thought_of_the_day',200)->nullable();
            $table->string('website')->nullable();
            $table->tinyInteger('gender')->default(1)->comment("0 => other, 1 => Male, 2 => Female")->nullable();
            $table->tinyInteger('phone_verified')->default(0)->comment("0 => Not Verify, 1 => Verify");
            $table->longText('bio')->nullable();
            $table->timestamp('delete_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
