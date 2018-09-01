<?php

namespace App\Http\Middleware;

use Closure;

class ApiCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        return $next($request);
    }

    public function md($data){
        // 进行身份的验证
        if(!isset($data['phone']) || !isset($data['sign'])){
            // 没有传递phone有问题
            return 403;
        }else{
            $sign = md5($data['phone'].'yanzhiqiang');
            if($sign != $data['sign']){

            }
        }
    }
}
