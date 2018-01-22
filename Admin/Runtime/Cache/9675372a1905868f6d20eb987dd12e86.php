<?php if (!defined('THINK_PATH')) exit(); require APP_ROOT.'public/top.php';?>

<div class="content">
  <?php require APP_ROOT.'public/left.php';?>
  <div class="right_panel" id="right">

<a href="javascript:;" onclick="dialog_div(800,500,'admin.php?m=permissions&a=add&ajax=1&time=<?php echo time()?>')" class="button">添加内容</a>

<table class="tables" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="title">
    <td height="30">&nbsp;&nbsp;用户名(点击修改)</td>
    <td>权限管理</td>
    <td>页面权限</td>
    <td>状态</td>
    <td>操作</td>
  </tr>
<?php
$user = M('user')->select(); foreach($user as $k=>$v) { ?>
  <tr class="row_list">
    <td height="30">&nbsp;&nbsp;<a href="javascript:;"  onclick="dialog_div(800,400,'admin.php?m=permissions&a=edit&user_id=<?php echo $v['user_id'];?>')"><?php echo $v['name']?></a></td>
    <td><a href="javascript:;"  onclick="dialog_div(800,400,'admin.php?m=permissions&a=permissions_edit&user_id=<?php echo $v['user_id'];?>')">权限管理</a></td>
    <td><a href="javascript:;"  onclick="dialog_div(800,400,'admin.php?m=permissions&a=page_edit&user_id=<?php echo $v['user_id'];?>')">页面权限</a></td>
    <td><a href="javascript:;"  onclick="dialog_div(800,400,'admin.php?m=permissions&a=edit&user_id=<?php echo $v['user_id'];?>')">状态</a></td>
    <td><a  href="javascript:;" onclick="if(confirm('确定删除吗!')){ajax_list('admin.php?m=classify&a=del_save&classify_id=<?php echo $v['classify_id'];?>','admin.php?m=classify&a=index&admin_classify_id=3')}" class="delete">删除</a></td>
  </tr>
<?php }?>
</table>




</div>
</div>
<?php require APP_ROOT.'public/bottom.php';?>