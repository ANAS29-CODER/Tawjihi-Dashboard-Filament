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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name')->required();
            $table->string('file_link')->nullable();
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade')->required();
            $table->foreignId('section_id')->constrained('sections') ->onDelete('cascade')->required();
            $table->string('file')->nullable();
            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
