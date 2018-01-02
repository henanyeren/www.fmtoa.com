<?php
namespace app\phone\model;
use       think\Model;
/**
* 模块模型
*/
class AppCommodity extends Model{
	//商品模型
	 
	protected $resulSetType = 'collection';

	public function AppCommodityAdd(){
		return $this->belongsToMany('AppCommodityAdd','AppCommodityPrice','price_add_id','price_commodity_id');
	}

}
