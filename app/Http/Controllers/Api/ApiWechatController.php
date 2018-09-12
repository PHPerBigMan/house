<?php

namespace App\Http\Controllers\Api;

use App\Model\Appointment;
use App\Model\BalanceList;
use App\Model\FloorConfig;
use App\Model\Log;
use App\Model\Sale;
use App\Model\SaleCode;
use App\Model\User;
use App\Model\Visit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ApiWechatController
 * @package App\Http\Controllers\Api
 * 用于看房派小程序2.0功能的开发
 */

class ApiWechatController extends Controller
{
    protected  $config ;
    public function __construct()
    {
        $this->config = config("app.allStar");
    }

    /**
     * method: 小程序用code换取用户的 openid
     * author: hongwenyang
     * param:
     */
    public function getUserInfo(Request $request){

        $code       = $request->input('code');
        $pageType   = $request->input('pageType');
        $extension  = $request->input('extension');
        $nickname   = $request->input('nickname');
        $avatar     = $request->input('avatar');
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=".$this->config['appid'].
            "&secret=".$this->config['secret']."&js_code=".$code."&grant_type=authorization_code";

        $return_data = json_decode(file_get_contents($url));


//        Log::insert([
//            'title'=>'demo1',
//            'value'=> json_encode($pageType."#".$extension)
//        ]);
        if(!isset($return_data->errcode)){
            // 正常获取了用户的id
            User::addUserInfo($return_data->openid,$extension,$pageType,$nickname,$avatar);
            return response()->json(['code'=>200,'data'=>$return_data->openid,"msg"=>"获取成功"]);
        }else{
            return response()->json(['code'=>403,'msg'=>"code异常"]);
        }

    }

    /**
     * method: 预约看房楼盘配置
     * author: hongwenyang
     * param:
     */
    public function floorConfig(Request  $request){
        $openid=  $request->input('open_id');
        // 判断是否有预约
        $appointment = Appointment::where(['openid'=>$openid,'book_status'=>1])
            ->select([
                'book_name',
                'book_phone','book_time',
                "id"
            ])->first();

        if(!$appointment){
            $appointment = [];
        }
        $config_data = FloorConfig::select([
            "floor_name",
            "floor_address",
            "floor_longitude",
            "floor_latitude",
            "floor_zoom",
        ])->first();
        return response()->json(['code'=>200,'msg'=>"获取成功",'data'=>empty($config_data)?[]:$config_data,'appointment'=>$appointment]);
    }


    /**
     * method: 预约
     * author: hongwenyang
     * param:
     */

    public function addBook(Request $request){
        $data = $request->except(['s']);
        $status = Appointment::addBook($data);
        if($status == 200){
            $appointment = Appointment::where(['openid'=>$data['open_id'],'book_status'=>1])->value('id');
            return response()->json(['code'=>200,'msg'=>"预约成功",'data'=>$appointment]);
        }else if ($status == 404){
            return response()->json(['code'=>403,'msg'=>"重复预约"]);
        }
        return response()->json(['code'=>403,'msg'=>"预约失败"]);
    }

    /**
     * method: 取消预约
     * author: hongwenyang
     * param:
     */

    public function cancelBook(Request $request){
        $id = $request->input('id');

        $status = Appointment::where('id',$id)->update(['book_status'=>0]);

        if($status){
            return response()->json(['code'=>200,'msg'=>"取消成功"]);
        }
        return response()->json(['code'=>403,'msg'=>"取消失败"]);
    }


    /**
     * method: 推广入驻
     * author: hongwenyang
     * param:
     */
    public function addSale(Request $request){
        $add = $request->except(['s']);

        $status = Sale::addSale($add);

        if($status == 200){
            return response()->json(['code'=>200,'msg'=>"添加成功"]);
        }else if($status == 401){
            return response()->json(['code'=>403,'msg'=>"该手机号已添加"]);
        }else if($status == 402){
            return response()->json(['code'=>403,'msg'=>"身份识别码已被使用"]);
        }else if($status == 403){
            return response()->json(['code'=>403,'msg'=>"无效的身份识别码"]);
        }else if($status == 405){
            return response()->json(['code'=>403,'msg'=>"身份识别码未分配不可使用"]);
        }
    }



    /**
     * method: 销售人员可以看的记录
     * author: hongwenyang
     * param:
     */
    public function appointmentList(Request $request){
        $data = $request->except(['s']);

        $returnData = Appointment::getlist($data);

        return response()->json(['code'=>200,"msg"=>"获取成功","data"=>$returnData]);
    }


    /**
     * method: 获取销售类型
     * author: hongwenyang
     * param:
     */
    public function saleType(Request $request){
        $open_id    = $request->input('open_id');
        $type       = User::where('openid',$open_id)->value('type');
        $isAdd      = Sale::where('open_id',$open_id)->value('id') ? "已添加" : "未添加";
        return response()->json(['code'=>200,"msg"=>"获取成功","data"=>$type,'isAdd'=>$isAdd]);

    }


    /**
     * method: 判断是否添加为推广人员
     * author: hongwenyang
     * param:
     */
    public function isAddSale(Request $request){
        $openid = $request->input('open_id');

        $isAdd = Sale::where('open_id',$openid)->value('id') ? "已添加" : "未添加";

        return response()->json(['code'=>200,"msg"=>"获取成功","data"=>$isAdd]);
    }


    /**
     * method: 浏览记录
     * author: hongwenyang
     * param:
     */
    public function visitList(Request $request){
        $openid         = $request->input('open_id');
        $extension      = User::where('openid',$openid)->value('id');
        $data           = Visit::where('extension',$extension)->select([
            "created_at",
            "openid",
        ])->get();
        if($data->isNotEmpty()){
            foreach ($data as $k=>$v){
                $v->avatar      = User::where('openid',$v->openid)->value('avatar');
                $v->nickname    = User::where('openid',$v->openid)->value('nickname');
                unset($data[$k]->openid);
            }
        }

        return response()->json(['code'=>200,'msg'=>'获取成功','data'=>$data]);
    }

    /**
     * method: 我的推广
     * author: hongwenyang
     * param:
     */
    public function  extensionList(Request $request){
        $openid = $request->input('open_id');

        $data = Sale::extensionList($openid);

        return response()->json(["code"=>200,"msg"=>'获取成功',"data"=>$data]);
    }

    /**
     * method: 我的奖励
     * author: hongwenyang
     * param:
     */
    public  function balanceList(Request $request){
        $openid         = $request->input('open_id');
        $extension      = User::where('openid',$openid)->value('id');
        $data           = BalanceList::getlist($extension);
        return response()->json(['code'=>200,'msg'=>'获取成功','data'=>$data]);
    }





    public function saleCode(){
        // 10000-19999 销售
        // 20000-29999 中介
        for ($i=0;$i<1000;$i++){
//            $math = rand(20000,29999);
//            if(!SaleCode::where('code',$math)->value('id')){
//                SaleCode::insert(['code'=>$math,'type'=>1]);
//            }
        }
    }
}
