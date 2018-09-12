<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserList extends Model
{
    protected $table = 'list';
    protected $fillable = [
        'key','value','phone'
    ];

    public static function saveMore($type,$phone){
        $isHave = UserList::where([
            'phone'=>$phone,
            'key'  =>$type
        ])->value('id');
        if($isHave){
            if($type != 'register'){
                UserList::where([
                    'phone'=>$phone,
                    'key'  =>$type
                ])->update([
                    'value'=>date('Y-m-d H:i:s',time())
                ]);
            }

        }else{
            $insert['key'] = $type;
            $insert['value'] = date('Y-m-d H:i:s',time());
            $insert['phone'] = $phone;

            UserList::create($insert);
        }
    }
}
