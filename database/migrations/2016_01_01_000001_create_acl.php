<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('actions'))
        {
            Schema::create('actions', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('action');
                $table->string('controller');
                $table->string('subdominio')->nullable();
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('permissions'))
        {
            Schema::create('permissions', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('action_id')->unsigned();
                $table->integer('user_id')->unsigned()->nullable();
                $table->integer('role_id')->unsigned()->nullable();
                $table->boolean('permission')->default(false);
                $table->timestamps();
            });

            Schema::table('permissions', function($table) {
                $table->foreign('action_id')->references('id')->on('actions');
            });

            Schema::table('permissions', function($table) {
                $table->foreign('user_id')->references('id')->on('users');
            });

            Schema::table('permissions', function($table) {
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
        if (Schema::hasTable('actions'))
        {
            Schema::drop('actions');
        }

        if (Schema::hasTable('permissions'))
        {
            Schema::drop('permissions');
        }
    }
}
