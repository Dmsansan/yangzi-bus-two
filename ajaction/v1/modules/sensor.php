<?

class sensor {
	var $conn=0;
	var $log;

	function do_cmd($cmd){
		$this->conn=new db(DB_TYPE,DB_HOST,DB_NAME,DB_USER,DB_PASS,true,SYSTEM_PATH.'log');
		$this->log=new log($this->conn);
		
		switch($cmd){
			case "add":
				$this->add();
				return;
			case "edit":
				$this->edit();
				return;
			case "del":
				$this->del();
				return;
			case "qry":
				$this->qry();
				return;
			case "qrybyone":
				$this->qrybyone();
				return;
			default:
                $arr = array ('status'=>'ERROR','reason'=>'未知的命令！');
                echo json_encode($arr);
                die();
		}
	}
	
	
	/**
		添加：ajaction/v1/?menuid=111011&
				sensor_no=编号&
				pressure_ul=上限&
				pressure_ll=下限&
				temp_ul=上限&
				temp_ll=下限&
				remark=备注&
                sensor_num
				cmd=add
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function add(){
        global $module_name,$cmd_name;

		$sensor_no=mysql_escape_string(trim($_REQUEST["sensor_no"].""));
		$pressure_ul=mysql_escape_string(trim($_REQUEST["pressure_ul"].""));
		$pressure_ll=mysql_escape_string(trim($_REQUEST["pressure_ll"].""));
		$temp_ul=mysql_escape_string(trim($_REQUEST["temp_ul"].""));
		$temp_ll=mysql_escape_string(trim($_REQUEST["temp_ll"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));
        $sensor_num=mysql_escape_string(trim($_REQUEST["sensor_num"].""));
        $tire_switch=mysql_escape_string(trim($_REQUEST["tire_switch"].""));
        
		if($sensor_no == "" || $pressure_ul=="" || $pressure_ll=="" || $temp_ul=="" || $temp_ll==""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}
		
        if($sensor_num!=""){        //批量添加传感器
            $cnt=0;
            for($i=1;$i<=intval($sensor_num);$i++){
                $sensor_no_X=sprintf("%s%X",$sensor_no,$i);
                $sql="insert into sensor (sensor_no,pressure_ul,pressure_ll,temp_ul,temp_ll,remark)
                    values ('$sensor_no_X','$pressure_ul','$pressure_ll','$temp_ul','$temp_ll','$remark')";
                $this->conn->query($sql);
                if($this->conn->affected_rows()>0){
                    $cnt++;
                    $sensor_id_val=$this->conn->insert_id();
                    
                    $str="添加了新传感器".$sensor_no_X;
                    $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
                    
                    
                    
                    
                    if($tire_switch=="on"){
                        $sql="select * from tire_addmore where store_id=0 and tire_switch='on' and admin_name='轮胎注册'";
                        $ret=$this->conn->query_first($sql);

                        if(!$ret){
                            $arr = array ('status'=>'ERROR','reason'=>'传感器添加成功，但添加关联轮胎失败(批量添加开关关闭，请使用轮胎注册账号登录并打开批量添加开关)！');
                            echo json_encode($arr);
                            die();
                        }else{
                            $factory_code=$sensor_no_X."000";
                            $sql="insert into tire_info (tire_rfid,sensor_id,factory_code,brand_id,tire_param_id,
                                    figure_value,rated_mile,rated_hour,order_num,price,p_staff,
                                    remark)
                            values ('$sensor_no_X','$sensor_id_val','$factory_code','$ret[brand_id]','$ret[tire_param_id]',
                                    '0','0','0','0','0','0','')";

                            $this->conn->query($sql);
                            if($this->conn->affected_rows()>0){
                                $str="添加了关联轮胎".$factory_code;
                                $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
                            }else{
                                $arr = array ('status'=>'ERROR','reason'=>'传感器添加成功，但添加关联轮胎失败！');
                                echo json_encode($arr);
                                die();
                            }
                        }
                    }

                    
                    
                    
                }
            }
            if($cnt==0){
                $arr = array ('status'=>'ERROR','reason'=>'添加传感器失败！');
                echo json_encode($arr);
                die();
            }else{
                $arr = array ('status'=>'OK');
                echo json_encode($arr);
                die();
            }
        }else{                  //单独传感器
            $sql="insert into sensor (sensor_no,pressure_ul,pressure_ll,temp_ul,temp_ll,remark)
            values ('$sensor_no','$pressure_ul','$pressure_ll','$temp_ul','$temp_ll','$remark')";
            $this->conn->query($sql);
            if($this->conn->affected_rows()>0){
                $sensor_id_val=$this->conn->insert_id();
                $str="添加了新传感器".$sensor_no;
                $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
                
                if($tire_switch=="on"){
                    $sql="select * from tire_addmore where store_id=0 and tire_switch='on'";
                    $ret=$this->conn->query_first($sql);
                    if(!$ret){
                        $arr = array ('status'=>'ERROR','reason'=>'传感器添加成功，但添加关联轮胎失败(批量添加开关关闭)！');
                        echo json_encode($arr);
                        die();
                    }else{
                        $factory_code=$sensor_no."000";
                        $sql="insert into tire_info (tire_rfid,sensor_id,factory_code,brand_id,tire_param_id,
                                figure_value,rated_mile,rated_hour,order_num,price,p_staff,
                                remark)
                        values ('$sensor_no','$sensor_id_val','$factory_code','$ret[brand_id]','$ret[tire_param_id]',
                                '0','0','0','0','0','0','')";
                        $this->conn->query($sql);
                        if($this->conn->affected_rows()>0){
                            $str="添加了关联轮胎".$factory_code;
                            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
                            $arr = array ('status'=>'OK');
                            echo json_encode($arr);
                            die();
                        }else{
                            $arr = array ('status'=>'ERROR','reason'=>'传感器添加成功，但添加关联轮胎失败(批量添加开关关闭)！');
                        echo json_encode($arr);
                            die();
                        }
                    }
                }
                $arr = array ('status'=>'OK');
                echo json_encode($arr);
                die();
            }else{
                $arr = array ('status'=>'ERROR','reason'=>'添加传感器失败！');
                echo json_encode($arr);
                die();
            }
        }
		return;
	}

	/**
	 *  修改: ajaction/v1/?menuid=101112&sensor_no=&sensor_name=品牌名&remark=备注&cmd=edit&sensor_id=品牌自增编号
	 */
	function edit(){
        global $module_name,$cmd_name;

		$sensor_no=mysql_escape_string(trim($_REQUEST["sensor_no"].""));
		$pressure_ul=mysql_escape_string(trim($_REQUEST["pressure_ul"].""));
		$pressure_ll=mysql_escape_string(trim($_REQUEST["pressure_ll"].""));
		$temp_ul=mysql_escape_string(trim($_REQUEST["temp_ul"].""));
		$temp_ll=mysql_escape_string(trim($_REQUEST["temp_ll"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));
		$sensor_id=mysql_escape_string(trim($_REQUEST["sensor_id"].""));

		if($sensor_id == ""){
			$arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
			echo json_encode($arr);
			die();
		}
		if($sensor_no == "" && $pressure_ul == "" && $pressure_ll == "" 
				&& $temp_ul == "" && $temp_ll == "" && $remark==""){
			$arr = array ('status'=>'ERROR','reason'=>'未指定修改项');
			echo json_encode($arr);
			die();
		}
		$sql="update sensor set";
		$fields=array();
		// if($sensor_no!="")$fields[]=" sensor_no='$sensor_no'";
		// if($pressure_ul!="")$fields[]=" pressure_ul='$pressure_ul'";
		// if($pressure_ll!="")$fields[]=" pressure_ll='$pressure_ll'";
		// if($temp_ul!="")$fields[]=" temp_ul='$temp_ul'";
		// if($temp_ll!="")$fields[]=" temp_ll='$temp_ll'";
		// if($remark!="")$fields[]=" remark='$remark'";
		$fields[]=" sensor_no='$sensor_no'";
		$fields[]=" pressure_ul='$pressure_ul'";
		$fields[]=" pressure_ll='$pressure_ll'";
		$fields[]=" temp_ul='$temp_ul'";
		$fields[]=" temp_ll='$temp_ll'";
		$fields[]=" remark='$remark'";
		
		$sql.=implode(",",$fields);
		$sql.=" where sensor_id=$sensor_id";
		
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="修改了传感器信息".$sensor_no;
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'没有记录被修改');
			echo json_encode($arr);
			die();
			//$this->log->do_log($str);
		}
		return;
	}

	/**
		获取轮胎品牌列表 : /ajaction/v1?menuid=111011&
			cmd=qry&
			sortname=排序字段& 
			sortorder=DESC or ASC &
			pagesize=分页条数&
			page=页数&
			sensor_no=传感器代码
		返回 {"Rows":[{"sensor_id":id,"sensor_no":"","pressure_ul":"上限","pressure_ll":"下限","temp_ul":"上限","temp_ll":"下限","remark","备 注"}],"count":1,"Total":11}   其中 count 表示当前反回条数，Total 反回满足条件总记录数
	*/
	function qry(){
		$sortname=mysql_escape_string(trim($_REQUEST["sortname"].""));
		$sortorder=mysql_escape_string(trim($_REQUEST["sortorder"].""));
		$pagesize=mysql_escape_string(trim($_REQUEST["pagesize"].""));
		$page=mysql_escape_string(trim($_REQUEST["page"].""));
		$sensor_no=mysql_escape_string(trim($_REQUEST["sensor_no"].""));
		
		$sql="select * from sensor";
		$sql_cnt="select count(*) as cnt from sensor";
		$where="";
		if($sensor_no!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" sensor_no like '%$sensor_no%'";
		}
		$sql.=$where;
		$sql_cnt.=$where;
        if($sortname!="")$sql.=" order by $sortname";
		if($sortorder!="")$sql.=" $sortorder";
		if($pagesize!=""&&$page!=""){
			$rec_from=intval($pagesize)*(intval($page)-1);
			$sql.=" limit $rec_from, $pagesize";
		}

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
	
	/**
		命令 ajaction/v1/?menuid=111011&cmd=qrybyone&sensor_id=id号
		反回 {"sensor_id":id,"sensor_no":"","pressure_ul":"上限","pressure_ll":"下限","temp_ul":"上限","temp_ll":"下限","remark","备 注"}
	 */
	function qrybyone(){
		$sensor_id=mysql_escape_string(trim($_REQUEST["sensor_id"].""));

		$sql="select * from sensor where sensor_id=$sensor_id";
		$ret=$this->conn->query_first($sql);
		if(!$ret){
			$arr = array ('Total'=>0);
			echo json_encode($arr);
			die();
		}else{
			echo json_encode($ret);
			die();
		}
		return;
	}

	/**
		传感器删除 :  ?menuid=111011&cmd=del&sensor_id=自增编号
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function del(){
        global $module_name,$cmd_name;
		$sensor_id=mysql_escape_string(trim($_REQUEST["sensor_id"].""));
        $sql="select sensor_no from sensor where sensor_id=$sensor_id";
        $ret=$this->conn->query_first($sql);
        if(!$ret){
			$arr = array ('status'=>'ERROR','reason'=>'删除失败！未找到要删除的记录。');
			echo json_encode($arr);
			die();
        }

		$sql="delete from sensor where sensor_id=$sensor_id";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="删除了传感器信息".$ret['sensor_no'];
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'删除失败！');
			echo json_encode($arr);
			die();
		}
		return;
	}
}

?>