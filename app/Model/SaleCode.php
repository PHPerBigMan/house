<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SaleCode extends Model
{
   protected $table = "sale_code";
   protected $fillable = [
       'code'
   ];
}
