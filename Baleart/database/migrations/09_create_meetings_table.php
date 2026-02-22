<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trek_id')->constrained('treks')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('guide_responsible_id')->constrained('users')->onUpdate('restrict')->onDelete('restrict');
            $table->date('day');
            $table->time('time');
            $table->date("appDateIni");
            $table->date("appDateEnd");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
