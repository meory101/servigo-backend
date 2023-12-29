<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('profile', function (Blueprint $table) {
            $table->id();
            $table->string('teamsize')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->integer('distance')->nullable();
            $table->string('imageurl')->nullable();
            $table->string('bio')->nullable();
            $table->bigInteger('userid')->unsigned();
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('profile');
    }
};
