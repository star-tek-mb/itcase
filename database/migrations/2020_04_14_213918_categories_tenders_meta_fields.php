<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoriesTendersMetaFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('handbook_categories', function (Blueprint $table) {
            $table->string('tender_meta_title_prefix')->nullable();
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
            $table->dropColumn('tender_meta_title_prefix');
        });
    }
}
