<?php
namespace app\phone\model;
use think\Db;
/**
* 模块模型
*/
class DistributionInformation extends \think\Model
{
	//关联查询
	// 设置返回数据集的对象名
	protected $resultSetType = 'collection';
	public function distributionGoods(){
		return $this->hasMany('distribution_goods','distribution_pid','distribution_id')->field('distribution_name_id,distribution_goods_number,distribution_total');
	}

}
