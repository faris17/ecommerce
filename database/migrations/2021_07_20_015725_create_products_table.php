<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('namaproduk');
            $table->integer('hargasatuan');
            $table->integer('hargacoret');
            $table->tinyInteger('diskon')->length(3);
            $table->string('satuan');
            $table->string('stock')->nullable();
            $table->string('ukuran')->nullable();
            $table->string('pilihanwarna')->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('ongkir');
            $table->string('jenispembayaran', 50)->default('cod');
            $table->unsignedBigInteger('owner_id');

            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
