<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDatatypeInTblCashAdvance extends Migration
{
    public $timestamps = false;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_cashAdvance', function (Blueprint $table) {
            $table->decimal('cash_advance', 16, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_cashAdvance', function (Blueprint $table) {
            $table->integer('cash_advance')->nullable()->change();
        });
    }
}
