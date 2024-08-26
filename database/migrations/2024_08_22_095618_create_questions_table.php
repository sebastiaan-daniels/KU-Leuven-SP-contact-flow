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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('type_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('contact_id')->nullable()->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('questions')->onDelete('restrict')->onUpdate('cascade');
            $table->string('name');
            $table->string('child_question')->nullable();
            $table->boolean('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
