<?php if (!defined('THINK_PATH')) exit(); require APP_ROOT.'public/head.php';?>
<div class="ajaxcontent">
<?php $type_id=pg('type_id');?>
<script type="text/javascript">
$('#form').ajaxForm({ success:function showResponse(responseText)  { 
	dialog_div_close('ajax_dialog');
	msg_show(responseText,5000000);
}}); 
</script>

<div class="menu_add">
  <form action="admin.php?m=input&a=add_save" onsubmit="return return_inputadd()" method="post" id="form">
    <ul>
      <input name="data[type_id]" type="hidden" value="<?php echo $type_id;?>" />
      <input name="data[date]" type="hidden" value="<?php echo time();?>" />
      <li><span>表单名：</span>
        <input name="data[input_name]" type="text" id="input_name">
      </li>
      <li><span>字段名：</span>
        <input name="data[field_name]" type="text" id="field_name">
      </li>
      <li><span>表单类型：</span>
        <select name="data[input_type_id]">
          <?php  $list = M('input_type')->select(); foreach($list as $k=>$v){ ?>
          <option value="<?php echo $v['input_type_id'];?>"><?php echo $v['input_type_name'];?></option>
          <?php }?>
        </select>
      </li>
      <li><span>数据类型：</span>
        <select name="data[data_type_id]">
          <?php  $list = M('data_type')->select(); foreach($list as $k=>$v){ ?>
          <option value="<?php echo $v['data_type_id'];?>"><?php echo $v['data_type_name'];?></option>
          <?php }?>
        </select>
      </li>
      <li><span>数据长度：</span>
        <input name="data[data_length]" type="text" value="0" size="5" />
      </li>
      <input class="submit" type="submit" value="确认无误，提交">
    </ul>
  </form>
</div>
</div>
<?php require APP_ROOT.'public/foot.php';?>