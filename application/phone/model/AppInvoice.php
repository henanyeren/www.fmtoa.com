<?php
namespace app\phone\model;
use think\Model;
/**
* 模块模型
*/
class AppInvoice extends Model{
	//发票申请
	public function goods(){

		return $this->hasMany('AppInvoiceGoods','invoice_pid','invoice_id');

	}

}
