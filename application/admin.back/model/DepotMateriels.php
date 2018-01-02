<?php
namespace app\admin\model;
use \think\Model;

class DepotMateriels extends Model
    /*无限级分类得到全部子类*/
{
	protected $resultSetType='collection';
    public function getChildren($list,$pid=0,$level=0){
 		static $arr = array();
		foreach ($list as $key => $value) {
			if($value['type_pid']==$pid){
				$value['level'] = $level;
				$value['str'] = str_repeat('————',$value['level']);
				$arr[] = $value;
				$this->getChildren($list,$value['type_id'],$level+1);
			}
		}
		return $arr;
	}
	
    public function getChildrens($list,$pid=0,$level=0){
        static $arr = array();
        foreach ($list as $key => $value) {
            $pidArr=explode(',',$value['type_super_id']);
            if(count($pidArr)<2){
                $duty_super_id= 0;
            }else{
                $duty_super_id=$pidArr[count($pidArr)-2];
            }
            if($duty_super_id==$pid){
                $value['level'] = $level;
                $value['str'] = str_repeat('——',$value['level']);
                $arr[] = $value;
                if ($value['level']==1){
                 break;
                }else {
                    $this->getChildren($list, $value['type_id'], $level + 1);
                }
            }
        }

        return $arr;
    }
    
    //插件获取下级
    public function getNextLevelChilds($pid){
    	$list=db('depot_type')->where('type_pid',$pid)->select();
   
    	return $list;
    }
    
    public function DepotPressMaterielsGoods(){
    	return $this->belongsTo('DepotPressMaterielsGoods','materiel_pid','materiel_id');
    }	    
    
    
    //关联得出物料名称
    public function GetMaterielsGoodsInfo(){
    	return $this->hasMany('DepotMaterielsGoods','materiel_pid','materiel_id');
    }		    

    
}