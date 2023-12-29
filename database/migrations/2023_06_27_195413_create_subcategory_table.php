<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('subcategory', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->bigInteger('maincategoryid')->unsigned();
            $table->foreign('maincategoryid')->references('id')->on('maincategory')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subcategory');
    }
};
