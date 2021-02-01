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
use app\admin\model\AdminUser;
use think\facade\Session;

class Login extends BaseController{


    public function index(){
        return View::fetch('login');
    }

    public function test(){
    dump(md5('123456_kamon'));
    dump(time());
    }

    public function check(){

        if(!$this->request->isAjax()){
            return show(config("status.error"), "非法请求", []);
        }

        $username = $this->request->param('username', '', 'trim');
        $password = $this->request->param('password', '', 'trim');
        $captcha = $this->request->param('captcha', '', 'trim');

        if(empty($username) || empty($password) || empty($captcha)){
            return show(config("status.error"), "参数错误", []);
        }

        if(!captcha_check($captcha)){
            return show(config("status.error"), "验证码错误", []);
        }

        //获取用户信息
        $adminUserModel = new AdminUser();
        $userInfo = $adminUserModel->getUserInfoByUsername($username);
        if(empty($userInfo) || $userInfo['status'] == 0){
            return show(config("status.error"), "用户不存在", []);
        }
        $userInfo = $userInfo->toArray();

        //校验密码是否正确
        if(md5($password . '_' . $userInfo['salt']) != $userInfo['password']){
            return show(config("status.error"), "密码不正确", []);
        }

        unset($userInfo['password']);
        return show(config("status.success"), '登录成功', $userInfo);



    }
}