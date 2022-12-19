<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPrivilegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_menu_privileges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('left_menu_id')->unsigned();
            $table->string('menu_slug')->nullable();
            $table->integer('creator_id')->unsigned();
            $table->integer('updated_by')->unsigned();
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('left_menu_id')->references('id')->on('left_menus')->onDelete('cascade');
            // $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_menu_privileges');
    }
}
