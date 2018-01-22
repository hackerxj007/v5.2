<?php require APP_ROOT.'public/head.php';?>

<div class="g00002">
  <div class="reg_content">
    <form action="index.php?m=member&a=register_save" method="post" id="register_form" onsubmit="return register_save()">
      <label>
      <span>登录名</span>
      <div class="text">
        <p>
        <i class="username_i succeed"></i>
          <input type="text" id="username" name="data[username]" placeholder="请输入登录名称" onblur="onblur_username($(this))" onfocus="onfocus_username($(this))" />
          <input type="hidden" id="check_username" />
        </p>
        <div class="check" id="prompt_username"></div>
      </div>
      </label>
      <label>
      
      <span>登入密码</span>
      <div class="text">
        <p>
        <span id="capslock"><i></i><s></s>键盘大写锁定已打开，请注意大小写</span>
        <i class="password_i succeed"></i>
          <input type="password" id="password" name="data[password]" placeholder="请输入密码" onfocus="onfocus_password($(this))" onblur="onblur_password($(this))" />
          <input type="hidden" id="check_password" />
        </p>
        <div class="check" id="prompt_password"></div>
      </div>
      </label>
      <label>
      <span>再次输入密码</span>
      <div class="text">
        <p>
			<i class="againpassword_i succeed"></i>
          <input type="password" id="againpassword" name="data[againpassword]" placeholder="再次输入密码" onfocus="onfocus_againpassword($(this))" onblur="onblur_againpassword($(this))" />
          <input type="hidden" id="check_againpassword" />
        </p>
        <div class="check" id="prompt_againpassword"></div>
      </div>
      </label>
      <label>
      <span>手机号码</span>
      <div class="text">
        <p><i class="tel86">+86</i>
			<i class="tel_i succeed"></i>
          <input name="data[tel]" type="text" maxlength="11" placeholder="请输入您的手机号码" onfocus="onfocus_tel($(this))" id="tel" onblur="onblur_tel($(this))" />
          <input type="hidden" id="check_tel" />
        </p>
        <div class="check" id="prompt_tel"></div>
         </div>
      </label>
      <label>
      <span>短信验证码</span>
      <div class="text">
		 <p>	<i class="sms_i succeed"></i>
        <input class="sms" id="sms" type="text" placeholder="请输入手机验证码"  name="data[sms]" onfocus="onfocus_sms($(this))" onblur="onblur_sms($(this))" />
        <input type="hidden" id="check_sms" />
        <a href="javascript:void" type="button" class="send_sms" onclick="send_sms()" id="send_sms" >发送短信</a>
        </p>
        <div class="check" id="prompt_sms"></div>
        </div>
      </label>
      <label>
        <input type="submit" class="submit" value="注册" onclick="register_form()" />
      </label>
    </form>
  </div>
</div>

<script type="text/javascript">
function onfocus_username(obj)
{
	$(".username_i.succeed").hide();
	obj.removeClass("error").addClass("on");
	$('#prompt_username').css('display','block').html('<i class="password_i prompt"></i><em class="grey">&nbsp;4-20位字符，支持汉字、字母、数字及"-"、"_"组合</em>');
}

function onblur_username(obj)
{
	obj.removeClass("on");
	if(obj.val()!='')
	{
		if(obj.val().length<4)
		{
			obj.addClass("error");
			$('#prompt_username').css('display','block').html('<i class="username_i error"></i><em class="red">&nbsp;账号长度不能小于4位</em>');
			$("#check_username").val('');
		}
		else
		{
			var html=ajax_load("index.php?m=member&a=check_username&username="+obj.val());
			if(html==1)
			{
				$('#prompt_username').css('display','block').html('<i class="username_i error"></i><em class="red">&nbsp;该账号已经被使用</em>');
				$("#check_username").val('');
				$(".username_i.succeed").hide();
			}
			else
			{
				$('#prompt_username').css('display','block').html('<em class="green">恭喜您！该账号可以使用</em>');
				$("#check_username").val(1);
				$(".username_i.succeed").show();
			}
		}
	}
	else
	{
		obj.addClass("error");
		$('#prompt_username').css('display','block').html('<i class="username_i error"></i><em class="red">&nbsp;用户名不能为空</em>');
		$("#check_username").val('');
	}
	
}

function onfocus_password(obj)
{
	$(".password_i.succeed").hide();
	obj.removeClass("error").addClass("on");
	$('#prompt_password').css('display','block').html('<i class="password_i prompt"></i><em class="grey">&nbsp;6-20位字符，建议由字母，数据和符号两种以上组合</em>');
}

function onblur_password(obj)
{
	$("#capslock").hide();
	obj.removeClass("on");
	if(obj.val()!='')
	{
		if(obj.val().length<6)
		{
			obj.addClass("error");
			$('#prompt_password').css('display','block').html('<i class="password_i error"></i><em class="red">&nbsp;长度只能在6-20个字符之间</em>');
			$("#check_password").val('');
		}
		else if($("#againpassword").val()!='' && $("#againpassword").val()!=obj.val())
		{
			obj.addClass("error");
			$('#prompt_againpassword').css('display','block').html('<i class="password_i error"></i><em class="red">&nbsp;两次密码输入不一致</em>');
			$("#check_againpassword").val('');
		}
		else
		{
			$(".password_i.succeed").show();
			$("#check_password").val(1);
		}
	}
	else
	{
		obj.addClass("error");
		$('#prompt_password').css('display','block').html('<i class="password_i error"></i><em class="red">&nbsp;密码不能为空</em>');
		$("#check_password").val('');
	}

}

function onfocus_againpassword(obj)
{
	$(".againpassword_i.succeed").hide();
	obj.removeClass("error").addClass("on");
	$('#prompt_againpassword').css('display','block').html('<i class="password_i prompt"></i><em class="grey">&nbsp;请再次输入密码</em>');
}

function onblur_againpassword(obj)
{
	if(obj.val()!='')
	{
		if(obj.val()!=$("#password").val())
		{
			obj.addClass("error");
			$('#prompt_againpassword').css('display','block').html('<i class="password_i error"></i><em class="red">&nbsp;两次密码输入不一致</em>');
			$("#check_againpassword").val('');
		}
		else
		{
			$(".againpassword_i.succeed").show();
			$("#check_againpassword").val(1);
		}
	}
	else
	{
		obj.addClass("error");
		$('#prompt_againpassword').css('display','block').html('<i class="password_i error"></i><em class="red">&nbsp;请输入确认密码</em>');
		$("#check_againpassword").val('');
	}
}

function onfocus_tel(obj)
{
	$(".tel_i.succeed").hide();
	obj.removeClass("error").addClass("on");
	$('#prompt_tel').css('display','block').html('<i class="password_i prompt"></i><em class="grey">&nbsp;完成验证后，可以使用该手机找回密码</em>');
}

function onblur_tel(obj)
{
	if(obj.val()!='')
	{
		var reg=/1[3578]\d{9}/i;
		if(!reg.test(obj.val()))
		{
			$('#prompt_tel').css('display','block').html('<i class="password_i error"></i><em class="red">&nbsp;请输入正确的手机号</em>');
			//$('#tel').focus();
			$("#check_tel").val('');
		}
		else
		{
			$(".tel_i.succeed").show();
			$("#check_tel").val(1);
			
		}
	}
	else
	{
		obj.addClass("error");
		$('#prompt_tel').css('display','block').html('<i class="tel_i error"></i><em class="red">&nbsp;手机号不能为空</em>');
		$("#check_tel").val('');
	}
}

function onfocus_sms(obj)
{
	$(".sms_i.succeed").hide();
	obj.removeClass("error").addClass("on");
	//$('#prompt_sms').css('display','block').html('<i class="password_i prompt"></i><em class="grey">&nbsp;完成验证后，可以使用该手机找回密码</em>');
}

function onblur_sms(obj)
{
	if(obj.val()!='')
	{
		var html=ajax_load("index.php?m=member&a=check_sms&sms="+obj.val());
		if(html==1)
		{
			$(".sms_i.succeed").show();
			$("#check_sms").val(1);
			$('#prompt_sms').css('display','block').html('');
		}
		else
		{
			$('#prompt_sms').css('display','block').html('<i class="username_i error"></i><em class="red">&nbsp;验证码错误</em>');
			$("#check_sms").val('');
			$(".sms_i.succeed").hide();
		}
		
		var reg=/1[3578]\d{9}/i;
		if(!reg.test($("#tel").val()))
		{
			$('#prompt_tel').css('display','block').html('<i class="password_i error"></i><em class="red">&nbsp;请输入正确的手机号</em>');
			//$('#tel').focus();
			$("#check_tel").val('');
			$("#check_sms").val('');
		}
		else
		{
			$(".tel_i.succeed").show();
		}
		
	}
	else
	{
		obj.addClass("error");
		$('#prompt_sms').css('display','block').html('<i class="tel_i error"></i><em class="red">&nbsp;验证码不能为空</em>');
		$("#check_sms").val('');
	}
}


$('#password')[0].onkeypress = function (event) {
                        var e = event || window.event,
                            $tip =
                        $('#capslock'),
                                kc = e.keyCode || e.which, // 按键的keyCode
                                isShift = e.shiftKey || (kc == 16 ) || false; // shift键是否按住
                        if (((kc >= 65 && kc <= 90) && !isShift) || ((kc >= 97 && kc <= 122) && isShift)) {
                                $tip.show();
                        }
                        else {
                                $tip.hide();
                        }
                    };
					

      var wait=60;//时间
      var code=$('#send_sms');
      code.removeAttr("disabled");

      // 倒计时
      function link_time()
	  {
		  if (wait == 0) {
				code.removeClass('on');
				code.attr("onclick", 'link_more()');
			  $('#text').css('display','none')
			  code.html("发送验证码");//改变按钮中value的值
			  wait = 60;
		  } else {
		  code.addClass('on');
		  code.attr("onclick", '');//倒计时过程中禁止点击按钮
		  code.html(wait+" 秒后重新获取");//改变按钮中value的值
		  wait--;
		  setTimeout(function() {
		  link_time();//循环调用
		  },
		  1000)
		  }
      }

      // 调用短信接口
      function send_sms(){
		if($("#check_tel").val()==1)
		{
			var html=ajax_load("index.php?m=sms&a=send_sms&tel="+$("#tel").val());
			if(html==1)
			{
				$('#prompt_sms').css('display','block').html('<i class="tel_i prompt"></i><em class="grey">&nbsp;验证码已发送</em>');
				link_time();
			}
			else
			{
				$('#prompt_sms').css('display','block').html('<i class="tel_i error"></i><em class="red">&nbsp;验证码发送失败</em>');						
			}
		}
		else
		{
			onblur_tel($("#tel"));
		}
    }

       
     function link_more(){
      if($('#tel').val()==''){
		  $('#teltext').css('display','inline-table').html('请输入手机号');
		  $('#tel').focus();
      }
	  else
	  {
			var reg=/1[3578]\d{9}/i;
			if(!reg.test($('#tel').val()))
			{
				$('#teltext').css('display','inline-table').html('请输入正确的手机号');			
				$('#tel').focus();
			}
			else
			{
				$('#teltext').hide();
				var html=ajax_load("index.php?m=member&a=select_tel&tel="+$('#tel').val());
				if(html==1)
				{
					$('#text').css('display','inline-table').html('<em class="red">手机号码已经被注册，请更换！</em>');
				}
				else
				{
					link_send();
				}
			  }
		  }
      }
	  
function register_save()
{	
	if($("#check_username").val()!=1)
	{
		onblur_username($("#username"));
		return false;
	}
	else if($("#check_password").val()!=1)
	{
		onblur_password($("#password"));
		return false;
	}
	else if($("#check_againpassword").val()!=1)
	{
		onblur_againpassword($("#againpassword"));
		return false;
	}
	else if($("#check_tel").val()!=1)
	{
		onblur_tel($("#tel"));
		return false;
	}
	else if($("#check_sms").val()!=1)
	{
		onblur_sms($("#sms"));
		return false;
	}
	else
	{
		return true;
	}
}
</script>
<?php require APP_ROOT.'public/foot.php';?>
