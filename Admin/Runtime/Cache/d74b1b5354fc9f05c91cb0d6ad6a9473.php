<?php if (!defined('THINK_PATH')) exit(); require APP_ROOT.'public/top.php';$site = M('site')->find();?>
<div class="content">
  <?php require APP_ROOT.'public/left.php';?>
<div class="right_panel" id="right">
<iframe src="http://oa.bjjun.com/index.php?m=order_site&a=notice_index&order_site_id=<?php echo $site['order_site_id'];?>" frameborder="0" scrolling="auto" width="100%" height="100%"></iframe>
</div>
</div>
<?php require APP_ROOT.'public/bottom.php';?>