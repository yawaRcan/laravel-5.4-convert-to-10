<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDossiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dossiers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dossiernummer')->unique();
            $table->date('datum')->nullable();
            $table->string('nummerplaat')->nullable();
            $table->integer('merk_id')->nullable();
            //$table->foreign('merk_id')->references('id')->on('cars');
            $table->string('model')->nullable();
            $table->integer('maatschappij_id')->nullable();
            //$table->foreign('maatschappij_id')->references('id')->on('maatschappijen');
            $table->integer('makelaar_id')->nullable();
            $table->string('merk',100)->nullable();
            $table->string('makelaar',300)->nullable();
            $table->string('maatschappij',300)->nullable();
            //$table->foreign('makelaar_id')->references('id')->on('makelaars');
            $table->float('resultaat')->nullable();
            $table->string('facturen')->nullable();
            $table->text('opmerkingen')->nullable();
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
        Schema::dropIfExists('dossiers');
    }
}