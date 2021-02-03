<?php
/**
 * Create By Kamon
 * User: Kamon
 * Date: {2021-02-03}
 * Time: {13:46}
 */

namespace app\common\model\mysql;

use think\Model;

class AdminUser extends Model
{

    /**
     * 通过用户名获取用户信息
     * @param $username
     */
    public function getUserInfoByUsername($username)
    {
        if (empty($username)) {
            return false;
        }
        $where = ['username' => trim($username)];
        $result = $this->where($where)->findOrEmpty();
        return $result;
    }


    /**
     * 通过主键id更改用户信息
     * @param $id
     * @param $data
     * @return \app\admin\model\AdminUser|false
     */
    public function updateById($id, $data)
    {
        $id = intval($id);
        if (empty($id) || empty($data) || !is_array($data)) {
            return false;
        }

        $where = ['id' => $id];
        return $this->where($where)->update($data);

    }
}