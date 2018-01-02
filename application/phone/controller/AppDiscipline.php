<?php
namespace app\phone\controller;
use think\Controller;
class AppDiscipline extends Controller{
	public function discipline_add(){
		//插入检验
         $user_id=input('user_id');
        if (isset($user_id)){
            $data['discipline_admin_id']=$user_id;
            $data['discipline_name']=input('discipline_name');
            $data['discipline_number']=input('discipline_number');
            $data['discipline_product_name']=input('discipline_product_name');
            $data['discipline_source']=input('discipline_source');
            $data['discipline_content']=input('discipline_content');
            $data['discipline_time']=time();
            $id=model('app_discipline')->insertGetId($data);
            if($id){
					return json_encode(array('status'=>'200','msg'=>$id));
				}else{
					return json_encode(array('status'=>'100','msg'=>"提交失败"));
			}
        }else{
            return json_encode(array('state'=>'101','msg'=>'参数错误'));
        }
	}


	public function discipline_goods_add(){
		// 获取表单上传文件 例如上传了001.jpg
    	$imgFileNames='';
    	    $files = request()->file();
    	    if($files){
 			    foreach($files as $file){
			        // 移动到框架应用根目录/public/uploads/ 目录下
			        $info = $file->move(ROOT_PATH . 'public' . DS . 'discipline');
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
		//插入检验
         $discipline_pid=input('discipline_pid');
        if (isset($discipline_pid)){
            $data['discipline_pid']=$discipline_pid;
            $data['discipline_goods_number']=input('discipline_goods_number');
            $data['discipline_goods_weight']=input('discipline_goods_weight');
            $data['discipline_goods_unit']=input('discipline_goods_unit');
            $data['discipline_goods_size']=input('discipline_goods_size');
            $data['discipline_goods_content']=input('discipline_goods_content');   
            $data['discipline_goods_img']=rtrim(input('discipline_goods_img'),',');
            $data['discipline_goods_time']=time();
            $id=db('app_discipline_goods')->insertGetId($data);
            if($id){
					return json_encode(array('status'=>'200','msg'=>$id));
				}else{
					return json_encode(array('status'=>'100','msg'=>"提交失败"));
			}
        }else{
            return json_encode(array('state'=>'101','msg'=>'参数错误'));
        }
	}

    public function query(){
        //插入检验
         $user_id=input('user_id');
        if (isset($user_id)){
            $where=[
                'discipline_admin_id'=>$user_id
            ];
            //return dump($where);exit;
            $stime=strtotime(date('Y-m-d', time()));
            $etime=strtotime(date('Y-m-d',strtotime("+1day",time())));
            $re=db('app_discipline')->where($where) ->where('discipline_time','>=',$stime)
                                                    ->where('discipline_time','<',$etime)
                                                    ->paginate(8);
            if($re){
                    return json_encode(array('status'=>'200','data'=>$re));
                }else{
                    return json_encode(array('status'=>'100','msg'=>"查询失败"));
            }
        }else{
            return json_encode(array('state'=>'101','msg'=>'参数错误'));
        }
    }
    
}