var submit=new Array();

$(document).on('click','.btn-submit',function(){
		if(submit.length==0){
			alert('请先填写内容');
		}
		
		if($.inArray(0,submit)>-1){
			console.log(submit);
			alert('请检查填写内容');
		}else{
		var mydata2={};
		//添加新属性
		var inputs=$('.my-row input.up');
		$.each(inputs, function(index,input) {
			var mypro=$(input).attr('name');
			var val=$(input).val();
			mydata2[mypro]=val;
		});
		$.ajax({
			type:"post",
			url:$('.my-row').attr('action'),
			data:mydata2,
			success:function(data){
				if(data.state==1){
					$('#content').fadeOut();
					getPage($('.my-row').attr('jumpUrl'));
				}else{
					alert(data.msg);
				}
			}
		});
		}
})
	
//免校验
$(document).on('click','.btn-submit-no-check',function(){
	startLoading();
		$(this).attr('disabled',true);
		var this_obj=$(this);
		var mydata2={};
		//添加新属性
		var inputs=$('.my-row-no-check input.up');
		$.each(inputs, function(index,input) {
			var mypro=$(input).attr('name');
			var val=$(input).val();
			mydata2[mypro]=val;
		});
		$.ajax({
			type:"post",
			url:$('.my-row-no-check').attr('action'),
			data:mydata2,
			success:function(data){
				if(data.state==1){
					$('#content').fadeOut();
					this_obj.attr('disabled',false);
					endLoading();
					getPage(this_obj.attr('jumpUrl'));
				}else{
					endLoading();
					alert(data.msg);
					$('.form-group input.form-control').val('');					
					this_obj.attr('disabled',false);
				}
			}
		});
});

//异步修改验证

$(document).on('click','.btn-upd-submit',function(){
	var mydata2={};
	
	//添加新属性
	var inputs=$('.my-edit input');
	$.each(inputs, function(index,input) {
		var mypro=$(input).attr('name');
		var val=$(input).val();
		mydata2[mypro]=val;
	});
	
	$.ajax({
		type:"post",
		url:$('.my-edit').attr('action'),
		data:mydata2,
		success:function(data){
			
			if(data.state==1){
				$('#content').fadeOut();
				getPage($('.my-edit').attr('jumpUrl'));
				
			}else{
				alert(data.msg);
			}
		}
		
	});
})



	
	//初始化绑定指定的事件
function bindEvent(){
	var inputs=$('.my-row input');

	$.each(inputs, function(index,input) {
		$(input).blur(function(){
			submit[index]=0;
			//获取对应的键值
			var mykey=$(input).attr('name');
			var myjson={};
			 myjson[mykey]=$(input).val();
			$.ajax({
				type:"post",
				data:myjson,
				url:$('.my-row').attr('check'),
				success:function(data){
					if(data.state==1){
						
						$(input).next().children().remove();
						$(input).next().html('<i class="glyphicon glyphicon-ok text-success"></i>');
						submit[index]=1;
						
					}else{
						$(input).next().children().remove();
						$(input).next().html('<i class="glyphicon glyphicon-remove text-danger"></i>');
					}
				}
			});
			
		})
	});		
}

var module_parameter='';
//异步获取页面
$(document).on('click','.ajax-get-page',function(){
			//隐藏ue
	startLoading();
	UE.getEditor('public-remark').setContent('');
	$('#public-remark').slideUp(500);
	getPage($(this).attr('url'),$(this).attr('id'));
	module_parameter=$(this).attr('module_parameter');
});

//获取页面
function getPage(url,id){
	startLoading();
	var data={};
	data['id']=id;
	$('#content').empty();
	$.getJSON(url,data,function(result){
		$('#content').html(result['page']);
		endLoading();
	});
	$('#content').fadeIn();
	
}

//异步获取2级页面
$(document).on('click','.ajax-get-sub-page',function(){
	startLoading();
	//隐藏ue
	UE.getEditor('public-remark').setContent('');
$('#public-remark').slideUp(500);
	var id=$(this).attr('id');
	var url=$(this).attr('url');
	var data={};
	data['module_parameter']=module_parameter;
	data['id']=id;
	$('#content-sub').empty();
	$.getJSON(url,data,function(result){
		$('#content-sub').html(result['page']);
		endLoading();
	});
	$('#content-sub').fadeIn();
});

//异步获取3级页面
$(document).on('click','.ajax-get-third-page',function(){
	UE.getEditor('public-remark').setContent('');
	$('#public-remark').slideUp(500);
	var id=$(this).attr('id');
	var url=$(this).attr('url');
	var data={};
	data['id']=id;
	$('#content-third').empty();
	$.getJSON(url,data,function(result){
		$('#content-third').html(result['page']);
	});
	$('#content-third').fadeIn();
});


//异步获取3级页面
$(document).on('click','.add-main-remark',function(){
	$('#public-remark').slideDown(500);
});


////无刷新分页
//$(document).on('click','table .pagination a',function(){
//	var url=$(this).attr('href');
//		$('#content').children().remove();
//	$.ajax({
//		type:"get",
//		url:url,
//		success:function(data){
//			$('#content').html(data.page);
//		}
//		
//	});
//	return false;
//});

//无刷新分页
$(document).on('click','#content .pagination a',function(){
	var url=$(this).attr('href');
		$('#content').children().remove();
	$.ajax({
		type:"get",
		url:url,
		success:function(data){
			$('#content').html(data.page);
		}
		
	});
	return false;
});

//模态框无刷新分页
$(document).on('click','#publicModal .pagination a',function(){
	$('#publicModal').slideUp();
	startLoading();
	var url=$(this).attr('href');
	$.ajax({
		type:"get",
		url:url,
		success:function(data){
			$('#publicModalDetail').html(data.page);
			endLoading();
			$('#publicModal').slideDown();
		}
		
	});
	return false;
});



//二级无刷新分页
$(document).on('click','#content-sub .pagination a',function(){
	var url=$(this).attr('href');
	$.ajax({
		type:"get",
		url:url,
		success:function(data){
			if(data.state==1){
				$('#content-sub').html(data.page);
			}
		}
	});
	return false;
});
//异步获取二级页面
$(document).on('click','.ajax-get-page-sub',function(){
		//隐藏ue
	UE.getEditor('public-remark').setContent('');
	$('#public-remark').slideUp(500);
    getPageSub($(this).attr('url'),$(this).attr(('id')));
});

//获取页面
function getPageSub(url,id){
    var data={};
    data['id']=id;
    $('#content-sub').empty();
    $.getJSON(url,data,function(result){
        $('#content-sub').html(result['page']);
    });
    $('#content-sub').fadeIn();
}


//ajax删除
$(document).on('click','.ajax-del',function(){
	startLoading();
	var url =$(this).attr('url');
	var data={};
	var get_id=$(this).attr('id');
	var jumpUrl=$(this).attr('jumpUrl');
	//用处处理移除已删除的标签，便于找到id
	var type_id=$(this).attr('type_id');
	var get_name=$(this).attr('name');
	data[get_name]=get_id;
	$.ajax({
		type:"post",
		url:url,
		data:data,
		success:function(data){
			if(data.state==1){
				$('#myModal'+type_id).modal('hide');
				$('.modal-backdrop').remove();
				$("#tr"+type_id).remove();
				alert(data.msg);
				endLoading();
				if(jumpUrl){
					getPage(jumpUrl);
				}
			}else{
				alert(data.msg);
				endLoading();
			}
			
		}
		
	});
	return false;
})



//下拉获取值
$(document).on('click','.drop-ul li a',function(){
	$(".drop-val").val($(this).attr('id'));
	$('.drop-btn').text($(this).text());
	
})

//多级下拉
$(document).on('click','.drop-ul-three li a',function(){
	$(".drop-val").val($(this).attr('id'));
	//console.log($(this).parent().parent().siblings('.drop-btn').text());
	$(this).parent().parent().siblings().text($(this).text());
	
})



//带checkbox的异步提交
	$(document).on('click','.btn-check-submit',function(){
	
var gr_rules = $("input[name='rules']:checked");
var gr_str='';
		$.each(gr_rules, function(index,checx) {
			gr_str+=($(checx).val()+',');
		});
		gr_str=gr_str.substring(0,gr_str.length-1);
		var data2={};
		
		data2['rules']=gr_str;
		data2['title']=$("[name=title]").val();
		data2['id']=$("[name=id]").val();
			console.log(data2);	
				$.ajax({
					type:"post",
					url:$('.my-row').attr('action'),
					data:data2,
					success:function(data){
						
						if(data.state==1){
							$('#content').fadeOut();
							getPage($('.my-row').attr('jumpUrl'));
							
						}else{
							alert(data.msg);
						}
					}
					
				});
	})
	
//带checkbox提交
	$(document).on('click','.btn-check2-submit',function(){
	var data2={};
	var gr_rules = $("input[type='checkbox']:checked");
	var inputs=$(".up-input");
		
	$.each(inputs, function(index,input) {
		var myval=$(input).val();
		var mykey=$(input).attr('name');
		
		data2[mykey]=myval;
		
	});

	var gr_str='';
	var check_name='';
		$.each(gr_rules, function(index,checx) {
			gr_str+=($(checx).val()+',');
			check_name=$(checx).attr('name');
		});
		gr_str=gr_str.substring(0,gr_str.length-1);
		
		data2[check_name]=gr_str;
			console.log(data2);	
				$.ajax({
					type:"post",
					url:$('.my-row').attr('action'),
					data:data2,
					success:function(data){
						if(data.state==1){
							$('#content').fadeOut();
							getPage($('.my-row').attr('jumpUrl'));
							
						}else{
							alert(data.msg);
						}
					}
				});
	})
	
//带radio选择的提交按钮事件
$(document).on('click','.btn-check-radio-submit',function(){
	var data2={};
	var gr_rules = $("input[type='radio']:checked");
	var inputs=$(".up-input");
		
	$.each(inputs, function(index,input) {
		var myval=$(input).val();
		var mykey=$(input).attr('name');
		
		data2[mykey]=myval;
		
	});

	var gr_str='';
	var check_name='';
		$.each(gr_rules, function(index,checx) {
			gr_str+=($(checx).val()+',');
			check_name=$(checx).attr('name');
		});
		gr_str=gr_str.substring(0,gr_str.length-1);
		
		data2[check_name]=gr_str;
			console.log(data2);	
				$.ajax({
					type:"post",
					url:$('.my-row').attr('action'),
					data:data2,
					success:function(data){
						if(data.state==1){
							$('#content').fadeOut();
							getPage($('.my-row').attr('jumpUrl'));
							
						}else{
							alert(data.msg);
						}
					}
				});
	})	

//异步获取详情
$(document).on('click','.get-detail',function(){
	startLoading();
	var url=$(this).attr('url');
	var mydata={};
	$('#showD').modal('show');
	mydata['id']=$(this).attr("myId");
	$.ajax({
		type:"post",
		url:url,
		data:{
			id:$(this).attr("myId"),
		},
		success:function(data){
			$('#publicModalDetail').html(data.msg);
			$('#myModalTitle').text(data.name);
			$("#publicModal").modal('show');
			endLoading();
		}
	});
})

$(document).on('click','.my-panel-group ul li.ajax-get-page',function(){
	$(this).addClass('myhover text-primary').siblings().removeClass('myhover text-primary');

})

//radio选择

$(document).on('click','.my-radio',function(){
	$('.my-radio-val').val(($("input[name='sex']:checked").val()));
})


//异步加载三级联动
$(document).on('click','ul.drop-ul-three li a',function(){
	
	var drops=$(".slider-content div.form-group");
	var currentDrop=$(this).parent().parent().parent().parent().parent().attr('drop');
	$.each(drops, function(index,input) {
		if($(input).attr('drop')>currentDrop){
			$(input).remove();	
		}
	});
	
	var pid=$(this).attr('id');
	var url=$(this).parent().parent().attr('url');
	var mykey=$(this).parent().parent().siblings('input').attr('name');
	var mydata={};
	
	mydata[mykey]=pid;
	$.ajax({
		url:url,
		data:mydata,
		success:function(data){
			if((data.type)=='list'){
				$('tbody').children().remove();
				$('tbody').html(data.page);
			}
			if(data.super_id){
				$('.staff_job_id').val(data.super_id);
			}
			
			if(data.status==1){
				$('.slider-content').append(data.page);
			}
			
		}
	});
	
})


//toolbar异步值

$(document).on('click','.my-toolbar .btn-group button',function(){
	$(this).parent().parent().siblings('.toolbar-val').val($(this).attr('type_id'));
	$(this).siblings().removeClass('my-click');
	$(this).addClass('my-click');
})


//采购申请代码

//异步获取二级页面
$(document).on('click','.ajax-getinfo-sub-page',function(){
	var url=$(this).attr('url');
	var upObj={};
	upObj['target_table']=$(this).attr('target_table');
	upObj['target_sub_table']=$(this).attr('target_sub_table');
	upObj['flow_id']=$(this).attr('flow_id');
	
	$.getJSON(url,upObj,function(result){
		$('#content-sub').children().remove();
		$('#content-sub').html(result['page']);
	});
	$('#content-sub').fadeIn();
});



var outIndex=2;

var mydataArr=[];
var mydataArrSub=[];
var mydataObj={};	

//添加物料列
$(document).on('click','.chasing-add',function(){
	var mycurrentdate=getCurrentTime();
	
	var	html='<tr>'+
		    '<td>'+outIndex+'</td>'+ 
			'<td><button class="chasing-del btn btn-danger">删除</button></td>'+
		 	'<td><input name="purchasing_name" sub="'+outIndex+'" type="text" class="up sub" /></td>'+    
			'	<td><input name="purchasing_specifications" sub="'+outIndex+'" class="up sub" type="text" /></td>'+   
			'	<td><input name="purchasing_number"  sub="'+outIndex+'" class="up sub" type="number" /></td>'+
			'	<td><input name="purchasing_unit" sub="'+outIndex+'" class="up sub" type="text" /></td>'+   
			'	<td><input name="purchasing_date_require" sub="'+outIndex+'" class="up sub my-sub-time" value="'+mycurrentdate+'"  type="datetime-local"  /></td>'+
			'	<td><input name="purchasing_remark" sub="'+outIndex+'" class="up sub"  type="text" /></td>'+
			'	<td><button class="btn btn-primary add-materuel" sub="'+outIndex+'">提交</button></td>'+
		    '</tr>';
	   outIndex++;
	   $('#myContent').append(html);
	   html='';
});

//添加入库物料列
$(document).on('click','.materiel-in-add',function(){
	var mycurrentdate=getCurrentTime();

	   
	var html='<tr>'+ 
	    '<td>'+outIndex+'</td> '+ 
		'<td><button class="chasing-del btn btn-danger">删除</button></td>'+ 
		'<input type="hidden" name="materiel_pid"  sub="'+outIndex+'" class="up sub materiel_id'+outIndex+'" materiel_id="'+outIndex+'" value="" />'+ 
		'<td>'+ 
			'<div class="dropdown">'+ 
			  '<button class="btn btn-default my-dropdown drop-num'+outIndex+'" is_in="1" type="button" materiel_page_id="'+outIndex+'">'+ 
			   ' 	选择'+ 
			  '  <span class="caret"></span>'+ 
			 ' </button>'+ 
			'</div>'+ 
		'</td>'+ 
	 	'<td><input name="materiel_batch_number" sub="'+outIndex+'" type="text" placeholder="输入生产编号" class="up sub materiel_batch_number'+outIndex+'" /></td>'+ 
	 	'<td><input name="materiel_no" sub="'+outIndex+'" placeholder="输入编号"  class="up sub materiel_no'+outIndex+'" type="text" /></td>'+ 
		'<td><input name="materiel_number" placeholder="0.00"  sub="'+outIndex+'" class="up sub materiel_number'+outIndex+'" type="number" /></td>'+ 
		'<td><input name="materiel_univalent" placeholder="0.00"  sub="'+outIndex+'" class="up sub materiel_univalent'+outIndex+'"  type="number" /></td>'+ 
		'<td><input name="material_total_money" placeholder="0.00"  sub="'+outIndex+'" class="up sub material_total_money'+outIndex+'"   type="number" /></td>'+ 
		'<td><input name="materiel_remark" sub="'+outIndex+'" class="up sub " placeholder="填写备注"  type="text" /></td>'+ 
		'<td><button class="btn btn-primary add-materuel" sub="'+outIndex+'">提交</button></td>'+ 
	   '</tr>';
	   outIndex++;
	   $('#myContent').append(html);
	   html='';
});



//添出库物料列
$(document).on('click','.materiel-add',function(){
	var mycurrentdate=getCurrentTime();

	   
	var html='<tr>'+ 
	    '<td>'+outIndex+'</td> '+ 
		'<td><button class="chasing-del btn btn-danger">删除</button></td>'+ 
		'<input type="hidden" name="materiel_pid"  sub="'+outIndex+'" class="up sub materiel_id'+outIndex+'" materiel_id="'+outIndex+'" value="" />'+ 
		'<td>'+ 
			'<div class="dropdown">'+ 
			  '<button class="btn btn-default my-dropdown drop-num'+outIndex+'" type="button" materiel_page_id="'+outIndex+'">'+ 
			   ' 	选择'+ 
			  '  <span class="caret"></span>'+ 
			 ' </button>'+ 
			'</div>'+ 
		'</td>'+ 
	 	'<td><input name="materiel_batch_number" sub="'+outIndex+'" type="text" placeholder="输入生产编号" class="up sub materiel_batch_number'+outIndex+'" /></td>'+ 
	 	'<td><input name="materiel_no" sub="'+outIndex+'"  placeholder="输入编号"  class="up sub materiel_no'+outIndex+'" type="text" /></td>'+ 
		'<td><input name="materiel_number" placeholder="0.00"  sub="'+outIndex+'" class="up sub materiel_number'+outIndex+'" type="number" /></td>'+ 
		'<td><input name="materiel_univalent" placeholder="0.00"  sub="'+outIndex+'" class="up sub materiel_univalent'+outIndex+'"  type="number" /></td>'+ 
		'<td><input name="material_total_money" placeholder="0.00"  sub="'+outIndex+'" class="up sub material_total_money'+outIndex+'"   type="number" /></td>'+ 
		'<td><input name="materiel_remark" sub="'+outIndex+'" class="up sub " placeholder="填写备注"  type="text" /></td>'+ 
		'<td><button class="btn btn-primary add-materuel" sub="'+outIndex+'">提交</button></td>'+ 
	   '</tr>';
	   outIndex++;
	   $('#myContent').append(html);
	   html='';
});


$(document).on('keyup','input[name=materiel_univalent],input[name=materiel_number]',function(){
	var rowNum=$(this).attr('sub');
	var re=accMul($('.materiel_univalent'+rowNum).val(),$('.materiel_number'+rowNum).val());
	$('.material_total_money'+rowNum).val(re);
});
//提交仓库行信息
$(document).on('click','.add-materuel',function(){
	
	var sub=$(this).attr('sub');
	var mythis=$(this);
	var subObj={};
	var inputs=$('input[sub='+sub+']');
	$.each(inputs, function(index,input) {
		subObj[$(input).attr('name')]=$(input).val();
	});
	if(!subObj['materiel_number']){
		alert('请填入物料数量');
		return false;
	}
	
	startLoading();
	$.ajax({
		type:"post",
		url:$('#myContent').attr('url'),
		data:subObj,
		success:function(data){
			if(data.status==1){
				$(mythis).text('已提交');
				$(mythis).attr('disabled',true);
				bIds=bIds+','+data.bId;
				console.log(bIds);
				$(mythis).parent().parent().find('input,button').attr('disabled',true);
				endLoading();
			}else{
				endLoading();
				alert(data.msg);
				
			}
		}
	});
	
	//把出库的pid 重置
	materiel_out_pid=0;	
	
});

//检查同物品批号相等，则合并
$(document).on('blur','input[name=materiel_no]',function(){
		var cur_sub=$(this).attr('sub');
		var materiel_no=$(this).val();
		var cur_materiel_id=$('.materiel_id'+cur_sub).val();
		
		var upObj={};
		upObj['materiel_no']=materiel_no;
		upObj['materiel_id']=cur_materiel_id;
		
		if(cur_materiel_id&&materiel_no){
			$.ajax({
				type:"post",
				url:$('#content-third').attr('checkBatch'),
				data:upObj,
				success:function(data){
					if(data){
						alert(data);	
					}
					
				}
			});
		}
})

//无限极联动信息控件插件
$(document).on('click','.Xdrop .dropdown-menu .Xli a',function(){
	$('#publicModal').slideUp();
	startLoading();
	var url=$(this).attr('url');
	var type_id=$(this).attr('type_id');
	var upObj={};
	upObj['type_id']=type_id;
	var mythis=$(this);
	//alert(type_id);
	$.ajax({
		type:"post",
		url:url,
		data:upObj,
		success:function(data){
			
			if(data.state==1){
				$(mythis).parent().parent().parent().nextAll().remove();
				$(mythis).parent().parent().parent().after(data.page);
				$(mythis).parent().parent().parent().children('.drop-btn-depot').eq(0).html($(mythis).html());
				endLoading();
				$('#publicModal').slideDown();
			}else if(data.state==2){
				//$(mythis).parent().parent().after(data.page);
				$('#materiel_data').remove();
				var len=$('.Xdrop').length;
				$(mythis).parent().parent().parent().children('.drop-btn-depot').eq(0).html($(mythis).html());
				$('.Xdrop').eq(len-1).after(data.page_data);
				endLoading();
				$('#publicModal').slideDown();
			}
			else{
				alert('找不到子类');
				endLoading();
				$('#publicModal').slideDown();
			}
		}
	});
	
});

//无限极联动  '类型' 信息控件插件
$(document).on('click','.Xdrop .dropdown-menu .XPtype-list a',function(){
	startLoading();
	var url=$(this).attr('url');
	var type_id=$(this).attr('type_id');
	var upObj={};
	upObj['type_id']=type_id;
	var mythis=$(this);
	//alert(type_id);
	$.ajax({
		type:"post",
		url:url,
		data:upObj,
		success:function(data){
			
			if(data.state==1){
				$(mythis).parent().parent().parent().nextAll().remove();
				$(mythis).parent().parent().parent().after(data.page);
				$(mythis).parent().parent().parent().children('.drop-btn-depot').eq(0).html($(mythis).html());
				endLoading();
			}else{
				$('.drop-val-depot').val($(mythis).attr('type_id'));
				$(mythis).parent().parent().parent().children('.drop-btn-depot').eq(0).html($(mythis).html());
				$(mythis).parent().parent().parent().nextAll().remove();
				endLoading();
			}
		}
	});
	
});

//无限极联动信息和数据控件
$(document).on('click','.Xdrop-list-data .dropdown-menu .XPtype-list a',function(){
	startLoading();
	var url=$(this).attr('url');
	var type_id=$(this).attr('type_id');
	var upObj={};
	upObj['type_id']=type_id;
	var mythis=$(this);
	//alert(type_id);
	$.ajax({
		type:"post",
		url:url,
		data:upObj,
		success:function(data){
			if(data.state==1){
				$(mythis).parent().parent().parent().nextAll().remove();
				$(mythis).parent().parent().parent().after(data.page);
				$(mythis).parent().parent().parent().children('.drop-btn-depot').eq(0).html($(mythis).html());
				endLoading();
			}else if(data.state==2){
				$('#materiel_data').remove();
				var len=$('.Xdrop-list-data').length;
				$(mythis).parent().parent().parent().children('.drop-btn-depot').eq(0).html($(mythis).html());
				$('.Xdrop-list-data').eq(len-1).after(data.page_data);
				endLoading();
			}
			else{
				endLoading();
				alert('找不到子类');
			}
		}
	});
	
});


var bIds='';

//提交申请表
$(document).on('click','#submit-all',function(){
	
	if(!confirm('确认提交吗？这将不可修改！')){
		return false;
	}
	
	if(!bIds){
		alert('请添加数据');
		return false;
	}
	
//alert($('#my-form1').attr('url'));
	var inputs=$('.main-up');
	var mythis=$(this);
	var url=$(this).attr('url');
	console.log(inputs);
	var myObj={};
	$.each(inputs,function(index,input){
		var mypro=$(input).attr('name');
		var val=$(input).val();
		myObj[mypro]=val;
	})
	myObj['requisition_sub_ids']=bIds;
	startLoading();
	$.ajax({
		type:"post",
		url:url,
		data:myObj,
		success:function(data){
			if(data.state==1){
				endLoading();
				$(mythis).remove();
				alert('提交成功！');
				bIds='';
			}else if(data.state==2){
				endLoading();
				$(mythis).remove();
				$('#publicModalDetail').html(data.page);
				$("#publicModal").modal('show');
				
			}
		}
	});
})


//获取无限级联动，部门下指定 的员工
var department_type_id=0;
$(document).on('click','.staff',function(){
	var url=$(this).attr('url');
	department_type_id=$(this).attr('department_type_id');
	var super_id=$(this).attr('super_id');
	var  upObj={};
	upObj['super_id']=super_id;
	
	$.ajax({
		type:"post",
		url:url,
		data:upObj,
		success:function(data){
			if(data.state==1){
				$('#publicModalDetail').html(data.page);
				$("#publicModal").modal('show');
			}else{
				//alert(data.msg);
			}
		}
	})
});

//把指定的员工id放到隐藏域
$(document).on('click','.my-staff-item',function(){
		$('.demander_name'+department_type_id).val($(this).html());
		
		$('input[name=materiel_purchasing_agent]').val($(this).attr('staff_id'));
		$("#publicModal").modal('hide');
})

//获取事务详情
$(document).on('click','.get-routine-detail',function(){
	startLoading();
	$("#publicModal").modal('hide');
	var url=$(this).attr('url');
	var target_table=$(this).attr('target_table');
	var target_id=$(this).attr('target_id');
	
	$('.approval-result').attr('toTable',$(this).attr('target_table'));
	$('.approval-result').attr('data-id',$(this).attr('target_id'));
	//上传对象
	var upObj={};
	upObj['target_table']=target_table;
	upObj['target_id']=target_id;
	
	$.ajax({
		type:"post",
		url:url,
		data:upObj,
		success:function(data){
			$('#publicModalDetail').html(data.page);
			endLoading();
			$("#publicModal").modal('show');
		}
	});
})

//删除采购物料信息

$(document).on('click','.chasing-del',function(){
	$(this).parent().parent().remove();
})

//获取当前器时间
function getCurrentTime(){
	var date = new Date();
    var seperator1 = "-";
    var seperator2 = ":";
    
    var myhours=date.getHours();
    var myminu=date.getMinutes();
    var mysec=date.getSeconds();
    
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    if(month.toString().length==1){
    	month='0'+month;	
    }
    
    if(strDate.toString().length==1){
    	strDate='0'+strDate;	
    }  
    if(myhours.toString().length==1){
    	myhours='0'+myhours;	
    }  
    	
    if(myminu.toString().length==1){
    	myminu='0'+myminu;	
    }      
    if(mysec.toString().length==1){
    	mysec='0'+mysec;	
    }    
    
    
    var mycurrentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
            + "T" + myhours + seperator2 +myminu
            + seperator2 + mysec;
            
    return mycurrentdate;
}
var re_content;
//申请结果
$(document).on('click','.approval-result',function(){
	startLoading();
	$(this).attr('disabled',true);
	var thisObj=$(this);
	//获取审批结果
	var approvalValue=$(this).attr('approval-result');
	var upObj={};
	re_content=$('#re_content').val();
	//alert(re_content);
	$('#re_content').val('');
	
	//如果审批通过
	upObj['requisition_message']=re_content;
	//置空ue值
	
	var url=$(this).attr('url');
	var tableId=$(this).attr('data-id');
	
	//alert(upObj['requisition_refuse_id']);
	var toTable=$(this).attr('toTable');
	upObj['approval-result']=approvalValue;
	upObj['toTable']=toTable;
	upObj['tableId']=tableId;
	$.ajax({
		type:"post",
		url:url,
		data:upObj,
		success:function(data){
			if(data.state==1){
				re_content='';
				$('.approve-div').fadeOut('1900');
				$('#tr'+tableId).fadeOut('1900');
				alert('审批成功！');
				thisObj.attr('disabled',false);
				endLoading();
			}else{
				re_content='';
				$('.approve-div').fadeOut('1900');
				$('#tr'+tableId).fadeOut('1900');
				alert(data);
				thisObj.attr('disabled',false);
				endLoading();
			}
		}
	});
});

var public_materiel_page_id='';
var is_in;
//物料类型和子级获取控件
$(document).on('click','.my-dropdown',function(){
	$('#publicModalDetail').html('');
	var url=$('#myContent').attr('sub-from-url');
	var materiel_page_id=$(this).attr('materiel_page_id');
	//alert(is_in);
	is_in=$(this).attr('is_in');
	public_materiel_page_id= $(this).attr('materiel_page_id');
	//alert(public_materiel_page_id);
	

	var upObj={};
	upObj['materiel_page_id']=materiel_page_id;
	//alert(module_parameter);
	upObj['module_parameter']=module_parameter;
	
	$.ajax({
		type:"post",
		url:url,
		data:upObj,
		success:function(data){
			if(data.state==1){
				
				$('#publicModalDetail').html(data.page);
				$("#publicModal").modal('show');
			}
		}
		
	});
});

//仓库原料所属类型无限级物料
//var materiel_out_pid=0;
$(document).on('click','.my-materiel-item',function(){
	$('#publicModal').slideUp();
	var myClass='materiel_id'+public_materiel_page_id;
	
	//获取materiel_id
	var materiel_id=$(this).attr('materiel_id');
	materiel_out_pid=materiel_id;
	$('.'+myClass).val(materiel_id);
	$('.drop-num'+public_materiel_page_id).html($(this).html());
	//alert(is_in)
	//判断是否出库表
	if(!is_in){
		var upObj={};
		//上传物料id,查改该类型批次数据
		upObj['materiel_id']=materiel_id;
		$.ajax({
			type:"post",
			url:"/admin/depot_materiels/getDepotGoods",
			data:upObj,
			success:function(data){
				if(data.state==1){
					$('#publicModalDetail').html(data.page_data);
					$("#publicModal").modal('show');
					$('#publicModal').slideDown();
				}
			}
		});
	}
	
	$('.materiel_unit'+public_materiel_page_id).val($(this).attr('materiel_unit'));
	$('.materiel_no'+public_materiel_page_id).val($(this).attr('materiel_no'));
	$('.materiel_no'+public_materiel_page_id).after('<input name="materiel_out_pid" sub='+public_materiel_page_id+' class="up sub check materiel_out_pid'+public_materiel_page_id+'" value='+materiel_out_pid+' type="hidden">');
	
	$("#publicModal").modal('hide');
	$('#publicModal').slideUp();
	

});

//获取仓库物料批次信息

$(document).on('click','.getDepotGoods',function(){
	var myClass='materiel_id'+public_materiel_page_id;
	
	//获取materiel_id
	var materiel_id=$(this).attr('materiel_id');
	
	$('.'+myClass).val($(this).attr('materiel_id'));
	
	//获取批次信息填充到当前表
	$('.materiel_batch_number'+public_materiel_page_id).val($(this).children('.materiel_batch_number').html());
	$('.materiel_no'+public_materiel_page_id).val($(this).children('.materiel_no').html());
	
	$('.materiel_number'+public_materiel_page_id).attr('max',$(this).children('.materiel_number').html());
	 
	
	
	$("#publicModal").modal('hide');
});

//限制出库数量输入，最大数不能超过当前属性max
$(document).on('keyup','input[name="materiel_number"]',function(){
	if(parseInt($(this).attr('max'))<parseInt($(this).val())){
		$(this).addClass('bg-danger');
	}else{
		$(this).removeClass('bg-danger');
	}
})

$(document).on('click','.my-infinitus-item',function(){
		$('.demander_name'+department_type_id).val($(this).html());
		$('.demander_id'+department_type_id).val($(this).attr('admin_id'));
	$("#publicModal").modal('hide');
})


//math.js文件

/**
 ** 加法函数，用来得到精确的加法结果
 ** 说明：javascript的加法结果会有误差，在两个浮点数相加的时候会比较明显。这个函数返回较为精确的加法结果。
 ** 调用：accAdd(arg1,arg2)
 ** 返回值：arg1加上arg2的精确结果
 **/
function accAdd(arg1, arg2) {
    var r1, r2, m, c;
    try {
        r1 = arg1.toString().split(".")[1].length;
    }
    catch (e) {
        r1 = 0;
    }
    try {
        r2 = arg2.toString().split(".")[1].length;
    }
    catch (e) {
        r2 = 0;
    }
    c = Math.abs(r1 - r2);
    m = Math.pow(10, Math.max(r1, r2));
    if (c > 0) {
        var cm = Math.pow(10, c);
        if (r1 > r2) {
            arg1 = Number(arg1.toString().replace(".", ""));
            arg2 = Number(arg2.toString().replace(".", "")) * cm;
        } else {
            arg1 = Number(arg1.toString().replace(".", "")) * cm;
            arg2 = Number(arg2.toString().replace(".", ""));
        }
    } else {
        arg1 = Number(arg1.toString().replace(".", ""));
        arg2 = Number(arg2.toString().replace(".", ""));
    }
    return (arg1 + arg2) / m;
}

/**
 ** 减法函数，用来得到精确的减法结果
 ** 说明：javascript的减法结果会有误差，在两个浮点数相减的时候会比较明显。这个函数返回较为精确的减法结果。
 ** 调用：accSub(arg1,arg2)
 ** 返回值：arg1减去arg2的精确结果
 **/
function accSub(arg1, arg2) {
    var r1, r2, m, n;
    try {
        r1 = arg1.toString().split(".")[1].length;
    }
    catch (e) {
        r1 = 0;
    }
    try {
        r2 = arg2.toString().split(".")[1].length;
    }
    catch (e) {
        r2 = 0;
    }
    m = Math.pow(10, Math.max(r1, r2)); //last modify by deeka //动态控制精度长度
    n = (r1 >= r2) ? r1 : r2;
    return ((arg1 * m - arg2 * m) / m).toFixed(n);
}

/**
 ** 乘法函数，用来得到精确的乘法结果
 ** 说明：javascript的乘法结果会有误差，在两个浮点数相乘的时候会比较明显。这个函数返回较为精确的乘法结果。
 ** 调用：accMul(arg1,arg2)
 ** 返回值：arg1乘以 arg2的精确结果
 **/
function accMul(arg1, arg2) {
    var m = 0, s1 = arg1.toString(), s2 = arg2.toString();
    try {
        m += s1.split(".")[1].length;
    }
    catch (e) {
    }
    try {
        m += s2.split(".")[1].length;
    }
    catch (e) {
    }
    return Number(s1.replace(".", "")) * Number(s2.replace(".", "")) / Math.pow(10, m);
}

/** 
 ** 除法函数，用来得到精确的除法结果
 ** 说明：javascript的除法结果会有误差，在两个浮点数相除的时候会比较明显。这个函数返回较为精确的除法结果。
 ** 调用：accDiv(arg1,arg2)
 ** 返回值：arg1除以arg2的精确结果
 **/
function accDiv(arg1, arg2) {
    var t1 = 0, t2 = 0, r1, r2;
    try {
        t1 = arg1.toString().split(".")[1].length;
    }
    catch (e) {
    }
    try {
        t2 = arg2.toString().split(".")[1].length;
    }
    catch (e) {
    }
    with (Math) {
        r1 = Number(arg1.toString().replace(".", ""));
        r2 = Number(arg2.toString().replace(".", ""));
        return (r1 / r2) * pow(10, t2 - t1);
    }
}

//打印的js
//打印表格
function print_table()
{
  var newWin=window.open('about:blank', '', '');   
  var titleHTML=document.getElementById("publicModalDetail").innerHTML;   
  newWin.document.write(titleHTML);   
  newWin.document.location.reload();   
  newWin.print();
}

//仓库进出库异步校验字段
//function X_form_ajax_check(){
//		var inputs=$('.check');
//		console.log(inputs);
//	$.each(inputs, function(index,input) {
//		$(input).bind('input blur', function() {
//			submit[index]=0;
//			//获取对应的键值
//			var mykey=$(input).attr('name');
//			var myjson={[mykey]:$(input).val()};
//			$.ajax({
//				type:"post",
//				data:myjson,
//				url:$('.X-form-ajax-check').attr('check'),
//				success:function(data){
//					if(data.state==1){
//						
//						$(input).next().children().remove();
//						$(input).next().html('<i class="glyphicon glyphicon-ok text-success"></i>');
//						submit[index]=1;
//						
//					}else{
//						$(input).next().children().remove();
//						$(input).next().html('<i class="glyphicon glyphicon-remove text-danger"></i>');
//						
//					}
//				}
//			});
//			
//		})
//	});	
//}

$(document).on('click','.add-remark-model',function(){
	ue_detail.setContent('');
	$('.approve-div').fadeOut();
	$('.approve-div').fadeIn();
	
	$('.approve-div .approval-result').attr('toTable',$(this).attr('toTable'));
	$('.approve-div .approval-result').attr('data-id',$(this).attr('data-id'));
})

 //处理动画开始方法
 function startLoading(){
 	$('#load_mask').slideDown();
 	$('#colorfulPulse').slideDown();
 }

function endLoading(){
 	$('#load_mask').slideUp();
 	$('#colorfulPulse').slideUp();
}

//bill模块下仓库搜索
	
	$(document).on('click','#searBtn',function(){
		startLoading();
		var upObj={};
		var inputs=$('.up-form .up');
		console.log(inputs);
		$.each(inputs,function(index,input){
			var mypro=$(input).attr('name');
			var val=$(input).val();
			upObj[mypro]=val;			
		})
		
		
		var mythis=$(this);
		
			$.ajax({
				type:"post",
				url:$(mythis).attr('url'),
				data:upObj,
				success:function(data){
					if(data.state==1){
						$('#content-sub').html(data.page);
						endLoading();
					}else{
						alert('错误');
						endLoading();
					}
				}
			});
	});
	
//根据进出库记录显示表单详情
$(document).on('click','.show-table-info',function(){
	alert();
})
