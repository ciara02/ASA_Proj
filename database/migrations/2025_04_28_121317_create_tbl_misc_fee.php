<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblMiscFee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_misc_fee', function (Blueprint $table) {
            $table->integer('misc_id');
            $table->string('misc_particulars')->nullable();
            $table->integer('misc_pax')->nullable();
            $table->decimal('misc_amount', 10, 2)->nullable();
            $table->decimal('misc_total', 10, 2)->nullable();

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
        Schema::dropIfExists('tbl_misc_fee');
    }
}
