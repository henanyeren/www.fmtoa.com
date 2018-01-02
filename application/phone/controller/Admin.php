<?php
namespace app\phone\model;
use       think\Model;
/**
* 管理员模型
*/

class Admin extends Model
{
	protected $resultSetType = 'collection';
	public function group()
	/*管理员与用户组之间的*/
	{
		return $this->belongsToMany('AuthGroup','auth_group_access','group_id','uid');
	}

	public function adminchile($data,$pid=0,$val=0){
	static  $mydata=array();
	    foreach ($data as $v=>$key){
	        if($key['admin_pid']==$pid){
	            $key['str']=str_repeat('---',$val);
	            $mydata[]=$key;
	            $this->adminchile($data,$key['admin_id'],$val+1);
            }
        }
        return $mydata;
    }

    		
}
?>