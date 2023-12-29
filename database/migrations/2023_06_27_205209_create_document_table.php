<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('document', function (Blueprint $table) {

            $table->id();
            $table->string('startuptime');
            $table->string('deliverytime');
            $table->boolean('isapprov');
            $table->integer('price');
            $table->string('createrid')->nullable();
            $table->string('title', 100);
            $table->string('content', 1000);
            $table->string('worklocation')->nullable();
            $table->bigInteger('orderid')->unsigned();
            $table->foreign('orderid')->references('id')->on('order')->onDelete('cascade');
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document');
    }
};
