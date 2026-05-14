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

            $table->foreignId('machine_id')->constrained('machines')->cascadeOnDelete();
            $table->foreignId('logged_by')->constrained('employees')->cascadeOnDelete();

            $table->enum('type', array_column(WorkOrderType::cases(), 'value'));

            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->text('notes')->nullable();

            // -- preventive only
            $table->string('maintenance_type')->nullable();
            $table->boolean('is_finished')->nullable();

            // -- task only
            $table->string('task_title')->nullable();
            $table->foreignId('division_id')->nullable()->constrained('divisions')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['machine_id', 'type']);
            $table->index('logged_by');
            $table->index('start_time');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
