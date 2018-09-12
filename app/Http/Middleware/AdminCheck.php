<?php

namespace App\Http\Middleware;

use App\Model\Admin;
use Closure;

class AdminCheck
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
        // 获取后台用户的信息
        $id            = session('admin');
        if(empty($id)){
            return redirect('/admin/login');
        }
        return $next($request);
    }
}
