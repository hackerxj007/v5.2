<?php require APP_ROOT.'public/head.php';?>
<div class="ajaxcontent">
<?php
$type_id = pg('type_id');
$content_id = pg('content_id');
$table_name = pg('table_name');
$list = M($table_name)->where(array($table_name . '_id' => $content_id))->find();
?>
<script type="text/javascript">
$('#form').ajaxForm({ success:function showResponse(responseText)  {
	dialog_div_close('ajax_dialog');
	msg_show(responseText,50000);
}});
</script>

<form action="admin.php?m=cms&a=edit_save" method="post" enctype="multipart/form-data" id="form">
<input name="type_id" type="hidden" value="<?php echo $type_id;?>" />
<input name="content_id" type="hidden" value="<?php echo $content_id;?>" />
<div class="codehtml"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
<?php
$input = M('input')->where(array('type_id'=>$type_id,'edit_switch'=>2,'input_pid'=>array('exp','is null')))->order('date asc')->select();
foreach($input as $k=>$v){
?>
<tr class="row">
  <td><?php echo $v['input_name']?></td>
  <td>
    <?php
	switch($v['input_type_id']){
		case 1:
		if($v['field_name']=='password' && $type_id==46)
		{
			$list[$v['field_name']]='';
		}
		?>
        <input name="data[<?php echo $v['field_name'];?>]" type="text" id="<?php echo $v['field_name'];?>" value="<?php echo $list[$v['field_name']];?>" size="<?php echo $v['edit_size'];?>" />
        <?php
		break;
		case 2:
		?>
        <textarea name="data[<?php echo $v['field_name'];?>]" cols="60" rows="<?php echo $v['edit_size'];?>" id="<?php echo $v['field_name'];?>"><?php echo $list[$v['field_name']];?></textarea>
        <?php
		break;
		case 3:
			echo fckeditor('data['.$v['field_name'].']',$v['edit_size'],$list[$v['field_name']]);
		break;
		case 4:
		?>
        <?php
		$input_p = M('input')->where(array('input_pid'=>$v['input_id']))->select();
		$valarr=unserialize($list[$v['field_name']]);
		foreach($input_p as $k2=>$v2){
		?>
        <label>
        <input type="checkbox" name="data[<?php echo $v['field_name'];?>][]"<?php if(in_array($v2['input_value'],$valarr))echo ' checked="checked"';?> value="<?php echo $v2['input_value']?>" />
        <?php echo $v2['input_name'];?>
        </label>
        <?php } ?>
        <?php
		break;

		case 5:
		?>
        <?php
		$input_p = M('input')->where(array('input_pid'=>$v['input_id']))->select();
		foreach($input_p as $k2=>$v2){
		?>
        <label>
        <input type="radio" name="data[<?php echo $v['field_name'];?>]" value="<?php echo $v2['input_value']?>" <?php if($list[$v['field_name']]==$v2['input_value'])echo ' checked="checked"';?>/>
        <?php echo $v2['input_name'];?>
        </label>&nbsp;&nbsp;
        <?php } ?>
        <?php
		break;
		case 6:
		?>
        <select name="data[<?php echo $v['field_name'];?>]" id="<?php echo $v['field_name'];?>">
        <option value="0">请选择</option>
        <?php
		$input_p = M('input')->where(array('input_pid'=>$v['input_id']))->select();
		foreach($input_p as $k2=>$v2){
		?>
          <option value="<?php echo $v2['input_value'];?>"<?php if($list[$v['field_name']]==$v2['input_value'])echo ' selected="selected"';?>><?php echo $v2['input_name'];?></option>
        <?php } ?>
        </select>
        <?php
		break;
		case 7:
		?>
        <input name="<?php echo $v['field_name'];?>" id="<?php echo $v['field_name'];?>" type="file" />
        <?php
		if($list[$v['field_name']]!='')
		{
			echo '<a href="'.$list[$v['field_name']].'" target="_blank"><img src="'.$list[$v['field_name']].'" width="50" height="25"/></a>';
			?>
            <a href="javascript:;" onclick="if(confirm('确定删除吗!')){delete_img('admin.php?m=content&a=delete_img&content_id=<?php echo $content_id;?>&table_name=<?php echo $table_name;?>&type_id=<?php echo $type_id;?>&field_name=<?php echo $v['field_name'];?>',$(this))}" class="delete">删除</a>
            <?php
		}
		break;
		case 8:
		?>
        <input name="data[<?php echo $v['field_name'];?>]" type="text" class="laydate-input" id="<?php echo $v['field_name'];?>" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?php echo cover_time($list[$v['field_name']],'Y-m-d H:i:s')?>" size="<?php echo $v['edit_size'];?>" />
        <?php
		break;
		case 9:
			$field_name=$v['field_name'];
		?>
		<div class="fieldset flash" id="fsUploadProgress" align="left"></div>
        <div id="divStatus">0 个文件已上传</div>
        <div> <span id="spanButtonPlaceHolder"></span><br />
          <input id="btnCancel" type="button" value="断开上传" onClick="swfu.cancelQueue();" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
        </div>
        <input name="data[<?php echo $v['field_name'];?>]" type="hidden" id="<?php echo $v['field_name'];?>" size="<?php echo $v['edit_size'];?>" />
		<?php
		if($list[$v['field_name']]!='')
		{
			?>
            <i class="fa fa-file-pdf-o bigfilei" aria-hidden="true"></i>
            <a href="javascript:;" onclick="if(confirm('确定删除吗!')){delete_img('admin.php?m=content&a=delete_img&content_id=<?php echo $content_id;?>&table_name=<?php echo $table_name;?>&type_id=<?php echo $type_id;?>&field_name=<?php echo $v['field_name'];?>',$(this))}" class="delete">删除</a>
            <?php
		}
		break;
	}
	?>
<?php $user=session('user'); if($user['user_id']==1){?>
    <a href="javascript:;" class="copycode" onClick="classify_children(<?php echo $type_id;?>,<?php echo $v['input_type_id'];?>,'<?php echo $v['field_name'];?>')">[字段]</a>
<?php }?>
     <?php echo $v['note'];?>
</td>
  </tr>
<?php }?>

</table>

<input type="submit" class="submit" value="确认无误，提交">
</form>
</div>
<script type="text/javascript">
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
<?php require APP_ROOT.'public/foot.php';?>
