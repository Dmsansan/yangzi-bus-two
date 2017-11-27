<?
require_once(INCLUDE_PATH."PHPExcel/IOFactory.php");
require_once(INCLUDE_PATH."PHPExcel.php");

class realtime_mon {
	var $conn=0;
	//var $log;
	function do_cmd($cmd){
		$this->conn=new db(DB_TYPE,DB_HOST,DB_NAME,DB_USER,DB_PASS,true,SYSTEM_PATH.'log');
		//$this->log=new log($this->conn);
		
		switch($cmd){
			case "qry":
				$this->qry();
				return;
			case "exp":
				$this->exp();
				return;
			case "qrytire":
				$this->qrytire();
				return;
			default:
                $arr = array ('status'=>'ERROR','reason'=>'未知的命令！');
                echo json_encode($arr);
                die();
		}
	}
	
	/**
		实时监控--获取车辆及轮胎实时状态信息
		../ajaction/v1/?menuid=131010&cmd=qry&plate_no=车牌号码
        返回 {"Rows":[{"Time":"时间",
                "Plate_No":"车牌号码",
                "speed":"车子当前速度",
                "overflow_speed":(是否在速度范围，超过为1，正常为0),
                "mile_count":累计里程,
                "pressure1":1号位轮胎压力,
                "overflow_pressure1":是否在压力范围（不是为1，正常为0）,
                "temp1":1号位轮胎温度,
                "overflow_temp1":是否在温度范围（不是为1，正常为0),
                "pressure2":2号位轮胎压力,
                "overflow_pressure2":是否在压力范围（不是为1，正常为0）,
                "temp2":2号位轮胎温度,
                "overflow_temp2":是否在温度范围（不是为1，正常为0),
                    ....(3,4,5,6..压力温度同1、2号位轮胎)},
                    ｛...其它车辆的｝],"count":1,"Total":11}
            其中 count 表示当前反回条数，Total 反回满足条件总记录数

这个接口增加 store_id 参数 (车队)   , 没有值 (store_id= 或 store_id=0 是所有车队的车辆实时状态), 如果有其它值就要筛选出只是这个车队的车辆实时状态

    */
	function qry(){
		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));
		$store_id=mysql_escape_string(trim($_REQUEST["store_id"].""));

        $company_id=mysql_escape_string(trim($_REQUEST["company_id"].""));
        $roules_id=mysql_escape_string(trim($_REQUEST["roules_id"].""));

		$sql="select distinct a.*,a.overflow_pressure1+a.overflow_pressure2+a.overflow_pressure3+a.overflow_pressure4+a.overflow_pressure5+a.overflow_pressure6  as pressureco ,a.overflow_temp1+a.overflow_temp2+a.overflow_temp3+a.overflow_temp4+a.overflow_temp5+a.overflow_temp6  as tempo,b.plate_no,b.speed_limit,b.mile_count,b.wheel_count from bt_real_log as a left join bus_info as b
                on a.bus_id=b.bus_id where b.plate_no like '%$plate_no%'";

        if($plate_no == ""){
            $sql="select distinct a.*,a.overflow_pressure1+a.overflow_pressure2+a.overflow_pressure3+a.overflow_pressure4+a.overflow_pressure5+a.overflow_pressure6  as pressureco ,a.overflow_temp1+a.overflow_temp2+a.overflow_temp3+a.overflow_temp4+a.overflow_temp5+a.overflow_temp6  as tempo,b.plate_no,b.speed_limit,b.mile_count,b.wheel_count from bt_real_log as a left join bus_info as b
                on a.bus_id=b.bus_id where b.plate_no!='' and b.plate_no is not null";
		}
		
		if($store_id!="0" && $store_id!=""){
		    //$sql.= " and b.bus_info=$store_id"; 
			//b.v_term_id in(select v_term_id from vehicle_term where store_id=9)
			$sql.= " and b.v_term_id in (select v_term_id from vehicle_term where store_id=$store_id)"; 
		}
        if($company_id!="0" && $company_id!=""){
            //$sql.= " and b.bus_info=$store_id"; 
            //b.v_term_id in(select v_term_id from vehicle_term where store_id=9)
            $sql.= " and b.company_id ='$company_id'"; 
        }
        if($roules_id!="0" && $roules_id!=""){
            //$sql.= " and b.bus_info=$store_id"; 
            //b.v_term_id in(select v_term_id from vehicle_term where store_id=9)
            $sql.= " and b.roules_id='$roules_id'"; 
        }
		
        $sql.=" order by pressureco desc,tempo desc";
		//
		//echo $sql;
        
		$res=$this->conn->query($sql);
        $arr=array();
        $cnt=0;
		if($this->conn->num_rows($res)>0){
			$arr['count']=$this->conn->num_rows($res);
			$arr['Total']=$this->conn->num_rows($res);
            $rows = array ();
			while ($rec=$this->conn->fetch_array($res)){
                $cnt++;
                $row=array();
                $row['Plate_No']=$rec[plate_no];
                $row['Time']=$rec[log_stamp];
                $row['speed']=$rec[speed];
                $row['max_speed']=$rec[max_speed];
                $row['speed_limit']=$ret1[speed_limit];
                if(intval($rec[speed])>intval($rec[speed_limit])){
                    $row[overflow_speed]='1';
                }else{
                    $row[overflow_speed]='0';
                }
                $row['mile_count']=$rec[mile_count];

                for($i=1;$i<=intval($rec[wheel_count]);$i++){
                    $row["pressure".$i]=$rec["pressure".$i];
                    //if($row["pressure".$i]=="0.00")$row["pressure".$i]="-";
					if($row["pressure".$i]=="255")$row["pressure".$i]="-";
                    $row["overflow_pressure".$i]=$rec["overflow_pressure".$i];
                    $row["temp".$i]=$rec["temp".$i];
                    //if($row["temp".$i]=="0")$row["temp".$i]="-";
					if($row["temp".$i]=="255")$row["temp".$i]="-";  //=255 表示没有温度
                    $row["overflow_temp".$i]=$rec["overflow_temp".$i];
                }
				array_push($rows,$row);
			}
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

	/**
		实时监控--导出车辆及轮胎实时状态信息
		../ajaction/v1/?menuid=131010&cmd=exp&plate_no=车牌号码
        返回 {"Rows":[{"Time":"时间",
                "Plate_No":"车牌号码",
                "speed":"车子当前速度",
                "overflow_speed":(是否在速度范围，超过为1，正常为0),
                "mile_count":累计里程,
                "pressure1":1号位轮胎压力,
                "overflow_pressure1":是否在压力范围（不是为1，正常为0）,
                "temp1":1号位轮胎温度,
                "overflow_temp1":是否在温度范围（不是为1，正常为0),
                "pressure2":2号位轮胎压力,
                "overflow_pressure2":是否在压力范围（不是为1，正常为0）,
                "temp2":2号位轮胎温度,
                "overflow_temp2":是否在温度范围（不是为1，正常为0),
                    ....(3,4,5,6..压力温度同1、2号位轮胎)},
                    ｛...其它车辆的｝],"count":1,"Total":11}
            其中 count 表示当前反回条数，Total 反回满足条件总记录数
    */
	function exp(){
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
                    ->setCellValue('A1', '时间')
                    ->setCellValue('B1', '车牌号码')
                    //->setCellValue('C1', '速度')
                    ->setCellValue('D1', '累计里程(Km)')
                    ->setCellValue('E1', '左前轮压力(Kg)')
                    ->setCellValue('F1', '左前轮温度(℃)')
                    ->setCellValue('G1', '右前轮压力(Kg)')
                    ->setCellValue('H1', '右前轮温度(℃)')
                    ->setCellValue('I1', '左后外侧压力(Kg)')
                    ->setCellValue('J1', '左后外侧温度(℃)')
                    ->setCellValue('K1', '左后内侧压力(Kg)')
                    ->setCellValue('L1', '左后内侧温度(℃)')
                    ->setCellValue('M1', '右后外侧压力(Kg)')
                    ->setCellValue('N1', '右后外侧温度(℃)')
                    ->setCellValue('O1', '右后内侧压力(Kg)')
                    ->setCellValue('P1', '右后内侧温度(℃)');


		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));
		$store_id=mysql_escape_string(trim($_REQUEST["store_id"].""));

//		$sql="select distinct a.*,a.overflow_pressure1+a.overflow_pressure2+a.overflow_pressure3+a.overflow_pressure4+a.overflow_pressure5+a.overflow_pressure6  as pressureco ,a.overflow_temp1+a.overflow_temp2+a.overflow_temp3+a.overflow_temp4+a.overflow_temp5+a.overflow_temp6  as tempo,b.plate_no,b.speed_limit,b.mile_count,b.wheel_count from bt_real_log as a left join bus_info as b
//                on a.bus_id=b.bus_id where b.plate_no like '%$plate_no%' order by pressureco desc,tempo desc";
//
//        if($plate_no == ""){
//            $sql="select distinct a.*,a.overflow_pressure1+a.overflow_pressure2+a.overflow_pressure3+a.overflow_pressure4+a.overflow_pressure5+a.overflow_pressure6  as pressureco ,a.overflow_temp1+a.overflow_temp2+a.overflow_temp3+a.overflow_temp4+a.overflow_temp5+a.overflow_temp6  as tempo,b.plate_no,b.speed_limit,b.mile_count,b.wheel_count from bt_real_log as a left join bus_info as b
//                on a.bus_id=b.bus_id where b.plate_no!='' and b.plate_no is not null order by pressureco desc,tempo desc";
//		}
		$sql="select distinct a.*,a.overflow_pressure1+a.overflow_pressure2+a.overflow_pressure3+a.overflow_pressure4+a.overflow_pressure5+a.overflow_pressure6  as pressureco ,a.overflow_temp1+a.overflow_temp2+a.overflow_temp3+a.overflow_temp4+a.overflow_temp5+a.overflow_temp6  as tempo,b.plate_no,b.speed_limit,b.mile_count,b.wheel_count from bt_real_log as a left join bus_info as b
                on a.bus_id=b.bus_id where b.plate_no like '%$plate_no%'";

        if($plate_no == ""){
            $sql="select distinct a.*,a.overflow_pressure1+a.overflow_pressure2+a.overflow_pressure3+a.overflow_pressure4+a.overflow_pressure5+a.overflow_pressure6  as pressureco ,a.overflow_temp1+a.overflow_temp2+a.overflow_temp3+a.overflow_temp4+a.overflow_temp5+a.overflow_temp6  as tempo,b.plate_no,b.speed_limit,b.mile_count,b.wheel_count from bt_real_log as a left join bus_info as b
                on a.bus_id=b.bus_id where b.plate_no!='' and b.plate_no is not null";
		}
		
		if($store_id!="0" && $store_id!=""){
		    $sql.= " and b.bus_info=$store_id"; 
		}
		
        $sql.=" order by pressureco desc,tempo desc";

		$res=$this->conn->query($sql);
        $arr=array();
        $cnt=0;
		if($this->conn->num_rows($res)>0){
			$arr['count']=$this->conn->num_rows($res);
			$arr['Total']=$this->conn->num_rows($res);
            $rows = array ();
            $line=1;
			while ($rec=$this->conn->fetch_array($res)){
			    $line++;
                $cnt++;
                $row=array();
                $row['Plate_No']=$rec[plate_no];
                $row['Time']=$rec[log_stamp];
                $row['speed']=$rec[speed];
                $row['max_speed']=$rec[max_speed];
                $row['speed_limit']=$ret1[speed_limit];
                if(intval($rec[speed])>intval($rec[speed_limit])){
                    $row[overflow_speed]='1';
                }else{
                    $row[overflow_speed]='0';
                }
                $row['mile_count']=$rec[mile_count];

                for($i=1;$i<=intval($rec[wheel_count]);$i++){
                    $row["pressure".$i]=$rec["pressure".$i];
                    //if($row["pressure".$i]=="0.00")$row["pressure".$i]="-";
					if($row["pressure".$i]=="255")$row["pressure".$i]="-";
                    $row["overflow_pressure".$i]=$rec["overflow_pressure".$i];
                    $row["temp".$i]=$rec["temp".$i];
                    //if($row["temp".$i]=="0")$row["temp".$i]="-";
					if($row["temp".$i]=="255")$row["temp".$i]="-";  //=255 表示没有温度
                    $row["overflow_temp".$i]=$rec["overflow_temp".$i];
                }
//				array_push($rows,$row);


        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$line, $row[Time])
                    ->setCellValue('B'.$line, $row[Plate_No])
                   //->setCellValue('C'.$line, $row[speed])
                    ->setCellValue('D'.$line, $row[mile_count])
                    ->setCellValue('E'.$line, $row[pressure1])
                    ->setCellValue('F'.$line, $row[temp1])
                    ->setCellValue('G'.$line, $row[pressure2])
                    ->setCellValue('H'.$line, $row[temp2])
                    ->setCellValue('I'.$line, $row[pressure3])
                    ->setCellValue('J'.$line, $row[temp3])
                    ->setCellValue('K'.$line, $row[pressure4])
                    ->setCellValue('L'.$line, $row[temp4])
                    ->setCellValue('M'.$line, $row[pressure5])
                    ->setCellValue('N'.$line, $row[temp5])
                    ->setCellValue('O'.$line, $row[pressure6])
                    ->setCellValue('P'.$line, $row[temp6]);
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


	function qry_old(){
		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));

		$sql="select bus_id,plate_no from bus_info where plate_no like '%$plate_no%'";
		if($plate_no == ""){
            $sql="select bus_id,plate_no from bus_info";
		}

		$res=$this->conn->query($sql);
        $arr=array();
        $cnt=0;
		if($this->conn->num_rows($res)>0){
			$arr['count']=$this->conn->num_rows($res);
			$arr['Total']=$this->conn->num_rows($res);
            $rows = array ();
			while ($rec=$this->conn->fetch_array($res)){
                $cnt++;
                $row=array();
                $row['Plate_No']=$rec[plate_no];
                $sql1="select * from bus_speed_log where bus_id='$rec[bus_id]'";
                $ret1=$this->conn->query_first($sql1);
                if($ret1){
                    $row['Time']=$ret1[log_stamp];
                    $row['speed']=$ret1[speed];
                    $row['max_speed']=$ret1[max_speed];
                    $row['speed_limit']=$ret1[speed_limit];
                    if(intval($ret1[speed])>intval($ret1[speed_limit])){
                        $row[overflow_speed]='1';
                    }else{
                        $row[overflow_speed]='0';
                    }
                    $row['mile_count']=$ret1[mile_count];
                }else{
                    $row['Time']='-';
                    $row['speed']='-';
                    $row['max_speed']='-';
                    $row['speed_limit']='-';
                    $row[overflow_speed]='0';
                    $row['mile_count']='-';
                }
                
                $sql2="select a.place, b.* from tire_info as a left join tire_pt_log as b on
                    a.tire_id=b.tire_id where a.plate_no='$rec[plate_no]' order by place asc";

                $res2=$this->conn->query($sql2);
                for($i=1;$i<=intval($rec[wheel_count]);$i++){
                    $row["pressure".$i]=0;
                    $row["overflow_pressure".$i]=0;
                    $row["temp".$i]="-";
                    $row["overflow_temp".$i]=0;
                }
                while ($rec2=$this->conn->fetch_array($res2)){
                    //$row["pressure".$rec2[place]]=($rec2[pressure]=="0.00"?"-":$rec2[pressure]);
					$row["pressure".$rec2[place]]=($rec2[pressure]=="255"?"-":$rec2[pressure]);
                    $row["overflow_pressure".$rec2[place]]=$rec2[o_pressure];
                    //$row["temp".$rec2[place]]=($rec2[temp]=="0"?"-":$rec2[temp]);
					$row["temp".$rec2[place]]=($rec2[temp]=="255"?"-":$rec2[temp]);
                    $row["overflow_temp".$rec2[place]]=$rec2[o_temp];
                }
                $this->conn->free_result($res2);
				array_push($rows,$row);
			}
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

	/**
menuid=131010&cmd=qrytire&plate_no=车牌号
功能: 车辆实时6个轮胎状态
这个反回的内容：
{"Total":6,"count":6,"Rows":[
    {"tire_rfid":"轮胎编号","place":"安装位置","mile_count":"总里程",
    "company_name":"轮胎品牌"，"hwsd":"花纹深度","zcsj":"装车时间","alarm_count":告警次数}]}
	*/
	function qrytire(){
        global $tire_position;

		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));
        /*先查询出品牌、规格、层级、花纹存入数组*/
        $arr_brand=array();
        $sql="select * from brand";
        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
            while ($rec=$this->conn->fetch_array($res)){
				$arr_brand[$rec[brand_id]]=$rec[brand_name];
			}
            $this->conn->free_result($res);
        }

        $arr_norms=array();
        $sql="select * from norms";
        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
            while ($rec=$this->conn->fetch_array($res)){
				$arr_norms[$rec[norms_id]]=$rec[norms_name];
			}
            $this->conn->free_result($res);
        }

        $arr_class=array();
        $sql="select * from class";
        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
            while ($rec=$this->conn->fetch_array($res)){
				$arr_class[$rec[class_id]]=$rec[class_name];
			}
            $this->conn->free_result($res);
        }

        $arr_figure_type=array();
        $sql="select * from figure_type";
        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
            while ($rec=$this->conn->fetch_array($res)){
				$arr_figure_type[$rec[figure_id]]=$rec[figure_name];
			}
            $this->conn->free_result($res);
        }

		$sql="select a.*,b.*,c.* from tire_info as a
                left join tire_param_info as b on a.tire_param_id=b.tire_param_id 
                left join sensor as c on a.sensor_id=c.sensor_id";
		$sql_cnt="select count(*) as cnt from tire_info as a
                left join tire_param_info as b on a.tire_param_id=b.tire_param_id 
                left join sensor as c on a.sensor_id=c.sensor_id";
		$where="";
		if($plate_no!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.plate_no = '$plate_no'";
		}
		$sql.=$where;
		$sql_cnt.=$where;

		$ret=$this->conn->query_first($sql_cnt);
		if($ret['cnt']==0){
			$arr = array ('Total'=>$ret['cnt']);
			echo json_encode($arr);
			die();
		}
		$arr=array();
		$arr['Total']=intval($ret['cnt']);
		$res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
			$arr['count']=$this->conn->num_rows($res);
			$rows = array ();
			while ($rec=$this->conn->fetch_array($res)){
                if(array_key_exists($rec[brand_id],$arr_brand))
                    $rec[brand_name]=$arr_brand[$rec[brand_id]];
                else
                    $rec[brand_name]="";
                
                if(array_key_exists($rec[norms_id],$arr_norms))
                    $rec[norms_name]=$arr_norms[$rec[norms_id]];
                else
                    $rec[norms_name]="";
                
                if(array_key_exists($rec[class_id],$arr_class))
                    $rec[class_name]=$arr_class[$rec[class_id]];
                else
                    $rec[class_name]="";
                
                if(array_key_exists($rec[figure_id],$arr_figure_type))
                    $rec[figure_name]=$arr_figure_type[$rec[figure_id]];
                else
                    $rec[figure_name]="";
                $rec[place]=$tire_position[intval($rec[place])];

				array_push($rows,$rec);
			}
			$arr['Rows']=$rows;
			//$result = trim(json_encode($arr),"\xEF\xBB\xBF");
			//$result=@iconv("GBK", "UTF-8//IGNORE", $result);
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
		}else{
			$arr = array ('Total'=>$ret['cnt']);
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