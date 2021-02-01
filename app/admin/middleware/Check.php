<?php
/**
 * Create By Kamon
 * User: Kamon
 * Date: {2021/1/30}
 * Time: {22:32}
 */

namespace app\admin\middleware;

class Check
{
    public function handle($request, \Closure $next){

//        $request->type = "kamon-type";
        return $next($request);
    }


    /**
     * 中间件调度
     * @param \think\Response $response
     */
    public function end(\think\Response $response){
        //结束是记录请求日志

    }
}