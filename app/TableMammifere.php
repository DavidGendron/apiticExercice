<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TableMammifere extends Model
{
    protected $table = 'mammifere';

    protected $fillable = [
    	'id',
        'fourrure',
        'idAnimal'
    ];

    public $timestamps = true;
}
