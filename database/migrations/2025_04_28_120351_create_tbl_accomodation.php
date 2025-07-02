<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblAccomodation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_accomodation', function (Blueprint $table) {      
            $table->integer('accomodation_id');
            $table->string('accom_hotel')->nullable();
            $table->decimal('accom_rate', 10, 2)->nullable();
            $table->integer('accom_rooms')->nullable();
            $table->integer('accom_nights')->nullable();
            $table->decimal('accom_amount', 10, 2)->nullable();
            $table->decimal('accom_total', 10, 2)->nullable();

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
        Schema::dropIfExists('tbl_accomodation');
    }
}
