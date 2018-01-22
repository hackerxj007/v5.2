<?php if (!defined('THINK_PATH')) exit(); require APP_ROOT.'public/head.php';?>
<div class="ajaxcontent">
<?php
$classify_id = pg('classify_id'); $type_id = pg('type_id'); $content_id = pg('content_id'); $table_name = pg('table_name'); $list = M($table_name)->where(array($table_name . '_id' => $content_id))->find(); ?>
<script type="text/javascript">
$('#form').ajaxForm({ success:function showResponse(responseText)  {
	dialog_div_close('ajax_dialog');
	msg_show(responseText,50000);
}});
</script>

<form action="admin.php?m=content&a=edit_save" method="post" enctype="multipart/form-data" id="form">
<input name="classify_id" type="hidden" value="<?php echo $classify_id;?>" />
<input name="type_id" type="hidden" value="<?php echo $type_id;?>" />
<input name="content_id" type="hidden" value="<?php echo $content_id;?>" />
<?php if($list['price_array']!=''){ $list['price_array']=unserialize($list['price_array']); foreach($list['price_array'] as $k=>$v){ $val=$v; unset($val['price']); unset($val['inventory']); unset($val['coding']); unset($val['volume']); unset($val['weight']); $val_id=implode('',$val); ?>
	<input type="hidden" value="<?php echo $v['price'];?>" id="price_<?php echo $val_id;?>" />
	<input type="hidden" value="<?php echo $v['inventory'];?>" id="inventory_<?php echo $val_id;?>" />
	<input type="hidden" value="<?php echo $v['coding'];?>" id="coding_<?php echo $val_id;?>" />
	<input type="hidden" value="<?php echo $v['volume'];?>" id="volume_<?php echo $val_id;?>" />
	<input type="hidden" value="<?php echo $v['weight'];?>" id="weight_<?php echo $val_id;?>" />
<?php } }?>

<div class="codehtml"></div>


<div class="tabouter">
<?php $user=session('user'); if($user['user_id']==1){?>
  <div class="tabnav">
    <ul>
      <li>基本设置</li>
      <li>高级设置</li>
    </ul>
  </div>
<?php }?>
  <div class="tabcon">
<div class="tabconent">


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
<?php $user=session('user'); if($user['user_id']==1){?>
<tr class="row">
  <td>功能</td>
  <td><a href="javascript:;" class="copycode" onClick="content_code(<?php echo $classify_id;?>,'<?php echo $type_id;?>')">[循环代码]</a>
  <a href="javascript:;" class="copycode" onClick="content_url_code()">[链接]</a>
  <a href="javascript:;" class="copycode" onClick="content_date_code()">[时间]</a>
  </td>
</tr>
<?php }?>
<?php
$input = M('input')->where(array('type_id'=>$type_id,'edit_switch'=>2,'input_pid'=>array('exp','is null')))->order('date asc')->select(); foreach($input as $k=>$v){ ?>
<tr class="row">
  <td><?php echo $v['input_name']; if($v['price_switch']==2){?>
  <input name="attribute_name[]" type="hidden" value="<?php echo $v['input_name'];?>" />
  <input name="field_name[]" type="hidden" value="<?php echo $v['field_name'];?>" />
  <div id="specifications<?php echo $v['field_name'];?>"></div>  
	<?php }?>
    </td>
  <td>
  <?php if($v['field_name']=='price_array'){?>
  <div class="product_table"></div>
  <?php }else{?>
    <?php
 switch($v['input_type_id']){ case 1: ?>
        <input name="data[<?php echo $v['field_name'];?>]" type="text" id="<?php echo $v['field_name'];?>" value="<?php echo $list[$v['field_name']];?>" size="<?php echo $v['edit_size'];?>"<?php if($v['price_switch']==2){?> onblur="product_specifications(4)" priceattr="specifications[<?php echo $v['field_name']?>]"<?php }?> />
        <?php
 break; case 2: ?>
        <textarea name="data[<?php echo $v['field_name'];?>]" cols="60" rows="<?php echo $v['edit_size'];?>" id="<?php echo $v['field_name'];?>"><?php echo $list[$v['field_name']];?></textarea>
        <?php
 break; case 3: echo fckeditor('data['.$v['field_name'].']',$v['edit_size'],$list[$v['field_name']]); break; case 4: ?>
        <?php
 $input_p = M('input')->where(array('input_pid'=>$v['input_id']))->select(); $valarr=unserialize($list[$v['field_name']]); foreach($input_p as $k2=>$v2){ ?>
        <label>
        <input type="checkbox" name="data[<?php echo $v['field_name'];?>][]"<?php if(in_array($v2['input_value'],$valarr))echo ' checked="checked"';?> value="<?php echo $v2['input_value']?>" />
        <?php echo $v2['input_name'];?>
        </label>
        <?php } ?>
        <?php
 break; case 5: ?>
        <?php
 $input_p = M('input')->where(array('input_pid'=>$v['input_id']))->select(); foreach($input_p as $k2=>$v2){ ?>
        <label>
        <input type="radio" name="data[<?php echo $v['field_name'];?>]" value="<?php echo $v2['input_value']?>" <?php if($list[$v['field_name']]==$v2['input_value'])echo ' checked="checked"';?>/>
        <?php echo $v2['input_name'];?>
        </label>&nbsp;&nbsp;
        <?php } ?>
        <?php
 break; case 6: ?>
        <select name="data[<?php echo $v['field_name'];?>]" id="<?php echo $v['field_name'];?>">
        <option value="0">请选择</option>
        <?php
 $input_p = M('input')->where(array('input_pid'=>$v['input_id']))->select(); foreach($input_p as $k2=>$v2){ ?>
          <option value="<?php echo $v2['input_value'];?>"<?php if($list[$v['field_name']]==$v2['input_value'])echo ' selected="selected"';?>><?php echo $v2['input_name'];?></option>
        <?php } ?>
        </select>
        <?php
 break; case 7: ?>
        <input name="<?php echo $v['field_name'];?>" id="<?php echo $v['field_name'];?>" type="file" />
        <?php
 if($list[$v['field_name']]!='') { echo '<a href="'.$list[$v['field_name']].'" target="_blank"><img src="'.$list[$v['field_name']].'" width="50" height="25"/></a>'; ?>
            <a href="javascript:;" onclick="if(confirm('确定删除吗!')){delete_img('admin.php?m=content&a=delete_img&content_id=<?php echo $content_id;?>&table_name=<?php echo $table_name;?>&type_id=<?php echo $type_id;?>&field_name=<?php echo $v['field_name'];?>',$(this))}" class="delete">删除</a>
            <?php
 } break; case 8: ?>
        <input name="data[<?php echo $v['field_name'];?>]" type="text" class="laydate-input" id="<?php echo $v['field_name'];?>" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?php echo cover_time($list[$v['field_name']],'Y-m-d H:i:s')?>" size="<?php echo $v['edit_size'];?>" />
        <?php
 break; case 9: $field_name=$v['field_name']; ?>
		<div class="fieldset flash" id="fsUploadProgress" align="left"></div>
        <div id="divStatus">0 个文件已上传</div>
        <div> <span id="spanButtonPlaceHolder"></span><br />
          <input id="btnCancel" type="button" value="断开上传" onClick="swfu.cancelQueue();" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
        </div>
        <input name="data[<?php echo $v['field_name'];?>]" type="hidden" id="<?php echo $v['field_name'];?>" size="<?php echo $v['edit_size'];?>" />
		<?php
 if($list[$v['field_name']]!='') { ?>
            <i class="fa fa-file-pdf-o bigfilei" aria-hidden="true"></i>
            <a href="javascript:;" onclick="if(confirm('确定删除吗!')){delete_img('admin.php?m=content&a=delete_img&content_id=<?php echo $content_id;?>&table_name=<?php echo $table_name;?>&type_id=<?php echo $type_id;?>&field_name=<?php echo $v['field_name'];?>',$(this))}" class="delete">删除</a>
            <?php
 } break; } } ?>
<?php $user=session('user'); if($user['user_id']==1){?>
    <a href="javascript:;" class="copycode" onClick="classify_children(<?php echo $type_id;?>,<?php echo $v['input_type_id'];?>,'<?php echo $v['field_name'];?>')">[字段]</a>
<?php }?>
    <?php echo $v['note'];?>
</td>
  </tr>
<?php }?>

</table>

    </div>
    
<div class="tabconent">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
  <tr class="row">
  <td>浏览器标题</td>
  <td><input name="data[title]" id="title" size="80" value="<?php echo $list['title'];?>" type="text"></td>
  </tr>
  <tr class="row">
  <td>浏览器关键词</td>
  <td><input name="data[keywords]" id="keywords" size="80" value="<?php echo $list['keywords'];?>" type="text"></td>
  </tr>
  <tr class="row">
  <td>浏览器描述</td>
  <td><input name="data[description]" id="description" size="80" value="<?php echo $list['description'];?>" type="text"></td>
  </tr>
</table>

    </div>

  </div>
  <script type="text/javascript">jQuery(".tabouter").slide({titCell:".tabnav ul li",mainCell:".tabcon",trigger:"click",delayTime:0});</script> 
</div>

<input type="submit" class="submit" value="确认无误，提交">
</form>

<script type="text/javascript">
var str,table_name_arr= new Array(),value_arr= new Array(),code_str="",price_str='',inventory_str='',coding_str='',volume_str='',weight_str='',checkbox_val_str,checkbox_val_arr= new Array()//定义一数组
function recursive_specifications(name_arr,number,length)
{

		code_str=code_str+"$(\"input[name='specifications["+name_arr[number]+"][]']\").each(function(){checkbox_val_arr["+number+"]=$(this).val();value_arr["+number+"]=$(this).val();";
		if(number<length)
		{
			number++;
			recursive_specifications(name_arr,number,length);
		}
		else
		{
			code_str=code_str+"checkbox_val_str='';str=str+'<tr>';";
			code_str=code_str+"for(var i=0;i<"+(length+1)+";i++){checkbox_val_str=checkbox_val_str+checkbox_val_arr[i];str=str+'<td class=th_menu>'+value_arr[i]+'<input type=\"hidden\" name=\"attributes['+table_name_arr[i]+'][]\" value=\"'+checkbox_val_arr[i]+'\" size=\"10\" ></td>';}if($('#price_'+checkbox_val_str).length >0){price_str=$('#price_'+checkbox_val_str).val();}else{price_str='';}if($('#inventory_'+checkbox_val_str).length >0){inventory_str=$('#inventory_'+checkbox_val_str).val();}else{inventory_str='';}if($('#coding_'+checkbox_val_str).length >0){coding_str=$('#coding_'+checkbox_val_str).val();}else{coding_str='';}if($('#volume_'+checkbox_val_str).length >0){volume_str=$('#volume_'+checkbox_val_str).val();}else{volume_str='';}if($('#weight_'+checkbox_val_str).length >0){weight_str=$('#weight_'+checkbox_val_str).val();}else{weight_str='';}";

			code_str=code_str+"str=str+'<td><input type=\"text\" name=\"attributes[price][]\" value=\"'+price_str+'\" size=\"10\" ></td><td><input type=\"text\" name=\"attributes[inventory][]\" value=\"'+inventory_str+'\" size=\"10\" ></td><td><input type=\"text\" name=\"attributes[coding][]\" value=\"'+coding_str+'\" size=\"10\" ></td><td><input type=\"text\" name=\"attributes[volume][]\" value=\"'+volume_str+'\" size=\"10\" ></td><td><input type=\"text\" name=\"attributes[weight][]\" value=\"'+weight_str+'\" size=\"10\" ></td></tr>';";

		}
		code_str=code_str+"});";
}

function product_specifications(id)
{
	str='<table border="0" cellspacing="0" width="100%"><thead><tr>';
	code_str='';
	$("input[name='attribute_name[]']").each(function()
	{
		str=str+'<th class="th_menu">'+$(this).val()+'</th>';
	});

	$("input[name='field_name[]']").each(function(i, n)
	{
		table_name_arr[i]=$(this).val();
		$("#specifications"+$(this).val()).html('');
		$.each($("input[priceattr='specifications["+$(this).val()+"]']").val().split("|"), function(si, sn){
			$("#specifications"+table_name_arr[i]).append('<input type="hidden" name="specifications['+table_name_arr[i]+'][]" value="'+sn+'" />');
		});
	});
	

	str=str+'<th class="th_price">价格</th><th class="th_inventory">数量</th><th class="th_coding">商家编码</th><th class="th_coding">体积m³</th><th class="th_coding">重量kg</th></tr></thead><tbody>';
	recursive_specifications(table_name_arr,0,(table_name_arr.length-1));
	eval(code_str);

	str=str+'</tbody></table>';


	$(".product_table").html(str);
	var n=0;
	//alert(str);
}
product_specifications(4);

	var swfu;
		var settings = {
			flash_url : "<?php echo APP_ROOT.'js/swfupload.swf';?>",
			upload_url: "admin.php?m=content&a=batch_upload_save",
			post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},
			file_size_limit : "2000 MB",
			file_types : "*.*",
			file_types_description : "All Files",
			file_upload_limit : 0,  //配置上传个数
			file_queue_limit : 0,
			custom_settings : {
				progressTarget : "fsUploadProgress",
				cancelButtonId : "btnCancel"
			},
			debug: false,
			// Button settings
			button_image_url: "",
			button_width: "100",
			button_height: "30",
			button_placeholder_id: "spanButtonPlaceHolder",
			button_text: '<span class="theFont" style="color:#f00;">点击上传</span>',
			button_text_style: ".theFont { font-size: 16; }",
			button_text_left_padding: 12,
			button_text_top_padding: 3,

			file_queued_handler : fileQueued,
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_start_handler : uploadStart,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete,
			queue_complete_handler : queueComplete	
		};

		swfu = new SWFUpload(settings);
	 
	 function uploadSuccess(file, serverData){
		 $("#<?php echo $field_name;?>").val(serverData);
		 $("#divStatus").show();
	}


</script>
</div>
<?php require APP_ROOT.'public/foot.php';?>