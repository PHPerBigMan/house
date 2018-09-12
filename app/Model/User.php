<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "user";
    protected $fillable = [
        "openid",
        "extension",
    ];

    /**
     * method: 编辑用户信息
     * author: hongwenyang
     * param:
     */
    public  static  function addUserInfo($openid,$extension,$pageType,$nickname,$avatar){
        if(!$pageType){
            $pageType   = "normal";
            $extension  = "";
        }


        if(!$nickname){
            $nickname   = "";
            $avatar     = "";
        }
        $ifHave = User::where('openid',$openid)->first();
        if($pageType == "normal"){
            // 通过小程序正常进入
            if(!$ifHave){
                User::insert(['openid'=>$openid,'nickname'=>$nickname,'avatar'=>$avatar]);
            }
        }else{
            // 通过分享链接进入
            $extensionOpenid = User::where('openid',$extension)->value('id');
            // 通过分享链接进入的增加浏览记录
            Visit::insert([
                'openid'    =>$openid,
                'extension' =>$extensionOpenid
            ]);
            // 增加访问奖励
            self::addMore($extensionOpenid,$openid,1,VISITVALUE);
            if(!$ifHave){
                User::insert(['openid'=>$openid,'nickname'=>$nickname,'avatar'=>$avatar]);
                $userId = User::where('openid',$openid)->value('id');
                if($userId != $extensionOpenid){
                    User::where('openid',$openid)->update(['extension'=>$extensionOpenid]);
                }
            }else{
                User::where(['openid'=>$openid])->update(['extension'=>$extensionOpenid]);
            }
        }
    }

    /**
     * method: 增加奖励记录
     * author: hongwenyang
     * param:
     */
    public static function addMore($extension,$openid,$type,$value){
       // 增加访问记录奖励
        BalanceList::insert([
            'openid'        =>$openid,
            'extension'     =>$extension,
            'type'          =>$type,
            'value'         =>$value
        ]);
        // 增加余额
        Sale::where('user_id',$extension)->increment('balance',$value);
    }
}
