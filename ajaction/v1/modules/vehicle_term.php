<?

class vehicle_term {
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
		添加：ajaction/v1/?menuid=101115&
			v_term_no=终端编号&
			v_term_name=终端名&
			plate_no=车牌号&
			store_id_val=所属车队Id&
			remark=备注&cmd=add
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function add(){
        global $module_name,$cmd_name;

		$v_term_no=mysql_escape_string(trim($_REQUEST["v_term_no"].""));
		$v_term_name=mysql_escape_string(trim($_REQUEST["v_term_name"].""));
		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));
		$store_id_val=mysql_escape_string(trim($_REQUEST["store_id_val"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));

		if($v_term_no == "" || $v_term_name==""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}
		
		$sql="insert into vehicle_term (v_term_no,v_term_name,plate_no,store_id,remark)
		values ('$v_term_no','$v_term_name','$plate_no','$store_id_val','$remark')";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="添加了新车载终端".$v_term_name;
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK','reason'=>'车载终端添加成功！');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'添加车载终端失败！');
			echo json_encode($arr);
			die();
		}
		return;
	}

	/**
	 *  修改
		修改:  ajaction/v1/?menuid=101115&v_term_no=终端编号&v_term_name=终端名&plate_no=车牌号&store_id_val=所属车队Id&remark=备注&cmd=edit&v_term_id=终端自增编号
	 */
	function edit(){
        global $module_name,$cmd_name;

		$v_term_no=mysql_escape_string(trim($_REQUEST["v_term_no"].""));
		$v_term_name=mysql_escape_string(trim($_REQUEST["v_term_name"].""));
		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));
		$store_id_val=mysql_escape_string(trim($_REQUEST["store_id_val"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));
		$v_term_id=mysql_escape_string(trim($_REQUEST["v_term_id"].""));

		if($v_term_id == ""){
			$arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
			echo json_encode($arr);
			die();
		}
		if($v_term_no == "" && $v_term_name == "" && $plate_no=="" && $store_id_val=="" &&
			$remark==""){
			$arr = array ('status'=>'ERROR','reason'=>'未指定修改项');
			echo json_encode($arr);
			die();
		}

		$sql="update vehicle_term set";
		$fields=array();
		// if($v_term_no!="")$fields[]=" v_term_no='$v_term_no'";
		// if($v_term_name!="")$fields[]=" v_term_name='$v_term_name'";
		// if($plate_no!="")$fields[]=" plate_no='$plate_no'";
		// if($store_id_val!="")$fields[]=" store_id='$store_id_val'";
		// if($remark!="")$fields[]=" remark='$remark'";
		$fields[]=" v_term_no='$v_term_no'";
		$fields[]=" v_term_name='$v_term_name'";
		$fields[]=" plate_no='$plate_no'";
		$fields[]=" store_id='$store_id_val'";
		$fields[]=" remark='$remark'";
		
		$sql.=implode(",",$fields);
		$sql.=" where v_term_id=$v_term_id";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="修改了车载终端信息".$v_term_name;
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK','reason'=>'车载终端修改成功！');
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
		获取车载终端列表 : /ajaction/v1?menuid=101115&cmd=qry&
			sortname=排序字段& 
			sortorder=DESC or ASC &
			pagesize=分页条数&
			page=页数&
			v_term_no=终端代码&
			plate_no=车牌号&
			v_term_name=终端名
		返回 {"Rows":[{"v_term_id":id,"v_term_no":"","v_term_name":"终端名","plate_no":"车牌号","store_id":"所属车队","mile_count":"累计里程","renew_stamp":"更新时间","remark","备 注"}],"count":1,"Total":11}   其中 count 表示当前反回条数，Total 反回满足条件总记录数	*/
	function qry(){
		$sortname=mysql_escape_string(trim($_REQUEST["sortname"].""));
		$sortorder=mysql_escape_string(trim($_REQUEST["sortorder"].""));
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		
		$offset = ($page-1)*$rows;
		$v_term_no=mysql_escape_string(trim($_REQUEST["v_term_no"].""));
		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));
		$v_term_name=mysql_escape_string(trim($_REQUEST["v_term_name"].""));

		$sql="select a.*,b.store_name from vehicle_term as a
                left join store as b on a.store_id=b.store_id";
		$sql_cnt="select count(*) as cnt from vehicle_term as a";
		$where="";
		if($v_term_no!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.v_term_no like '%$v_term_no%'";
		}
		if($plate_no!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.plate_no like '%$plate_no%'";
		}
		if($v_term_name!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.v_term_name like '%$v_term_name%'";
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
		命令 ajaction/v1/?menuid=101115&cmd=qrybyone&v_term_id=终端id号
		反回 {"v_term_id":1, "v_term_no":"","v_term_name":"终端名","plate_no":"车牌号","store_id":"所属车队","remark":"备注"}	 */
	function qrybyone(){
		$v_term_id=mysql_escape_string(trim($_REQUEST["v_term_id"].""));

		$sql="select * from vehicle_term where v_term_id=$v_term_id";
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
	 * 车载终端删除 :  ?menuid=101115&cmd=del&v_term_id=终端自增编号
	 * 成功反回 {"status":"OK"}
	 * 失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function del(){
        global $module_name,$cmd_name;
		$v_term_id=mysql_escape_string(trim($_REQUEST["v_term_id"].""));

        $sql="select v_term_name from vehicle_term where v_term_id=$v_term_id";
        $ret=$this->conn->query_first($sql);
        if(!$ret){
			$arr = array ('status'=>'ERROR','reason'=>'删除失败！未找到要删除的记录。');
			echo json_encode($arr);
			die();
        }

		$sql="delete from vehicle_term where v_term_id=$v_term_id";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="删除了车载终端信息".$ret['v_term_name'];
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK','reason'=>'车载终端删除成功！');
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