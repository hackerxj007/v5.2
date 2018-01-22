<?php require APP_ROOT.'public/head.php';?>
<div class="ajaxcontent">
<script type="text/javascript">
$('#form').ajaxForm({ success:function showResponse(responseText)  {
	dialog_div_close('ajax_dialog');
	msg_show(responseText,50000);
}});
</script>

<form action="admin.php?m=admin_classify&a=edit_save" method="post" enctype="multipart/form-data" id="form" onsubmit="return return_classify()" class="navbar-form">
<?php
global $lists,$classify_pids,$classify_id;
$classify_id=pg('classify_id');
$classify = M('admin_classify')->where(array('classify_id'=>$classify_id))->find();
$lists = M('admin_classify')->field('classify_id,level_id,classify_pid,classify_name')->where(array('version_id'=>session('version_id')))->select();
$classify_pids=$classify['classify_pid'];
?>
<input name="classify_id" type="hidden" value="<?php echo $classify_id;?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
  <tr class="row">
    <td>分类名称</td>
    <td><input name="data[classify_name]" class="form-control" id="classify_name" type="text" value="<?php echo $classify['classify_name']?>"></td>
  </tr>
<?php $user=session('user'); if($user['user_id']==1){?>
  <tr class="row">
    <td>父级</td>
    <td><select name="data[classify_pid]" id="classify_pid">
  <option value="<?php echo session('version_classify_id');?>">根目录</option>
<?php
function recursive_classify($classify_pid='1')
{
	global $lists,$classify_pids,$classify_id;
	foreach($lists as $key=>$val)
	{
		if($val['classify_pid']==$classify_pid)
		{
?>
  <option value="<?php echo $val['classify_id']?>"<?php if($classify_id==$val['classify_id']){?> disabled="disabled"<?php }?><?php if($classify_pids==$val['classify_id']){?> selected="selected"<?php }?>>┣<?php for($i=3;$i<=$val['level_id'];$i++)echo "━";?><?php echo $val['classify_name']?></option>
<?php
			recursive_classify($val['classify_id']);
		}
	}
}
recursive_classify();
?>
</select>
</td>
  </tr>
  <?php }else{?>
  <tr class="row">
    <td>父级</td>
    <td><?php echo M('admin_classify')->where(array('classify_id'=>$classify['classify_pid']))->getField('classify_name');?></td>
  </tr>
  <?php }?>
  <tr class="row">
    <td>链接</td>
    <td><input name="data[classify_url]" class="form-control" id="classify_url" type="text" value="<?php echo $classify['classify_url']?>" size="60"></td>
  </tr>
</table>
<input type="submit" class="submit" value="确认无误，提交">
</form>
</div>
<?php require APP_ROOT.'public/foot.php';?>
