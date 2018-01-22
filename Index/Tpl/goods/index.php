<?php require APP_ROOT.'public/top.php';?>

<div class="g00002">
  <div class="g00003" id="left">
    <?php require APP_ROOT.'public/left.php';?>
  </div>
  <div class="g00004" id="right">
    <?php require APP_ROOT.'public/right.php';?>
    <div class="f14464848055">
      <ul class="f14464848056">
        <?php $perpage=12;$offset=($p-1)*$perpage;
		$goods = M()->table('index_goods n,index_relevance r')->where('r.classify_id ='.$classify_id.' and r.content_id=n.goods_id')->order('date desc')->limit($offset,$perpage)->select();
		$total_num=M()->table('index_goods n,index_relevance r')->where('r.classify_id ='.$classify_id.' and r.content_id=n.goods_id')->count();
		foreach($goods as $k=>$v){  ?>
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
