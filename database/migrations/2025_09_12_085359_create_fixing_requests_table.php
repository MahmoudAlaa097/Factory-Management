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
        Schema::create('fixing_requests', function (Blueprint $table) {
            $table->id();

            // Request details
            $table->timestamp('requested_at')->useCurrent();
            $table->enum('shift', ['1','2','3']);
            $table->foreignId('division_id')->constrained()->onDelete('cascade');
            $table->foreignId('operator_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('machine_id')->constrained()->onDelete('cascade');
            $table->enum('machine_status', ['running','stopped']);

            // Technician assignment
            $table->foreignId('technician_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('received_at')->nullable();

            // Maintenance details
            $table->timestamp('fixed_at')->nullable();
            $table->integer('time_taken')->nullable()->comment('Time taken in minutes');
            $table->foreignId('part_id')->nullable()->constrained('machine_parts')->onDelete('set null');
            $table->foreignId('malfunction_id')->nullable()->constrained('machine_malfunctions')->onDelete('set null');

            // Status tracking
            $table->enum('status', ['open','in_progress','fixed','closed'])->default('open');
            $table->boolean('confirmed_by_operator')->default(false);
            $table->boolean('ack_supervisor')->default(false);
            $table->boolean('ack_engineer')->default(false);
            $table->timestamp('closed_at')->nullable();

            // Laravel timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixing_requests');
    }
};
