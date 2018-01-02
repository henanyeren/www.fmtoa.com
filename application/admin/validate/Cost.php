<?php
namespace app\admin\validate;

    class Cost extends \think\Validate
{
	protected $rule = [
        'fund_payment_unit'  =>  'require|max:256',
       	'fund_receivables'	=>	'require|max:256',
        'fund_reason'	=>	'require',
        'fund_money'=>'require|number',
        'fund_moneys'=>'require',
        'fund_name'=>'require',
        'fund_duty'=>'require',
        'fund_number'=>'require',

        'borrow_duty'=>'require',
        'borrow_name'=>'require',
        'borrow_reason'	=>	'require',
        'borrow_dutys'=>'require',
        'borrow_money'=>'require|number',
        'borrow_moneys'=>'require',

        'payment_duty'=>'require',
        'payment_name'=>'require',
        'payment_receivables'=>'require',
        'payment_contract'=>'require',
        'payment_money'=>'require|number',
        'payment_moneys'=>'require',
        'payment_proportion'=>'require',
        'payment_actual_proportion'=>'require',
    ];
    
    protected $message = [
	    'fund_payment_unit.require'	=> 	'付款单位必填',
	    'fund_receivables.require'	=> 	'收款单位必填',
        'fund_payment_unit.max'		=>	'付款单位不能超过80汉字',
	    'fund_receivables.max'		=>	'收款单位不能超过80汉字',
        'fund_reason.require'		=>	'付款事由不能为空',
        'fund_money.require'      =>'付款金额不能为空',
        'fund_money.number'      =>'付款金额只能为数字',
        'fund_moneys.require'      =>'付款金额大写不能为空',
        'fund_name.require'      =>'申请人不能为空',
        'fund_duty.require'     =>'申请部门不能未空',
        'fund_number.require'=>'编号不能未空',

         'borrow_duty.require'     =>'申请部门不能未空',
        'borrow_name.require'      =>'申请人不能为空',
        'borrow_dutys.require'     =>'职务不能未空',
        'borrow_reason.require'		=>	'借款事由不能为空',
        'borrow_money.require'      =>'借款金额不能为空',
        'borrow_money.number'      =>'借款金额只能为数字',
        'borrow_moneys.require'      =>'借款金额大写不能为空',

        'payment_duty.require'=>'申请部门不能为空',
        'payment_name.require'=>'申请人不能为空',
        'payment_receivables.require'=>'收款单位不能为空',
        'payment_contract.require'=>'合同编号不能为空',
        'payment_reason.require'=>'申请内容不能为空',
        'payment_money.require'      =>'付款金额不能为空',
        'payment_money.number'      =>'付款金额只能为数字',
        'payment_moneys.require'      =>'付款金额大写不能为空',
        'payment_proportion.require'=>'付款比例不能为空',
        'payment_actual_proportion.require'=>'合同付款比例不能为空',
	];
	
	protected $scene=[
		'fund'=>['fund_number','fund_receivables','fund_name','fund_duty','fund_payment_unit','fund_reason','fund_moneys','fund_money'],
        'fund_reason'=>'fund_reason',
        'fund_payment_unit'=>'fund_payment_unit',
        'fund_receivables'=>'fund_receivables',
        'fund_money'=>'fund_money',
        'fund_moneys'=>'fund_moneys',
        'fund_name'=>'fund_name',
        'fund_duty'=>'fund_duty',
        'fund_number'=>'fund_number',

        'borrow'=>['borrow_duty','borrow_name','borrow_dutys','borrow_reason','borrow_money'],
        'borrow_duty'=>'borrow_duty',
		'borrow_name'=>'borrow_name',
        'borrow_dutys'=>'borrow_dutys',
        'borrow_reason'=>'borrow_reason',
        'borrow_money'=>'borrow_money',
        'borrow_moneys'=>'borrow_moneys',

        'payment'=>['payment_duty','payment_name','payment_receivables','payment_contract','payment_reason','payment_money','payment_moneys','payment_proportion','payment_actual_proportion'],
        'payment_duty'=>'payment_duty',
        'payment_name'=>'payment_name',
        'payment_receivables'=>'payment_receivables',
        'payment_contract'=>'payment_contract',
        'payment_reason'=>'payment_reason',
        'payment_money'=>'payment_money',
        'payment_moneys'=>'payment_moneys',
        'payment_proportion'=>'payment_proportion',
        'payment_actual_proportion'=>'payment_actual_proportion',

	];
	
}
