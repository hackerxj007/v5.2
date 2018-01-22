<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$site = get_site();
$p=pg('p')==''?1:pg('p');
$classify_id=get_classify_id();
$content_id=pg('content_id');
$type_id=get_type_id();
$search=pg('search');
$member=session('member');
$member_id=$member['member_id'];
$recursive_classify_id=recursive_classify_id($classify_id,3)==''?3:recursive_classify_id($classify_id,3);
$cart_num=M('cart')->where(array('member_id'=>$member['member_id']))->count();
if($cart_num=='')$cart_num=0;
$balance=M('account')->where(array('member_id'=>$member_id))->order('account_id desc')->getfield('balance');
if($balance=='')$balance=0.00;
$mobile_url='mobile.php?'.$_SERVER["QUERY_STRING"];
?>
<title><?php echo $site['title'];?></title>
<meta name="keywords" content="<?php echo $site['keywords'];?>" />
<meta name="description" content="<?php echo $site['description'];?>" />
<link href="Admin/Tpl/font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo APP_ROOT;?>css/public_head.css" rel="stylesheet" type="text/css"/>
<?php
$list=each_dir(APP_ROOT.'css');
foreach($list as $k=>$v){
	if($v['filename']!='public_head.css'){
?>
<link href="<?php echo APP_ROOT;?>css/<?php echo $v['filename'];?>" rel="stylesheet" type="text/css"/>
<?php } } ?>
<script src="<?php echo APP_ROOT;?>js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo APP_ROOT;?>js/common.js" type="text/javascript"></script>
<script src="<?php echo APP_ROOT;?>js/jquery.SuperSlide.2.1.1.js" type="text/javascript"></script>
<script src="<?php echo APP_ROOT;?>js/laydate/laydate.js" type="text/javascript"></script>
</head>
<body>
<?php if(file_exists('mobile.php')){?>
<script type="text/javascript">
function IsPC()
{  
           var userAgentInfo = navigator.userAgent;  
           var Agents = new Array("Android", "iPhone", "SymbianOS", "Windows Phone", "iPad", "iPod");  
           var flag = true;  
           for (var v = 0; v < Agents.length; v++) {  
               if (userAgentInfo.indexOf(Agents[v]) > 0) { flag = false; break; }  
           }  
           return flag;  
}            
if(!IsPC())window.location.href="<?php echo $mobile_url;?>";

</script>
<?php }?>
