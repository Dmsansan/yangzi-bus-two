<?

class tire_delivers {
	var $conn=0;
	var $log;
    
	function do_cmd($cmd){
		$this->conn=new db(DB_TYPE,DB_HOST,DB_NAME,DB_USER,DB_PASS,true,SYSTEM_PATH.'log');
		$this->log=new log($this->conn);
		
		switch($cmd){
			case "add":
				$this->add();
				return;
			case "removeTire":
				$this->removeTire();
				return;
			case "qry":
				$this->qry();
				return;
			default:
                $arr = array ('status'=>'ERROR','reason'=>'未知的命令！');
                echo json_encode($arr);
                die();
		}
	}
	
	/**配送轮胎到某个车队
            ../ajaction/v1/?menuid=111111&cmd=add&store_id=1&tire_list=2,4
            说明:  store_id 为车队ID
                tire_list  为轮胎ID 列表，用逗号隔开
            成功反回 {"status":"OK"}
            失败反回{"status":"ERROR","reason":"失败原因"}	 */
	function add(){
        global $module_name,$cmd_name;
    
        $tire_list=mysql_escape_string(trim($_REQUEST["tire_list"].""));
		$store_id=mysql_escape_string(trim($_REQUEST["store_id"].""));

		if($tire_list == "" || $tire_list==""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}
        $tires=explode(",",$tire_list);
        foreach($tires as $tire_id){
            $sql="select * from tire_info where tire_id=$tire_id and store_id=0 and to_store_id=0";
            $ret=$this->conn->query_first($sql);
            if(!$ret){
                $arr = array ('status'=>'ERROR','reason'=>'轮胎无法配送'.$tire_id);
                echo json_encode($arr);
                die();
            }else{
                $sql="update tire_info set to_store_id=$store_id where tire_id=$tire_id";
                $this->conn->query($sql);
            }
        }
        $str="用户".$_SESSION[UserName]."配送了轮胎";
        $this->log->do_log($module_name[__CLASS__],"轮胎配送",$str);
        $arr = array ('status'=>'OK');
        echo json_encode($arr);
        die();
		return;
	}

	/**将某一轮胎取消配送到某车队
        ../ajaction/v1/?menuid=111111&cmd=removeTire&store_id=车队ID&tire_id=轮胎ID
        反功反回 {"status":"OK"}
        失败反回{"status":"ERROR","reason":"失败原因"}*/
	function removeTire(){
        global $module_name,$cmd_name;
    
        $tire_id=mysql_escape_string(trim($_REQUEST["tire_id"].""));
		$store_id=mysql_escape_string(trim($_REQUEST["store_id"].""));

		if($tire_id == "" || $store_id==""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}

        $sql="select * from tire_info where tire_id=$tire_id";
        $ret=$this->conn->query_first($sql);
        if(!$ret){
            $arr = array ('status'=>'ERROR','reason'=>'未找到需要操作的轮胎'.$tire_id);
            echo json_encode($arr);
            die();
        }else{
            if(intval($ret[store_id])==intval($store_id)){
                $arr = array ('status'=>'ERROR','reason'=>'该轮胎已被车队确认配送，无法取消配送'.$tire_id);
                echo json_encode($arr);
                die();
            }
            $sql="update tire_info set to_store_id=0,store_id=0 where tire_id=$tire_id";
            $this->conn->query($sql);
            $str="用户".$_SESSION[UserName]."取消了轮胎配送";
            $this->log->do_log($module_name[__CLASS__],"轮胎配送",$str);
            $arr = array ('status'=>'OK');
            echo json_encode($arr);
            die();
        }
		return;
	}

	/**根据车队ID ，获取该车队轮胎列表
        任务描述../ajaction/v1/?menuid=111111&cmd=qry&store_id=
    返回 {"Rows":[{"tire_id":tire_id,
            "factory_code":"轮胎编码",
            "sensor_no":"传感器编号",
            "dis_status":"配送状态",
            "norms_name":"规格",
            "class_name":"层级",
            "figure_name":"花纹",
            "brand_name":"品牌"}],"count":1,"Total":11}   
            其中 count 表示当前反回条数，Total 反回满足条件总记录数
            配送状态为  "未确认"   "已确认"	*/
	function qry(){
		$sortname=mysql_escape_string(trim($_REQUEST["sortname"].""));
		$sortorder=mysql_escape_string(trim($_REQUEST["sortorder"].""));
		$pagesize=mysql_escape_string(trim($_REQUEST["pagesize"].""));
		$page=mysql_escape_string(trim($_REQUEST["page"].""));
		$factory_code=mysql_escape_string(trim($_REQUEST["factory_code"].""));
		$sensor_no=mysql_escape_string(trim($_REQUEST["sensor_no"].""));
        $store_id=mysql_escape_string(trim($_REQUEST["store_id"].""));
		
        /*先查询出品牌、规格、层级、花纹存入数组*/
        $arr_brand=array();
        $sql="select * from brand";
        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
            while ($rec=$this->conn->fetch_array($res)){
				$arr_brand[$rec[brand_id]]=$rec[brand_name];
			}
            $this->conn->free_result($res);
        }

        $arr_norms=array();
        $sql="select * from norms";
        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
            while ($rec=$this->conn->fetch_array($res)){
				$arr_norms[$rec[norms_id]]=$rec[norms_name];
			}
            $this->conn->free_result($res);
        }

        $arr_class=array();
        $sql="select * from class";
        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
            while ($rec=$this->conn->fetch_array($res)){
				$arr_class[$rec[class_id]]=$rec[class_name];
			}
            $this->conn->free_result($res);
        }

        $arr_figure_type=array();
        $sql="select * from figure_type";
        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
            while ($rec=$this->conn->fetch_array($res)){
				$arr_figure_type[$rec[figure_id]]=$rec[figure_name];
			}
            $this->conn->free_result($res);
        }

		$sql="select a.*,b.*,c.* from tire_info as a
                left join tire_param_info as b on a.tire_param_id=b.tire_param_id 
                left join sensor as c on a.sensor_id=c.sensor_id";
		$sql_cnt="select count(*) as cnt from tire_info as a
                left join tire_param_info as b on a.tire_param_id=b.tire_param_id 
                left join sensor as c on a.sensor_id=c.sensor_id";
		$where="";
		if($factory_code!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.factory_code like '%$factory_code%'";
		}
		if($sensor_no!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" c.sensor_no like '%$sensor_no%'";
		}
		if($store_id!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" (a.store_id=$store_id or a.to_store_id=$store_id)";
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
                if(array_key_exists($rec[brand_id],$arr_brand))
                    $rec[brand_name]=$arr_brand[$rec[brand_id]];
                else
                    $rec[brand_name]="";
                
                if(array_key_exists($rec[norms_id],$arr_norms))
                    $rec[norms_name]=$arr_norms[$rec[norms_id]];
                else
                    $rec[norms_name]="";
                
                if(array_key_exists($rec[class_id],$arr_class))
                    $rec[class_name]=$arr_class[$rec[class_id]];
                else
                    $rec[class_name]="";
                
                if(array_key_exists($rec[figure_id],$arr_figure_type))
                    $rec[figure_name]=$arr_figure_type[$rec[figure_id]];
                else
                    $rec[figure_name]="";
                
                if($rec[store_id]==$store_id && $rec[to_store_id]==0){
                    $rec[dis_status]='已确认';
                }
                if($rec[store_id]==0 && $rec[to_store_id]==$store_id){
                    $rec[dis_status]='未确认';
                }
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