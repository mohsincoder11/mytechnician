<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsermanagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usermanages', function (Blueprint $table) {
            $table->id();
            $table->string('full_name',50);
            $table->string('email',50);
            $table->string('password',50);
            $table->integer('mobile');
            $table->string('address',100);
            $table->string('image',100);
            $table->integer('pincode');
            $table->integer('status');
        
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
        Schema::dropIfExists('usermanages');
    }
}
