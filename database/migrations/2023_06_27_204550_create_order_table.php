<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->bigInteger('subcategoryid')->unsigned();
            $table->bigInteger('buyerid')->unsigned();
            $table->bigInteger('sellerid')->unsigned();
            $table->bigInteger('mediatorid')->unsigned()->nullable();
            $table->foreign('subcategoryid')->references('id')->on('subcategory')->onDelete('cascade');
            $table->foreign('buyerid')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sellerid')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('mediatorid')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
