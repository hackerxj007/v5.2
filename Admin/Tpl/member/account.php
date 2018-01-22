<?php require APP_ROOT.'public/top.php';?>
<div class="content">
  <?php require APP_ROOT.'public/left.php';?>
  <?php $member_id=pg('member_id');
	$type_id=51;
	$data=pg('data');
	$search_type=pg('search_type');
	$search=pg('search');
	$lt_date=pg('lt_date');
	$gt_date=pg('gt_date');
	if($search_type=='member_id')
	{
		$data[$search_type]=$search;
	}
	else if($search!='')
	{
		$member=M('member')->where(array($search_type=>$search))->field('member_id')->find();
		$data['member_id']=array('in',$member);
	}
	if($member_id!='')
	{
		$where['member_id']=$member_id;
		$search=$member_id;
	}
	if($lt_date && $gt_date)
	{
		$where['date']=array(array('gt',strtotime($gt_date)),array('lt',strtotime($lt_date)));
	}
	else if($lt_date)
	{
		$where['date']=array('lt',strtotime($lt_date));
	}
	else if($gt_date)
	{
		$where['date']=array('gt',strtotime($gt_date));
	}
	
	foreach($data as $k=>$v)
	{
		if($v)$where[$k]=$v;
	}
	?>
  

  <div class="right_panel" id="right">
    <a href="javascript:;" onclick="dialog_div(600,400,'admin.php?m=member&a=add_account&ajax=1&member_id=<?php echo $member_id; ?>&time=<?php echo time() ?>')" class="button">财务操作</a> 
    
<form action="admin.php?m=member&a=account" method="post">
        <select id="search_type" name="search_type">
          <option value="member_id"<?php if($search_type=='member_id')echo ' selected="selected"';?>>会员ID</option>
          <option value="username"<?php if($search_type=='username')echo ' selected="selected"';?>>用户名</option>
          <option value="qq"<?php if($search_type=='qq')echo ' selected="selected"';?>>QQ</option>
          <option value="mobile"<?php if($search_type=='mobile')echo ' selected="selected"';?>>手机</option>
        </select>
        <input id="search" name="search" type="text" value="<?php echo $search;?>"/>
        
        筛选:
        <select id="amount_type" name="data[amount_type]">
          <option value="" selected>财务类型</option>
          <?php $input=M('input')->where(array('input_pid'=>425))->select();foreach($input as $k=>$v){?>
          <option value="<?php echo $v['input_id'];?>"<?php if($data['amount_type']==$v['input_id'])echo ' selected="selected"';?>><?php echo $v['input_name'];?></option>
          <?php }?>
        </select>
        <select id="state" name="data[state]">
          <option value="" selected>状态</option>
          <?php $input=M('input')->where(array('input_pid'=>430))->select();foreach($input as $k=>$v){?>
          <option value="<?php echo $v['input_id'];?>"<?php if($data['state']==$v['input_id'])echo ' selected="selected"';?>><?php echo $v['input_name'];?></option>
          <?php }?>
        </select>

        起始日期:
        <input type="text"  class="laydate-input"  id="start_time" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?php echo $gt_date;?>" size="25" name="gt_date" />
        终止日期:
        <input type="text" class="laydate-input" id="end_time" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" onkeyup="checkDate()"  value="<?php echo $lt_date;?>" size="25" name="lt_date" />
        <input type="submit" class="submit" value="搜索"/>
      </form>
      
       
    <table class="tables" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="title">
        <td height="30">&nbsp;财务ID</td>
        <td>会员ID</td>
        <td>用户名</td>
        <td>财务类型</td>
        <td>交易金额</td>
        <td>余额</td>
        <td>备注</td>
        <td>状态</td>
        <td>操作时间</td>
        <td>操作</td>
      </tr>
      <?php
			$perpage=20;
			$offset=($p-1)*$perpage;//偏移量
			$account=M('account')->where($where)->limit($offset,$perpage)->order('account_id desc')->select();
			//echo M()->getlastsql();
			$total_num=M('account')->where($where)->count();
			foreach($account as $key=>$v){
		?>
      <tr>
        <td height="35">&nbsp;<?php echo $v['account_id'];?></td>
        <td><?php echo $v['member_id'];?></td>
        <td><?php echo M('member')->where(array('member_id'=>$v['member_id']))->getField('username');?></td>
        <td><?php echo M('input')->where(array('input_value'=>$v['amount_type'],'input_pid'=>425))->getField('input_name');?></td>
        <td><?php
		if($v['amount_type']==1)
		{
			 echo "+".$v['amount'];
		}
		else
		{
			echo "-".$v['amount'];
		}?></td>
        <td><?php echo $v['balance'];?></td>
        <td><?php echo $v['note'];?></td>
        <td><?php $state=M('input')->where(array('input_value'=>$v['state'],'input_pid'=>430))->find();?>
            	<span style="color:<?php echo $state['color'];?>"><?php echo $state['input_name'];?></span>
        </td>
        <td><?php echo cover_time($v['date'],'Y-m-d H:i:s');?></td>
        <td><a  href="javascript:;" onclick="dialog_div(600,400,'admin.php?m=cms&a=edit&ajax=1&type_id=<?php echo $type_id;?>&table_name=account&content_id=<?php echo $v['account_id'];?>')">修改</a></td>
      </tr>
      <?php }?>
    </table>
    <?php require APP_ROOT.'public/page.php';?>
</div>
</div>
<?php require APP_ROOT.'public/bottom.php';?>
