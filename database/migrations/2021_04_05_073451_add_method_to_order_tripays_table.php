<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMethodToOrderTripaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_tripays', function (Blueprint $table) {
            $table->string('method')->nullable()->after('kememberan_id');
            $table->string('referal')->nullable()->after('snap_url');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_tripays', function (Blueprint $table) {
            $table->dropColumn('method');
            $table->dropColumn('referal');
        });
    }
}
