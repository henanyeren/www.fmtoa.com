<?php
namespace app\phone\controller;
use think\Controller;
use think\Request;

class FinancialStatements extends Controller
{

    public function lst()
    {
        $financial_category = input('financial_category');
        if ($financial_category) {
            $myfinance = db('app_financial_statements')
                ->order('financial_id desc')
                ->where('financial_category',$financial_category)
                ->paginate(6);
            $mydata = $myfinance->toArray();
            $mydata['state'] = '200';
            if ($mydata['total'] == 0) {
                return json_encode(array('state' => '204', 'msg' => '还没有报表'));
            }
            $timedata = array();
            foreach ($mydata['data'] as $k => $v) {
                $v['financial_time'] = date('Y-m-d H:i:s',$v['financial_time']);
                array_push($timedata, $v);
            }
            $mydata['data'] = $timedata;
            return json_encode($mydata);
        }else{
            return json_encode(array('state' => '101', 'msg' => '参数错误'));
        }
    }
}