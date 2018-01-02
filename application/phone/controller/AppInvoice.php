<?php
namespace app\phone\controller;
use think\Controller;
class AppInvoice extends Controller{
	//申请所有信息
	public function invoice(){

	    $user_id=input('invoice_user_id');
	    if (isset($user_id)){
	    
			$data=[
				'invoices'=>input('invoices'),
				'invoice_user_id'=>input('invoice_user_id'),
				
				'invoice_user_name'=>input('invoice_user_name'),
				'invoice_name'=>input('invoice_name'),
				'invoice_time'=>input('invoice_time'),
				'invoice_unit'=>input('invoice_unit'),
				'invoice_ratepaying'=>input('invoice_ratepaying'),
				'invoice_add'=>input('invoice_add'),
				'invoice_tel'=>input('invoice_tel'),
				'invoice_opening_bank'=>input('invoice_opening_bank'),
				'invoice_bank_number'=>input('invoice_bank_number'),
				'invoice_totalprict_big'=>input('invoice_totalprict_big'),
				'invoice_totalprict'=>input('invoice_totalprict'),
				'invoice_good_ids'=>input('invoice_good_ids'),
				'invoice_put_time'=>time()
			];
			
			if($id=db('app_invoice')->insertGetId($data)){
				$where=[
					'invoice_good_id'=>array('in',input('invoice_good_ids'))
				];
				db('app_invoice_goods')->where($where)->update(['invoice_pid' => $id]);
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
		$name_pid=input('invoice_name_id');
		if (isset($name_pid)){
			$data=[
				'invoice_name_id'=>input('invoice_name_id'),
				'invoice_format'=>input('invoice_format'),
				'invoice_unit'=>input('invoice_unit'),
				'invoice_goods_number'=>input('invoice_goods_number'),
				
				'invoice_univalent'=>input('invoice_univalent'),
				'invoice_total'=>input('invoice_total'),
			];
			$id=db('app_invoice_goods')->insertGetId($data);
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