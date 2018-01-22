function dialog_div(o_w,o_h,url){
	art.dialog.open(url,{title:"点击拖拽",width: o_w, height: o_h,lock:true});
}

function dialog_div2(o_w,o_h,url,page_name){
	var divname='ajax_dialog';
	$(document.body).append('<div id="'+divname+'" class="ajax_dialog"><div id="btl" class="btl"><span>点击拖拽</span><a href="javascript:void(0)" onclick="dialog_div_close(\''+divname+'\')"> 关闭 </a> </div><div id="nr" class="nr"></div></div><div id="'+divname+'divLock" class="divLock"><iframe style="position:absolute;width:100%;height:100%;_filter:alpha(opacity=0);opacity=0;border-style:none;"></iframe></div>');

	divname='#'+divname;
	var _move=false;//移动标记
	var _x,_y;//鼠标离控件左上角的相对位置
	var div_name=""+divname+" #btl";
	$(div_name).click(function(){
	}).mousedown(function(e){
		_move=true;
		$(div_name).css("cursor","move");
		_x=e.pageX-parseInt($(divname).css("left"));
		_y=e.pageY-parseInt($(divname).css("top"));
		});
		$(document).mousemove(function(e){
		if(_move){
			var x=e.pageX-_x;//移动时根据鼠标位置计算控件左上角的绝对位置
			var y=e.pageY-_y;
			$(divname).css({top:y,left:x});//控件新位置
		}
		}).mouseup(function(){
		_move=false;
	});

	$(divname).css("width",o_w);
	$(divname).css("height",o_h);
	$(".nr").css("height",o_h-35);
	if(page_name=='') page_name='index.php';
	$.ajax({
		type: "get",
		url: page_name,
		data: url,
		dataType:"html",
		beforeSend:function()
		{
		msg_show('数据加载中,请稍候!',999);
		},
		success: function(html){
			msg_close();
			$(""+divname+" .nr").html(html)
			$('.ajax_dialog input:text:first').focus();//焦点丢失获取焦点
		}
	});
	div_center(divname);
	$(""+divname+"divLock").height($("body").height());
}
function dialog_div_close(obj){
	var win=art.dialog.top;
	win.location.reload();
}
function div_display(div_name,status,obj){
	if($(div_name).css("display")=="block")
	{
	$(div_name).css("display","none");
	obj.find("img").attr("src","/bzy/img/add.gif");
	}
	else
	{
	$(div_name).css("display",status);
	obj.find("img").attr("src","/bzy/img/decrease.gif");
	}
}
function msg_show(n,t)
{
	//if(n==null) n='操作成功!';
	$(document.body).append('<div class="msg_show" id="msg_show"></div>');
	div_center('#msg_show');
	$('#msg_show').html(n);
	$('#msg_show').show();
	if(t!=999)
	{
		if(t==null) t=500;
		if(t!='')
		{
		setTimeout("$('#msg_show').hide();$('#msg_show').remove();",t); 
		}
		else
		{
		$('#msg_show').hide();
		$('#msg_show').remove();
		}
	}
}
function msg_close()
{
	$('#msg_show').remove();
}
function div_center(obj){
	var windowWidth = $(window).width();   
	var windowHeight = $(window).height();   
	var popupHeight = $(obj).height();
	var popupWidth = $(obj).width();
	$(obj).css({
		"top": (windowHeight-popupHeight)/2+$(document).scrollTop(),   
		"left": (windowWidth-popupWidth)/2   
	});  
}
function goto_url(url){
	if(url=='')url=location.href;
	location.href=url;
}
function ajax_list(path,go_url){
	$.ajax({
	type: "post",
	url: path,
	data: '',
	dataType:"html",
	success: function(html)
	{
		msg_show(html,5000000);
		goto_url(go_url)
	}
	});
}
function ajax_load(path){
	var htmls;
	$.ajax({
	type: "post",
	url: path,
	data: '',
	async:false,
	dataType:"html",
	success: function(html){
		htmls=html;
	}
	});
	return htmls;
}

$(document).ready(function(){
	win_size()
})
$(window).resize(function(){
	win_size()
})
function win_size(){
	var win_h = $(window).height();
	$("#left").height(win_h-126);
	var left_h = $(window).height();
	$("#right").height(win_h-146);
}

function delete_img(url,obj){
	var html=ajax_load(url);
	msg_show(html,1000);
	obj.prev().remove();
	obj.remove();
}

function SelectAll(name) { var checkboxs=document.getElementsByName(name); for (var i=0;i<checkboxs.length;i++) {  var e=checkboxs[i];  e.checked=!e.checked; }}

function password_edit_save()
{
	if($("#old_password").val()=='')
	{
		alert("请输入旧密码");
		return false;
	}
	else if($("#password").val()=='')
	{
		alert("请输入新密码");
		return false;
	}
	else if($("#confirm_password").val()=='')
	{
		alert("请再输入新密码");
		return false;
	}
	else
	{
		return true;
	}
}
function password_select()
{
	if($("#old_password").val()!='')
	{
		var html=ajax_load("admin.php?m=site&a=password_select&password="+$("#old_password").val());
		$(".password_select").html(html);		
	}
	else
	{
			$(".password_select").html('');
	}
}
function check_password()
{
	if($("#confirm_password").val()!='' && $("#password").val()!='')
	{
		if($("#confirm_password").val()!=$("#password").val())
		{
			$(".confirm_password").html('两次输入密码不一致');
		}
		else
		{
			$(".confirm_password").html('');
		}
	}
	else
	{
		$(".confirm_password").html('');
	}
}

function return_classify()
{
	if($("#classify_name").val()=='')
	{
		alert("分类名称不能为空");
		return false;
	}
	else
	{
		return true;
	}
}

function classify_code(classify_id,field)
{
	var html=ajax_load("admin.php?m=site&a=classify_code&classify_id="+classify_id+"&field="+field);
	$(".codehtml").html(html);
}

function classify_children(type_id,input_type_id,field)
{
	var html=ajax_load("admin.php?m=site&a=classify_children&type_id="+type_id+"&input_type_id="+input_type_id+"&field="+field);
	$(".codehtml").html(html);
}

function content_code(classify_id,type_id)
{
	var html=ajax_load("admin.php?m=site&a=content_code&classify_id="+classify_id+"&type_id="+type_id);
	$(".codehtml").html(html);
}

function content_url_code()
{
	var html=ajax_load("admin.php?m=site&a=content_url_code");
	$(".codehtml").html(html);
}

function site_children(field)
{
	var html=ajax_load("admin.php?m=site&a=site_children&field="+field);
	$(".codehtml").html(html);
}

function content_date_code()
{
	var html=ajax_load("admin.php?m=site&a=content_date_code");
	$(".codehtml").html(html);
}

function export_content()
{
	if($("#export_content_id").val()==1)
	{
		goto_url(location.href.replace('&export_content_id=1','')+"&export_content_id=1");
	}
	else
	{
		goto_url(location.href.replace('&export_content_id=1',''));
	}
}

function return_content()
{
	if($("#export_content_id").val()==1)
	{
		var i=0;
		$(".export_check:checked").each(function(){
			i=1;
		});
		if(i==0)
		{
			alert("请选择导出的字段");
			return false;
		}
		
	}
	else
	{
	}
}

function return_inputadd()
{
	if($("#input_name").val()=='')
	{
		alert("表单名称不能为空");
		return false;
	}
	else if($("#field_name").val()=='')
	{
		alert("字段名不能为空");
		return false;
	}
	else
	{
		return true;
	}
}

function copy_version()
{
	if($("#version_name").val()=='')
	{
		alert("版本名称");
		return false;
	}
	if($("#version_directory").val()=='')
	{
		alert("版本文件名");
		return false;
	}
}




