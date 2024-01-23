<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeVervaldagtypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::table('vervaldagtypes', function (Blueprint $table) {
            $table->integer('dagen');
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
