<?php
	namespace app\phone\controller;
	use think\Controller;

	class Marking extends Controller{
        public function area(){
        	$data=model('distributionArea')->select();
        	return json_encode($data);
        }
		public function lst(){
			$data = array();
			$listInfo=db('distribution_information')->paginate(10);
			$list=$listInfo->toArray();
			
			foreach($list['data'] as $k=>$v){
				$v['distribution_time']=date('m-d',$v['distribution_time']);
				$v['distribution_img']=explode(',',$v['distribution_img'])[0];
				array_push($data,$v);
			}
			$list['data']=$data;
			$re=json_encode($list);
			return $re;				
			
		}

        //个人列表
		public function my_lst(){
			$data = array();
			$distribution_user_id = input('distribution_user_id');
			$listInfo=db('distribution_information')->where('distribution_user_id',$distribution_user_id)->paginate(10);
			$list=$listInfo->toArray();
			
			foreach($list['data'] as $k=>$v){
				$v['distribution_time']=date('m-d',$v['distribution_time']);
				$v['distribution_img']=explode(',',$v['distribution_img'])[0];
				array_push($data,$v);
			}
			$list['data']=$data;
			$re=json_encode($list);
			return $re;				
			
		}


        //查询一条店铺信息
		public function oneinfo(){
			$distribution_id = input('distribution_id');
			$listInfo=model('distribution_information')->where('distribution_id',$distribution_id)->find();
			
			$data=$listInfo->distributionGoods;
			//dump($data->toArray());exit;

			foreach ($data as $v) {
				$info=$v['appCommodity'];
			}
			
			$re=json_encode($listInfo->toArray());
			return $re;			
			
			
		}		
		
	//提交图片和所有的信息
	public function addhanddle(){
    // 获取表单上传文件 例如上传了001.jpg
    	$imgFileNames='';
    	    $files = request()->file();
    	    if($files){
 			    foreach($files as $file){
			        // 移动到框架应用根目录/public/uploads/ 目录下
			        $info = $file->move(ROOT_PATH . 'public' . DS . 'marking');
			        if($info){
			           // echo $info->getSaveName();
			            $imgFileNames.= $info->getSaveName().',';
			        }else{
			            // 上传失败获取错误信息
			            echo $file->getError();
			        }    
			    } 
			    return rtrim($imgFileNames,','); die;    	
    	    }
    	    
			$data=[
				'distribution_img'=>rtrim(input('distribution_img'),','),
				'distribution_text'=>input('distribution_text'),
				'distribution_user_id'=>input('distribution_user_id'),
				'distribution_user_name'=>input('distribution_user_name'),
				'distribution_info_name'=>input('distribution_info_name'),
				'distribution_delivery_unit'=>input('distribution_delivery_unit'),
				'distribution_customer_tel'=>input('distribution_customer_tel'),
				'distribution_consignee'=>input('distribution_consignee'),
				'distribution_customer_signe'=>input('distribution_customer_signe'),
				'distribution_delivery_name'=>input('distribution_delivery_name'),
				'distribution_touching'=>input('distribution_touching'),
				'distribution_number'=>input('distribution_number'),
				'distribution_delivery_call'=>input('distribution_delivery_call'),
				'distribution_mode_of_payment'=>input('distribution_mode_of_payment'),
				'distribution_delivery_date'=>input('distribution_delivery_date'),
				'distribution_totalprict'=>input('distribution_totalprict'),
				'distribution_totalprict_big'=>input('distribution_totalprict_big'),
				'distribution_goods_ids'=>input('distribution_goods_ids'),
				'distribution_type'=>input('distribution_type'),
				
				'distribution_time'=>time()
			];
			
			if($id=db('distribution_information')->insertGetId($data)){
				$where=[
					'distribution_good_id'=>array('in',input('distribution_goods_ids'))
				];
				model('DistributionGoods')->where($where)->update(['distribution_pid' => $id]);
				return json_encode(array('status'=>'200','msg'=>"提交成功"));
			}else{
				return json_encode(array('status'=>'100','msg'=>"提交失败"));
			}
		}	
		

		
	public function detail()
	{
		$id=input('distribution_id');
		$detail=db('distribution_information')->find($id);
		if($detail){
			return json_encode($detail);
		}else{
			return json_encode(array('找不到你要的公告'));
		}
			
	}		

	//接收铺货信息=产品列表，并返回id
	public function distribution(){
		$data=[
			'distribution_name_id'=>input('distribution_name_id'),
			'distribution_lot_number'=>input('distribution_lot_number'),
			'distribution_format'=>input('distribution_format'),
			'distribution_unit'=>input('distribution_unit'),
			
			'distribution_goods_number'=>input('distribution_goods_number'),
			'distribution_univalent'=>input('distribution_univalent'),
			'distribution_total'=>input('distribution_total')
		];
		
		$id=db('distribution_goods')->insertGetId($data);
				if($id){
					return json_encode(array('status'=>'200','msg'=>$id));
				}else{
					return json_encode(array('status'=>'100','msg'=>"提交失败"));
				}
		}
	
	public function add_distribution_goods(){
			
			
		$data=[
			'distribution_delivery_unit'=>input('distribution_delivery_unit'),
			'distribution_delivery_unit'=>input('distribution_delivery_unit'),
			'distribution_consignee'=>input('distribution_consignee'),
			'distribution_customer_signe'=>input('distribution_customer_signe'),
			
			'distribution_touching'=>input('distribution_touching'),
			'distribution_delivery_call'=>input('distribution_delivery_call'),
			'distribution_mode_of_payment'=>input('distribution_mode_of_payment'),
			'distribution_goods_ids'=>input('distribution_goods_ids ')
		];
		
		
		
		
	}
		
	}
 