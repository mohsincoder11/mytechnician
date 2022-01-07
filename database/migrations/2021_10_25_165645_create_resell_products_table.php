<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResellProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resell_products', function (Blueprint $table) {
            $table->id();
            $table->integer('appliance_id');
            $table->string('product_name');
            $table->date('purchase_date');
           $table->string('brand_name');
           $table->text('description');
           $table->integer('price');
           $table->integer('warranty');
           $table->text('images');
           $table->string('status');
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
        Schema::dropIfExists('resell_products');
    }
}
