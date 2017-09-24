<?

class alarm_mon_store {
	var $conn=0;
	//var $log;

	function do_cmd($cmd){
		$this->conn=new db(DB_TYPE,DB_HOST,DB_NAME,DB_USER,DB_PASS,true,SYSTEM_PATH.'log');
		//$this->log=new log($this->conn);
		
		switch($cmd){
			case "qry":
				$this->qry();
				return;
			default:
                $arr = array ('status'=>'ERROR','reason'=>'未知的命令！');
                echo json_encode($arr);
                die();
		}
	}
	
	/**按车队查询时段内的胎压告警记录
		命令  /ajaction/v1/?menuid=131112&cmd=qry&
                begin_date=时间开始&
                end_date=结束&
                store_list_val  车队ID列表(,号分隔)

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
		$begin_date=mysql_escape_string(trim($_REQUEST["begin_date"].""));
		$end_date=mysql_escape_string(trim($_REQUEST["end_date"].""));
		$store_list_val=mysql_escape_string(trim($_REQUEST["store_list_val"].""));
		
        if($begin_date==""||$end_date==""){
            $arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
        }
        $begin_date.=" 00:00:00";
        $end_date.=" 23:59:59";

		$sql="select a.*,b.plate_no,c.v_term_no,d.factory_code,d.store_id from bus_alarm_log as a 
                left join bus_info as b on a.bus_id=b.bus_id
                left join vehicle_term as c on a.v_term_id=c.v_term_id
                left join tire_info as d on a.tire_id=d.tire_id
            where d.store_id in ($store_list_val) and log_stamp>='$begin_date' and log_stamp<='$end_date'";
//die($sql);
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
                $row['place_no']=$rec[place];
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
}

?>