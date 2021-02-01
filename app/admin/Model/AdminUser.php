<?php
/**
 * Create By Kamon
 * User: Kamon
 * Date: {2021-02-01}
 * Time: {15:07}
 */
namespace app\admin\model;

use think\Model;

class AdminUser extends Model{

    public function getUserInfoByUsername($username){
        $where = ['username'=>$username];
        $result = $this->where($where)->find();
        return $result;
    }

}