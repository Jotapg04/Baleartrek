<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('comment');
            $table->tinyInteger('score')->default(0); //valores de 0-5
            $table->enum('status', ['y','n'])->default('n'); // validación admin
            $table->foreignId('user_id')->constrained('users')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('meeting_id')->constrained('meetings')->onUpdate('restrict')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
