<?php
namespace app\admin\validate;
use think\Validate;

class DepotPress extends Validate{
    protected $rule=[
    	'materiel_pid'=>'require',
    	
    	
        'materiel_contract_for_purchase'=>'require|max:32',
        'materiel_add_time'=>'require|number',
        
        'materiel_demander_id'=>'require|number',
        'materiel_godown_keeper'=>'require|number',
        
        'materiel_type'=>'require|number',
        'materiel_no'=>'require|min:1|max:128',
        'meteriel_number'=>'require|max:11|number',
        'meteriel_unit'=>'require|min:1|max:20'
    ];
    protected $message=[
    	'materiel_pid.require'=>'请选择物料',
    
    	
        'materiel_contract_for_purchase.require'=>'不能为空',
        'materiel_contract_for_purchase.max'=>'超出最大字限制',
        'materiel_add_time.require'=>'不能为空',
        'materiel_add_time.number'=>'必须为数字',
        
        'materiel_demander_id.require'=>'不能为空',
        'materiel_demander_id.number'=>'必须为数字',
        'materiel_godown_keeper.require'=>'不能为空',
        'materiel_godown_keeper.number'=>'必须为数字',
        
        
        'materiel_type.require'=>'表类型必填',
        'materiel_type.number'=>'规类型必须为数字',
        
        'meteriel_number.require'=>'数量为空',
        'meteriel_number.number'=>'必须为数字',
        'meteriel_number.max'=>'数量过长',
        'meteriel_number.min'=>'数量过短',
        'materiel_no.require'=>'物料编号为空',
        'materiel_no.max'=>'物料编号过长',
        'materiel_no.min'=>'物料编号过短',
        'meteriel_unit.require'=>'单位为空',
        'meteriel_unit.max'=>'单位过长',
        'meteriel_unit.min'=>'单位过短',
        'meteriel_type_super_id'=>'请选择类别',
    ];
    protected $scene=[
    	'materiel_pid'=>'materiel_pid',
    	
    	
        'type_name'=>'type_name',
        'type_super_id'=>'type_super_id',
        'addtype'=>['type_name','type_super_id'],
        'add'=>[ 'meteriel_type_super_id', 'meteriel_unit','materiel_name','materiel_specifications','materiel_no','meteriel_number'],
        'meteriel_type_super_id'=>'meteriel_type_super_id',
        'materiel_name'=> 'materiel_name',
        'materiel_specifications'=>'materiel_specifications',
        'materiel_no'=>'materiel_no',
        'meteriel_unit'=>'meteriel_unit',
        'meteriel_number'=>'meteriel_number',

    ];
}