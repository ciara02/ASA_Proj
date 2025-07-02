<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblPointsystemAttachment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pointsystem_attachment', function (Blueprint $table) {
            $table->id();
            $table->integer('ps_att_id'); // Primary key (auto-increment)
            $table->string('ps_att_name')->nullable()->unique(); // Make nullable and unique if needed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_pointsystem_attachment');
    }
}
