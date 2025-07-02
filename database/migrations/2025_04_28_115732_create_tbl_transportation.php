<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblTransportation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_transportation', function (Blueprint $table) {
            $table->integer('transpo_id');
            $table->date('transpo_date')->nullable();
            $table->string('transpo_description')->nullable();
            $table->string('transpo_from')->nullable();
            $table->string('transpo_to')->nullable();
            $table->decimal('transpo_amount', 10 , 2)->nullable();
            $table->decimal('transpo_total', 10, 2)->nullable();

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
        Schema::dropIfExists('tbl_transportation');
    }
}
