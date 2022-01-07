<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicianRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technician_ratings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('service_id');
            $table->integer('rating');
            $table->text('review',100);
            $table->string('rating_for',20);
        
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
        Schema::dropIfExists('technician_ratings');
    }
}
