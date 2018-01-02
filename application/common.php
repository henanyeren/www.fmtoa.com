<?php

// use phpmailer\phpmailer;
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
    function SendMail($address,$title,$message)
    /*发送邮件的方法*/
    {
        vendor('PHPMailer.class#PHPMailer');
        $mail=new PHPMailer();          // 设置PHPMailer使用SMTP服务器发送Email
        $mail->IsSMTP();                // 设置邮件的字符编码，若不指定，则为'UTF-8'
        $mail->CharSet='UTF-8';         // 添加收件人地址，可以多次使用来添加多个收件人
        $mail->AddAddress($address);    // 设置邮件正文
        $mail->Body=$message;           // 设置邮件头的From字段。
        $mail->From=config('MAIL_ADDRESS');  // 设置发件人名字
        $mail->FromName='小可老师';  // 设置邮件标题
        $mail->Subject=$title;          // 设置SMTP服务器。
        $mail->Host=config('MAIL_SMTP');     // 设置为"需要验证" ThinkPHP 的config方法读取配置文件
        $mail->SMTPAuth=true;           // 设置用户名和密码。
        $mail->Username=config('MAIL_LOGINNAME');
        $mail->Password=config('MAIL_PASSWORD'); // 发送邮件。
        return($mail->Send());
    }

    function SendMessage($phonenum)
    /*发送短信方法*/
        {
            // 配置信息
            import('dayu.top.TopClient');
            import('dayu.top.TopLogger');
            import('dayu.top.request.AlibabaAliqinFcSmsNumSendRequest');
            import('dayu.top.ResultSet');
            import('dayu.top.RequestCheckUtil');
            $appkey = config('appkey');
            $secretKey = config('secretKey');
            
            $c = new \TopClient;
            $c ->appkey = $appkey ;
            $c ->secretKey = $secretKey ;
            
            $num = rand(100000,999999);

            cookie((string)$phonenum,$num,60);
            $req = new \AlibabaAliqinFcSmsNumSendRequest;
            $req ->setExtend( "" );
            $req ->setSmsType( "normal" );
            $req ->setSmsFreeSignName( "小可THINKP" );
            $req ->setSmsParam( "{code:'".$num."'}" );
            $req ->setRecNum( $phonenum );
            $req ->setSmsTemplateCode( "SMS_69190745" );
            $resp = $c ->execute( $req );


        }
        function hide_phone($str){  
            /*电话号码替换中间四位数*/
            $resstr=substr_replace($str,'****',3,4);  
            return $resstr;  
        }  
        
        
		function removeXSS($val){
			static $obj=null;
			if($obj===null){
				require('HTMLPurifier/HTMLPurifier.includes.php');
				$config=HTMLPurifier_Config::createDefault();
				
				$config->set('HTML.TargetBlank',TRUE);
				$obj=new HTMLPurifier($config);
			}
			return $obj->purify($val);
		}
		
		//身份证号码校验
		function validation_filter_id_card($id_card){
		    if(strlen($id_card)==18){
		        return idcard_checksum18($id_card);
		    }elseif((strlen($id_card)==15)){
		        $id_card=idcard_15to18($id_card);
		        return idcard_checksum18($id_card);
		    }else{
		        return false;
		    }
		}
		// 计算身份证校验码，根据国家标准GB 11643-1999
		function idcard_verify_number($idcard_base){
		    if(strlen($idcard_base)!=17){
		        return false;
		    }
		    //加权因子
		    $factor=array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
		    //校验码对应值
		    $verify_number_list=array('1','0','X','9','8','7','6','5','4','3','2');
		    $checksum=0;
		    for($i=0;$i<strlen($idcard_base);$i++){
		        $checksum += substr($idcard_base,$i,1) * $factor[$i];
		    }
		    $mod=$checksum % 11;
		    $verify_number=$verify_number_list[$mod];
		    return $verify_number;
		}
		// 将15位身份证升级到18位
		function idcard_15to18($idcard){
		    if(strlen($idcard)!=15){
		        return false;
		    }else{
		        // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
		        if(array_search(substr($idcard,12,3),array('996','997','998','999')) !== false){
		            $idcard=substr($idcard,0,6).'18'.substr($idcard,6,9);
		        }else{
		            $idcard=substr($idcard,0,6).'19'.substr($idcard,6,9);
		        }
		    }
		    $idcard=$idcard.idcard_verify_number($idcard);
		    return $idcard;
		}
		// 18位身份证校验码有效性检查
		function idcard_checksum18($idcard){
		    if(strlen($idcard)!=18){
		        return false;
		    }
		    $idcard_base=substr($idcard,0,17);
		    if(idcard_verify_number($idcard_base)!=strtoupper(substr($idcard,17,1))){
		        return false;
		    }else{
		        return true;
		    }
		}
		
		//第一个参数传递的参数
		function supplement_0($num,$temp_num = 10000000){
 			$new_num = $num + $temp_num;
 			$real_num = substr($new_num,1,7); //即截取掉最前面的“1”
 			return $real_num;	
		}


//签到月份规则，默认查询上一个月分的


 //计算有效期  1970年到2038年  超过此年份会出错
 //计算有效期  1970年到2038年  超过此年份会出错
 //计算有效期  1970年到2038年  超过此年份会出错
 //计算有效期  1970年到2038年  超过此年份会出错
 //计算有效期  1970年到2038年  超过此年份会出错
 //计算有效期  1970年到2038年  超过此年份会出错
 function month($month,$year,$category=0/*类别  0为默认查出上一个月的日期*/){
     //dump($month.$year);
     //判断是否是默认设置
     if($category ==0 ) {
         if ($month == 1) {
             $month = 12;
             $year = $year - 1;
         } else {
             $month = $month - 1;
         }
     }
     //dump($month.$year);

		$months=[
		    1=>[31,'0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0'],
            2=>[28,'0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0'],
            3=>[31,'0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0'],
            4=>[30,'0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0'],
            5=>[31,'0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0'],
            6=>[30,'0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0'],
            7=>[31,'0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0'],
            8=>[31,'0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0'],
            9=>[30,'0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0'],
            10=>[31,'0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0'],
            11=>[30,'0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0'],
            12=>[31,'0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0'],
        ];
		if($year%100 !=0 && $year%4 ==0 || $year%100 ==0 && $year%400 ==0){
                $months[2]=[29,'0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0'];
        }
     //计算有效期  1970年到2038年01月19日03时14分07秒 超过此年份会出错
            $time=$year.'-'.$month;
	        $times=$year.'-'.$month.'-'.$months[$month][0];
            $months[$month]['time']=strtotime($time);
            $months[$month]['times']=strtotime($times);
            $months[$month]['month']=date('m', $months[$month]['time']);
            $week=date('w', $months[$month]['time']);
            $myweek=[
                0=>'日',
                1=>'一',
                2=>'二',
                3=>'三',
                4=>'四',
                5=>'五',
                6=>'六',

            ];
            for ($i=0;$i<$months[$month][0];$i++){

                $weeks[$i+1]=$myweek[$week];
                $week++;
                if($week==7){
                    $week=0;
                }
            }
            $months[$month]['week']=$weeks;
        return $months[$month];
 }
		
