<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblCashAdvanceRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_cash_advance_request', function (Blueprint $table) {
            $table->integer('proj_id');
            $table->string('requested_by')->nullable();
            $table->string('person_implementing')->nullable();
            $table->date('date_filed')->nullable();
            $table->string('reseller_name')->nullable();
            $table->string('proj_name')->nullable();
            $table->string('reseller_contact')->nullable();
            $table->string('reseller_location')->nullable();
            $table->string('reseller_email')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->string('enduser_name')->nullable();
            $table->string('enduser_contact')->nullable();
            $table->string('enduser_email')->nullable();
            $table->string('enduser_location')->nullable();
            $table->integer('mandays')->nullable();
            $table->decimal('cost_manday', 10, 2)->nullable();
            $table->decimal('proj_cost', 10, 2)->nullable();
            $table->string('po_number')->nullable();
            $table->string('so_number')->nullable();
            $table->string('payment_status')->nullable();
            $table->decimal('expenses', 10, 2)->nullable();
            $table->decimal('margin', 10, 2)->nullable();   
            $table->boolean('charged_to_margin')->default(false);
            $table->boolean('charged_to_parked_funds')->default(false);
            $table->boolean('charged_to_others')->default(false);
            $table->string('charged_others_input')->nullable();
            $table->string('division')->nullable();
            $table->string('division2')->nullable();
            $table->string('prod_line')->nullable();
            $table->boolean('expense_DigiOne')->default(false);
            $table->boolean('expense_marketingEvent')->default(false);
            $table->boolean('expense_travel')->default(false);
            $table->boolean('expense_training')->default(false);
            $table->boolean('expense_promos')->default(false);
            $table->boolean('expense_advertising')->default(false);
            $table->boolean('expense_freight')->default(false);
            $table->boolean('expense_representation')->default(false);
            $table->boolean('expense_others')->default(false);
            $table->string('expense_others_input')->nullable();
            $table->decimal('grand_total', 10, 2)->nullable();
            $table->string('project_type')->nullable();
            $table->string('status')->nullable();
            $table->string('approver_email')->nullable();
            $table->string('approver_name')->nullable();
            $table->string('requester_email')->nullable();

            $table->uuid('hash')->unique()->nullable();
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
        Schema::dropIfExists('tbl_cash_advance_request');
    }
}
