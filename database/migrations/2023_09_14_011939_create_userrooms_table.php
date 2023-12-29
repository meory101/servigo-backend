<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('userrooms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userid1')->unsigned();
            $table->bigInteger('userid2')->unsigned();
            $table->bigInteger('roomid')->unsigned();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->foreign('userid1')->references('id')->on('users');
            $table->foreign('userid2')->references('id')->on('users');
            $table->foreign('roomid')->references('id')->on('room');


            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('userrooms');
    }
};
