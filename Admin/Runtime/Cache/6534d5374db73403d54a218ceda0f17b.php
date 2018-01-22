<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>百家骏网络-后台管理系统</title>
<link href="<?php echo APP_ROOT.'css/main.css';?>" rel="stylesheet" type="text/css" />
</head>
<body style="background:#016ba9;">
<form action="admin.php?m=login&a=login_save" method="post" id="form">
<div class="login">
<ul>
<li><span>用户名：</span><input type="text" name="data[username]" size="20" /></li>
<li><span>密&nbsp;码：</span><input type="password" name="data[password]" size="20" /></li>
<li style="display:none;"><span>验证码：</span></li>
<li><input name="" type="submit" class="login_submit" value="登&nbsp;&nbsp;录" /></li>
</ul>
</div>
</form>
</body>
</html>