<?
/**
 *  db.class.php 达信通数据库操作类
 *
 * @copyright
 * @license
 * @lastmodify
 */

class db {
	var $db_type = 0;									//0:MySQL  1:PgSQL
	var $database = "";
	var $link_id = 0;
	var $query_id = 0;
	var $record = array();

	var $errdesc = "";
	var $errno = 0;
	var $reporterror = 1;

	var $server = "localhost";
	var $user = "root";
	var $password = "";
	var $charset = "";

	var $ShowDBErr = true;
	var $LogPath ="";

	function db($type,$host,$dbname,$uname,$upass,$showerr,$logpath){
		switch(strtoupper($type)){
			case "MYSQL":
				$this->db_type = 0;
			break;
			case "PGSQL":
				$this->db_type = 1;
			break;
			default:
				echo "错误的数据库类型！";
				return false;
			break;
		}		
		$this->database=$dbname;
		$this->user=$uname;
		$this->password=$upass;
		$this->ShowDBErr=$showerr;
		$this->LogPath=$logpath;
		$this->connect();
	}
	
	function connect(){		//连接，并试图打开数据库。成功：返回持久连接标识符。
		switch($this->db_type){
			case 0:
				if (0==$this->link_id) {		//还未连接
					if ($this->password=="")
						$this->link_id=@mysql_pconnect($this->server,$this->user);
					else
						$this->link_id=@mysql_pconnect($this->server,$this->user,$this->password);
				}

				if (!$this->link_id) $this->halt("数据库连接失败!");
				if ($this->database!="") {
					if(!@mysql_select_db($this->database, $this->link_id))
						$this->halt("无法连接到数据库!! [".$this->database."]");
				}
			break;
			case 1:
				if (0==$this->link_id) {		//还未连接
					$conn_string = "host=".$this->server." user=".$this->user;
					if ($this->password!="")
						$conn_string .= " password=".$this->password;
					if ($this->database!="")
						$conn_string .= " database=".$this->database;
					$this->link_id = @pg_pconnect($conn_string);
				}
				if (!$this->link_id) $this->halt("数据库连接失败!");
			break;
			default:
				return false;
		}
	}

	function geterrdesc() {		//返回上一个操作产生的文本错误信息
		switch($this->db_type){
			case 0:
				$this->error=mysql_error();
				return $this->error;
			break;
			case 1:
				$this->error=pg_result_error($this->link_id);
				return $this->error;
			break;
			default:
				return false;
		}
	}

	function geterrno() {		//Pg_SQL没有此功能函数。
		switch($this->db_type){
			case 0:
				$this->errno=mysql_errno();
				return $this->errno;
			break;
			case 1:
				$this->errno=pg_last_error($this->link_id);
				return $this->errno;
			break;
			default:
				return false;
		}
	}

	function select_db($database="") {				// select database
		switch($this->db_type){
			case 0:
				if ($database!="")
					$this->database=$database;
				if(!mysql_select_db($this->database, $this->link_id))
					$this->halt("无法连接到数据库!! [".$this->database."]");
			break;
			case 1:
				if ($database!="")
					$this->database=$database;
				$this->link_id = @pg_pconnect("dbname=".$this->database);
				if (!$this->link_id) $this->halt("无法连接到数据库!! [".$this->database."]");
			break;
			default:
				return false;
		}
	}

	function query($query_string) {
		switch($this->db_type){
			case 0:
				if( $this->charset != "" ){
					mysql_query("SET NAMES ".$this->charset);
				}
				$this->query_id = mysql_query($query_string,$this->link_id);
				if (!$this->query_id)
					$this->halt("错误的SQL语句: [".$query_string."]");
				return $this->query_id;
			break;
			case 1:
				$this->query_id = pg_query($this->link_id, $query_string);
				if (!$this->query_id)
					$this->halt("错误的SQL语句: [".$query_string."]");
				return $this->query_id;
			break;
			default:
				return false;
		}
	}

	function fetch_array($query_id=-1) {
		if ($query_id!=-1)
			$this->query_id=$query_id;

		switch($this->db_type){
			case 0:
				$this->record = mysql_fetch_array($this->query_id);
				return $this->record;
			break;
			case 1:
				$this->record = pg_fetch_array($this->query_id);
				return $this->record;
			break;
			default:
				return false;
		}
	}

	function fetch_row($query_id=-1) {
		if ($query_id!=-1)
			$this->query_id=$query_id;

		switch($this->db_type){
			case 0:
				$this->record = mysql_fetch_row($this->query_id);
				return $this->record;
			break;
			case 1:
				$this->record = pg_fetch_row($this->query_id);
				return $this->record;
			break;
			default:
				return false;
		}
	}

	function free_result($query_id=-1) {					//释放内存
		if ($query_id!=-1)
			$this->query_id=$query_id;
		switch($this->db_type){
			case 0:
				return @mysql_free_result($this->query_id);
			break;
			case 1:
				return @pg_free_result($this->query_id);
			break;
			default:
				return false;
		}
	}

	function query_first($query_string) {			//根据执行语句执行然后释放内存
		$this->query_id = $this->query($query_string);
		$returnarray=$this->fetch_array($this->query_id);
		$this->free_result($this->query_id);
		return $returnarray;
	}

	function data_seek($pos,$query_id=-1) {	//移动内部返回的列指针
		if ($query_id!=-1) $this->query_id=$query_id;
		switch($this->db_type){
			case 0:
				$status = mysql_data_seek($this->query_id, $pos);	//pos从0到mysql_num_rows-1
				return $status;
			break;
			case 1:
				$status = pg_result_seek($this->query_id, $pos);
				return $status;
			break;
			default:
				return false;
		}
	}
 
	function num_rows($query_id=-1) {			//返回行数
		if ($query_id!=-1) $this->query_id=$query_id;
		switch($this->db_type){
			case 0:
					return @mysql_num_rows($this->query_id);
				break;
				case 1:
				return pg_num_rows($this->query_id);
				break;
				default:
					return false;
			}
	}

	function affected_rows() {			//返回行数
		switch($this->db_type){
			case 0:
				return @mysql_affected_rows($this->link_id);
				break;
			case 1:
			default:
				return false;
			}
	}
	
	function insert_id() {				//返回最后使用Insert的ID
		switch($this->db_type){
			case 0:
				return mysql_insert_id($this->link_id);
				break;
			case 1:
				return pg_last_oid($this->link_id);
			break;
			default:
				return false;
		}
	}

  function list_tables() {					//获取库中表格列表
		switch($this->db_type){
			case 0:
				return mysql_list_tables($this->database);
				break;
			case 1:
				return false;
			break;
			default:
				return false;
		}
  }
  
	function halt($msg) {			//错误提示
		switch($this->db_type){
			case 0:
				$this->errdesc=mysql_error();
				$this->errno=mysql_errno();
			break;
			case 1:
				$this->errdesc=pg_result_error($this->link_id);
				$this->errno="-";
			break;
			default:
				return false;
		}
		
		if($this->ShowDBErr==true){			//写入数据库操作log
			if(!empty($this->LogPath)){
				if(!file_exists($this->LogPath."/DBLog"))
					mkdir($this->LogPath."/DBLog",0777);
				$fp = fopen($this->LogPath."/DBLog/".date("Ymd").".log","a+");
				fputs($fp,"\r\n------------------\r\n");
				fputs($fp,"-时间:".date("h:i:s")."-\r\n");
				fputs($fp,"-错误信息:".$msg."-\r\n");
				fputs($fp,"-错误内容:".$this->errdesc."-\r\n");
				fputs($fp,"-错误号:".$this->errno."-\r\n");
				fputs($fp,"-错误脚本:".getenv("REQUEST_URI")."-\r\n");
				fputs($fp,"-错误页面地址:".getenv("HTTP_REFERER")."-\r\n");
				fputs($fp,"------------------\r\n");
				fclose($fp);
			}else{
				echo  "<font color=red><br><br>";
				echo "\r\n------------------\r\n<br>";
				echo "-时间:".date("h:i:s")."-\r\n<br>";
				echo "-错误信息:".$msg."-\r\n<br>";
				echo "-错误内容:".$this->errdesc."-\r\n<br>";
				echo "-错误号:".$this->errno."-\r\n<br>";
				echo "-错误脚本:".getenv("REQUEST_URI")."-\r\n<br>";
				echo "-错误页面地址:".getenv("HTTP_REFERER")."-\r\n<br>";
				echo "------------------\r\n";
				echo "<br><br></font>";
			}
		}
		if($this->errno==0)return true;
		$this->close();
	}

	function close(){
		switch($this->db_type){
			case 0:
				@mysql_close($this->link_id);
			break;
			case 1:
				@pg_close($this->link_id);
			break;
			default:
				return false;
		}
	}
};  //end class
 ?>
