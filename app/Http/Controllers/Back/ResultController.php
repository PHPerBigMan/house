<?php

namespace App\Http\Controllers\Back;

use App\Model\Buy;
use App\Model\Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
class ResultController extends Controller
{
    public function excelLoad(Request $request){
        $file = $request->file('file');

        Excel::load($file, function($reader) use ($file){
            $reader = $reader->getSheet(0);
            $data = $reader->toArray();

            foreach ($data as $k=>$v){
                $isHave = Buy::where('phone',$v[0])->first();
                if($isHave){
                    $create['phone']        = $v[0];
                    $create['registration'] = $isHave->registration;
                    $create['getHouse']     = $v[1];
                    $create['name']         = $v[2];
                    if(Result::where('phone',$v[0])->value('id')){
//                        Result::where('phone',$v[0])->update([
//                            'result'=>$create['result']
//                        ]);
                    }else{
                        Result::create($create);
                    }
                }
            }
        });
        return response()->json(200);
    }

    public function resultPage(){
        $title = "resultPage";
        return view('Back.result.test',compact('title'));
    }

    /**
     * method: 获取身份证判断是否有结果
     * author: hongwenyang
     * param:
     */
    public function search(Request $request){


        // 根据身份证号查询数据
        $id = Buy::where('idCard',$request->input('idCard'))->first();

        if($id){
            $result = Result::where(['phone'=>$id->phone,'registration'=>$id->registration])->first();

            if($result){
                return response()->json(['code'=>200,'id'=>$id->id]);
            }
            return response()->json(['code'=>403]);
        }else{
            return response()->json(['code'=>403]);
        }
    }

    /**
     * method: 身份证查询返回的页面
     * author: hongwenyang
     * param:
     */
    public function read($id,$type,$fromPage = 0){

        $data = Buy::with(['img','result'])->findOrFail($id);

        return view('Back.result.read',compact('data','type','fromPage'));
    }
}
