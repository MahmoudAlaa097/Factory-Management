<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\WorkOrderType;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('machine_id')->nullable()->constrained('machines')->nullOnDelete();
            $table->foreignId('logged_by')->constrained('employees')->cascadeOnDelete();

            $table->enum('type', array_column(WorkOrderType::cases(), 'value'));
            $table->date('date');
            $table->unsignedInteger('duration_minutes');

            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->text('notes')->nullable();

            // -- preventive only
            $table->string('maintenance_type')->nullable();

            // -- task only
            $table->string('task_title')->nullable();
            $table->string('task_tag')->nullable();
            $table->nullableMorphs('requester');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['date', 'type']);
            $table->index('task_tag');
            $table->index('machine_id');
            $table->index('logged_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
