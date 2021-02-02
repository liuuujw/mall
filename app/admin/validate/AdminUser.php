<?php
/**
 * Create By Kamon
 * User: Kamon
 * Date: {2021/2/2}
 * Time: {23:46}
 */

namespace app\admin\validate;

use think\Validate;

class AdminUser extends Validate
{

    protected $rule = [
        'username' => 'require',
        'password' => 'require',
        'captcha' => 'require:checkCaptcha',
    ];

    protected $message = [
        'username' => '请输入用户名',
        'password' => '请输入密码',
        'captcha' => '验证码不能为空'
    ];

    protected function checkCaptcha($value, $rule, $data = [])
    {
        if (!captcha_check($value)) {
            return "请输入正确的验证码";
        }
        return true;
    }

}