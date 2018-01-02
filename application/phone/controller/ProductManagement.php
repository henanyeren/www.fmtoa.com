<?php
namespace app\phone\controller;
use think\Controller;
use think\Request;

class ProductManagement extends Controller
{

    public function lst()
    {
        //合同查询
        $product_category = input('product_category');
        if ($product_category) {
            $myfinance = db('app_product_management')
                ->order('product_id desc')
                ->where('product_category',$product_category)
                ->paginate(6);
            $mydata = $myfinance->toArray();
            $mydata['state'] = '200';
            if ($mydata['total'] == 0) {
                return json_encode(array('state' => '204', 'msg' => '还没有报表'));
            }
            $timedata = array();
            foreach ($mydata['data'] as $k => $v) {
                $v['product_time'] = date('Y-m-d H:i:s',$v['product_time']);
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
        $product_id=input('product_id');
        if(isset($product_id)){
            $myfinance = db('app_product_management')
                ->where('product_id', $product_id)
                ->find();
         $myfinance['product_time']=date('Y-m-d H:i:s',$myfinance['product_time']);
         $myfinance['state']='200';
           return json_encode($myfinance);
        }else{
            return json_encode(array('state' => '101', 'msg' => '参数错误'));
        }
    }
}