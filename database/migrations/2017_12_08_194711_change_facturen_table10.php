<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFacturenTable10 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facturen', function($table)
        {
            $table->text('type')->nullable()->change();
            $table->text('vervaldagtype_id')->nullable()->change();
            $table->text('merk_id')->nullable()->change();
            $table->text('makelaar_id')->nullable()->change();
            $table->text('maatschappij_id')->nullable()->change();
        });
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
