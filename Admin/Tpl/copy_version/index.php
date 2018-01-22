<?php require APP_ROOT.'public/top.php';?>
<script type="text/javascript">
$('#form_menu').ajaxForm({ success:function showResponse(responseText)  {
	msg_show(responseText,500000);
	goto_url("");
}});
</script>
<div class="content">
	<?php require APP_ROOT.'public/left.php';?>
	<div class="right_panel" id="right">
		<a href="javascript:;" onclick="dialog_div(900,600,'admin.php?m=copy_version&a=add&ajax=1&time=<?php echo time()?>')" class="button">添加版本</a>
		<form method="post" id="form_menu" action="admin.php?m=content&a=batch_edit_save" >
		<table class="tables" width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr class="title">
					<input name="table_name" type="hidden" id="table_name" value="<?php echo $table_name;?>" />
					<input name="type_id" type="hidden" id="type_id" value="<?php echo $type_id;?>" />
					<td height="30"><input name="" type="checkbox" class="checkbox" onclick="SelectAll('content_id[]')" value="" />全选</td>
					<td>版本名称</td>
					<td>操作</td>
				</tr>
				<?php
				$list = M('site')->select();
				foreach($list as $k=>$v){
				?>
					<tr>
						<td height="35">&nbsp;<?php echo $v['site_id'];?></td>
						<td><?php echo $v['version_name'];?></td>
						<td></td>
					</tr>
				<?php }?>
			</table>

		</form>
	</div>

</div>
<?php require APP_ROOT.'public/bottom.php';?>
