<?php
namespace  app\phone\controller;
use think\Collection;
use app\admin\model;
class Duty extends Collection{
    public function lst(){

        //部门查询
        $mymodel=new model\Duty();
        $list=db('duty')->select();
        $new_list=$mymodel->getChildren($list);

        return json_encode(array('state'=>'200','msg'=>$new_list));
    }


    public function person_lst(){

        //部门查询
        $super_id=input('super_id');//获取地址id   1,2
        if(isset($super_id)){
	        $list=model('duty')->where('duty_super_id',$super_id)->find()->staff;

	        return json_encode(array('state'=>'200','data'=>$list));
        }else{
        	return json_encode(array('state'=>'100','data'=>'参数错误'));
        }
    }

    public function person_info(){

        //部门下的人员详情查询
        $staff_id=input('staff_id');//获取地址id   1,2
        if(isset($staff_id)){
            $data=db('staff')->where('staff_id',$staff_id)->find();

            return json_encode(array('state'=>'200','data'=>$data));
        }else{
            return json_encode(array('state'=>'100','data'=>'参数错误'));
        }
    }
}