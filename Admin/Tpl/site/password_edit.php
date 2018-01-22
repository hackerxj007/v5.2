<?php require APP_ROOT.'public/top.php';?>
<div class="content">
  <?php require APP_ROOT.'public/left.php';?>
  <div class="right_panel" id="right">
    <form method="post" id="form_menu" action="admin.php?m=site&a=password_edit_save" enctype="multipart/form-data" onsubmit="return password_edit_save()" >
      <input name="version_id" type="hidden" value="<?php echo session('version_id');?>" />
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr class="title" height="30">
    <td width="7%">&nbsp;密码修改</td>
    <td width="89%"></td>
  </tr>
<tr class="row">
    <td width="7%">&nbsp;旧密码</td>
    <td width="89%"><input name="old_password" type="password" id="old_password" onblur="password_select()" />
    <span class="password_select"></span>
    </td>
  </tr>
<tr class="row">
    <td>&nbsp;新密码</td>
    <td><input name="password" type="password" id="password" onblur="check_password()" />
    <span class="confirm_password"></span>
    </td>
  </tr>
  <tr class="row">
    <td>&nbsp;确认密码</td>
    <td><input name="confirm_password" type="password" id="confirm_password" onblur="check_password()" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="" type="submit" class="submit" value="提交" /></td>
  </tr>
</table>
    </form>
  </div>
</div>
<?php require APP_ROOT.'public/bottom.php';?>
