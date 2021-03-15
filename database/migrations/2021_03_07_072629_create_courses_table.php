<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('mentors')->onDelete('cascade');
            $table->integer('kategori_id');
            $table->string('nama');
            $table->string('image');
            $table->boolean('sertifikat');
            $table->integer('harga');
            $table->enum('level', ['All-level', 'Beginer', 'Intermediate', 'Advance'])->default('All-level');
            $table->longText('deskripsi');
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
        Schema::dropIfExists('courses');
    }
}
