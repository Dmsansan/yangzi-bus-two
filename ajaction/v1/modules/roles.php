<?
//命令接收页   /ajaction/v1/sys_do.php
//获取角色列表 :  ?menuid=101010&cmd=qry&sortname=排序字段&sortorder=DESC or ASC &pagesize=分页条数&page=页数&title=角色名
//返回 {"Rows":[{"role_id":1, "title":"管理员","modules_list":"10,1001","operate_list":"添加;修改;删除","remark":"管理员"}],"count":1,"Total":11}   其中 count 表示当前反回条数，Total 反回满足条件总记录数

//添加角色 :  ?menuid=101010&cmd=add&title=角色名&remark=说明&module_list=功能权限列表&operlist=可操作权限列表
//修改角色:    ?menuid=101010&cmd=edit&role_id=角色编号&title=角色名&remark=说明&module_list=功能权限列表&operlist=可操作权限列表
//功能权限列表（modules 中的 module_id;module_id）
//可操作权限列表( 添加;修改:删除）
//成功反回 {"status":"OK"}
//失败反回 {"status":"ERROR","reason":"失败原因"}

//获取单条角色信息 :  ?menuid=101010&cmd=qrybyone&role_id=角色编号
//返回 {"role_id":1, "title":"管理员","modules_list":"10;1001","remark":"管理员","operate_list":"添加;修改;删除"}

//角色删除 :  ?menuid=101010&cmd=del&role_id=角色编号
//成功反回 {"status":"OK"}
//失败反回 {"status":"ERROR","reason":"失败原因"}

class roles {
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
	 *  添加
	 */
	function add(){
        global $module_name,$cmd_name;

		$title=mysql_escape_string(trim($_REQUEST["title"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));
		$module_list=mysql_escape_string(trim($_REQUEST["module_list"].""));
		$module_list_val=mysql_escape_string(trim($_REQUEST["module_list_val"].""));
		$operlist=mysql_escape_string(trim($_REQUEST["operlist"].""));

		if($title == "" || $module_list=="" || $operlist==""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}

		$sql="insert into roles (title,role_name,remark,modules_list,modules_list_val,operlist) 
                values ('$title','$title','$remark','$module_list','$module_list_val','$operlist')";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="添加了新角色".$title;
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'添加角色失败！');
			echo json_encode($arr);
			die();
		}
		return;
	}

	/**
	 *  修改
	 *  ?menuid=101010&cmd=edit&role_id=角色编号&title=角色名&remark=说明&module_list=功能权限列表&operlist=可操作权限列表
	 */
	function edit(){
        global $module_name,$cmd_name;
		$role_id=mysql_escape_string(trim($_REQUEST["role_id"].""));
		$title=mysql_escape_string(trim($_REQUEST["title"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));
		$module_list=mysql_escape_string(trim($_REQUEST["module_list"].""));
		$module_list_val=mysql_escape_string(trim($_REQUEST["module_list_val"].""));
		$operlist=mysql_escape_string(trim($_REQUEST["operlist"].""));

		if($role_id == ""){
			$arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
			echo json_encode($arr);
			die();
		}
		if($remark == "" && $title == "" && $module_list=="" && $module_list_val=="" && $operlist==""){
			$arr = array ('status'=>'ERROR','reason'=>'未指定修改项');
			echo json_encode($arr);
			die();
		}

		$sql="update roles set";
		$fields=array();
		// if($remark!="")$fields[]=" remark='$remark'";
		// if($title!=""){
			// $fields[]=" title='$title'";
			// $fields[]=" role_name='$title'";
		// }
		// if($module_list!="")$fields[]=" modules_list='$module_list'";
		// if($module_list_val!="")$fields[]=" modules_list_val='$module_list_val'";
		// if($operlist!="")$fields[]=" operlist='$operlist'";
		
        $fields[]=" remark='$remark'";
		$fields[]=" title='$title'";
		$fields[]=" role_name='$title'";
		$fields[]=" modules_list='$module_list'";
		$fields[]=" modules_list_val='$module_list_val'";
		$fields[]=" operlist='$operlist'";
		
        $sql.=implode(",",$fields);
		$sql.=" where role_id=$role_id";
		
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="修改了角色信息".$title;
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
	 *  列表
	 *  ?menuid=101010&cmd=qry&
	 *    sortname=排序字段&sortorder=DESC or ASC &pagesize=分页条数&page=页数&title=角色名
	 */
	function qry(){
		$sortname=mysql_escape_string(trim($_REQUEST["sortname"].""));
		$sortorder=mysql_escape_string(trim($_REQUEST["sortorder"].""));
		$pagesize=mysql_escape_string(trim($_REQUEST["pagesize"].""));
		$page=mysql_escape_string(trim($_REQUEST["page"].""));
		$title=mysql_escape_string(trim($_REQUEST["title"].""));

		$sql="select * from roles";
		$sql_cnt="select count(*) as cnt from roles";
		if($title!=""){
			$sql.=" where title like '%$title%'";
			$sql_cnt.=" where title like '%$title%'";
		}
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
	 *  获取单条角色信息 :  ?menuid=101010&cmd=qrybyone&role_id=角色编号
     *  返回 {"role_id":1, "title":"管理员","modules_list":"10;1001","remark":"管理员","operate_list":"添加;修改;删除"}
	 */
	function qrybyone(){
		$role_id=mysql_escape_string(trim($_REQUEST["role_id"].""));

		$sql="select * from roles where role_id=$role_id";
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
	 * 角色删除 :  ?menuid=101010&cmd=del&role_id=角色编号
	 * 成功反回 {"status":"OK"}
	 * 失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function del(){
        global $module_name,$cmd_name;

		$role_id=mysql_escape_string(trim($_REQUEST["role_id"].""));
        $sql="select title from roles where role_id=$role_id";
        $ret=$this->conn->query_first($sql);
        if(!$ret){
			$arr = array ('status'=>'ERROR','reason'=>'删除失败！未找到要删除的记录。');
			echo json_encode($arr);
			die();
        }

		$sql="delete from roles where role_id=$role_id";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="删除了角色信息".$ret['title'];
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