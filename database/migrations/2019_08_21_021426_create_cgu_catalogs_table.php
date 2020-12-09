<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCguCatalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cgu_catalogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ru_title')->nullable();
            $table->string('en_title')->nullable();
            $table->string('uz_title')->nullable();
            $table->text('ru_slug')->nullable();
            $table->text('en_slug')->nullable();
            $table->text('uz_slug')->nullable();
            $table->longText('ru_description')->nullable();
            $table->longText('en_description')->nullable();
            $table->longText('uz_description')->nullable();
            $table->string('file')->nullable();
            $table->string('video')->nullable();
            $table->string('link')->nullable();
            $table->boolean('active')->default(1);
            $table->integer('position')->default(0);
            $table->integer('category_id')->default(0);
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
        Schema::dropIfExists('cgu_catalogs');
    }
}
