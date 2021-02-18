<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('client_type');
            $table->string('client_name');
            $table->string('client_email')->nullable();
            $table->string('client_phone_number');
            $table->string('client_company_name')->nullable();
            $table->string('client_site_url')->nullable();

            $table->string('title');
            $table->longText('description');
            $table->bigInteger('budget')->default(0);
            $table->date('deadline');

            $table->string('target_audience')->nullable();
            $table->string('links')->nullable();
            $table->string('additional_info')->nullable();
            $table->string('other_info')->nullable();
            $table->string('what_for')->nullable();
            $table->string('type')->nullable();

            $table->string('slug');
            $table->boolean('opened')->default(true);

            $table->integer('need_id')->nullable();
            $table->text('geo_location')->nullable();
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
        Schema::dropIfExists('tenders');
    }
}
