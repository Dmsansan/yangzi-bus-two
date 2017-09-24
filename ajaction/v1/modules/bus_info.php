<?

class bus_info {
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
	
/*
  create table bus_info (
    bus_id          int auto_increment,
    plate_no        varchar(20)         comment '车牌号码',
    bus_no          varchar(32)         comment '车辆编号',
    bus_type        varchar(32)         comment '车辆型号',
    curr_speed      float(6,2)          comment '当前速度',
    factory         varchar(100)        comment '厂商',
    wheel_count     int                 comment '轮数',
    store_id        int                 comment '仓库/车队ID',
    v_term_id       int                 comment '车载终端ID',
    remark          varchar(200)        comment '备注',
    primary key (bus_id),
    unique (plate_no)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
*/
	
	/**
		添加：ajaction/v1/?menuid=121010&cmd=add&
                plate_no=车牌号&
                terminal_id_val=终端ID
                remark=备注
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function add(){
        global $module_name,$cmd_name;

		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));
		$bus_no=mysql_escape_string(trim($_REQUEST["bus_no"].""));
		$bus_type=mysql_escape_string(trim($_REQUEST["bus_type"].""));
		$factory=mysql_escape_string(trim($_REQUEST["factory"].""));
        $speed_limit=mysql_escape_string(trim($_REQUEST["speed_limit"].""));
		$wheel_count=mysql_escape_string(trim($_REQUEST["wheel_count_val"].""));
		$v_term_id=mysql_escape_string(trim($_REQUEST["terminal_id_val"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));
		
		if($plate_no == ""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}
		
		$sql="insert into bus_info (plate_no,bus_no,bus_type,factory,wheel_count,speed_limit,
                v_term_id,remark,add_stamp)
		values ('$plate_no','$bus_no','$bus_type','$factory','$wheel_count','$speed_limit',
                '$v_term_id','$remark',now())";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="添加了新车辆".$plate_no;
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'添加车辆失败！');
			echo json_encode($arr);
			die();
			//$this->log->do_log($str);
		}
		return;
	}

	/**
	 *  修改: ajaction/v1/?menuid=121010&cmd=edit&plate_no=车牌号&terminal_id_val=终端IDremark=备注
	 */
	function edit(){
        global $module_name,$cmd_name;

		$bus_no=mysql_escape_string(trim($_REQUEST["bus_no"].""));
		$bus_type=mysql_escape_string(trim($_REQUEST["bus_type"].""));
		$factory=mysql_escape_string(trim($_REQUEST["factory"].""));
        $speed_limit=mysql_escape_string(trim($_REQUEST["speed_limit"].""));
		$wheel_count=mysql_escape_string(trim($_REQUEST["wheel_count_val"].""));
		$v_term_id=mysql_escape_string(trim($_REQUEST["terminal_id_val"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));

		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));

		if($plate_no == ""){
			$arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
			echo json_encode($arr);
			die();
		}
		if($bus_no == "" && $bus_type == "" && $factory == "" && $speed_limit == ""
				&& $wheel_count == "" && $v_term_id == "" && $remark==""
                ){
			$arr = array ('status'=>'ERROR','reason'=>'未指定修改项');
			echo json_encode($arr);
			die();
		}
		$sql="update bus_info set";
		$fields=array();
		// if($bus_no!="")$fields[]=" bus_no='$bus_no'";
		// if($bus_type!="")$fields[]=" bus_type='$bus_type'";
		// if($factory!="")$fields[]=" factory='$factory'";
		// if($speed_limit!="")$fields[]=" speed_limit='$speed_limit'";
		// if($wheel_count!="")$fields[]=" wheel_count='$wheel_count'";
		// if($v_term_id!="")$fields[]=" v_term_id='$v_term_id'";
		// if($remark!="")$fields[]=" remark='$remark'";
		$fields[]=" bus_no='$bus_no'";
		$fields[]=" bus_type='$bus_type'";
		$fields[]=" factory='$factory'";
		$fields[]=" speed_limit='$speed_limit'";
		$fields[]=" wheel_count='$wheel_count'";
		$fields[]=" v_term_id='$v_term_id'";
		$fields[]=" remark='$remark'";
		
		$sql.=implode(",",$fields);
		$sql.=" where plate_no='$plate_no'";
		
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="修改了车辆信息".$plate_no;
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
		获取列表 : /ajaction/v1?menuid=121010&cmd=qry&
                sortname=排序字段&
                sortorder=DESC or ASC &
                pagesize=分页条数&
                page=页数&
                plate_no=汽车号码
		返回 {"Rows":[{"bus_id":bus_id,"plate_no":"","v_term_no":"车载编号","remark":"说明"}],"count":1,"Total":11}
                其中 count 表示当前反回条数，Total 反回满足条件总记录数
	*/
	function qry(){
		$sortname=mysql_escape_string(trim($_REQUEST["sortname"].""));
		$sortorder=mysql_escape_string(trim($_REQUEST["sortorder"].""));
		$pagesize=mysql_escape_string(trim($_REQUEST["pagesize"].""));
		$page=mysql_escape_string(trim($_REQUEST["page"].""));
		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));
		$begin_date=mysql_escape_string(trim($_REQUEST["bdate"].""));
		$end_date=mysql_escape_string(trim($_REQUEST["edate"].""));
        if($begin_date!="")$begin_date.=" 00:00:00";
        if($end_date!="")$end_date.=" 23:59:59";

		$sql="select a.*,b.v_term_no from bus_info as a left join vehicle_term as b on a.v_term_id=b.v_term_id";
		$sql_cnt="select count(*) as cnt from bus_info";
		$where="";
        $where1="";
		if($plate_no!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.plate_no like '%$plate_no%'";
			if($where1=="")
				$where1=" where";
			else
				$where1.=" and";
			$where1.=" plate_no like '%$plate_no%'";
		}
		if($begin_date!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.add_stamp >= '$begin_date'";
			if($where1=="")
				$where1=" where";
			else
				$where1.=" and";
			$where1.=" add_stamp >= '$begin_date'";
		}
		if($end_date!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.add_stamp <= '$end_date'";
			if($where1=="")
				$where1=" where";
			else
				$where1.=" and";
			$where1.=" add_stamp <= '$end_date'";
		}

		$sql.=$where;
		$sql_cnt.=$where1;
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
		命令 ajaction/v1/?menuid=121010&cmd=qrybyone&plate_no=车牌号
		反回 {"plate_no":"车牌号", "v_term_id":"","remark":"备注"}
	 */
	function qrybyone(){
		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));

		$sql="select * from bus_info where plate_no='$plate_no'";
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
		删除 :  ajaction/v1/?menuid=121010&cmd=del&plate_no=车牌号
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function del(){
        global $module_name,$cmd_name;

		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));

		$sql="delete from bus_info where plate_no='$plate_no'";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="删除了车辆信息".$plate_no;
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