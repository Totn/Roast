<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCafesPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cafes_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cafe_id')->unsigned()->default(0)->comment('咖啡店ID');
            $table->integer('uploaded_by')->unsigned()->default(0)->comment('上传用户ID');
            $table->text('file_url')->comment('文件路径');
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
        Schema::dropIfExists('cafes_photos');
    }
}
