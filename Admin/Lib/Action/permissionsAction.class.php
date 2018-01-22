<?php
class permissionsAction extends Action {

    public function index(){
        $this->display();
    }
	public function add_save()
	{
		$data=pg('data');
		$data['password']=md5($data['password']);
		M('user')->data($data)->add();
		echo '操作成功';
	}
	public function edit_save()
	{
		$data=pg('data');
		$user_id=pg('user_id');
		if($user_id!='')
		{
			if($data['password']!='')
			{
				$data['password']=md5($data['password']);
			}
			else
			{
				unset($data['password']);
			}
			M('user')->where(array('user_id'=>$user_id))->save($data);
		}
		echo '操作成功';
	}
	public function permissions_edit_save()
	{
		$classify_id=pg('classify_id');
		$user_id=pg('user_id');
		$list=M('user_classify')->where(array('user_id'=>$user_id))->select();
		foreach($list as $k=>$v)
		{
			if(!in_array($v['classify_id'],$classify_id))
			{
				M('user_classify')->where(array('user_id'=>$user_id,'classify_id'=>$v['classify_id']))->delete();
			}
		}
		foreach($classify_id as $k=>$v)
		{
			$data=array('user_id'=>$user_id,'classify_id'=>$v);
			$user_classify=M('user_classify')->where($data)->find();
			if(empty($user_classify))
			{
				M('user_classify')->data($data)->add();
			}
		}
		echo '操作成功';
	}
	
	public function page_edit_save()//页面权限
	{
		$page=pg('page');
		$user_id=pg('user_id');
		$list=M('user_page')->where(array('user_id'=>$user_id))->select();
		foreach($list as $k=>$v)
		{
			if(!in_array($v['page'],$page))
			{
				M('user_page')->where(array('user_id'=>$user_id,'page'=>$v['page']))->delete();
			}
		}
		foreach($page as $k=>$v)
		{
			$data=array('user_id'=>$user_id,'page'=>$v);
			$user_page=M('user_page')->where($data)->find();
			if(empty($user_page))
			{
				M('user_page')->data($data)->add();
			}
		}
		echo '操作成功';
	}
}



