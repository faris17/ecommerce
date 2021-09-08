<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductHasTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_has_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('transaction_id');
            $table->tinyInteger('total');
            $table->unsignedBigInteger('hargasatuanbarang');
            $table->tinyInteger('diskon');
            $table->unsignedBigInteger('hargaperludibayar');

            $table->timestamps();
        });

        Schema::table('product_has_transactions', function (Blueprint $table) {

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_has_transactions');
    }
}
