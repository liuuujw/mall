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
use app\common\model\mysql\AdminUser;
use think\facade\Session;

class Login extends BaseController {

    public function initialize()
    {

    }

    public function index(){
        return View::fetch('login');
    }

    public function test(){
    dump(md5('123456_kamon'));
    dump(time());
    }

    public function check(){


        try{
            if(!$this->request->isAjax()){
                return show(config("status.error"), "非法请求", []);
            }

            $username = $this->request->param('username', '', 'trim');
            $password = $this->request->param('password', '', 'trim');
            $captcha = $this->request->param('captcha', '', 'trim');

            $data = [
              'username'=>$username,
              'password'=>$password,
              'captcha'=>$captcha
            ];

            /**
             * 参数验证放在validate中
             */
            $validate = new \app\admin\validate\AdminUser();
            if(!$validate->check($data)){
                return show(config("status.error"), $validate->getError(),[]);
            }


//            if(empty($username) || empty($password) || empty($captcha)){
//                return show(config("status.error"), "参数错误", []);
//            }
//
//            if(!captcha_check($captcha)){
//                return show(config("status.error"), "验证码错误", []);
//            }


            $adminUserObj = new \app\admin\business\AdminUser();
            $result = $adminUserObj->login($data);
            if($result){
                return show(config("status.success"), '登录成功', []);
            }
            return $result;
        }catch (\Exception $e){
            // todo 记录日志
            return show(config("status.error"), $e->getMessage(), []);
        }

    }


    //退出登录
    public function logout(){
        //清空session
        \session(config("admin.session_admin"), null);
        //跳转连接
        return redirect('/admin/login/index');
    }
}