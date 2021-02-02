<?php
/**
 * Create By Kamon
 * User: Kamon
 * Date: {2021/2/2}
 * Time: {21:06}
 */

namespace app\admin\middleware;

class Auth
{
    public function handle($request, \Closure $next)
    {
        //判断session是否存在，以及控制器是否为login， 跳转登录页面
        if(empty(session(config("admin.session_admin"))) && !preg_match('/login/', $request->pathinfo())){
            return redirect('/admin/login/index');
        }
        // $response 前是前置中间件
        $response = $next($request);

        //后置中间件
//        if(empty(session("admin.session_admin")) && $request->controller() != 'login'){
//            return redirect('/admin/login/index');
//        }

        return $response;
    }
}