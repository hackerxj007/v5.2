<?php if (!defined('THINK_PATH')) exit(); require APP_ROOT.'public/top.php';?>
<div class="g00002">
  <div class="g00003" id="left">
    <?php require APP_ROOT.'public/left.php';?>
  </div>
  <div class="g00004" id="right">
	<?php require APP_ROOT.'public/right.php';?>
    <div class="f14464855461">
      <?php $goods=M('goods')->where(array('goods_id'=>$content_id))->find();?>
      <div class="f14464854885"> <?php echo $goods['goods_name'];?> </div>
      
      <div class="f14464545151"><?php echo cover_time($goods['date'],'Y-m-d H:i:s');?></div>
      <div class="f14464854883"> <img class="f14464854884" src="<?php echo $goods['goods_img'];?>" /> </div>
      <div class="f144648548813"> <?php echo $goods['goods_content'];?> </div>      
    </div>
  </div>
</div>
<?php require APP_ROOT.'public/bottom.php';?>