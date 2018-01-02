<?php
namespace app\phone\controller;
use think\Controller;
class AppSample extends Controller{
	//申请样品所有信息
	public function sample(){

	    $user_id=input('sample_user_id');
	    if (isset($user_id)){
	    
			$data=[
				'sample_name'=>input('sample_name'),
				'sample_user_id'=>input('sample_user_id'),
				
				'sample_user_name'=>input('sample_user_name'),
				'sample_time'=>input('sample_time'),
				'sample_cause'=>input('sample_cause'),
				'sample_good_ids'=>input('sample_good_ids'),
				'sample_put_time'=>time()
			];
			
			if($id=db('app_sample')->insertGetId($data)){
				$where=[
					'sample_good_id'=>array('in',input('sample_good_ids'))
				];
				db('app_sample_goods')->where($where)->update(['sample_pid' => $id]);
				return json_encode(array('status'=>'200','msg'=>"提交成功"));
			}else{
				return json_encode(array('status'=>'100','msg'=>"提交失败"));
			}

	    }else{
	    	return json_encode(array('status'=>'201','msg'=>"参数错误"));
	    }

	}
    //添加商品
	public function goods(){
		$name_pid=input('sample_name_id');
		if (isset($name_pid)){
			$data=[
				'sample_name_id'=>input('sample_name_id'),
				'sample_format'=>input('sample_format'),
				'sample_unit'=>input('sample_unit'),
				'sample_goods_number'=>input('sample_goods_number'),
				
				'sample_univalent'=>input('sample_univalent'),
				'sample_total'=>input('sample_total'),
			];
			$id=db('app_sample_goods')->insertGetId($data);
			if($id){
				return json_encode(array('status'=>'200','msg'=>$id));
			}else{
				return json_encode(array('status'=>'100','msg'=>"提交失败"));
			}
	    }else{
	    	return json_encode(array('status'=>'201','msg'=>"参数错误"));
	    }

	}
}