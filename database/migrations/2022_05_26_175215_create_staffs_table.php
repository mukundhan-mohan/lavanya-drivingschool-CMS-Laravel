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
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('staff_code')->nullable();
            $table->string('father_or_spouse')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('previous_experience')->nullable();
            $table->string('total_experience')->nullable();
            $table->string('education_qualification')->nullable();
            $table->string('curricular_activities')->nullable();
            $table->string('interested_area')->nullable();
            $table->string('joining_date')->nullable();
            $table->string('designation')->nullable();
            $table->string('avatar')->nullable();
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
        Schema::dropIfExists('staffs');
    }
};
