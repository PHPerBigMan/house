<?php

namespace App\Http\Controllers\Back;

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
                $filable = 'all';
                if($keyword['phone']){
                    $filable = 'phone';
                    $search = $keyword['phone'];
                }
                if($keyword['name']){
                    $filable = 'name';
                    $search = $keyword['name'];
                }

                if($filable == 'all'){
                    $data = Buy::orderBy('id','desc')
                        ->with([
                            'img',
                            'adminFirst',
                            'adminFinal'
                        ])
                        ->paginate(15);
                }else{
                    $data = Buy::orderBy('id','desc')
                        ->with([
                            'img',
                            'adminFirst',
                            'adminFinal'
                        ])
                        ->where($filable,'like',"%$search%")
                        ->paginate(15);
                }
            }else{
                $data = Buy::orderBy('id','desc')
                    ->with([
                        'img',
                        'adminFirst',
                        'adminFinal'
                    ])
                    ->where($keyword)
                    ->paginate(15);
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
                ->paginate(15);
        }
        return view('Back.Index.index',compact('title','keyword','data'));
    }


    /**
     * method: 数据详情
     * author: hongwenyang
     * param:
     */
    public function read($id,$type){
        $data = Buy::with('img')->findOrFail($id);
        if($data->status == 0){

            // 进行初审
            Buy::where(['id'=>$id])->update(['status'=>1,'firstTrial'=>session('admin')]);
        }else if($data->status == 2){

            if($data->firstTrial != session('admin')){
                // 进行复审
                Buy::where(['id'=>$id])->update(['status'=>3,'firstTrial'=>session('admin')]);
            }
        }
        return view('Back.Index.read',compact('data','type'));
    }

    /**
     * method: 图片详情
     * author: hongwenyang
     * param:
     */
    public function img($id,$type){
        $data = Buy::with('img')->findOrFail($id);

        return view('Back.Index.img',compact('data','type'));
    }

    /**
     * method: 添加不通过
     * author: hongwenyang
     * param:
     */
    public function disagreement(Request $request){
        $all = $request->except(['s']);

        Disagreement::saveImg($all,session('admin'));

        // 审核不通过
        Buy::where('id',$all['buyId'])->update(['status'=>4]);

        return response()->json(['code'=>200]);
    }

    /**
     * method: 修改资料状态
     * author: hongwenyang
     * param:
     */
    public function status(Request $request){
        $all = $request->except(['s']);
        Buy::where('id',$all['id'])->update([
            'status'=>$all['status']
        ]);
    }


    public function excel($type){
       $data =  excelData($type);
       if($type == 2){
           $title = "公司用表";
       }else if($type == 1){
           $title = "房管局用表";
       }else if($type == 3){
           $title = "公式表";
       }
        Excel::create($title,function($excel) use ($data){
            $excel->sheet('score', function($sheet) use ($data){
                $sheet->rows($data);
            });
        })->export('xls');
    }

    /**
     * method: 数据详情
     * author: hongwenyang
     * param:
     */
    public function readRandom($type){

        if($type == 0){
            // 初审
            $id = Buy::where('status',0)->value('id');
        }else if($type == 1){
            // 随机拿一条是他的数据
            $id = Buy::where('status',1)->where('firstTrial',session('admin'))->value('id');
        }else if($type == 2){
            // 待复审
            $id = Buy::where('status',2)->value('id');
        }else if($type == 3){
            // 随机拿一条是他的数据
            $id = Buy::where('status',3)->where('finalTrial',session('admin'))->value('id');
        }

        if($id){
            // 先查一次做一下判断
            $data = Buy::with('img')->findOrFail($id);
            if($data->status == 0){

                // 进行初审
                Buy::where(['id'=>$id])->update(['status'=>1,'firstTrial'=>session('admin')]);
            }else if($data->status == 2){
                // 进行复审
                Buy::where(['id'=>$id])->update(['status'=>3,'finalTrial'=>session('admin')]);
            }
            // 再把最新的数据查一次到前端显示出来
            $data = Buy::with('img')->findOrFail($id);
            $from = 'random';
            return view('Back.Index.read',compact('data','type','from'));
        }else{
            // 如果没有数据的话
            return view('Back.error.no');
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


    public function send(Request $request){
        $phone = explode(',',$request->input('phone'));
        dd($phone);

    }
}
