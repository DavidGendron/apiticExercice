<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TableAnimal extends Model
{
    protected $table = 'animal';

    protected $fillable = [
    	'id',
        'nom',
        'genre',
        'poids',
        'taille'
    ];

    public $timestamps = true;
}
