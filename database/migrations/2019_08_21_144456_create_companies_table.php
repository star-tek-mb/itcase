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
            $table->bigIncrements('id');
            $table->string('ru_title')->nullable();
            $table->string('en_title')->nullable();
            $table->string('uz_title')->nullable();
            $table->longText('ru_description')->nullable();
            $table->longText('en_description')->nullable();
            $table->longText('uz_description')->nullable();
            $table->string('image')->nullable();
            $table->string('bad_quality_image')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('url')->nullable();
            $table->integer('user_id')->unsigned()->default(0);
            $table->integer('active')->unsigned()->default(1);
            $table->text('phone_number')->nullable();
            $table->text('geo_location')->nullable();
            $table->text('geo_position_x')->nullable();
            $table->text('geo_position_y')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
