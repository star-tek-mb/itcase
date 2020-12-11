<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserFreelanceFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Customer fields
            $table->string('company_name')->nullable();
            $table->string('site')->nullable();
            $table->integer('foundation_year')->nullable();
            $table->string('customer_type')->nullable();

            // Contractor fields
            $table->string('gender')->nullable();
            $table->date('birthday_date')->nullable();
            $table->string('specialization')->nullable();
            $table->string('skills')->nullable();

            // Common fields
            $table->string('facebook')->nullable();
            $table->string('vk')->nullable();
            $table->string('telegram')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('instagram')->nullable();
            $table->string('phone_number')->nullable();
            $table->longText('about_myself')->nullable();
            $table->boolean('agree_personal_data_processing')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
