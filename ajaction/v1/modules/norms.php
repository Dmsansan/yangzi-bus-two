<?

class norms {
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
		添加：ajaction/v1/?menuid=101113&
			norms_no=&
			norms_name=规格名&
			remark=备注&cmd=add
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function add(){
        global $module_name,$cmd_name;

		$norms_no=mysql_escape_string(trim($_REQUEST["norms_no"].""));
		$norms_name=mysql_escape_string(trim($_REQUEST["norms_name"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));

		if($norms_no == "" || $norms_name==""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}
		
		$sql="insert into norms (norms_no,norms_name,remark)
		values ('$norms_no','$norms_name','$remark')";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="添加了新规格".$norms_name;
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'添加轮胎规格失败！');
			echo json_encode($arr);
			die();
		}
		return;
	}

	/**
	 *  修改: ajaction/v1/?menuid=101113&norms_no=&norms_name=规格名&remark=备注&cmd=edit&norms_id=规格自增编号
	 */
	function edit(){
        global $module_name,$cmd_name;

		$norms_no=mysql_escape_string(trim($_REQUEST["norms_no"].""));
		$norms_name=mysql_escape_string(trim($_REQUEST["norms_name"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));
		$norms_id=mysql_escape_string(trim($_REQUEST["norms_id"].""));

		if($norms_id == ""){
			$arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
			echo json_encode($arr);
			die();
		}
		if($norms_no == "" && $norms_name == "" && $remark==""){
			$arr = array ('status'=>'ERROR','reason'=>'未指定修改项');
			echo json_encode($arr);
			die();
		}
		$sql="update norms set";
		$fields=array();
		// if($norms_no!="")$fields[]=" norms_no='$norms_no'";
		// if($norms_name!="")$fields[]=" norms_name='$norms_name'";
		// if($remark!="")$fields[]=" remark='$remark'";
		$fields[]=" norms_no='$norms_no'";
		$fields[]=" norms_name='$norms_name'";
		$fields[]=" remark='$remark'";
		
		$sql.=implode(",",$fields);
		$sql.=" where norms_id=$norms_id";
		
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="修改了规格信息".$norms_name;
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
		获取轮胎规格列表 : /ajaction/v1?menuid=101113&cmd=qry&
			sortname=排序字段& 
			sortorder=DESC or ASC &
			pagesize=分页条数&
			page=页数&
			norms_no=型号代码&
			norms_name=型号名
		返回 {"Rows":[{"norms_id":id,"norms_no":"","norms_name":"规格名","remark","备 注"}],"count":1,"Total":11}   其中 count 表示当前反回条数，Total 反回满足条件总记录数
	*/
	function qry(){
		$sortname=mysql_escape_string(trim($_REQUEST["sortname"].""));
		$sortorder=mysql_escape_string(trim($_REQUEST["sortorder"].""));
		$pagesize=mysql_escape_string(trim($_REQUEST["pagesize"].""));
		$page=mysql_escape_string(trim($_REQUEST["page"].""));
		$norms_no=mysql_escape_string(trim($_REQUEST["norms_no"].""));
		$norms_name=mysql_escape_string(trim($_REQUEST["norms_name"].""));

		$sql="select * from brand";
		$sql_cnt="select count(*) as cnt from brand";
		$where="";
		if($norms_no!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" norms_no like '%$norms_no%'";
		}
		if($norms_name!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" norms_name like '%$norms_name%'";
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
		命令 ajaction/v1/?menuid=101113&cmd=qrybyone&norms_id=规格id号
		反回 {"norms_id":1, "norms_no":"","norms_name":"规格名","remark":"备注"}
	 */
	function qrybyone(){
		$norms_id=mysql_escape_string(trim($_REQUEST["norms_id"].""));

		$sql="select * from norms where norms_id=$norms_id";
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
		轮胎品牌删除 :  ?menuid=101113&cmd=del&norms_id=规格编号
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function del(){
        global $module_name,$cmd_name;

		$norms_id=mysql_escape_string(trim($_REQUEST["norms_id"].""));
        $sql="select norms_name from norms where norms_id=$norms_id";
        $ret=$this->conn->query_first($sql);
        if(!$ret){
			$arr = array ('status'=>'ERROR','reason'=>'删除失败！未找到要删除的记录。');
			echo json_encode($arr);
			die();
        }

		$sql="delete from norms where norms_id=$norms_id";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="删除了规格信息".$ret['norms_name'];
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