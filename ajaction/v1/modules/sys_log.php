<?

class sys_log {
	var $conn=0;
	//var $log;

	function do_cmd($cmd){
		$this->conn=new db(DB_TYPE,DB_HOST,DB_NAME,DB_USER,DB_PASS,true,SYSTEM_PATH.'log');
		//$this->log=new log($this->conn);
		
		switch($cmd){
			case "qry":
				$this->qry();
				return;
			default:
				die("404,unknown");
		}
	}
	
	/**历史记录查询
        /ajaction/v1/?menuid=141010&cmd=qry&
                begin_date=时间开始&
                end_date=结束[&log_type=&title=&admin_name=]
            //方括号中字段可选
        返回 {"Rows":[{     "log_stamp":"时间",
                            "admin_name":"操作员用户名",
                            "log_type":"类型",
                            "title":"标题",
                            "content":"内容"}],"count":1,"Total":11}
                            其中 count 表示当前反回条数，Total 反回满足条件总记录数	*/
	function qry(){
		$begin_date=mysql_escape_string(trim($_REQUEST["begin_date"].""));
		$end_date=mysql_escape_string(trim($_REQUEST["end_date"].""));
		$log_type=mysql_escape_string(trim($_REQUEST["log_type"].""));
		$title=mysql_escape_string(trim($_REQUEST["title"].""));
		$admin_name=mysql_escape_string(trim($_REQUEST["admin_name"].""));
		
        if($begin_date==""||$end_date==""){
            $arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
        }
        $begin_date.=" 00:00:00";
        $end_date.=" 23:59:59";
        
		$sql="select a.*,b.admin_name from sys_log as a left join admins as b
                on a.admin_id=b.admin_id";
		$sql_cnt="select count(*) as cnt from sys_log as a left join admins as b
                on a.admin_id=b.admin_id";
		$where=" where log_stamp>='$begin_date' and log_stamp<='$end_date'";
		if($log_type!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.log_type like '%$log_type%'";
		}
		if($title!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.title like '%$title%'";
		}
		if($admin_name!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" b.admin_name like '%$admin_name%'";
		}
		$sql.=$where;
		$sql_cnt.=$where;
        
        //die($sql);
        // if($sortname!="")$sql.=" order by $sortname";
		// if($sortorder!="")$sql.=" $sortorder";
		// if($pagesize!=""&&$page!=""){
			// $rec_from=intval($pagesize)*(intval($page)-1);
			// $sql.=" limit $rec_from, $pagesize";
		// }

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
}

?>