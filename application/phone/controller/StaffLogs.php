<?php
	namespace app\phone\controller;
	use think\Controller;

	class StaffLogs extends Controller{
		
	public function login()
	{
		$username=input('username');
		$password=input('password');
		$userinfo=db('admin')->where('admin_name',$username)->find();
		if(!$userinfo){
			return "用户名或者！";
			die;
		}
		
		if(md5($password)!=$userinfo['admin_password']){
			return "用户名或者密码错误！";
			die;
		}	
		$re= array('status'=>'200','user_id'=>$userinfo['admin_id']);
		return json_encode($re);
	}
	
		
	public function lst()
	{
		
		
	}
		
		
		
	}
