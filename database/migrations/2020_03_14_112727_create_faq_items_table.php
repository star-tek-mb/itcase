<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ru_question')->nullable();
            $table->string('en_question')->nullable();
            $table->string('uz_question')->nullable();
            $table->longText('ru_content')->nullable();
            $table->longText('en_content')->nullable();
            $table->longText('uz_content')->nullable();

            $table->integer('faq_group_id')->unsigned();
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
        Schema::dropIfExists('faq_items');
    }
}
