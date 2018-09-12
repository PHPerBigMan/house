<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BalanceList extends Model
{
    protected $table = "balance_list";
    protected $fillable = [
        "openid",
        "extension",
        "type",
        "value",
    ];

    /**
     * method: 我的奖励
     * author: hongwenyang
     * param:
     */
    public static function getlist($extension){
        $data = BalanceList::where('extension',$extension)
            ->select([
                "type",
                "openid",
                "value",
                "created_at"
            ])
            ->get();
        if($data->isNotEmpty()){
            foreach ($data as $k=>$v){
                $v->type                = $v->type == 1 ? "访问奖励" : $v->type == 2? "预约奖励" : "到访奖励";
                $v->avatar              = User::where('openid',$v->openid)->value('avatar');
                $v->nickname            = User::where('openid',$v->openid)->value('nickname');
                unset($v->openid);
            }
        }
        return $data;
    }
}
