<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectReferenceIdToExistingTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add column to tbl_cash_advance_request
        Schema::table('tbl_cash_advance_request', function (Blueprint $table) {
            $table->unsignedBigInteger('proj_ref_id')->nullable()->before('proj_id');
        });

        // Add column to tbl_per_diem
        Schema::table('tbl_per_diem', function (Blueprint $table) {
            $table->unsignedBigInteger('proj_ref_id')->nullable()->before('proj_id');
            $table->uuid('hash')->nullable()->after('proj_ref_id');     
        });

        // Add column to tbl_transportation
        Schema::table('tbl_transportation', function (Blueprint $table) {
            $table->unsignedBigInteger('proj_ref_id')->nullable()->before('proj_id');
            $table->uuid('hash')->nullable()->after('proj_ref_id');
        });

        // Add column to tbl_accomodation
        Schema::table('tbl_accomodation', function (Blueprint $table) {
            $table->unsignedBigInteger('proj_ref_id')->nullable()->before('proj_id');
            $table->uuid('hash')->nullable()->after('proj_ref_id');
        });

        // Add column to tbl_misc_fee
        Schema::table('tbl_misc_fee', function (Blueprint $table) {
            $table->unsignedBigInteger('proj_ref_id')->nullable()->before('proj_id');
            $table->uuid('hash')->nullable()->after('proj_ref_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_cash_advance_request', function (Blueprint $table) {
            $table->dropColumn('proj_ref_id');
        });

        Schema::table('tbl_per_diem', function (Blueprint $table) {
            $table->dropColumn('proj_ref_id');
            $table->dropColumn('hash'); 
        });

        Schema::table('tbl_transportation', function (Blueprint $table) {
            $table->dropColumn('proj_ref_id');
            $table->dropColumn('hash');
        });

        Schema::table('tbl_accomodation', function (Blueprint $table) {
            $table->dropColumn('proj_ref_id');
            $table->dropColumn('hash');
        });

        Schema::table('tbl_misc_fee', function (Blueprint $table) {
            $table->dropColumn('proj_ref_id');
            $table->dropColumn('hash');
        });
    }
}
