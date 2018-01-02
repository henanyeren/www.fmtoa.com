<?php
namespace app\admin\model;
use \think\Model;

class Flow extends Model
{
	protected $resultSetType='collection';
	
    public function Duty(){
    	return $this->hasMany('Duty','duty_id','flow_weights');
    }


    
    
}