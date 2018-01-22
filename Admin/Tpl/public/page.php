<?php
$pageurl=get_url();
$pageurl=preg_replace('/\&p=[0-9]+/','',$pageurl);//正则替换
?>
<!-- 翻页-->
<div class="page">
<a href="<?php echo $pageurl."&p=1"?>">首页</a>
<?php
  $page_count=ceil($total_num/$perpage);
  $prev=$p-1;
  $next=$p+1;
  $pagenum=5;//固定页码数
  $floorpage=floor($pagenum/2);//页码偏移量
  $star=$p-$floorpage;
  $end=$p+$floorpage;
  if($p>1){
  ?>
    <a href="<?php echo $pageurl."&p=".$prev;?>">&lt;</a>
    <?php
  }else{
	?>
    <span>&lt;</span>
    <?php }
	if($star<1)$star=1;
	if($end>$page_count)$end=$page_count;
	if($end==0)$end=1;
	if($page_count==0)$page_count=1;
	for($i=$star;$i<=$end;$i++){
	if($p==$i){
	?>
    <span><?php echo $i;?></span>
    <?php }else{?>
    <a href="<?php echo $pageurl."&p=".$i;?>"><?php echo $i;?></a>
    <?php }
 }
	if($p<$page_count){?>
    <a href="<?php echo $pageurl."&p=".$next;?>">&gt;</a>
    <?php }else{?>
    <span>&gt;</span>
    <?php }?>
    
    <a href="<?php echo $pageurl."&p=".$page_count?>">尾页</a>
    <p>到 第
      <select name="page_number" id="page_number" onchange="on_page('<?php echo $pageurl;?>')">
        <?php for($i=1;$i<=$page_count;$i++){?>
        <option value="<?php echo $i;?>"<?php if($p==$i){?> selected="selected"<?php }?>><?php echo $i;?>&nbsp;</option>
        <?php }?>
      </select>
      页</p>
  </ul>
</div>
<script type="text/javascript">
function on_page(url)
{
	window.location.href=url+"&p="+$("#page_number").val();
}
</script>