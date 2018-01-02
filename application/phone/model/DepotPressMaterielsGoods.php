<?php
namespace app\phone\model;
use think\Model;
/**
* 模块模型
*/
class DepotPressMaterielsGoods extends Model{
	//采购单物品
    protected $resultSetType = 'collection';

    public function DepotPressMateriels(){
    	//返回库单和物体的数据
    	return $this->belogsTo('DepotPressMateriels');
    }
    //返回商品和数据主表的关联
    public function DepotPress(){
    	return $this->hasOne('DepotMateriels','materiel_id','materiel_pid');
    }
	//出库模型关联，为了获取物料名称
    public function DepotMaterielsGoods(){
    	return $this->hasOne('DepotMaterielsGoods','materiel_id','materiel_pid');
    }

}