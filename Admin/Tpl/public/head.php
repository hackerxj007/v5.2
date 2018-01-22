<?php
$user=session('user');
if(session('version_id')=='')session('version_id',1);
$version_id=session('version_id');

if(session('version_classify_id')=='')session('version_classify_id',1);
$version_classify_id=session('version_classify_id');

$recursive_classify_id=pg('recursive_classify_id')==''?$version_classify_id:pg('recursive_classify_id');
if(empty($user))
{
	showmsg('请先登录',U('login/index'));
	die();
}
$function_switch = M('function_switch')->where(array('function_switch_id'=>1))->find();
$user_page = M('user_page')->where(array('user_id'=>$user['user_id']))->select();
foreach($user_page as $k=>$v)
{
	$page_arr[]=$v['page'];
}
/*
if(!in_array(MODULE_NAME.'_'.ACTION_NAME.'.php',$page_arr) && $user['user_id']!=1)
{
		session('user',null);
		setcookie('user');
		showmsg('你还没有登录，请先登录!',U('login/index'),1000);
		exit;
}
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Admin/Tpl/font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo APP_ROOT;?>css/main.css" rel="stylesheet" type="text/css" />
<script src="<?php echo APP_ROOT;?>js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo APP_ROOT;?>js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo APP_ROOT;?>js/jquery.SuperSlide.2.1.1.js" type="text/javascript"></script>
<script src="<?php echo APP_ROOT;?>js/common.js" type="text/javascript"></script>
<script src="<?php echo APP_ROOT;?>js/laydate/laydate.js" type="text/javascript"></script>
<script src="<?php echo APP_ROOT;?>js/ZeroClipboard.js" type="text/javascript"></script>
<script charset="utf-8" src="ThinkPHP/Extend/Vendor/kindeditor-4.1.7/kindeditor.js"></script>

<script>
//引入artDialog
(function() {
	var _skin, _jQuery;
	var _search = window.location.search;
	if (_search) {
		_skin = _search.split('demoSkin=')[1];
	};
	document.write('<scr'+'ipt src="<?php echo APP_ROOT;?>js/artDialog/artDialog.js?skin=' + (_skin || 'default') +'"></sc'+'ript>');
	window._isDemoSkin = !!_skin;
})();
</script>
<script src="<?php echo APP_ROOT;?>js/artDialog/plugins/iframeTools.js"></script>
<?php
$site = M('site')->find();
$p=pg('p')==''?1:pg('p');
?>
<script src="<?php echo APP_ROOT;?>js/swfupload.js" type="text/javascript"></script>
<script src="<?php echo APP_ROOT;?>js/fileprogress.js" type="text/javascript"></script>
<script src="<?php echo APP_ROOT;?>js/handlers.js" type="text/javascript"></script>

<title><?php echo $site['company_name'];?>-后台管理系统</title>
</head>
<body>
<?php if($function_switch['left_navigation']==2){?>
<style type="text/css">
.right_panel{ margin-left:210px; }
</style>
<?php }?>