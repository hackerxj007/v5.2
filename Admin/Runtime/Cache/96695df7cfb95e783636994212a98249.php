<?php if (!defined('THINK_PATH')) exit(); require APP_ROOT.'public/head.php';?>
<div class="ajaxcontent">
<?php
$type_id=pg('type_id'); $input_pid=pg('input_pid'); ?>
<script type="text/javascript">
$('#form').ajaxForm({ success:function showResponse(responseText)  { 
	dialog_div_close('ajax_dialog');
	msg_show(responseText,5000000);
}});
</script>

<div class="menu_add">
  <form action="admin.php?m=input&a=child_add_save" method="post" id="form">
    <ul>
      <input name="data[input_pid]" type="hidden" value="<?php echo $input_pid;?>" />
      <input name="data[type_id]" type="hidden" value="<?php echo $type_id;?>" />
      <input name="data[date]" type="hidden" value="<?php echo time();?>" />
      <li><span>选项名称：</span>
        <input name="data[input_name]" id="menu_name" type="text">
      </li>
      <li><span>选项值：</span>
        <input name="data[input_value]" id="input_value" type="text">
      </li>
      
      <input class="submit" type="submit" value="确认无误，提交">
    </ul>
  </form>
</div>
</div>
<?php require APP_ROOT.'public/foot.php';?>