<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('llr_id')->nullable();
            $table->string('name')->nullable();
            $table->string('accnt_no')->nullable();
            $table->string('entry_date')->nullable();
            $table->string('old_balance')->nullable();
            $table->string('balance')->nullable();
            $table->string('amount')->nullable();
            $table->string('pending_amount')->nullable();
            $table->string('receipt_no')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
