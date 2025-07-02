<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPerDiem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_per_diem', function (Blueprint $table) {
            $table->integer('perDiem_id');
            $table->string('perDiem_currency')->nullable();
            $table->decimal('perDiem_rate', 10, 2)->nullable();
            $table->integer('perDiem_days')->nullable();
            $table->integer('perDiem_pax')->nullable();
            $table->decimal('perDiem_total', 10, 2)->nullable();

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
        Schema::dropIfExists('tbl_per_diem');
    }
}
