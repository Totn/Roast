<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBrewMethodsIcon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brew_methods', function (Blueprint $table) {
            $table->string('icon')->default('')->after('method')->comment('冲泡方法icon图标');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brew_methods', function (Blueprint $table) {
            //
        });
    }
}
