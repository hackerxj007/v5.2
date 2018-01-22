<?php require APP_ROOT.'public/top.php';?>

<div class="header-box header-box2">
  <p class="currents">在线支付</p>
  <div class="progress-bar">
    <dl>
      <dt class="on">1</dt>
      <dd>我的购物车</dd>
    </dl>
    <dl>
      <dt class="on">2</dt>
      <dd>确认订单</dd>
    </dl>
    <dl>
      <dt class="on">3</dt>
      <dd>付款</dd>
    </dl>
    <dl>
      <dt>4</dt>
      <dd>支付成功</dd>
    </dl>
  </div>
  <!--progress-bar-->
  <div class="cart-bg1 cart-bg2 cart-bg3 "></div>
</div>
<!--header-box-->
<?php
$order_id=pg('order_id');
$order=M('order')->where(array('order_id'=>$order_id))->find();
?>
<input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id;?>" />
<div class="cart-main main2">
  <div class="suc-payment">
    <form action="index.php?f=order&w=mycart2" method="post" enctype="application/x-www-form-urlencoded">
      <!--cart-thead-->
      <div class="payment_list">
        <div class="submitted"><img src="<?php echo APP_ROOT;?>images/submitted.png" /></div>
        <ul>
          <li class="title">您的订单已经提交成功，感谢您的订购！</li>
          <li>在线支付订单号：<font class="num"><?php echo $order['order_number'];?></font> ｜ 应付款金额：<font class="num">￥
            <?php  echo $order['price'];?>
            </font> <font class="num details"><a href="index.php?m=order&a=detail&order_id=<?php echo $order['order_id'];?>">订单付款详情 &gt;&gt;</a></font> </li>
          <li class="horizontal"></li>
          
          <?php if($order['state']>381){?>
          <li>订单已经完成支付</li>
          <?php }?>
        </ul>
      </div>
    </form>
  </div>
 
  <form method="post" action="https://api.teegon.com/charge/pay" onsubmit="" id="topup_form" target="_blank">
    <input type="hidden" name="order_no" id="order_no" value="">
    <input type="hidden" name="subject" id="subject" value="">
    <input type="hidden" name="metadata" id="metadata" value="">
    <input type="hidden" name="client_ip" id="client_ip" value="">
    <input type="hidden" name="return_url" id="return_url" value="">
    <input type="hidden" name="notify_url" id="notify_url" value="">
    <input type="hidden" name="sign" id="sign" value="">
    <input type="hidden" name="client_id" id="client_id" value="">
    <input type="hidden" name="amount" id="amount" value="<?php  echo $order['price'];?>" />
    <div class="topup">
      <div class="topupdiv"><span>账户余额：</span>
        <div class="text">
          <p><em class="price">￥<?php echo $balance;?></em></p>
        </div>
      </div>
      <?php if($balance<$order['price']){?>
      <div class="topupdiv hr"> 您的账户余额不足，请选择其它支付方式  <a href="index.php?m=member&a=topup">在线充值</a></div>
      <?php }else{?>
      <div class="topupdiv hr">
        <input type="button" class="submit" value="余额支付" onclick="balance_pay()">
      </div>
      <?php }?>
      <div class="topupdiv method"> <span>其它支付方式：</span>
        <div class="text">
          <label>
            <input type="radio" name="channel" value="alipay" checked="checked" />
            <img class="pay" src="<?php echo APP_ROOT.'images/alipay.png'?>" /> </label>
          <label>
            <input type="radio" name="channel" value="wxpay" />
            <img class="pay" src="<?php echo APP_ROOT.'images/wxpay.png'?>" /> </label>
          <label>
            <input type="radio" name="channel" value="chinapay_b2c" />
            <img class="pay" src="<?php echo APP_ROOT.'images/chinapay_b2c.png'?>" /> </label>
        </div>
      </div>
      
      <div class="topupdiv">
        <input type="button" class="submit" value="在线支付" onclick="online_pay()">
        <a href="index.php?m=alipay&a=pay&order_id=<?php echo $order_id;?>" target="_blank">支付宝支付</a>
        <a href="javascript:;" onClick="weixin_qrcode_pay(<?php echo $order_id;?>)">微信支付</a>
        <div class="qrcode"></div>
      </div>
    </div>
  </form>

</div>
<script type="text/javascript">
function balance_pay()
{
	var html=ajax_load("index.php?m=order&a=balance_pay&order_id="+$("#order_id").val());
	if(html==1)
	{
		goto_url("index.php?m=order&a=pay_success&order_id="+$("#order_id").val());
	}
	else
	{
		alert(html);
	}
}

function online_pay()
{
	var html=ajax_load("index.php?m=order&a=online_pay&amount="+$("#amount").val()+"&channel="+$('input[name="channel"]:checked').val()+"&order_id="+$("#order_id").val());		
	var json_obj = jQuery.parseJSON(html);
	$.each(json_obj, function(i, n){
		$("#"+i).val(n);
	});
	$("#topup_form").submit();
}

</script>

<?php require APP_ROOT.'public/bottom.php';?>
