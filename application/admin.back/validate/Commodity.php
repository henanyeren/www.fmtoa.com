<?php
namespace app\admin\validate;
use think\Validate;

class Commodity extends Validate{
    protected $rule=[
        'commodity_img'=>'require|max:255',
        'commodity_name'=>'require|max:255',
        'commodity_preview'=>'require|max:255',
        'address'=>'require|max:255',
    ];
    protected $message=[
        'commodity_img.require'=>'商品图不能为空',
        'commodity_name.require'=>'商品名不能为空',
        'commodity_preview.require'=>'商品缩略图不能为空',
        'commodity_img.max'=>'商品图片地址过长',
        'commodity_name.max'=>'商品名过长',
       'commodity_preview.max'=>'商品缩略图过长',
        'address.max'=>'商品缩略图过长',
        'address.require'=>'商品缩略图不能为空',
    ];
    protected $scene=[
        'commodity_img'=>'commodity_img',
        'commodity_name'=>'commodity_name',
        'commodity_preview'=>'commodity_preview',
        'address'=>'address',
        'add1'=>['commodity_img','commodity_name','commodity_preview']
    ];
}