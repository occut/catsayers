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

class Node extends supcontroller
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
        $data = \app\index\model\Node::where($where)->paginate(10);
        $this->assign([
            "data" => $data,
        ]);
        return $this->fetch('/Admin/Node/index');

    }
    /**
     * 权限添加页面
     * @return \think\response\View
     */
    public function addview()
    {
        return view("/Admin/Node/addView");
    }
    /**
     * 权限添加数据
     */
    function add(){
        $data = $this->data();
        $rule = [
            ["nodename", "require|unique:Node", "请填写权限名称|权限名称已经存在"],
            ["auth", "require", "请填写模块名称"],
            ["url", "require", "请填写控制器名称"],
        ];
        $validate = new Validate($rule);
        if (!$validate->check($data)) {
            return['msg'=>$validate->getError(),'error'=>false];
        }
        $data['created_at'] = date("Y-m-d H:i:s");
        $privilege = \app\index\model\Node::create($data);
        if (!$privilege) {
            return['msg'=>"添加失败",'error'=>false];
        }
        return['msg'=>"添加成功",'error'=>false];
    }

}