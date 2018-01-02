<?php
namespace app\phone\model;
use       think\Model;
/**
* 模块模型
*/

class AppCommodityAdd extends Model{
	//商品模型
	
	protected $resulSetType = 'collection'; 

	public function AppCommodity(){
		return $this->belongsToMany('AppCommodity','AppCommodityPrice','price_commodity_id','price_add_id');
	}

}
