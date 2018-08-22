<?php

namespace App\Http\Controllers\Back;

use App\Model\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    public  function index(){
        $data = Config::first();
        if(!$data){
            $data = json_decode('{}');
            $data->project_name = "";
            $data->project_extension = "";
            $data->time = "";
            $data->updated_end = date("Y-m-d H:i:s",time());
            $data->img = "";
            $data->registration_notes = "";
            $data->frozen = "";
            $data->notice = "";
        }else{
            $data->time = $data->start_at . '~' .$data->end_at;
        }
        $title = 'config';
        return view('Back.Config.index',compact('data','title'));
    }

    function save(Request $request){
        $all = $request->except(['s']);

        if($all['time']){
            $img = explode('~',$all['time']);

            $all['start_at'] = $img[0];
            $all['end_at'] = $img[1];
        }
        if(Config::where('id',1)->first()){
            Config::where('id',1)->update([
                'project_name'      =>$all['project_name'],
                'project_extension' =>$all['project_extension'],
                'start_at'          =>$all['start_at'],
                'end_at'            =>$all['end_at'],
                'updated_end'       =>$all['updated_end'],
                'img'               =>$all['img'],
                'registration_notes'=>$all['registration_notes'],
                'frozen'            =>$all['frozen'],
                'notice'            =>$all['notice'],
            ]);
        }else{
            Config::create($all);
        }
        return back()->with('success', '密码不匹配或账号已被删除');

    }
}
