<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class YarnKnittingProgram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yarn_knitting_program', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('date')->nullable();
        $table->unsignedInteger('party_order_no')->index()->nullable();
        $table->unsignedInteger('party_id')->index()->nullable();
        $table->string('note')->nullable();
        $table->integer('created_by')->nullable();
        $table->integer('updated_by')->nullable();
        $table->timestamps();
        $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
