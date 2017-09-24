<?

class figure_type {
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
		添加：ajaction/v1/?menuid=101117&
                figure_no=&
                figure_name=名&
                remark=备注&cmd=add
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function add(){
        global $module_name,$cmd_name;

		$figure_no=mysql_escape_string(trim($_REQUEST["figure_no"].""));
		$figure_name=mysql_escape_string(trim($_REQUEST["figure_name"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));

		if($figure_no == "" || $figure_name==""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}
		
		$sql="insert into figure_type (figure_no,figure_name,remark)
		values ('$figure_no','$figure_name','$remark')";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="添加了新花纹".$figure_name;
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'添加花纹失败！');
			echo json_encode($arr);
			die();
			//$this->log->do_log($str);
		}
		return;
	}

	/**
	 *  修改: ajaction/v1/?menuid=101117&figure_no=&figure_name=名&remark=备注&cmd=edit&figure_id=自增编号
	 */
	function edit(){
        global $module_name,$cmd_name;

		$figure_no=mysql_escape_string(trim($_REQUEST["figure_no"].""));
		$figure_name=mysql_escape_string(trim($_REQUEST["figure_name"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));
		$figure_id=mysql_escape_string(trim($_REQUEST["figure_id"].""));

		if($figure_id == ""){
			$arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
			echo json_encode($arr);
			die();
		}
		if($figure_no == "" && $figure_name == "" && $remark==""){
			$arr = array ('status'=>'ERROR','reason'=>'未指定修改项');
			echo json_encode($arr);
			die();
		}
		$sql="update figure_type set";
		$fields=array();
		// if($figure_no!="")$fields[]=" figure_no='$figure_no'";
		// if($figure_name!="")$fields[]=" figure_name='$figure_name'";
		// if($remark!="")$fields[]=" remark='$remark'";
		$fields[]=" figure_no='$figure_no'";
		$fields[]=" figure_name='$figure_name'";
		$fields[]=" remark='$remark'";
		
		$sql.=implode(",",$fields);
		$sql.=" where figure_id=$figure_id";
		
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="修改了花纹信息".$figure_name;
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
		获取轮胎品牌列表 :  /ajaction/v1?menuid=101117&
                cmd=qry&
                sortname=排序字段&
                sortorder=DESC or ASC &
                pagesize=分页条数&
                page=页数&
                figure_no=花纹代码&
                figure_name=花纹名
		返回 {"Rows":[{"figure_id":id,"figure_no":"","figure_name":"名","remark","备 注"}],"count":1,"Total":11}   其中 count 表示当前反回条数，Total 反回满足条件总记录数
	*/
	function qry(){
		$sortname=mysql_escape_string(trim($_REQUEST["sortname"].""));
		$sortorder=mysql_escape_string(trim($_REQUEST["sortorder"].""));
		$pagesize=mysql_escape_string(trim($_REQUEST["pagesize"].""));
		$page=mysql_escape_string(trim($_REQUEST["page"].""));
		$figure_no=mysql_escape_string(trim($_REQUEST["figure_no"].""));
		$figure_name=mysql_escape_string(trim($_REQUEST["figure_name"].""));
		
		$sql="select * from figure_type";
		$sql_cnt="select count(*) as cnt from figure_type";
		$where="";
		if($figure_no!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" figure_no like '%$figure_no%'";
		}
		if($figure_name!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" figure_name like '%$figure_name%'";
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
		命令 ajaction/v1/?menuid=101117&cmd=qrybyone&figure_id=id号
		反回 {"figure_id":1, "figure_no":"","figure_name":"名","remark":"备注"}
	 */
	function qrybyone(){
		$figure_id=mysql_escape_string(trim($_REQUEST["figure_id"].""));

		$sql="select * from figure_type where figure_id=$figure_id";
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
		删除 :  ?menuid=101117&cmd=del&figure_id=自增编号
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function del(){
        global $module_name,$cmd_name;

		$figure_id=mysql_escape_string(trim($_REQUEST["figure_id"].""));
        $sql="select figure_name from figure_type where figure_id=$figure_id";
        $ret=$this->conn->query_first($sql);
        if(!$ret){
			$arr = array ('status'=>'ERROR','reason'=>'删除失败！未找到要删除的记录。');
			echo json_encode($arr);
			die();
        }

		$sql="delete from figure_type where figure_id=$figure_id";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="删除了花纹信息".$ret['figure_name'];
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'删除失败！');
			echo json_encode($arr);
			die();
			//$this->log->do_log($str);
		}
		return;
	}
}

?>