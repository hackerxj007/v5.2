<?php require APP_ROOT.'public/head.php';?>
<div class="header"> <a href="" class="admin-logo">
	<!-- <img src="Admin/Tpl/images/logo.png"/>-->
</a>
  <div class="header_login">
<a class="exit_login" href="admin.php?m=login&a=login_exit">退出登录!</a>
</div>
  <?php $site = M('site')->select(); if(count($site)>1){
	  foreach($site as $k=>$v){?>
  <a class="exit_login<?php if(session('version_id')==$v['version_id'])echo ' on';?>" href="admin.php?m=site&a=switch_version&version_id=<?php echo $v['version_id'];?>"><?php echo $v['version_name'];?></a>
  <?php } }?>
<?php $user=session('user'); if($user['user_id']==1){?><a class="exit_login">程序版本：<?php echo $function_switch['version_number'];?></a><?php }?>
  <div class="top">
    <?php 
$type_id=pg('type_id');
echo $user['name']."<i>欢迎您！</i>";
?>
  </div>
  <div class="navigation">
    <ul>
      <?php 
$list = M('admin_classify')->where(array('level_id'=>2))->order('date asc')->select();
foreach($list as $k=>$v){
	$user_classify = M('user_classify')->where(array('user_id'=>$user['user_id'],'classify_id'=>$v['classify_id']))->find();
	if(!empty($user_classify)){
?>
      <li><a href="<?php echo $v['classify_url'];?>&admin_classify_id=<?php echo $v['classify_id'];?>"><span><?php echo $v['classify_name'];?></span></a></li>
      <?php } }?>
    </ul>
  </div>
  <div class="sub_nav ">
    <ul>
      <?php 
if(pg('admin_classify_id')!='')session('admin_classify_id',pg('admin_classify_id'));
$list = M('admin_classify')->where(array('classify_pid'=>session('admin_classify_id')))->order('date asc')->select();
foreach($list as $k=>$v){
	$user_classify = M('user_classify')->where(array('user_id'=>$user['user_id'],'classify_id'=>$v['classify_id']))->find();
	if(!empty($user_classify)){
?>
      <li><a href="<?php echo $v['classify_url'];?>&admin_classify_id=<?php echo $v['classify_pid'];?>"><span><?php echo $v['classify_name'];?></span></a></li>
	<?php } }
		if(session('admin_classify_id')==3){
$list = M('classify')->where(array('classify_pid'=>1))->select();
foreach($list as $k=>$v){
	  ?>
      <li><a href="admin.php?m=classify&a=index&admin_classify_id=3&recursive_classify_id=<?php echo $v['classify_id'];?>"><span><?php echo $v['classify_name'];?></span></a></li>
      <?php }}?>
    </ul>
  </div>
</div>
