<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoryDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('handbook_categories', function (Blueprint $table) {
            $table->longText('ru_description')->nullable();
            $table->longText('en_description')->nullable();
            $table->longText('uz_description')->nullable();
        });
        Schema::table('menu_items', function (Blueprint $table) {
            $table->longText('ru_description')->nullable();
            $table->longText('en_description')->nullable();
            $table->longText('uz_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('handbook_categories', function (Blueprint $table) {
            $table->dropColumn('ru_description');
            $table->dropColumn('en_description');
            $table->dropColumn('uz_description');
        });
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn('ru_description');
            $table->dropColumn('en_description');
            $table->dropColumn('uz_description');
        });
    }
}
