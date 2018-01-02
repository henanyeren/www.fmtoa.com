<?php
namespace app\admin\validate;
use think\Validate;

class Video extends Validate{
    protected $rule=[
        'video_url'=>'require|max:255',
        'video_name'=>'require|max:255',
        'video_preview'=>'require|max:255',
        'video_title'=>'require|max:255',
    ];
    protected $message=[
        'video_url.require'=>'视频地址不能空',
        'video_name.require'=>'视频名字不能为空',
        'video_preview.require'=>'图片地址不能空',
        'video_title.require'=>'描述不能为空',
        'video_title.max'=>'描述不能超过80字',
        'video_preview.max'=>'地址过长',
       'video_name.max'=>'名字过长',
        'video_url.max'=>'视频地址过长',
    ];
    protected $scene=[
        'video_url'=>'video_url',
        'video_name'=>'video_name',
        'video_preview'=>'video_preview',
        'video_title'=>'video_title',
        'add'=>['video_url','video_name','video_preview','video_title']
    ];
}