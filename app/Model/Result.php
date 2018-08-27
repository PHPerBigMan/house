<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = "result";
    protected $fillable = [
        'registration','phone','result',"getHouse","name"
    ];
}
