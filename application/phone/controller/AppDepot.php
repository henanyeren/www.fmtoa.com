<?php
namespace app\phone\controller;
use think\Controller;

class AppDepot extends Controller{

    //查询类型
   
	public function type(){
		$sid = input('sid');
	
        $data=db('depot_press_type')->where('type_is_in',$sid)->select();
        
		return json_encode(array('state'=>'200','data'=>$data));
	}
    //查询部门下的人员
	public function super(){
		$admin_name=input('admin_name');
		$data=model('Admin')->where('admin_name',$admin_name)->field('admin_id,admin_name')->find();
		//$data=db('Duty')->select();

		return json_encode(array('state'=>'200','data'=>$data));
	}



	//物料属性	
	public function gain(){ 

		//$mydata=getList(model('DepotType')->select()); 
		$mydata=model('DepotType')->select();
		
		if($mydata){
			return json_encode($mydata);
		}
		return json_encode(array('status'=>'100','msg'=>'未找到物品信息'));
			 

	}
    
    //物料名称
	public function goods(){
 
	    $type_pid = input('type_pid');
     
	    $data=db('DepotMateriels')->where('materiel_type_pid',$type_pid)->select();
	 
		if($data){
			return json_encode($data);
		}
		return json_encode(array('status'=>'100','msg'=>'未找到物品信息'));
  

	}
	//搜索
	public function search(){ 
		$kwd=input('kwd');     
        $data=db('DepotMateriels')->where('materiel_name','like','%'.$kwd.'%')->select();
      /*  foreach ($data as $k=>$v) {
        	//$v['price']=db('AppCommodityPrice')->where('price_commodity_id',$v['commodity_id'])->find()['price'];
        	//$data[$k]['price']=$v['price'];
        	$data[$k]['time'] = date('Y-m-d',$v['time']);

        }*/
      
        if(!empty($data)){
        	
        	return json_encode(array('state'=>'200','data'=>$data));
        }else{
        	return json_encode(array('state'=>'200','msg'=>'no'));
        }
	}

	//每批货的列表
	public function search_show(){
		$id = input('id');
		if($id){
			
			$data = model('DepotMateriels')->where('materiel_id',$id)->find();
			$data->DepotMateriels;
			
			if($data){
				return json_encode(array('state'=>'200','data'=>$data));
			}else{
				return json_encode(array('state'=>'100','data'=>'无数据'));
			}
		}else{
            return json_encode(array('state'=>'101','msg'=>'参数错误'));
		}
	}

	public function oneinfo(){
		$materiel_id = input('materiel_id');
		$data = db('depot_materiels')->where('materiel_id',$materiel_id)->find();

		if($data){
			return json_encode(array('state'=>'200','data'=>$data));
		}
		return json_encode(array('state'=>'100','msg'=>'未找到物品信息'));

	}


	//提交通用的表单
    public function press_form(){ 
		
		
		$data=request()->post();
		$flow=db('flow')->find(7);
		$data['requisitionl_flow']=$flow['flow_weights'];
		$data['table_title'] = $flow['flow_name'];
		$data['requisitionl_flow_id'] = $flow['flow_id'];
		$data['materiel_add_time']=strtotime(input('materiel_add_time')); 
		$data['requisitionl_routine_id']='2'; 

		//保持物料变更状态
		$re_id=db('depot_press_materiels')->insertGetId($data);
		if($re_id){
			//更新物料数据	
			$re=[
				'state'=>'1',
				'msg'=>$re_id,
			];
		}else{
			$re=[
				'state'=>'0',
				'msg'=>'操作错误',
			];
		}

		return json_encode($re);
	}


   
	//物料入库=同步进库数据
	public function pressAddhandle(){

		$materiel_pid=input('materiel_pid');

		$data['materiel_pid']=input('materiel_pid');
		$data['materiel_batch_number']=input('materiel_batch_number');
		$data['materiel_no']=input('materiel_no');
		$data['materiel_number']=input('materiel_number');
		$data['materiel_unit']=input('materiel_unit');
		$data['materiel_univalent']=input('materiel_univalent');
		$data['material_total_money']=input('material_total_money');
		$data['materiel_remark']=input('materiel_remark');
		$data['materiel_add_time']=time();
        $data['materiel_main_table_pid'] = input('materiel_main_table_pid');

		//保持物料变更状态
		$re_id=db('depot_press_materiels_goods')->insertGetId($data);

		if($re_id){
			//更新物料数据
			$materiel_number=db('depot_materiels')->find($materiel_pid)['materiel_number'];
			
			$new_materiel_number=$materiel_number+$data['materiel_number'];

			$update_re=db('depot_materiels')->where('materiel_id',$materiel_pid)->update([
				'materiel_number'=>$new_materiel_number
			]);

			$re=[
				'status'=>1,
				'msg'=>$re_id,
			];
		}else{
			$re=[
				'status'=>0,
				'msg'=>'保存状态错误',
			];
		}

		return json_encode($re);
	}





	//物料出库=同步进库数据
    public function deliveryAddhandle(){
			
		$materiel_pid=input('materiel_pid');

		$data['materiel_pid']=input('materiel_pid');
		$data['materiel_main_table_pid'] = input('materiel_main_table_pid');
		$data['materiel_batch_number']=input('materiel_batch_number');
		$data['materiel_no']=input('materiel_no');
		$data['materiel_number']=input('materiel_number');
		$data['materiel_unit']=input('materiel_unit');
		$data['materiel_univalent']=input('materiel_univalent');
		$data['material_total_money']=input('material_total_money');
		$data['materiel_remark']=input('materiel_remark');
		$data['materiel_add_time']=time();
		//保持物料变更状态
		$re_id=db('depot_press_materiels_goods')->insertGetId($data);
		if($re_id){
			//更新物料数据
			$materiel_number=db('depot_materiels')->find($materiel_pid)['materiel_number'];
			
			$new_materiel_number=$materiel_number-$data['materiel_number'];
			
			$update_re=db('depot_materiels')->where('materiel_id',$materiel_pid)->update([
				'materiel_number'=>$new_materiel_number
			]);

			$re=[
				'status'=>1,
				'msg'=>$re_id,
			];
		}else{
			$re=[
				'status'=>0,
				'msg'=>'保存状态错误',
			];
		}

		return json_encode($re);
	}



    //最终提交
	public function all(){
        $materiel_goods_ids=rtrim(input('materiel_goods_ids'),',');
        $materiel_id=input('materiel_id');
		

		if($materiel_goods_ids){
            $ids_re=db('depot_press_materiels')->where('materiel_id',$materiel_id)->update(['materiel_goods_ids'=>$materiel_goods_ids]);

            if ($ids_re) {
            	return json_encode(array('state'=>'200','msg'=>"提交成功"));
            }else{
            	return json_encode(array('state'=>'100','msg'=>"提交失败"));
            }

		}else{
			 return json_encode(array('state'=>'101','msg'=>'参数错误'));
		}


	
    }




    //历史已处理事务列表
	public function  history_lst(){
		
		$super_id=input('super_id');
		if(isset($super_id)){
			$duty=model('Duty')->where('duty_super_id',$super_id)->find();

				$untreated_arr=db('depot_press_materiels')->where('requisition_is_end','=','1' )->field('materiel_id,materiel_add_time,materiel_godown_keeper,requisition_from_id')->order('materiel_add_time desc')->paginate(12);

                $untreated_arr = $untreated_arr->toArray();
				foreach($untreated_arr['data'] as $k=>$v){
					
				    $untreated_arr['data'][$k]['requisition_from_id'] = db('admin')->field('admin_name')->find($v['requisition_from_id'])['admin_name'];
                   
					$untreated_arr['data'][$k]['materiel_add_time'] = date('Y-m-d H:i:s',$v['materiel_add_time']);
					
				}
			
				if(!$untreated_arr['data']){
	                return json_encode(array('state'=>'201','data'=>'暂无数据！'));
				}else{
				   
					return json_encode(array('state'=>'200','data'=>$untreated_arr));
				}
			

	    }else{
	    	return json_encode(array('state'=>'101','msg'=>"参数错误"));
	    }


	}



}
