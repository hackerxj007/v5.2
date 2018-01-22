<?php require APP_ROOT.'public/head.php';?>
<div class="ajaxcontent">
<?php
	$type_id=51;
	$member_id=pg('member_id');
?>
<script type="text/javascript">
$('#form').ajaxForm({ success:function showResponse(responseText)  {
	dialog_div_close('ajax_dialog');
	msg_show(responseText,5000);
}});
</script>

<form action="admin.php?m=member&a=add_account_save" method="post" enctype="multipart/form-data" id="form">
<input name="data[date]" type="hidden" id="date" value="<?php echo time();?>" />
<input name="data[version_id]" type="hidden" id="version_id" value="1" />
<input name="data[type_id]" type="hidden" id="type_id" value="<?php echo $type_id; ?>" />
<input name="data[member_id]" type="hidden" id="member_id" value="<?php echo $member_id; ?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
  <tr class="row">
  <td>用户名</td>
  <td><?php echo M('member')->where(array('member_id'=>$member_id))->getfield('username');?></td>
  </tr>
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
        <input name="data[<?php echo $v['field_name'];?>]" type="text" id="<?php echo $v['field_name'];?>" size="<?php echo $v['edit_size'];?>" value="<?php if($v['field_name']=='member_id')echo $member_id;?>" />
        <?php
		break;
		case 2:
		?>
        <textarea name="data[<?php echo $v['field_name'];?>]" cols="60" rows="<?php echo $v['edit_size'];?>" id="<?php echo $v['field_name'];?>"></textarea>
        <?php
		break;
		case 3:
			echo fckeditor('data['.$v['field_name'].']',$v['edit_size']);
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
	}
	?>
</td>
  </tr>
  <?php }?>
</table>
<input type="submit" class="submit" value="确认无误，提交">
</form>
</div>
<?php require APP_ROOT.'public/foot.php';?>
