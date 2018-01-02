<?php
namespace app\admin\model;
/**
* 模块模型
*/
class Routine extends \think\Model
{
protected $resultSetType='collection';

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
    	return $this->hasOne('MyRoutine','routine_id','requisitionl_routine_id');
    }
    //根绝批文id获取批文人员信息
    public function Admin(){
    	return $this->hasOne('Admin','admin_id','flow_write_admin_id');
    }    
    //根绝获取部门人员信息获取部门信息
    public function Duty(){
    	return $this->hasOne('Duty','admin_id','flow_write_admin_id');
    }      
}
