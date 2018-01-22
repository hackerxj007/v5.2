<?php require APP_ROOT.'public/top.php';?>
<div class="g00002">
  <div class="g00003" id="left">
    <?php require APP_ROOT.'public/left.php';?>
  </div>
  <div class="g00004" id="right">
	<?php require APP_ROOT.'public/right.php';?>    
    <div class="f14464843411">
      <ul class="f14464843415">
	<?php
		$perpage=10;$offset=($p-1)*$perpage;
		$news = M()->table('index_news n,index_relevance r')->where('r.classify_id ='.$classify_id.' and r.content_id=n.news_id')->order('date desc')->limit($offset,$perpage)->select();
		$total_num=M()->table('index_news n,index_relevance r')->where('r.classify_id ='.$classify_id.' and r.content_id=n.news_id')->count();
		foreach($news as $k=>$v){
	?>
        <li class="f14464843416">
          <div class="f14464843419"> <a class="f144648434110" href="<?php echo content_url($v['type_id'],$v['news_id']) ?>"><?php echo $v['news_title'] ?></a> <span class="f144648434111"><?php echo cover_time($v['date'],'Y-m-d');?></span> </div>
        </li>
        <?php }?>
      </ul>
    </div>
	<?php require APP_ROOT.'public/page.php';?>    
  </div>
</div>
<?php require APP_ROOT.'public/bottom.php';?>
