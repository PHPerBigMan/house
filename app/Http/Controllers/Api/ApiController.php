<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Buy;
use App\Model\Config;
use App\Model\Message;
use App\Model\UserList;
use Illuminate\Http\Request;
header("Access-Control-Allow-Origin: *");
class ApiController extends Controller
{
    public function __construct(Request $request)
    {

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
        $code           = 1234;
        // 执行发送短信的方法
        $all            = $request->all();

        $all['code']    = $code;
        $status         = Message::create($all);
        if($status){
            return response()->json(['code'=>200,'msg'=>'ok']);
        }
        return response()->json(['code'=>403,'msg'=>'send wrong']);
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
        $all = $request->except(['s']);

        $status = Message::check($all);

        if($status == 200){
            UserList::saveMore('register',$all['phone']);
            return response()->json(['code'=>200,'msg'=>"验证码正确"]);
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

        $status = Buy::saveAll($all);
        if($status == 403){
            return response()->json(['code'=>403,'msg'=>'登记已结束']);
        }
        if($status == 404){
            return response()->json(['code'=>403,'msg'=>'登记修改已截止']);
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

        return response()->json([
            'code'=>200,
            'msg' =>'ok',
            'data'=>Buy::getForm($all)
        ]);
    }

    /**
     * method: 保存图片到七牛云
     * author: hongwenyang
     * param:
     */
    public function qiniuImg(Request $request){
        $file = $request->file('file');
        $img = qiniuSave($file);
        if($img != 403){
            return response()->json(['code'=>200,'msg'=>'ok','data'=>$img]);
        }
        return response()->json(['code'=>403,'msg'=>'error']);
    }

    /**
     * method: 项目配置信息
     * author: hongwenyang
     * param:
     */
    public function config(){
        $data = Config::where('id',1)
            ->select('project_name','img','registration_notes','frozen','notice')
            ->first();
        return response()->json(['code'=>200,'data'=>$data]);
    }
}
