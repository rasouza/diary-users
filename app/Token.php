<?php

namespace App;

use Moloquent;

class Token extends Moloquent
{
    protected $fillable = [
        'provider', 'code'
    ];
}
