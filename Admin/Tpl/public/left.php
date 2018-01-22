<?php if($function_switch['left_navigation']==2){?>
<div class="left_panel" id="left">
  <div class="menu">
    <ul>
      <?php 
$list = M('classify')->where(array('level_id'=>2))->order('date asc')->select();
foreach($list as $k=>$v){
	if($v['type_id']!= 13){
?>
      <li class="list-main"><a href="admin.php?m=content&a=index&type_id=<?php echo $v['type_id']?>&classify_id=<?php echo $v['classify_id']?>"><span><?php echo $v['classify_name'];?></span></a></li>
      <?php
	}else{?>
	<li class="list-main"><a><span><?php echo $v['classify_name'];?></span></a></li>
	<?php
	}
$classify = M('classify')->where(array('classify_pid'=>$v['classify_id']))->select();
foreach($classify as $key=>$val){
	if($val['type_id']!= 13){
?>
      <li><a href="admin.php?m=content&a=index&type_id=<?php echo $val['type_id']?>&classify_id=<?php echo $val['classify_id']?>"><?php echo $val['classify_name'];?></a></li>
		<?php  } else {?>
      <li><a><?php echo $val['classify_name'];?></a></li>
	<?php } } } ?>
    </ul>
  </div>
</div>
<?php }?>