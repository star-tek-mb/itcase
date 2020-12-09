<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCguCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cgu_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ru_title')->nullable();
            $table->string('en_title')->nullable();
            $table->string('uz_title')->nullable();
            $table->string('ru_slug')->nullable();
            $table->string('en_slug')->nullable();
            $table->string('uz_slug')->nullable();
            $table->string('image')->nullable();
            $table->integer('position')->default(0);

            $table->nestedSet();
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
        Schema::dropIfExists('cgu_categories');
    }
}
