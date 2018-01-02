<?php
namespace app\phone\model;
/**
* 管理员模型
*/

class Admin extends \think\Model
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


    public function staff(){
	//用户和用户详情
		return $this->hasOne('Staff','staff_id','admin_staff_pid')->field('staff_pic,staff_name,staff_sex,staff_tel,staff_native_place,staff_address');
	}


    		
}
?>