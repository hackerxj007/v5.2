<?php
// 本类由系统自动生成，仅供测试用途
class typeAction extends Action {

    public function index(){
        $this->display();
    }
	public function add_save()
	{
		$data=pg('data');
		M('classify_type')->data($data)->add();
		
		$sql='
		CREATE TABLE index_'.$data['table_name'].' (
		  '.$data['table_name'].'_id int(10) NOT NULL AUTO_INCREMENT,
		  type_id int(10) NOT NULL,
		  date int(10) NOT NULL,
		  title varchar(99) NOT NULL,
		  keywords varchar(99) NOT NULL,
		  description varchar(10) NOT NULL,
		  version_id int(10) NOT NULL,
		  PRIMARY KEY ('.$data['table_name'].'_id)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
		M()->query($sql);
		
		if(!file_exists('Index/Lib/Action/'.$data['table_name'].'Action.class.php'))
		{
			copy('Index/Lib/Action/messageAction.class.php','Index/Lib/Action/'.$data['table_name'].'Action.class.php');
			$content=read_file('Index/Lib/Action/'.$data['table_name'].'Action.class.php');
			$content=str_replace('messageAction',$data['table_name'].'Action',$content);
			write_file('Index/Lib/Action/'.$data['table_name'].'Action.class.php',$content);
			copy_dir('Index/Tpl/message','Index/Tpl/'.$data['table_name']);
		}
		
		echo '操作成功';
	}
	public function show_save()
	{
		$type_id=pg('type_id');
		$show_id=pg('show_id')==1?2:1;
		M('classify_type')->where(array('type_id'=>$type_id))->save(array('show_id'=>$show_id));
		echo '操作成功';
	}
	public function del_save()//删除类型
	{
		$type_id=pg('type_id');
		if($type_id!='')
		{
			$classify_type=M('classify_type')->where(array('type_id'=>$type_id))->find();
			$sql='DROP TABLE IF EXISTS index_'.$classify_type['table_name'].';';
			M()->query($sql);//删除表

			M('classify_type')->where(array('type_id'=>$type_id))->delete();//删除类型
			M('input')->where(array('type_id'=>$type_id))->delete();//删除表单

			echo '操作成功';

		}

	}
}
