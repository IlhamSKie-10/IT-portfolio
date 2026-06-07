<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: create_projects_table
 *
 * Run: php artisan migrate
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->longText('long_description')->nullable();

            $table->json('tech_stack')->default('[]');

            $table->string('screenshot')->nullable();

            $table->enum('status', ['active', 'completed', 'archived'])->default('completed');
            $table->enum('type', ['erp', 'webapp', 'ai', 'other'])->default('webapp');

            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_featured')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
