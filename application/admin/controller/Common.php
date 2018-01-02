<?php  
namespace app\admin\controller;
use think\Db;
/**
* 公共控制器
*/
class Common extends \think\Controller
{
	public function _initialize()
	/*控制器初始化函数*/
	{
		if (!session("?admin_id")) {
			$this->redirect('login/login');
		}
		$module_model = model('module');
		$module_list_select = db('module')->where('module_status','eq','1')->select();
		$module_list_inM = $module_model->getChildrenM($module_list_select);
		if(!in_array(session('admin_name'),config('superadmin'))){
			$auth = new Auth();
			if (!$auth->check(request()->controller()."/".request()->action(),session('admin_id'))) {
				$this->error('您没有该权限','index/index');
			}
			//获取管理员拥有的权限
			$authlist = $auth->getAuthList(session('admin_id'),'1');
			foreach ($module_list_inM as $key => $value) {
				//判断模块是否在权限里面
				if (in_array($value['module_name'],$authlist)) {
					$module_list_inM1[] = $value;
				}
			}
			$module_list_inM = $module_list_inM1;
		}
		$this->assign('module_list_selectM',$module_list_inM);
	
		//获取邮件
		$email_info=db('email')->where([
			'email_to_id'=>session('admin_id'),
			'email_is_read'=>0
			])->select();
			
		//获取所属部门事务流程表id
		$duty_info=db('duty')->where('duty_super_id',session('admin_duty_superid'))->find();
		//获取事务查找 指定 表群
		$tables=db('flow_tables')->where('table_id',$duty_info['duty_flow_tables_id'])->find()['table_weights_names'];
		$table_arr=explode(',',$tables);
		static $flow_connt=0;
		foreach($table_arr as $k=>$v){
			if($v){
				//获取未处理事务数量
				//$flow_connt+=(int)
				$requisitionl_flow=db($v)->field('requisitionl_flow')->where('requisition_is_end',0)->select();
				
				//处理所以未完成的事务，得出所属部门的事务
				foreach($requisitionl_flow as $k=>$v1){
					$requisitionl_flow_sub_arr=explode(',',$v1["requisitionl_flow"]);

						//遍历得出事务流程的所有id，判断是否很管理员部门ID相同，如果相同
						foreach($requisitionl_flow_sub_arr as $k=>$v2){
							if($k==0){
								if($v2==$duty_info['duty_id']){
									$flow_connt++;
								}								
							}else{
								if($v2==$duty_info['duty_id']&&!$requisitionl_flow_sub_arr[$k-1]){
									$flow_connt++;
								}								
							}

						}
				}				
			}
		}
		//dump($flow_connt);
		//判断邮件数量并累计
		$email_info_counts=count($email_info);
			$this->assign('email_info_counts',$email_info_counts);
		
		$message_counts=$flow_connt+$email_info_counts;
		$this->assign([
			'email_info'=>$email_info,	//未处理邮件个数
			'flow_connt'=>$flow_connt, //未处理事务个数
			'message_counts'=>$message_counts	//所有未处理个数
		]);
	}

    public function NP_Excel($filename,$headArr,$list){
        //接收名字   必须带后缀名   后缀名   xlsx
        if(empty($list) || !is_array($list)){
            die("<script>alert('error1！');</script>");
        }
        if(empty($headArr) || !is_array($headArr)){
            die("<script>alert('error！');</script>");
        }
        //检查文件名
        if(empty($filename)){
            die("<script>alert('error');</script>");
        }
        //实例化Excel
        $path = dirname(__FILE__); //找到当前脚本所在路径
        $PHPExcel = new\PHPExcel; //实例化PHPExcel类，类似于在桌面上新建一个Excel表格
        $PHPSheet = $PHPExcel->getActiveSheet(); //获得当前活动sheet的操作对象
        $PHPSheet->setTitle('demo'); //给当前活动sheet设置名称

        //表头填充
        $key=ord('A');
        foreach ($headArr as $v){//表头循环
            $colum=chr($key);
            $PHPSheet->setCellValue($colum.'1',$v);
            $key+=1;
        }
        //传入数据数组   自动填充数据
        $i=2;
        foreach ($list as $key => $value) {//把行循环出来
            $keys=ord('A');
            foreach ($value as $va){//把列循环出来
                $j=chr($keys);
                $PHPSheet->setCellValue($j.$i, $va);
                $keys++;
            }
            $i++;
        }

        //生成Excel并下载
        $PHPWriter = PHPExcel_IOFactory::createWriter($PHPExcel,'Excel2007');//按照指定格式生成Excel文件，'Excel2007'表示生成2007版本的xlsx，'Excel5'表示生成2003版本Excel文件
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');//告诉浏览器输出07Excel文件
        //header('Content-Type:application/vnd.ms-excel');//告诉浏览器将要输出Excel03版本文件
        header("Content-Disposition: attachment;filename=\"$filename\"");//告诉浏览器输出浏览器名称
        header('Cache-Control: max-age=0');//禁止缓存
        $PHPWriter->save("php://output");
        exit;
    }


    public function words($html,$file){
        $html='<p>'.$html.'</p>';
        $word = new word();
        $word->start();
        /* $file = iconv('UTF-8','GBK',$file);//防止乱码
         $html=iconv('UTF-8','GBK',  $html); //防止乱码*/
        echo $html;
        $word->save(ROOT_PATH .$file); //可以自定义保存路径
        ob_flush();//每次执行前刷新缓存
        flush();
    }




    /**
     * 人民币小写转大写
     *
     * @param string $number 数值
     * @param string $int_unit 币种单位，默认"元"，有的需求可能为"圆"
     * @param bool $is_round 是否对小数进行四舍五入
     * @param bool $is_extra_zero 是否对整数部分以0结尾，小数存在的数字附加0,比如1960.30，
     *             有的系统要求输出"壹仟玖佰陆拾元零叁角"，实际上"壹仟玖佰陆拾元叁角"也是对的
     * @return string
     */
    function mynumber($number=0, $int_unit = '元', $is_round = TRUE, $is_extra_zero = FALSE)
    {
        // 将数字切分成两段
        $parts = explode('.', $number, 2);
        $int = isset($parts[0]) ? strval($parts[0]) : '0';
        $dec = isset($parts[1]) ? strval($parts[1]) : '';

        // 如果小数点后多于2位，不四舍五入就直接截，否则就处理
        $dec_len = strlen($dec);
        if (isset($parts[1]) && $dec_len > 2)
        {
            $dec = $is_round
                ? substr(strrchr(strval(round(floatval("0.".$dec), 2)), '.'), 1)
                : substr($parts[1], 0, 2);
        }

        // 当number为0.001时，小数点后的金额为0元
        if(empty($int) && empty($dec))
        {
            return '零';
        }

        // 定义
        $chs = array('0','壹','贰','叁','肆','伍','陆','柒','捌','玖');
        $uni = array('','拾','佰','仟');
        $dec_uni = array('角', '分');
        $exp = array('', '万');
        $res = '';

        // 整数部分从右向左找
        for($i = strlen($int) - 1, $k = 0; $i >= 0; $k++)
        {
            $str = '';
            // 按照中文读写习惯，每4个字为一段进行转化，i一直在减
            for($j = 0; $j < 4 && $i >= 0; $j++, $i--)
            {
                $u = $int{$i} > 0 ? $uni[$j] : ''; // 非0的数字后面添加单位
                $str = $chs[$int{$i}] . $u . $str;
            }
            //echo $str."|".($k - 2)."<br>";
            $str = rtrim($str, '0');// 去掉末尾的0
            $str = preg_replace("/0+/", "零", $str); // 替换多个连续的0
            if(!isset($exp[$k]))
            {
                $exp[$k] = $exp[$k - 2] . '亿'; // 构建单位
            }
            $u2 = $str != '' ? $exp[$k] : '';
            $res = $str . $u2 . $res;
        }

        // 如果小数部分处理完之后是00，需要处理下
        $dec = rtrim($dec, '0');

        // 小数部分从左向右找
        if(!empty($dec))
        {
            $res .= $int_unit;

            // 是否要在整数部分以0结尾的数字后附加0，有的系统有这要求
            if ($is_extra_zero)
            {
                if (substr($int, -1) === '0')
                {
                    $res.= '零';
                }
            }

            for($i = 0, $cnt = strlen($dec); $i < $cnt; $i++)
            {
                $u = $dec{$i} > 0 ? $dec_uni[$i] : ''; // 非0的数字后面添加单位
                $res .= $chs[$dec{$i}] .$u;
            }

            $res = rtrim($res, '0');// 去掉末尾的0
            $res = preg_replace("/0+/", "零", $res); // 替换多个连续的0
        }
        else
        {
            $res .= $int_unit . '整';
        }
        return $res;
    }


}