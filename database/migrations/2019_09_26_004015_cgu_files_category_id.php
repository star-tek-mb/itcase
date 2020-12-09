<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CguFilesCategoryId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cgu_catalogs', function (Blueprint $table) {
            $table->integer('handbook_category_id')->nullable()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cgu_catalogs', function (Blueprint $table) {
            $table->dropColumn('handbook_category_id');
        });
    }
}
