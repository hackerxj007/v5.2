<?php if (!defined('THINK_PATH')) exit(); require APP_ROOT.'public/top.php';?>

<div class="content">
  <?php require APP_ROOT.'public/left.php';?>
  <div class="right_panel" id="right"> <a href="javascript:;" onclick="dialog_div(500,300,'admin.php?m=type&a=add&time=<?php echo time()?>')" class="button">添加表单</a>
    <table class="tables" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="title">
        <td width="7%" height="30"><input name="" class="checkbox" type="checkbox" value="" />
          全选</td>
        <td>表单类型名称</td>
        <td>表名</td>
        <td>页面名</td>
        <td>显示</td>
        <td>表单设置</td>
        <td>内容添加</td>
        <td>操作</td>
      </tr>
      <?php  $list=M('classify_type')->select(); foreach($list as $k=>$v){ ?>
      <tr>
        <td height="30"><input name="type_id[]" class="checkbox" type="checkbox" value="<?php echo $v['type_id'];?>" />
          <?php echo $v['type_id'];?></td>
        <td><input name="type_name[]" type="text" value="<?php echo $v['type_name'];?>" size="10" /></td>
        <td><input name="table_name[]" type="text" value="<?php echo $v['table_name'];?>" size="10" /></td>
        <td><input name="page_name[]" type="text" value="<?php echo $v['page_name'];?>" size="10" /></td>
        <td><a  href="javascript:;" onclick="if(confirm('确定执行吗!')){ajax_list('admin.php?m=type&a=show_save&type_id=<?php echo $v['type_id'];?>&show_id=<?php echo $v['show_id'];?>','admin.php?m=type&a=index&admin_classify_id=4&time=<?php echo time();?>')}"><?php echo $v['show_id']==2? '开':'<font color="#FF0000">关</font>';?></a></td>
        <td><a class="con_list" href="admin.php?m=input&a=index&type_id=<?php echo $v['type_id'];?>">[表单设置]</a></td>
        <td><a href="admin.php?m=cms&a=index&type_id=<?php echo $v['type_id'];?>">[内容列表]</a></td>
        <td><a  href="javascript:;" onclick="if(confirm('确定删除吗!')){ajax_list('admin.php?m=type&a=del_save&type_id=<?php echo $v['type_id'];?>','admin.php?m=type&a=index&admin_classify_id=4&time=<?php echo time();?>')}" class="delete">[删除]</a></td>
      </tr>
      <?php }?>
    </table>
  </div>
</div>
<?php require APP_ROOT.'public/bottom.php';?>