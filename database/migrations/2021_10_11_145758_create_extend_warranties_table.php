<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtendWarrantiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extend_warranties', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('appliance_id');
            $table->integer('status');
            $table->string('brand_name', 50);
            $table->date('date_of_purchase');
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
        Schema::dropIfExists('extend_warranties');
    }
}
