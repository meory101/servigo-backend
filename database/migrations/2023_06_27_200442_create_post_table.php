<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::create('post', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('content', 1000);
            $table->string('date');
            $table->string('status');
            $table->integer('price')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->bigInteger('subcategoryid')->unsigned();
            $table->bigInteger('profileid')->unsigned();
            $table->foreign('profileid')->references('id')->on('profile')->onDelete('cascade');
            $table->foreign('subcategoryid')->references('id')->on('subcategory')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post');
    }
};
