<?
require_once(INCLUDE_PATH."PHPExcel/IOFactory.php");
require_once(INCLUDE_PATH."PHPExcel.php");

class history_mon {
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
			default:
                $arr = array ('status'=>'ERROR','reason'=>'未知的命令！');
                echo json_encode($arr);
                die();
		}
	}
	
	/**
		命令  ajaction/v1/?menuid=131110&cmd=qry&
                begin_date=2016-02-14开始日期&
                end_date=2016-02-15结束日期&
                plate_no_val=3车辆ID&
                place_no=0（轮胎位置 0为所有，其它表示对应位置轮胎）
        返回 {"Rows":[{"Time":"时间",
                "Plate_No":"车牌号码",
                "speed":"车子当前速 度",
                "overflow_speed":(是否在速度范围，超过为1，正常为0),
                "mile_count":累计里程,
                "pressure1":1号 位轮胎压力,
                "overflow_pressure1":是否在压力范围（不是为1，正常为0）,
                "temp1":1号位轮胎温 度,
                "overflow_temp1":是否在温度范围（不是为1，正常为0),
                "pressure2":2号位轮胎压力,
                "overflow_pressure2":是否在压力范围（不是为1，正常为0）,
                "temp2":2号位轮 胎温度,
                "overflow_temp2":是否在温度范围（不是为1，正常为0),
                    ....(3,4,5,6..压力温度同1、2号位轮胎)}, ｛...其它车辆的｝],
                    "count":1,"Total":11}
            其中 count 表示当前反回条数，Total 反回满足条件总记录数
    */
	function qry(){
		$begin_date=mysql_escape_string(trim($_REQUEST["begin_date"].""));
		$end_date=mysql_escape_string(trim($_REQUEST["end_date"].""));
		$plate_no_val=mysql_escape_string(trim($_REQUEST["plate_no_val"].""));
		$place_no=mysql_escape_string(trim($_REQUEST["place_no"].""));

        if($begin_date==""||$end_date==""){
            $arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
        }
        $begin_date.=" 00:00:00";
        $end_date.=" 23:59:59";

		$sql="select a.*,b.plate_no,b.speed_limit,b.mile_count,b.wheel_count from bt_history_log as a left join bus_info as b
                on a.bus_id=b.bus_id where a.bus_id = '$plate_no_val' and log_stamp>='$begin_date' and log_stamp<='$end_date'";

        if($plate_no_val == ""){
            $sql="select a.*,b.plate_no,b.speed_limit,b.mile_count,b.wheel_count from bt_history_log as a left join bus_info as b
                on a.bus_id=b.bus_id where log_stamp>='$begin_date' and log_stamp<='$end_date'";
		}
		//$sql=""
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
                    if(intval($place_no)!=0 && intval($place_no)!=$i)continue;
                    $row["pressure".$i]=$rec["pressure".$i];
                    $row["overflow_pressure".$i]=$rec["overflow_pressure".$i];
                    $row["temp".$i]=$rec["temp".$i];
                    $row["overflow_temp".$i]=$rec["overflow_temp".$i];
                    if($row["pressure".$i]=="0.00")$row["pressure".$i]="-";
                    if($row["temp".$i]=="0")$row["temp".$i]="-";
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
		命令  ajaction/v1/?menuid=131110&cmd=qry&
                begin_date=2016-02-14开始日期&
                end_date=2016-02-15结束日期&
                plate_no_val=3车辆ID&
                place_no=0（轮胎位置 0为所有，其它表示对应位置轮胎）
        返回 {"Rows":[{"Time":"时间",
                "Plate_No":"车牌号码",
                "speed":"车子当前速 度",
                "overflow_speed":(是否在速度范围，超过为1，正常为0),
                "mile_count":累计里程,
                "pressure1":1号 位轮胎压力,
                "overflow_pressure1":是否在压力范围（不是为1，正常为0）,
                "temp1":1号位轮胎温 度,
                "overflow_temp1":是否在温度范围（不是为1，正常为0),
                "pressure2":2号位轮胎压力,
                "overflow_pressure2":是否在压力范围（不是为1，正常为0）,
                "temp2":2号位轮 胎温度,
                "overflow_temp2":是否在温度范围（不是为1，正常为0),
                    ....(3,4,5,6..压力温度同1、2号位轮胎)}, ｛...其它车辆的｝],
                    "count":1,"Total":11}
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
            ->setCellValue('C1', '速度')
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




		$begin_date=mysql_escape_string(trim($_REQUEST["begin_date"].""));
		$end_date=mysql_escape_string(trim($_REQUEST["end_date"].""));
		$plate_no_val=mysql_escape_string(trim($_REQUEST["plate_no_val"].""));
		$place_no=mysql_escape_string(trim($_REQUEST["place_no"].""));

        if($begin_date==""||$end_date==""){
            $arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
        }
        $begin_date.=" 00:00:00";
        $end_date.=" 23:59:59";

		$sql="select a.*,b.plate_no,b.speed_limit,b.mile_count,b.wheel_count from bt_history_log as a left join bus_info as b
                on a.bus_id=b.bus_id where a.bus_id = '$plate_no_val' and log_stamp>='$begin_date' and log_stamp<='$end_date'";

        if($plate_no_val == ""){
            $sql="select a.*,b.plate_no,b.speed_limit,b.mile_count,b.wheel_count from bt_history_log as a left join bus_info as b
                on a.bus_id=b.bus_id where log_stamp>='$begin_date' and log_stamp<='$end_date'";
		}

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
                    if(intval($place_no)!=0 && intval($place_no)!=$i)continue;
                    $row["pressure".$i]=$rec["pressure".$i];
                    $row["overflow_pressure".$i]=$rec["overflow_pressure".$i];
                    $row["temp".$i]=$rec["temp".$i];
                    $row["overflow_temp".$i]=$rec["overflow_temp".$i];
                    if($row["pressure".$i]=="0.00")$row["pressure".$i]="-";
                    if($row["temp".$i]=="0")$row["temp".$i]="-";
                }
//				array_push($rows,$row);

        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$line, $row[Time])
                    ->setCellValue('B'.$line, $row[Plate_No])
                    ->setCellValue('C'.$line, $row[speed])
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

}

?>