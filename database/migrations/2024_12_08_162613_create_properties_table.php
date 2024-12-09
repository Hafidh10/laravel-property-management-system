<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable(); // Add image column
            $table->decimal('price', 10, 2); // Add price column
            $table->integer('bedrooms'); // Add bedrooms column
            $table->string('title'); // Add title column
            $table->text('description')->nullable(); // Add description column
            $table->string('address'); // Add address column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
