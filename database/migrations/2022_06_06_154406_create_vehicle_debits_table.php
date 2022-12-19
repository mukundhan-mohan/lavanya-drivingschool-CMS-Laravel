<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleDebitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_debits', function (Blueprint $table) {
            $table->id();
            $table->string('debit')->nullable();
            $table->string('vehicle_id')->nullable();
            $table->string('category')->nullable();
            $table->string('date')->nullable();
            $table->string('details')->nullable();
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('vehicle_debits');
    }
}
