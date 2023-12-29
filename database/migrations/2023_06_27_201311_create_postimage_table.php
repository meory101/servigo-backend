<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('postimage', function (Blueprint $table) {
            $table->id();
            $table->string('imageurl');
            $table->bigInteger('postid')->unsigned();
            $table->foreign('postid')->references('id')->on('post')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postimage');
    }
};
