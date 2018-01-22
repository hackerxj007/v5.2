<?php require APP_ROOT.'public/head.php';?>
<div class="ajaxcontent">
<script type="text/javascript">
$('#form').ajaxForm({ success:function showResponse(responseText)  {
	dialog_div_close('ajax_dialog');
	msg_show(responseText,50000);
}});

</script>
<?php
	$type_id=pg('type_id');
?>
<form action="admin.php?m=cms&a=add_save" method="post" enctype="multipart/form-data" id="form">
<input name="data[date]" type="hidden" id="date" value="<?php echo time();?>" />
<input name="data[version_id]" type="hidden" id="version_id" value="1" />
<input name="data[type_id]" type="hidden" id="type_id" value="<?php echo $type_id;?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
<?php
$list = M('input')->where(array('type_id'=>$type_id,'edit_switch'=>2,'input_pid'=>array('exp','is null')))->order('date asc')->select();
foreach($list as $k=>$v){
?>
  <tr class="row">
  <td><?php echo $v['input_name']?></td>
  <td>
  <?php
	switch($v['input_type_id']){
		case 1:
		?>
        <input name="data[<?php echo $v['field_name'];?>]" type="text" id="<?php echo $v['field_name'];?>" size="<?php echo $v['edit_size'];?>" />
        <?php
		break;
		case 2:
		?>
        <textarea name="data[<?php echo $v['field_name'];?>]" cols="60" rows="<?php echo $v['edit_size'];?>" id="<?php echo $v['field_name'];?>"></textarea>
        <?php
		break;
		case 3:
			echo fckeditor('data['.$v['field_name'].']',$v['edit_size'],'');
		break;
		case 4:
		?>
        <?php
		$input_p = M('input')->where(array('input_pid'=>$v['input_id']))->select();
		foreach($input_p as $k2=>$v2){
		?>
        <label>
        <input type="checkbox" name="data[<?php echo $v['field_name'];?>][]" value="<?php echo $v2['input_value']?>" />
        <?php echo $v2['input_name'];?>
        </label>&nbsp;&nbsp;
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
        <input type="radio" name="data[<?php echo $v['field_name'];?>]" value="<?php echo $v2['input_value']?>" />
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
          <option value="<?php echo $v2['input_value'];?>"><?php echo $v2['input_name'];?></option>
        <?php } ?>
        </select>
        <?php
		break;
		case 7:
		?>
        <input name="<?php echo $v['field_name'];?>" id="<?php echo $v['field_name'];?>" type="file" />
        <?php
		break;
		case 8:
		?>
        <input name="data[<?php echo $v['field_name'];?>]" class="laydate-input" type="text" id="<?php echo $v['field_name'];?>" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" size="<?php echo $v['edit_size'];?>" />
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
		break;
	}
	?>
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
