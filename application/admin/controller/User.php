<?php
namespace app\admin\controller;
use think\Request;
use app\admin\model\Users;
use think\Db;

class User extends Base{
	public function show()
	{

		$data1 = Users::select();   //连接数据库，查询数据
		//$data = Db::name('Users')->order(['uid'])->paginate(5);
		$data = Db::name('users')->order(['uid'])->paginate(4);
		$count = Users::count();
	

		$sex = [
			'm' => 'male',
			'w' => 'female',
			'x' => 'unknown',
		];
		$this -> assign('count',$count);
		$this->assign('sex', $sex);   //渲染前台页面
		$this->assign('data', $data);
		//die;
		return $this->fetch();
	}

	//渲染添加用户页面
	public function add(){
		return $this -> fetch();
		//echo "add";
	}

	//用户添加操作
	public function doadd(Request $request){
		$data = $request->post();
		//var_dump($data);
		// 查询一条数据
		//验证用户名
		if (! preg_match('/^[\x{4E00}-\x{9FA5}A-Za-z0-9]{4,16}$/u', $data['uname'])) return $this->error('用户不符合标准. 只允许中文, 数字,字母组成, 且用户名必须为6-16位');
        // 判断用户名是否存在
		if (Users::where(['uname' => $data['uname']])->find()) return $this->error('用户名已存在');
		//验证性别是否为空
		$sex = ['m','w','x'];
		if(! in_array($data['sex'], $sex)) return $this-> error('非法数据');
		//验证手机
		if (! preg_match('/^(13[0-9]|14[5|7]|17[0-9]||15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/', $data['tel'])) return $this->error('手机号码错误');

		//验证密码
		if (! preg_match('/^[A-Za-z0-9_\.]{6,16}$/', $data['upwd'])) return $this->error('密码不符合规则 只允许:A-Za-z0-9_. 必须6-16位');

		if ($data['upwd'] != $data['re_upwd']) return $this->error('确认密码不一致,请重新输入.');

		unset($data['re_upwd']);

		//密码MD5加密
		$data['upwd'] = md5($data['upwd']);
		$data['create_at'] = time();  //添加时间（时间戳）
		$data['addr'] = '暂无';   //地址默认为 ‘暂无’

		//插入数据
		$res = Db::name('Users')->insert($data);
		if($res){
			$this->success('添加成功！',url('admin/User/show'));
		}else{
			$this -> error('添加失败');
		}
	}

	//删除用户
	public function del(Request $request){
		$uid = $request->param('uid');  //获取用户id
		//验证uid
		//if（! preg_match('/^\d+$/',$uid)） return $this ->error('非法数据');
		if (! preg_match('/^\d+$/', $uid)) return $this->error('非法数据1');
		//先查询是否存在该用户id
		$model = Users::find($uid);
		if(!$model) return $this->error('非法数据');
		//若存在就进行删除
		if($model->delete()){
			return $this->success('删除成功');
		}else{
			return $this->error('删除失败');
		}
	}

	//重置用户密码
	public function resetPass(Request $request){
		$str = "zxcvbnmasdfghjklqwertyuiop0987654321";
		$strlength = strlen($str);  //字符串长度
		$num = 15;    //密码长度
		$pass = '';   //存放随机密码
		for($i=0;$i<$num;$i++){
			$c = mt_rand(0,$strlength-1);
			$pass .=$str[$c];
		}
		//获取uid
		$uid = $request->param('uid');
		//验证uid
		if (! preg_match('/^\d+$/', $uid)) return $this->error('非法数据');
		// 2. 先查询有没有这条数据
		$model = Users::find($uid); // NULL
		if (! $model) return $this->error('非法数据');
		//保存数据
		$model -> upwd = md5($pass);
		if($model->save()){
			return $this->success('重置成功 pass:['.$pass.']');
		}else{
			return $this ->error('重置失败');
		}

	}

}