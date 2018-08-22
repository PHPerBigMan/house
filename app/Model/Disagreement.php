<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Disagreement extends Model
{
    protected $table = 'disagreement';
    protected $fillable = [
        'buyId','key','reason','trial','type'
    ];


    public static function saveImg($all,$admin){

        $ifHave = Disagreement::where([
            'key'       =>$all['key'],
            'trial'     =>$admin,
            'buyId'     =>$all['buyId']
        ])->value('id');
        if($ifHave){
            Disagreement::where([
                'key'       =>$all['key'],
                'trial'     =>$admin,
                'buyId'     =>$all['buyId']
            ])->update([
                'reason'    =>$all['reason']
            ]);
        }else{
            $all['trial'] = $admin;

            Disagreement::create($all);
        }
    }
}
