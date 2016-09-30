<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('accounts'))
        {
            Schema::create('accounts', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->integer('account_type')->default(1);
                $table->string('name')->nullable();
                $table->decimal('balance', 15, 2)->default('0.00');
                $table->decimal('limit', 15, 2)->default('0.00');
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        }

        if (Schema::hasTable('accounts') && Schema::hasTable('users'))
        {
            Schema::table('accounts', function ($table) {
                $table->foreign('user_id')->references('id')->on('users');
            });
        }

        if (!Schema::hasTable('honests'))
        {
            Schema::create('honests', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('account_id')->unsigned();
                $table->string('hash');
                $table->timestamps();
            });
        }

        if (Schema::hasTable('accounts') && Schema::hasTable('honests'))
        {
            Schema::table('honests', function ($table) {
                $table->foreign('account_id')->references('id')->on('accounts');
            });
        }

        if (!Schema::hasTable('transactions'))
        {
            Schema::create('transactions', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('account_id')->unsigned();
                $table->integer('transaction_type');
                $table->string('description')->nullable();
                $table->string('document')->nullable();
                $table->decimal('value', 15, 2)->default('0.00');
                $table->decimal('previous_balance', 15, 2)->default('0.00');
                $table->decimal('current_balance', 15, 2)->default('0.00');
                $table->timestamps();
            });
        }

        if (Schema::hasTable('accounts') && Schema::hasTable('transactions'))
        {
            Schema::table('transactions', function ($table) {
                $table->foreign('account_id')->references('id')->on('accounts');
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
        if (Schema::hasTable('accounts'))
        {
            Schema::drop('accounts');
        }

        if (Schema::hasTable('honests'))
        {
            Schema::drop('honests');
        }

        if (Schema::hasTable('transactions'))
        {
            Schema::drop('transactions');
        }
    }
}
