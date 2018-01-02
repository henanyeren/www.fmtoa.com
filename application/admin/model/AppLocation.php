<?php  
namespace app\admin\model;
use  	  think\Model;
/**
* 用户组模型
*/
class AppLocation extends Model{
    protected $resultSetType = 'collection';
	public function admin(){
		return $this->hasOne('Admin','admin_id','location_admin_id')->field('admin_name');
	}
}