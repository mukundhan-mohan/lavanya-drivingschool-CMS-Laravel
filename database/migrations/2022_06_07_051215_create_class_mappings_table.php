<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_mappings', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_id')->nullable();
            $table->string('entry_date')->nullable();
            $table->string('staff_id')->nullable();
            $table->string('no_of_classes')->nullable();
            $table->string('student_id')->nullable();
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
        Schema::dropIfExists('class_mappings');
    }
}
