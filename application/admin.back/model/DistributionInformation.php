<?php
namespace app\admin\model;
use think\Db;
/**
* 模块模型
*/
class DistributionInformation extends \think\Model
{
	public function getChildren($list,$pid=0,$level=0)
	/*无限级分类得到全部子类*/
	{
		static $arr = array();
		foreach ($list as $key => $value) {
			$pidArr=explode('-',$value['distribution_super_id']);
			if(count($pidArr)<2){
				$duty_super_id= 0;
			}else{
				$duty_super_id=$pidArr[count($pidArr)-2];
			}
			if($duty_super_id==$pid){
				$value['level'] = $level;
				$value['str'] = str_repeat('——',$value['level']);
				$arr[] = $value;
				$this->getChildren($list,$value['distribution_id'],$level+1);
			}
		}
		
		return $arr;
	}
	
	public function getChildrenM($list,$pid='0')
	/*无限级分类得到全部子类*/
	{
		$arr = array();
		foreach ($list as $key => $value) {
			if($value['pid']==$pid){
				$value['children'] = $this->getChildrenM($list,$value['id']);
				$arr[] = $value;
			}
		}
		return $arr;
	}
	
	//关联查询
	
	public function comm(){
		return $this->hasMany('distribution_goods','distribution_pid','distribution_id');
	}
	
	//获取所有关联
	public function getListINfo(){
//		return 	$mycompany=db('DistributionInformation')
//	    ->alias('d')

//		->where('oa_distribution_goods as g g.distribution_id','in',explode(',','d.distribution_goods_ids')) 
////	    ->join('oa_distribution_goods g','g.distribution_id eq "1"')
//	    ->select();


return Db::query("SELECT * FROM oa_distribution_goods as g, oa_distribution_information as d where g.distribution_id in (d.distribution_goods_ids)");

//
//		return $mycompany=db('DistributionGoods')
//		->where('distribution_id','in', explode(',',db('DistributionInformation')->where('distribution_id',1)->field('distribution_goods_ids')->find()["distribution_goods_ids"]))
//		->select();


		
//		return db('DistributionInformation')->where('distribution_id',1)->field('distribution_goods_ids')->find()["distribution_goods_ids"];
		//return explode(',',$mycompany=db('DistributionInformation')->field('distribution_goods_ids')->select()[0]["distribution_goods_ids"]);
		
//		return explode(',',$mycompany=db('DistributionInformation')
//	    ->field('distribution_goods_ids')
//	    ->select()[0]["distribution_goods_ids"]
//	    );
	}
}
