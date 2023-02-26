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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title', 100);
            $table->longText('desc');
            $table->tinyInteger('type')->default(0)->comment('0 => Pulic, 1 => Private, 2=> Draft');
            $table->unsignedInteger('max_edit_time')->default(86400)->after('body');

            // SEO Fields 
            $table->string('seo_title', 100)->nullable();
            $table->string('slug_url', 100);
            $table->string('meta_desc', 2500)->nullable();
            $table->string('post_number')->nullable();
            $table->timestamps();

            //creating foreign key CONSTRAINTS
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
