<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_orders', function (Blueprint $table) {
            $table->id();
            $table->string('number_reference')->nullable();
            $table->string('status', 1)->default(0);
            $table->string('type_payment', 1)->default(0);
            $table->text('json_response')->nullable();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('modify_by');
            $table->timestamps();
        });

        Schema::create('master_order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('master_order_id');
            $table->unsignedInteger('order_id');
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
        Schema::dropIfExists('master_orders');
        Schema::dropIfExists('master_order_details');
    }
}
