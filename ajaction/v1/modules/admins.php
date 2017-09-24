<?

class admins {
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
		添加：ajaction/v1/?menuid=101011
			&admin_name=test
			&role_id=角色显示名
			&role_id_val=10
			&admin_pass=不加密密码
			&real_name=真实名
			&tel=联系电话
			&mobile=手机号
			&email=邮箱
			&remark=备注
			&is_term=on
			&cmd=add
		is_term 如果为 on 表示选中，如果没有或其它表示没选
		admin_pass 为不加密的原始密码
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function add(){
        global $module_name,$cmd_name;
    
        $admin_name=mysql_escape_string(trim($_REQUEST["admin_name"].""));
		$role_id=mysql_escape_string(trim($_REQUEST["role_id"].""));
		$role_id_val=mysql_escape_string(trim($_REQUEST["role_id_val"].""));
		$admin_pass=mysql_escape_string(trim($_REQUEST["admin_pass"].""));
		$real_name=mysql_escape_string(trim($_REQUEST["real_name"].""));
		$tel=mysql_escape_string(trim($_REQUEST["tel"].""));
		$mobile=mysql_escape_string(trim($_REQUEST["mobile"].""));
		$email=mysql_escape_string(trim($_REQUEST["email"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));
		$is_term=mysql_escape_string(trim($_REQUEST["is_term"].""));
		$store_id=mysql_escape_string(trim($_REQUEST["store_id_val"].""));

		if($admin_name == "" || $admin_pass==""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}
		$password=md5($admin_pass);
		if($is_term=="on")
			$is_term='Y';
		else
			$is_term='N';

		$sql="insert into admins (admin_name,role_id,password,real_name,tel,mobile,email,remark,is_term,store_id)
		values ('$admin_name',$role_id_val,'$password','$real_name','$tel','$mobile','$email','$remark','$is_term','$store_id')";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="添加了新用户".$admin_name;
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'添加用户失败！');
			echo json_encode($arr);
			die();
		}
		return;
	}

	/**
	 *  修改
		修改: ajaction/v1/?menuid=101011&admin_name=test&role_id=角色显示名& role_id_val=10&admin_pass=不加密密码&real_name=真实名&tel=联系电话& mobile=手机号&email=邮箱&remark=备注&is_term=on&cmd=edit&admin_id=用户id
	 */
	function edit(){
        global $module_name,$cmd_name;

		$admin_name=mysql_escape_string(trim($_REQUEST["admin_name"].""));
		$role_id=mysql_escape_string(trim($_REQUEST["role_id"].""));
		$role_id_val=mysql_escape_string(trim($_REQUEST["role_id_val"].""));
		$admin_pass=mysql_escape_string(trim($_REQUEST["admin_pass"].""));
		$real_name=mysql_escape_string(trim($_REQUEST["real_name"].""));
		$tel=mysql_escape_string(trim($_REQUEST["tel"].""));
		$mobile=mysql_escape_string(trim($_REQUEST["mobile"].""));
		$email=mysql_escape_string(trim($_REQUEST["email"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));
		$is_term=mysql_escape_string(trim($_REQUEST["is_term"].""));
		$store_id=mysql_escape_string(trim($_REQUEST["store_id_val"].""));
		$admin_id=mysql_escape_string(trim($_REQUEST["admin_id"].""));

		if($admin_id == ""){
			$arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
			echo json_encode($arr);
			die();
		}
		if($admin_name == "" && $role_id_val == "" && $admin_pass=="" && $real_name=="" &&
			$tel == "" && $mobile == "" && $email=="" && $remark=="" && $is_term=="" && $store_id==""){
			$arr = array ('status'=>'ERROR','reason'=>'未指定修改项');
			echo json_encode($arr);
			die();
		}
		$password="";
		if($admin_pass!="")$password=md5($admin_pass);
		if($is_term=="on")
			$is_term='Y';
		else
			$is_term='N';
		$sql="update admins set";
		$fields=array();
		// if($admin_name!="")$fields[]=" admin_name='$admin_name'";
		// if($role_id_val!="")$fields[]=" role_id=$role_id_val";
		// if($password!="")$fields[]=" password='$password'";
		// if($real_name!="")$fields[]=" real_name='$real_name'";
		// if($tel!="")$fields[]=" tel='$tel'";
		// if($mobile!="")$fields[]=" mobile='$mobile'";
		// if($remark!="")$fields[]=" remark='$remark'";
		// if($email!="")$fields[]=" email='$email'";
		// if($is_term!="")$fields[]=" is_term='$is_term'";
		// if($store_id!="")$fields[]=" store_id='$store_id'";
		$fields[]=" admin_name='$admin_name'";
		$fields[]=" role_id=$role_id_val";
		$fields[]=" password='$password'";
		$fields[]=" real_name='$real_name'";
		$fields[]=" tel='$tel'";
		$fields[]=" mobile='$mobile'";
		$fields[]=" remark='$remark'";
		$fields[]=" email='$email'";
		$fields[]=" is_term='$is_term'";
		$fields[]=" store_id='$store_id'";
		
		$sql.=implode(",",$fields);
		$sql.=" where admin_id=$admin_id";
		
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="修改了用户信息".$admin_name;
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
      列表 :  ?menuid=101011&cmd=qry&
				sortname=排序字段&
				sortorder=DESC or ASC &
				pagesize=分页条数&
				page=页数&
				admin_name=用户名&
				real_name=真实姓名
      返回 {"Rows":[
				{"admin_id":1, "role_title":"管理员","admin_name":"admin","realname":"管理员","remark":"管理员"}
			],"count":1,"Total":11}
			其中 count 表示当前反回条数，Total 反回满足条件总记录数
				role_title 为角色名
	*/
	function qry(){
		$sortname=mysql_escape_string(trim($_REQUEST["sortname"].""));
		$sortorder=mysql_escape_string(trim($_REQUEST["sortorder"].""));
		$pagesize=mysql_escape_string(trim($_REQUEST["pagesize"].""));
		$page=mysql_escape_string(trim($_REQUEST["page"].""));
		$admin_name=mysql_escape_string(trim($_REQUEST["admin_name"].""));
		$real_name=mysql_escape_string(trim($_REQUEST["real_name"].""));

		$sql="select a.*,b.title as role_title,c.store_name from admins as a 
            left join roles as b on a.role_id=b.role_id
            left join store as c on a.store_id=c.store_id";
		$sql_cnt="select count(*) as cnt from admins";
		$where="";
		if($admin_name!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" admin_name like '%$admin_name%'";
		}
		if($real_name!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" real_name like '%$real_name%'";
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
	 *  获取单条角色信息 :  ?menuid=101011&cmd=qrybyone&admin_id=用户id号
     *  反回 {"admin_id":1, "admin_name":"管理员","admin_pass":"密码","real_name":"管理员","role_id":角色编号,“is_term”:false,"email",:"","tel":"","mobile","","remark":""}
	 */
	function qrybyone(){
		$admin_id=mysql_escape_string(trim($_REQUEST["admin_id"].""));

		$sql="select * from admins where admin_id=$admin_id";
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
	 * 角色删除 :  ?menuid=101011&cmd=del&admin_id=账户编号
	 * 成功反回 {"status":"OK"}
	 * 失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function del(){
        global $module_name,$cmd_name;

		$admin_id=mysql_escape_string(trim($_REQUEST["admin_id"].""));
        $sql="select admin_name from admins where admin_id=$admin_id";
        $ret=$this->conn->query_first($sql);
        if(!$ret){
			$arr = array ('status'=>'ERROR','reason'=>'删除失败！未找到要删除的记录。');
			echo json_encode($arr);
			die();
        }
        
		$sql="delete from admins where admin_id=$admin_id";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="删除了用户信息".$ret['admin_name'];
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