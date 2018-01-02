<?php
	namespace app\admin\controller;
	use think\Controller;

	class Commodity extends Common{
		
		public function add()
		{
			$this->assign([
				'tabTitle'=>'添加商品',
			]);	
			$re=[
				'status'=>1,
				'page'=>$this->fetch(),
			]; 
			return $re;
		}

		//	商品添加处理数据
		public function addhanddle()
		{
			$data['commodity_img']=input('commodity_img');
			$data['commodity_name']=input('commodity_name');
			$data['commodity_preview']=input('commodity_preview');
			$data['time']=time();
            $validate=validate('Commodity');
        if(!$validate->scene('add1')->check($data)){
            $this->error($validate->getError());
        }
			$re=db('app_commodity')->insert($data);
			if($re){
				return array('state'=>1,'msg'=>'规则添加成功');
			}else{
				return array('state'=>0,'msg'=>'规则添加失败');
			}
				
			return ;
		}

		///获取商品信息
	public function lst()
	{
	    $join=[
	       ['app_commodity_add add','a.price_add_id = add.add_id','RIGHT'],
            ['app_commodity b','a.price_commodity_id = b.commodity_id','RIGHT']
        ];
        $list = db('app_commodity_price')->alias('a')->join($join)->select();

        $item=array();
        //var_dump($list);
        foreach($list as $k=>$v){
            if(!isset($item[$v['commodity_id']])){
                $item[$v['commodity_id']][]=$v;
            }else{
                $item[$v['commodity_id']][]=$v;
            }
        }
			$this->assign([
				'list'=>$item,
				'tabTitle'=>'商品列表',
			]);	
			
			$re=[
				'status'=>1,
				'page'=>$this->fetch('lst'),
			];
			
			if(request()->isAjax()){
				return $re;
			}
    }

	
	
	
	//修改商品获取页面
	public function upd()
	{
		$id=input('id');
		$detail_info=db('app_commodity')->where('commodity_id',$id)->find();
		$this->assign('detail_info',$detail_info);

		$re=[
			'status'=>1,
			'page'=>$this->fetch('upd'),
		];
		
		return $re;
	}
	
	//修改商品上传数据
	public function updhanddle()
	{
		$data=[
				'commodity_preview'=>input('commodity_preview'),
				'commodity_name'=>input('commodity_name'),
				'commodity_img'=>input('commodity_img'),
			];
		$id=input('commodity_id');
		$validate=validate('commodity');
		if(!$validate->scene('add1')->check($data)){
			$this->error($validate->getError());
		}

		$re=db('app_commodity')->where('commodity_id',$id)->update($data);
		if($re){
			return array('state'=>1,'msg'=>'修改成功');
		}else{
			return array('state'=>0,'msg'=>'修改失败');
		}
		
	}
//修改金额页面
        public function updprice()
        {
            $data['price_commodity_id']=input('id');
            $data['price_add_id']=input('add_id');
            $detail_info=db('app_commodity_price')
                ->where($data)
                ->alias('a')
                ->join('app_commodity_add b','a.price_add_id = b.add_id')
                ->join('app_commodity c','a.price_commodity_id = c.commodity_id ')
                ->find();
            $this->assign('detail_info',$detail_info);

            $re=[
                'status'=>1,
                'page'=>$this->fetch('updprice'),
            ];

            return $re;
        }

        //获取修改金额
        public function updpricehanddle(){
            $data['price_commodity_id']=input('price_commodity_id');
            $data['price_add_id']=input('price_add_id');
		    $add['price']=input('price');
		    if (db('app_commodity_price')->where($data)->update($add)){
                return array('state'=>1,'msg'=>'修改成功');
            }else{
                return array('state'=>0,'msg'=>'修改失败');
            }

        }

		public function upload()
		{
			if(request()->isAjax()){
				$admin_post=request()->post();
				$key=array_keys($admin_post)[0];
				
				
				$validate=validate('Commodity');
				if(!$validate->scene($key)->check($admin_post))
				{
					return array('state'=>'0','msg'=>$validate->getError());
				}else{
					return array('state'=>'1','msg'=>'名称可以使用');
				}
			}
		}
		public function del()
		{
			$id=input('commodity_id');
			if(db('app_commodity')->delete($id)){
			    db('app_commodity_price')->where('price_commodity_id',$id)->delete();
				return array('state'=>1,'msg'=>'删除成功！');
			}else{
				return array('state'=>0,'msg'=>'删除失败!');	
			}
		}
		
		
	public function detail()
	{
		$id=input('id');
		$detail=db('app_commodity')->where('commodity_id',$id)->find();
		if($detail){
            $this->assign('detail',$detail);
			return array('state'=>'1','msg'=>$this->fetch(),'name'=>'商品详情');
		}else{
			return array('state'=>'0','msg'=>'查询错误');
		}
    }
        public function uploads(){
            // 获取表单上传文件 例如上传了001.jpg9
            $file = request()->file('thumb');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $file_img="public".DS."commodity";
            $files_img=DS."commodity";
            $info_img = $file->move(ROOT_PATH .$file_img);
            if($info_img){
                $address=$files_img.DS.$info_img->getSaveName();
                $thumb_img=\think\Image::open('commodity'.DS.$info_img->getSaveName());
                $thumb="commodity".DS.time().".png";
                if($thumb_img->thumb(80,60,6)->save($thumb)){
                    $b[0]="<script>alert('文件上传成功！');</script>";
                    $b[1]=$address;
                    $b[2]=$thumb;
                    return $b;}else{
                    $b[0]="<script>alert('缩略图生成失败请重试！');</script>";
                    $b[1]=0;
                    $b[2]=0;
                    return $b;
                }
            }else{
                $b[0]="<script>alert('文件上传失败请重试！');</script>";
                $b[1]=0;
                $b[2]=0;
                return $b;
            }
        }

        //添加商品地区
        public function addressadd(){
            $this->assign([
                'tabTitle'=>'添加商品价格',
            ]);
            $re=[
                'status'=>1,
                'page'=>$this->fetch(),
            ];
            return $re;
        }
     //上传商品地区
        public function addressaddhanddle(){

            $data['address']=input('address');
            $validate=validate('Commodity');
            if(!$validate->scene('address')->check(input('address'))){
                $this->error($validate->getError());
            }
            $re=db('app_commodity_add')->insert($data);
            if($re){
                return array('state'=>1,'msg'=>'地址添加成功');
            }else{
                return array('state'=>0,'msg'=>'规则添加失败');
            }

            return ;
        }

        public function addlst(){
            //地区列表
            $list=  db('app_commodity_add')->select();
            $this->assign('add',$list);
            $re=[
                'status'=>1,
                'page'=>$this->fetch('addlst'),
            ];
            return $re;

        }

        public function addupd(){
            //修改地区页面
            $add_id=input('id');
            $list=  db('app_commodity_add')->where('add_id',$add_id)->find();
            $this->assign('add',$list);
            $re=[
                'status'=>1,
                'page'=>$this->fetch('addupd'),
            ];
            return $re;
        }
        //地区列表修改
        public function addupdhand(){
            $id=input('add_id');
            $data['address']=input('address');
            if(db('app_commodity_add')->where('add_id',$id)->update($data)){
                return array('state'=>1,'msg'=>'地址修改成功');
            }else{
                return array('state'=>0,'msg'=>'地址修改失败');
            }

        }

        //地区删除
        public function adddel(){
            $id=input('id');
            if(db('app_commodity_add')->delete($id)) {
                $data = db('app_commodity_price')->where('price_add_id', $id)->delete();
                if ($data) {
                    return array('state' => 1, 'msg' => '删除成功！');
                } else {
                    return array('state' => 0, 'msg' => '删除失败!');
                }
            }
        }

        //添加商品价格
        public function priceadd(){
            $commodity=db('app_commodity')->select();
            $add=db('app_commodity_add')->select();
            $this->assign([
                'tabTitle'=>'添加商品价格',
                'co'=>$commodity,
                'add'=>$add,
            ]);
            $re=[
                'status'=>1,
                'page'=>$this->fetch(),
            ];
            return $re;
        }

        public function priceaddhanddle(){

            $data['price_add_id']=input('price_add_id');
            $data['price_commodity_id']=input('price_commodity_id');
            $data['price']=input('price');

            $where=[
                'price_add_id'=>input('price_add_id'),
                'price_commodity_id'=>input('price_commodity_id'),
            ];
            if(db('app_commodity_price')->where($where)->select()){
                return array('state'=>0,'msg'=>'价格已经添加');
            }
            $re=db('app_commodity_price')->insert($data);
            if($re){
                return array('state'=>1,'msg'=>'价格添加成功');
            }else{
                return array('state'=>0,'msg'=>'价格添加失败');
            }

            return ;
        }
	}
