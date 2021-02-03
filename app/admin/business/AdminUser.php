<?php
/**
 * Create By Kamon
 * User: Kamon
 * Date: {2021/2/2}
 * Time: {23:45}
 */
namespace app\admin\business;

use \app\common\model\mysql\AdminUser as AdminUserModel;
use think\Exception;

class AdminUser {

    public $adminUserModel = null;

    public function __construct()
    {
        $this->adminUserModel = new AdminUserModel();
    }


    public function login($data){

        $userInfo = $this->getUserInfoByUsername($data['username']);
        if ($userInfo == false){
            throw new Exception('用户不存在');
        }

        //校验密码是否正确
        if(md5($data['password'] . '_' . $userInfo['salt']) != $userInfo['password']){
            throw new Exception('密码不正确');
        }

        unset($userInfo['password']);
        $updateDate = [
            'last_login_time' => time(),
            'last_login_ip' => request()->ip(),
            'update_time' => time(),
        ];
        $res = $this->adminUserModel->updateById($userInfo['id'], $updateDate);

        if(empty($res)){
            throw new Exception('登录失败');
        }

        session(config("admin.session_admin"), $userInfo);
        return true;

    }

    public function getUserInfoByUsername($username){
        //获取用户信息
        $userInfo = $this->adminUserModel->getUserInfoByUsername($username);
        if(empty($userInfo) || $userInfo->status == 0){
            return false;
        }
        $userInfo = $userInfo->toArray();
        return $userInfo;
    }

}