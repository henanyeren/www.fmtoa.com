//添加账号  查出部门下人员名字
$(document).on('click','.drop-ul-admins li a',function () {
    $(".drop-val-admin").val($(this).attr('id'));
    $('.drop-val-admin_alias').val($(this).text());
    $('.drop-btn-admins').text($(this).text());
    $('.drop-val-admins').val($(this).attr('myid'));
})

$(document).on('click','.drop-ul-admin li a',function(){
    $(".drop-val-admin").val($(this).attr('id'));
    $('.drop-btn-admin').text($(this).text());
    var mykey='id';
    var myjson={};
    myjson[mykey]=$(this).attr('id');
    $.ajax({
        url:$('#mysuperid').attr('url'),
        data:myjson,
        type:'post',
        success:function (data) {
            if((data.status)==1){
                $('#myname').children().remove();
                $('#adminmyname').html(data.page);
            }
        }
    })
})
//无限极联动  jq（列表页面）
$(document).on('click','.drop-ul-depot li a',function(){

    //获取第几级联动
    var len=$(this).attr('pid');

    //拼接联动的class属性   并改变其值
    var val="drop-val-depot"+len;
    var btn="drop-btn-depot"+len;
    $("."+val).val($(this).attr('id'));
    $("."+btn).text($(this).text());

    //获取目标id编号
    var mykey=$(this).attr('name');
    var myjson={};
    myjson[mykey]=$(this).attr('id');
    var url=$(this).attr('url')
    //alert(url)
    $.ajax({
        url:url,
        data:myjson,
        type:'post',
        success:function (data) {
            //改变列表的值
            $('.my-tbody').empty();
            $('.my-tbody').html(data.page1)
            if((data.status)==1){
                var $elements = $('div.unlimited');
                var lens = $elements.length;

                //判断是选择的第几级联动，把多余的给移除掉
                if(data.lens<lens+1){
                for(var i=data.lens;i<lens+1;i++){
                    var removes="myremove"+i;
                    $("."+removes).remove();
                    }
                }
                $('#myunlimited').find('.unlimited').eq(len-1).after(data.page);
            }

        }
    })
})



//添加页面无限极联动
$(document).on('click','.drop-ul-depots li a',function(){
alert();
    //获取第几级联动
    var len=$(this).attr('pid');

    //拼接联动的class属性   并改变其值
    var val="drop-val-depot"+len;
    var btn="drop-btn-depot"+len;
    $("."+val).val($(this).attr('id'));
    $("."+btn).text($(this).text());

    //获取目标id编号
    var mykey=$(this).attr('name');
    var myjson={};
    myjson[mykey]=$(this).attr('id');
    var url=$(this).attr('url')
    //alert(url)
    $.ajax({
        url:url,
        data:myjson,
        type:'post',
        success:function (data) {
            if((data.status)=='-1'){
                $('.mymeteriel_type_super_id').val(data.val);
            }
            //改变列表的值
            if((data.status)==1){
                var $elements = $('div.unlimited');
                var lens = $elements.length;

                //判断是选择的第几级联动，把多余的给移除掉
                if(data.lens<lens+1){
                    for(var i=data.lens;i<lens+1;i++){
                        var removes="myremove"+i;
                        $("."+removes).remove();
                    }
                }
                $('#myunlimited').find('.unlimited').eq(len-1).after(data.page);
                $('.mymeteriel_type_super_id').val(data.val);
            }
        }
    })
})


//签到 查询js+ajax
$(document).on('click','#N-sign span.mysign',function () {
    var url=$(this).attr('myurl')
    var myjson={};
    myjson['time']=$("input[name='time']").val();
    myjson['times']=$("input[name='times']").val();
    myjson['name']=$("input[name='name']").val();
    $.ajax({
        url:url,
        data:myjson,
        type:'post',
        success:function (data) {
            if(data.status==1) {
                $('div#mysign').empty();
                $('div#mysign').html(data.page);
            } else if(data.status==2){
                alert('未查到数据  :(日期分秒一定要写！');
            }else {
                alert('查询错误');
            }
        }
    })

})

//把小写钱数转换为大写钱数
$(document).on('blur','.money',function () {
    var money = {};
    var a = $(this).val();
    money['number'] = a;
    var url = $(this).attr('myurl')
    $.ajax({
        type: 'post',
        data: money,
        url: url,
        success: function (data) {
            if (data.state == 1) {
                $('.moneys').val(data.number);
            }
            if (data.state == 0) {
                alert('非法输入')
            }
        }
    })
} )


//app新闻单选按钮选项判断
$(document).on('click','.myradio',function () {
    var val=$(this).val();
    if(val){
        $('#myradio').val(val)
    }else {
        $('#myradio').val(0)
    }
})