<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFacturenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::table('facturen', function (Blueprint $table){
//$table->integer('vervaldagtype_id')->unsigned();
//$table->foreign('vervaldagtype_id')->references('id')->on('vervaldagtypes');
//$table->dropColumn('vervaldag');
/*            $table->dropColumn('klant');
            $table->integer('klant_id')->unsigned();
            $table->foreign('klant_id')->references('id')->on('klanten');
            $table->dropColumn('merk');
            $table->integer('merk_id')->unsigned();
            $table->foreign('merk_id')->references('id')->on('cars');
            $table->dropColumn('makelaar');
            $table->integer('makelaar_id')->unsigned();
            $table->foreign('makelaar_id')->references('id')->on('makelaars');
            $table->dropColumn('maatschappij');
            $table->integer('maatschappij_id')->unsigned();
            $table->foreign('maatschappij_id')->references('id')->on('maatschappijen');
*/        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
