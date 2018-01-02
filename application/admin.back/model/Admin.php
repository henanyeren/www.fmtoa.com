<?php
namespace app\admin\model;
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
    
    //密码加密算法
	public function getNewPwd($pwd){
		$str="+_)(*&^%$#@!)+_)(*&^%$#@!@!!@#$%^&*()_+POIUYTREWQLKJHGFDSA?><MNBVCXZLKJHGFDS";
	   	$salt= substr(str_shuffle($str),0,8);
        return array('newPwd'=> md5($pwd.$salt),'random'=>$salt);
    }	
    
    public function DepotPressGetAlias(){
    	//返回库单和物体的数据
    	return $this->belongsTo('DepotPressMateriels','materiel_bodily_destination','admin_id');
    }    
    
    		
}
?>