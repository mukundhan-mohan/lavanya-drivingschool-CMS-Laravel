<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsJoinedToCustomerEnquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_enquiries', function (Blueprint $table) {
            $table->integer('is_joined')->unsigned()->default(0)->after('remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_enquiries', function (Blueprint $table) {
            $table->dropColumn('is_joined');
        });
    }
}
