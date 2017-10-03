<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TableReptile extends Model
{
    protected $table = 'reptile';

    protected $fillable = [
    	'id',
        'ecaille',
        'idAnimal'
    ];

    public $timestamps = true;
}
