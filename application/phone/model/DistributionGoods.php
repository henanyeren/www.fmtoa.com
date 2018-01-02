<?php
namespace app\phone\model;
use  	  think\Model;
/**
* 模块模型
*/
class DistributionGoods extends Model{
	// 设置返回数据集的对象名
	protected $resultSetType = 'collection';
    public function appCommodity(){
		return $this->hasOne('app_commodity','commodity_id','distribution_name_id');
	}

}
