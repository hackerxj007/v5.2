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
    <form method="post" id="form_menu" action="admin.php?m=classify&a=batch_edit_save" >
      <table class="tables" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr class="title">
          <td height="30">&nbsp;&nbsp;&nbsp;&nbsp;id</td>
          <td>分类名称(点击修改)</td>
          <td>类型</td>
          <td>添加子分类</td>
          <td>添加内容</td>
          <td>内容列表</td>
          <td>排序</td>
	<?php $user=session('user'); if($user['user_id']==1){?>
          <td>隐删除</td>
	<?php }?>
          <td>删除</td>
        </tr>
         <?php
		$classify = M('classify')->field('classify_id,level_id,classify_pid,type_id,classify_name,date,is_delete,classify_img,note,page_img')->where(array('classify_id'=>$recursive_classify_id,'level_id'=>array('gt',1)))->order('date asc')->select();
foreach($classify as $k=>$v){
?>
        <tr class="row_list">
          <td height="30">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $v['classify_id']?>
            <input name="classify_id[]" type="hidden" value="<?php echo $v['classify_id']?>" /></td>
          <td><?php for($i=3;$i<=$v['level_id'];$i++)echo "&nbsp;&nbsp;&nbsp;";?>
            <a href="javascript:;"  onclick="dialog_div(900,600,'admin.php?m=classify&a=edit&classify_id=<?php echo $v['classify_id'];?>')"><?php echo $v['classify_name']?></a>
            <?php if($v['note']!='')echo '<span class="classify_note">['.$v['note'].']</span>';?>
            <?php if($v['classify_img']!='')echo '<a href="'.$v['classify_img'].'" target="_blank"><img src="'.$v['classify_img'].'" width="50" height="20"/></a>';?>
            <?php if($v['page_img']!='')echo '<a href="'.$v['page_img'].'" target="_blank"><img src="'.$v['page_img'].'" width="50" height="20"/></a>';?>
            </td>
          <td><?php
$type = M('classify_type')->where(array('type_id'=>$v['type_id']))->find();
echo $type['type_name'];
	?></td>
          <td><a href="javascript:;" onclick="dialog_div(900,600,'admin.php?m=classify&a=add&classify_id=<?php echo $v['classify_id'];?>&time=<?php echo time();?>')">添加子分类</a></td>
          <td><?php if($v['type_id']!= 13){?>
            <a href="javascript:;" onclick="dialog_div(900,600,'admin.php?m=content&a=add&type_id=<?php echo $v['type_id'];?>&classify_id=<?php echo $v['classify_id'];?>&time=<?php echo time();?>')">添加内容</a>
            <?php }?></td>
          <?php $count= M('relevance')->where(array('classify_id'=>$v['classify_id']))->count();
	?>
          <td><?php if($v['type_id']!= 13){?>
            <a class="con_list" href="admin.php?m=content&a=index&type_id=<?php echo $v['type_id']?>&classify_id=<?php echo $v['classify_id']?>">内容列表(<?php echo $count ;?>)</a>
            <?php }?></td>
          <td><input name="data[date][]" type="text" value="<?php echo cover_time($v['date'],'Y-m-d H:i:s');?>" size="20" /></td>
	<?php $user=session('user'); if($user['user_id']==1){?>
          <td>
          <select name="data[is_delete][]">
              <?php
		$input_p = M('input')->where(array('input_pid'=>351))->select();
		foreach($input_p as $k2=>$v2){
		?>
              <option value="<?php echo $v2['input_value'];?>"<?php if($v['is_delete']==$v2['input_value'])echo ' selected="selected"';?>><?php echo $v2['input_name'];?></option>
              <?php } ?>
            </select></td>
            <?php }?>
          <td><?php $classify = M('classify')->where(array('classify_pid'=>$v['classify_id']))->find();
	if(empty($classify)&&$count==0&&$v['is_delete']!=2){?>
            <a  href="javascript:;" onclick="if(confirm('确定删除吗!')){ajax_list('admin.php?m=classify&a=del_save&classify_id=<?php echo $v['classify_id'];?>','admin.php?m=classify&a=index&admin_classify_id=3')}" class="delete">删除</a>
            <?php }?></td>
        </tr>
	<?php }?>
        
       <?php
global $list;
$list = M('classify')->field('classify_id,level_id,classify_pid,type_id,classify_name,date,is_delete,classify_img,note,page_img')->where(array('version_id'=>$version_id))->order('date asc')->select();
function recursive_classify($classify_pid='1')
{
	global $list;
	foreach($list as $k=>$v)
	{
		if($v['classify_pid']==$classify_pid)
		{
?>
        <tr class="row_list">
          <td height="30">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $v['classify_id']?>
            <input name="classify_id[]" type="hidden" value="<?php echo $v['classify_id']?>" /></td>
          <td><?php for($i=3;$i<=$v['level_id'];$i++)echo "&nbsp;&nbsp;&nbsp;";?>
            <a href="javascript:;"  onclick="dialog_div(900,600,'admin.php?m=classify&a=edit&classify_id=<?php echo $v['classify_id'];?>')"><?php echo $v['classify_name']?></a>
            <?php if($v['note']!='')echo '<span class="classify_note">['.$v['note'].']</span>';?>
            <?php if($v['classify_img']!='')echo '<a href="'.$v['classify_img'].'" target="_blank"><img src="'.$v['classify_img'].'" width="50" height="20"/></a>';?>
            <?php if($v['page_img']!='')echo '<a href="'.$v['page_img'].'" target="_blank"><img src="'.$v['page_img'].'" width="50" height="20"/></a>';?>
            </td>
          <td><?php
$type = M('classify_type')->where(array('type_id'=>$v['type_id']))->find();
echo $type['type_name'];
	?></td>
          <td><a href="javascript:;" onclick="dialog_div(900,600,'admin.php?m=classify&a=add&classify_id=<?php echo $v['classify_id'];?>&time=<?php echo time();?>')">添加子分类</a></td>
          <td><?php if($v['type_id']!= 13){?>
            <a href="javascript:;" onclick="dialog_div(900,600,'admin.php?m=content&a=add&type_id=<?php echo $v['type_id'];?>&classify_id=<?php echo $v['classify_id'];?>&time=<?php echo time();?>')">添加内容</a>
            <?php }?></td>
          <?php $count= M('relevance')->where(array('classify_id'=>$v['classify_id']))->count();
	?>
          <td><?php if($v['type_id']!= 13){?>
            <a class="con_list" href="admin.php?m=content&a=index&type_id=<?php echo $v['type_id']?>&classify_id=<?php echo $v['classify_id']?>">内容列表(<?php echo $count ;?>)</a>
            <?php }?></td>
          <td><input name="data[date][]" type="text" value="<?php echo cover_time($v['date'],'Y-m-d H:i:s');?>" size="20" /></td>
	<?php $user=session('user'); if($user['user_id']==1){?>
          <td>
          <select name="data[is_delete][]">
              <?php
		$input_p = M('input')->where(array('input_pid'=>351))->select();
		foreach($input_p as $k2=>$v2){
		?>
              <option value="<?php echo $v2['input_id'];?>"<?php if($v['is_delete']==$v2['input_id'])echo ' selected="selected"';?>><?php echo $v2['input_name'];?></option>
              <?php } ?>
            </select></td>
            <?php }?>
          <td><?php $classify = M('classify')->where(array('classify_pid'=>$v['classify_id']))->find();
	if(empty($classify)&&$count==0&&$v['is_delete']!=353){?>
            <a  href="javascript:;" onclick="if(confirm('确定删除吗!')){ajax_list('admin.php?m=classify&a=del_save&classify_id=<?php echo $v['classify_id'];?>','admin.php?m=classify&a=index&admin_classify_id=3')}" class="delete">删除</a>
            <?php }?></td>
        </tr>
        <?php
			recursive_classify($v['classify_id']);
		}
	}
}
recursive_classify($recursive_classify_id);
?>
      </table>
      <input name="" type="submit" class="submit" value="提交" />
    </form>
  </div>
</div>
<?php require APP_ROOT.'public/bottom.php';?>
