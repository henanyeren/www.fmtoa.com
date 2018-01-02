<?php
namespace app\admin\model;
use \think\Model;

class DepotPress extends Model
{
	protected $resultSetType='collection';
	//根绝id查出整个表的数据
	public function getPressTable($id=1){
		$DepotPressMateriels_model=model('DepotPressMateriels');
		$DepotPressMateriels_data=$DepotPressMateriels_model->get($id);
		
		//获取单位模型
		$DepotPressMateriels_data->DepotPressMaterielsGoods;
		$arr=$DepotPressMateriels_data->toArray();
		//dump($arr);
		$arr['materiel_demander_id']=$this->getAlias($arr['materiel_demander_id']);
		$arr['materiel_bodily_destination']=$this->getAlias($arr['materiel_bodily_destination']);
		
		$arr['materiel_godown_keeper']=$this->getAlias($arr['materiel_godown_keeper']);
		return $arr;
	}
	
	//根据id获取姓名
	public function getAlias($id){
		return db('admin')->find($id)['alias'];
	}
	//根据表的type_id获取表的type_name
	
	public function getTypeName($id){
		 $type_name=db('depot_press_type')->where('type_number',$id)->find()['type_name'];
		return $type_name;
	}
	
	//根据id获取关联的所有数据
	public function DepotPress($re_id=1){
			//实例化model
			$DepotPressMaterielsModel=model('DepotPressMateriels');
			$get_data=$DepotPressMaterielsModel->get($re_id);
			$get_data->DepotPressMaterielsGoods;
			
			foreach($get_data['DepotPressMaterielsGoods'] as $k=>$v){
				//判断进出库，如果出库则取出关联的数据
				if(!$get_data->materiel_is_in){
					
					//关联多个表
					$v->DepotMaterielsGoods->DepotMateriels;
					
					//为了统一入库数据信息，因为入库没有批次，而出库有，必须统一数据，供前台调用
					$v->DepotMaterielsGoods;
					//关联得到名称
					$v->materiel_name=$v->DepotMaterielsGoods->DepotMateriels->materiel_name;
					//关联得到单位
					$v->materiel_unit=$v->DepotMaterielsGoods->DepotMateriels->materiel_unit;
					//关联得到规格
					$v->materiel_specifications=$v->DepotMaterielsGoods->DepotMateriels->materiel_specifications;
				}else{
					$v->DepotPress;
					//关联的到名称
					$v->materiel_name=$v->DepotPress->materiel_name;
					//关联的到单位
					$v->materiel_unit=$v->DepotPress->materiel_unit;
					//关联的规格
					$v->materiel_specifications=$v->DepotPress->materiel_specifications;
				}
			}
			$get_data->materiel_id=supplement_0($get_data->materiel_id);
			
			$get_data->Demander;
			$get_data->Qc;
			$get_data->Godownkeeper;
			$get_data->Lssuer;
			$get_data->DepotpressType;
			$get_data->ProductDepartment;
			
			//关联出库人
			$get_data->MaterielOutboundPersonId;
			$get_data->cancellingStocks;
			$get_data->ReceiverId;
			$get_data->Purchaser;
			
			$get_data->AalesTo;
			$data=$get_data->toArray();
			//dump($data);die;
			return $data;
	}
}