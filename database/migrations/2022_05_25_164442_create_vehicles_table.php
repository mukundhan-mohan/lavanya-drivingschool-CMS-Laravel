<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('vechicle_no')->nullable();
            $table->string('insurance_date')->nullable();
            $table->string('fc_date')->nullable();
            $table->string('next_oil_service')->nullable();
            $table->string('next_wheel_balance')->nullable();
            $table->string('next_water_service')->nullable();
            $table->string('next_battery_service')->nullable();
            $table->string('details')->nullable();
            $table->integer('has_deleted')->unsigned()->default(0);
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('vehicles');
    }
};
