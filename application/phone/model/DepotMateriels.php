<?php
namespace app\phone\model;
use think\Model;
/**
* 模块模型
*/
class DepotMateriels extends Model{
	//物料用品模型
	// 设置返回数据集的对象名
	protected $resultSetType = 'collection';
     public function DepotMateriels(){
    	return $this->hasMany('DepotMaterielsGoods','materiel_pid','materiel_id');
    }
}
