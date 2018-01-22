<?php if (!defined('THINK_PATH')) exit(); require APP_ROOT.'public/top.php';?>

<div class="g00002">
  <div class="g00003" id="left">
    <?php require APP_ROOT.'public/left.php';?>
  </div>
  <div class="g00004" id="right">
    <div class="f14464847035">
      <div class="f14464847036">
        <?php require APP_ROOT.'public/right.php';?>
      </div>
    </div>
    <div class="f14464847351">
      <?php $news=M('news')->where(array('news_id'=>$content_id))->find();?>
      <div class="f14464847352"><?php echo $news['news_title'];?></div>
      <div class="f14464847353">发布时间：<?php echo cover_time($news['date'],'Y/m/d');?></div>
      <div class="f14464847354"><?php echo $news['news_content'];?></div>
      <?php  $news_gt = M()->table('index_news n,index_relevance r')->where('r.classify_id ='.$classify_id.' and n.date > '.$news['date'].' and r.content_id=n.news_id')->order('date asc')->find(); if(!empty($news_gt)){?>
      <div class="f14464847355"><a class="f14464847356" href="<?php echo content_url($news_gt['type_id'],$news_gt['news_id']) ?>">上一篇：<?php echo $news_gt['news_title'];?></a></div>
      <?php }?>
      <?php  $news_lt = M()->table('index_news n,index_relevance r')->where('r.classify_id ='.$classify_id.' and n.date < '.$news['date'].' and r.content_id=n.news_id')->order('date desc')->find(); if(!empty($news_lt)){?>
      <div class="f14464847355"><a class="f14464847356" href="<?php echo content_url($news_lt['type_id'],$news_lt['news_id']) ?>">下一篇：<?php echo $news_lt['news_title'];?></a></div>
      <?php }?>
    </div>    
  </div>
</div>
<?php require APP_ROOT.'public/bottom.php';?>