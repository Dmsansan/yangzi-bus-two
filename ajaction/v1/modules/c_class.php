<?

class c_class {
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
	
	function add(){
        global $module_name,$cmd_name;
        
		$class_no=mysql_escape_string(trim($_REQUEST["class_no"].""));
		$class_name=mysql_escape_string(trim($_REQUEST["class_name"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));

		if($class_no == "" || $class_name==""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}
		
		$sql="insert into class (class_no,class_name,remark)
		values ('$class_no','$class_name','$remark')";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="添加了新层级".$class_name;
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'添加层级失败！');
			echo json_encode($arr);
			die();
			//$this->log->do_log($str);
		}
		return;
	}

	function edit(){
        global $module_name,$cmd_name;

		$class_no=mysql_escape_string(trim($_REQUEST["class_no"].""));
		$class_name=mysql_escape_string(trim($_REQUEST["class_name"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));
		$class_id=mysql_escape_string(trim($_REQUEST["class_id"].""));

		if($class_id == ""){
			$arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
			echo json_encode($arr);
			die();
		}
		if($class_no == "" && $class_name == "" && $remark==""){
			$arr = array ('status'=>'ERROR','reason'=>'未指定修改项');
			echo json_encode($arr);
			die();
		}
		$sql="update class set";
		$fields=array();
		// if($class_no!="")$fields[]=" class_no='$class_no'";
		// if($class_name!="")$fields[]=" class_name='$class_name'";
		// if($remark!="")$fields[]=" remark='$remark'";
		$fields[]=" class_no='$class_no'";
		$fields[]=" class_name='$class_name'";
		$fields[]=" remark='$remark'";
		
		$sql.=implode(",",$fields);
		$sql.=" where class_id=$class_id";
		
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="修改了层级信息".$class_name;
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

	function qry(){
		$sortname=mysql_escape_string(trim($_REQUEST["sortname"].""));
		$sortorder=mysql_escape_string(trim($_REQUEST["sortorder"].""));
		$pagesize=mysql_escape_string(trim($_REQUEST["pagesize"].""));
		$page=mysql_escape_string(trim($_REQUEST["page"].""));
		$class_no=mysql_escape_string(trim($_REQUEST["class_no"].""));
		$class_name=mysql_escape_string(trim($_REQUEST["class_name"].""));

		$sql="select * from class";
		$sql_cnt="select count(*) as cnt from class";
		$where="";
		if($class_no!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" class_no like '%$class_no%'";
		}
		if($class_name!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" class_name like '%$class_name%'";
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
	
	function qrybyone(){
		$class_id=mysql_escape_string(trim($_REQUEST["class_id"].""));

		$sql="select * from class where class_id=$class_id";
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

	function del(){
        global $module_name,$cmd_name;

		$class_id=mysql_escape_string(trim($_REQUEST["class_id"].""));
        $sql="select class_name from class where class_id=$class_id";
        $ret=$this->conn->query_first($sql);
        if(!$ret){
			$arr = array ('status'=>'ERROR','reason'=>'删除失败！未找到要删除的记录。');
			echo json_encode($arr);
			die();
        }
        

		$sql="delete from class where class_id=$class_id";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="删除了层级信息".$ret['class_name'];
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