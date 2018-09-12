<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = "sale";
    protected $fillable = [
        "sale_name",
        "sale_phone",
        "sale_wechat",
        "open_id",
        "user_id",
        "sale_code",
    ];

    /**
     * method: 添加销售
     * author: hongwenyang
     * param:
     */
    public static function  addSale($data){
        $data['user_id']    = User::where('openid',$data['open_id'])->value('id');
        // 判断是否已经添加
        $isHaveSale         = Sale::where('sale_phone',$data['sale_phone'])->value('id');
        if($isHaveSale){
            //  手机号码已经入驻
            return 401;
        }

        // 没有身份识别码的一概认为是中介
        $UserType = 2;
        if($data['sale_code']){
            if($data['sale_code'] >= 10000 && $data['sale_code']< 20000){
                $UserType = 1;
            }else{
                $UserType = 2;
            }
            $saleCodeStatus  = SaleCode::where('code',$data['sale_code'])->first();
            if($saleCodeStatus){
                if($saleCodeStatus->is_send == 0){
                    // 未分配不可使用
                    return 405;
                }
                if($saleCodeStatus->is_use == 1){
                    // 已被使用
                    return 402;
                }
            }else{
                // 不存在
                return 403;
            }
            SaleCode::where('id',$saleCodeStatus->id)->update(['is_use'=>1]);
        }
        User::where('openid',$data['open_id'])->update(['type'=>$UserType]);
        if($data['sale_code']){
            Sale::create($data);

            return 200;
        }else{

            Sale::create($data);
            return 200;
        }
    }

    /**
     * method: 我的推广
     * author: hongwenyang
     * param:
     */
    public static function extensionList($openid){
        $extension = User::where('openid',$openid)->first();

        if($extension){
            // 浏览量
            $visitCount         = Visit::where('extension',$extension->id)->count();
            // 预约量
            $appointmentCount   = Appointment::where(['book_extension'=>$extension->id])->whereIn('book_status',[0,1])->count();
            // 到访量
            $comeCount          = Appointment::where(['book_extension'=>$extension->id,'book_status'=>2])->count();
            // 奖励金
            $sale               = Sale::where('user_id',$extension->id)->first();;
            $balance            = $sale->balance;
            $name               = $sale->sale_name;

            if($extension->type == 1){
                // 销售
                return [
                    'visitCount'        =>$visitCount,
                    'appointmentCount'  =>$appointmentCount,
                    'comeCount'         =>$comeCount,
                    "name"              =>$name
                ];
            }
            return [
                'visitCount'        =>$visitCount,
                'appointmentCount'  =>$appointmentCount,
                'comeCount'         =>$comeCount,
                'balance'           =>$balance,
                'name'              =>$name
            ];
        }
        return [];
    }

}
