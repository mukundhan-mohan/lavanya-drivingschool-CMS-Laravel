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
        Schema::create('customer_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone_number', 20)->nullable();
            $table->string('email', 20)->nullable();
            $table->string('version');
            $table->string('address')->nullable();
            $table->string('fees');
            $table->string('no_of_classes');
            $table->string('remarks')->nullable();
            $table->integer('has_deleted')->unsigned()->default(0);
            $table->datetime('enquiry_date');
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
        Schema::dropIfExists('customer_enquiries');
    }
};
