<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_product_variations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shop_product_id')->unsigned();
            $table->bigInteger('shop_product_variation_type_id')->unsigned();
            $table->string('variation');
            $table->string('photo');
            $table->timestamps();

            $table->foreign('shop_product_id')->references('id')->on('shop_products');
            $table->foreign('shop_product_variation_type_id')->references('id')->on('shop_product_variation_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_product_variations');
    }
};
