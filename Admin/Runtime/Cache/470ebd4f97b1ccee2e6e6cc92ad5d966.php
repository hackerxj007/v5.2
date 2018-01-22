<?php if (!defined('THINK_PATH')) exit(); require APP_ROOT.'public/head.php';?>

<div class="ajaxcontent"> 
  <script type="text/javascript">
$('#form').ajaxForm({ success:function showResponse(responseText)  { 
	dialog_div_close('ajax_dialog');
	msg_show(responseText,50000);
}});
</script>
  <div class="menu_add">
    <form action="admin.php?m=type&a=add_save" method="post" id="form">
      <ul>
        <input name="data[date]" type="hidden" value="<?php echo time();?>" />
        <li><span>类型名称：</span>
          <input name="data[type_name]" type="text">
        </li>
        <li><span>表名：</span>
          <input name="data[table_name]" type="text">
        </li>
        <li><span>页面名：</span>
          <input name="data[page_name]" type="text" value="index">
        </li>
        <input class="submit" type="submit" value="确认无误，提交">
      </ul>
    </form>
  </div>
</div>
<?php require APP_ROOT.'public/foot.php';?>