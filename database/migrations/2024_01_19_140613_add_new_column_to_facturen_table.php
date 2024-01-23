<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('facturen', function (Blueprint $table) {
            $table->integer('vervaldagtype_id');
            $table->integer('klant_id');
            $table->integer('merk_id');
            $table->integer('makelaar_id');
            $table->integer('maatschappij_id');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facturen', function (Blueprint $table) {
            //
        });
    }
};
