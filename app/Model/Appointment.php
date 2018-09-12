<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 预约数据
class Appointment extends Model
{
    protected $table = "appointment";
    protected $fillable = [
        "book_name",
        "book_phone",
        "book_time",
        "book_status",
        "book_cancel",
        "book_extension",
        "openid"
    ];

    /**
     * method: 增加预约数据
     * author: hongwenyang
     * param:
     */
    public static function addBook($data){
        if(empty($data['book_name']) || empty($data['book_phone']) || empty($data['book_time'])){
            // 缺少预约数据
            return 405;
        }
        // 判断是否已经预约
        $ifHave = Appointment::where(['openid'=>$data['open_id'],'book_status'=>1])->first();
        if($ifHave){
            // 重复预约
            return 404;
        }else{
            // 获取推广人id
            $book_extension = User::where('openid',$data['open_id'])->value('extension');
            if($book_extension){
                $data['book_extension'] = $book_extension;
                // 增加预约奖励
                User::addMore($book_extension,$data['open_id'],2,APPOINTMENTVALUE);
            }
            $data['openid'] = $data['open_id'];
            $s = Appointment::create($data);
            if($s){
                // TODO:: 预约成功发送短信通知
                return 200;
            }
            return 403;
        }
    }

    /**
     * method: 销售人员可以看的记录
     * author: hongwenyang
     * param:
     */

    public static  function getlist($get){
        // 获取推广人的id
        $extension = User::where('openid',$get['open_id'])->value('id');
        if($get['type'] == 1){
            $data = Appointment::where(['book_extension'=>$extension])->whereIn('book_status',[0,1])
                ->select([
                    "book_name",
                    "book_phone",
                    "book_time",
                    "book_status",
                    "openid",
                    "id"
                ])
                ->get();
            if($data->isNotEmpty()){
                foreach ($data as $k=>$v){
                    if(time() > strtotime($v->created_at)){
                        if($v->book_status == 1){
                            $v->book_status = "预约中";
                        }else{
                            $v->book_status = "已取消";
                        }
                    }else{
                        $v->book_status = "已逾期";
                    }

                    $v->avatar = User::where('openid',$v->openid)->value('avatar');
                    unset($data[$k]->openid);
                }
            }
        }else{
            // 已到访的数据
            $data = Appointment::where(['book_extension'=>$extension,'book_status'=>2]) ->select([
                "book_name",
                "book_phone",
                "book_time",
                "book_status",
                "openid",
                "id"
            ])->get();
            if($data->isNotEmpty()){
                foreach ($data as $k=>$v){
                    $v->come_send   =  $v->come_send == 0? "未通知" : "已通知";
                    $v->avatar      = User::where('openid',$v->openid)->value('avatar');
                    $v->book_status = "已到访";
                    unset($data[$k]->openid);
                }
            }
        }

        return $data;
    }
}
