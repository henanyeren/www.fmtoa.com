<?php  		
namespace app\phone\controller;
use  	  think\Controller;

class AppNews extends Controller{
    //事务消息列表
	public function  lst(){
		
		$super_id=input('super_id');
		if(isset($super_id)){
			$duty=model('Duty')->where('duty_super_id',$super_id)->find();

			$purchasing=$duty->flowtables; 
           
	        if($purchasing['table_weights_names']){ 
                 //查询到未处理事务
				$requisitionl_flow_lines=db($purchasing['table_weights_names'])->where('requisition_is_end','=','0' )->paginate(15);

		        $untreated_arr =[];
		        //查找该谁未审批的事务
				foreach($requisitionl_flow_lines as $k=>$v){
					
				    //dump(array_keys($requisitionl_flow_lines[$k])[0]='id');exit;
				    $id = $requisitionl_flow_lines[$k][array_keys($requisitionl_flow_lines[$k])[0]];
				  
                    $v['id']=$id;
                    $v['flowtables']=$purchasing['table_weights_names'];
				    $v['requisition_from_id'] = db('admin')->field('admin_name')->find($v['requisition_from_id'])['admin_name'];

					$v['add_time'] = date('Y-m-d H:i:s',$requisitionl_flow_lines[$k][array_keys($requisitionl_flow_lines[$k])[1]]);
					$requisitionl_flow_sub_arr=explode(',',$v["requisitionl_flow"]);

					foreach($requisitionl_flow_sub_arr as $k1=>$v1){
						if($k1==0){
							if($v1==$duty['duty_id']){
							  $untreated_arr['table_data'][$k]=$v;
							 
							}								
						}else{
							if($v1 == $duty['duty_id'] && $requisitionl_flow_sub_arr[$k1-1]== 0){
							 
							  $untreated_arr['table_data'][$k]=$v;
							  

							}								
						}									
						

					}
				}
			    

				if(!$untreated_arr){
	                return json_encode(array('state'=>'201','data'=>'暂无未处理事务！'));
				}else{
				   
					return json_encode(array('state'=>'200','data'=>array_values($untreated_arr['table_data']) ));
				}
			}else{
				return json_encode(array('state'=>'201','data'=>'暂无未处理事务！'));
			}

	    }else{
	    	return json_encode(array('state'=>'101','msg'=>"参数错误"));
	    }


	}
    

    //仓库事物详情
	public function detail(){
		$id = input('id');
		//实例化一个插件
		$model=model('DepotPress');
		//传递参数
		$data=$model->DepotPress($id);
        $data['materiel_add_time'] = date('Y-m-d H:i:s',time());
        //dump($data);exit;
		return json_encode(array('state'=>'200','data'=>$data));	
	}


    //未审批详情
	public function info(){
		$tab_name = input('tab_name');
        $id = input('id');
        $type = 'info';
		if(isset($tab_name)){
			//$data=model($tab_name)->find(input('id'));
            //调用审批表的方法
            $data = $this -> $tab_name($type);

			return json_encode(array('status'=>'200','data'=>$data->toArray()));
		}

	}
    //调用采购方法
	public function depot_purchasing_requisition($type){
        
		if($type=='res'){ 
		//审批结果逻辑
			//同意、拒接
            $res_id = input('res_id');
		    $super_id=input('super_id');
            $duty_id=db('Duty')->where('duty_super_id',$super_id)->find();

            //数据的id
		    $id = input('id');
            
            if($res_id == 1){
            //同意
	            if($duty_id['duty_id'] == '35'){

	            	$data = db('DepotPurchasingRequisition')->where('requisition_id',$id)
	            	                                       ->update(['requisition_executive_deputy_general_manager'=>$res_id,
	                                                                 'requisitionl_flow'=>'0,7'
	            	                                                ]); 
	            }else if($duty_id['duty_id'] == '7'){
	            	$data = db('DepotPurchasingRequisition')->where('requisition_id',$id)
	            	                                       ->update(['requisition_department_manager'=>$res_id,
	            	                                       	         'requisitionl_flow'=>'0,0',
	            	                                       	         'requisition_is_end'=>'1'
	            	                                                ]); 

	            }else{

	            	$data = false;

	            }
	        }else if($res_id == 0){
	        	//拒绝
	            $data = model('DepotPurchasingRequisition')->save(['requisition_is_end'=>'1','requisition_refuse_id'=>$user_id],[ 'requisition_id' => $id ] ); 
	            	                                      
	        }

	

		}else if($type=='info'){
        //审批详情

			$data = model(input('tab_name'))->find(input('id'));
		
			$data['requisition_from_id'] = $data->FromId['admin_name'];
			//读取时间
			$data['add_time'] = date('Y-m-d',$data[array_keys($data->toArray())[1]]);

			$data['requisition_super_id'] =  db('duty')->where('duty_super_id',$data['requisition_super_id'])->find()['duty_name'];
	           
			$data->Goods;

		}
        
       
		return $data;

	}
    //调用出入库方法
	public function depot_press_materiels($type){

		if($type=='res'){ 
        //审批结果逻辑
			//同意、拒接
            $res_id = input('res_id');
            $user_id= input('user_id');
		    $super_id=input('super_id');
            $duty_id=db('Duty')->where('duty_super_id',$super_id)->find();
             
            //数据的id
		    $id = input('id');
            if($res_id == 1){
            	//同意
	            if($duty_id['duty_id'] == '11'){

	            	$data = db('DepotPressMateriels')->where('materiel_id',$id)
	            	                                       ->update(['materiel_qc_id'=>$user_id,
	                                                                 'requisitionl_flow'=>'0,22'
	            	                                                ]); 
	            }else if($duty_id['duty_id'] == '22'){
	            	$data = db('DepotPressMateriels')->where('materiel_id',$id)
	            	                                       ->update(['requisitionl_flow'=>'0,0',
	            	                                       	         'requisition_is_end'=>'1'
	            	                                                ]); 

	            }else{

	            	$data = false;
	            	
	            }
	        }else if($res_id == 0){
	        	//拒绝
	            $data = model('DepotPressMateriels')->save(['requisition_is_end'=>'1','requisition_refuse_id'=>$user_id],[ 'materiel_id' => $id ] );                                       
	        }

		}else if($type=='info'){
        //审批详情
			$data = model(input('tab_name'))->find(input('id'));
			$data['requisition_from_id'] = $data->FromId['admin_name'];
			//读取时间
			$data['add_time'] = date('Y-m-d',$data[array_keys($data->toArray())[1]]);

			$data['requisition_super_id'] =  db('duty')->where('duty_super_id',$data['requisition_super_id'])->find()['duty_name'];
	           
			$data->Goods;
	    	$data->DepotPressType;
	    }
       
		return $data;
	}

    //审批结果
	public function res(){
		$type ='res';
        $name = input('tab_name');
        $res_id = input('res_id');

        //$req_data = request()->post();
        $req_data['flow_to_id'] = input('id');
        $req_data['flow_write_admin_id'] = input('user_id');
        $req_data['flow_message'] = input('message');
        $req_data['flow_table_name'] = $name;
        $req_data['add_time'] = time();
	
        $super_id=input('super_id');
		if(isset($super_id)){
			db('FlowMessages')->insert($req_data);
			$data = $this->$name($type);
			if($data){
				return json_encode(array('status'=>'200','msg'=>'提交成功'));
			}else{
				return json_encode(array('status'=>'201','msg'=>'提交失败'));
			}
			
		}else{
			return json_encode(array('status'=>'101','msg'=>'参数错误'));
		}
       
		
		//调用 方法
		
     
		//$controller = new AppDepot;
		//$res = $controller ->$name();

	}





}


?>