<?php
	namespace app\phone\controller;
	use think\Controller;
	class CancerRehabilitaion extends Controller{
        public function test()
	{
		$data=request()->post();
		$re=db('PatientCircleTherapy')->insert($data);
        if($re){
				return json_encode(array('msg'=>'成功'));				
		}else{
			
			return json_encode(array('msg'=>'失败'));	
		}
		
	}

    //查询病患资料列表
    public function lst(){
        $patiend_type = input('patiend_type');
        if (isset($patiend_type)){
           $data=db('PatientCircleTherapy')->where('patiend_type',$patiend_type)->paginate(15);
           if($data){
                return json_encode(array('state'=>'200','msg'=>$data));
           }else{
                return json_encode(array('state'=>'201','msg'=>'查询失败'));
           }
        }else{
            return json_encode(array('state'=>'101','msg'=>'参数错误'));
        }
       
    }

    //查询病患资料详情
    public function show(){
        $patiend_id = input('patiend_id');
        if (isset($patiend_id)){
           $data=db('PatientCircleTherapy')->where('patiend_id',$patiend_id)->find();
           if($data){
                return json_encode(array('state'=>'200','msg'=>$data));
           }else{
                return json_encode(array('state'=>'201','msg'=>'查询失败'));
           }
        }else{
            return json_encode(array('state'=>'101','msg'=>'参数错误'));
        }
       
    }

	public function cancer()
    {
        $imgFileNames = '';
        $files = request()->file();
        if ($files) {
            foreach ($files as $file) {
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move(ROOT_PATH . 'public' . DS . 'cancer');
                if ($info) {
                    // echo $info->getSaveName();
                    $imgFileNames .= $info->getSaveName() . ',';
                } else {
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
            }
            return rtrim($imgFileNames, ',');
            die;
        }


        $data=[
            "patiend_file"=>input('file'),//文件
            "patined_review"=>input('review'),//缩略图
            "patiend_admin"=>input('admin'),//文章提供者
            "patiend_remarks"=>input('remarks'),//备注
            "patiend_age"=>input('age'),//年龄
            "patiend_name"=>input('name'),//名字
            "patiend_sex"=>input('sex'),//性别
            "patiend_nation"=>input('nation'),//民族
            "patiend_marriage"=>input('marriage'),//婚姻状态   0未婚 1已婚 2再婚 3离异
            "patiend_profession"=>input('profession'),//职业
            "patiend_work_addr"=>input('work_addr'),//工作地址
            "patiend_tel"=>input('tel'),//电话
            "patiend_allergy"=>input('allergy'),//药物过敏
            "patiend_visi_time"=>input('visi_time'),//就诊时间
            "patiend_main_desc"=>input('main_desc'),//主要描述
            "patiend_disease_history"=>input('disease_history'),//现病史
            "patiend_disease_history_imgs"=>input('disease_history_imgs'),//现病史图片
            "patiend_previous_history"=>input('previous_history'),//既往史
            "patiend_previous_history_imgs"=>input('previous_history_imgs'),//既往史图片
            "patiend_personal_history"=>input('personal_history'),//个人史
            "patiend_personal_history_imgs"=>input('personal_history_imgs'),//个人史图片
            "patiend_menstrual_history"=>input('menstrual_history'),//月经历史
            "patiend_menstrual_history_imgs"=>input('menstrual_history_imgs'),//月经历史图片
            "patiend_marriage_history"=>input('marriage_history'),//婚姻历史
            "patiend_marriage_history_imgs"=>input('marriage_history_imgs'),//patiend_menstrual_history_imgs
            "patiend_family_history"=>input('family_history'),//家族史
            "patiend_family_history_imgs"=>input('family_history_imgs'),//家族史图片
            "patiend_physical_examination"=>input('physical_examination'),//体格检查
            "patiend_physical_examination_imgs"=>input('physical_examination_imgs'),//体格检查图片
            "patiend_tcm"=>input('tcm'),//中医四诊
            "patiend_accessory_examination"=>input('accessory_examination'),//辅助检查
            "patiend_accessory_examination_imgs"=>input('accessory_examination_imgs'),//辅助检查图片
            "patiend_tcm_diagnosis"=>input('tcm_diagnosis'),//中医诊断
            "patiend_tcm_diagnosis_imgs"=>input('tcm_diagnosis_imgs'),//中医诊断图片
            "patiend_western_diagnosis"=>input('western_diagnosis'),//西医诊断
            "patiend_western_diagnosis_imgs"=>input('western_diagnosis_imgs'),//西医诊断图片
            "patiend_circles"=>input('circles'),//接收圈疗数
            "patiend_therapeutic_opinion"=>input('therapeutic_opinion'),//治疗意见
            "patiend_therapeutic_opinion_imgs"=>input('therapeutic_opinion_imgs'),//治疗意见图片
            "patiend_doctor_signature"=>input('doctor_signature'),//医生签名
            "patiend_type"=>input('patiend_type'),//提交类型
            
        ];
        $re=db('PatientCircleTherapy')->insert($data);

        if($re){
            return json_encode(array('state'=>'200','msg'=>'成功'));
        }else{

            return json_encode(array('state'=>'101','msg'=>'失败!'));
        }
    }
		
		
	}
