<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_logs', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_id')->nullable();
            $table->string('entry_date')->nullable();
            $table->string('opening_km')->nullable();
            $table->string('closing_km')->nullable();
            $table->string('total_km')->nullable();
            $table->string('no_of_classes')->nullable();
            $table->string('average')->nullable();
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
        Schema::dropIfExists('vehicle_logs');
    }
}
