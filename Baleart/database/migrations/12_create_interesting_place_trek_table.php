<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interesting_place_trek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trek_id')->constrained('treks')->onDelete('cascade');
            $table->foreignId('interesting_place_id')->constrained('interesting_places')->onDelete('cascade');
            $table->integer('order')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interesting_place_trek');
    }
};
