<?php

namespace App\Http\Controllers\Back;

use App\Model\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index(){
        $data = Admin::where('is_del',0)->paginate(15);
        $title = 'account';
        return view('Back.Admin.index',compact('data','title'));
    }

    public function read($id){
        if($id){
            $data = Admin::findOrFail($id) ;
        }else{
            $data = json_decode('{}');
            $data->account = '';
            $data->user    = '';
            $data->password = '';
            $data->id      = 0;
        }
        $title = 'account';
        return view('Back.Admin.read',compact('data','title'));
    }


    public function save(Request $request){
        $all = $request->except(['s']);
        $all['password']   = sha1($all['password']);
        if(!$all['id']){
            // 新增
            $status = Admin::create($all);
        }else{
            Admin::where('id',$all['id'])->update([
                'account'=>$all['account'],
                'password'=>$all['password'],
                'user'=>$all['user'],
            ]);
        }
        return response()->json(['code'=>200]);
    }


    public function del(Request $request){
        $id = $request->input('id');
        Admin::where('id',$id)->update([
            'is_del'=>1
        ]);
    }
}
