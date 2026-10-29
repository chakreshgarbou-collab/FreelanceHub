<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('freelancer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('professional_title', 100);
            $table->text('bio')->nullable();
            $table->string('skills', 255)->nullable();
            $table->string('location', 100)->nullable();
            $table->decimal('hourly_rate', 8, 2)->default(0);
            $table->boolean('availability_status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('freelancer_profiles');
    }
};

