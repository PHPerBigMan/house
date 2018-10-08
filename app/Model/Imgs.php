<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Imgs extends Model
{
    protected $table = 'imgs';
    protected $fillable = [
        'buyId','idCardfront','idCardback','accountBook','accountBookpersonal',
        'accountBookmain','housing_situation','personal_credit','fund_freezing',
        'other_housing_situation','divorce_img','security_img','other_img','death','marry',
        "child_img","inCome"
    ];

    /**
     * method: 临安及其他部分住房
     * author: hongwenyang
     * param:
     */
    public function getOtherHousingSituationAttribute($value){
        if($value){
            return json_decode($value,true);
        }
        return array();
    }
    /**
     * method: 离婚证明
     * author: hongwenyang
     * param:
     */
    public function getDivorceImgAttribute($value){
        if($value){
            return json_decode($value,true);
        }
        return array();
    }

    /**
     * method: 杭州地区住房证明
     * author: hongwenyang
     * param:
     */
    public function getHousingSituationAttribute($value){
        if($value){
            return json_decode($value,true);
        }
        return array();
    }

    /**
     * method: 个人征信
     * author: hongwenyang
     * param:
     */
    public function getPersonalCreditAttribute($value){
        if($value){
            return json_decode($value,true);
        }
        return array();
    }

    /**
     * method: 冻结资金
     * author: hongwenyang
     * param:
     */
    public function getFundFreezingAttribute($value){
        if($value){
            return json_decode($value,true);
        }
        return array();
    }
    /**
     * method: 社保证明
     * author: hongwenyang
     * param:
     */
    public function getSecurityImgAttribute($value){
        if($value){
            return json_decode($value,true);
        }
        return array();
    }

    /**
     * method: 其他购房者信息
     * author: hongwenyang
     * param:
     */
    public function getOtherImgAttribute($value){
        if($value){
            return json_decode($value,true);
        }
        return array();
    }
    /**
     * method: 子女户口本页面
     * author: hongwenyang
     * param:
     */
    public function getChildImgAttribute($value){
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
    public static function ImgData($data){

        $data = self::ImgString($data);

        $ifHave = Imgs::where('buyId',$data['buyId'])->value('id');

        foreach ($data as $k=>$v){
            if(empty($v) && $k!="housing_situation"){
                unset($data[$k]);
            }
        }
        if($ifHave){
            unset($data['idCard']);
            // 修改
            Imgs::where('id',$ifHave)->update($data);
        }else{
            Imgs::create($data);
        }
    }

    public static  function ImgString($data){
        $fillable = [
            'buyId','idCardfront','idCardback','accountBook','accountBookpersonal',
            'accountBookmain','housing_situation','personal_credit','fund_freezing',
            'other_housing_situation','divorce_img','security_img',"other_img",'death'
            ,'marry','idCard',"inCome","child_img"
        ];


        foreach ($data as $k=>$value){
            if(!in_array($k,$fillable) && $k!="housing_situation"){
                unset($data[$k]);
            }
            // 离婚证明
            if($k == "divorce_img" && $data['divorce_img']){
                $data['divorce_img'] = json_encode($data['divorce_img']);
            }
            // 杭州地区住房证明
            if($k == "housing_situation"){
                if($data['housing_situation']){
                    $data['housing_situation'] = json_encode($data['housing_situation']);
                }else{
                    $data['housing_situation']  = "";
                }
            }
            // 收入证明
            if($k == "inCome") {
                if ($data['inCome']) {
                    $data['inCome'] = json_encode($data['inCome']);
                } else {
                    $data['inCome'] = "";
                }
            }
            // 临安其他地区住房证明
            if($k == "other_housing_situation" && $data['other_housing_situation']){
                $data['other_housing_situation'] = json_encode($data['other_housing_situation']);
            }
            // 个人征信
            if($k == "personal_credit" && $data['personal_credit']){
                $data['personal_credit'] = json_encode($data['personal_credit']);
            }
            // 冻结资金
            if($k == "fund_freezing" && $data['fund_freezing']){
                $data['fund_freezing'] = json_encode($data['fund_freezing']);
            }
            // 社保证明
            if($k == "security_img" && $data['security_img']){
                $data['security_img'] = json_encode($data['security_img']);
            }
            // 其他购房者的图片信息
            if($k == "other_img" && $data['other_img']){
                $data['other_img'] = json_encode($data['other_img']);
            }
            // 未成年子女户口本数据
            if($k == "child_img") {
                if ($data['child_img']) {
                    $data['child_img'] = json_encode($data['child_img']);
                } else {
                    $data['child_img'] = "";
                }
            }
        }

        return $data;
    }

    /**
     * method: 处理其他购房者信息的图片用户后面删除使用
     * author: hongwenyang
     * param:
     */
    public static function changeOtherImgKey($img,$idCard){
        $img = json_decode($img,true);

        foreach($img as $k=>$v){
            $img[$k]['idCard'] = $idCard[$k];
        }

        return $img;
    }
}
