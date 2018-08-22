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

    public function result(){
        return $this->hasOne(Result::class,'phone','phone');
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

            // 判断主购房人是否在其他购房人中
            $status = Buy::where('phone',$data['phone'])->value('status');

            if(in_array($status,[0,1,2,3])){
                return 200;
            }
            if(time() > strtotime($config->updated_end)){
                return 404;
            }

            // 最后一项身份证
            if(isset($data['idCardfront'])){
                if($data['idCardfront']){
                    $data['buyId'] = $isHave;
                    Imgs::ImgData($data);
                    $type = 'firstLast';
                    Buy::where('id',$isHave)->update(['status'=>0]);
                }
            }else{
                $buy = self::buyString($data);
                // 第二页处理其他购房者信息
                if(isset($data['other'])){
                    self::delOtherImg($data['other'],$isHave);
                }

                if(isset($buy['marriage'])){
                    // 如果是未婚单身则没有未成年人信息
                    if(in_array($buy['marriage'],["未婚单身"])){
                        $buy['child'] = '';
                    }
                }

                // 获取用户的数据
                $userSave = Buy::where('id',$isHave)->first();
                if(isset($buy['name'])){
                    if(ISBUY){
                        $get['name']    = $buy['name'];
                        $get['idCard']  = $buy['idCard'];
                        $get['phone']   = $data['phone'];
                        $ifInOther = self::ifInOther($get);
                        if($ifInOther == 407){
                            return 407;
                        }
                    }
                    if($userSave->marriage == "已婚"){
                        // 必须要有其他购房人信息
                        if(!isset($buy['other'])){
                            return 406;
                        }
                    }else if($userSave->marriage == "未婚单身"){
                        Imgs::where('buyId',$isHave)->update([
                            'marry'=>''
                        ]);
                    }
                }else{
                    // 第一页的数据

                }


                if(!isset($buy['other'])){
                    if(isset($buy['name'])){
                        $buy['other'] = '';
                        Imgs::where('buyId',$isHave)->update([
                            'other_img'=>''
                        ]);
                    }else{
                        // 第一页数据

                    }
                }

                if(!isset($buy['child'])){
                    if(isset($buy['name'])) {
                        $buy['child'] = '';
                    }
                }
                // 修改前两页数据
                $type = 'firstSecond';

                Buy::where('id',$isHave)->update($buy);
            }
        }else{

            if(time() > strtotime($config->end_at)){
                return 403;
            }
            $type = 'firstAdd';

            Buy::create($data);

        }
        UserList::saveMore($type,$data['phone']);
        return 200;
    }


    /**
     * method: 删除不包含在第二步提交的身份证号的其他购房者图片
     * author: hongwenyang
     * param:  $data 其他购房者数据   $buyId 数据id
     */
    public static function delOtherImg($data,$buyId){
        $key = array();
        foreach ($data as $k=>$v){
            $idCard[$k] = $v['idCard'];
        }

        // 获取这调数据的其他购房者信息图片
        $otherImg = Imgs::where('buyId',$buyId)->value('other_img');

        foreach ($otherImg as $k=>$v){
            if(isset($v['idCard'])){
                if(!in_array($v['idCard'],$idCard)){
                    $key[] = $k;
                }
            }
        }

        if($key){
            foreach ($key as $v){
                unset($otherImg[$v]);
            }
            if($otherImg){
                $otherImg = json_encode($otherImg);
                ksort($otherImg);
            }else{
                $otherImg = "";
            }
            Imgs::where('buyId',$buyId)->update([
                'other_img'=>$otherImg
            ]);
        }
    }
    /**
     * method: 判断是否已经被加入其它购房者信息中
     * author: hongwenyang
     * param:
     */
    public static function ifInOther($get){
        $data = Buy::where('other','<>','')->get();

        $phone = Buy::where(['name'=>$get['name'],'idCard'=>$get['idCard']])->value('phone');

        if($phone){
            if($phone != $get['phone']){
                return 407;
            }
        }

        if($data->isNotEmpty()){
            foreach ($data as $v){
                foreach ($v['other'] as $value){
                    if($value['idCard'] == $get['idCard']){
                        return 407;
                    }
                }
            }
            return 200;
        }
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
        $buyId  = Buy::where('phone',$data['phone'])->value('id');
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


//            $return = Imgs::where('buyId',$buyId)->select($fillabe)->first();
//            if($return){
//                $status = Buy::where('phone',$data['phone'])->value('status');
//                if(in_array($status,[0,1,2,3])){
//                    $return->status = "审核中";
//                }else if($status == 4){
//                    $return->status = "审核不通过";
//                    $error = Disagreement::where('buyId',$buyId)->select('key','reason')->get();
//                    if($error->isNotEmpty()){
//                        $return->error = $error;
//                    }
//                }else{
//                    $return->status  = "审核通过";
//                }
//            }
//            return $return;
        }

        if($data['type'] == 3){
            $return = Imgs::where('buyId',$buyId)->select($fillabe)->first();
        }else{

            $return = Buy::where('phone',$data['phone'])->select($fillabe)->first();
        }

        if($return){
            $status = Buy::where('phone',$data['phone'])->value('status');
            if(in_array($status,[0,1,2,3])){
                $return->status = "审核中";
            }else if(in_array($status,[4,7])){
                $return->status = "审核不通过";
                $error = Disagreement::where([
                    'buyId'=>$buyId,
                    'type'=>0
                ])->select('key','reason')->get();
                // 主购房人图片审核不通过
                if($error->isNotEmpty()){
                    $return->error = $error;
                }

                $othererror = Disagreement::where([
                    'buyId'=>$buyId,
                    'type'=>1
                ])->select('key','reason')->get();
                // 其他图片审核不通过
                if($othererror->isNotEmpty()){
                    foreach ($othererror as $k=>$v){
                        $key                    = explode('-',$v->key);
                        $othererror[$k]->key    = $key[1];
                        $othererror[$k]->name   = $key[2];
                    }
                    $return->othererror = $othererror;
                }
            }else if($status == 5){
                $return->status  = "审核通过";
            }else if($status == 6){
                $return->status  = "资料没填完";
            }
        }
        return $return;
    }


    public static function saveMobileUser($data,$type= 1){
        if($type == 1){
            // 保存手机信息

            $ifHave = Buy::where('phone',$data['phone'])->value('id');
            if(!$ifHave){
                $id  = Buy::insertGetId([
                    'phone'=>$data['phone'],
                    'md5'  =>$data['sign'],
                ]);
                $registration = NAME.self::id($id);
                Buy::where('phone',$data['phone'])->update([
                    'registration'=>$registration
                ]);
            }else{
                Buy::where('id',$ifHave)->update([
                    'md5'  =>$data['sign']
                ]);
            }
        }
    }

    public static function id($id){
        $strlen = LEN-strlen($id);
        $returnStr = "";
        if($strlen){
            for($i =0 ;$i<$strlen;$i++){
                $returnStr .= "0";
            }
            return $returnStr.$id;
        }
        return $id;
    }


    public static function Info($phone){
        $Info = Buy::where('phone',$phone)->first();
        if(!$Info){
            return 403;
        }else{
            if($Info->status == 6){
                return 403;
            }
            return 200;
        }
    }
}
