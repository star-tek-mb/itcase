<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoriesMenuManyToMany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('handbook_categories', function (Blueprint $table) {
            $table->dropColumn('menu_id');
        });

        Schema::create('categories_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id')->unsigned();
            $table->integer('category_id')->unsigned();
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
            $table->integer('menu_id')->nullable()->unsigned();
        });
        Schema::dropIfExists('categories_menus');
    }
}
