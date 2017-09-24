<?

class curve_pt {
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
		获取轮胎压力或温度曲线 --按车辆和轮胎号位查
        命令  ajaction/v1/?menuid=131610&cmdx=qry&
                begin_date=开始日期&
                end_date=结束时间&
                plate_no=车牌号&
                plate_no_val=车辆ID&
                charts_no=曲线类型&
                place_no_v=轮胎号位
        说明 : plate_no 或 plate_no_val 随便用哪一个
                charts_no=0 为压力数据
                charts_no=1 为温度数据
        反回（压力数据有 max 和min , 温度数据只有 温度上限 max）:
                {"status":"OK",
                "xdata":["2015-01-01","2015-01-02"],
                "ydata":[30.1,40.5],
                "max":50,
                "min":10}
        失败反回:{"status":"ERROR","reason":"失败原因"}
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
        
        $pressure_ul=array();
        $pressure_ll=array();
        $temp_ul=array();
        for($i=0;$i<10;$i++){
            $pressure_ul[$i]=12.5;
            $pressure_ll[$i]=6.5;
            $temp_ul[$i]=90;
        }
        
        $sql="select a.tire_id,a.place,b.pressure_ul,b.pressure_ll,b.temp_ul from tire_info as a
                left join tire_param_info as b on a.tire_param_id=b.tire_param_id where
                plate_no='$plate_no'";
        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
			while ($rec=$this->conn->fetch_array($res)){
                $pressure_ul[intval($rec[place])]=floatval($rec[pressure_ul]);
                $pressure_ll[intval($rec[place])]=floatval($rec[pressure_ll]);
                $temp_ul[intval($rec[place])]=intval($rec[temp_ul]);
            }
        }
        
        $begin_date.=" 00:00:00";
        $end_date.=" 23:59:59";
        $sql="select * from bt_history_log where 
                bus_id='$plate_no_val' and 
                log_stamp>='$begin_date' and 
                log_stamp<='$end_date' order by log_stamp";
		$res=$this->conn->query($sql);
        $arr=array();
        $max=0;$min=100;

		if($this->conn->num_rows($res)>0){
            $xdata=array();
            $ydata=array();
			while ($rec=$this->conn->fetch_array($res)){
                if($charts_no=="0"){    //压力数据
					if($rec["pressure".$place]!="255"){
						$xdata[]=$rec["log_stamp"];
						$ydata[]=floatval($rec["pressure".$place]);
						$max=$pressure_ul[$place];
						$min=$pressure_ll[$place];
					}
                    // if(intval($rec["pressure".$place])>$max){
                        // $max=intval($rec["pressure".$place]);
                    // }
                    // if(intval($rec["pressure".$place])<$min){
                        // $min=intval($rec["pressure".$place]);
                    // }
                }
                if($charts_no=="1"){    //温度数据
					if($rec["temp".$place]!="255"){
						$xdata[]=$rec["log_stamp"];
						$ydata[]=floatval($rec["temp".$place]);
						$max=$temp_ul[$place];
						$min=0;
					}
                    // if(intval($rec["temp".$place])>$max){
                        // $max=intval($rec["temp".$place]);
                    // }
                    // if(intval($rec["temp".$place])<$min){
                        // $min=intval($rec["temp".$place]);
                    // }
                }
            }
            $arr["status"]="OK";
            $arr["xdata"]=$xdata;
            $arr["ydata"]=$ydata;
            $arr["max"]=$max;
            $arr["min"]=$min;
 			$result = json_encode($arr);
			echo $result;
			die();
       }else{
			$arr = array ('ERROR'=>'没有数据');
			$result = json_encode($arr);
			echo $result;
			die();
        }
   
		return;
	}
}

?>