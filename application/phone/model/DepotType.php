<?php
namespace app\phone\model;
use think\Model;
/**
* 模块模型
*/
class DepotType extends Model{
	//物料模型
   // 设置返回数据集的对象名
	protected $resultSetType = 'collection';
	public function depotmateriels(){

		return $this->hasMany('DepotMateriels','materiel_type_pid','type_id');

	}

}
