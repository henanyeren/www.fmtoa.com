<?php
namespace app\phone\controller;
use think\Controller;
use think\Request;
use app\phone\model\DistributionInformation as DistributionInformationModel;

class DistributionInformation extends Controller
  {
    public function add(){

        if(request()->post()) {
            $companydata['distribution_img'] = input('distribution_img');
            $companydata['distribution_name']=input('distribution_name');
            $companydata['distribution_time'] = time();
            $companydata['distribution_content'] = input('distribution_content');
            $res = db('DistributionInformation')->insert($companydata);
            if ($res) {
                return array('state'=>1,'msg'=>'添加成功！');
            } else {
                return array('state'=>1,'msg'=>'添加失败');
            }
        }

        $re=[
            'status'=>1,
            'page'=>$this->fetch('add'),
        ];
        return $re;

    }

    public function lst(){
//      $mycompany=db('DistributionInformation')
//      ->alias
//      
//      ;
//      $this->assign('mycompany',$mycompany);
//      $re=[
//          'status'=>1,
//          'page'=>$this->fetch('lst'),
//      ];
//      if(request()->isAjax()){
//          return $re;
//      }
       
      // $data=model('DistributionInformation')->select();
      
      $id=input('distribution_id');
      $infos=DistributionInformationModel::get($id)->toArray();
      if($infos){
      	$infos['status']=200;
      }
      $list=DistributionInformationModel::get($id)->comm()->select();
       
				
				foreach($list as $k1=> $v1){
					$getNewArr=[
							'distribution_good_id'			=>$v1->distribution_good_id,
							'distribution_name_id'			=>$v1->distribution_name_id,
							'distribution_format'			=>$v1->distribution_format,
							'distribution_unit'			=>$v1->distribution_unit,
							'distribution_goods_number'		=>$v1->distribution_goods_number,
							'distribution_lot_number'		=>$v1->distribution_lot_number,
							'distribution_univalent'		=>$v1->distribution_univalent,
							'distribution_total'			=>$v1->distribution_total,
							'distribution_pid'			=>$v1->distribution_pid,
										
					];
					$infos['sub'][$k1]=$getNewArr;
				}
				
			return json_encode($infos);
			
			die;
				//$infos=DistributionInformationModel::get(1)->comm()->select();		
//			foreach($infos as $v){
//				v
//				
//				$Distribution=[
//					'distribution_id'				=>$v->distribution_id,
//				//			dump($arr);
			//dump($infos->select());
			
			
//			
	//		dump($infos);
			
//			foreach($infos->comm as $v){
//				dump($v);
//			}
//     
//			$infos=DistributionInformationModel::get(1);
////			
//			dump($infos->comm);
//			
//			foreach($infos as $v){
//				dump($v->comm());
//			}

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
    public function upload(){
        if(request()->isAjax()){
            $validate=\think\Loader::validate('DistributionInformation');
            $mypost=request()->post();
            $mykey=array_keys($mypost)[0];
            if(!$validate->scene($mykey)->check($mypost)){
                return array('state'=>'0','msg'=>$validate->getError());
            }else{
                return array('state'=>'1','msg'=>'可以使用');
            }
        }
    }
    public function uploads(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('thumb');
        // 移动到框架应用根目录/public/uploads/ 目录下
        //获取文件名字
            $file_img="public".DS."information";
            $files_img=DS."information";
            $info_img = $file->move(ROOT_PATH .$file_img);
            if($info_img){
                $address=$files_img.DS.$info_img->getSaveName();
                $b[0]="<script>alert('文件上传成功！');</script>";
                $b[1]=$address;
                return $b;
            }else{
                $b[0]="<script>alert('文件上传失败请重试！');</script>";
                $b[1]=0;
                return $b;
            }
    }
    //修改获取页面
    public function upd()
    {
        $id=input('id');
        $detail_info=db('DistributionInformation')->find($id);
        $this->assign('company',$detail_info);

        $re=[
            'status'=>1,
            'page'=>$this->fetch('upd'),
        ];

        return $re;
    }

    //修改上传数据
    public function updhanddle()
    {
        $data=[
            'distribution_img' =>input('distribution_img'),
       'distribution_name'=>input('distribution_name'),
        'distribution_content'=> input('distribution_content'),
        ];
        $id=input('distribution_id');
      $validate=validate('DistributionInformation');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }
        $re=db('DistributionInformation')->where('distribution_id',$id)->update($data);
        if($re){
            return array('state'=>1,'msg'=>'修改成功');
        }else{
            return array('state'=>0,'msg'=>'修改失败');
        }
    }
    public function detail()
    {
        $id=input('id');

        $detail=db('DistributionInformation')->find($id);
        if($detail){
            $this->assign('detail',$detail);
            return array('state'=>'1','msg'=>$this->fetch(),'name'=>"铺货信息预览");
        }else{
            return array('state'=>'0','msg'=>'查询错误');
        }
    }

}
