<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('machine_downtime_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->constrained('machines')->onDelete('cascade');
            $table->foreignId('fault_report_id')->constrained('fault_reports')->onDelete('cascade');
            $table->timestamp('downtime_start');
            $table->timestamp('downtime_end')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->timestamps();

            $table->index(['machine_id', 'fault_report_id', 'downtime_start']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('machine_downtime_logs');
    }
};
