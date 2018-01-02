<?php
namespace app\admin\validate;
use think\Validate;

class ArticleManagement extends Validate{
    protected $rule=[
        'article_name'=>'require|max:255',
        'article_url'=>'require|max:255',
        'article_category'=>'require|max:2',
    ];
    protected $message=[
        'article_category.require'=>'类别必须选',
        'article_category.max'=>'类别格式错误',
        'article_name.require'=>'文档名不能空',
        'article_url.require'=>'文档必须上传',
    ];
    protected $scene=[
        'article_name'=>'article_name',
        'article_url'=>'article_url',
        'article_category'=>'article_category',
        'add'=>['article_name','article_url','article_category']
    ];
}