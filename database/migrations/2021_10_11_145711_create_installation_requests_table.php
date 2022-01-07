<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installation_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('status');

            $table->integer('appliance_id');
            $table->string('brand_name', 50);
            $table->date('date_of_purchase');
            $table->string('accessory', 50);
            $table->string('specific_requirement');     
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
        Schema::dropIfExists('installation_requests');
    }
}
