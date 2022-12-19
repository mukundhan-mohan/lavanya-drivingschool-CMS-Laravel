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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('registration_date')->nullable();
            $table->string('accnt_no')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('role')->nullable();
            $table->string('no_of_classes')->default(0);
            $table->string('vehicle_id')->nullable();
            $table->string('status')->default('ongoing');
            $table->string('staff_id')->nullable();
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
        Schema::dropIfExists('attendances');
    }
};
