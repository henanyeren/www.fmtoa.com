<?php  
namespace app\admin\controller;
/**
* 登录控制器
*/
class Login extends \think\Controller
{
	public function test(){
	dump('asehfdasjklf');	
}
	public function login()
	/*管理员登录界面显示*/
	{
		return view();
	}

	public function checklogin()
	/*验证管理员登录*/
	{
		if (request()->isPost()) {
			$post = request()->post();
			$admin_find = db('admin')->where('admin_name','eq',$post['admin_name'])->find();
			$re=$admin_find['admin_password']==md5($post['admin_password'].$admin_find['admin_random_number']);
			if(!$re){
				$this->error('账号或密码错误！');
				return false;
			}
			if (empty($admin_find)) {
				$this->error('用户或密码错误','login/login');
			}
			else{
				$duty_inifo=db('duty')->where('duty_super_id',$admin_find['admin_duty_superid'])->find();
				session('admin_id',$admin_find['admin_id']);
				
				session('admin_alias',$admin_find['alias']);
				session('admin_name',$admin_find['admin_name']);
				session('admin_duty_superid',$admin_find['admin_duty_superid']);
				session('duty_name',$duty_inifo['duty_name']);
				
				session('duty_id',$duty_inifo['duty_id']);
				$this->redirect('index/index');
			}
		}
	}

	public function logout()
	/*管理员登出*/
	{
		session('admin_id',null);
		session('admin_name',null);
		$this->redirect('login/login');
	}
}
