<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_owners', function (Blueprint $table) {
            $table->id();
            $table->string('transactionid', 15);
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('typeowner_id');
            $table->date('tanggalbayar')->nullable();
            $table->string('harga')->nullable();
            $table->string('notabayar')->nullable();
            $table->string('status')->default('waiting');
            $table->string('payment_url')->nullable();

            $table->timestamps();
        });

        Schema::table('pay_owners', function (Blueprint $table) {

            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
            $table->foreign('typeowner_id')->references('id')->on('typeowners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pay_owners');
    }
}
