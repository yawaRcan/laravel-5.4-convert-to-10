<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Klant extends Model
{
    protected $table = 'klanten';

    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'klanten.naam' => 1,
            'klanten.straat' => 3,
            'klanten.postcode' => 4
        ]
    ];
}