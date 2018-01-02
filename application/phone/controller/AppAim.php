<?php
namespace app\phone\controller;
use think\Controller;
class AppAim extends Controller{
	public function aim_add(){
		//接受发布的目标
         $aim_pid=input('aim_pid');
        if (isset($aim_pid)){
            $data['aim_pid']=$aim_pid;
            $data['aim_content']=input('aim_content');
            $data['aim_type']=input('aim_type');
            $data['aim_time']=time();
            if (model('app_aim')->insert($data)){
                return json_encode(array('state'=>'200','msg'=>'发布成功'));
            }else{
                return json_encode(array('state'=>'101','msg'=>'发布失败'));
            }
        }else{
            return json_encode(array('state'=>'101','msg'=>'参数错误'));
        }
	}

	public function lst(){
		//查询最新的目标
		$data=array();
		for ($i=1;$i<4 ;$i++) { 
		    $day_aim=model('app_aim')->order('aim_time desc')->where('aim_type',$i)->find();	
            array_push($data,$day_aim);
		}
        
        return json_encode(array('state'=>'200','data'=>$data));
      
        


	}
}