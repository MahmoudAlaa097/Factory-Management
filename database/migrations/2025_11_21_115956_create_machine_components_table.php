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
        Schema::create('machine_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_section_id')->constrained('machine_sections')->onDelete('cascade');
            $table->foreignId('component_type_id')->constrained('component_types')->onDelete('cascade');
            $table->string('name');
            $table->string('manufacturer')->nullable();
            $table->json('specifications')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machine_components');
    }
};
