<?php
	namespace app\phone\controller;
	use think\Controller;

	class Staff extends Controller{
		
	public function login()
	{
		$username=input('username');
		$password=input('password');
		$userinfo=model('admin')->where('admin_name',$username)->find();
		
		if(!$userinfo){
			return json_encode(array('status'=>'101','msg'=>'用户名密码错误！'));
			die;
		}
		
		if(md5($password.$userinfo['admin_random_number'])!=$userinfo['admin_password']){
			return json_encode(array('status'=>'101','msg'=>'用户名密码错误！'));
			die;
		}
		//关联用户详细信息
		
		
		
		if($info=$userinfo->staff){
			$re= array('status'=>'200','admin_duty_superid'=>$userinfo['admin_duty_superid'],'user_id'=>$userinfo['admin_id'],'user_name'=>$userinfo['admin_name'],'admin_staff_pid'=>$userinfo['admin_staff_pid'],'staff_pic'=>$info->staff_pic ,'staff_native_place'=>$info->staff_native_place);
			return json_encode($re);
		}else{
			$re= array('status'=>'200','admin_duty_superid'=>$userinfo['admin_duty_superid'],'user_id'=>$userinfo['admin_id'],'user_name'=>$userinfo['admin_name'],'admin_staff_pid'=>$userinfo['admin_staff_pid'],'staff_pic'=>'null','staff_native_place'=>'null');
			return json_encode($re);
		}
		
	}
	

	public  function  modify_password(){
        $user_id=input('user_id');
        $admin_name=input('user_name');

        if(isset($user_id)){
            $userinfo=db('admin')->where('admin_id',$user_id)->find();
            if($userinfo){
                $password=md5(input('password').$userinfo['admin_random_number']);
                    if($userinfo['admin_name']==$admin_name){
                        if(db('admin')->where('admin_id',$user_id)->update(['admin_password'=>$password])){
                            return json_encode(array('status'=>'200','msg'=>'密码修改成功'));
                            die;
                        }
                        return json_encode(array('status'=>'101','msg'=>'密码修改失败'));
                    }else{
                        return json_encode(array('status'=>'101','msg'=>'用户名不存在！'));
                    }
            }else{
                return json_encode(array('status'=>'101','msg'=>'id不存在'));
            }
        }else{
            return json_encode(array('status'=>'101','msg'=>'请传入正确的id'));
        }
    }

    //app获取个人信息
    public function myinfo(){
		$username=input('username');
		//$user_id=input('user_id');
		$userinfo=db('staff')->field('staff_pic,staff_name,staff_sex,staff_tel,staff_native_place,staff_address')->where('staff_name',$username)->find();
		
		$userinfo= array('status'=>'200','data'=>$userinfo);
		return json_encode($userinfo);
	}

		
	}
