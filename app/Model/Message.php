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
        $id                 = Message::where($data)->value('id');
        if($id){
            Message::where($data)->update([
                'is_use'=>1
            ]);
            return 200;
        }
        return 403;
    }
}
