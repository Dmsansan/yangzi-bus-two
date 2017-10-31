<?
require_once(INCLUDE_PATH."PHPExcel/IOFactory.php");
require_once(INCLUDE_PATH."PHPExcel.php");

class alarm_history_mon {
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
	
	/**车辆轮胎告警历史记录
		命令  /ajaction/v1/?menuid=131210&cmd=qry&
                begin_date=时间开始&
                end_date=结束&
                plate_no_val=车辆ID&
                place_no=轮胎号位（0为所有,其它值为其它轮胎）

        返回 {"Rows":[{
                "Time":"时间",
                "Plate_No":"车牌号码",
                "place_no":轮胎号位,
                "sensor_no":"车载控制器编号",
                "tire_no":轮胎胎号,
                "pressure_val":轮胎压力,
                "pressure":压力阀值（下限-上限）,
                "temp_val":轮胎温度,
                "temp_ul":温度上限}],"count":1,"Total":11}   
        其中 count 表示当前反回条数，Total 反回满足条件总记录数
    */
	function qry(){
        global $tire_position;
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

		$sql="select a.*,b.plate_no,c.v_term_no,d.factory_code from bus_alarm_log as a 
                left join bus_info as b on a.bus_id=b.bus_id
                left join vehicle_term as c on a.v_term_id=c.v_term_id
                left join tire_info as d on a.tire_id=d.tire_id
            where a.bus_id = '$plate_no_val' and log_stamp>='$begin_date' and log_stamp<='$end_date'";

        if($plate_no_val == ""){
            $sql="select a.*,b.plate_no,c.v_term_no,d.factory_code from bus_alarm_log as a 
                left join bus_info as b on a.bus_id=b.bus_id
                left join vehicle_term as c on a.v_term_id=c.v_term_id
                left join tire_info as d on a.tire_id=d.tire_id
            where log_stamp>='$begin_date' and log_stamp<='$end_date'";
		}
        if($place_no!="0" && $place_no!=""){
            $sql.=" and a.place='$place_no'";
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
/*
                "place_no":轮胎号位,
                "sensor_no":"车载控制器编号",
                "tire_no":轮胎胎号,
                "pressure_val":轮胎压力,
                "pressure":压力阀值（下限-上限）,
                "temp_val":轮胎温度,
                "temp_ul":温度上限}],"count":1,"Total":11}   
*/
                $row['Plate_No']=$rec[plate_no];
                $row['Time']=$rec[log_stamp];
                $row['place_no']=$tire_position[$rec[place]];
                $row['tire_no']=$rec[factory_code];
                $row['sensor_no']=$rec[v_term_no];
                $row['pressure_val']=$rec[pressure];
                $row['pressure']=$rec[pressure_ll]."-".$rec[pressure_ul];
                $row['temp_val']=$rec[temp];
                $row['temp_ul']=$rec[temp_ul];

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

	/**车辆轮胎告警历史记录
		命令  /ajaction/v1/?menuid=131210&cmd=qry&
                begin_date=时间开始&
                end_date=结束&
                plate_no_val=车辆ID&
                place_no=轮胎号位（0为所有,其它值为其它轮胎）

        返回 {"Rows":[{
                "Time":"时间",
                "Plate_No":"车牌号码",
                "place_no":轮胎号位,
                "sensor_no":"车载控制器编号",
                "tire_no":轮胎胎号,
                "pressure_val":轮胎压力,
                "pressure":压力阀值（下限-上限）,
                "temp_val":轮胎温度,
                "temp_ul":温度上限}],"count":1,"Total":11}   
        其中 count 表示当前反回条数，Total 反回满足条件总记录数
    */
	function exp(){
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator($_SESSION['RealName'])
							 ->setTitle("Export history");
/*
时间
车牌号码
轮胎号位
车载控制器编号
轮胎胎号
轮胎压力(Kg)
压力阀值(Kg)
轮胎温度(℃)
温度上限(℃)
*/
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '时间')
            ->setCellValue('B1', '车牌号码')
            ->setCellValue('C1', '轮胎号位')
            ->setCellValue('D1', '车载控制器编号')
            ->setCellValue('E1', '轮胎胎号')
            ->setCellValue('F1', '轮胎压力(Kg)')
            ->setCellValue('G1', '压力阀值(Kg)')
            ->setCellValue('H1', '轮胎温度(℃)')
            ->setCellValue('I1', '温度上限(℃)');


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

		$sql="select a.*,b.plate_no,c.v_term_no,d.factory_code from bus_alarm_log as a 
                left join bus_info as b on a.bus_id=b.bus_id
                left join vehicle_term as c on a.v_term_id=c.v_term_id
                left join tire_info as d on a.tire_id=d.tire_id
            where a.bus_id = '$plate_no_val' and log_stamp>='$begin_date' and log_stamp<='$end_date'";

        if($plate_no_val == ""){
            $sql="select a.*,b.plate_no,c.v_term_no,d.factory_code from bus_alarm_log as a 
                left join bus_info as b on a.bus_id=b.bus_id
                left join vehicle_term as c on a.v_term_id=c.v_term_id
                left join tire_info as d on a.tire_id=d.tire_id
            where log_stamp>='$begin_date' and log_stamp<='$end_date'";
		}
        if($place_no!="0" && $place_no!=""){
            $sql.=" and a.place='$place_no'";
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
/*
                "place_no":轮胎号位,
                "sensor_no":"车载控制器编号",
                "tire_no":轮胎胎号,
                "pressure_val":轮胎压力,
                "pressure":压力阀值（下限-上限）,
                "temp_val":轮胎温度,
                "temp_ul":温度上限}],"count":1,"Total":11}   
*/
                $row['Plate_No']=$rec[plate_no];
                $row['Time']=$rec[log_stamp];
                $row['place_no']=$rec[place];
                $row['tire_no']=$rec[factory_code];
                $row['sensor_no']=$rec[v_term_no];
                $row['pressure_val']=$rec[pressure];
                $row['pressure']=$rec[pressure_ll]."-".$rec[pressure_ul];
                $row['temp_val']=$rec[temp];
                $row['temp_ul']=$rec[temp_ul];

//				array_push($rows,$row);
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$line, $row[Time])
                    ->setCellValue('B'.$line, $row[Plate_No])
                    ->setCellValue('C'.$line, $row[place_no])
                    ->setCellValue('D'.$line, $row[sensor_no])
                    ->setCellValue('E'.$line, $row[tire_no])
                    ->setCellValue('F'.$line, $row[pressure_val])
                    ->setCellValue('G'.$line, $row[pressure])
                    ->setCellValue('H'.$line, $row[temp_val])
                    ->setCellValue('I'.$line, $row[temp_ul]);


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