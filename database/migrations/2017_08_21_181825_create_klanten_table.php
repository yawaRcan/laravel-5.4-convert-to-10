<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKlantenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klanten', function (Blueprint $table) {
            $table->increments('id');
            $table->string('naam');
            $table->string('voornaam');
            $table->string('straat');
            $table->string('nr');
            $table->string('postcode');
            $table->string('telefoon');
            $table->string('email');
            $table->boolean('btw');
            $table->string('btwnr');
            $table->text('opmerking');
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
        Schema::dropIfExists('klanten');
    }
}
