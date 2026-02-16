<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('housings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('city');
            $table->string('address')->nullable();
            $table->unsignedInteger('price');
            $table->unsignedTinyInteger('guests');
            $table->unsignedTinyInteger('bedrooms');
            $table->unsignedTinyInteger('beds');
            $table->unsignedTinyInteger('baths');
            $table->string('image_url');
            $table->text('description')->nullable();
            $table->json('amenities')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('housings');
    }
};
