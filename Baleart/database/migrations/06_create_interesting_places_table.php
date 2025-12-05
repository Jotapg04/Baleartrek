<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interesting_places', function (Blueprint $table) {
            $table->id();
            $table->string('gps')->unique();
            $table->string('name');
            $table->foreignId('place_type')->constrained('place_types')->onUpdate('restrict')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interesting_places');
    }
};
