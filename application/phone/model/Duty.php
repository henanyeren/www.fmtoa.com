<?php
namespace app\phone\model;
use think\Model;
/**
* 模块模型
*/
class Duty extends Model{
	//关联查询  部门关联人员
	public function admins(){

		return $this->hasMany('Admin','admin_duty_superid','duty_super_id')->field('admin_name,admin_phone')->paginate(10);
	}

	public function staff(){

		return $this->hasMany('Staff','staff_duty_super_id','duty_super_id')->field('staff_id,staff_pic,staff_name,staff_tel');
	}
    //关联流程
	public function flowtables(){

		return $this->hasOne('FlowTables','table_id','duty_flow_tables_id');
	}

}
