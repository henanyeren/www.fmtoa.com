<?php
namespace app\phone\controller;
use think\Controller;
class AppProductTest extends Controller{
	public function test_add(){


        // 获取表单上传文件 例如上传了001.jpg
    	$imgFileNames='';
    	    $files = request()->file();
    	    if($files){
 			    foreach($files as $file){
			        // 移动到框架应用根目录/public/uploads/ 目录下
			        $info = $file->move(ROOT_PATH . 'public' . DS . 'productTest');
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
         $product_test_admin_id=input('user_id');
        if (isset($product_test_admin_id)){
            $data['product_test_admin_id']=$product_test_admin_id;
            $data['product_test_product_name']=input('product_test_product_name');
            $data['product_test_batch']=input('product_test_batch');
            $data['product_test_number']=input('product_test_number');
            $data['product_test_project']=input('product_test_project');
            $data['product_test_name']=input('product_test_name');
            $data['product_test_warehousing_date']=input('product_test_warehousing_date');   
            $data['product_test_please_date']=input('product_test_please_date');
            $data['product_test_check_date']=input('product_test_check_date');
            $data['product_test_report_date']=input('product_test_report_date');
            $data['product_test_content']=input('product_test_content');
            $data['product_test_type']=input('product_test_type');
            $data['product_test_imgs']=rtrim(input('product_test_imgs'),',');
            $data['product_test_time']=time();
            $re=db('app_product_test')->insertGetId($data);
            if($re){
					return json_encode(array('status'=>'200','msg'=>'提交成功'));
				}else{
					return json_encode(array('status'=>'100','msg'=>"提交失败"));
			}
        }else{
            return json_encode(array('state'=>'101','msg'=>'参数错误'));
        }





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


	
    
}