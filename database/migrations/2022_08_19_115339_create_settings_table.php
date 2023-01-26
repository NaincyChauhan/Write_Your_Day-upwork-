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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            // general information
            $table->string('email',400)->nullable();
            $table->string('mobile')->nullable();
            $table->text('address',1000)->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->string('favicon')->nullable();
            $table->string('dark_logo')->nullable();
            $table->string('light_logo')->nullable();
            $table->string('company_profile')->nullable();

            // SEO
            $table->string('keywords', 1000)->nullable();
            $table->string('description', 1000)->nullable();
            $table->string('title', 500)->nullable();
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
        Schema::dropIfExists('settings');
    }
};
