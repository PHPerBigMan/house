<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Disagreement extends Model
{
    protected $table = 'disagreement';
    protected $fillable = [
        'buyId','key','reason','trial'
    ];


    public static function saveImg($all,$admin){
        $ifHave = Disagreement::where([
            'key'       =>$all['key'],
            'trial'     =>$admin
        ])->value('id');
        if($ifHave){
            Disagreement::where([
                'key'       =>$all['key'],
                'trial'     =>$admin
            ])->update([
                'reason'    =>$all['reason']
            ]);
        }else{
            $all['trial'] = $admin;
            Disagreement::create($all);
        }
    }
}
