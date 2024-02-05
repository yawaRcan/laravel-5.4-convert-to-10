<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    protected $table = 'dossiers';
    protected $fillable = ['datum', 'dossiernummer', 'nummerplaat', 'merk_id', 'model', 'maatschappij_id', 'makelaar_id', 'merk', 'makelaar', 'maatschappij', 'resultaat', 'facturen', 'opmerkingen'];
    public function facturen()
    {
        return $this->belongsToMany('App\Models\Factuur', 'dossier_factuur', 'dossier_id', 'factuur_id');
    }
}
