<?php
namespace app\admin\controller;

use think\Controller;


class Base extends Controller
{
	public function _initialize()
	{
		// 在任何方法之前执行
		if (! session('?adminUser')) {
			$this->error('请先登录', url('admin/Login/login'));
			die;
		}
	}
}