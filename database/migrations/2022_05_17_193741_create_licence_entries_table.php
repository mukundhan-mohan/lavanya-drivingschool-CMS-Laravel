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
        Schema::create('licence_entries', function (Blueprint $table) {
            $table->id();
            $table->string('enquiry_id')->nullable();
            $table->string('name');
            $table->string('phone_number', 20)->nullable();
            $table->string('email', 20)->nullable();
            $table->string('version');
            $table->string('address')->nullable();
            $table->string('fees');
            $table->string('no_of_classes');
            $table->string('remarks')->nullable();
            $table->integer('has_deleted')->unsigned()->default(0);
            $table->datetime('enquiry_date')->nullable();
            $table->string('account_no')->nullable();
            $table->string('llr_no')->nullable();
            $table->datetime('from')->nullable();
            $table->datetime('to')->nullable();
            $table->string('notary_remarks')->nullable();
            $table->datetime('registration_date')->nullable();
            $table->string('dl_no')->nullable();
            $table->datetime('licence_expiry_date')->nullable();
            $table->datetime('issued_at')->nullable();
            $table->string('advance_if_any')->nullable();
            $table->string('balance')->nullable();
            $table->string('attender')->nullable();
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
        Schema::dropIfExists('licence_entries');
    }
};
