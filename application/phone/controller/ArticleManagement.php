<?php
namespace app\phone\controller;
use think\Controller;
use think\Request;

class ArticleManagement extends Controller
{

    public function lst()
    {
        //考勤查询
        $article_category = input('article_category');
        if ($article_category) {
            $myfinance = db('app_article_management')
                ->order('article_id desc')
                ->where('article_category',$article_category)
                ->paginate(6);
            $mydata = $myfinance->toArray();
            $mydata['state'] = '200';
            if ($mydata['total'] == 0) {
                return json_encode(array('state' => '204', 'msg' => '还没有报表'));
            }
            $timedata = array();
            foreach ($mydata['data'] as $k => $v) {
                $v['article_time'] = date('Y-m-d H:i:s',$v['article_time']);
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
        $article_id=input('article_id');
        if(isset($article_id)){
            $myfinance = db('app_article_management')
                ->where('article_id', $article_id)
                ->find();
         $myfinance['article_time']=date('Y-m-d H:i:s',$myfinance['article_time']);
         $myfinance['state']='200';
           return json_encode($myfinance);
        }else{
            return json_encode(array('state' => '101', 'msg' => '参数错误'));
        }
    }
}