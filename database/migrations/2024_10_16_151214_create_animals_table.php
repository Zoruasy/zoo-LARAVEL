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
        Schema::create('animals', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name'); // Naam van het dier
            $table->string('species'); // Soort
            $table->string('habitat'); // Habitat
            $table->string('image')->nullable(); // Afbeelding (optioneel)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps(); // Created_at en Updated_at timestamps
        });
        Schema::table('animals', function (Blueprint $table) {
            $table->string('soort')->nullable();
            $table->string('habitat')->nullable();
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
