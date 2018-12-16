<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedCafeParentChildRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cafes', function (Blueprint $table)
        {
            $table->integer('parent')->unsigned()->deault(0)->after('id');
            $table->string('location_name')->default('')->after('name');
            $table->integer('roaster')->default(0)->after('longitude');
            $table->string('website')->after('roaster');
            $table->text('description')->after('website');
            $table->integer('added_by')->default(0)->unsigned()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cafes', function (Blueprint $table)
        {
            $table->dropColumn('parent');
            $table->dropColumn('location_name');
            $table->dropColumn('roaster');
            $table->dropColumn('website');
            $table->dropColumn('description');
            $table->dropColumn('added_by');
        });
    }
}
