<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTripaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_tripays', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('pending');
            $table->integer('user_id');
            $table->integer('kememberan_id');
            $table->string('no_referensi')->nullable();
            $table->string('kode_pembayaran')->nullable();
            $table->string('jumlah_tagihan')->nullable();
            $table->string('snap_url')->nullable();
            $table->json('metadata')->nullable();
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
        Schema::dropIfExists('order_tripays');
    }
}
