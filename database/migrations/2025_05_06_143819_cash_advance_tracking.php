<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CashAdvanceTracking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('tbl_cash_advance_request', function (Blueprint $table) {
        $table->integer('group')->default(0);
    });
    Schema::table('tbl_per_diem', function (Blueprint $table) {
        $table->integer('group')->default(0);
    });

    Schema::table('tbl_transportation', function (Blueprint $table) {
        $table->integer('group')->default(0);
    });

    Schema::table('tbl_accomodation', function (Blueprint $table) {
        $table->integer('group')->default(0);
    });

    Schema::table('tbl_misc_fee', function (Blueprint $table) {
        $table->integer('group')->default(0);
    });
}

public function down()
{
    Schema::table('tbl_cash_advance_request', function (Blueprint $table) {
        $table->dropColumn('group');
    });
    Schema::table('tbl_per_diem', function (Blueprint $table) {
        $table->dropColumn('group');
    });

    Schema::table('tbl_transportation', function (Blueprint $table) {
        $table->dropColumn('group');
    });

    Schema::table('tbl_accomodation', function (Blueprint $table) {
        $table->dropColumn('group');
    });

    Schema::table('tbl_misc_fee', function (Blueprint $table) {
        $table->dropColumn('group');
    });
}

}
