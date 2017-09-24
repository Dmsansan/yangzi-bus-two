<?

class curve_pt_alarm {
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
	
	/**
		获取轮胎压力或温度告警 --按车辆和轮胎号位查
        命令  ajaction/v1/?menuid=131612&cmdx=qry&
                begin_date=开始日期&
                end_date=结束时间&
                plate_no=车牌号&
                plate_no_val=车辆ID&
                charts_no=曲线类型&
                place_no_v=轮胎号位
        说明 : plate_no 或 plate_no_val 随便用哪一个
                charts_no=0 为压力告警
                charts_no=1 为温度告警
        反回 温度告警没有低出的，只有前2个（正常数和高出）
                {"status":"OK","data":[正常数,高出上限数,低出下限数数]}
        失败反回:
                {"status":"ERROR","reason":"失败原因"}
    */
	function qry(){
		$begin_date=mysql_escape_string(trim($_REQUEST["begin_date"].""));
		$end_date=mysql_escape_string(trim($_REQUEST["end_date"].""));
		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));
		$plate_no_val=mysql_escape_string(trim($_REQUEST["plate_no_val"].""));
		$charts_no=mysql_escape_string(trim($_REQUEST["charts_no"].""));
		$place=mysql_escape_string(trim($_REQUEST["place_no_v"].""));

        if($begin_date==""||$end_date==""||$plate_no==""||$plate_no_val==""||$charts_no==""||$place==""){
			$arr = array ('ERROR'=>'缺少必要的参数');
			$result = json_encode($arr);
			echo $result;
			die();
        }
        
        $sql="select a.tire_id,b.pressure_ul,b.pressure_ll,b.temp_ul from tire_info as a
                left join tire_param_info as b on a.tire_param_id=b.tire_param_id where
                plate_no='$plate_no' and place='$place'";
        $ret=$this->conn->query_first($sql);
        if(!$ret){
			$arr = array ('ERROR'=>'未找到轮胎信息');
			$result = json_encode($arr);
			echo $result;
			die();
        }
        
        $begin_date.=" 00:00:00";
        $end_date.=" 23:59:59";

        if($charts_no=="0"){    //压力数据
            $data=array();
            $field="pressure".$place;
            $sql="select count(*) as cnt from bt_history_log where 
                    bus_id='$plate_no_val' and 
                    log_stamp>='$begin_date' and 
                    log_stamp<='$end_date'";

            $sql0=$sql." and ($field<=$ret[pressure_ul] and $field>=$ret[pressure_ll])";
            $ret1=$this->conn->query_first($sql0);
            $data[]=intval($ret1[cnt]);
            
            $sql1=$sql." and $field>$ret[pressure_ul]";
            $ret1=$this->conn->query_first($sql1);
            $data[]=intval($ret1[cnt]);

            $sql1=$sql." and $field<$ret[pressure_ll]";
            $ret1=$this->conn->query_first($sql1);
            $data[]=intval($ret1[cnt]);
            
            $arr["status"]="OK";
            $arr["data"]=$data;
 			$result = json_encode($arr);
			echo $result;
			die();
        }
        if($charts_no=="1"){    //温度数据
            $data=array();
            $field="temp".$place;
            $sql="select count(*) as cnt from bt_history_log where 
                    bus_id='$plate_no_val' and 
                    log_stamp>='$begin_date' and 
                    log_stamp<='$end_date'";

            $sql0=$sql." and $field<=$ret[temp_ul]";
            $ret1=$this->conn->query_first($sql0);
            $data[]=intval($ret1[cnt]);
            
            $sql1=$sql." and $field>$ret[temp_ul]";
            $ret1=$this->conn->query_first($sql1);
            $data[]=intval($ret1[cnt]);
            
            $arr["status"]="OK";
            $arr["data"]=$data;
 			$result = json_encode($arr);
			echo $result;
			die();
        }
		return;
	}
}

?>