<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskLogsTable extends Migration
{
    public function up()
    {
        Schema::create('task_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('log_message')->nullable();
            $table->text('error_message')->nullable();
            $table->string('response_code')->nullable();
            $table->json('response_data')->nullable();
            $table->timestamps();
            
            $table->index('task_id');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_logs');
    }
}
