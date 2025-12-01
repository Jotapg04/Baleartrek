<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastName');
            $table->string('dni')->unique();
            $table->string('email')->unique();
            $table->date('email_verified_at');
            $table->string('phone');
            $table->string('passwd');
            $table->foreignId('rol_id')->constrained('roles')->onDelete('cascade');
            $table->foreignId('meeting_id')->constrained('zones')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
