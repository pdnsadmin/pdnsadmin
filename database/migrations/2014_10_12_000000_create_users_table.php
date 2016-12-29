<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->tinyInteger('group_id')->default(0);
            $table->tinyInteger('is_root')->default(0);
            $table->tinyInteger('active')->default(1);
            $table->integer('ttl')->default(3600);
            $table->string('phone')->nullable();
            $table->string('jobtitle')->nullable();
            $table->text('biography')->nullable();
            $table->text('signature')->nullable();
            $table->string('location')->nullable();
            $table->text('overview')->nullable();
            $table->text('permission')->nullable();
            $table->string('avatar')->nullable();
            $table->text('notes')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
