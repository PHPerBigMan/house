<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\AliSmsController;
use App\Model\Buy;
use App\Model\Disagreement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class IndexController extends Controller
{
    public function index(Request $request){
        $title = 'house';
        $keyword = $request->except(['s']);
        unset($keyword['page']);
        if($keyword){


            if($keyword['status'] == 6){
                $search = '';
                $phone  = '';
                $name   = '';
                $filable = 'all';
                if($keyword['phone']){
                    $filable = 'phone';
                    $search = $keyword['phone'];
                    $phone = $search;
                }
                if($keyword['name']){
                    $filable = 'name';
                    $search = $keyword['name'];
                    $name = $search;
                }

                if($filable == 'all'){
                    $data = Buy::orderBy('id','desc')
                        ->with([
                            'img',
                            'adminFirst',
                            'adminFinal'
                        ])
                        ->where('status','<>',6)
                        ->paginate(50);
                }else{

                    $data = Buy::orderBy('id','desc')
                        ->with([
                            'img',
                            'adminFirst',
                            'adminFinal'
                        ])
                        ->where($filable,'like',"%$search%")
                        ->where('status','<>',6)
                        ->paginate(50);
                }
                return view('Back.Index.index',compact('title','keyword','data','phone','name','filable'));
            }else{
                if($keyword['status'] == 8){
                    if(session('admin') == 1){
                        // 挂起中,针对每一个销售
                        $data = Buy::orderBy('id','desc')->with(['img', 'adminFirst', 'adminFinal'])
                            ->where([
                                'hang_up'=>1
                            ])->paginate(50);
                    }else{
                        // 挂起中,针对每一个销售
                        $data = Buy::orderBy('id','desc')->with(['img', 'adminFirst', 'adminFinal'])
                            ->where([
                                'firstTrial'=>session('admin'),
                                'hang_up'=>1
                            ])->paginate(50);
                    }

                }else{
                    $keyword['hang_up'] = 0;
                    $data = Buy::orderBy('id','desc')
                        ->with([
                            'img',
                            'adminFirst',
                            'adminFinal'
                        ])
                        ->where($keyword)
                        ->paginate(50);
                }
                return view('Back.Index.index',compact('title','keyword','data'));
            }
        }else{
            $keyword['status'] = 0;
            $data = Buy::orderBy('id','desc')
                ->with([
                    'img',
                    'adminFirst',
                    'adminFinal'
                ])
                ->where('status',0)
                ->paginate(50);
            return view('Back.Index.index',compact('title','keyword','data'));
        }
    }


    /**
     * method: 数据详情
     * author: hongwenyang
     * param: fromPage -> 0:待初审页面 1:初审中页面 2:初审通过页面 3:复审中
     */
    public function read($id,$type,$fromPage = 0){


        $data = Buy::with('img')->findOrFail($id);

        if($type == 1){
            if($data->status == 0){

                // 进行初审
                Buy::where(['id'=>$id])->update(['status'=>1,'firstTrial'=>session('admin')]);
            }else if($data->status == 2){
                // 进行复审
                Buy::where(['id'=>$id])->update(['status'=>3,'finalTrial'=>session('admin')]);
            }
        }

        $data = Buy::with('img')->findOrFail($id);

        if($data->img){
            if($data->img->inCome){
                $data->img->inCome = json_decode($data->img->inCome,true);
            }
        }

        return view('Back.Index.read',compact('data','type','fromPage'));
    }

    /**
     * method: 图片详情
     * author: hongwenyang
     * param:
     */
    public function img($id,$type){
        $data = Buy::with('img')->findOrFail($id);
        if($data->img) {
            if ($data->img->inCome) {
                $data->img->inCome = json_decode($data->img->inCome, true);
            }
        }
        return view('Back.Index.img',compact('data','type'));
    }

    /**
     * method: 图片详情
     * author: hongwenyang
     * param:
     */
    public function imgOther($id,$type){
        $data = Buy::with('img')->findOrFail($id);

//        if($data->img){
//            if($data->img->child_img){
//                foreach ($data->img->child_img as $k=>$v){
//                    $num    = $k+1;
//                    $imgSrc = $v['accountBookpersonal'];
////                    $idCard = $data->child[$k]['name'];
//                    dd( $data->child);
//                    $data->img->child_img_html = "<div class='swiper-slide  '  data-hash='child-img-$num'><img src='$imgSrc' alt='未成年人户口本个人页' title='child-img-'>";
//                }
//            }
//        }
//        dd($data->img);
        return view('Back.Index.imgOther',compact('data','type'));
    }
    /**
     * method: 添加不通过增加不通过理由
     * author: hongwenyang
     * param:
     */
    public function disagreement(Request $request){
        $all = $request->except(['s']);

        Disagreement::saveImg($all,session('admin'));
        return response()->json(['code'=>200]);
    }


    /**
     * method: 点击不通过按钮
     * author: hongwenyang
     * param:
     */
    public function nopass(Request $request){
        $all = $request->except(['s']);
        // 审核不通过
        // 如果存在复审人员的账号则视为复审不通过 否则为初审不通过
        $ifHaveFinal = Buy::where('id',$all['id'])->value('status');

        if($ifHaveFinal == 3){
            // 修改为复审不合格
            Buy::where('id',$all['id'])->update(['status'=>7]);
        }else{
            // 初审不合格
            Buy::where('id',$all['id'])->update(['status'=>4,'hang_up'=>0]);
        }

        return response()->json(['code'=>200]);
    }
    /**
     * method: 修改资料状态
     * author: hongwenyang
     * param:
     */
    public function status(Request $request){
        $all = $request->except(['s']);

        if($all['status'] == 8){
            // 暂时挂起
            Buy::where('id',$all['id'])->update([
                'hang_up'=>1
            ]);
        }else if($all['status'] == 9){
            // 超级管理员打回数据为审核中，删除审核不通过的数据
            Buy::where('id',$all['id'])->update(['status'=>1]);
            // 进行审核不通过数据的删除
            Disagreement::where('buyId',$all['id'])->delete();
        }else{
            Buy::where('id',$all['id'])->update([
                'status'=>$all['status']
            ]);
        }
    }


    /**
     * method: 导出excel
     * author: hongwenyang
     * param:
     */
    public function excel($type){
        $data =  excelData($type);
        if($type == 2){
            $title = "公司用表";
        }else if($type == 1){
            $title = "房管局用表";
        }else if($type == 3){
            $title = "公示表";
        }

        $ua = $_SERVER['HTTP_USER_AGENT'];
        $ua = strtolower($ua);
        if(preg_match('/msie/', $ua) || preg_match('/edge/', $ua)) {
            //判断是否为IE或Edge浏览器
            $title = str_replace('+', '%20', urlencode($title)); //使用urlencode对文件名进行重新编码

        }else{
            $title = iconv('UTF-8', 'GBK', $title);
        }

        Excel::create($title,function($excel) use ($data){
            $excel->sheet('score', function($sheet) use ($data){
                $sheet->setAutoSize(true);

                // 从第二行开始填充数据
                for($i=2;$i<=count($data['data'])+1;$i++){
                    $sheet->row($i,$data['data'][$i-2]);
                    $sheet->setHeight([
                        $i=>25
                    ]);
                    $sheet->setFontSize(14);
                }
                if($data['type'] == 1){
                    $head = "房管局用表";
                }else if($data['type'] == 2){
                    $head = "公司用表";
                }else{
                    $head = "公示表";
                }

                if($data['type']  == 1){
                    // 房管局
                    $sheet->mergeCells('A1:G1');
                    $sheet->setWidth([
                        'A'=>15,
                        'B'=>15,
                        'C'=>20,
                        'D'=>15,
                        'E'=>15,
                        'F'=>30,
                        'G'=>90,
                    ]);
                }else if($data['type'] == 2){
                    // 公司用表
                    $sheet->mergeCells('A1:T1');
                    $sheet->setWidth([
                        'A'=>15,
                        'B'=>13,
                        'C'=>20,
                        'D'=>13,
                        'E'=>13,
                        'F'=>25,
                        'G'=>15,
                        'H'=>13,
                        'I'=>13,
                        'J'=>15,
                        'K'=>13,
                        'L'=>13,
                        'M'=>13,
                        'N'=>15,
                        'O'=>15,
                        'P'=>10,
                        'Q'=>13,
                        'R'=>60,
                        'S'=>90,
                        'T'=>25,
                    ]);
                }else{
                    // 公式表
                    $sheet->mergeCells('A1:G1');

                    $sheet->setWidth([
                        'A'=>15,
                        'B'=>15,
                        'C'=>20,
                        'D'=>15,
                        'E'=>15,
                        'F'=>30,
                        'G'=>90,
                    ]);
                }

                $sheet->cell('A1', function($cell) use ($head) {
                    // manipulate the cell
                    $cell->setValue($head);
                    $cell->setFontSize(20);
                    $cell->setAlignment('center');
                });
//                $sheet->setAllBorders('thin');
            });

        })->export('xls');
    }


    public function excelDemo($type){
        $data =  excelData($type);
        if($type == 2){
            $title = "公司用表";
        }else if($type == 1){
            $title = "房管局用表";
        }else if($type == 3){
            $title = "公式表";
        }

        $ua = $_SERVER['HTTP_USER_AGENT'];
        $ua = strtolower($ua);
        if(preg_match('/msie/', $ua) || preg_match('/edge/', $ua)) {
            //判断是否为IE或Edge浏览器
            $title = str_replace('+', '%20', urlencode($title)); //使用urlencode对文件名进行重新编码

        }else{
            $title = iconv('UTF-8', 'GBK', $title);
        }


        Excel::create($title,function($excel) use ($data){
            $excel->sheet('score', function($sheet) use ($data){
                $sheet->setAutoSize(true);

                // 从第二行开始填充数据
                for($i=2;$i<count($data['data']);$i++){
                    $sheet->row($i,$data['data'][$i-2]);
                    $sheet->setHeight([
                        $i=>25
                    ]);

                }
                if($data['type'] == 1){
                    $head = "房管局用表";
                }else if($data['type'] == 2){
                    $head = "公司用表";
                }else{
                    $head = "公示表";
                }

                if($data['type']  == 1){
                    // 房管局
                    $sheet->mergeCells('A1:G1');
                    $sheet->setWidth([
                        'A'=>15,
                        'B'=>15,
                        'C'=>20,
                        'D'=>15,
                        'E'=>15,
                        'F'=>30,
                        'G'=>90,
                    ]);
                }else if($data['type'] == 2){
                    // 公司用表
                    $sheet->mergeCells('A1:T1');
                    $sheet->setWidth([
                        'A'=>15,
                        'B'=>13,
                        'C'=>20,
                        'D'=>13,
                        'E'=>13,
                        'F'=>25,
                        'G'=>15,
                        'H'=>13,
                        'I'=>13,
                        'J'=>15,
                        'K'=>13,
                        'L'=>13,
                        'M'=>13,
                        'N'=>15,
                        'O'=>15,
                        'P'=>10,
                        'Q'=>13,
                        'R'=>60,
                        'S'=>90,
                        'T'=>25,
                    ]);
                }else{
                    // 公式表
                    $sheet->mergeCells('A1:G1');

                    $sheet->setWidth([
                        'A'=>15,
                        'B'=>15,
                        'C'=>20,
                        'D'=>15,
                        'E'=>15,
                        'F'=>30,
                        'G'=>90,
                    ]);
                }

                $sheet->cell('A1', function($cell) use ($head) {
                    // manipulate the cell
                    $cell->setValue($head);
                    $cell->setFontSize(20);
                    $cell->setAlignment('center');
                });
                $sheet->setAllBorders('thin');
            });

        })->export('xls');
    }

    /**
     * method: 数据详情
     * author: hongwenyang
     * param:
     */
    public function readRandom($random){

        if($random == 0){
            // 初审
            $id = Buy::where('status',0)->value('id');
        }else if($random == 1){
            // 随机拿一条是他的数据
            $id = Buy::where('status',1)->where('firstTrial',session('admin'))->value('id');
        }else if($random == 2){
            // 待复审

            $id = Buy::where('status',2)->value('id');
        }else if($random == 3){
            // 随机拿一条是他的数据
            $id = Buy::where('status',3)->where('finalTrial',session('admin'))->value('id');
        }

        if($id){
            // 先查一次做一下判断
            $data = Buy::with('img')->findOrFail($id);
            if($data->status == 0){

                // 进行初审
                $status = Buy::where(['id'=>$id])->update(['status'=>1,'firstTrial'=>session('admin')]);

//                var_dump($status);
                echo "<br>";
            }else if($data->status == 2){
                // 进行复审
                Buy::where(['id'=>$id])->update(['status'=>3,'finalTrial'=>session('admin')]);
            }
            // 再把最新的数据查一次到前端显示出来
            $data = Buy::with('img')->findOrFail($id);
            $from = 'random';
            $type = 1;

//            dd($data);
//            var_dump($id);
            return view('Back.Index.read',compact('data','type','from'));
        }else{
            // 如果没有数据的话
            return back()->with('noUser', '暂时没有可审核的客户信息');
//            return redirect('/admin/index',403);
        }
    }


    public function latestStatus(Request $request){
        $status = Buy::where('id',$request->input('id'))->value('status');
        return response()->json(['data'=>$status]);
    }

    /**
     * method: 后台修改用户名
     * author: hongwenyang
     * param:
     */
    public function userEdit(Request $request){
        $all = $request->except(['s']);
        Buy::where('id',$all['id'])->update([
            'name'=>$all['name']
        ]);
    }

    public function file(Request $request){
        $all = $request->except(['s']);

        $file = Buy::where('id',$all['id'])->value('file');

        $file[$all['list']] = $all['value'];

        Buy::where('id',$all['id'])->update([
            'file'=>json_encode($file)
        ]);
    }


    /**
     * method: 发送短信通知
     * author: hongwenyang
     * param:
     */

    public function send(Request $request){
        $status = $request->input('status');

        $alisms         = new AliSmsController();
        if($status == 2){
            // 给全部成功的人发送短信
            $phone = Buy::where(['status'=>2,'is_send'=>0])->get();

            foreach ($phone as $v) {

                $content['name']            = $v->name;
                $content['houseName']       = HOUSENAME;
                $content['registration']    = $v->registration;
                // TODO::这里还是有点问题
                $bizid = $alisms->smsPass($v->phone, SIGNNAME, PASSCODE, $content);
//                sleep(1);
//                $alisms->querySendDetails($v->phone,$bizid);
//                Buy::where('phone',$v->phone)->update(['is_send'=>1]);
            }
        }else{
            $phone = Buy::where(['status'=>4,'is_send'=>0])->get();
            // 给全部失败的人发送短信
            foreach ($phone as $v) {
                $content['name']        = $v->name;
                $content['houseName']   = HOUSENAME;
                $alisms->smsPass($v->phone, SIGNNAME, NOPASS, $content);
                Buy::where('phone',$v->phone)->update(['is_send'=>1]);
            }
        }

        return response()->json(200);
    }

    public function ifHave($random){

        if($random == 0){
            // 初审
            $id = Buy::where('status',0)
                ->latest()
                ->value('id');
        }else if($random == 1){
            // 随机拿一条是他的数据
            $id = Buy::where('status',1)
                ->latest()
                ->where('firstTrial',session('admin'))->value('id');
        }else if($random == 2){
            // 待复审

            $id = Buy::where([
                ['status','=',2],
                ['firstTrial','<>',session('admin')]
            ])
                ->latest()
                ->value('id');
        }else if($random == 3){
            // 随机拿一条是他的数据
            $id = Buy::where('status',3)
                ->latest()
                ->where('finalTrial',session('admin'))->value('id');
        }else if($random == 8){
            // 随机拿一条这个销售的挂起用户
            $id = Buy::where('hang_up',1)
                ->latest()
                ->where('firstTrial',session('admin'))->value('id');
        }
        if($id){
            return response()->json(['code'=>200,'data'=>$id]);
        }
        return response()->json(['code'=>403]);
    }

    public function disagreementRead($id){
        // 获取当前状态
        $status     = Buy::findOrFail($id);
        $data       = Disagreement::where('buyId',$id)->get();
        $title      = "disagreement";
        return view('Back.UserList.disagreement',compact('data','title','status'));
    }
}
