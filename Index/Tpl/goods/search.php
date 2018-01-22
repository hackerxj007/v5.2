<?php require APP_ROOT.'public/top.php';?>

<div class="g00002">
  <div class="g00003" id="left">
    <?php require APP_ROOT.'public/left.php';?>
  </div>
  <div class="g00004" id="right">
        <?php require APP_ROOT.'public/right.php';?>    
      <div class="f14466174187">
        <ul class="f14466174188">
	<?php $perpage=12;$offset=($p-1)*$perpage;
	$goods = M('goods')->where(array('goods_name'=>array('like','%'.$search.'%')))->limit($offset,$perpage)->select();
	$total_num=M('goods')->where(array('goods_name'=>array('like','%'.$search.'%')))->count();
	foreach($goods as $k=>$v){
		?>
          <li class="f14464848057">
          <div class="f14464848058"> <a class="f14464848059" href="<?php echo content_url($v['type_id'],$v['goods_id']) ?>"><img class="f144648480510" src="<?php echo $v['goods_img'];?>" /></a></div>
          <div class="f144648480511"> <a class="f144648480512" href="<?php echo content_url($v['type_id'],$v['goods_id']) ?>"><?php echo $v['goods_name'] ?></a> </div>
        </li>
          <?php }?>
        </ul>
      </div>
    <?php require APP_ROOT.'public/page.php';?>
    </div>
</div>
<?php require APP_ROOT.'public/bottom.php';?>
