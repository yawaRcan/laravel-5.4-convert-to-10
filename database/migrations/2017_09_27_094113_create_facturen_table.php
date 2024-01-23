<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturen', function (Blueprint $table) {
            $table->increments('id');
            $table->string('factuurnummer');
            $table->date('datum');
            $table->string('termijn');
            $table->date('vervaldag');
            $table->string('klant');
            $table->integer('bedrag');
            $table->integer('betaald');
            $table->boolean('voldaan');
            $table->string('code');
            $table->string('merk');
            $table->string('type');
            $table->string('makelaar');
            $table->string('maatschappij');
            $table->text('opmerkingen');
            $table->string('betalingswijze');
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
        Schema::dropIfExists('facturen');
    }
}
