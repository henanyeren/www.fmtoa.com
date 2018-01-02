<?php  
namespace app\admin\model;
use  	  think\Model;
/**
* 用户组模型
*/
class AppAim extends Model{
    protected $resultSetType = 'collection';
	public function admin(){
		return $this->hasOne('Admin','admin_id','aim_pid')->field('admin_name');
	}
}