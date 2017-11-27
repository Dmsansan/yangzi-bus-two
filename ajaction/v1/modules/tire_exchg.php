<?

class tire_exchg {
	var $conn=0;
	var $log;

	function do_cmd($cmd){
		$this->conn=new db(DB_TYPE,DB_HOST,DB_NAME,DB_USER,DB_PASS,true,SYSTEM_PATH.'log');
		$this->log=new log($this->conn);
		
		switch($cmd){
			case "addtire":
				$this->install_tire();
				return;
			case "removeTire":
				$this->uninstall_tire();
				return;
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
		安装轮胎：ajaction/v1/?menuid=121011&cmd=addtire&
                plate_no=车牌号&
                tire_id_val=轮胎ID&
                place_no_val=位置编号
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function install_tire(){
        global $module_name,$cmd_name;
		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));
		$tire_id_val=mysql_escape_string(trim($_REQUEST["tire_id_val"].""));
		$place_no_val=mysql_escape_string(trim($_REQUEST["place_no_val"].""));
		
		$figure_mile=mysql_escape_string(trim($_REQUEST["figure_mile"].""));

		if($plate_no == "" || $tire_id_val=="" || $place_no_val==""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}
		
        //1、确定该轮胎没有被安装；
        $sql="select * from tire_info where tire_id='$tire_id_val'";
        $ret=$this->conn->query_first($sql);
        //致标志位
        $param_id=$ret[tire_param_id];
        $param_sql="select figure_mile2 from  tire_param_info where tire_param_id='$param_id'";
        $param_ret=$this->conn->query_first($param_sql);
        if($figure_mile < $param_ret[figure_mile2]){
        	$bf=1;
        }else{
        	$bf=0;
        }
        if(!$ret){
			$arr = array ('status'=>'ERROR','reason'=>'未找到指定的轮胎！');
			echo json_encode($arr);
			die();
        }
        if(intval($ret[place])!=0){
			$arr = array ('status'=>'ERROR','reason'=>'指定的轮胎已经安装在车辆上了！');
			echo json_encode($arr);
			die();
        }
        $fst_place_stamp=$ret[fst_place_stamp];
        
        //2、确定该车辆是存在的；
        $sql="select * from bus_info where plate_no='$plate_no'";
        $ret1=$this->conn->query_first($sql);
        if(!$ret1){
			$arr = array ('status'=>'ERROR','reason'=>'未找到指定的车辆！');
			echo json_encode($arr);
			die();
        }
    
        //3、确定该车相应胎位是空置的；（根据车牌和胎位找有没有轮胎，找到说明该位置有轮胎装着）
        $sql="select count(*) as cnt from tire_info where plate_no='$plate_no' and place='$place_no_val'";
        $ret=$this->conn->query_first($sql);
        if(intval($ret[cnt])>0){
			$arr = array ('status'=>'ERROR','reason'=>'指定的轮胎位置上已经安装了其它轮胎！');
			echo json_encode($arr);
			die();
        }

        //4、安装轮胎。
        if($fst_place_stamp=="0000-00-00 00:00:00")
            $sql="update tire_info set bus_mile_count={$ret1[mile_count]},status='装上',plate_no='$plate_no', place='$place_no_val', place_stamp=now(), fst_place_stamp=now(),figure_value='$figure_mile',bf='$bf' where tire_id='$tire_id_val'";
        else
            $sql="update tire_info set bus_mile_count={$ret1[mile_count]},status='装上',plate_no='$plate_no', place='$place_no_val', place_stamp=now(),figure_value='$figure_mile',bf='$bf' where tire_id='$tire_id_val'";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str=$plate_no."在".$place_no_val."号位安装了轮胎";
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK');
			echo json_encode($arr);
            
            //5、更新轮胎替换日志
            $sql="insert into tire_exchg_log (tire_id,bus_id,v_term_id,place,
                    install_stamp,uninstall_stamp,mile_count,stamp_count,action,log_stamp,figure_mile) value
                    ('$tire_id_val','$ret1[bus_id]','$ret1[v_term_id]','$place_no_val',
                    NOW(),'0000-00-00 00:00:00','$ret1[mile_count]',0,'装上',NOW(),'$figure_mile')";
            $this->conn->query($sql);
            $exchg_id=$this->conn->insert_id();
            $sql="update tire_info set exchg_id='$exchg_id' where tire_id='$tire_id_val'";
            $this->conn->query($sql);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'添加轮胎失败！');
			echo json_encode($arr);
			die();
			//$this->log->do_log($str);
		}
		return;
	}

	/**
		卸载轮胎：ajaction/v1/?menuid=121011&cmd=removeTire&tire_id=轮胎ID
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function uninstall_tire(){
        global $module_name,$cmd_name;
		$tire_id=mysql_escape_string(trim($_REQUEST["tire_id"].""));
		
		if($tire_id == ""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}
		
        //1、确定该轮胎已被安装在车辆上；
        $sql="select * from tire_info where tire_id='$tire_id'";
        $ret=$this->conn->query_first($sql);
        if(!$ret){
			$arr = array ('status'=>'ERROR','reason'=>'未找到指定的轮胎！');
			echo json_encode($arr);
			die();
        }
        if(intval($ret[place])==0){
			$arr = array ('status'=>'ERROR','reason'=>'指定的轮胎没有安装在车辆上！');
			echo json_encode($arr);
			die();
        }

        //2、取得车辆ID；
        $sql="select * from bus_info where plate_no='$ret[plate_no]'";
        $ret1=$this->conn->query_first($sql);
        // if(!$ret1){
			// $arr = array ('status'=>'ERROR','reason'=>'未找到指定的车辆！');
			// echo json_encode($arr);
			// die();
        // }

        //3、确定该车相应胎位是空置的；（根据车牌和胎位找有没有轮胎，找到说明该位置有轮胎装着）
        // $sql="select count(*) as cnt from tire_info where plate_no='$plate_no' and place='$place_no_val'";
        // $ret=$this->conn->query_first($sql);
        // if(intval($ret[cnt])>0){
			// $arr = array ('status'=>'ERROR','reason'=>'指定的轮胎位置上已经安装了其它轮胎！');
			// echo json_encode($arr);
			// die();
        // }

        //4、卸载轮胎。
		$sql="update tire_info set tire_mile_count=mile_count,status='卸下',plate_no='', place='0', place_stamp=now() where tire_id='$tire_id'";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str=$ret[plate_no]."在".$ret[place]."号位卸载了轮胎";
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK');
			echo json_encode($arr);
            
            //5、更新轮胎替换日志
            // $sql="insert into tire_exchg_log (tire_id,bus_id,place,action,log_stamp) value
                    // ('$tire_id','$ret1[bus_id]','$ret[place]','卸下',NOW())";
            //先查符合条件的安装记录，然后更新卸载时间。
            $sql="select id,install_stamp from tire_exchg_log where tire_id='$tire_id' 
                    and bus_id='$ret1[bus_id]' 
                    and place='$ret[place]'
                    and uninstall_stamp='0000-00-00 00:00:00'
                    and action='装上' order by log_stamp desc limit 1";
            $ret_id=$this->conn->query_first($sql);
            if(!$ret_id){
                $sql="insert into tire_exchg_log (tire_id,bus_id,v_term_id,place,
                        install_stamp,uninstall_stamp,mile_count,stamp_count,action,log_stamp) value
                        ('$tire_id','$ret1[bus_id]','$ret1[v_term_id]','$ret[place]',
                        NOW(),NOW(),'$ret1[mile_count]',0,'装上',NOW())";
            }else{
                //计算使用时长，计算里程，计算
                $curr_tm=time();
                $uninstall_stamp=date("Y-m-d H:i:s",$curr_tm);
                $inst_tm=ymdhis2ts($ret_id[install_stamp]);
                $stamp_count=$curr_tm-$inst_tm;
                
                $sql="update tire_exchg_log set
                        uninstall_stamp='$uninstall_stamp',
                        stamp_count='$stamp_count',
                        action='卸下',
                        log_stamp='$uninstall_stamp' where id=$ret_id[id]";
            }
            $this->conn->query($sql);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'卸载轮胎失败！');
			echo json_encode($arr);
			die();
			//$this->log->do_log($str);
		}
		return;
	}

	/**
		获取轮胎列表 : /ajaction/v1?menuid=121011&cmd=qry&plate_no=车牌号码
		返回 {"Rows":[{"tire_id":tire_id,"place":"胎位","sensor_no":"传感器编号",
                "factory_code":"出厂编码","brand_name":"品牌","norms":"规格/层级/花纹",
                "speed_ul":"速度上限","temp_ul":"温度上限","pressure_ul":"胎压上限",
                "pressure_ul":"胎压下限"}],"count":1,"Total":11}
                其中 count 表示当前反回条数，Total 反回满足条件总记录数
	*/
	function qry(){
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
        $sql="select * from brand";
        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
            while ($rec=$this->conn->fetch_array($res)){
				$arr_norms[$rec[brand_id]]=$rec[norms_name];
			}
            $this->conn->free_result($res);
        }

        $arr_class=array();
        $sql="select * from brand";
        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
            while ($rec=$this->conn->fetch_array($res)){
				$arr_class[$rec[brand_id]]=$rec[class_name];
			}
            $this->conn->free_result($res);
        }

        $arr_figure_type=array();
        $sql="select * from brand";
        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
            while ($rec=$this->conn->fetch_array($res)){
				$arr_figure_type[$rec[brand_id]]=$rec[figure_name];
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
                
                if(array_key_exists($rec[brand_id],$arr_norms))
                    $rec[norms_name]=$arr_norms[$rec[brand_id]];
                else
                    $rec[norms_name]="";
                
                if(array_key_exists($rec[brand_id],$arr_class))
                    $rec[class_name]=$arr_class[$rec[brand_id]];
                else
                    $rec[class_name]="";
                
                if(array_key_exists($rec[brand_id],$arr_figure_type))
                    $rec[figure_name]=$arr_figure_type[$rec[brand_id]];
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