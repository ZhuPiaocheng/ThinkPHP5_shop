<?php
use think\Route;
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


Route::get('/', 'index/Index/index');

// 登陆
Route::get('/admin/login', 'admin/Login/login');
Route::post('/admin/login', 'admin/Login/dologin');

// 退出
Route::get('/admin/logout', 'admin/Index/logout');

// 用户
Route::get('/admin/user:uid', 'admin/User/del');   //删除用户页面
Route::get('/admin/repass:uid', 'admin/User/resetPass');   //重置用户密码

Route::get('/admin/user', 'admin/User/show');
Route::get('/admin/user/add', 'admin/User/add');   //添加用户页面
Route::post('/admin/user/add', 'admin/User/doadd');   //添加用户页面

Route::get('/admin', 'admin/Index/index');




