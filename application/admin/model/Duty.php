<?php
namespace app\admin\model;
/**
* 模块模型
*/
class Duty extends \think\Model
{
protected $resultSetType='collection';

	public function getChildren($list,$pid=0,$level=0)
	/*无限级分类得到全部子类*/
	{
		static $arr = array();
		foreach ($list as $key => $value) {
			$pidArr=explode('-',$value['duty_super_id']);
			if(count($pidArr)<2){
				$duty_super_id= 0;
			}else{
				$duty_super_id=$pidArr[count($pidArr)-2];
			}
			if($duty_super_id==$pid){
				$value['level'] = $level;
				$value['str'] = str_repeat('——',$value['level']);
				$arr[] = $value;
				$this->getChildren($list,$value['duty_id'],$level+1);
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


    public function Flow(){
    	return $this->belongsTo('Flow','flow_flow_weights','duty_id');
    }	

	//根据部门id获取事务id
	public function getFlowInfo($duty_id=0){
		if(!$duty_id){
			dump('找不到部门id');
			return;
		}
		
		$duty_flow_id=db('duty')->find($duty_id);
		return $duty_flow_id;
	}
	
    public function MyRoutine(){
    	return $this->hasOne('MyRoutine','routine_id','duty_routine_id');
    }
}
