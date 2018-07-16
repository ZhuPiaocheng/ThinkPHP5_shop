<?php
namespace app\admin\controller;
use think\Controller;
class Index extends Base{
    public function index()
    {
        return view();
    }
    //退出
    public function logout()
    {
		// 登陆状态
		session('adminUser', null);
		// 用户id
		session('adminUserId', null);
		// 用户名字
		session('adminUserName', null);

		$this->success('退出成功!', url('admin/Login/login'));
    }
}
