<?php

namespace App\Http\Controllers\Back;

use App\Model\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class loginController extends Controller
{
    public function check(Request $request){
        if($request->isMethod("Get")){
            return redirect('/admin/login');
        }else if($request->isMethod("Post")){
            $input = $request->all();

            $rules = array(
                'account' => 'bail|required|exists:admin,account',
                'password' => 'bail|required',
            );
            //自定义错误信息
            $messages = array(
                'required' => ':attribute 不能为空',
                'exists' => ':attribute 不存在'
            );
            //解释字段名
            $attributes = array(
                "account" => '用户名',
                'password' => '密码',
            );

            $validator = Validator::make($input, $rules, $messages, $attributes);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }


            $admin = Admin::where([
                'account'=>$input['account'],
                'is_del' =>0
            ])->first();
            if($admin->password != sha1($input['password'])){
                return back()->with('error', '密码不匹配或账号已被删除');
            }
            $request->session()->put('admin', $admin->id);
            return redirect('/admin/index');
        }
    }

    public function loginout(Request $request){
        $request->session()->put('admin', null);
        return redirect('/admin/login');
    }
}
