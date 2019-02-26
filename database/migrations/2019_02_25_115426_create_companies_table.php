<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('公司名称');
            $table->integer('roaster')->default(0)->comment('是否烘焙店');
            $table->text('website')->comment('公司网址');
            $table->text('logo')->comment('公司Logo图片地址');
            $table->text('description')->comment('公司简介信息');
            $table->integer('added_by')->unsigned()->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('companies');
    }
}
