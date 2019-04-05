<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Initial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('account_name');
            $table->string('account_number');
            $table->text('description');
            $table->string('status')->default('Not Started');
            $table->string('work_order');
            $table->date('due_date');
            $table->timestamps();
        });

        Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('user_role');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('notes', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('user_id');
            $table->text('content');
            $table->timestamps();   

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });

        Schema::create('user_project', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('project_id');
        });

        Schema::create('tasks', function(Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->boolean('completed')->default(false);
            $table->string('title');
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->dateTime('completed_on')->nullable();
            $table->integer('user_id');
            $table->unsignedInteger('project_id');
            $table->integer('task_template_id');
            $table->timestamps();


            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });

        Schema::create('status_codes', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('hex_color');
            $table->timestamps();
        });

        Schema::create('task_templates', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('roles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('user_role', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('role_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('projects');
        Schema::drop('users');
        Schema::drop('notes');
        Schema::drop('user_project');
        Schema::drop('roles');
        Schema::drop('user_role');
        Schema::drop('tasks');
        Schema::drop('status_codes');
        Schema::drop('task_templates');
    }
}
