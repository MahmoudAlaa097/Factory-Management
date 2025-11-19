<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_type_id')->constrained('machine_types')->onDelete('cascade');
            $table->foreignId('division_id')->constrained('divisions')->onDelete('cascade');
            $table->string('number')->unique();
            $table->string('status')->default('operational');
            $table->date('last_maintenance_date')->nullable();
            $table->integer('total_running_hours')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['division_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
