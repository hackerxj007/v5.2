<?php
// 本类由系统自动生成，仅供测试用途
class wxpayAction extends Action {
    public function index()
	{
		$this->display();
    }
	
	//JS支付地址
	public function pay()
	{
		$this->display();
    }

    //扫码支付地址
	public function natpay()
	{
		$this->display();
    }
    
	//获取支付结果,更新数据库
    public function payact()
	{
		$id=md5('order_id'.date('Ym'));
		$order_id=$_GET[$id];

		//判断为空退出
		if(empty($order_id)){
			exit;
		}
		//查询数据库
		$info=M('order')->field('state')->where('order_id='.$order_id)->find();

		//订单状态大于1 退出
		if($info['state']>261){
			exit;
		}
		//更新状态为2已付款
		$data['state']=262;
		$cnt=M('order')->where('order_id='.$order_id)->save($data);
		
    }
	
	//用户充值页面
    public function mem_acc()
	{
		
		$id=md5('mem_acc_id'.date('Ym'));
		$mem_acc_id=$_GET[$id];
		//判断为空退出
		if(empty($mem_acc_id)){
			exit;
		}
		//查询数据库
		
		$info=M('member_account')->field('state')->where('member_account_id='.$mem_acc_id)->find();

		//订单状态大于1 退出
		if($info['state']==2){
			exit;
		}
		//更新状态为2已付款
		$data['state']=2;
		$cnt=M('member_account')->where('member_account_id='.$mem_acc_id)->save($data);
		
    }

    
	/**
	 * 查询订单号生成二维码
	 * @param  string $url    请求URL
	 * @return array  $data   响应数据
	 */
	public function qrcode_pay()
	{
		$order_id=pg('order_id');
		ini_set('date.timezone','Asia/Shanghai');
		//引入类
		vendor('Wxpay.lib.WxPay#Exception');
		vendor('Wxpay.lib.WxPay#Data');
		vendor('Wxpay.lib.WxPay#config');
		vendor('Wxpay.lib.WxPay#Api');
		vendor('Wxpay.example.WxPay#NativePay');
		vendor('Wxpay.example.log');
		vendor('Wxpay.example.phpqrcode.phpqrcode');
	
		//获取订单号信息
		$order_list=M('order')->where(array('order_id'=>$order_id))->find();
		$order_goods=M('order_goods')->where(array('order_id'=>$order_id))->find();
	
		//②、统一下单
		$input = new WxPayUnifiedOrder();
		$input->SetBody($order_goods['vpn_tc']);
		$input->SetAttach($order_id);
		// $input->SetAttach('110110110');
		$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
		$input->SetTotal_fee($order_list['price']*100); //价格传入
		// $input->SetTotal_fee("1");
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("test");
		$input->SetNotify_url("http://".$_SERVER['SERVER_NAME']."/wxpay/notice.php");
		$input->SetTrade_type("NATIVE");
		$input->Setproduct_id($order_id);
		$rs = WxPayApi::unifiedOrder($input);
		$link_url=$rs['code_url'];
		if(empty($link_url)){
			return 'FAIL';
		}
	
		$dir='./uploads/imgaes/'.date('Y/m/d');
		if(!is_dir($dir)){
			mkdir($dir,'0777',true);
		}
		$qrcode=$dir.'/'.$order_list['order_number'].'.png';
		QRcode::png($link_url,$qrcode,'M',5.7,3);
		echo '<img src="'.$qrcode.'" />';
	}
	

	public function order_state()
	{
		$order_id=pg('order_id');
		echo M('order')->where(array('order_id'=>$order_id))->getfield('state');
	}
	
	
	
	
}