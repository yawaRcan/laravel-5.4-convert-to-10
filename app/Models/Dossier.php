<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    protected $table = 'dossiers';

    public function facturen()
    {
        return $this->belongsToMany('App\Models\Factuur', 'dossier_factuur', 'dossier_id', 'factuur_id');
    }
}
