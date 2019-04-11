<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('system_id')->unsigned();
            $table->foreign('system_id')->references('id')->on('system_type');
            $table->string('offer_name',255);
            $table->enum('offer_type',['amt','per','combo'])->default('amt');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->bigInteger('venue_id')->unsigned();
            $table->foreign('venue_id')->references('id')->on('venues');
            $table->bigInteger('merchant_id')->unsigned();
            $table->foreign('merchant_id')->references('id')->on('merchants');
            $table->bigInteger('modifier_id')->unsigned();
            $table->foreign('modifier_id')->references('id')->on('product_modifiers');
            $table->decimal('discount_amt',8,2);
            $table->text('combo_product_ids')->nullable();
            $table->string('valid_from')->nullable();
            $table->string('valid_to')->nullable();
            $table->integer('status')->default('1');
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_offers');
    }
}
