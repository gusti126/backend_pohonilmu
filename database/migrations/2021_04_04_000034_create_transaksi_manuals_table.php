<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiManualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_manuals', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('pending');
            $table->integer('user_id');
            $table->integer('kememberan_id');
            $table->string('bukti_pembayaran')->nullable();
            $table->string('referal')->nullable();
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
        Schema::dropIfExists('transaksi_manuals');
    }
}
