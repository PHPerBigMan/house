<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AliSmsController;
use App\Http\Controllers\Controller;
use App\Model\Buy;
use App\Model\Config;
use App\Model\Disagreement;
use App\Model\Log;
use App\Model\Message;
use App\Model\Result;
use App\Model\UserList;
use Flc\Dysms\Client;
use Flc\Dysms\Request\SendSms;
use Illuminate\Http\Request;
header("Access-Control-Allow-Origin: *");
class ApiController extends Controller
{
    public function __construct()
    {
//        $this->sms = $sms;
    }

    /**
     * method: 发送短信
     * author: hongwenyang
     * param:
     */
    public function send(Request $request){
        if($request->isMethod("Get")){
            return response()->json(['msg'=>'Unauthorized access']);
        }
        $code  = rand(1000,9999);
        // 执行发送短信的方法
        $all            = $request->all();

        $all['code']    = $code;
        $alisms         = new AliSmsController();
        $message = $alisms->sms($all['phone'],SIGNNAME,'SMS_140070108',$code);
        if($message == 200){
            $status         = Message::create($all);
            if($status){
                return response()->json(['code'=>200,'msg'=>'ok']);
            }
            return response()->json(['code'=>403,'msg'=>'send wrong']);
        }else{
            return response()->json(['code'=>403,'msg'=>'短信发送异常']);
        }

    }

    /**
     * method: 短信的验证
     * author: hongwenyang
     * param:
     */
    public function checkMessage(Request $request){
        if($request->isMethod("Get")){
            return response()->json(['msg'=>'Unauthorized access']);
        }
        $all        = $request->except(['s']);
        $config = Config::where('id',1)->first();
        if(time() < strtotime($config->start_at)){
            return response()->json(['code'=>403,'msg'=>'登记尚未开始']);
        }

        if(time() > strtotime($config->end_at)){
            // 判断用户是否填写过资料
            if(Buy::Info($all['phone']) == 403){
                return response()->json(['code'=>403,'msg'=>'登记已结束']);
            }
        }
        $status     = Message::check($all);
        if($status == 200){
            UserList::saveMore('register',$all['phone']);
            $save['phone'] = $all['phone'];
            $save['sign']  = $all['sign'];
            Buy::saveMobileUser($save);
            $userStatus = Buy::where('phone',$all['phone'])->value('status');
            if(in_array($userStatus,[0,1,2,3,4,7,5])){
                $userStatus = "跳";
            }else{
                $userStatus  = "不跳" ;
            }
            return response()->json(['code'=>200,'msg'=>"验证码正确",'status'=>$userStatus]);
        }
        return response()->json(['code'=>403,'msg'=>'验证码有误']);
    }

    /**
     * method: 保存表单数据
     * author: hongwenyang
     * param:
     */
    public function saveBuy(Request $request){
        if($request->isMethod("Get")){
            return response()->json(['msg'=>'Unauthorized access']);
        }
        $config = Config::where('id',1)->first();
        if(time() < strtotime($config->start_at)){
            return response()->json(['code'=>403,'msg'=>'登记尚未开始']);
        }

        $all = $request->except(['s']);

        $all['phone'] = Buy::where('md5',$all['phone'])->value('phone');
        if(!$all['phone']){
            return response()->json(['code'=>403,'msg'=>'登录失效,请重新登录']);
        }

        $status = Buy::saveAll($all);
        if($status == 406){
            return response()->json(['code'=>403,'msg'=>'其他购房人信息为必填项']);
        }
        if($status == 403){
            return response()->json(['code'=>403,'msg'=>'登记已结束']);
        }
        if($status == 404){
            return response()->json(['code'=>403,'msg'=>'登记修改已截止']);
        }

        if($status == 407){
            return response()->json(['code'=>403,'msg'=>'该身份证号已被添加为其他购房者,不可作为主购房人']);
        }
        return response()->json(['code'=>200,'msg'=>'save success']);
    }


    /**
     * method: 获取各个页面的数据
     * author: hongwenyang
     * param:
     */
    public function get(Request $request){
        if($request->isMethod("Get")){
            return response()->json(['msg'=>'Unauthorized access']);
        }
        $all = $request->except(['s']);
        $all['phone'] = Buy::where('md5',$all['phone'])->value('phone');

        if(!$all['phone']){
            return response()->json(['code'=>403,'msg'=>'登录失效,请重新登录']);
        }
        return response()->json([
            'code'=>200,
            'msg' =>'ok',
            'data'=>Buy::getForm($all),
            'isBuy'=>ISBUY
        ]);
    }

    /**
     * method: 保存图片到七牛云
     * author: hongwenyang
     * param:
     */
    public function qiniuImg(Request $request){
        /*七牛云保存*/

//        $file = $request->file('file');
//        $img = qiniuSave($file);
//        return response()->json(['code'=>403,'msg'=>$img]);
//
//        if($img != 403){
//            return response()->json(['code'=>200,'msg'=>'ok','data'=>$img]);
//        }
//        return response()->json(['code'=>403,'msg'=>'上传错误']);

        /*file文件本地保存*/
        /*base64本地保存*/
        $base64_image_content = $request->input('file');


        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
            $type = $result[2];

            $array = [
                'jpg',
                'png',
                'bmp',
                'gif',
                'jpeg',
                'JPG',
                'PNG',
                'BMP',
                'JPEG',
            ];
            if(!in_array($type,$array)){
                return response()->json(['code'=>403,'msg'=>'文件格式有误','data'=>""]);
            }
            $new_file = "user/".time().rand(1000,9999).".{$type}";

            $r = file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)));

            if($r){
                return response()->json(['code'=>200,'msg'=>'ok','data'=>URL1.$new_file]);
            }
            return response()->json(['code'=>403,'msg'=>'no','data'=>""]);
        }
    }


    public function qiniuImgBack(Request $request){
        /*七牛云保存*/

        $file = $request->file('file');
        $img = qiniuSave($file);

        if($img != 403){
            return response()->json(['code'=>200,'msg'=>'ok','data'=>$img]);
        }
        return response()->json(['code'=>403,'msg'=>'上传错误']);

    }
    /**
     * method: 小程序使用的保存图片
     * author: hongwenyang
     * param:
     */
    public function wechatImg(Request $request){

        if($request->hasFile('file')){
            $file = $request->file('file');
            $extension = $file->extension();
            $array = [
                'jpg',
                'png',
                'bmp',
                'gif',
                'jpeg',
                'JPG',
                'PNG',
                'BMP',
                'JPEG',
            ];
            if(!in_array($extension,$array)){
                return response()->json(403);
            }
            $newName   = time().rand(100000,999999).'.'.$extension;
            $path = URL.$file->storeAs('user', $newName,'user');
            return $path;
        }else{
            return response()->json(403);
        }
    }
    /**
     * method: 项目配置信息
     * author: hongwenyang
     * param:
     */
    public function config(Request $request){
        $data = Config::where('id',1)
            ->select('project_name','img','registration_notes','frozen','notice','updated_end',"end_at")
            ->first();
        $data->end_msg  = "";
        $data->isBuy        = ISBUY;
        $data->bankImgtype  = BANKIMGTYPE;
        $phone = $request->input('phone');

        if(time() > strtotime($data->end_at)){
            $data->end_msg        = "登记已结束";
        }

        if(time() > strtotime($data->updated_end)){
            $data->end_msg        = "登记已结束";
        }

        if($phone){
            $phone = Buy::where('md5',$phone)->value('phone');

            if(!$phone){
                return response()->json(['code'=>403,'msg'=>'登录失效,请重新登录']);
            }
            $status = Buy::where('phone',$phone)->get();


            if($status->isNotEmpty()){
                if(in_array($status[0]->status,[0,1,2,3])){
                    $data->status = "审核中";
                }else if(in_array($status[0]->status,[4,7])){
                    $data->status = "审核不通过";

                }else if($status[0]->status == 5){
                    $data->status  = "审核通过";
                }else if($status[0]->status == 6){
                    $data->status  = "资料没填完";
                }
            }else{

                $data->status  = "第一次进来";
            }
        }
        return response()->json(['code'=>200,'data'=>$data]);
    }

    /**
     * method: 重新提交
     * author: hongwenyang
     * param:
     */

    public function sendAgain(Request $request){
        $phone = $request->input('phone');

        $phone = Buy::where('md5',$phone)->value('phone');

        if(!$phone){
            return response()->json(['code'=>403,'msg'=>'error check']);
        }
        Buy::where('phone',$phone)->update(['status'=>6,'is_send'=>0]);
        // 获取buyId
        $buyId = Buy::where('phone',$phone)->value('id');
        Disagreement::where('buyId',$buyId)->delete();
        return response()->json(['code'=>200]);
    }


    public function sendMessageAli(){
//        $id = 1000;
//        $strlen = LEN-strlen($id);
//        $returnStr = "";
//        if($strlen){
//           for($i =0 ;$i<$strlen;$i++){
//               $returnStr .= "0";
//           }
//            dd($returnStr.$id);
//        }
//        dd($id);
//        dd(strlen(299)*"0");
//        $data['phone'] = 17751130708;
//        $data['name']  = "闫志强";
//        $data['floor']  = "盛世豪庭";
//        $data['number']  = "SSHT1023";
//        $url = "http://api.zhuanxinyun.com/api/v2/sendSms.json?appKey=HsBtjDV6WbLMfO7BBmkozzZtzELlAy02&appSecret=0d2ab2ab591dc7c7b357144ad25f3d675687&phones=".$data['phone']."&content=【售房派】".$data['name'].":您申请".$data['floor']."的资料已通过审核,您的登记编号为:".$data['number'].",此编号为参与摇号的身份识别号,不作为选房顺序号。";
//        $url = "http://api.zhuanxinyun.com/api/v2/sendSms.json?appKey=HsBtjDV6WbLMfO7BBmkozzZtzELlAy02&appSecret=0d2ab2ab591dc7c7b357144ad25f3d675687&phones=".$data['phone']."&content=【售房派】".$data['name'].":您申请".$data['floor']."的资料未通过审核，请尽快联系置业顾问更新相关材料。";
//        $url = "http://api.zhuanxinyun.com/api/v2/sendSms.json?appKey=HsBtjDV6WbLMfO7BBmkozzZtzELlAy02&appSecret=0d2ab2ab591dc7c7b357144ad25f3d675687&phones=".$data['phone']."&content=【售房派】您的短信验证码为:".rand(100000,999999);
//        $result = json_decode(file_get_contents($url),true);
//        dd($result);
//        $curl = curl_init();
//        curl_setopt($curl, CURLOPT_URL, $url);
//        curl_setopt($curl, CURLOPT_HEADER, 1);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//        $data = curl_exec($curl);
//        curl_close($curl);
//        dd(json_decode($data,true));
        $send = "审核";
        $content['name']         = "房产证";
        $content['houseName']    = SIGNNAME;
//        $content['type']         = $send;
        $content['registration'] = "aaaa";
        $alisms         = new AliSmsController();
        dd($alisms->smsPass(13858126467,SIGNNAME,PASS1,$content));
        dd($message = $alisms->sms(17751130708,SIGNNAME,'SMS_140070108',123456));
//        dd($alisms->smsPass(17321485804,SIGNNAME,PASSCODE,$content));

//        $content['password']    = HOUSENAME;
////        $content['submittime']          = date("Y-m-d");
//
//        dd($alisms->smsPass(17751130708,"售房派",NOPASSOTHER,$content));

//        $alisms->Search();
    }

    public function idCard(Request $request){
       $data = $request->except(['s']);
        $url = "http://route.showapi.com/1072-1?showapi_appid=44372&showapi_sign=05aee77ddd534a3c80643a72cc8c9b09&acct_pan=&name=".$data['name']."&idcard=".$data['idcard'];
        $result = json_decode(file_get_contents($url));

        if($result->showapi_res_code == 0){
            if ($result->showapi_res_body->code == 0) {
                return response()->json(['code'=>200]);
            }
            return response()->json(['code'=>403]);
        }
    }


    /**
     * method: 查询摇号结果
     * author: hongwenyang
     * param:
     */
    public function result(Request $request){
        $get    = $request->except(['s']);
        if(!Buy::where($get)->value('id')){
            return response()->json(['code'=>403,'msg'=>'无效的手机号或编号']);
        }
        $data   = Result::where($get)->first();
        if($data){

            $data->result = $data->result == 0 ? "未中签" : "已中签";

            $name = Buy::where($get)->value('name');

            return response()->json(['code'=>200,'msg'=>'查询成功','result'=>$data->result,'name'=>$name]);
        }else{
            return response()->json(['code'=>403,'msg'=>'暂无结果']);
        }
    }


    /**
     * method: 获取审核通过之后图片的数据
     * author: hongwenyang
     * param:
     */
    public function getImg(Request $request){
        $phone = $request->input('phone');
        if($phone){
            $phone = Buy::where('md5',$phone)->value('phone');
            if(!$phone){
                return response()->json(['code'=>403,'msg'=>'登录失效,请重新登录']);
            }else{
                $data = Buy::where('phone',$phone)->select('name','idCard','registration','status')->first();
                if($data){
                    if($data->status == 5){
                        // 审核通过
                        return response()->json(['code'=>200,'msg'=>"获取成功",'data'=>$data]);
                    }
                    return response()->json(['code'=>403,'msg'=>"审核暂未通过"]);
                }
                return response()->json(['code'=>403,'msg'=>"获取异常"]);
            }
        }
    }
}
