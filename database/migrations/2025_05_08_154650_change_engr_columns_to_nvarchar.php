<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeEngrColumnsToNvarchar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_engineers', function (Blueprint $table) {
             $table->string('engr_name', 255)->change();

         
            $table->string('engr_email', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_engineers', function (Blueprint $table) {
            $table->string('engr_name', 255)->change();
            $table->string('engr_email', 255)->change();
        });
    }
}
