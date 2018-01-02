<?php
namespace app\phone\controller;
use think\Controller;
use think\Request;

class Sales extends Controller
{

    public function lst()
    {
        //财务报表查询
        $sales_category = input('sales_category');
        if ($sales_category) {
            $myfinance = db('app_sales')
                ->order('sales_id desc')
                ->where('sales_category',$sales_category)
                ->paginate(6);
            $mydata = $myfinance->toArray();
            $mydata['state'] = '200';
            if ($mydata['total'] == 0) {
                return json_encode(array('state' => '204', 'msg' => '还没有报表'));
            }
            $timedata = array();
            foreach ($mydata['data'] as $k => $v) {
                $v['sales_time'] = date('Y-m-d H:i:s',$v['sales_time']);
                array_push($timedata, $v);
            }
            $mydata['data'] = $timedata;
            return json_encode($mydata);
        }else{
            return json_encode(array('state' => '101', 'msg' => '参数错误'));
        }
    }
    public function one(){
        //查出详细信息
        $sales_id=input('sales_id');
        if(isset($sales_id)){
            $myfinance = db('app_sales')
                ->where('sales_id', $sales_id)
                ->find();
            $myfinance['sales_time']=date('Y-m-d H:i:s',$myfinance['sales_time']);
            $myfinance['state']='200';
            return json_encode($myfinance);
        }else{
            return json_encode(array('state' => '101', 'msg' => '参数错误'));
        }
    }
}