<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('platnomor', 30);
            $table->unsignedBigInteger('harga');
            $table->string('jenismobil');
            $table->string('keterangan');
            $table->unsignedBigInteger('owner_id');
            $table->string('gambarmobil')->nullable();

            $table->timestamps();
        });

        Schema::table('cars', function (Blueprint $table) {
            $table->foreign('owner_id')->references('id')->on('owners')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
