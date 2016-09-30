<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('menus'))
        {
            Schema::create('menus', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('parent_id')->nullable();
                $table->integer('order')->default(1);
                $table->string('name');
                $table->string('route');
                $table->string('grupo');
                $table->boolean('active')->default(true);
                $table->timestamps();
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
        if (Schema::hasTable('menus'))
        {
            Schema::drop('menus');
        }
    }
}
