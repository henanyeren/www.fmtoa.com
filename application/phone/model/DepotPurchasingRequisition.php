<?php
namespace app\phone\model;
use think\Model;
/**
* 模块模型
*/
class DepotPurchasingRequisition extends Model{
	//采购单
	protected $resultSetType = 'collection';

	public function FromId(){
		return $this->hasOne('Admin','admin_id','requisition_from_id')->field('admin_name');
	}
	public function RefuseId(){
		return $this->hasOne('Admin','admin_id','requisition_refuse_id')->field('admin_name');
	}

	public function Goods(){
		return $this->hasMany('DepotPurchasingRequisitionGoods','purchasing_pid','requisition_id');
	}
}