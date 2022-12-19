<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPwCodeToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('pw_code', 10)->nullable()->after('phone_number');
            $table->string('has_deleted')->default(0)->after('pw_code');
            $table->string('updated_by')->default(0)->after('has_deleted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('pw_code');
            $table->dropColumn('has_deleted');
            $table->dropColumn('updated_by');
        });
    }
}
