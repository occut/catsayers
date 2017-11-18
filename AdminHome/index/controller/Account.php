<?php
/**
 * 账号管理
 * Created by PhpStorm.
 * User: qiangbi
 * Date: 17-3-10
 * Time: 下午6:34
 */

namespace app\index\controller;


use think\Validate;

class Account extends supcontroller
{
    /**
     * 首页html展示
     * @return mixed
     */
    public function index()
    {
        $account = $this->request->get("username");
        $where = [];
        if (!empty($account)) {
            $where['username|ip|updated_at'] = ['like',"%$account%"];
        }
        $data = \app\index\model\Adminstrator::where($where)->paginate(10);
        $this->assign([
            "data" => $data,
        ]);
        return $this->fetch('/Admin/Account/index');

    }

}