<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TendersBudgetStringField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $t = DB::table('tenders')->get();
        foreach ($t as $user) {
            DB::table('tenders')
                ->where('id', $user->id)->update(['budget' => intval($user->budget)]);
        }
        Schema::table('tenders', function (Blueprint $table) {
            $table->bigInteger('budget')->change();
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
            $table->string('budget')->change();
        });
    }
}
