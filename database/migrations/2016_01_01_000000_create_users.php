<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users'))
        {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->boolean('active')->default(true);
                $table->rememberToken();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('password_resets'))
        {
            Schema::create('password_resets', function (Blueprint $table) {
                $table->string('email')->index();
                $table->string('token')->index();
                $table->timestamp('created_at');
            });
        }

        if (!Schema::hasTable('roles'))
        {
            Schema::create('roles', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('role_user'))
        {
            Schema::create('role_user', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->integer('role_id')->unsigned();
                $table->timestamps();
            });

            Schema::table('role_user', function($table) {
                $table->foreign('user_id')->references('id')->on('users');
            });

            Schema::table('role_user', function($table) {
                $table->foreign('role_id')->references('id')->on('roles');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('users'))
        {
            Schema::drop('users');
        }

        if (Schema::hasTable('password_resets'))
        {
            Schema::drop('password_resets');
        }

        if (Schema::hasTable('roles'))
        {
            Schema::drop('roles');
        }

        if (Schema::hasTable('role_user'))
        {
            Schema::drop('role_user');
        }
    }
}
