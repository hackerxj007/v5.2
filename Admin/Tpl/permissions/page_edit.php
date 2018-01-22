<?php require APP_ROOT.'public/head.php';?>
<div class="ajaxcontent">
<script type="text/javascript">
$('#form').ajaxForm({ success:function showResponse(responseText)  { 
	dialog_div_close('ajax_dialog');
	msg_show(responseText,50000);
}});
</script>

<form action="admin.php?m=permissions&a=page_edit_save" method="post" enctype="multipart/form-data" id="form">
  <?php
global $page_edit_arr;
$user_id=pg('user_id');
$user_page = M('user_page')->where(array('user_id'=>$user_id))->select();
foreach($user_page as $k=>$v)
{
	$page_edit_arr[]=$v['page'];
}
?>
  <input name="user_id" type="hidden" id="user_id" value="<?php echo $user_id?>" />
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
    <?php
function listDir2($dir,$directory)
{
	?>
    <tr>
      <td><strong><?php echo $directory;?></strong></td>
    </tr>
    <tr>
      <td><?php
	if(is_dir($dir))
   	{
     	if ($dh = opendir($dir))
		{
        	while (($file = readdir($dh)) !== false)
			{
     			if((is_dir($dir.$file)) && $file!="." && $file!="..")
				{
					$path=$file;
					?>
        <br />
        <div class="menu_pname"><?php echo $directory;?></div>
        <?php
     			}
				else
				{
         			if($file!="." && $file!="..")
					{
						global $page_edit_arr;
						?>
        <label> <?php echo $file;?>
          <input name="page[]"<?php if(in_array($directory.'_'.$file,$page_edit_arr)){?> checked="checked"<?php }?> type="checkbox" class="checkbox" value="<?php echo $directory.'_'.$file;?>" />
        </label>
        &nbsp;&nbsp;&nbsp;
        <?php
					}
     			}
        	}
        	closedir($dh);
     	}
   	}
	?></td>
    </tr>
    <tr class="row">
      <td></td>
    </tr>
    <?php
}

//开始运行
$list=each_dir(APP_ROOT);
foreach($list as $k=>$v)
{
	if(!in_array($v['filename'],array('images','css','js','font-awesome-4.5.0')))
	{
	listDir2(APP_ROOT.$v['filename'],$v['filename']);
	}
}
?>
  </table>
  <input name="" class="submit" type="submit" value="提交" />
</form>
</div>
<?php require APP_ROOT.'public/foot.php';?>
