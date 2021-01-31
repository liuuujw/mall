<?php
/**
 * Create By Kamon
 * User: Kamon
 * Date: {2021/1/30}
 * Time: {23:40}
 */
namespace app\admin\controller;

use app\BaseController;
use think\facade\View;

class Login extends BaseController{


    public function index(){
        return View::fetch('login');
    }
}