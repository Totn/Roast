<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('城市名称');
            $table->string('state')->default('')->comment('省份名称');
            $table->string('country')->default('')->comment('国家名称');
            $table->string('slug')->default('')->comment('');
            $table->decimal('latitude', 11, 8)->default(0.0)->comment('坐标轴纬度');
            $table->decimal('longitude', 11, 8)->default(0.0)->comment('坐标轴经度');
            $table->decimal('radius', 4, 2)->default(0.0)->comment('范围，占地大小');
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
        Schema::dropIfExists('cities');
    }
}
