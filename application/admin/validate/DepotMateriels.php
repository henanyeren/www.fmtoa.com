<?php
namespace app\admin\validate;
use think\Validate;

class DepotMateriels extends Validate{
    protected $rule=[
        'type_name'=>'require|max:255',
        'type_pid'=>'require',

        'materiel_name'=>'require|min:2|max:150',
        'materiel_specifications'=>'require|min:1|max:30',
        'materiel_no'=>'require|min:1|max:128',
        'materiel_number'=>'require|max:11|number',
        'materiel_unit'=>'require|min:1|max:20'
    ];
    protected $message=[
        'type_name.require'=>'物料名不能为空',
        'type_name.max'=>'超出最大字限制',
        'type_pid.require'=>'类别id不能为空',
        'materiel_type_pid.require'=>'物料所属类别不能为空',
        'materiel_name.require'=>'物料名称不能为空',
        'materiel_name.max'=>'物料名称过长',
        'materiel_name.min'=>'物料名称过短',
        'materiel_specifications.require'=>'规格不能为空',
        'materiel_specifications.max'=>'规格过长',
        'materiel_specifications.min'=>'规格过短',
        'materiel_number.require'=>'数量为空',
        'materiel_number.number'=>'必须为数字',
        'materiel_number.max'=>'数量过长',
        'materiel_number.min'=>'数量过短',
        'materiel_no.require'=>'物料编号为空',
        'materiel_no.max'=>'物料编号过长',
        'materiel_no.min'=>'物料编号过短',
        'materiel_unit.require'=>'单位为空',
        'materiel_unit.max'=>'单位过长',
        'materiel_unit.min'=>'单位过短',
        'materiel_type_pid'=>'请选择类别',
    ];
    protected $scene=[
        'type_name'=>'type_name',
        'type_super_pid'=>'type_super_pid',
        'addtype'=>['type_name','type_pid'],
        'add'=>['materiel_type_pid','materiel_unit','materiel_name','materiel_specifications','materiel_no','materiel_number'],
        'materiel_type_pid'=>'materiel_type_pid',
        'materiel_name'=> 'materiel_name',
        'materiel_specifications'=>'materiel_specifications',
        'materiel_no'=>'materiel_no',
        'materiel_unit'=>'materiel_unit',
        'materiel_number'=>'materiel_number',

    ];
}