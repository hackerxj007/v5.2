<?php if (!defined('THINK_PATH')) exit(); require APP_ROOT.'public/top.php';?>
<script type="text/javascript">
$('#form_menu').ajaxForm({ success:function showResponse(responseText)  {
	msg_show(responseText,500000);
	goto_url("");
}});
</script>
<div class="content">
  <?php require APP_ROOT.'public/left.php';?>
  <div class="right_panel" id="right">
  <div class="form_panel">
    <form method="post" id="form_menu" action="admin.php?m=admin_classify&a=batch_edit_save" class="navbar-form">
<table class="tables" width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr class="title">
          <td height="30">&nbsp;id</td>
          <td>后台分类(点击修改)</th>
          <td>链接</td>
          <td>添加子分类</td>
          <td>排序</td>
	<?php $user=session('user'); if($user['user_id']==1){?>
          <th>隐删除</td>
	<?php }?>
          <td>删除</td>
        </tr>
        <?php
global $list; $list = M('admin_classify')->where(array())->order('date asc')->select(); function recursive_classify($classify_pid='1') { global $list; foreach($list as $k=>$v) { if($v['classify_pid']==$classify_pid) { ?>
        <tr>
          <td height="35">&nbsp;<?php echo $v['classify_id']?>
            <input name="classify_id[]" type="hidden" value="<?php echo $v['classify_id']?>" /></td>
          <td><?php for($i=3;$i<=$v['level_id'];$i++)echo "&nbsp;&nbsp;&nbsp;";?>           
            <a href="javascript:;"  onclick="dialog_div(900,600,'admin.php?m=admin_classify&a=edit&classify_id=<?php echo $v['classify_id'];?>')"><?php echo $v['classify_name']?></a>
            </td>
            <td><input name="data[classify_url][]" class="form-control" id="classify_url" type="text" value="<?php echo $v['classify_url']?>" size="60"></td>
          <td>
          <?php if($v['level_id']<3){?>
          <a href="javascript:;" onclick="dialog_div(900,600,'admin.php?m=admin_classify&a=add&classify_id=<?php echo $v['classify_id'];?>&time=<?php echo time();?>')">添加子分类</a>
          <?php }?>
          </td>
          <td><input name="data[date][]" class="form-control" type="text" value="<?php echo cover_time($v['date'],'Y-m-d H:i:s');?>" size="20" /></td>
	<?php $user=session('user'); if($user['user_id']==1){?>
          <td>
          <select name="data[is_delete][]">
              <option value="2"<?php if($v['is_delete']==2)echo ' selected="selected"';?>>显示</option>
              <option value="1"<?php if($v['is_delete']==1)echo ' selected="selected"';?>>隐藏</option>
            </select></td>
            <?php }?>
          <td><?php $classify = M('classify')->where(array('classify_pid'=>$v['classify_id']))->find(); if(empty($classify)&&$count==0&&$v['is_delete']!=1){?>
            <a  href="javascript:;" onclick="if(confirm('确定删除吗!')){ajax_list('admin.php?m=admin_classify&a=del_save&classify_id=<?php echo $v['classify_id'];?>','admin.php?m=admin_classify&a=index&admin_classify_id=3')}" class="delete">删除</a>
            <?php }?></td>
        </tr>
        <?php
 recursive_classify($v['classify_id']); } } } recursive_classify(); ?>
      </table>
      <input name="" type="submit" class="submit" value="提交" />
    </form>
  </div>
  </div>
</div>
<?php require APP_ROOT.'public/bottom.php';?>