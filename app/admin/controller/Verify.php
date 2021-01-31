<?php
/**
 * Create By Kamon
 * User: Kamon
 * Date: {2021/1/31}
 * Time: {20:39}
 */

namespace app\admin\controller;

use think\captcha\facade\Captcha;

class Verify
{
    public function index(){
        return Captcha::create("abc");
    }

}