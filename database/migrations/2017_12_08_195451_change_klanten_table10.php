<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeKlantenTable10 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('klanten', function($table)
        {
            $table->text('naam')->nullable()->change();
            $table->text('straat')->nullable()->change();
            $table->text('postcode')->nullable()->change();
            $table->text('gemeente')->nullable()->change();
            $table->text('email')->nullable()->change();
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
