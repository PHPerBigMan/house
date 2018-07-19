<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'config';
    protected $fillable = [
        'project_name',
        'project_extension',
        'start_at',
        'end_at',
        'updated_end',
        'img',
        'registration_notes',
        'frozen',
        'notice',
    ];
}
