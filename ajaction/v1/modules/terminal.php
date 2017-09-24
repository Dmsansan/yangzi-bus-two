<?

class terminal {
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
		添加：ajaction/v1/?menuid=101111&
			terminal_ip=&
			store_id=车队名称&
			store_id_val=车队编号&
			remark=备注&cmd=add
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function add(){
        global $module_name,$cmd_name;
        
		$terminal_ip=mysql_escape_string(trim($_REQUEST["terminal_ip"].""));
		$store_id=mysql_escape_string(trim($_REQUEST["store_id"].""));
		$store_id_val=mysql_escape_string(trim($_REQUEST["store_id_val"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));

		if($terminal_ip == "" || $store_id_val==""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}
		
		$sql="insert into terminal (terminal_ip,store_id,remark)
		values ('$terminal_ip',$store_id_val,'$remark')";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="添加了新手持终端".$this->conn->insert_id();
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'添加终端失败！');
			echo json_encode($arr);
			die();
			//$this->log->do_log($str);
		}
		return;
	}

	/**
	 *  修改: ajaction/v1/?menuid=101111&terminal_ip=&store_id=车队名称&store_id_val=车队编号&remark=备注&cmd=edit&terminal_id=终端编号
	 */
	function edit(){
        global $module_name,$cmd_name;
		$terminal_ip=mysql_escape_string(trim($_REQUEST["terminal_ip"].""));
		$store_id=mysql_escape_string(trim($_REQUEST["store_id"].""));
		$store_id_val=mysql_escape_string(trim($_REQUEST["store_id_val"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));
		$terminal_id=mysql_escape_string(trim($_REQUEST["terminal_id"].""));

		if($terminal_id == ""){
			$arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
			echo json_encode($arr);
			die();
		}
		if($terminal_ip == "" && $store_id_val == "" && $store_id==""){
			$arr = array ('status'=>'ERROR','reason'=>'未指定修改项');
			echo json_encode($arr);
			die();
		}
		$sql="update terminal set";
		$fields=array();
		// if($terminal_ip!="")$fields[]=" terminal_ip='$terminal_ip'";
		// if($store_id_val!="")$fields[]=" store_id=$store_id_val";
		// if($remark!="")$fields[]=" remark='$remark'";
		$fields[]=" terminal_ip='$terminal_ip'";
		$fields[]=" store_id=$store_id_val";
		$fields[]=" remark='$remark'";
		
		$sql.=implode(",",$fields);
		$sql.=" where terminal_id=$terminal_id";
		
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="修改了手持终端信息".$terminal_id;
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
		获取手持终端列表 : /ajaction/v1?menuid=101111&cmd=qry&
			sortname=排序字段&
			sortorder=DESC or ASC &
			pagesize=分页条数&
			page=页数&
			terminal_ip=终端IP&
			store_id=车队id
		返回 {"Rows":[{"terminal_id":id,"terminal_ip":"ip","store_name":"车队名","admin_name":"最后一次登陆用户","last_stamp":"最后登陆时间","remark","备注"}],"count":1,"Total":11}
		其中 count 表示当前反回条数，Total 反回满足条件总记录数	*/
	function qry(){
		$sortname=mysql_escape_string(trim($_REQUEST["sortname"].""));
		$sortorder=mysql_escape_string(trim($_REQUEST["sortorder"].""));
		$pagesize=mysql_escape_string(trim($_REQUEST["pagesize"].""));
		$page=mysql_escape_string(trim($_REQUEST["page"].""));
		$terminal_ip=mysql_escape_string(trim($_REQUEST["terminal_ip"].""));
		$store_id=mysql_escape_string(trim($_REQUEST["store_id"].""));

		$sql="select a.*,b.store_name,c.admin_name from terminal as a 
                left join store as b on a.store_id=b.store_id
                left join admins as c on a.last_admin_id=c.admin_id";
		$sql_cnt="select count(*) as cnt from terminal";
		$where="";
		if($terminal_ip!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" terminal_ip like '%$terminal_ip%'";
		}
		if($store_id!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" store_id = $store_id";
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
		命令 ajaction/v1/?menuid=101111&cmd=qrybyone&terminal_id=终端id号
		反回 {"terminal_id":1, "terminal_ip":"ip","store_id":车队编号,"remark":""}
	 */
	function qrybyone(){
		$terminal_id=mysql_escape_string(trim($_REQUEST["terminal_id"].""));

		$sql="select * from terminal where terminal_id=$terminal_id";
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
		终端删除 :  ?menuid=101111&cmd=del&terminal_id=终端编号
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function del(){
        global $module_name,$cmd_name;
		$terminal_id=mysql_escape_string(trim($_REQUEST["terminal_id"].""));

		$sql="delete from terminal where terminal_id=$terminal_id";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="删除了手持终端信息".$terminal_id;
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