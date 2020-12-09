<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenderRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tender_requests', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('tender_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('budget_from')->nullable();
            $table->string('budget_to')->nullable();
            $table->string('period_from')->nullable();
            $table->string('period_to')->nullable();
            $table->string('comment')->nullable();

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
        Schema::dropIfExists('tender_requests');
    }
}
