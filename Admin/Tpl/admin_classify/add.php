<?php require APP_ROOT.'public/head.php';?>
<div class="ajaxcontent">
<script type="text/javascript">
$('#form').ajaxForm({ success:function showResponse(responseText)  { 
	dialog_div_close('ajax_dialog');
	msg_show(responseText,50000);
}});
</script>
<?php
global $lists,$classify_id;
$classify_id=pg('classify_id');
$classify = M('admin_classify')->where(array('classify_id'=>$classify_id))->find();
?>
<form action="admin.php?m=admin_classify&a=add_save" method="post" enctype="multipart/form-data" id="form" onsubmit="return return_classify()" class="navbar-form">
<input name="data[date]" type="hidden" id="date" value="<?php echo time();?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
  <tr class="row">
    <td>分类名称</td>
    <td><input name="data[classify_name]" class="form-control" id="classify_name" type="text"></td>
  </tr>
  <tr class="row">
    <td>父级</td>
    <td>
<select name="data[classify_pid]" id="classify_pid">
  <option value="<?php echo session('version_classify_id');?>">根目录</option>
  <?php 
$lists = M('admin_classify')->field('classify_id,level_id,classify_pid,classify_name')->select();
function recursive_classify($classify_pid='1')
{
	global $lists,$classify_id;
	foreach($lists as $k=>$v)
	{
		if($v['classify_pid']==$classify_pid)
		{
?>
  <option value="<?php echo $v['classify_id']?>"<?php if($classify_id==$v['classify_id']){?> selected="selected"<?php }?>>┣<?php for($i=3;$i<=$v['level_id'];$i++)echo "━";?> <?php echo $v['classify_name']?></option>
<?php
			recursive_classify($v['classify_id']);
		}
	}
}
recursive_classify();
?>
</select>
</td>
  </tr>
  <tr class="row">
    <td>链接</td>
    <td><input name="data[classify_url]" class="form-control" id="classify_url" type="text" size="60"></td>
  </tr>
</table>
<input type="submit" class="submit" value="确认无误，提交">
</form>
</div>
<?php require APP_ROOT.'public/foot.php';?>
