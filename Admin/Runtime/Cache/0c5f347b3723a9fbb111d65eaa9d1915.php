<?php if (!defined('THINK_PATH')) exit(); require APP_ROOT.'public/top.php';?>
<script type="text/javascript">
$('#form_menu').ajaxForm({ success:function showResponse(responseText)  { 
	msg_show(responseText,500000);
	goto_url("");
}});
$('#form_menu1').ajaxForm({ success:function showResponse(responseText)  { 
	msg_show(responseText,500000);
	goto_url("");
}});
$('#form_menu2').ajaxForm({ success:function showResponse(responseText)  { 
	msg_show(responseText,500000);
	goto_url("");
}});
</script>

<div class="content">
  <?php require APP_ROOT.'public/left.php';?>
  <div class="right_panel" id="right">
<?php $list = M('site')->where(array('version_id'=>session('version_id')))->find(); $type_id = 57; $table_name = M('classify_type')->where(array('type_id' => $type_id))->getField('table_name'); ?>
    
    
    
    
    
    <table class="tables" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr class="title">
          <td height="30">&nbsp;常用代码</td>
          <td></td>
        </tr>
     
        <tr class="row">
          <td>&nbsp;查询当前分类所以子类内容</td>
          <td>&lt;?php $list = M()->table('index_goods c left join index_relevance r on r.content_id = c.goods_id')->where(array('r.classify_id'=>array('in',get_child_classify(2))))->order('c.date desc')->select();?></td>
          </tr>
      </table>
      <br>
    <form action="admin.php?m=cms&a=edit_save" method="post" enctype="multipart/form-data" id="form_menu">
      <input name="type_id" type="hidden" value="57" />
      <input name="content_id" type="hidden" value="1" />
      <table class="tables" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr class="title">
          <td height="30">&nbsp;扩展功能开关</td>
          <td></td>
        </tr>
        <?php
$list = M('function_switch')->where(array('function_switch_id' => 1))->find(); $input = M('input')->where(array('type_id'=>57,'edit_switch'=>2,'input_pid'=>array('exp','is null')))->order('date asc')->select(); foreach($input as $k=>$v){ ?>
        <tr class="row">
          <td>&nbsp;<?php echo $v['input_name']?></td>
          <td><?php
 switch($v['input_type_id']){ case 1: if($v['field_name']=='password' && $type_id==46) { $list[$v['field_name']]=''; } ?>
            <input name="data[<?php echo $v['field_name'];?>]" type="text" id="<?php echo $v['field_name'];?>" value="<?php echo $list[$v['field_name']];?>" size="<?php echo $v['edit_size'];?>" />
            <?php
 break; case 2: ?>
            <textarea name="data[<?php echo $v['field_name'];?>]" cols="60" rows="<?php echo $v['edit_size'];?>" id="<?php echo $v['field_name'];?>"><?php echo $list[$v['field_name']];?></textarea>
            <?php
 break; case 3: echo fckeditor('data['.$v['field_name'].']',$v['edit_size'],$list[$v['field_name']]); break; case 4: ?>
            <?php
 $input_p = M('input')->where(array('input_pid'=>$v['input_id']))->select(); $valarr=unserialize($list[$v['field_name']]); foreach($input_p as $k2=>$v2){ ?>
            <label>
              <input type="checkbox" name="data[<?php echo $v['field_name'];?>][]"<?php if(in_array($v2['input_value'],$valarr))echo ' checked="checked"';?> value="<?php echo $v2['input_value']?>" />
              <?php echo $v2['input_name'];?> </label>
            <?php } ?>
            <?php
 break; case 5: ?>
            <?php
 $input_p = M('input')->where(array('input_pid'=>$v['input_id']))->select(); foreach($input_p as $k2=>$v2){ ?>
            <label>
              <input type="radio" name="data[<?php echo $v['field_name'];?>]" value="<?php echo $v2['input_value']?>" <?php if($list[$v['field_name']]==$v2['input_value'])echo ' checked="checked"';?>/>
              <?php echo $v2['input_name'];?> </label>
            &nbsp;
            <?php } ?>
            <?php
 break; case 6: ?>
            <select name="data[<?php echo $v['field_name'];?>]" id="<?php echo $v['field_name'];?>">
              <option value="0">请选择</option>
              <?php
 $input_p = M('input')->where(array('input_pid'=>$v['input_id']))->select(); foreach($input_p as $k2=>$v2){ ?>
              <option value="<?php echo $v2['input_value'];?>"<?php if($list[$v['field_name']]==$v2['input_value'])echo ' selected="selected"';?>><?php echo $v2['input_name'];?></option>
              <?php } ?>
            </select>
            <?php
 break; case 7: ?>
            <input name="<?php echo $v['field_name'];?>" id="<?php echo $v['field_name'];?>" type="file" />
            <?php
 if($list[$v['field_name']]!='') { echo '<a href="'.$list[$v['field_name']].'" target="_blank"><img src="'.$list[$v['field_name']].'" width="50" height="25"/></a>'; ?>
            <a href="javascript:;" onclick="if(confirm('确定删除吗!')){delete_img('admin.php?m=content&a=delete_img&content_id=<?php echo $content_id;?>&table_name=<?php echo $table_name;?>&type_id=<?php echo $type_id;?>&field_name=<?php echo $v['field_name'];?>',$(this))}" class="delete">删除</a>
            <?php
 } break; case 8: ?>
            <input name="data[<?php echo $v['field_name'];?>]" type="text" class="laydate-input" id="<?php echo $v['field_name'];?>" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?php echo cover_time($list[$v['field_name']],'Y-m-d H:i:s')?>" size="<?php echo $v['edit_size'];?>" />
            <?php
 break; } ?>
            <?php echo $v['note'];?></td>
        </tr>
        <?php }?>
        <tr>
          <td>&nbsp;
            <input name="" type="submit" class="submit" value="确认无误，提交" /></td>
        </tr>
      </table>
    </form>
    
    
    
        
    <div class="codehtml"></div>
    <form action="admin.php?m=cms&a=edit_save" method="post" enctype="multipart/form-data" id="form_menu1">
      <input name="type_id" type="hidden" value="54" />
      <input name="content_id" type="hidden" value="1" />
      <table class="tables" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr class="title">
          <td height="30">&nbsp;微信支付配置</td>
          <td></td>
        </tr>
        <?php
$list = M('wxpay')->where(array('wxpay_id' => 1))->find(); $input = M('input')->where(array('type_id'=>54,'edit_switch'=>2,'input_pid'=>array('exp','is null')))->order('date asc')->select(); foreach($input as $k=>$v){ ?>
        <tr class="row">
          <td>&nbsp;<?php echo $v['input_name']?></td>
          <td><?php
 switch($v['input_type_id']){ case 1: if($v['field_name']=='password' && $type_id==46) { $list[$v['field_name']]=''; } ?>
            <input name="data[<?php echo $v['field_name'];?>]" type="text" id="<?php echo $v['field_name'];?>" value="<?php echo $list[$v['field_name']];?>" size="<?php echo $v['edit_size'];?>" />
            <?php
 break; case 2: ?>
            <textarea name="data[<?php echo $v['field_name'];?>]" cols="60" rows="<?php echo $v['edit_size'];?>" id="<?php echo $v['field_name'];?>"><?php echo $list[$v['field_name']];?></textarea>
            <?php
 break; case 3: echo fckeditor('data['.$v['field_name'].']',$v['edit_size'],$list[$v['field_name']]); break; case 4: ?>
            <?php
 $input_p = M('input')->where(array('input_pid'=>$v['input_id']))->select(); $valarr=unserialize($list[$v['field_name']]); foreach($input_p as $k2=>$v2){ ?>
            <label>
              <input type="checkbox" name="data[<?php echo $v['field_name'];?>][]"<?php if(in_array($v2['input_value'],$valarr))echo ' checked="checked"';?> value="<?php echo $v2['input_value']?>" />
              <?php echo $v2['input_name'];?> </label>
            <?php } ?>
            <?php
 break; case 5: ?>
            <?php
 $input_p = M('input')->where(array('input_pid'=>$v['input_id']))->select(); foreach($input_p as $k2=>$v2){ ?>
            <label>
              <input type="radio" name="data[<?php echo $v['field_name'];?>]" value="<?php echo $v2['input_value']?>" <?php if($list[$v['field_name']]==$v2['input_value'])echo ' checked="checked"';?>/>
              <?php echo $v2['input_name'];?> </label>
            &nbsp;
            <?php } ?>
            <?php
 break; case 6: ?>
            <select name="data[<?php echo $v['field_name'];?>]" id="<?php echo $v['field_name'];?>">
              <option value="0">请选择</option>
              <?php
 $input_p = M('input')->where(array('input_pid'=>$v['input_id']))->select(); foreach($input_p as $k2=>$v2){ ?>
              <option value="<?php echo $v2['input_value'];?>"<?php if($list[$v['field_name']]==$v2['input_value'])echo ' selected="selected"';?>><?php echo $v2['input_name'];?></option>
              <?php } ?>
            </select>
            <?php
 break; case 7: ?>
            <input name="<?php echo $v['field_name'];?>" id="<?php echo $v['field_name'];?>" type="file" />
            <?php
 if($list[$v['field_name']]!='') { echo '<a href="'.$list[$v['field_name']].'" target="_blank"><img src="'.$list[$v['field_name']].'" width="50" height="25"/></a>'; ?>
            <a href="javascript:;" onclick="if(confirm('确定删除吗!')){delete_img('admin.php?m=content&a=delete_img&content_id=<?php echo $content_id;?>&table_name=<?php echo $table_name;?>&type_id=<?php echo $type_id;?>&field_name=<?php echo $v['field_name'];?>',$(this))}" class="delete">删除</a>
            <?php
 } break; case 8: ?>
            <input name="data[<?php echo $v['field_name'];?>]" type="text" class="laydate-input" id="<?php echo $v['field_name'];?>" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?php echo cover_time($list[$v['field_name']],'Y-m-d H:i:s')?>" size="<?php echo $v['edit_size'];?>" />
            <?php
 break; } ?>
            <?php echo $v['note'];?></td>
        </tr>
        <?php }?>
        <tr>
          <td>&nbsp;
            <input name="" type="submit" class="submit" value="确认无误，提交" /></td>
        </tr>
      </table>
    </form>
    <div class="codehtml"></div>
    <form action="admin.php?m=cms&a=edit_save" method="post" enctype="multipart/form-data" id="form_menu2">
      <input name="type_id" type="hidden" value="56" />
      <input name="content_id" type="hidden" value="1" />
      <table class="tables" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr class="title">
          <td height="30">&nbsp;支付宝支付配置</td>
          <td></td>
        </tr>
        <?php
$list = M('alipay')->where(array('alipay_id' => 1))->find(); $input = M('input')->where(array('type_id'=>56,'edit_switch'=>2,'input_pid'=>array('exp','is null')))->order('date asc')->select(); foreach($input as $k=>$v){ ?>
        <tr class="row">
          <td>&nbsp;<?php echo $v['input_name']?></td>
          <td><?php
 switch($v['input_type_id']){ case 1: if($v['field_name']=='password' && $type_id==46) { $list[$v['field_name']]=''; } ?>
            <input name="data[<?php echo $v['field_name'];?>]" type="text" id="<?php echo $v['field_name'];?>" value="<?php echo $list[$v['field_name']];?>" size="<?php echo $v['edit_size'];?>" />
            <?php
 break; case 2: ?>
            <textarea name="data[<?php echo $v['field_name'];?>]" cols="60" rows="<?php echo $v['edit_size'];?>" id="<?php echo $v['field_name'];?>"><?php echo $list[$v['field_name']];?></textarea>
            <?php
 break; case 3: echo fckeditor('data['.$v['field_name'].']',$v['edit_size'],$list[$v['field_name']]); break; case 4: ?>
            <?php
 $input_p = M('input')->where(array('input_pid'=>$v['input_id']))->select(); $valarr=unserialize($list[$v['field_name']]); foreach($input_p as $k2=>$v2){ ?>
            <label>
              <input type="checkbox" name="data[<?php echo $v['field_name'];?>][]"<?php if(in_array($v2['input_value'],$valarr))echo ' checked="checked"';?> value="<?php echo $v2['input_value']?>" />
              <?php echo $v2['input_name'];?> </label>
            <?php } ?>
            <?php
 break; case 5: ?>
            <?php
 $input_p = M('input')->where(array('input_pid'=>$v['input_id']))->select(); foreach($input_p as $k2=>$v2){ ?>
            <label>
              <input type="radio" name="data[<?php echo $v['field_name'];?>]" value="<?php echo $v2['input_value']?>" <?php if($list[$v['field_name']]==$v2['input_value'])echo ' checked="checked"';?>/>
              <?php echo $v2['input_name'];?> </label>
            &nbsp;
            <?php } ?>
            <?php
 break; case 6: ?>
            <select name="data[<?php echo $v['field_name'];?>]" id="<?php echo $v['field_name'];?>">
              <option value="0">请选择</option>
              <?php
 $input_p = M('input')->where(array('input_pid'=>$v['input_id']))->select(); foreach($input_p as $k2=>$v2){ ?>
              <option value="<?php echo $v2['input_value'];?>"<?php if($list[$v['field_name']]==$v2['input_value'])echo ' selected="selected"';?>><?php echo $v2['input_name'];?></option>
              <?php } ?>
            </select>
            <?php
 break; case 7: ?>
            <input name="<?php echo $v['field_name'];?>" id="<?php echo $v['field_name'];?>" type="file" />
            <?php
 if($list[$v['field_name']]!='') { echo '<a href="'.$list[$v['field_name']].'" target="_blank"><img src="'.$list[$v['field_name']].'" width="50" height="25"/></a>'; ?>
            <a href="javascript:;" onclick="if(confirm('确定删除吗!')){delete_img('admin.php?m=content&a=delete_img&content_id=<?php echo $content_id;?>&table_name=<?php echo $table_name;?>&type_id=<?php echo $type_id;?>&field_name=<?php echo $v['field_name'];?>',$(this))}" class="delete">删除</a>
            <?php
 } break; case 8: ?>
            <input name="data[<?php echo $v['field_name'];?>]" type="text" class="laydate-input" id="<?php echo $v['field_name'];?>" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?php echo cover_time($list[$v['field_name']],'Y-m-d H:i:s')?>" size="<?php echo $v['edit_size'];?>" />
            <?php
 break; } ?>
            <?php echo $v['note'];?></td>
        </tr>
        <?php }?>
        <tr>
          <td>&nbsp;
            <input name="" type="submit" class="submit" value="确认无误，提交" /></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php require APP_ROOT.'public/bottom.php';?>