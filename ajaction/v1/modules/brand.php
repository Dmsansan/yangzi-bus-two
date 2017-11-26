<?

class brand {
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
			norms_name=规格名称&
			class_name=层级名称&
			figure_name=花纹名称&
			remark=备注&cmd=add
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function add(){
        global $module_name,$cmd_name;

		//$brand_no=mysql_escape_string(trim($_REQUEST["brand_no"].""));
		$brand_name=mysql_escape_string(trim($_REQUEST["brand_name"].""));
		$norms_name=mysql_escape_string(trim($_REQUEST["norms_name"].""));
		$class_name=mysql_escape_string(trim($_REQUEST["class_name"].""));
		$figure_name=mysql_escape_string(trim($_REQUEST["figure_name"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));
		//echo $remark;die();
		if($brand_name=="" || $norms_name=="" || $class_name=="" || $figure_name==""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}
		
		$sql="insert into brand (brand_name,remark,norms_name,class_name,figure_name)
		values ('$brand_name','$remark','$norms_name','$class_name','$figure_name')";
		$this->conn->query($sql);
		/*$norms_sql = "insert into norms (norms_name,remark)
		values ('$norms_name','$remark')";
		$this->conn->query($norms_sql);
		$class_sql = "insert into class (class_name,remark)
		values ('$class_name','$remark')";
		$this->conn->query($class_sql);
		$figure_sql = "insert into figure_type (figure_name,remark)
		values ('$figure_name','$remark')";
		$this->conn->query($figure_sql);*/
		if($this->conn->affected_rows()>0){
            $str="添加了新的轮胎参数";
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK','reason'=>'轮胎基本参数添加成功！');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'添加轮胎参数失败！');
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
		$brand_name=mysql_escape_string(trim($_REQUEST["brand_name"].""));
		$norms_name=mysql_escape_string(trim($_REQUEST["norms_name"].""));
		$class_name=mysql_escape_string(trim($_REQUEST["class_name"].""));
		$figure_name=mysql_escape_string(trim($_REQUEST["figure_name"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));
		$brand_id=mysql_escape_string(trim($_REQUEST["brand_id"].""));

		if($brand_id == ""){
			$arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
			echo json_encode($arr);
			die();
		}
		if($brand_name == "" && $remark=="" && $norms_name=="" && $class_name=="" && $figure_name=""){
			$arr = array ('status'=>'ERROR','reason'=>'未指定修改项');
			echo json_encode($arr);
			die();
		}
		$sql="update brand set";
		$fields=array();
		// if($brand_no!="")$fields[]=" brand_no='$brand_no'";
		// if($brand_name!="")$fields[]=" brand_name='$brand_name'";
		// if($remark!="")$fields[]=" remark='$remark'";
		//$fields[]=" brand_no='$brand_no'";
		$fields[]=" brand_name='$brand_name'";
		$fields[]=" norms_name='$norms_name'";
		$fields[]=" class_name='$class_name'";
		$fields[]=" figure_name='$figure_name'";
		$fields[]=" remark='$remark'";
		
		$sql.=implode(",",$fields);
		$sql.=" where brand_id=$brand_id";
		
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="修改了参数信息";
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK','reason'=>'轮胎基本参数修改成功！');
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
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		
		$offset = ($page-1)*$rows;
		$brand_no=mysql_escape_string(trim($_REQUEST["brand_no"].""));
		$brand_name=mysql_escape_string(trim($_REQUEST["brand_name"].""));

		$sql="select * from brand";
		$sql_cnt="select count(*) as cnt from brand";
		$where="";
		if($brand_no!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" brand_no like '%$brand_no%'";
		}
		if($brand_name!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" brand_name like '%$brand_name%'";
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
		命令 ajaction/v1/?menuid=101112&cmd=qrybyone&brand_id=品牌id号
		反回 {"brand_id":1, "brand_no":"","brand_name":"品牌名","remark":"备注"}
	 */
	function qrybyone(){
		$brand_id=mysql_escape_string(trim($_REQUEST["brand_id"].""));

		$sql="select * from brand where brand_id=$brand_id";
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
		轮胎品牌删除 :  ?menuid=101112&cmd=del&brand_id=品牌编号
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function del(){
        global $module_name,$cmd_name;

		$brand_id=mysql_escape_string(trim($_REQUEST["brand_id"].""));
        $sql="select brand_name from brand where brand_id=$brand_id";
        $ret=$this->conn->query_first($sql);
        if(!$ret){
			$arr = array ('status'=>'ERROR','reason'=>'删除失败！未找到要删除的记录。');
			echo json_encode($arr);
			die();
        }

		$sql="delete from brand where brand_id=$brand_id";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="删除了品牌信息".$ret[brand_name];
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK','reason'=>'轮胎基本参数删除成功！');
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