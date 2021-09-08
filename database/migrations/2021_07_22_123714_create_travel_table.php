<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel', function (Blueprint $table) {
            $table->id();
            $table->text('destination');
            $table->string('namapaket')->nullable();
            $table->string('harga');
            $table->text('description');
            $table->string('gambartravel');
            $table->unsignedBigInteger('owner_id');

            $table->timestamps();
        });

        Schema::table('travel', function (Blueprint $table) {

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
        Schema::dropIfExists('travel');
    }
}
