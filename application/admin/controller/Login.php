<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use app\admin\model\Users;
class Login extends Controller{

	public function login()
	{
		return $this->fetch();
	}
	//登陆操作
	public function dologin(Request $request){
		//获取数据
		$data = $request->post();
		//1.判断用户是否存在
		$res = Users::where(['uname'=>$data['uname']])->find();
		if($res){
			if($res->upwd == md5($data['upwd'])){   //验证密码
				session('adminUser',true);
				//存放用户id
				session('adminUserId',$res->uid);
				//存放用户名
				session('adminUserName',$res->uname);
				if($res->sex == 'm'){
					$this->success('登陆成功！',url('admin/Index/index'));
				}else{
					$this->success('登陆成功！',url('admin/Index/index'));
				}
			}else{
				$this->success('登陆失败！');
			}
		}else{
			$this->success('登陆失败！');
		}
	}
}
?>