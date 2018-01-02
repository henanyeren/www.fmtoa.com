<?php
namespace app\admin\model;
/**
* 管理员模型
*/

class BillMonthly extends \think\Model
{
    protected $resultSetType = 'collection';
    public function monthly(){
    	    return $this->hasOne('BillReimbursement','reimbursement_id','monthly_pid');
        }
}
?>