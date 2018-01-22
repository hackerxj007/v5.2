<?php require APP_ROOT.'public/top.php';?>
<script type="text/javascript">
$('#form_menu').ajaxForm({ success:function showResponse(responseText)  { 
	dialog_div_close('ajax_dialog');
	msg_show(responseText,500000);
	goto_url("admin.php?m=input&a=index&type_id=<?php echo $type_id;?>");
}});
</script>

<div class="content">
  <?php require APP_ROOT.'public/left.php';?>
  <div class="right_panel" id="right"> <a href="javascript:;" onclick="dialog_div(500,300,'admin.php?m=input&a=add&type_id=<?php echo $type_id;?>&time=<?php echo time()?>')" class="button">添加表单</a>
    <form method="post" id="form_menu" action="admin.php?m=input&a=batch_edit_save" >
      <input name="type_id" type="hidden" value="<?php echo $type_id;?>" />
      <table class="tables" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr class="title">
          <td height="30">&nbsp;ID</td>
          <td>名称</td>
          <td></td>
          <td>默认值</td>
          <td>表单提示</td>
          <td>备注</td>
          <td>颜色</td>
          <td>表单名</td>
          <td>必填</td>
          <td>后台</td>
          <td>前台</td>
          <td>价格</td>
          <td>大小</td>
          <td>表单类型</td>
          <td>数据类型</td>
          <td>数据长度</td>
          <td>列表</td>
          <td>列表大小</td>
          <td>排序</td>
          <td>操作</td>
        </tr>
        <?php 
$list = M('input')->where(array('type_id'=>$type_id,'input_pid'=>array('EXP','IS NULL')))->order('date asc')->select();
//echo M()->getLastSql();
foreach($list as $k=>$v){
?>
        <tr>
          <td height="35"><input name="data[input_id][]" type="hidden" value="<?php echo $v['input_id'];?>" />
            &nbsp;<?php echo $v['input_id'];?></td>
          <td><input name="data[input_name][]" type="text" value="<?php echo $v['input_name'];?>" size="10" />
          <input name="data[input_value][]" type="hidden" value="<?php echo $v['input_value'];?>" size="10" /></td>
          <td><?php
	$input_type = M('input_type')->where(array('input_type_id'=>$v['input_type_id'],'is_parent'=>2))->select();
	if(!empty($input_type))

	{?>
            <a href="javascript:;" onclick="dialog_div(500,300,'admin.php?m=input&a=child_add&type_id=<?php echo $type_id;?>&input_pid=<?php echo $v['input_id']?>&time=<?php echo time()?>')">添加</a>
            <?php }	?></td>
          <td><input name="data[default_value][]" type="text" value="<?php echo $v['default_value'];?>" size="10" /></td>
          <td><input name="data[prompt][]" type="text" value="<?php echo $v['prompt'];?>" size="10" /></td>
          <td><input name="data[note][]" type="text" value="<?php echo $v['note'];?>" size="10" /></td>
          <td><input name="data[color][]" type="text" value="<?php echo $v['color'];?>" size="10" /></td>
          <th><input name="data[field_name][]" type="text" value="<?php echo $v['field_name'];?>" size="10" /></th>
          <td><select name="data[required_switch][]">
              <option value="1"<?php if($v['required_switch']==1)echo 'selected="selected"';?>>否</option>
              <option value="2"<?php if($v['required_switch']==2)echo 'selected="selected"';?>>是</option>
            </select></td>
          <td><select name="data[edit_switch][]">
              <option value="1"<?php if($v['edit_switch']==1)echo 'selected="selected"';?>>隐</option>
              <option value="2"<?php if($v['edit_switch']==2)echo 'selected="selected"';?>>显</option>
            </select></td>
          <td><select name="data[show_switch][]">
              <option value="1"<?php if($v['show_switch']==1)echo 'selected="selected"';?>>隐</option>
              <option value="2"<?php if($v['show_switch']==2)echo 'selected="selected"';?>>显</option>
            </select></td>
            <td><select name="data[price_switch][]">
              <option value="1"<?php if($v['price_switch']==1)echo 'selected="selected"';?>>否</option>
              <option value="2"<?php if($v['price_switch']==2)echo 'selected="selected"';?>>是</option>
            </select></td>
          <td><input name="data[edit_size][]" type="text" value="<?php echo $v['edit_size'];?>" size="3" /></td>
          <td><select name="data[input_type_id][]">
              <?php 
$list2 = M('input_type')->select();
foreach($list2 as $k2=>$v2){
?>
              <option value="<?php echo $v2['input_type_id'];?>"<?php if($v['input_type_id']==$v2['input_type_id'])echo 'selected="selected"';?>><?php echo $v2['input_type_name'];?></option>
              <?php }?>
            </select></td>
          <td><select name="data[data_type_id][]">
              <?php 
$list2 = M('data_type')->select();
foreach($list2 as $k2=>$v2){
?>
              <option value="<?php echo $v2['data_type_id'];?>"<?php if($v['data_type_id']==$v2['data_type_id'])echo 'selected="selected"';?>><?php echo $v2['data_type_name'];?></option>
              <?php }?>
            </select></td>
          <td><input name="data[data_length][]" type="text" value="<?php echo $v['data_length'];?>" size="5" /></td>
          <td><select name="data[list_switch][]">
              <option value="1"<?php if($v['list_switch']==1)echo 'selected="selected"';?>>隐</option>
              <option value="2"<?php if($v['list_switch']==2)echo 'selected="selected"';?>>显</option>
            </select></td>
          <td><input name="data[list_size][]" type="text" value="<?php echo $v['list_size'];?>" size="3" /></td>
          <td><input name="data[date][]" type="text" value="<?php echo cover_time($v['date'],'Y-m-d H:i:s');?>" size="20" /></td>
          <td><a  href="javascript:;" onclick="if(confirm('确定删除吗!')){ajax_list('admin.php?m=input&a=del_save&type_id=<?php echo $type_id;?>&input_id=<?php echo $v['input_id'];?>&time=<?php echo time();?>','admin.php?m=input&a=index&type_id=<?php echo $type_id;?>')}" class="delete">[删除]</a></td>
        </tr>
        <?php
  //if(!empty($input_type)){
	$input = M('input')->where(array('input_pid'=>$v['input_id']))->select();
	foreach($input as $k2=>$v2){
  ?>
        <tr>
          <td height="30"></td>
          <td><input name="data[input_id][]" type="hidden" value="<?php echo $v2['input_id'];?>" />
          <input name="data[default_value][]" type="hidden" value="<?php echo $v2['default_value'];?>" />
          <input name="data[prompt][]" type="hidden" value="<?php echo $v2['prompt'];?>" size="10" />
<input name="data[note][]" type="hidden" value="<?php echo $v2['note'];?>" />
<input name="data[field_name][]" type="hidden" value="<?php echo $v2['field_name'];?>" />
<input name="data[required_switch][]" type="hidden" value="1" />
<input name="data[edit_switch][]" type="hidden" value="1" />
<input name="data[show_switch][]" type="hidden" value="1" />
<input name="data[price_switch][]" type="hidden" value="1" />
<input name="data[input_type_id][]" type="hidden" value="1" />
<input name="data[data_type_id][]" type="hidden" value="1" />
<input name="data[list_switch][]" type="hidden" value="1" />
<input name="data[edit_size][]" type="hidden" value="<?php echo $v2['edit_size'];?>" />
<input name="data[data_length][]" type="hidden" value="<?php echo $v2['data_length'];?>" />
<input name="data[list_size][]" type="hidden" value="<?php echo $v2['list_size'];?>" />
          </td>
          <td>&nbsp;<?php echo $v2['input_id'];?>
            <input name="data[input_name][]" type="text" value="<?php echo $v2['input_name'];?>" size="10" /></td>
            <td><input name="data[input_value][]" type="text" value="<?php echo $v2['input_value'];?>" size="10" /></td>            
            <td></td>
            <td></td>
            <td><input name="data[color][]" type="text" value="<?php echo $v2['color'];?>" size="10" /></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          <td><input name="data[date][]" type="text" value="<?php echo cover_time($v2['date'],'Y-m-d H:i:s');?>" size="20" /></td>
          <td><a  href="javascript:;" onclick="if(confirm('确定删除吗!')){ajax_list('admin.php?m=input&a=del_save&input_id=<?php echo $v2['input_id'];?>&type_id=<?php echo $type_id;?>','admin.php?m=input&a=index&type_id=<?php echo $type_id;?>')}" class="delete">[删除]</a></td>
        </tr>
        <?php } //}?>
        <?php }?>
        <tr>
          <td></td>
          <td><input name="" type="submit" class="submit" value="确认无误，提交" /></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php require APP_ROOT.'public/bottom.php';?>
