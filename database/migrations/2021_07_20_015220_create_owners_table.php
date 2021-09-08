<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('namausaha');
            $table->string('nohpusaha', 15);
            $table->text('deskripsiowner');
            $table->string('coverimage')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['waiting', 'enable', 'disable'])->default('waiting');

            $table->timestamps();
        });

        Schema::table('owners', function (Blueprint $table) {

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('owners');
    }
}
