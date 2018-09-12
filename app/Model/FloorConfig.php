<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 预约看房楼盘配置
class FloorConfig extends Model
{
    protected  $table = "floor_config";
    protected $fillable = [
        "floor_name",
        "floor_address",
        "floor_longitude",
        "floor_latitude",
        "floor_zoom",
    ];
}
