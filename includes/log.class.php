<?
class log {
	var $conn=0;

	function log($logconn){
		$this->conn=$logconn;		
	}

/*
	id	            int auto_increment,
    log_type        varchar(20)         comment '类型',
    title           varchar(40)         comment '标题',
    content         varchar(200)        comment '内容',
    admin_id        int                 comment '操作员',
    log_stamp       timestamp           comment '记录时间',
*/
	function do_log($log_type="",$title="",$content="",$admin_id=-1){
		$content=mysql_escape_string($content).'';
		$title=mysql_escape_string($title).'';
        if($admin_id==-1)$admin_id=$_SESSION['AdminID'];
		$sql="insert into sys_log (log_type,log_stamp,admin_id,title,content) values ('$log_type',now(),$admin_id,'$title','$content')";
		$res=$this->conn->query($sql);
		return;
	}	
};  //end class

?>
