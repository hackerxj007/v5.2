<?php require APP_ROOT.'public/head.php';?>
<div class="ajaxcontent">
<script type="text/javascript">
$('#form').ajaxForm({ success:function showResponse(responseText)  { 
	dialog_div_close('ajax_dialog');
	msg_show(responseText,50000);
}});
</script>

<form action="admin.php?m=permissions&a=edit_save" method="post" enctype="multipart/form-data" id="form">
  <?php
$user_id=pg('user_id');
$user = M('user')->where(array('user_id'=>$user_id))->find();
?>
  <input name="user_id" type="hidden" id="date" value="<?php echo $user_id;?>" />
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
    <tr class="row">
      <td>名称</td>
      <td><input name="data[name]" type="text" id="name" value="<?php echo $user['name'];?>"></td>
    </tr>
    <tr class="row">
      <td>用户名</td>
      <td><input name="data[username]" id="username" type="text" value="<?php echo $user['username'];?>"></td>
    </tr>
    <tr class="row">
      <td>密码</td>
      <td><input name="data[password]" id="password" type="text" value=""></td>
    </tr>
  </table>
  <input type="submit" class="submit" value="确认无误，提交">
</form>
</div>
<?php require APP_ROOT.'public/foot.php';?>
