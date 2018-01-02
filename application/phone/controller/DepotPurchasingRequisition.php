<?php
	namespace app\phone\controller;
	use think\Controller;

	class DepotPurchasingRequisition extends Controller{
        //插入请求
		public function requisition(){
		   $requisition_from_id = input('requisition_from_id');
		   if (isset($requisition_from_id)){
			   $data['requisition_from_id']  = $requisition_from_id ;
		       $data['requisition_super_id']  =input('requisition_super_id');
		       $data['requisition_time']  =strtotime(input('requisition_time'));
		       $data['requisitionl_flow']  =input('requisitionl_flow');
		       $data['table_title']  =input('table_title');
		       $data['table_sub_name']  ='depot_purchasing_requisition_goods';
		       $re_id=db('DepotPurchasingRequisition')->insertGetId($data);
		       return json_encode(array('status'=>'200','msg'=>$re_id)); 

		    }else{
               return json_encode(array('status'=>'101','msg'=>'参数错误'));
            }


		}
        //流程
		public function flow(){
			$flow_id = input('flow_id');
			$data=db('flow')->where('flow_id',$flow_id)->find();
			
			return json_encode(array('state'=>'200','msg'=>$data['flow_weights']));
		}
        //部门
		public function super(){
			$super_id = input('super_id');
			$data=db('duty')->where('duty_super_id',$super_id)->find();
			$res=[
               'duty_name'    => $data['duty_name'],
               'duty_super_id'=> $data['duty_super_id']
			];
			return json_encode(array('state'=>'200','msg'=>$res));
		}

        //请求的商品
		public function requisition_goods(){
            $data['purchasing_name']  =input('purchasing_name');
            $data['purchasing_number']=input('purchasing_number');
            $data['purchasing_unit']=input('purchasing_unit');
            $data['purchasing_specifications']=input('purchasing_specifications');
            $data['purchasing_date_require']=strtotime(input('purchasing_date_require'));
            $data['purchasing_remark']=input('purchasing_remark');
            $data['purchasing_pid'] = input('purchasing_pid');
            
            $re_id=db('DepotPurchasingRequisitionGoods')->insertGetId($data);

		    return json_encode(array('status'=>'200','msg'=>$re_id));  

		}

		public function goodsid(){
            $requisition_id = input('requisition_id');
            $requisition_sub_ids=rtrim(input('requisition_sub_ids'),',');
		    if (isset($requisition_id)){
		    	$re=db('DepotPurchasingRequisition')->where('requisition_id',$requisition_id)->update(['requisition_sub_ids' =>$requisition_sub_ids]);
		    	
		    	if($re){
		    		return json_encode(array('status'=>'200','msg'=>'提交成功'));
		    	}
		    	
		    }else{
		    	return json_encode(array('status'=>'101','msg'=>'参数错误'));
		    }
		}
	}