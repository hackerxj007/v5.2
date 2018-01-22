<?php require APP_ROOT.'public/head.php';?>
<div class="ajaxcontent">
<script type="text/javascript">
$('#form').ajaxForm({ success:function showResponse(responseText)  { 
	dialog_div_close('ajax_dialog');
	msg_show(responseText,50000);
}});
</script>

<form action="admin.php?m=permissions&a=permissions_edit_save" method="post" enctype="multipart/form-data" id="form">
  <?php
$user_id=pg('user_id');
$list = M('admin_classify')->where(array('level_id'=>2))->select();
?>
  <input name="user_id" type="hidden" id="date" value="<?php echo $user_id;?>" />
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
    <?php foreach($list as $k=>$v){
		$user_classify = M('user_classify')->where(array('user_id'=>$user_id,'classify_id'=>$v['classify_id']))->find();
		?>
    <tr class="row">
      <td><label>
	<strong><?php echo $v['classify_name'];?></strong><input name="classify_id[]" type="checkbox" value="<?php echo $v['classify_id'];?>"<?php if(!empty($user_classify))echo ' checked="checked"';?> /></label></td>
    </tr>
    <?php $admin_classify = M('admin_classify')->where(array('classify_pid'=>$v['classify_id']))->select();
	if(!empty($admin_classify)){?>
    <tr class="row">
      <td><?php foreach($admin_classify as $k_ac=>$v_ac){
		  $user_classify = M('user_classify')->where(array('user_id'=>$user_id,'classify_id'=>$v_ac['classify_id']))->find();
		  ?><label>
        <?php echo $v_ac['classify_name'];?><input name="classify_id[]" type="checkbox" value="<?php echo $v_ac['classify_id'];?>"<?php if(!empty($user_classify))echo ' checked="checked"';?> /></label>&nbsp;&nbsp;&nbsp;
        <?php }?></td>
    </tr>
    <?php }?>
    <?php }?>
  </table>
  <input type="submit" class="submit" value="确认无误，提交">
</form>
</div>
<?php require APP_ROOT.'public/foot.php';?>
