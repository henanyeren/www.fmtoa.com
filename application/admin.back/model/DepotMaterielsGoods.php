<?php
namespace app\admin\model;
use \think\Model;

class DepotMaterielsGoods extends Model
{
	protected $resultSetType='collection';

    //返回商品和数据主表的关联
    public function DepotMateriels(){
    	return $this->hasOne('DepotMateriels','materiel_id','materiel_pid');
    }
    
}