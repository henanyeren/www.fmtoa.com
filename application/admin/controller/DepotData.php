<?php
namespace app\admin\controller;
use think\model;

class DepotData extends Common
  {
	//返回仓所有分页数据
	public function lst(){

		$materiel_data=db('depot_materiels')->paginate(15);
		$this->assign('list',$materiel_data);
		$page=$this->fetch();		
		return array('state'=>1,'page'=>$page);
	}

	//返回仓批次所有分页数据
	public function batchLst(){
		$materiel_id=input('id');
		if(!$materiel_id){
			return array('state'=>0,'page'=>'未传递参数');
		}
		
		$list=db('depot_materiels_goods')->where('materiel_pid',$materiel_id)->paginate(15);
		
		dump($list->toArray());die;
		
		
		foreach($list as $k=>$v){
		}
		$this->assign('list',$list);
		$page=$this->fetch();		
		return array('state'=>1,'page'=>$page);
	}
}
