<?

class curve_speed {
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
		获取历史车速曲线
        命令 :  ajaction/v1/?menuid=131614&cmdx=qry&
                begin_date=2016-02-21&
                end_date=2016-02-29&
                plate_no_val=车辆ID
        成功反回:
                {"status":"OK","xdata":["2015-01-01 10:00:00","2015-01-01 10:05:00"],"ydata":[50,60]}
                ydata 为对应的车辆速度
        失败反回:
                {"status":"ERROR","reason":"失败原因"}
    */
	function qry(){
		$begin_date=mysql_escape_string(trim($_REQUEST["begin_date"].""));
		$end_date=mysql_escape_string(trim($_REQUEST["end_date"].""));
		$plate_no_val=mysql_escape_string(trim($_REQUEST["plate_no_val"].""));

        if($begin_date==""||$end_date==""||$plate_no_val==""){
			$arr = array ('ERROR'=>'缺少必要的参数');
			$result = json_encode($arr);
			echo $result;
			die();
        }
        $begin_date.=" 00:00:00";
        $end_date.=" 23:59:59";
        $sql="select bus_id,speed,max_speed,log_stamp from bt_history_log where 
                bus_id='$plate_no_val' and 
                log_stamp>='$begin_date' and 
                log_stamp<='$end_date' order by log_stamp";
		$res=$this->conn->query($sql);
        $arr=array();

		if($this->conn->num_rows($res)>0){
            $xdata=array();
            $ydata=array();
			while ($rec=$this->conn->fetch_array($res)){
                $xdata[]=$rec["log_stamp"];
                $ydata[]=intval($rec["speed"]);
            }
            $arr["status"]="OK";
            $arr["xdata"]=$xdata;
            $arr["ydata"]=$ydata;
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