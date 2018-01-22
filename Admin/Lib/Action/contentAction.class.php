<?php
class contentAction extends Action {

    public function index(){
        $this->display();
    }
	public function add_save()
	{
		$data = pg('data');
		$type_id = $data['type_id'];
		$classify_id = pg('classify_id');
		$table_name = M('classify_type')->where(array('type_id' => $type_id))->getField('table_name');
		$content = M($table_name)->where(array($table_name.'_id' => $content_id))->select();
		$list = M('input')->where(array('type_id' => $type_id, 'edit_switch' => 2, 'input_type_id' => 4))->select();
		foreach($list as $k => $v){
			$data[$v['field_name']]=serialize($data[$v['field_name']]);
		}

		$list = M('input')->where(array('type_id' => $type_id, 'edit_switch' => 2, 'input_type_id' => 7))->select();
		foreach($list as $k => $v){
			if(!empty($_FILES[$v['field_name']]['tmp_name'])){
				$data[$v['field_name']] = $this->up_file(array('name' => $v['field_name']));
			}
		}

		$list = M('input')->where(array('type_id' => $type_id, 'edit_switch' => 2, 'input_type_id' => 8))->select();
		foreach($list as $k => $v)
		{
			$data[$v['field_name']]=strtotime($data[$v['field_name']]);
		}
		
		$specifications = pg('specifications');
		$attributes = pg('attributes');
		if(!empty($attributes))
		{
			$specifications_choose_ids = array();
			foreach($attributes as $k=>$v)
			{
				foreach($v as $key=>$val)
				{
					$data['price_array'][$key][$k]=$val;
				}
			}
			$data['price_array']=serialize($data['price_array']);
		}
		$id = M($table_name)->data($data)->add();
		M('relevance')->data(array('classify_id'=> $classify_id, 'content_id' => $id, 'main_id' => 1, 'type_id' => $type_id))->add();
		echo '操作成功';
	}
	public function edit_save()
	{
		$data = pg('data');
		$type_id = pg('type_id');
		$classify_id = pg('classify_id');
		$content_id = pg('content_id');

		$table_name = M('classify_type')->where(array('type_id' => $type_id))->getField('table_name');
		$content = M($table_name)->where(array($table_name.'_id' => $content_id))->select();

		$list = M('input')->where(array('type_id' => $type_id, 'edit_switch' => 2, 'input_type_id' => 4))->select();
		foreach($list as $k => $v){
			$data[$v['field_name']]=serialize($data[$v['field_name']]);
		}

		$list = M('input')->where(array('type_id' => $type_id, 'edit_switch' => 2, 'input_type_id' => 7))->select();
		foreach($list as $k => $v){
			if(!empty($_FILES[$v['field_name']]['tmp_name'])){
				if(file_exists($content[0][$v['field_name']])){
					unlink($content[0][$v['field_name']]);	//通过文件路径来删除
				}
				$data[$v['field_name']] = $this->up_file(array('name' => $v['field_name']));
			}
		}
		$list = M('input')->where(array('type_id' => $type_id, 'edit_switch' => 2, 'input_type_id' => 8))->select();
		foreach($list as $k => $v)
		{
			$data[$v['field_name']]=strtotime($data[$v['field_name']]);
		}

		$specifications = pg('specifications');
		$attributes = pg('attributes');
		if(!empty($attributes))
		{
			$specifications_choose_ids = array();
			foreach($attributes as $k=>$v)
			{
				foreach($v as $key=>$val)
				{
					$data['price_array'][$key][$k]=$val;
				}
			}
			$data['price_array']=serialize($data['price_array']);
		}
		
		if($content_id != ''){
			M($table_name)->where($table_name . '_id = ' . $content_id)->save($data);
		}
		echo '操作成功';
	}
	public function batch_edit_save()//批量修改
	{
		$content_ids = pg('content_id');
		$table_name = pg('table_name');
		$type_id = pg('type_id');
		$datas = pg('data');
		$shared_id=pg('shared_id');
		$cancel_shared_id=pg('cancel_shared_id');
		$batch_delete_id=pg('batch_delete_id');
		$move_id=pg('move_id');
		$copy_id=pg('copy_id');
		$export_content_id=pg('export_content_id');
		$export=pg('export');
		$export_content_check=pg('export_content_check');
		$classify_id=pg('classify_id');

		foreach($datas['content_id'] as $k => $content_id){
			if(!$content_id) continue;

			$data = array();
			foreach($datas as $key => $val){
				if($key == 'content_id')
					continue;
				else if($key == 'date')
					$val[$k] = strtotime($val[$k]);

				$data[$key] = $val[$k];
			}			
			M($table_name)->where($table_name . '_id = ' . $content_id)->save($data);	
		}
		if($shared_id!='')
		{
			foreach($content_ids as $k=>$v)
			{
				if($v!='' && $type_id!='')
				{
					$data=array('classify_id'=>$shared_id,'content_id'=>$v,'type_id'=>$type_id);
					$list=M('relevance')->where($data)->select();
					if(empty($list))
					{
						M('relevance')->data($data)->add();
					}
				}
			}
		}
		
		if($cancel_shared_id!='')
		{
			foreach($content_ids as $k=>$v)
			{
				if($v!='' && $type_id!='')
				{
					$data=array('classify_id'=>$cancel_shared_id,'content_id'=>$v,'type_id'=>$type_id);
					$list=M('relevance')->where(array('classify_id'=>$cancel_shared_id,'content_id'=>$v,'type_id'=>$type_id,'main_id'=>1))->select();
					if(empty($list))
					{
						M('relevance')->where($data)->delete();//删除关联
					}
				}
			}
		}
		
		if($move_id!='')
		{
			foreach($content_ids as $k=>$v)
			{
				if($v!='' && $type_id!='')
				{
					$data=array('classify_id'=>$move_id);
					$list=M('relevance')->where(array('classify_id'=>$move_id,'content_id'=>$v,'type_id'=>$type_id))->find();
					if(!empty($list))
					{
						M('relevance')->where(array('classify_id'=>$move_id,'content_id'=>$v,'type_id'=>$type_id))->delete();//删除关联
					}
					M('relevance')->where(array('content_id'=>$v,'type_id'=>$type_id,'main_id'=>1))->save($data);//批量移动
				}
			}
		}
		
		if($copy_id!='')
		{
			foreach($content_ids as $k=>$v)
			{
				if($v!='' && $type_id!='')
				{
					$content = M($table_name)->where(array($table_name.'_id' => $v))->find();
					if(!$content || !$type_id){
						echo '操作失败';
						die;
					}
					$new_content=$content;
					$new_content['date']=$new_content['date']+60;
					unset($new_content[$table_name.'_id']);
					$list = M('input')->where(array('type_id' => $type_id, 'edit_switch' => 2, 'input_type_id' => 7))->select();
					foreach($list as $key => $val){
						if(file_exists($content[$val['field_name']])){
							$suffix=end(explode('.',$content[$val['field_name']]));
							$img_name=rand(1,8000).rand(8000,16000).'_'.$val['field_name'].'.'.$suffix;
							
							$arr['path']='Uploads/images/'.date('Y').'/'.date('m').'/'.date('d').'/';
							if(!file_exists($arr['path']))
							{
								mkdir($arr['path'],0777,true);//创建文件
							}
							$new_content[$val['field_name']]=$arr['path'].$img_name;
							copy($content[$val['field_name']],$new_content[$val['field_name']]);
						}
					}
					
					$id=M($table_name)->add($new_content);
					M('relevance')->add(array('content_id' => $id, 'type_id' => $type_id,'classify_id'=>$copy_id,'main_id'=>1));
				}
			}
		}

		if($batch_delete_id!='')
		{
			foreach($content_ids as $k=>$v)
			{
				if($v!='' && $type_id!='')
				{
					$content = M($table_name)->where(array($table_name.'_id' => $v))->find();
					if(!$content || !$type_id){
						echo '操作失败';
						die;
					}
			
					$list = M('input')->where(array('type_id' => $type_id, 'edit_switch' => 2, 'input_type_id' => 7))->select();
					foreach($list as $key => $val){
						if(file_exists($content[$val['field_name']])){
							unlink($content[$val['field_name']]);	//通过文件路径来删除
						}
					}
					
					M($table_name)->where(array($table_name.'_id' => $v))->delete();
					M('relevance')->where(array('content_id' => $v, 'type_id' => $type_id))->delete();
					//echo '操作成功';
				}
			}
		}
		if($export_content_id)
		{
			$xlsName  = "content";
			$i=0;
			foreach($export as $k=>$v)
			{
				$xlsCell[$i][0]=$k;
				$xlsCell[$i][1]=$v;
				$i++;
			}
			if($export_content_check)
			{
				$where = array();
				$where['r.classify_id'] = $classify_id;
				$where['r.type_id'] = $type_id;
				if($type_id==46)
				{
					$content_list = M('member')->order('date desc')->select();
				}
				else
				{
					$content_list = M()->table(C('DB_PREFIX') . $table_name . ' c left join ' . C('DB_PREFIX') . 'relevance r on r.content_id = c.' . $table_name . '_id')->where($where)->order('c.date desc')->select();
				}
			}
			else
			{
				$content_list = M($table_name)->where(array($table_name.'_id' => array('in',$content_ids)))->select();
			}
			
			
			foreach($content_list as $k=>$v)
			{
				foreach($export as $k2=>$v2)
				{
					$input=M('input')->where(array('field_name'=>$k2,'type_id'=>$type_id))->find();
					if($input['input_type_id']==5 || $input['input_type_id']==6)
					{
						$v[$k2]=M('input')->where(array('input_pid'=>$input['input_id'],'input_value'=>$v[$k2]))->getfield('input_name');								
					}
					else if($input['input_type_id']==4)
					{
						$valarr=unserialize($v[$k2]);
						$v[$k2]='';
						foreach($valarr as $k3=>$v3)
						{
							$v[$k2]=$v[$k2].' '.M('input')->where(array('input_pid'=>$input['input_id'],'input_value'=>$v3))->getfield('input_name');
						}
					}
					else if($input['input_type_id']==8)
					{
						$v[$k2]=cover_time($v[$k2],'Y-m-d H:i:s');
					}
					$xlsData[$k][$k2]=$v[$k2];
				}
			}
			$this->exportExcel($xlsName,$xlsCell,$xlsData,$type_id);
		}
		echo '操作成功';
	}
	public function delete_img()//删除图片
	{
		$content_id = pg('content_id');
		$table_name = pg('table_name');
		$type_id = pg('type_id');
		$field_name = pg('field_name');
		if($content_id != ''){
			$content = M($table_name)->where(array($table_name . '_id' => $content_id))->select();
			unlink($content[0][$field_name]);	//删除内容时删除上传口图片
			M($table_name)->where($table_name . '_id = ' . $content_id)->save(array($field_name => ''));
		}
		echo '操作成功';
	}
	public function del_save()//删除分类
	{
		$content_id = pg('content_id');
		$table_name = pg('table_name');
		$type_id = pg('type_id');

		$content = M($table_name)->where(array($table_name.'_id' => $content_id))->find();
		if(!$content || !$type_id){
			echo '操作失败';
			die;
		}

		$list = M('input')->where(array('type_id' => $type_id, 'edit_switch' => 2, 'input_type_id' => 7))->select();
		foreach($list as $k => $v){
			if(file_exists($content[$v['field_name']])){
				unlink($content[$v['field_name']]);	//通过文件路径来删除
			}
		}

		M($table_name)->where(array($table_name.'_id' => $content_id))->delete();
		M('relevance')->where(array('content_id' => $content_id, 'type_id' => $type_id))->delete();
		echo '操作成功';
	}
	public function batch_upload_save()//批量修改栏目
	{
		$name=$_FILES['Filedata']['name'];
		$name_arr=explode('.',$name);
		$time=time();
		$data['product_name']=$name_arr[0];
		if(!empty($_FILES['Filedata']['tmp_name']))
		{
			$imgpath='Uploads/images/'.date('Y').'/'.date('m').'/'.date('d');
			if(!file_exists($imgpath))
			{
				mkdir($imgpath,0777,true);//创建文件
			}
			$imgpath=$imgpath.'/batch'.$time.rand(1000,8000).rand(8000,16000).'.'.$name_arr[1];
			move_uploaded_file($_FILES['Filedata']['tmp_name'],$imgpath);
		}
		echo $imgpath;
		//echo '操作成功';
	}
	public function content_batch_upload_save()
	{
		$data['version_id']=session('version_id')!=''?session('version_id'):1;
		$classify_id=pg('classify_id');
		$data['type_id']=3;
		$name=$_FILES['Filedata']['name'];
		$name_arr=explode('.',$name);
		$time=time();
		$data['date']=$time;
		$data['goods_name']=$name_arr[0];

		$imgpath='Uploads/images/'.date('Y').'/'.date('m').'/'.date('d');
		if(!file_exists($imgpath))
		{
			mkdir($imgpath,0777,true);//创建文件
		}
		$list=M('input')->where(array('type_id'=>$data['type_id'],'edit_switch'=>2,'input_type_id'=>7))->select();
		foreach($list as $k=>$v)
		{
			if(!empty($_FILES['Filedata']['tmp_name']))
			{
				$data[$v['field_name']]=$imgpath.'/batch'.$time.rand(1000,8000).rand(8000,16000).'_'.$v['field_name'].'.'.$name_arr[1];
				move_uploaded_file($_FILES['Filedata']['tmp_name'],$data[$v['field_name']]);
			}
		}
		copy($data['goods_img'],$data['goods_bigimg']);
		$table_name = M('classify_type')->where(array('type_id' => $data['type_id']))->getField('table_name');
		$id = M($table_name)->data($data)->add();
		echo M()->getlastsql();
		M('relevance')->data(array('classify_id'=> $classify_id, 'content_id' => $id, 'main_id' => 1, 'type_id' => $data['type_id']))->add();
		echo '操作成功';
	}

	public function exportExcel($expTitle,$expCellName,$expTableData,$type_id)
	{
		$xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
		$fileName = date('YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
		$cellNum = count($expCellName);
		$dataNum = count($expTableData);
		vendor("PHPExcel.PHPExcel");
		
		$objPHPExcel = new PHPExcel();
		$cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
		
		//$objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
		// $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));  
		for($i=0;$i<$cellNum;$i++){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]);
			$objPHPExcel->getActiveSheet(0)->getStyle($cellName[$i].'1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet(0)->getStyle($cellName[$i])->getFont()->setSize(10);
			$objPHPExcel->getActiveSheet(0)->getStyle($cellName[$i].'1')->getFont()->setSize(10);			
			$objPHPExcel->getActiveSheet(0)->getStyle($cellName[$i].'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet(0)->getRowDimension(1)->setRowHeight(20);
			$objPHPExcel->getActiveSheet(0)->getStyle($cellName[$i].'1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		}
		
		
		
		
		$objPHPExcel->getActiveSheet(0)->getColumnDimension('A')->setWidth(30);
		$objPHPExcel->getActiveSheet(0)->getColumnDimension('B')->setWidth(30);
		$objPHPExcel->getActiveSheet(0)->getColumnDimension('C')->setWidth(30);
		$objPHPExcel->getActiveSheet(0)->getColumnDimension('D')->setWidth(30);
		$objPHPExcel->getActiveSheet(0)->getColumnDimension('E')->setWidth(30);
		$objPHPExcel->getActiveSheet(0)->getColumnDimension('F')->setWidth(30);
		$objPHPExcel->getActiveSheet(0)->getColumnDimension('G')->setWidth(30);
		$objPHPExcel->getActiveSheet(0)->getColumnDimension('H')->setWidth(30);
		$objPHPExcel->getActiveSheet(0)->getColumnDimension('I')->setWidth(30);
		$objPHPExcel->getActiveSheet(0)->getColumnDimension('J')->setWidth(30);
		$objPHPExcel->getActiveSheet(0)->getColumnDimension('K')->setWidth(30);
		$objPHPExcel->getActiveSheet(0)->getColumnDimension('L')->setWidth(30);
		$objPHPExcel->getActiveSheet(0)->getColumnDimension('M')->setWidth(30);
		$objPHPExcel->getActiveSheet(0)->getColumnDimension('N')->setWidth(30);
		

			
		// Miscellaneous glyphs, UTF-8
		for($i=0;$i<$dataNum;$i++){
		  for($j=0;$j<$cellNum;$j++){
			  $input_type_id=M('input')->where(array('field_name'=>$expCellName[$j][0],'type_id'=>$type_id))->getfield('input_type_id');
			  if($input_type_id==7 && file_exists($expTableData[$i][$expCellName[$j][0]]))
			  {
					// 图片生成
					$objDrawing[$i.$j] = new PHPExcel_Worksheet_Drawing();
					$objDrawing[$i.$j]->setPath($expTableData[$i][$expCellName[$j][0]]);
					// 设置宽度高度
					$objDrawing[$i.$j]->setHeight(80);//照片高度
					//$objDrawing[$i.$j]->setWidth(80); //照片宽度
					/*设置图片要插入的单元格*/
					$objDrawing[$i.$j]->setCoordinates($cellName[$j].($i+2));
					// 图片偏移距离
					$objDrawing[$i.$j]->setOffsetX(5);
					$objDrawing[$i.$j]->setOffsetY(5);
					$objDrawing[$i.$j]->setWorksheet($objPHPExcel->getActiveSheet());
					$objPHPExcel->getActiveSheet(0)->getRowDimension(($i+2))->setRowHeight(80);
			  }
			  else
			  {
				$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), $expTableData[$i][$expCellName[$j][0]]);
			  }
			 	$objPHPExcel->getActiveSheet(0)->getStyle($cellName[$j].($i+2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		  }
		}

		header('pragma:public');
		header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
		header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
		ob_end_clean();//清除缓冲区
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
		$objWriter->save('php://output');
		//exit;
	}

}

