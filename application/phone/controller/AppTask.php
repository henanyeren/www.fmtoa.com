<?php
namespace app\phone\controller;
use think\Controller;
class AppTask extends Controller{
	public function task_add(){
		//接受发布的目标
         $task_pid=input('task_pid');
        if (isset($task_pid)){
            $data['task_pid']=$task_pid;
            $data['task_content']=input('task_content');
            $data['task_time']=time();
            if (model('app_task')->insert($data)){
                return json_encode(array('state'=>'200','msg'=>'发布成功'));
            }else{
                return json_encode(array('state'=>'101','msg'=>'发布失败'));
            }
        }else{
            return json_encode(array('state'=>'101','msg'=>'参数错误'));
        }
	}

	public function info(){
		//查询最新的目标
		 $data=model('app_task')->order('task_time desc')->find();
        
        return json_encode(array('state'=>'200','data'=>$data));
      
        


	}
}