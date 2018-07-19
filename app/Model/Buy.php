<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    protected $table = "buy";
    protected $fillable = [
        "registration","name","idCard","haveHouse","file","marriage",
        "pay","loan","down","household","status","sale",
        "area","phone","address","email","parking","child",
        "other","firstTrial","finalTrial","phone","divorce","hzHouse","otherHouse"
        ,"cardType","noHouse","generation","security","nothzHouse"
    ];

    public function list_use(){
        return $this->hasMany(UserList::class,'phone','phone');
    }
    public function img(){
        return $this->hasOne(Imgs::class,'buyId','id');
    }

    public function adminFirst(){
        return $this->hasOne(Admin::class,'id','firstTrial');
    }

    public function adminFinal(){
        return $this->hasOne(Admin::class,'id','finalTrial');
    }
    /**
     * method: 子女信息
     * author: hongwenyang
     * param:
     */
    public function getChildAttribute($value){
        if($value){
            return json_decode($value,true);
        }
        return array();
    }
    /**
     * method:其他购房信息
     * author: hongwenyang
     * param:
     */
    public function getOtherAttribute($value){
        if($value){
            return json_decode($value,true);
        }
        return array();
    }

    /**
     * method: 档案编号
     * author: hongwenyang
     * param:
     */
    public function getFileAttribute($value){
        if($value){
            return json_decode($value,true);
        }
        return array();
    }
    /**
     * method: 保存表单数据
     * author: hongwenyang
     * param:
     */
    public static function saveAll($data){
        $isHave = Buy::where('phone',$data['phone'])->value('id');
        $config = Config::where('id',1)->first();
        if($isHave){
            if(time() > strtotime($config->updated_end)){
                return 404;
            }
            $buy = self::buyString($data);
            // 修改前两页数据
            $type = 'firstSecond';
            Buy::where('id',$isHave)->update($buy);
            // 最后一项身份证
            if(isset($data['idCardfront'])){
                if($data['idCardfront']){
                    $data['buyId'] = $isHave;

                    Imgs::ImgData($data);
                    $type = 'firstLast';
                    Buy::where('id',$isHave)->update(['status'=>0]);
                }
            }
        }else{

            if(time() > strtotime($config->end_at)){
                return 403;
            }
            $type = 'firstAdd';
            $data['registration'] = NAME.rand(1000,9999);
            while (Buy::where('registration',$data['registration'])->value('id')){
                $data['registration'] = NAME.rand(1000,9999);
            }
//            dd($data);
            Buy::create($data);

        }
        UserList::saveMore($type,$data['phone']);
        return 200;
    }

    /**
     * method: 过滤字段
     * author: hongwenyang
     * param:
     */
    public static  function buyString($data){
        $fillable = [
            "registration","name","idCard","haveHouse","file","marriage",
            "pay","loan","down","household","status","sale",
            "area","phone","address","email","parking","child",
            "other","firstTrial","finalTrial","phone","divorce","hzHouse","otherHouse"
            ,"cardType","noHouse","generation","nothzHouse","security"
        ];

       foreach ($data as $k=>$value){
           if(!in_array($k,$fillable)){
               unset($data[$k]);
           }
           if($k == "child" && $data['child']){
               $data['child'] = json_encode($data['child']);
           }
           if($k == "other" && $data['other']){
               $data['other'] = json_encode($data['other']);
           }
           if($k == "file" && $data['file']){
               $data['file'] = json_encode($data['file']);
           }
       }
       return $data;
    }

    /**
     * method: 获取每个页面的数据
     * author: hongwenyang
     * param:
     */
    public static function getForm($data){
        $return = "";
        if($data['type'] == 1){
            // 第一页数据
            $fillabe = [
                'household','marriage','divorce','hzHouse','otherHouse','security'
            ];
        }else if($data['type'] == 2){
            // 第二页数据
            $fillabe = [
                'name','cardType','idCard','haveHouse','loan','pay','down','generation',
                'area','parking','child','other','file','sale',"nothzHouse"
            ];
        }else{
            // 第三页的数据
            $fillabe = [
                'idCardfront','idCardback','accountBook','accountBookpersonal',
                'accountBookmain','housing_situation','personal_credit','fund_freezing',
                'other_housing_situation','divorce_img','security_img','other_img',"marry",'death'
            ];
            $buyId  = Buy::where('phone',$data['phone'])->value('id');

            $return = Imgs::where('buyId',$buyId)->select($fillabe)->first();
            if($return){
                $status = Buy::where('phone',$data['phone'])->value('status');
                if(in_array($status,[0,1,2,3])){
                    $return->status = "审核中";
                }else if($status == 4){
                    $return->status = "审核不通过";
                    $error = Disagreement::where('buyId',$buyId)->select('key','reason')->get();
                    if($error->isNotEmpty()){
                        $return->error = $error;
                    }
                }else{
                    $return->status  = "审核通过";
                }
            }
            return $return;
        }

        return Buy::where('phone',$data['phone'])->select($fillabe)->first();
    }
}
