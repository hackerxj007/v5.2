<?php require APP_ROOT.'public/top.php';?>
<script type="text/javascript">
$('#form_menu0').ajaxForm({ success:function showResponse(responseText)  {
	alert(responseText);
	msg_show(responseText,500000);
	goto_url("");
}});
</script>

<div class="content">
  <?php require APP_ROOT.'public/left.php';?>
  <?php
	$data=pg('data');
	$search_type=pg('search_type');
	$search=trim(pg('search'));
	$lt_date=pg('lt_date');
	$gt_date=pg('gt_date');
	$data[$search_type]=$search;
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
	$state=pg('state');
	?>
  <div class="right_panel" id="right">
    <form action="admin.php?m=order&a=index&admin_classify_id=21" method="post">
      <select id="search_type" name="search_type">
        <option value="goods_name"<?php if($search_type=='goods_name')echo ' selected="selected"';?>>宝贝名称</option>
        <option value="consignee"<?php if($search_type=='consignee')echo ' selected="selected"';?>>收货人</option>
        <option value="phone"<?php if($search_type=='phone')echo ' selected="selected"';?>>电话</option>
        <option value="order_number"<?php if($search_type=='order_number')echo ' selected="selected"';?>>订单号</option>
      </select>
      <input id="search" name="search" type="text" value="<?php echo $search;?>"/>
      起始日期:
      <input type="text"  class="laydate-input"  id="start_time" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?php echo $gt_date;?>" size="25" name="gt_date" />
      终止日期:
      <input type="text" class="laydate-input" id="end_time" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" onkeyup="checkDate()"  value="<?php echo $lt_date;?>" size="25" name="lt_date" />
      <input type="submit" class="submit" value="搜索"/>
      <div class="remind clearfix">
        <p><em></em>提醒:</p>
        <ul>
          <?php
					$dfk_count=M('order')->where(array('state'=>1))->count();//待付款
					$dfh_count=M('order')->where(array('state'=>2))->count();//待发货
					$dsh_count=M('order')->where(array('state'=>3))->count();//待收货
					?>
          <li><a href="admin.php?m=order&a=index&state=1">待付款订单 (<?php echo $dfk_count;?>)</a></li>
          <li><a href="admin.php?m=order&a=index&state=2">待发货订单(<?php echo $dfh_count;?>) </a></li>
          <li><a href="admin.php?m=order&a=index&state=3">已发货订单 (<?php echo $dsh_count;?>)</a></li>
        </ul>
      </div>
    </form>
    <form method="post" id="form_menu" action="admin.php?m=order&a=batch_edit_save" >
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="ordertable">
        <thead>
          <tr class="title">
            <th height="30"><input name="" type="checkbox" class="checkbox" onclick="SelectAll('order_id[]')" value="" />
              全选 订单商品</th>
            <th>收货信息</th>
            <th>单价</th>
            <th>订单金额</th>
            <th class="th5">操作</th>
          </tr>
        </thead>
        <?php
					$perpage=20;
					$offset=($p-1)*$perpage;//偏移量
					if($search_type==''&& empty($gt_date) && empty($gt_date))
					{
						
						$total_num= M('order')->where($where)->count();
						$order=M('order')->where($where)->limit($offset,$perpage)->order('date desc')->select();
					}
					else
					{
						
						if($gt_date)
						{
							$w_date=' and o.date >'.strtotime($gt_date);
						}
						if($lt_date)
						{
							$w_date.=' and o.date <'.strtotime($lt_date);
						}
						if( !$gt_date && !$lt_date){
							$w_date='';
						}
						$key=array_keys($data);
						if($key[0]=='goods_name'){
							$total_num= M()->table('index_order o,index_order_goods og')->where('o.order_id = og.order_id and og.'.$key[0].' like "%'.$data[$key[0]].'%" '.$w_date)->count();
						
						$order = M()->table('index_order o,index_order_goods og')->where('o.order_id = og.order_id and og.'.$key[0].' like "%'.$data[$key[0]].'%" '.$w_date)->select();
						}else{
						$total_num= M()->table('index_order o,index_order_goods og')->where('o.order_id = og.order_id and o.'.$key[0].' like "%'.$data[$key[0]].'%" '.$w_date)->count();
						
						$order = M()->table('index_order o,index_order_goods og')->where('o.order_id = og.order_id and o.'.$key[0].' like "%'.$data[$key[0]].'%" '.$w_date)->select();
						}
					}
					foreach($order as $k=>$v)
					{
					 ?>
        <tbody>
          <tr height="30">
            <td colspan="4" class="info"><input name="order_id[]" type="checkbox" value="<?php echo $v['order_id']?>"/>
              <?php echo date('Y-m-d H:i:s',$v['date']) ?> <span>订单号：<a href="#"><?php echo $v['order_number'] ?></a></span></td>
            <td class="info"><a  href="javascript:;" onclick="if(confirm('确定删除吗!')){ajax_list('admin.php?m=order&a=del_save&order_id=<?php echo $v['order_id'];?>','')}" class="delete">删除订单</a></td>
          </tr>
          <?php
						$order_goods=M('order_goods')->where(array('order_id'=>$v['order_id']))->select();
						foreach($order_goods as $og_k=>$og_v)
						{
						?>
          <tr>
            <td class="td1"><a href="index.php?m=goods&a=details&content_id=<?php echo $og_v['goods_id'];?>" class="fl"><img src="<?php echo $og_v['goods_img']?>" width="100" height="80"/></a>
              <div class="gsattr"> <a href="index.php?m=goods&a=details&goods_id=<?php echo $og_v['goods_id'];?>"><?php echo $og_v['goods_name'] ?></a>
                <div class="red">
				<?php
		 $name=unserialize($og_v['name']);
		 $value=unserialize($og_v['value']);
		   foreach($name as $k2=>$v2)
		   {
			   echo $v2.':'.$value[$k2].'<br>';
		   }
		   ?>
           </div>
              </div>
              
              </td>
            <td class="td2"><div class="consignee">
                <?php       
        $goods_attribute_array=unserialize($og_v['goods_attribute_array']);
        $goods_attribute_value_array=unserialize($og_v['goods_attribute_value_array']);
        foreach($goods_attribute_array as $k_gaa=>$v_gaa)
        {
            echo $v_gaa['name'].':'.$goods_attribute_value_array[$v_gaa[id]]['name'].'&nbsp;&nbsp;&nbsp;&nbsp;';
		}?>
                <?php echo $v['consignee'] ?> <?php echo $v['phone'] ?><br />
                <?php echo $v['address'] ?></div></td>
            <td class="td3">¥<?php echo $og_v['price'] ?> X <?php echo $og_v['number']; ?></td>

            <?php if($og_k==0){?>
            <td rowspan="<?php echo count($order_goods);?>">总价：<b>¥<?php echo $v['price'];?></b></td>
            <td class="td5" rowspan="<?php echo count($order_goods);?>"><?php $input=M('input')->where(array('input_value'=>$v['state'],'input_pid'=>380))->field('input_name,color')->find(); ?>
              <span style="color:<?php echo $input['color'];?>; font-weight:600;"><?php echo $input['input_name'];?></span> <br />
              <a href="javascript:;" onclick="dialog_div(1050,600,'admin.php?m=order&a=details&order_id=<?php echo $v['order_id'] ?>&ajax=1&time=<?php echo time()?>')">订单详情</a> <a href="javascript:;" onclick="dialog_div(800,600,'admin.php?m=cms&a=edit&content_id=<?php echo $v['order_id'] ?>&table_name=order&type_id=47&ajax=1&time=<?php echo time()?>')">修改订单信息</a> <?php echo $v['note'];?>
              <?php if($v['state']>=1){?>
              <a href="javascript:;" style="color:red; display:none;" onclick="dialog_div(700,600,'admin.php?m=order&a=express&typeCom=<?php echo $v['shipping_id']?>&typeNu=<?php echo $v['courier_number']?>')">查看物流信息</a>
              <?php }?></td>
            <?php }?>
          </tr>
          <?php }?>
        </tbody>
        <?php }?>
      </table>
      <div class="content_btn_w"> &nbsp;
        <select class="shared_select" name="batch_delete_id" id="batch_delete_id">
          <option value="">批量删除</option>
          <option value="1">确定删除</option>
        </select>
	<?php if($function_switch['xls_order']==2){?>
        <select class="shared_select" name="export_order" id="export_order">
          <option value="">导出订单</option>
          <option value="1">确定导出</option>
        </select>
	<?php }?>
        <input name="" class="submit" type="submit" value="提交" />
      </div>
    </form>
    <?php require APP_ROOT.'public/page.php';?>
  </div>
</div>
<?php require APP_ROOT.'public/bottom.php';?>
