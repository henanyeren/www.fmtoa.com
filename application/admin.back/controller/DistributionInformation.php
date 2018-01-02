<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use app\admin\model\DistributionInformation as DistributionInformationModel;

class DistributionInformation extends Common
  {
    public function detail()
    {
        $id=input('id');
        
				$detail=db('DistributionInformation')->find($id);
				
				//根据ID制作编号
    		$newNumber = substr(strval($detail['distribution_id']+100000000),1,8);
    		
				$detail['distribution_id']=$newNumber;
				$subArr=DistributionInformationModel::get($id)->comm()->select();
				
				//如果存在铺货商品
				if($subArr){
					//遍历里面的关联数据
					foreach($subArr as $k1=> $v1){
						$getNewArr=[
											'distribution_good_id'				=>$v1->distribution_good_id,
											'distribution_lot_number'			=>$v1->distribution_lot_number,
											'distribution_name_id'=>$v1->distribution_name_id,
											'distribution_format'			=>$v1->distribution_format,
											'distribution_unit'			=>$v1->distribution_unit,
											'distribution_goods_number'			=>$v1->distribution_goods_number,
											'distribution_univalent'			=>$v1->distribution_univalent,
											'distribution_total'			=>$v1->distribution_total,
											'distribution_pid'			=>$v1->distribution_pid,
						];
						$detail['sub'][$k1+1]=$getNewArr;
					}
				}else{
					$detail['sub']=null;
				}
        if($detail){
            $this->assign('detail',$detail);
            return array('state'=>'1','msg'=>$this->fetch(),'name'=>"铺货信息预览");
        }else{
            return array('state'=>'0','msg'=>'查询错误');
        }
    }
    public function lst(){

			$infos=db('DistributionInformation')->paginate(1);
			$list=$infos->toArray();
			foreach($list['data'] as $k=> $v){
				$subArr= distributionInformationModel::get($v['distribution_id'])->comm()->select();
				
				foreach($subArr as $k1=> $v1){
					$getNewArr=[
										'distribution_good_id'				=>$v1->distribution_good_id,
										'distribution_name_id'=>$v1->distribution_name_id,
										'distribution_format'			=>$v1->distribution_format,
										'distribution_unit'			=>$v1->distribution_unit,
										'distribution_goods_number'			=>$v1->distribution_goods_number,
										'distribution_univalent'			=>$v1->distribution_univalent,
										'distribution_total'			=>$v1->distribution_total,
										'distribution_pid'			=>$v1->distribution_pid,
					];
					$list['data'][$k]['sub'][$k1]=$getNewArr;
				}
			}
			

		$this->assign([
			'list'=>$list,
			'paginate'=>$infos,
			]);
		
		$re=[
			'status'=>1,
			'page'=>$this->fetch(),	
		];
		
		if(request()->isAjax()){
			return $re;
		}


    }
    public function del()
    {
        $id = input('distribution_id');
        $mycompany = db('DistributionInformation')->delete($id);
        if ($mycompany) {
            return array('state' => 1, 'msg' => '删除成功！');
        } else {
            return array('state' => 0, 'msg' => '删除失败!');
        }
    }



}