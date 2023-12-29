<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('message', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('content');
            $table->string('status')->nullable();
            $table->bigInteger('senderid')->unsigned();
            $table->bigInteger('recieverid')->unsigned();
            $table->bigInteger('roomid')->unsigned();
            $table->foreign('senderid')->references('id')->on('users');
            $table->foreign('recieverid')->references('id')->on('users');
            $table->foreign('roomid')->references('id')->on('room');
            $table->timestamps();
        });
    }

 
    public function down(): void
    {
        Schema::dropIfExists('message');
    }
};
