<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYarnReceiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yarn_receive_challan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('date')->nullable();
            $table->unsignedInteger('receive_id')->index()->nullable();
            $table->unsignedInteger('party_id')->index()->nullable();
            $table->string('chalan')->default(0);
            $table->string('gate_pass')->default(0);
            $table->string('token')->nullable();
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
        Schema::dropIfExists('yarn_receive');
    }
}
