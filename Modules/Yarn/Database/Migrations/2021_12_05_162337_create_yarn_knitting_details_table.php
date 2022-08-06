<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYarnKnittingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yarn_knitting_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('date')->nullable();
            $table->unsignedInteger('knitting_id')->index()->nullable();
            $table->unsignedInteger('party_order_quantity')->index()->nullable();
            $table->unsignedInteger('receive_id')->index()->nullable();
            $table->unsignedInteger('party_id')->index()->nullable();
            $table->string('stl_order_no')->nullable();
            $table->string('brand')->nullable();
            $table->string('count')->nullable();
            $table->string('lot')->nullable();
            $table->string('buyer_name')->nullable();
            $table->string('knitting_qty')->nullable();
            $table->double('prod_qty')->nullable();
            $table->string('mc_dia')->nullable();
            $table->string('f_dia')->nullable();
            $table->string('f_gsm')->nullable();
            $table->string('sl')->nullable();
            $table->string('colour')->nullable();
            $table->string('fabric_type')->nullable();
            $table->double('rate')->nullable();
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
        Schema::dropIfExists('yarn_knitting_details');
    }
}
