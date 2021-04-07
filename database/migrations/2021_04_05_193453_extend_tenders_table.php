<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtendTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenders', function (Blueprint $table) {
            $table->string('delete_reason')->nullable();
            $table->string('place')->nullable();
            $table->date('work_start_at')->nullable();
            $table->date('work_end_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tenders', function (Blueprint $table) {
            $table->dropColumn('delete_reason');
            $table->dropColumn('place');
            $table->dropColumn('work_start_at');
            $table->dropColumn('work_end_at');
        });
    }
}
