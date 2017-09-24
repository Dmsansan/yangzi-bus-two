<?

class store {
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
		添加：添加：ajaction/v1/?menuid=101110&
			store_no=0111&
			store_name=车队名&
			contact=联系人&
			tel=电话&
			mobile=手机&
			address=地址&
			remark=备注&cmd=add
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function add(){
        global $module_name,$cmd_name;
        
		$store_no=mysql_escape_string(trim($_REQUEST["store_no"].""));
		$store_name=mysql_escape_string(trim($_REQUEST["store_name"].""));
		$contact=mysql_escape_string(trim($_REQUEST["contact"].""));
		$tel=mysql_escape_string(trim($_REQUEST["tel"].""));
		$mobile=mysql_escape_string(trim($_REQUEST["mobile"].""));
		$address=mysql_escape_string(trim($_REQUEST["address"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));

		if($store_no == "" || $store_name==""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}
		
		$sql="insert into store (store_no,store_name,contact,tel,mobile,address,remark)
		values ('$store_no','$store_name','$contact','$tel','$mobile','$address','$remark')";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="添加了新车队(仓库)".$store_name;
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'添加仓库失败！');
			echo json_encode($arr);
			die();
		}
		return;
	}

	/**
	 *  修改
		修改: ajaction/v1/?menuid=101110&
			store_no=0111&
			store_name=车队名&
			contact=联系人&
			tel=电话&
			mobile=手机&
			address=地址&
			remark=备注&cmd=edit&store_id=车队编号
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function edit(){
        global $module_name,$cmd_name;
		$store_no=mysql_escape_string(trim($_REQUEST["store_no"].""));
		$store_name=mysql_escape_string(trim($_REQUEST["store_name"].""));
		$contact=mysql_escape_string(trim($_REQUEST["contact"].""));
		$tel=mysql_escape_string(trim($_REQUEST["tel"].""));
		$mobile=mysql_escape_string(trim($_REQUEST["mobile"].""));
		$address=mysql_escape_string(trim($_REQUEST["address"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));
		$store_id=mysql_escape_string(trim($_REQUEST["store_id"].""));

		if($store_id == ""){
			$arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
			echo json_encode($arr);
			die();
		}
		if($store_no == "" && $store_name == "" && $contact=="" &&
			$tel == "" && $mobile == "" && $address=="" && $remark==""){
			$arr = array ('status'=>'ERROR','reason'=>'未指定修改项');
			echo json_encode($arr);
			die();
		}
		$sql="update store set";
		$fields=array();
		// if($store_no!="")$fields[]=" store_no='$store_no'";
		// if($store_name!="")$fields[]=" store_name='$store_name'";
		// if($contact!="")$fields[]=" contact='$contact'";
		// if($tel!="")$fields[]=" tel='$tel'";
		// if($mobile!="")$fields[]=" mobile='$mobile'";
		// if($remark!="")$fields[]=" remark='$remark'";
		// if($address!="")$fields[]=" address='$address'";
		$fields[]=" store_no='$store_no'";
		$fields[]=" store_name='$store_name'";
		$fields[]=" contact='$contact'";
		$fields[]=" tel='$tel'";
		$fields[]=" mobile='$mobile'";
		$fields[]=" remark='$remark'";
		$fields[]=" address='$address'";
		
		$sql.=implode(",",$fields);
		$sql.=" where store_id=$store_id";
		
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="修改了车队(仓库)信息".$store_name;
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
		获取列表 : /ajaction/v1?menuid=101110&cmd=qry&
			sortname=排序字段&
			sortorder=DESC or ASC &
			pagesize=分页条数&
			page=页数&
			store_name=车队名
		返回 {"Rows":[{"store_id":1, "store_name":"管理员","store_no":""}],"count":1,"Total":11}
		其中 count 表示当前反回条数，
		    Total 反回满足条件总记录数

	*/
	function qry(){
		$sortname=mysql_escape_string(trim($_REQUEST["sortname"].""));
		$sortorder=mysql_escape_string(trim($_REQUEST["sortorder"].""));
		$pagesize=mysql_escape_string(trim($_REQUEST["pagesize"].""));
		$page=mysql_escape_string(trim($_REQUEST["page"].""));
		$store_name=mysql_escape_string(trim($_REQUEST["store_name"].""));
		$store_no=mysql_escape_string(trim($_REQUEST["store_no"].""));

		$sql="select * from store";
		$sql_cnt="select count(*) as cnt from store";
		$where="";
		if($store_name!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" store_name like '%$store_name%'";
		}
		if($store_no!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" store_no like '%$store_no%'";
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
	 *  命令 ajaction/v1/?menuid=101110&cmd=qrybyone&store_id=车队id号
     *  反回 {"store_id":1, "store_no":"","store_name":"车队名",“contact”:"联系人",“tel”:"电话","mobile":"手机","address":"地址","remark":"备注"}
	 */
	function qrybyone(){
		$store_id=mysql_escape_string(trim($_REQUEST["store_id"].""));

		$sql="select * from store where store_id=$store_id";
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
	 * 角色删除 :  ?menuid=101110&cmd=del&store_id=车队编号本系统的自增编号
	 * 成功反回 {"status":"OK"}
	 * 失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function del(){
        global $module_name,$cmd_name;
		$store_id=mysql_escape_string(trim($_REQUEST["store_id"].""));
        $sql="select store_name from store where store_id=$store_id";
        $ret=$this->conn->query_first($sql);
        if(!$ret){
			$arr = array ('status'=>'ERROR','reason'=>'删除失败！未找到要删除的记录。');
			echo json_encode($arr);
			die();
        }

		$sql="delete from store where store_id=$store_id";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="删除了车队(仓库)信息".$ret['store_name'];
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