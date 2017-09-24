<?

class tire_used_time {
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
		获取轮胎使用总时间查询
		../ajaction/v1/?menuid=131310&cmd=qry&tire_id_val=轮胎ID
        返回 {"Rows":[{"time_add":"装车时间",
            "time_remove":"卸载时间",
            "place_no":轮胎号位,
            "plate_no":"车辆号码",
            "tire_no":轮胎胎号,
            "used_time":使用时间(计算卸载与装车时间差值),
            }],"count":1,"Total":11}
            其中 count 表示当前反回条数，Total 反回满足条件总记录数
    */
	function qry(){
		$tire_id_val=mysql_escape_string(trim($_REQUEST["tire_id_val"].""));
		// if($tire_id_val == ""){
			// $arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
			// echo json_encode($arr);
			// die();
		// }
        //根据轮胎找轮胎记录、车牌以及该轮胎的所有替换记录。
		$sql="select a.*,b.plate_no,c.factory_code,c.fst_place_stamp from tire_exchg_log as a 
                left join bus_info as b on a.bus_id=b.bus_id
                left join tire_info as c on a.tire_id=c.tire_id";
        if($tire_id_val != ""){
            $tire_id_val=str_replace(";","','",$tire_id_val);
            $sql.=" where a.tire_id in ('".$tire_id_val."')";
        }
        // $sql.=" order by a.bus_id asc,tire_id asc,log_stamp asc";
		$res=$this->conn->query($sql);

		if($this->conn->num_rows($res)>0){
            $rows = array ();
			while ($rec=$this->conn->fetch_array($res)){
                $row=array();
                $row['time_add']=$rec[install_stamp];
                $row['time_remove']=$rec[uninstall_stamp];
                $row['place_no']=$rec[place];
                $row['plate_no']=$rec[plate_no];
                $row['tire_no']=$rec[factory_code];
                $row['used_time']=$rec[stamp_count];
                
				array_push($rows,$row);
			}
			$arr['count']=$this->conn->num_rows($res);
			$arr['Total']=$this->conn->num_rows($res);

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