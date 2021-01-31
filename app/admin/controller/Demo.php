<?php
/**
 * Create By Kamon
 * User: Kamon
 * Date: {2021/1/30}
 * Time: {22:13}
 */

namespace app\admin\controller;

use app\BaseController;
use think\App;

class Demo extends BaseController
{
    public function index()
    {
        echo $abc;
    }

    public function abc()
    {
        dump($this->request->type);
    }
}