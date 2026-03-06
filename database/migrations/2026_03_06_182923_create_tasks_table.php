<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('facebook_pages')->onDelete('cascade');
            $table->foreignId('content_id')->constrained('contents')->onDelete('cascade');
            $table->dateTime('scheduled_at');
            $table->enum('frequency', ['once', 'daily', 'weekly', 'monthly'])->default('once');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->timestamp('executed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->integer('retry_count')->default(0);
            $table->timestamps();
            
            $table->index('page_id');
            $table->index('status');
            $table->index('scheduled_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}