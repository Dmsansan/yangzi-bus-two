<?

class roules {
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
		添加：ajaction/v1/?menuid=101112&
			brand_no=&
			brand_name=品牌名&
			remark=备注&cmd=add
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function add(){
        global $module_name,$cmd_name;

		//$brand_no=mysql_escape_string(trim($_REQUEST["brand_no"].""));
		$roules_name=mysql_escape_string(trim($_REQUEST["roules_name"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));

		if($roules_name==""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}
		
		$sql="insert into roules (roules_name,remark) values ('$roules_name','$remark')";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="添加了新线路".$brand_name;
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK','reason'=>'线路添加成功！');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'添加线路失败！');
			echo json_encode($arr);
			die();
			//$this->log->do_log($str);
		}
		return;
	}

	/**
	 *  修改: ajaction/v1/?menuid=101112&brand_no=&brand_name=品牌名&remark=备注&cmd=edit&brand_id=品牌自增编号
	 */
	function edit(){
        global $module_name,$cmd_name;

		//$brand_no=mysql_escape_string(trim($_REQUEST["brand_no"].""));
		$roules_name=mysql_escape_string(trim($_REQUEST["roules_name"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));
		$id=mysql_escape_string(trim($_REQUEST["id"].""));

		if($id == ""){
			$arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
			echo json_encode($arr);
			die();
		}
		if($roules_name == "" && $remark==""){
			$arr = array ('status'=>'ERROR','reason'=>'未指定修改项');
			echo json_encode($arr);
			die();
		}
		$sql="update roules set";
		$fields=array();
		// if($brand_no!="")$fields[]=" brand_no='$brand_no'";
		// if($brand_name!="")$fields[]=" brand_name='$brand_name'";
		// if($remark!="")$fields[]=" remark='$remark'";
		//$fields[]=" brand_no='$brand_no'";
		$fields[]=" roules_name='$roules_name'";
		$fields[]=" remark='$remark'";
		
		$sql.=implode(",",$fields);
		$sql.=" where id=$id";
		
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="修改了分公司信息".$brand_name;
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK','reason'=>'线路修改成功！');
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
		获取轮胎品牌列表 : /ajaction/v1?menuid=101112&cmd=qry&
			sortname=排序字段& 
			sortorder=DESC or ASC &
			pagesize=分页条数&
			page=页数&
			brand_no=品牌编号&
			brand_name=品牌名
		返回 {"Rows":[{"brand_id":id,"brand_no":"","brand_name":"品牌名","remark","备 注"}],"count":1,"Total":11}   其中 count 表示当前反回条数，Total 反回满足条件总记录数
	*/
	function qry(){
		$sortname=mysql_escape_string(trim($_REQUEST["sortname"].""));
		$sortorder=mysql_escape_string(trim($_REQUEST["sortorder"].""));
		$pagesize=mysql_escape_string(trim($_REQUEST["pagesize"].""));
		$page=mysql_escape_string(trim($_REQUEST["page"].""));
		//$brand_no=mysql_escape_string(trim($_REQUEST["brand_no"].""));
		$roules_name=mysql_escape_string(trim($_REQUEST["roules_name"].""));

		$sql="select * from roules";
		$sql_cnt="select count(*) as cnt from roules";
		$where="";
		/*if($brand_no!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" brand_no like '%$brand_no%'";
		}*/
		if($roules_name!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" roules_name like '%$roules_name%'";
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
		命令 ajaction/v1/?menuid=101112&cmd=qrybyone&brand_id=品牌id号
		反回 {"brand_id":1, "brand_no":"","brand_name":"品牌名","remark":"备注"}
	 */
	function qrybyone(){
		//$roules_name=mysql_escape_string(trim($_REQUEST["roules_name"].""));
		$id=mysql_escape_string(trim($_REQUEST["id"].""));
        
		$sql="select * from roules where id=$id";
		$ret=$this->conn->query_first($sql);
		if(!$ret){
			$arr = array ('total'=>0);
			echo json_encode($arr);
			die();
		}else{
			echo json_encode($ret);
			die();
		}
		return;
	}

	/**
		轮胎品牌删除 :  ?menuid=101112&cmd=del&brand_id=品牌编号
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function del(){
        global $module_name,$cmd_name;

		$id=mysql_escape_string(trim($_REQUEST["id"].""));
        $sql="select roules_name from roules where id=$id";
		
        $ret=$this->conn->query_first($sql);
        if(!$ret){
			$arr = array ('status'=>'ERROR','reason'=>'删除失败！未找到要删除的记录。');
			echo json_encode($arr);
			die();
        }

		$sql="delete from roules where id=$id";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="删除了分公司信息".$ret[roules_name];
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK','reason'=>'线路删除成功！');
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