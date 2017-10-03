<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TableOiseau extends Model
{
    protected $table = 'oiseau';

    protected $fillable = [
    	'id',
        'plumage',
        'idAnimal'
    ];

    public $timestamps = true;
}
