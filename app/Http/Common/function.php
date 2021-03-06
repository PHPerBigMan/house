<?php
/**
 * Created by HongWenYang
 * User: hwy
 * Date: 2018/7/16
 * Time: 20:47
 * 说明:
 */
function qiniuSave($file){
    // 获取文件后缀
    $extension = $file->getClientOriginalExtension();
    $array = [
        'jpg',
        'png',
        'bmp',
        'gif',
        'jpeg'
    ];

    if(!in_array($extension,$array)){
        return 403;
    }

    if($file && $file->isValid()){
        $newFileName  = md5($file->getClientOriginalName() . time());


        $disk = \itbdw\QiniuStorage\QiniuStorage::disk('qiniu');

        $filename = $disk->put($newFileName,$file);

        $img_url = $disk->downloadUrl($filename);

        return $img_url;
    }

    return 403;
}


function excelData($type){

    $array = [];
    if($type == 1 || $type == 3){
        // 房管局用表
        $cellData = [
            [
                '购房登记号','购房人姓名','购房人证件号','是否无家庭房','档案编号','其他购房人及家庭成员姓名'
                ,'其他购房人及家庭成员证件号码'
            ],
        ];
        $status = [
            5
        ];
    }else if($type == 2){
        // 公司用表
        $cellData = [
            [
                '购房登记号','购房人姓名','购房人证件号码','是否无家庭房','查档编号','婚姻状况',
                '付款方式','贷款记录','首付比例','户籍','审核状态','销售顾问','面积段',
                '手机号码','有效地址','Email','是否购买车位','子女信息(姓名-证件号)','其他购房人信息(姓名-证件号-手机号)',
                '审核人'
            ],
        ];
        $status = [
            0,1,2,3,4,5
        ];
    }

    $data = \App\Model\Buy::whereIn('status',$status)->get();
    if($data->isNotEmpty()){
        if($type == 2){
            foreach($data as $k=>$v){
                $array[$k][0] = $v->registration;
                $array[$k][1] = $v->name;
                $array[$k][2] = "\t".$v->idCard."\t";
                $array[$k][3] = $v->haveHouse;
                if($v->file){
                    $file = implode(',',$v->file);
                }
                $array[$k][4] = $file;
                $array[$k][5] = $v->marriage;
                $array[$k][6] = $v->pay;
                $array[$k][7] = $v->loan;
                $array[$k][8] = $v->down;
                $array[$k][9] = $v->household;
                if($v->status == 0){
                    $status = "待审核";
                }else if($v->status == 1){
                    $status = "初审中";
                }else if($v->status == 2){
                    $status = "待复审";
                }else if($v->status == 3){
                    $status = "复审中";
                }else if($status == 4){
                    $status = "审核不通过";
                }else{
                    $status = "审核通过";
                }
                $array[$k][10] = $status;
                $array[$k][11] = $v->sale;
                $array[$k][12] = $v->area;
                $array[$k][13] = $v->phone;
                $array[$k][14] = $v->address;
                $array[$k][15] = $v->email;
                $array[$k][16] = $v->parking;
                $newChild = "";
                $otherHouse = "";
                if($v->child){
                    foreach ($v->child as $key=>$value){
                        $child[$k] = implode('-',$v->child[$key]);
                    }
                    $newChild = implode(',',$child);
                }
                $array[$k][17] = $newChild;
                if($v->other){
                    foreach ($v->other as $key=>$value){
                        $other[$k] = implode('-',$v->other[$key]);
                    }
                    $otherHouse = implode(',',$other);
                }
                $array[$k][18] = $otherHouse;
                $first = "";
                $final = "";
                if($v->firstTrial){
                    $first = \App\Model\Admin::where('id',$v->firstTrial)->value('account');
                }
                if($v->finalTrial){
                    $final = \App\Model\Admin::where('id',$v->firstTrial)->value('account');
                }
                $array[$k][19] = "初审人:".$first.'-复审人:'.$final;
            }
        }

        if($type == 1 || $type ==3){
            foreach($data as $k=>$v){
                $array[$k][0] = $v->registration;

                if($type == 3){
                    $array[$k][1] = hidestr($v->name,1,-1);
                    $array[$k][2] = hidestr("\t".$v->idCard."\t",6,8);
                }else{
                    $array[$k][1] = $v->name;
                    $array[$k][2] = "\t".$v->idCard."\t";
                }

                $array[$k][3] = $v->haveHouse;
                if($v->file){
                    $file = implode(',',$v->file);
                }
                $array[$k][4] = $file;
                if($v->other){
                    foreach ($v->other as $key=>$value){
                        if($type == 3){
                            $name[$k]   = hidestr($v->other[$key]['name'],1,-1);
                            $idCard[$k] = hidestr("\t".$v->other[$key]['idCard']."\t",6,8);
                        }else{
                            $name[$k]   = $v->other[$key]['name'];
                            $idCard[$k] = "\t".$v->other[$key]['idCard']."\t";
                        }

                    }
                }
                $array[$k][5] = implode(',',$name);
                $array[$k][6] = implode(',',$idCard);
            }
        }
    }

    if($array){
        $returnArray = array_merge($cellData,$array);
    }else{
        $returnArray = $cellData;
    }
    return $returnArray;
}

/**
 * method: 隐藏姓名
 * author: hongwenyang
 * param:
 */
function substr_cut($user_name){
    $strlen     = mb_strlen($user_name, 'utf-8');
    $firstStr     = mb_substr($user_name, 0, 1, 'utf-8');
    $lastStr     = mb_substr($user_name, -1, 1, 'utf-8');
    return $strlen == 2 ? $firstStr . str_repeat('*', mb_strlen($user_name, 'utf-8') - 1) : $firstStr . str_repeat("*", $strlen - 2) . $lastStr;
}

function hidestr($string, $start = 0, $length = 0, $re = '*') {
    if (empty($string)) return false;
    $strarr = array();
    $mb_strlen = mb_strlen($string);
    while ($mb_strlen) {//循环把字符串变为数组
        $strarr[] = mb_substr($string, 0, 1, 'utf8');
        $string = mb_substr($string, 1, $mb_strlen, 'utf8');
        $mb_strlen = mb_strlen($string);
    }
    $strlen = count($strarr);
    $begin  = $start >= 0 ? $start : ($strlen - abs($start));
    $end    = $last   = $strlen - 1;
    if ($length > 0) {
        $end  = $begin + $length - 1;
    } elseif ($length < 0) {
        $end -= abs($length);
    }
    for ($i=$begin; $i<=$end; $i++) {
        $strarr[$i] = $re;
    }
    if ($begin >= $end || $begin >= $last || $end > $last) return false;
    return implode('', $strarr);
}