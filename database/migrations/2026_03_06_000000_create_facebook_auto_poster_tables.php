<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Schema;

class CreateFacebookAutoPosterTables extends Migration
{
    public function up()
    {
        Schema::create('facebook_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('facebook_id')->unique();
            $table->timestamps();
        });

        Schema::create('facebook_pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->string('page_id')->unique();
            $table->string('name');
            $table->timestamps();
            $table->foreign('profile_id')->references('id')->on('facebook_profiles')->onDelete('cascade');
        });

        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('task_pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('page_id');
            $table->timestamps();
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('page_id')->references('id')->on('facebook_pages')->onDelete('cascade');
        });

        Schema::create('task_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->string('status');
            $table->timestamps();
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        });

        Schema::create('proxies', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->string('port');
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_logs');
        Schema::dropIfExists('task_pages');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('contents');
        Schema::dropIfExists('facebook_pages');
        Schema::dropIfExists('facebook_profiles');
        Schema::dropIfExists('proxies');
        Schema::dropIfExists('settings');
    }
}
