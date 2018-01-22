<?php
class loginAction extends Action {

    public function index(){
        $this->display();
    }
	public function login_save()
	{
		$data=pg('data');
		$data['password']=md5($data['password']);
		$user = M('user')->where($data)->find();
		if(empty($user))
		{
			$this->error('用户名密码错误',U('login/index'));
		}
		else
		{
			session('user',$user);
			setcookie('user',$user, time()+86400);
			$this->success('登录成功',U('/'));
		}
	}
	public function login_exit()
	{
		session('user',null);
		setcookie('user');
		$this->success('安全退出',U('login/index'));
	}
	public function del_save()//删除分类
	{
		$classify_id=pg('classify_id');
		$classify_id!=''?M('classify')->where(array('classify_id'=>$classify_id))->delete():'';
		echo '操作成功';
	}

}
