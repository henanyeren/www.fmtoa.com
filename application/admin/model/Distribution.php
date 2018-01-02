<?php
namespace app\admin\model;
/**
* 模块模型
*/
class Distribution extends \think\Model
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

}
