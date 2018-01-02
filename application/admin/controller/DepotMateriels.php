<?php
namespace app\admin\controller;
use think\model;

class DepotMateriels extends Common
  {
		public function materielmanager()
		{

			$re=[
				'status'=>1,
				'page'=>$this->fetch(),
			];
			return $re;
		}  	

		public function goodsmanager()
		{

			$re=[
				'status'=>1,
				'page'=>$this->fetch(),
			];
			return $re;
		}  
		
		public function add()
		{
			//如果存在模块额外参数
		$module_parameter=input('module_parameter');
		
		if($module_parameter){
			$page_info=$this->typelist($module_parameter);
		}else{
			$page_info=$this->typelist();
		}
		
//		$this->assign('list',$page);
//		
//		$page=$this->fetch('typelist');
		
			
		if($page_info['state']==!1){
					dump('找不到分类页面');
		}
		
		
    $this->assign([
    		'page'=>$page_info['page'],
        'tabTitle'=>'物料添加',
    ]);
			$re=[
				'status'=>1,
				'page'=>$this->fetch(),
			];
			return $re;
		}
	//返回仓库类型的无限极分类
	public function typelist($module_parameter=0){
		$type_id=input('type_id')?input('type_id'):0;
		if($module_parameter){
			$type_id=$module_parameter;
		}
		
		//dump($type_id);
		$materiel_data=db('depot_type')->where('type_pid',$type_id)->select();
		$this->assign('list',$materiel_data);
		
		$page=$this->fetch('typelist');		
		if(!$materiel_data){
			return array('state'=>0,'page'=>'找不到子类');
		}
		return array('state'=>1,'page'=>$page);
	}

	//返回仓库类型 和数据 的无限极分类
	public function typelistData($module_parameter=0){
		$type_id=input('type_id')?input('type_id'):0;
		if($module_parameter){
			$type_id=$module_parameter;
		}
		
		//dump($type_id);
		$materiel_data=db('depot_type')->where('type_pid',$type_id)->select();
		$this->assign('list',$materiel_data);
		
		$page=$this->fetch('typelist');		
		if(!$materiel_data){
			//$mylist=db('depot_materiels')->where('materiel_type_pid',)->select();
			
			return array('state'=>0,'page'=>'找不到子类');
		}
		return array('state'=>1,'page'=>$page);
	}
				
		
		//添加处理数据
		public function addhanddle()
		{
			$data=request()->post();
			//默认数量为0
			$data['materiel_number']=0;
            $validate=validate('DepotMateriels');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            
            $re=db('DepotMateriels')->insert($data);

			if($re){
				return array('state'=>0,'msg'=>'物料添加成功');
			}else{
				return array('state'=>0,'msg'=>'物料添加失败');
			}
			return ;
		}
  	
    public function detail()
    {
        $id=input('id');
        $detail=db('DepotMateriels')->find($id);
        if($detail){
            $this->assign('detail',$detail);
            return array('state'=>'1','msg'=>$this->fetch(),'name'=>"物料预览");
        }else{
            return array('state'=>'0','msg'=>'查询错误');
        }
    }
    //无线联动,添加页面
    public function adds(){
        $type_super_id=input('type_super_id');
        $arr=explode(',',$type_super_id);
        $len=count($arr);

        $pid=array_pop($arr);
        $mydata=db('depot_type')->select();
        $re= model('DepotMateriels')->getChildrens($mydata,$pid);


        if(!$re){
            $re=[
                'status'=>-1,
                'val'=> $type_super_id,
            ];
            return $re;
        }
        $this->assign([
            'mylist'=>$re,
            'type_id'=>$len,
        ]);
        
        $re=[
            'status'=>1,
            'lens'=>$arr,
            'page'=>$this->fetch('mylst'),
            'val'=>$type_super_id,

        ];
        if(request()->isAjax()){
            return $re;
        }
    }

    public function lst(){
        
			$type_id=input('type_id')?input('type_id'):0;
			if($type_id);
				//如果存在模块额外参数
			$module_parameter=input('module_parameter');
			
			if($module_parameter){
				$type_id=$module_parameter;
				//dump($type_id);
			}
			$materiel_data=db('depot_type')->where('type_pid',$type_id)->select();
			//如果找不到类型，则查找数据
			if(!$materiel_data){
				$list=db('depot_materiels')->where('materiel_type_pid',$type_id)->select();
				$this->assign('list',$list);
				return array('state'=>2,'page_data'=>$this->fetch());
			}
					
			$this->assign('list',$materiel_data);
			
			$page=$this->fetch('typelistdata');		

			return array('state'=>1,'page'=>$page);
		
    }

    public function upd(){
        $id=input('id');
        $mydate=db('depot_materiels')->where('materiel_id',$id)->find();
        $mydata=db('depot_type')->select();
        $data= model('DepotMateriels')->getChildren($mydata);
        //unset($data[0]);
        $this->assign([
            'detail_info'=>$mydate,
            'mydata'=>$data,
        ]);
        $re=[
            'status'=>1,
            'page'=>$this->fetch(),
        ];
        if(request()->isAjax()){
            return $re;
        }
    }

    public function updhanddle(){
        $data=[
            'materiel_type_pid'=>input('materiel_type_pid'),
            'materiel_name'=>input('materiel_name'),
            'materiel_no'=>input('materiel_no'),
            'materiel_specifications'=>input('materiel_specifications'),
            'materiel_number'=>input('materiel_number'),
            'materiel_unit'=>input('materiel_unit'),
           // 'meteriel_remark'=>input('meteriel_remark'),
        ];
        $validate=validate('DepotMateriels');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }
       // $data['materiel_type_pid']=array_slice(explode(',',$data['meteriel_type_id']),-1,1)[0];
        $id=input('materiel_id');

        $re=db('depot_materiels')->where('materiel_id',$id)->update($data);
        if($re){
            return array('state'=>1,'msg'=>'物料类别添加成功');
        }else{
            return array('state'=>0,'msg'=>'物料类别添加失败');
        }
        return ;
    }

    public function del()
    {
        $id = input('materiel_id');
        $mycompany = db('depot_materiels')->delete($id);
        if ($mycompany) {
            return array('state' => 1, 'msg' => '删除成功！');
        } else {
            return array('state' => 0, 'msg' => '删除失败!');
        }
    }



//仓库物品类型管理

	public function type(){
		
		$re=[
			'status'=>1,
			'page'=>$this->fetch(),	
		];
			return $re;
	}

	public function typeadd(){

        $mydata=db('depot_type')->select();
        $data= model('DepotMateriels')->getChildren($mydata);
        $this->assign([
            'tabTitle'=>'物料类别添加',
            'mydata'=>$data,
        ]);
        $re=[
            'status'=>1,
            'page'=>$this->fetch(),
        ];
        return $re;
    }

    public function typeaddhanddle()
    {
        if(input('type_pid')==0){
            return array('state'=>0,'msg'=>'不允许添加首级分类！如需要请联系网站管理员！添加子类请选择类别！');
        }
	if(input('type_pid')==""){
	 return array('state'=>0,'msg'=>'物料类别添加失败,请选择类别！！');
	}
        $data=[
            'type_name'=>input('type_name'),
            'type_pid'=>input('type_pid')
        ];
        $validate=validate('DepotMateriels');
        if(!$validate->scene('addtype')->check($data)){
            $this->error($validate->getError());
        }
      //  $data['type_pid']=array_slice(explode(',',$data['type_super_id']),-1,1)[0];
        $re=db('depot_type')->insert($data);
       // $type_super_id=input('type_super_id').','.$re_id;
       // $re=db('depot_type')->where('type_id',$re_id)->update(['type_super_id'=>$type_super_id]);
        if($re){
            return array('state'=>1,'msg'=>'物料类别添加成功');
        }else{
            return array('state'=>0,'msg'=>'物料类别添加失败');
        }
        return ;
    }

    public function typelst(){
        $mydata=db('depot_type')->select();
        $data= model('DepotMateriels')->getChildren($mydata);
        $this->assign([
            'list'=>$data,
            'tabTitle'=>'物料类别列表'
        ]);
        $re=[
            'status'=>1,
            'page'=>$this->fetch('typelst'),
        ];
        if(request()->isAjax()){
            return $re;
        }
    }

    public function typedetail(){
        $id=input('id');
        $detail=db('depot_type')->find($id);
        if($detail){
            $this->assign('detail',$detail);
            return array('state'=>'1','msg'=>$this->fetch(),'name'=>"物料预览");
        }else{
            return array('state'=>'0','msg'=>'查询错误');
        }
    }

    public function typeupd(){
        $id=input('id');
        $mydate=db('depot_type')->where('type_id',$id)->find();
        $mydata=db('depot_type')->select();
        $data= model('DepotMateriels')->getChildren($mydata);
        $this->assign([
            'detail_info'=>$mydate,
            'mydata'=>$data,
        ]);
        $re=[
            'status'=>1,
            'page'=>$this->fetch(),
        ];
        if(request()->isAjax()){
            return $re;
        }
    }

public function typeupdhanddle(){
        $data=[
            'type_name'=>input('type_name'),
            'type_pid'=>input('type_pid')
        ];
        $id=input('type_id');
        if($id==input('type_pid')){
            return array('state'=>0,'msg'=>'请不要乱选（！');
        }
        if($id==1 || $id==7){
            return array('state'=>0,'msg'=>'此物料类别不允许修改！如需修改请联系管理员！');
        }
        $validate=validate('DepotMateriels');
        if(!$validate->scene('addtype')->check($data)){
            $this->error($validate->getError());
        }
        if($data['type_pid'] ==""){
            $re=db('depot_type')->where('type_id',$id)->update(array('type_name'=>input('type_name')));
        }else{
            $mydata=db('depot_type')->select();
            $mydata= $this->getSubs($mydata,$id);
          $i=0;
            foreach ($mydata as $key){
                if($key['type_id']==input('type_pid')){
                    $i=1;
                }
            }
            if($i==1){
               $pid=db('depot_type')->where('type_id',input('type_id'))->find()['type_pid'];
                $res=db('depot_type')->where('type_id',input('type_pid'))->update(array('type_pid'=>$pid));
                if(!$res){
                    return array('state'=>0,'msg'=>'修改失败');
                }
                $re = db('depot_type')->where('type_id', $id)->update($data);
            }else {
                $re = db('depot_type')->where('type_id', $id)->update($data);
            }
        }

        if($re){
            return array('state'=>1,'msg'=>'物料类别添加成功');
        }else{
            return array('state'=>0,'msg'=>'物料类别添加失败');
        }
        return ;
    }

    public function typedel()
    {
        $id = input('type_id');
        $mycompany = db('depot_type')->select();
        $myid= $this->getSubs($mycompany,$id);
        $re= db('depot_type')->delete($id);
        if(!$re){
            return ['state' => -1, 'msg' => $id . '父类删除失败'];
        }
        foreach ($myid as $key){
            $re= db('depot_type')->delete($key['type_id']);
            if(!$re){
                return ['state'=>-1,'msg'=>$key.'子类删除失败'];
            }
        }
        return array('state' => 1,'msg' => '删除成功！');

    }


    function getSubs($categorys,$catId=0,$level=1){
        $subs=array();
        foreach($categorys as $item){
            if($item['type_pid']==$catId){
                $item['level']=$level;
                $subs[]=$item;
                $subs=array_merge($subs,$this->getSubs($categorys,$item['type_id'],$level+1));
            }
        }
        return $subs;
    }

    public function upload(){
        if(request()->isAjax()){
            $validate=\think\Loader::validate('DepotMateriels');
            $mypost=request()->post();
            $mykey=array_keys($mypost)[0];
            
            if(!$validate->scene($mykey)->check($mypost)){
                return array('state'=>'0','msg'=>$validate->getError());
            }else{
                return array('state'=>'1','msg'=>'可以使用');
            }
        }
    }
    
    //返回类型信息控件
    public function infinite(){
    	$materiel_page_id=input('materiel_page_id');
    	$type_id=input('type_id')?input('type_id'):0;
    	
    	if(input('module_parameter')){
    		$type_id=input('module_parameter');
    	}
    	
    	
    	//dump($type_id);
    	$list=model('DepotMateriels')->getNextLevelChilds($type_id);
    	
    	//如果没有下级了，就找出物料信息
    	if(!$list){
    		$materiel_data=db('depot_materiels')->where('materiel_type_pid',$type_id)->select();
    		//dump($materiel_data);
    		$this->assign([
    			'materiel_data'=>$materiel_data,
    			'list'=>$list
    			]);
    		return array('state' => 2,'materiel_page_id'=>$materiel_page_id,'page' =>$this->fetch('infinite'),'page_data' =>$this->fetch('materiel_data'));
    	}
    	
    	//dump($list);die;
    	$this->assign([
    		'list'=>$list,
    		'materiel_data'=>'null'
    	]);
    	
    	return array('state' => 1,'page' =>$this->fetch('infinite'));
    	//dump($model_list);
    }

	public function history(){
		$materiel_pid=input('id');
		if(input('id')){
			session('materiel_pid',$materiel_pid);
		}else{
			$materiel_pid=session('materiel_pid');
		}
		
		$materiel_list=db('depot_press_materiels_goods')->order('materiel_id desc')->where([
			'materiel_is_add'=>1,
			'materiel_out_pid'=>$materiel_pid,
		])->paginate(5);

		$pagin_info=$materiel_list;
		$materiel_list=$materiel_list->toarray()['data'];
		
		foreach($materiel_list as $k=>$v){
					//获取主表信息，用于查找主表单时间
			$DepotPressMateriels_info=model('DepotPressMateriels')->find($v['materiel_main_table_pid']);
			
			$v['materiel_add_time']=$DepotPressMateriels_info->toArray()['materiel_add_time'];
			
			$new_materiel_list[$k]=$v;
		}
		if($new_materiel_list){
			$this->assign([
				'pagin_info'=>$pagin_info,
				'list'=>$new_materiel_list
				]);
			return array('state'=>'1','msg'=>$this->fetch(),'page'=>$this->fetch());
		}
		return array('state'=>'0','msg'=>'未找到记录！');
	}
	//获取仓库实体物品批次信息
	public function getDepotGoods(){
		//获取批次信息
		$materiel_id=input('materiel_id');
		//使用模型关联
		$DepotPress_model=model('DepotMateriels');
		$DepotPress_data=$DepotPress_model->get($materiel_id);
		$DepotPress_data->GetMaterielsGoodsInfo;
		
		$materiels_goods_list=$DepotPress_data->toArray();
		//删除为0的批次
		foreach($materiels_goods_list['GetMaterielsGoodsInfo'] as $k=>$v){
			//如果数量为0则删除
			if($v['materiel_number']<=0){
				unset($materiels_goods_list['GetMaterielsGoodsInfo'][$k]);
			}
		}
		$this->assign([
			'materiel_data'=>$materiels_goods_list,
		]);
    				
		return array('state' => 1,'page_data' =>$this->fetch('get_depot_goods'));
		//dump($materiels_goods_list);
		
	}

	
}