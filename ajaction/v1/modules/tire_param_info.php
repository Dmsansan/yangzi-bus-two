<?
/*
获取轮胎参数列表增加反回字段  "mainterance1":一保值，"mainterance2":二保值
添加修改字段增加  &mainterance1=一保值&mainterance2=二保值
获取单条信息增加反回字段  "mainterance1":一保值，"mainterance2":二保值
*/
class tire_param_info {
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
		添加：ajaction/v1/?menuid=111010&cmd=add&
            company_name=制造商&
            brand_id_val=品牌ID&
            norms_id_val=规格ID&
            class_id_val=层级Id&
            figure_id_val=花纹ID&
            pressure_ll=&
            pressure_ul=&
            speed_ul=&
            temp_ul=&
            tkph_val=&
            baro_val=
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function add(){
        global $module_name,$cmd_name;

		$company_name=mysql_escape_string(trim($_REQUEST["company_name"].""));
		$brand_id_val=mysql_escape_string(trim($_REQUEST["brand_id_val"].""));
		$norms_id_val=mysql_escape_string(trim($_REQUEST["norms_id_val"].""));
		$class_id_val=mysql_escape_string(trim($_REQUEST["class_id_val"].""));
		$figure_id_val=mysql_escape_string(trim($_REQUEST["figure_id_val"].""));
		$pressure_ul=mysql_escape_string(trim($_REQUEST["pressure_ul"].""));
		$pressure_ll=mysql_escape_string(trim($_REQUEST["pressure_ll"].""));
		$speed_ul=mysql_escape_string(trim($_REQUEST["speed_ul"].""));
		$temp_ul=mysql_escape_string(trim($_REQUEST["temp_ul"].""));
		$tkph_val=mysql_escape_string(trim($_REQUEST["tkph_val"].""));
		$baro_val=mysql_escape_string(trim($_REQUEST["baro_val"].""));
		$mainterance1=mysql_escape_string(trim($_REQUEST["mainterance1"].""));
		$mainterance2=mysql_escape_string(trim($_REQUEST["mainterance2"].""));
        $rated_mile=mysql_escape_string(trim($_REQUEST["rated_mile"].""));

		if($company_name == "" || $brand_id_val=="" || $norms_id_val=="" ||
                $class_id_val=="" || $figure_id_val==""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}
		
		$sql="insert into tire_param_info (company_name,brand_id,norms_id,class_id,figure_id,
                pressure_ul,pressure_ll,speed_ul,temp_ul,tkph_val,baro_val,mainterance1,mainterance2,rated_mile)
		values ('$company_name','$brand_id_val','$norms_id_val','$class_id_val','$figure_id_val',
                '$pressure_ul','$pressure_ll','$speed_ul','$temp_ul','$tkph_val','$baro_val','$mainterance1','$mainterance2','$rated_mile')";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="添加了新轮胎参数".$this->conn->insert_id();
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'添加轮胎参数失败！');
			echo json_encode($arr);
			die();
		}
		return;
	}

	/**
	 *  修改: ajaction/v1/?menuid=111010&cmd=edit&tire_param_id=&company_name=制造商&brand_id_val=品牌ID&norms_id_val=规格ID&class_id_val=层级Id&figure_id_val=花纹ID&pressure_ll=&pressure_ul=&speed_ul=&temp_ul=&tkph_val=
	 */
	function edit(){
        global $module_name,$cmd_name;
		$company_name=mysql_escape_string(trim($_REQUEST["company_name"].""));
		$brand_id_val=mysql_escape_string(trim($_REQUEST["brand_id_val"].""));
		$norms_id_val=mysql_escape_string(trim($_REQUEST["norms_id_val"].""));
		$class_id_val=mysql_escape_string(trim($_REQUEST["class_id_val"].""));
		$figure_id_val=mysql_escape_string(trim($_REQUEST["figure_id_val"].""));
		$pressure_ul=mysql_escape_string(trim($_REQUEST["pressure_ul"].""));
		$pressure_ll=mysql_escape_string(trim($_REQUEST["pressure_ll"].""));
		$speed_ul=mysql_escape_string(trim($_REQUEST["speed_ul"].""));
		$temp_ul=mysql_escape_string(trim($_REQUEST["temp_ul"].""));
		$tkph_val=mysql_escape_string(trim($_REQUEST["tkph_val"].""));
		$baro_val=mysql_escape_string(trim($_REQUEST["baro_val"].""));
		//$mainterance1=mysql_escape_string(trim($_REQUEST["mainterance1"].""));
		//$mainterance2=mysql_escape_string(trim($_REQUEST["mainterance2"].""));
		$figure_mile1=mysql_escape_string(trim($_REQUEST["figure_mile1"].""));
        $figure_mile2=mysql_escape_string(trim($_REQUEST["figure_mile2"].""));

		$tire_param_id=mysql_escape_string(trim($_REQUEST["tire_param_id"].""));

		if($tire_param_id == ""){
			$arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
			echo json_encode($arr);
			die();
		}
		if($company_name == "" && $brand_id_val == "" && $norms_id_val == "" 
				&& $class_id_val == "" && $figure_id_val == "" && $pressure_ul==""
                && $pressure_ll == "" && $speed_ul == "" && $temp_ul==""
                && $tkph_val == "" && $baro_val == "" && $mainterance1==""
                && $mainterance2 == "" && $rated_mile == ""
                ){
			$arr = array ('status'=>'ERROR','reason'=>'未指定修改项');
			echo json_encode($arr);
			die();
		}
		$sql="update tire_param_info set";
		$fields=array();
		// if($company_name!="")$fields[]=" company_name='$company_name'";
		// if($brand_id_val!="")$fields[]=" brand_id='$brand_id_val'";
		// if($norms_id_val!="")$fields[]=" norms_id='$norms_id_val'";
		// if($class_id_val!="")$fields[]=" class_id='$class_id_val'";
		// if($figure_id_val!="")$fields[]=" figure_id='$figure_id_val'";
		// if($pressure_ul!="")$fields[]=" pressure_ul='$pressure_ul'";
		// if($pressure_ll!="")$fields[]=" pressure_ll='$pressure_ll'";
		// if($speed_ul!="")$fields[]=" speed_ul='$speed_ul'";
		// if($temp_ul!="")$fields[]=" temp_ul='$temp_ul'";
		// if($tkph_val!="")$fields[]=" tkph_val='$tkph_val'";
		// if($baro_val!="")$fields[]=" baro_val='$baro_val'";
		$fields[]=" company_name='$company_name'";
		$fields[]=" brand_id='$brand_id_val'";
		$fields[]=" norms_id='$norms_id_val'";
		$fields[]=" class_id='$class_id_val'";
		$fields[]=" figure_id='$figure_id_val'";
		$fields[]=" pressure_ul='$pressure_ul'";
		$fields[]=" pressure_ll='$pressure_ll'";
		$fields[]=" speed_ul='$speed_ul'";
		$fields[]=" temp_ul='$temp_ul'";
		$fields[]=" tkph_val='$tkph_val'";
		$fields[]=" baro_val='$baro_val'";
		//$fields[]=" mainterance1='$mainterance1'";
		//$fields[]=" mainterance2='$mainterance2'";
		$fields[]= " figure_mile1='$figure_mile1'";
		$fields[]= " figure_mile2='$figure_mile2'";
		$fields[]=" rated_mile='$rated_mile'";
		
		$sql.=implode(",",$fields);
		$sql.=" where tire_param_id=$tire_param_id";
		
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="修改了轮胎参数信息".$tire_param_id;
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'没有记录被修改');
			echo json_encode($arr);
			die();
		}
		return;
	}

	/**
		获取轮胎品牌列表 : /ajaction/v1?menuid=111010&cmd=qry&
            sortname=排序字段& 
            sortorder=DESC or ASC &
            pagesize=分页条数&
            page=页数&
            company_name=制造商
		返回 {"Rows":[{"tire_param_id":id,"company_name":"","brand_name":"品牌",
                "norms_name":"规格","class_name":"层级",
                "figure_name":"花纹","pressure_ll":"胎压下限","pressure_ul","胎压上限",
                "speed_ul":"速度上限","temp_ul":"温度上限","tkph_val":"tkph值",
                "baro_val":"标准充气压力"}],"count":1,"Total":11}   
            其中 count 表示当前反回条数，Total 反回满足条件总记录数
	*/
	function qry(){
		$sortname=mysql_escape_string(trim($_REQUEST["sortname"].""));
		$sortorder=mysql_escape_string(trim($_REQUEST["sortorder"].""));
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		
		$offset = ($page-1)*$rows;
		$company_name=mysql_escape_string(trim($_REQUEST["company_name"].""));
		
		$sql="select a.*,b.brand_name,c.norms_name,d.class_name,e.figure_name from tire_param_info as a
                left join brand as b on a.brand_id=b.brand_id 
                left join brand as c on a.norms_id=c.brand_id
                left join brand as d on a.class_id=d.brand_id
                left join brand as e on a.figure_id=e.brand_id
                ";
		$sql_cnt="select count(*) as cnt from tire_param_info as a";
		$where="";
		if($company_name!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.company_name like '%$company_name%'";
		}
		$sql.=$where;
		$sql_cnt.=$where;
        if($sortname!="")$sql.=" order by $sortname";
		if($sortorder!="")$sql.=" $sortorder";
		$sql.=" limit $offset, $rows";
		$ret=$this->conn->query_first($sql_cnt);
		if($ret['cnt']==0){
			$arr = array ('Total'=>$ret['cnt']);
			echo json_encode($arr);
			die();
		}
		$arr=array();
		$arr['total']=intval($ret['cnt']);
		$res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
			$arr['count']=$this->conn->num_rows($res);
			$rows = array ();
			while ($rec=$this->conn->fetch_array($res)){
				array_push($rows,$rec);
			}
			$arr['rows']=$rows;
			//$result = trim(json_encode($arr),"\xEF\xBB\xBF");
			//$result=@iconv("GBK", "UTF-8//IGNORE", $result);
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
		}else{
			$arr = array ('total'=>$ret['cnt']);
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
		命令 ajaction/v1/?menuid=111010&cmd=qrybyone&tire_param_id=参数id号
		反回 {"tire_param_id":1, "company_name":"","brand_id":"","norms_id":"","class_id":"","figure_id":"",
            "pressure_ul":1, "pressure_ll":22,"speed_ul":44,"temp_ul":33,"tkph_val":4,"baro_val":34}
	 */
	function qrybyone(){
		$tire_param_id=mysql_escape_string(trim($_REQUEST["tire_param_id"].""));

		$sql="select * from tire_param_info where tire_param_id=$tire_param_id";
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
		删除 :  ?menuid=111010&cmd=del&tire_param_id=参数表编号
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function del(){
        global $module_name,$cmd_name;
		$tire_param_id=mysql_escape_string(trim($_REQUEST["tire_param_id"].""));

		$sql="delete from tire_param_info where tire_param_id=$tire_param_id";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="删除了轮胎参数信息".$tire_param_id;
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