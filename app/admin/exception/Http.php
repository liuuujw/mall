<?php
/**
 * Create By Kamon
 * User: Kamon
 * Date: {2021/1/30}
 * Time: {22:21}
 */

namespace app\admin\exception;

use think\exception\Handle;
use think\Response;
use Throwable;

class Http extends Handle
{
    public $httpStatus = 500;

    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request   $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        return parent::render($request, $e);
        if(method_exists($e, 'getStatusCode')){
            $httpStatus = $e->getStatusCode();
        }else{
            $httpStatus = $this->httpStatus;
        }
        // 添加自定义异常处理机制
        return show(config("status.error"),$e->getMessage(), [], $httpStatus);
    }
}