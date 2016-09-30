<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('persons'))
        {
            Schema::create('persons', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('person_type')->default(1);
                $table->string('name_first')->nullable();
                $table->string('name_last')->nullable();
                $table->char('sexo', 1)->default('M');
                $table->string('nationality')->nullable();
                $table->boolean('active')->default(true);
                $table->date('date of birth')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('adresses'))
        {
            Schema::create('adresses', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('adresse_type')->default(1);
                $table->string('country')->nullable();
                $table->string('state')->nullable();
                $table->string('street')->nullable();
                $table->string('number')->nullable();
                $table->string('complement')->nullable();
                $table->string('district')->nullable();
                $table->string('zip_code')->nullable();
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('person_adresses'))
        {
            Schema::create('person_adresses', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('person_id')->unsigned();
                $table->integer('adresse_id')->unsigned();
                $table->timestamps();
            });

            Schema::table('person_adresses', function($table) {
                $table->foreign('person_id')->references('id')->on('persons');
            });

            Schema::table('person_adresses', function($table) {
                $table->foreign('andresse_id')->references('id')->on('andresses');
            });
        }

        if (!Schema::hasTable('phones'))
        {
            Schema::create('phones', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('phone_type')->default(1);
                $table->string('number')->nullable();
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('person_phones'))
        {
            Schema::create('person_phones', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('person_id')->unsigned();
                $table->integer('phone_id')->unsigned();
                $table->timestamps();
            });

            Schema::table('person_phones', function($table) {
                $table->foreign('person_id')->references('id')->on('persons');
            });

            Schema::table('person_phones', function($table) {
                $table->foreign('phone_id')->references('id')->on('phones');
            });
        }

        if (!Schema::hasTable('documents'))
        {
            Schema::create('documents', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('document_type')->default(1);
                $table->string('value')->nullable();
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('person_documents'))
        {
            Schema::create('person_documents', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('person_id')->unsigned();
                $table->integer('document_id')->unsigned();
                $table->timestamps();
            });

            Schema::table('person_documents', function($table) {
                $table->foreign('person_id')->references('id')->on('persons');
            });

            Schema::table('person_documents', function($table) {
                $table->foreign('document_id')->references('id')->on('documents');
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
        if (Schema::hasTable('persons'))
        {
            Schema::drop('persons');
        }

        if (Schema::hasTable('adresses'))
        {
            Schema::drop('adresses');
        }

        if (Schema::hasTable('person_adresses'))
        {
            Schema::drop('person_adresses');
        }

        if (Schema::hasTable('phones'))
        {
            Schema::drop('phones');
        }

        if (Schema::hasTable('documents'))
        {
            Schema::drop('documents');
        }
    }
}
