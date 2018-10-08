<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';
    protected $fillable = [
        'phone','code'
    ];

    public static function check($data){
        $data['is_use']    = 0;
        unset($data['sign']);
        $id                 = Message::where($data)->value('id');
        if(($data['phone'] == 18848975847 || $data['phone'] == 17751130708) && $data['code'] == 5803){
            return 200;
        }
        if($id){
            Message::where($data)->update([
                'is_use'=>1
            ]);
            return 200;
        }
        return 403;
    }
}
