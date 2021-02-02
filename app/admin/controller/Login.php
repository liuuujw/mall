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

            $validate = new \app\admin\validate\AdminUser();
            if(!$validate->check($data)){
                return show(config("status.error"), $validate->getError(),[]);
            }


            if(empty($username) || empty($password) || empty($captcha)){
                return show(config("status.error"), "参数错误", []);
            }

            if(!captcha_check($captcha)){
                return show(config("status.error"), "验证码错误", []);
            }

            //获取用户信息
            $adminUserModel = new AdminUser();
            $userInfo = $adminUserModel->getUserInfoByUsername($username);
            if(empty($userInfo) || $userInfo->status == 0){
                return show(config("status.error"), "用户不存在", []);
            }
            $userInfo = $userInfo->toArray();

            //校验密码是否正确
            if(md5($password . '_' . $userInfo['salt']) != $userInfo['password']){
                return show(config("status.error"), "密码不正确", []);
            }

            unset($userInfo['password']);

            $updateDate = [
                'last_login_time' => time(),
                'last_login_ip' => request()->ip(),
            ];

            $res = $adminUserModel->updateById($userInfo['id'], $updateDate);

            if(empty($res)){
                return show(config("status.error"), '登录失败' );
            }

        }catch (\Exception $e){
            print_r($e->getMessage());die;
            // todo 记录日志
            return show(config("status.error"), '登录失败', []);

        }

        session(config("admin.session_admin"), $userInfo);
        return show(config("status.success"), '登录成功', $userInfo);

    }


    //退出登录
    public function logout(){
        //清空session
        \session(config("admin.session_admin"), null);
        //跳转连接
        return redirect('/admin/login/index');
    }
}