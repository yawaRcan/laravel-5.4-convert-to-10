<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Factuur extends Model
{
    protected $table = 'facturen';

    public function klant()
    {
        return $this->belongsTo(Klant::class);
    }

    public function car()
    {
        return $this->belongsTo('App\Models\Car', 'merk_id');
    }

    public function maatschappij()
    {
        return $this->belongsTo(Maatschappij::class);
    }

    public function makelaar()
    {
        return $this->belongsTo(Makelaar::class);
    }

    public function dossiers()
    {
        return $this->belongsToMany('App\Models\Dossier', 'dossier_factuur', 'factuur_id', 'dossier_id');
    }
    /*
        public function hasDossier() {
            return (bool) $this->hasOne('App\Dossier');
        }
    */
    public static function volgendFactuurNummer()
    {
        $laatsteFactuur = Factuur::orderBy('created_at', 'desc')->first();
        $nummer = 0;
        $huidigjaar = date("Y");

        if ($laatsteFactuur) {
            $jaar = substr($laatsteFactuur->factuurnummer, 0, 4);

            if ($huidigjaar == $jaar)
                $nummer = substr($laatsteFactuur->factuurnummer, 4);
        }

        return $huidigjaar . sprintf('%05d', intVal($nummer) + 1);
    }

    public function scopeBedrag($query, $operator, $bedrag)
    {
        if ($bedrag != '') {
            if ($operator == 'less') {
                return $query->where('bedrag', '<', $bedrag);
            } else if ($operator == 'more') {
                return $query->where('bedrag', '>', $bedrag);
            } else if ($operator == 'equal') {
                return $query->where('bedrag', '=', $bedrag);
            }
        } else {
            return $query;
        }
    }

    public function scopeFactuurNummer($query, $start, $einde)
    {
        return $query->whereBetween('factuurnummer', [$start, $einde]);
    }

    public function scopeFactuurDatum($query, $start, $einde)
    {
        return $query->whereBetween('datum', [$start, $einde]);
    }

    public function scopeKlant($query, $klant_id)
    {
        if ($klant_id != '') {
            return $query->where('klant_id', $klant_id);
        } else {
            return $query;
        }
    }

    public function scopeMakelaar($query, $makelaar_id)
    {
        if ($makelaar_id != '') {
            return $query->where('makelaar_id', $makelaar_id);
        } else {
            return $query;
        }
    }

    public function scopeWelkeFacturen($query, $facturen_selectie)
    {
        if ($facturen_selectie == 1) {
            return $query;
        } else if ($facturen_selectie == 2) {
            return $query->where('voldaan', true);
        } else if ($facturen_selectie == 3) {
            return $query->where('voldaan', false);
        } else if ($facturen_selectie == 4) {
            return $query->where('voldaan', false)->where('vervaldag', '<', Carbon::now());
        }
    }

    public function scopeSortering($query, $sortering)
    {
        if ($sortering == 1) {
            return $query->orderBy('factuurnummer', 'asc');
        } else if ($sortering == 2) {
            return $query->orderBy('klant_id', 'asc');
        } else if ($sortering == 3) {
            return $query->orderBy('datum', 'asc');
        } else if ($sortering == 4) {
            return $query->orderBy('vervaldag', 'asc');
        } else if ($sortering == 5) {
            return $query->orderBy('bedrag', 'asc');
        }
    }

    public function scopeJaar($query, $begin, $eind)
    {
        return $query->whereYear('datum', '=', $begin);
    }
}