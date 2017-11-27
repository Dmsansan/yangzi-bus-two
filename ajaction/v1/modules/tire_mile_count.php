<?
require_once(INCLUDE_PATH."PHPExcel/IOFactory.php");
require_once(INCLUDE_PATH."PHPExcel.php");

class tire_mile_count {
	var $conn=0;
	//var $log;

	function do_cmd($cmd){
		$this->conn=new db(DB_TYPE,DB_HOST,DB_NAME,DB_USER,DB_PASS,true,SYSTEM_PATH.'log');
		//$this->log=new log($this->conn);
		
		switch($cmd){
			case "qry":
				$this->qry();
				return;
			case "qry_search":
				$this->qry_search();
				return;
			case "exp":
				$this->exp();
				return;
            case "qry_figure":
                $this->qry_figure();
                return;
            case "exp_figure":
                $this->exp_figure();
                return;
			default:
                $arr = array ('status'=>'ERROR','reason'=>'未知的命令！');
                echo json_encode($arr);
                die();
		}
	}
	
	/**
		获取轮胎运行总时总里程查询
		../ajaction/v1/?menuid=131311&cmd=qry&tire_id_val=轮胎ID
        返回 {"Rows":[{"time_add":"装车时间",
                "time_remove":"卸载时间",
                "place_no":轮胎号位,
                "plate_no":"车辆号码",
                "tire_no":轮胎胎号,
                "run_time":运行时长(安装到卸载期间轮胎在跑的总时长),
                "run_mile":累计里程(安装到卸载期间轮胎累计里程)
                }],"count":1,"Total":11}
        其中 count 表示当前反回条数，Total 反回满足条件总记录数
    */
	function qry(){
		global $tire_position;
		$page = isset($_POST['page'])?intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		
		$offset = ($page-1)*$rows;

		$tire_id_val=mysql_escape_string(trim($_REQUEST["tire_id_val"].""));

		$plate_no = mysql_escape_string(trim($_REQUEST["plate_no"].""));
		//echo $palte_no;die;
		// if($tire_id_val == ""){
			// $arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
			// echo json_encode($arr);
			// die();
		// }
        //根据轮胎找轮胎记录、车牌以及该轮胎的所有替换记录。
		$sql="select a.*,b.plate_no,b.mile_count as b_mc,c.factory_code,c.fst_place_stamp,c.status from tire_exchg_log as a 
                left join bus_info as b on a.bus_id=b.bus_id
                left join tire_info as c on a.tire_id=c.tire_id";

        if($tire_id_val != ""){
            $tire_id_val=str_replace(";","','",$tire_id_val);
            $sql.=" where a.tire_id in ('".$tire_id_val."')";
        }
        if($plate_no != ""){
        	$sql .= " where b.plate_no ='$plate_no'";
        }
        if($_SESSION[CompanyID]!=""||$_SESSION[CompanyID]!=0){
            $sql .= " and b.company_id='$_SESSION[CompanyID]'";
        }
        $res_count = $this->conn->query($sql);
        $arr['total']=$this->conn->num_rows($res_count);

        // $sql.=" order by a.bus_id asc,tire_id asc,log_stamp asc";
        $sql .=" limit $offset,$rows";
        //echo $sql;die;
		$res=$this->conn->query($sql);

		if($this->conn->num_rows($res)>0){
            $rows = array ();
			while ($rec=$this->conn->fetch_array($res)){
                $row=array();
                $row['time_add']=$rec[install_stamp];
                $row['time_remove']="-";
                if($rec[uninstall_stamp]!="0000-00-00 00:00:00"){
                    $row['time_remove']=$rec[uninstall_stamp];
                }
                $row['place_no']=$tire_position[$rec[place]];
                $row['plate_no']=$rec[plate_no];
                $row['tire_no']=$rec[factory_code];
//如果是装在车上的轮胎，应该是最后一条缷下时的统计时间，加上（现在时间-最后装上时间）
//如果不是装在车上的轮胎，应该是最后一条缷下时的统计时间。
                $sql_qry="select max(stamp_count) as cnt from tire_exchg_log where tire_id=$rec[tire_id]";
                $ret_qry=$this->conn->query_first($sql_qry);
                
                $row['run_time']=sprintf('%.2f',intval($ret_qry[cnt])/3600);
                if($rec[status]=="装上"){
                    $row['run_time']=sprintf('%.2f',(time()-ymdhis2ts($rec[install_stamp]))/3600);
                }
//                $row['run_time']=$rec[stamp_count];
                //$row['run_mile']=$rec[b_mc];
                $nums = $this->conn->num_rows($res);
                if($nums==1){
                    $row['run_mile'] = $rec[b_mc];  
                }else{
                    if($rec[b_mc]==$rec[mile_count]&&$rec[uninstall_stamp]=="0000-00-00 00:00:00"){
                        $row['run_mile']=0;
                    }else{
                        if($row['run_time']<24){
                         $row['run_mile']=0;    
                        }else{
                        $row['run_mile']=$rec[mile_count];//车辆的实时里程数据
                        }
                    }
                }
                
				array_push($rows,$row);
			}
			$arr['count']=$this->conn->num_rows($res);
			

			$arr['rows']=$rows;
			//$result = trim(json_encode($arr),"\xEF\xBB\xBF");
			//$result=@iconv("GBK", "UTF-8//IGNORE", $result);
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
		}else{
			$arr = array ('total'=>0,'count'=>0);
			$result = json_encode($arr);
			//@iconv("GBK", "UTF-8//IGNORE", $result);
			echo $result;
			die();
			//$this->log->do_log($str);
			//die("404, $str\r\n");
		}

		return;
	}

    function qry_figure(){
        global $tire_position;
        $page = isset($_POST['page'])?intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        
        $offset = ($page-1)*$rows;

        $tire_id_val=mysql_escape_string(trim($_REQUEST["tire_id_val"].""));

        $plate_no = mysql_escape_string(trim($_REQUEST["plate_no"].""));

        $start_time = isset($_REQUEST['start_time']) ? mysql_real_escape_string($_REQUEST['start_time']) : '';

        $end_time = isset($_REQUEST['end_time']) ? mysql_real_escape_string($_REQUEST['end_time']) : '';

        //echo $palte_no;die;
        // if($tire_id_val == ""){
            // $arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
            // echo json_encode($arr);
            // die();
        // }
        //根据轮胎找轮胎记录、车牌以及该轮胎的所有替换记录。
        $sql="select a.*,b.plate_no,b.mile_count as b_mc,c.factory_code,c.fst_place_stamp,c.status from tire_exchg_log as a 
                left join bus_info as b on a.bus_id=b.bus_id
                left join tire_info as c on a.tire_id=c.tire_id where a.place!=0";

        if($tire_id_val != ""){
            $tire_id_val=str_replace(";","','",$tire_id_val);
            $sql.=" where a.tire_id in ('".$tire_id_val."')";
        }
        if($plate_no != ""){
            $sql .= " and b.plate_no ='$plate_no'";
        }
        if($_SESSION[CompanyID]!=""&&$_SESSION[CompanyID]!=0){
            $sql .= " and b.company_id='$_SESSION[CompanyID]'";
        }
        if($start_time != "" && $end_time != ""){
            $start_time .= " 00:00:00";
            $end_time .= " 23:59:59";
            $sql.= " and a.install_stamp>='$start_time' and a.install_stamp<='$end_time'";
        }
        $sql .= " and c.factory_code!=''";
        //echo $sql;die;
        $res_count = $this->conn->query($sql);
        $arr['total']=$this->conn->num_rows($res_count);

        // $sql.=" order by a.bus_id asc,tire_id asc,log_stamp asc";
        $sql .=" limit $offset,$rows";
        //echo $sql;die;
        $res=$this->conn->query($sql);

        if($this->conn->num_rows($res)>0){
            $rows = array ();
            while ($rec=$this->conn->fetch_array($res)){
                $row=array();
                $row['time_add']=$rec[install_stamp];
                $row['time_remove']="-";
                if($rec[uninstall_stamp]!="0000-00-00 00:00:00"){
                    $row['time_remove']=$rec[uninstall_stamp];
                }
                $row['place_no']=$tire_position[$rec[place]];
                $row['plate_no']=$rec[plate_no];
                $row['tire_no']=$rec[factory_code];
                $row['figure_mile']=$rec[figure_mile];
//如果是装在车上的轮胎，应该是最后一条缷下时的统计时间，加上（现在时间-最后装上时间）
//如果不是装在车上的轮胎，应该是最后一条缷下时的统计时间。
                $sql_qry="select max(stamp_count) as cnt from tire_exchg_log where tire_id=$rec[tire_id]";
                $ret_qry=$this->conn->query_first($sql_qry);
                $row['run_time']=sprintf('%.2f',intval($ret_qry[cnt])/3600);
                if($rec[status]=="装上"){
                    $row['run_time']=sprintf('%.2f',(time()-ymdhis2ts($rec[install_stamp]))/3600);
                }
//                $row['run_time']=$rec[stamp_count];
                //$row['run_mile']=$rec[b_mc];
                $nums = $this->conn->num_rows($res);
                if($nums==1){
                    $row['run_mile'] = $rec[b_mc];  
                }else{
                    if($rec[b_mc]==$rec[mile_count]&&$rec[uninstall_stamp]=="0000-00-00 00:00:00"){
                        $row['run_mile']=0;
                    }else{
                        if($row['run_time']<24){
                         $row['run_mile']=0;    
                        }else{
                        $row['run_mile']=$rec[mile_count];//车辆的实时里程数据
                        }
                    }
                }
                array_push($rows,$row);
            }
            $arr['count']=$this->conn->num_rows($res);
            

            $arr['rows']=$rows;
            //$result = trim(json_encode($arr),"\xEF\xBB\xBF");
            //$result=@iconv("GBK", "UTF-8//IGNORE", $result);
            $result = json_encode($arr);
            echo $result;
            die();
            //$this->log->do_log($str);
        }else{
            $arr = array ('total'=>0,'count'=>0);
            $result = json_encode($arr);
            //@iconv("GBK", "UTF-8//IGNORE", $result);
            echo $result;
            die();
            //$this->log->do_log($str);
            //die("404, $str\r\n");
        }

        return;
    }

     function exp_figure(){ 
        global $tire_position;

        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator($_SESSION['RealName'])
                                     ->setTitle("Export history");
        //时间、车牌号码、速度、累计里程(Km)、
        //左前轮压力(Kg)、左前轮温度(℃)、
        //右前轮压力(Kg)、右前轮温度(℃)、
        //左后外侧压力(Kg)、左后外侧温度(℃)、
        //左后内侧压力(Kg)、左后内侧温度(℃)、
        //右后外侧压力(Kg)、右后外侧温度(℃)、
        //右后内侧压力(Kg)、右后内侧温度(℃)、
        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', '轮胎胎号')
                    ->setCellValue('B1', '车辆号码')
                    ->setCellValue('C1', '轮胎号位')
                    ->setCellValue('D1', '装车时间')
                    ->setCellValue('E1', '花纹深度');

        $pagesize=mysql_escape_string(trim($_REQUEST["pagesize"].""));
        $page=mysql_escape_string(trim($_REQUEST["page"].""));

        $tire_id_val=mysql_escape_string(trim($_REQUEST["tire_id_val"].""));

        $plate_no = mysql_escape_string(trim($_REQUEST["plate_no"].""));

        $start_time = isset($_REQUEST['start_time']) ? mysql_real_escape_string($_REQUEST['start_time']) : '';

        $end_time = isset($_REQUEST['end_time']) ? mysql_real_escape_string($_REQUEST['end_time']) : '';

        //echo $palte_no;die;
        // if($tire_id_val == ""){
            // $arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
            // echo json_encode($arr);
            // die();
        // }
        //根据轮胎找轮胎记录、车牌以及该轮胎的所有替换记录。
        $sql="select a.*,b.plate_no,b.mile_count as b_mc,c.factory_code,c.fst_place_stamp,c.status from tire_exchg_log as a 
                left join bus_info as b on a.bus_id=b.bus_id
                left join tire_info as c on a.tire_id=c.tire_id where a.place!=0";

        if($tire_id_val != ""){
            $tire_id_val=str_replace(";","','",$tire_id_val);
            $sql.=" where a.tire_id in ('".$tire_id_val."')";
        }
        if($plate_no != ""){
            $sql .= " and b.plate_no ='$plate_no'";
        }
        if($start_time != "" && $end_time != ""){
            $start_time .= " 00:00:00";
            $end_time .= " 23:59:59";
            $sql.= " and a.install_stamp>='$start_time' and a.install_stamp<='$end_time'";
        }
        //echo $sql;die;
        $res_count = $this->conn->query($sql);
        $arr['total']=$this->conn->num_rows($res_count);

        // $sql.=" order by a.bus_id asc,tire_id asc,log_stamp asc";
        if($pagesize!=""&&$page!=""){
            $rec_from=intval($pagesize)*(intval($page)-1);
            $sql.=" limit $rec_from, $pagesize";
        }
        //echo $sql;die;
        $res=$this->conn->query($sql);

        if($this->conn->num_rows($res)>0){
            $rows = array ();
            $line=1;
            while ($rec=$this->conn->fetch_array($res)){
                $line++;
                $row=array();
                $row['time_add']=$rec[install_stamp];
                $row['time_remove']="-";
                if($rec[uninstall_stamp]!="0000-00-00 00:00:00"){
                    $row['time_remove']=$rec[uninstall_stamp];
                }
                $row['place_no']=$tire_position[$rec[place]];
                $row['plate_no']=$rec[plate_no];
                $row['tire_no']=$rec[factory_code];
                $row['figure_mile']=$rec[figure_mile];
//如果是装在车上的轮胎，应该是最后一条缷下时的统计时间，加上（现在时间-最后装上时间）
//如果不是装在车上的轮胎，应该是最后一条缷下时的统计时间。
                $sql_qry="select max(stamp_count) as cnt from tire_exchg_log where tire_id=$rec[tire_id]";
                $ret_qry=$this->conn->query_first($sql_qry);
                $row['run_time']=sprintf('%.2f',intval($ret_qry[cnt])/3600);
                if($rec[status]=="装上"){
                    $row['run_time']=ceil((time()-ymdhis2ts($rec[install_stamp]))/3600);
                }
//                $row['run_time']=$rec[stamp_count];
                //$row['run_mile']=$rec[b_mc];
                $nums = $this->conn->num_rows($res);
                if($nums==1){
                    $row['run_mile'] = $rec[b_mc];  
                }else{
                    if($rec[b_mc]==$rec[mile_count]&&$rec[uninstall_stamp]=="0000-00-00 00:00:00"){
                        $row['run_mile']=0;
                    }else{
                        if($row['run_time']<24){
                         $row['run_mile']=0;    
                        }else{
                        $row['run_mile']=$rec[mile_count];//车辆的实时里程数据
                        }
                    }
                }
               // array_push($rows,$row);
                 $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$line, $row[tire_no])
                    ->setCellValue('B'.$line, $row[plate_no])
                    ->setCellValue('C'.$line, $row[place_no])
                    ->setCellValue('D'.$line, $row[time_add])
                    ->setCellValue('E'.$line, $row[figure_mile]);
            }
             $objPHPExcel->getActiveSheet()->setTitle("导出数据");

            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);

            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="导出数据.xls"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            die();
            //$this->log->do_log($str);
        }else{
            $arr = array ('total'=>0,'count'=>0);
            $result = json_encode($arr);
            //@iconv("GBK", "UTF-8//IGNORE", $result);
            echo $result;
            die();
            //$this->log->do_log($str);
            //die("404, $str\r\n");
        }

        return;
    }

	function qry_search(){
		global $tire_position;
		$pagesize=mysql_escape_string(trim($_REQUEST["pagesize"].""));
		$page=mysql_escape_string(trim($_REQUEST["page"].""));

		$tire_id_val=mysql_escape_string(trim($_REQUEST["tire_id_val"].""));

		$plate_no = mysql_escape_string(trim($_REQUEST["plate_no"].""));
		//echo $palte_no;die;
		// if($tire_id_val == ""){
			// $arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
			// echo json_encode($arr);
			// die();
		// }
        //根据轮胎找轮胎记录、车牌以及该轮胎的所有替换记录。
		$sql="select a.*,b.plate_no,b.mile_count as b_mc,c.factory_code,c.fst_place_stamp,c.status from tire_exchg_log as a 
                left join bus_info as b on a.bus_id=b.bus_id
                left join tire_info as c on a.tire_id=c.tire_id";

        if($tire_id_val != ""){
            $tire_id_val=str_replace(";","','",$tire_id_val);
            $sql.=" where a.tire_id in ('".$tire_id_val."')";
        }
        if($plate_no != ""){
        	$sql .= " where b.plate_no ='$plate_no'";
        }
        $res_count = $this->conn->query($sql);
        $arr['Total']=$this->conn->num_rows($res_count);

        // $sql.=" order by a.bus_id asc,tire_id asc,log_stamp asc";
       if($pagesize!=""&&$page!=""){
			$rec_from=intval($pagesize)*(intval($page)-1);
			$sql.=" limit $rec_from, $pagesize";
		}
        //echo $sql;die;
		$res=$this->conn->query($sql);

		if($this->conn->num_rows($res)>0){
            $rows = array ();
			while ($rec=$this->conn->fetch_array($res)){
                $row=array();
                $row['time_add']=$rec[install_stamp];
                $row['time_remove']="-";
                if($rec[uninstall_stamp]!="0000-00-00 00:00:00"){
                    $row['time_remove']=$rec[uninstall_stamp];
                }
                $row['place_no']=$tire_position[$rec[place]];
                $row['plate_no']=$rec[plate_no];
                $row['tire_no']=$rec[factory_code];
//如果是装在车上的轮胎，应该是最后一条缷下时的统计时间，加上（现在时间-最后装上时间）
//如果不是装在车上的轮胎，应该是最后一条缷下时的统计时间。
                $sql_qry="select max(stamp_count) as cnt from tire_exchg_log where tire_id=$rec[tire_id]";
                $ret_qry=$this->conn->query_first($sql_qry);
                $row['run_time']=sprintf('%.2f',intval($ret_qry[cnt])/3600);
                if($rec[status]=="装上"){
                    $row['run_time']=sprintf('%.2f',(time()-ymdhis2ts($rec[install_stamp]))/3600);
                }
//                $row['run_time']=$rec[stamp_count];
                //$row['run_mile']=$rec[b_mc];
                $nums = $this->conn->num_rows($res);
                if($nums==1){
                    $row['run_mile'] = $rec[b_mc];  
                }else{
                    if($rec[b_mc]==$rec[mile_count]&&$rec[uninstall_stamp]=="0000-00-00 00:00:00"){
                        $row['run_mile']=0;
                    }else{
                        if($row['run_time']<24){
                         $row['run_mile']=0;    
                        }else{
                        $row['run_mile']=$rec[mile_count];//车辆的实时里程数据
                        }
                    }
                }
				array_push($rows,$row);
			}
			$arr['count']=$this->conn->num_rows($res);
			

			$arr['Rows']=$rows;
			//$result = trim(json_encode($arr),"\xEF\xBB\xBF");
			//$result=@iconv("GBK", "UTF-8//IGNORE", $result);
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
		}else{
			$arr = array ('Total'=>0,'count'=>0);
			$result = json_encode($arr);
			//@iconv("GBK", "UTF-8//IGNORE", $result);
			echo $result;
			die();
			//$this->log->do_log($str);
			//die("404, $str\r\n");
		}

		return;
	}

	function exp(){
		global $tire_position;

		$objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator($_SESSION['RealName'])
        							 ->setTitle("Export history");
        //时间、车牌号码、速度、累计里程(Km)、
        //左前轮压力(Kg)、左前轮温度(℃)、
        //右前轮压力(Kg)、右前轮温度(℃)、
        //左后外侧压力(Kg)、左后外侧温度(℃)、
        //左后内侧压力(Kg)、左后内侧温度(℃)、
        //右后外侧压力(Kg)、右后外侧温度(℃)、
        //右后内侧压力(Kg)、右后内侧温度(℃)、
        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', '安装时间')
                    ->setCellValue('B1', '卸载时间')
                    ->setCellValue('C1', '车辆号码')
                    ->setCellValue('D1', '轮胎号码')
                    ->setCellValue('E1', '轮胎胎号')
                    ->setCellValue('F1', '累计运行时长')
                    ->setCellValue('G1', '累计运行里程');


		$pagesize=mysql_escape_string(trim($_REQUEST["pagesize"].""));
		$page=mysql_escape_string(trim($_REQUEST["page"].""));

		$tire_id_val=mysql_escape_string(trim($_REQUEST["tire_id_val"].""));

		$plate_no = mysql_escape_string(trim($_REQUEST["plate_no"].""));
		//echo $palte_no;die;
		// if($tire_id_val == ""){
			// $arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
			// echo json_encode($arr);
			// die();
		// }
        //根据轮胎找轮胎记录、车牌以及该轮胎的所有替换记录。
		$sql="select a.*,b.plate_no,b.mile_count as b_mc,c.factory_code,c.fst_place_stamp,c.status from tire_exchg_log as a 
                left join bus_info as b on a.bus_id=b.bus_id
                left join tire_info as c on a.tire_id=c.tire_id";

        if($tire_id_val != ""){
            $tire_id_val=str_replace(";","','",$tire_id_val);
            $sql.=" where a.tire_id in ('".$tire_id_val."')";
        }
        if($plate_no != ""){
        	$sql .= " where b.plate_no ='$plate_no'";
        }
        $res_count = $this->conn->query($sql);
        $arr['Total']=$this->conn->num_rows($res_count);

        // $sql.=" order by a.bus_id asc,tire_id asc,log_stamp asc";
       if($pagesize!=""&&$page!=""){
			$rec_from=intval($pagesize)*(intval($page)-1);
			$sql.=" limit $rec_from, $pagesize";
		}
        //echo $sql;die;
		$res=$this->conn->query($sql);

		if($this->conn->num_rows($res)>0){
            $rows = array ();
            $line=1;
			while ($rec=$this->conn->fetch_array($res)){
				$line++;
                $row=array();
                $row['time_add']=$rec[install_stamp];
                $row['time_remove']="-";
                if($rec[uninstall_stamp]!="0000-00-00 00:00:00"){
                    $row['time_remove']=$rec[uninstall_stamp];
                }
                $row['place_no']=$tire_position[$rec[place]];
                $row['plate_no']=$rec[plate_no];
                $row['tire_no']=$rec[factory_code];
//如果是装在车上的轮胎，应该是最后一条缷下时的统计时间，加上（现在时间-最后装上时间）
//如果不是装在车上的轮胎，应该是最后一条缷下时的统计时间。
                $sql_qry="select max(stamp_count) as cnt from tire_exchg_log where tire_id=$rec[tire_id]";
                $ret_qry=$this->conn->query_first($sql_qry);
                $row['run_time']=sprintf('%.2f',intval($ret_qry[cnt])/3600);
                if($rec[status]=="装上"){
                     $row['run_time']=sprintf('%.2f',(time()-ymdhis2ts($rec[install_stamp]))/3600);
                }
//                $row['run_time']=$rec[stamp_count];
                //$row['run_mile']=$rec[b_mc];
                $nums = $this->conn->num_rows($res);
                if($nums==1){
                    $row['run_mile'] = $rec[b_mc];  
                }else{
                    if($rec[b_mc]==$rec[mile_count]&&$rec[uninstall_stamp]=="0000-00-00 00:00:00"){
                        $row['run_mile']=0;
                    }else{
                        if($row['run_time']<24){
                         $row['run_mile']=0;    
                        }else{
                        $row['run_mile']=$rec[mile_count];//车辆的实时里程数据
                        }
                    }
                }
				//array_push($rows,$row);


        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$line, $row[time_add])
                    ->setCellValue('B'.$line, $row[time_remove])
                    ->setCellValue('C'.$line, $row[plate_no])
                    ->setCellValue('D'.$line, $row[place_no])
                    ->setCellValue('E'.$line, $row[tire_no])
                    ->setCellValue('F'.$line, $row[run_time])
                    ->setCellValue('G'.$line,$row[run_mile]);
			}

            $objPHPExcel->getActiveSheet()->setTitle("导出数据");

            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);

            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="导出数据.xls"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');

//			$arr['Rows']=$rows;
//			//$result = trim(json_encode($arr),"\xEF\xBB\xBF");
//			//$result=@iconv("GBK", "UTF-8//IGNORE", $result);
//			$result = json_encode($arr);
//			echo $result;
			die();
			//$this->log->do_log($str);
		}else{
			$arr = array ('Total'=>0,'count'=>0);
			$result = json_encode($arr);
			//@iconv("GBK", "UTF-8//IGNORE", $result);
			echo $result;
			die();
			//$this->log->do_log($str);
			//die("404, $str\r\n");
		}
		return;
	}


}

?>