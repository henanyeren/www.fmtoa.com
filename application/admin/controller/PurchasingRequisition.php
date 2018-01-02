<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use app\admin\model\PurchasingRequisition as PurchasingRequisitionModel;

class PurchasingRequisition extends Common
  {
		public function manager()
		{
			$re=[
				'status'=>1,
				'page'=>$this->fetch(),
			];
			return $re;
		}  	
		
		public function depotPurchasingRequisitionAdd()
		{
			$target_table=input('target_table');
			$target_sub_table=input('target_sub_table');
			$flow_id=input('flow_id');
			
			session('flow_id',$flow_id);
			session('routine_table',$target_table);
			session('routine_sub_table',$target_sub_table);
			
			//通过seiion
			$departmentName=db('duty')->where('duty_super_id',session('admin_duty_superid'))->find()["duty_name"];
			$this->assign([
			'tabTitle'=>'填写物料请购单',
			'departmentName'=>$departmentName
			]);
			
			$re=[
				'status'=>1,
				'page'=>$this->fetch(),
			];
			return $re;
		}
		//添加处理数据
		public function depotPurchasingRequisitionAddhanddle()
		{
			$data=request()->post();
			$flow_weights=db('flow')->find(session('flow_id'))['flow_weights'];
			$data['requisition_time']=strtotime(str_replace('T',' ',$data['requisition_time']));
			
			
			//添加子表名
			$data['table_sub_name']=session('routine_sub_table');
			$data['requisitionl_flow']=$flow_weights;
			
			$re=db(session('routine_table'))->insert($data);
			if($re){
				return array('state'=>1,'msg'=>'提交成功');
			}else{
				return array('state'=>0,'msg'=>'提交失败');
			}
			return ;
		}
		//添加处理数据
		public function depotPurchasingRequisitionSubUpload()
		{
			$data=request()->post();
			
			$data['purchasing_date_require']=strtotime(str_replace('T',' ',$data['purchasing_date_require']));
			
			$re=db(session('routine_sub_table'))->insertGetId($data);
			if($re){
				return array('status'=>1,'msg'=>'提交成功','bId'=>$re);
			}else{
				return array('status'=>0,'msg'=>'提交失败');
			}
			return;
		}  	
    public function detail()
    {
        $id=input('id');
				$detail=db('PurchasingRequisition')->find($id);
				//根据ID制作编号
    			$newNumber = substr(strval($detail['distribution_id']+100000000),1,8);
    		
				$detail['distribution_id']=$newNumber;
				$subArr=PurchasingRequisitionModel::get($id)->comm()->select();
				
				//如果存在铺货商品
				if($subArr){
					//遍历里面的关联数据
					foreach($subArr as $k1=> $v1){
						$getNewArr=[
							'distribution_good_id'				=>$v1->distribution_good_id,
							'distribution_lot_number'			=>$v1->distribution_lot_number,
							'distribution_name_id'				=>$this->distribution_good_name($v1->distribution_name_id),
							'distribution_format'				=>$v1->distribution_format,
							'distribution_unit'					=>$v1->distribution_unit,
							'distribution_goods_number'			=>$v1->distribution_goods_number,
							'distribution_univalent'			=>$v1->distribution_univalent,
							'distribution_total'				=>$v1->distribution_total,
							'distribution_pid'					=>$v1->distribution_pid,
						];
						$detail['sub'][$k1+1]=$getNewArr;
					}
				}else{
					$detail['sub']=null;
				}
        if($detail){
            $this->assign('detail',$detail);
            return array('state'=>'1','msg'=>$this->fetch(),'name'=>"铺货信息预览");
        }else{
            return array('state'=>'0','msg'=>'查询错误');
        }
    }
    
    public function distribution_good_name($distribution_good_id){
    	if($distribution_good_id){
		    return db('app_commodity')->where('commodity_id',$distribution_good_id)->find()['commodity_name'];
    	}else{
    		return '未找到';
    	}
    }
    
    public function lst(){

			$infos=db('PurchasingRequisition')->select();


		$this->assign([
			'list'=>$infos,
			'tabTitle'=>'物料列表'
			]);
		
		$re=[
			'status'=>1,
			'page'=>$this->fetch(),	
		];
		
		if(request()->isAjax()){
			return $re;
		}


    }
    public function del()
    {
        $id = input('distribution_id');
        $mycompany = db('PurchasingRequisition')->delete($id);
        if ($mycompany) {
            return array('state' => 1, 'msg' => '删除成功！');
        } else {
            return array('state' => 0, 'msg' => '删除失败!');
        }
    }



}