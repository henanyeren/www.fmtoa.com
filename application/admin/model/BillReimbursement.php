<?php
namespace app\admin\model;
/**
* 管理员模型
*/

class BillReimbursement extends \think\Model
{
    protected $resultSetType = 'collection';
    public function expenses(){
    	    return $this->hasOne('Admin','admin_id','reimbursement_names')->field('admin_id,admin_duty_superid,admin_name');
        }
}
?>