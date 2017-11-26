<?

class tire_info {
	var $conn=0;
	var $log;

	function do_cmd($cmd){
		$this->conn=new db(DB_TYPE,DB_HOST,DB_NAME,DB_USER,DB_PASS,true,SYSTEM_PATH.'log');
		$this->log=new log($this->conn);
		
		switch($cmd){
			case "add":
				$this->add();
				return;
			case "addmore":
				$this->addmore();
				return;
			case "qry_tireswitch":
				$this->qry_tireswitch();
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
			case "qry_search":
				$this->qry_search();
				return;
			case "qrybyone":
				$this->qrybyone();
				return;
			case "qry_kc":
				$this->qry_kc();
				return;
			default:
                $arr = array ('status'=>'ERROR','reason'=>'未知的命令！');
                echo json_encode($arr);
                die();
		}
	}
	
/*
  create table tire_info (
    tire_id         int auto_increment,
    tire_rfid       varchar(20)         comment '轮胎身份ID 就是传感器编号',
    factory_code    varchar(20)         comment '轮胎出厂编码',
    brand_id        int                 comment '轮胎品牌',
    tire_param_id   int                 comment '轮胎参数ID',

	figure_value	int					comment '花纹深度',
    rated_mile      int                 comment '额定里程',
    rated_hour      int                 comment '标称使用小时数',

    order_num       varchar(24)         comment '订单号',
    price           float(8,2)          comment '价格',
    p_staff         varchar(24)         comment '采购人员',

    status          char(8)             comment '状态',
    last_stamp      timestamp default current_timestamp           comment '最近操作时间',
    add_stamp       timestamp           comment '入库时间',
    store_id        int                 comment '仓库编号',
    plate_no        varchar(20)         comment '车牌号码',
    place           varchar(100)        comment '装车位置',
    place_stamp     timestamp           comment '装车时间',
    mile_count      int                 comment '累计里程',
    reason          varchar(256)        comment '报废理由',
    remark          varchar(200)        comment '备注',
    primary key (tire_id),
    --unique (tire_rfid),
    unique (factory_code)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
*/
	
	/**
		添加：ajaction/v1/?menuid=111110&cmd=add&
                factory_code=出厂编码&
                brand_id_val=品牌ID&
                norms_id_val=参数ID(值为 tire_param_id)&
                sensor_id_val=传感器Id&
                figure_value=花纹深度值
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function add(){
        global $module_name,$cmd_name;
		// $tire_rfid=mysql_escape_string(trim($_REQUEST["tire_rfid"].""));
		$factory_code=mysql_escape_string(trim($_REQUEST["factory_code"].""));
		$brand_id_val=mysql_escape_string(trim($_REQUEST["brand_id_val"].""));
		$tire_param_id=mysql_escape_string(trim($_REQUEST["norms_id_val"].""));
		$sensor_id_val=mysql_escape_string(trim($_REQUEST["sensor_id_val"].""));
		$figure_value=mysql_escape_string(trim($_REQUEST["figure_value"].""));

		$rated_mile=mysql_escape_string(trim($_REQUEST["rated_mile"].""));
		$rated_hour=mysql_escape_string(trim($_REQUEST["rated_hour"].""));
		$order_num=mysql_escape_string(trim($_REQUEST["order_num"].""));
		$price=mysql_escape_string(trim($_REQUEST["price"].""));
		$p_staff=mysql_escape_string(trim($_REQUEST["p_staff"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));
		
		$add_stamp = date('Y-m-d H:i:s',time());

		if($factory_code == "" || $brand_id_val==""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}
        $factory_code=sprintf("%08s",$factory_code);

        //确定传感器是否存在
        $sql="select * from sensor where sensor_id='$sensor_id_val'";
        $ret=$this->conn->query_first($sql);
        if(!$ret){
			$arr = array ('status'=>'ERROR','reason'=>'未找到指定的传感器！');
			echo json_encode($arr);
			die();
        }

		$sql="insert into tire_info (tire_rfid,sensor_id,factory_code,brand_id,tire_param_id,
                figure_value,rated_mile,rated_hour,add_stamp,order_num,price,p_staff,
                remark)
		values ('$ret[sensor_no]','$sensor_id_val','$factory_code','$brand_id_val','$tire_param_id',
                '$figure_value','$rated_mile','$rated_hour','$add_stamp','$order_num','$price','$p_staff','$remark')";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="添加了新轮胎".$factory_code;
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK','reason'=>'轮胎添加成功！');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'添加轮胎失败！');
			echo json_encode($arr);
			die();
		}
		return;
	}

    /**
    命令 ../ajaction/v1/?menuid=111110&cmd=addmore&
            brand_id_val=品牌ID&
            norms_id_val=参数ID(值为 tire_param_id)[&tire_switch=on]
            tire_switch 没有时代表开关 关闭
    成功反回 {"status":"OK"}
    失败反回 {"status":"ERROR","reason":"失败原因"}
    */
    function addmore(){
        global $module_name,$cmd_name;

		$brand_id_val=mysql_escape_string(trim($_REQUEST["brand_id_val"].""));
		$tire_param_id=mysql_escape_string(trim($_REQUEST["norms_id_val"].""));
		$tire_switch=mysql_escape_string(trim($_REQUEST["tire_switch"].""));

		$figure_mile=mysql_escape_string(trim($_REQUEST["figure_mile"].""));

		if($tire_param_id == "" || $brand_id_val=="" || $figure_mile == ""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}
        $sql="delete from tire_addmore where store_id='{$_SESSION[StoreID]}' and admin_name='{$_SESSION[UserName]}'";
        $this->conn->query($sql);
        if($tire_switch==""){       //关闭
            $sql="insert into tire_addmore (brand_id,tire_param_id,figure_mile,tire_switch,add_stamp,store_id,admin_name) 
                    values ('$brand_id_val','$tire_param_id','$figure_mile','off',now(),'{$_SESSION[StoreID]}','{$_SESSION[UserName]}')";
            $this->conn->query($sql);
            if($this->conn->affected_rows()>0){
                $arr = array ('status'=>'OK','reason'=>'批量添加轮胎开启成功！');
                echo json_encode($arr);
                die();
            }else{
                $arr = array ('status'=>'ERROR','reason'=>'批量添加轮胎开启失败！');
                echo json_encode($arr);
                die();
            }
        }
        if($tire_switch=="on"){
            $sql="insert into tire_addmore (brand_id,tire_param_id,figure_mile,tire_switch,add_stamp,store_id,admin_name) 
                    values ('$brand_id_val','$tire_param_id','$figure_mile','$tire_switch',now(),'{$_SESSION[StoreID]}','{$_SESSION[UserName]}')";
            $this->conn->query($sql);
            if($this->conn->affected_rows()>0){
                $arr = array ('status'=>'OK');
                echo json_encode($arr);
                die();
            }else{
                $arr = array ('status'=>'ERROR','reason'=>'批量添加轮胎开启失败！');
                echo json_encode($arr);
                die();
            }
        }else{
			$arr = array ('status'=>'ERROR','reason'=>'参数不正确');
			echo json_encode($arr);
			die();
        }
		return;
    }
    
    /**
    获取批量入库轮胎开关参数：
        ../ajaction/v1/?menuid=111110&cmd=qry_tireswitch
    反回:
        {"brand_id":"品牌ID","tire_param_id":"参数ID","tire_switch":"on"}
    */
    function qry_tireswitch(){
        global $module_name,$cmd_name;

		$sql="select * from tire_addmore where store_id='{$_SESSION[StoreID]}' and admin_name='{$_SESSION[UserName]}'";
        $ret=$this->conn->query_first($sql);

        if(!$ret){
			$arr = array ('status'=>'ERROR','reason'=>'获取数据失败');
			echo json_encode($arr);
			die();
        }else{
			$arr = array ('brand_id'=>$ret[brand_id],'tire_param_id'=>$ret[tire_param_id],'tire_switch'=>$ret[tire_switch],'figure_mile'=>$ret[figure_mile]);
			echo json_encode($arr);
			die();
        }
        return;
    }
    
	/**
	 *  修改: ajaction/v1/?menuid=111110&cmd=edit&tire_id=轮胎编号&factory_code=出厂编码&brand_id_val=品牌ID&norms_id_val=参数ID(值为 tire_param_id)&sensor_id_val=传感器Id&figure_value=花纹深度值
	 */
	function edit(){
        global $module_name,$cmd_name;
		// $tire_rfid=mysql_escape_string(trim($_REQUEST["tire_rfid"].""));
		$factory_code=mysql_escape_string(trim($_REQUEST["factory_code"].""));
		$brand_id_val=mysql_escape_string(trim($_REQUEST["brand_id_val"].""));
		$tire_param_id=mysql_escape_string(trim($_REQUEST["norms_id_val"].""));
		$sensor_id_val=mysql_escape_string(trim($_REQUEST["sensor_id_val"].""));
		$figure_value=mysql_escape_string(trim($_REQUEST["figure_value"].""));

		$rated_mile=mysql_escape_string(trim($_REQUEST["rated_mile"].""));
		$rated_hour=mysql_escape_string(trim($_REQUEST["rated_hour"].""));
		$order_num=mysql_escape_string(trim($_REQUEST["order_num"].""));
		$price=mysql_escape_string(trim($_REQUEST["price"].""));
		$p_staff=mysql_escape_string(trim($_REQUEST["p_staff"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));

		$tire_id=mysql_escape_string(trim($_REQUEST["tire_id"].""));

		if($tire_id == ""){
			$arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
			echo json_encode($arr);
			die();
		}
		if($factory_code == "" && $brand_id_val == "" 
				&& $tire_param_id == "" && $sensor_id_val == "" && $figure_value==""
                && $rated_mile == "" && $rated_hour == "" && $order_num==""
                && $price == "" && $p_staff == "" && $remark == ""
                ){
			$arr = array ('status'=>'ERROR','reason'=>'未指定修改项');
			echo json_encode($arr);
			die();
		}
        
        //确定传感器是否存在
        $sql="select * from sensor where sensor_id='$sensor_id_val'";
        $ret=$this->conn->query_first($sql);
        if(!$ret){
			$arr = array ('status'=>'ERROR','reason'=>'未找到指定的传感器！');
			echo json_encode($arr);
			die();
        }
        $tire_rfid=$ret[sensor_no];
        
		$sql="update tire_info set";
		$fields=array();
		// if($tire_rfid!="")$fields[]=" tire_rfid='$tire_rfid'";
		// if($factory_code!=""){
            // $factory_code=sprintf("%08s",$factory_code);
            // $fields[]=" factory_code='$factory_code'";
        // }
		// if($brand_id_val!="")$fields[]=" brand_id='$brand_id_val'";
		// if($tire_param_id!="")$fields[]=" tire_param_id='$tire_param_id'";
		// if($sensor_id_val!="")$fields[]=" sensor_id='$sensor_id_val'";
		// if($figure_value!="")$fields[]=" figure_value='$figure_value'";
		// if($rated_mile!="")$fields[]=" rated_mile='$rated_mile'";
		// if($rated_hour!="")$fields[]=" rated_hour='$rated_hour'";
		// if($order_num!="")$fields[]=" order_num='$order_num'";
		// if($price!="")$fields[]=" price='$price'";
		// if($p_staff!="")$fields[]=" p_staff='$p_staff'";
		// if($remark!="")$fields[]=" remark='$remark'";
		$fields[]=" tire_rfid='$tire_rfid'";
		$factory_code=sprintf("%08s",$factory_code);
        $fields[]=" factory_code='$factory_code'";
		$fields[]=" brand_id='$brand_id_val'";
		$fields[]=" tire_param_id='$tire_param_id'";
		$fields[]=" sensor_id='$sensor_id_val'";
		$fields[]=" figure_value='$figure_value'";
		$fields[]=" rated_mile='$rated_mile'";
		$fields[]=" rated_hour='$rated_hour'";
		$fields[]=" order_num='$order_num'";
		$fields[]=" price='$price'";
		$fields[]=" p_staff='$p_staff'";
		$fields[]=" remark='$remark'";
		
		$sql.=implode(",",$fields);
		$sql.=" where tire_id=$tire_id";
		//echo $sql;die;
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="修改了轮胎信息".$factory_code;
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK','reason'=>'轮胎修改成功！');
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
		获取轮胎列表 : /ajaction/v1?menuid=111110&cmd=qry&
                sortname=排序字段&
                sortorder=DESC or ASC &
                pagesize=分页条数&
                page=页数&
                factory_code=轮胎编码&
                sensor_no=传感器编号
		返回 {"Rows":[{"tire_id":tire_id,"factory_code":"轮胎编码","sensor_no":"传感器编号",
                "norms_name":"规格","class_name":"层级","figure_name":"花纹","brand_name":"品牌",
                "status":"状态","speed_ul":"速度上限","temp_ul":"温度上限","pressure_ul":"胎压上限",
                "pressure_ul":"胎压下限"}],"count":1,"Total":11}
                其中 count 表示当前反回条数，Total 反回满足条件总记录数

                命令参数 增加 [&store_id=车队ID]
                如果有 车队ID，则表示反回可调配的轮胎列表
	*/
	function qry(){
        global $tire_position;
		$sortname=mysql_escape_string(trim($_REQUEST["sortname"].""));
		$sortorder=mysql_escape_string(trim($_REQUEST["sortorder"].""));
		
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		
		$offset = ($page-1)*$rows;

		$factory_code=mysql_escape_string(trim($_REQUEST["factory_code"].""));
		$sensor_no=mysql_escape_string(trim($_REQUEST["sensor_no"].""));
        $store_id=mysql_escape_string(trim($_REQUEST["store_id"].""));
        $store_list_val=mysql_escape_string(trim($_REQUEST["store_list_val"].""));
        $mile_count=mysql_escape_string(trim($_REQUEST["mile_count"].""));
        
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
        $sql="select * from brand";
        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
            while ($rec=$this->conn->fetch_array($res)){
				$arr_norms[$rec[brand_id]]=$rec[norms_name];
			}
            $this->conn->free_result($res);
        }

        $arr_class=array();
        $sql="select * from brand";
        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
            while ($rec=$this->conn->fetch_array($res)){
				$arr_class[$rec[brand_id]]=$rec[class_name];
			}
            $this->conn->free_result($res);
        }

        $arr_figure_type=array();
        $sql="select * from brand";
        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
            while ($rec=$this->conn->fetch_array($res)){
				$arr_figure_type[$rec[brand_id]]=$rec[figure_name];
			}
            $this->conn->free_result($res);
        }

		$sql="select a.*,b.*,c.* from tire_info as a
                left join tire_param_info as b on a.tire_param_id=b.tire_param_id 
                left join sensor as c on a.sensor_id=c.sensor_id";
		$sql_cnt="select count(*) as cnt from tire_info as a
                left join tire_param_info as b on a.tire_param_id=b.tire_param_id 
                left join sensor as c on a.sensor_id=c.sensor_id";
        if($store_id==""){
            $sql="select a.*,b.*,c.*,d.store_name from tire_info as a
                    left join tire_param_info as b on a.tire_param_id=b.tire_param_id 
                    left join sensor as c on a.sensor_id=c.sensor_id
                    left join store as d on a.store_id=d.store_id";
            $sql_cnt="select count(*) as cnt from tire_info as a
                    left join tire_param_info as b on a.tire_param_id=b.tire_param_id 
                    left join sensor as c on a.sensor_id=c.sensor_id
                    left join store as d on a.store_id=d.store_id";
        }
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
			$where.=" a.store_id=0 and a.to_store_id=0";
		}
		if($store_list_val!=""){
            $store_list_val=str_replace(";",",",$store_list_val);
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.store_id in ($store_list_val)";
		}
		if($mile_count!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.mile_count >= $mile_count";
		}
		
		$sql.=$where;
		$sql_cnt.=$where;
        if($sortname!="")$sql.=" order by $sortname";
		if($sortorder!="")$sql.=" $sortorder";
		$sql .=" limit $offset,$rows";

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
                $rec[place]=$tire_position[intval($rec[place])];
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
	function qry_search(){
        global $tire_position;
		$sortname=mysql_escape_string(trim($_REQUEST["sortname"].""));
		$sortorder=mysql_escape_string(trim($_REQUEST["sortorder"].""));
		
		$pagesize=mysql_escape_string(trim($_REQUEST["pagesize"].""));
		$page=mysql_escape_string(trim($_REQUEST["page"].""));

		$factory_code=mysql_escape_string(trim($_REQUEST["factory_code"].""));
		$sensor_no=mysql_escape_string(trim($_REQUEST["sensor_no"].""));
        $store_id=mysql_escape_string(trim($_REQUEST["store_id"].""));
        $store_list_val=mysql_escape_string(trim($_REQUEST["store_list_val"].""));
        $mile_count=mysql_escape_string(trim($_REQUEST["mile_count"].""));
        
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
        $sql="select * from brand";
        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
            while ($rec=$this->conn->fetch_array($res)){
				$arr_norms[$rec[brand_id]]=$rec[norms_name];
			}
            $this->conn->free_result($res);
        }

        $arr_class=array();
        $sql="select * from brand";
        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
            while ($rec=$this->conn->fetch_array($res)){
				$arr_class[$rec[brand_id]]=$rec[class_name];
			}
            $this->conn->free_result($res);
        }

        $arr_figure_type=array();
        $sql="select * from brand";
        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
            while ($rec=$this->conn->fetch_array($res)){
				$arr_figure_type[$rec[brand_id]]=$rec[figure_name];
			}
            $this->conn->free_result($res);
        }

		$sql="select a.*,b.*,c.* from tire_info as a
                left join tire_param_info as b on a.tire_param_id=b.tire_param_id 
                left join sensor as c on a.sensor_id=c.sensor_id";
		$sql_cnt="select count(*) as cnt from tire_info as a
                left join tire_param_info as b on a.tire_param_id=b.tire_param_id 
                left join sensor as c on a.sensor_id=c.sensor_id";
        if($store_id==""){
            $sql="select a.*,b.*,c.*,d.store_name from tire_info as a
                    left join tire_param_info as b on a.tire_param_id=b.tire_param_id 
                    left join sensor as c on a.sensor_id=c.sensor_id
                    left join store as d on a.store_id=d.store_id";
            $sql_cnt="select count(*) as cnt from tire_info as a
                    left join tire_param_info as b on a.tire_param_id=b.tire_param_id 
                    left join sensor as c on a.sensor_id=c.sensor_id
                    left join store as d on a.store_id=d.store_id";
        }
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
			$where.=" a.store_id=0 and a.to_store_id=0";
		}
		if($store_list_val!=""){
            $store_list_val=str_replace(";",",",$store_list_val);
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.store_id in ($store_list_val)";
		}
		if($mile_count!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.mile_count >= $mile_count";
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
                $rec[place]=$tire_position[intval($rec[place])];
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
		命令 ajaction/v1/?menuid=111110&cmd=qrybyone&tire_id=轮胎编号
		反回 {"tire_id":1, "company_name":"","brand_id":"品牌ID","tire_param_id":"参数ID","sensor_id":"传感器","figure_value":花纹深度}
	 */
	function qrybyone(){
		$tire_id=mysql_escape_string(trim($_REQUEST["tire_id"].""));

		$sql="select * from tire_info where tire_id=$tire_id";
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
		删除 :  ajaction/v1/?menuid=111110&cmd=del&tire_id=轮胎编号
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function del(){
        global $module_name,$cmd_name;
		$tire_id=mysql_escape_string(trim($_REQUEST["tire_id"].""));
        $sql="select factory_code from tire_info where tire_id=$tire_id";
        $ret=$this->conn->query_first($sql);
        if(!$ret){
			$arr = array ('status'=>'ERROR','reason'=>'删除失败！未找到要删除的记录。');
			echo json_encode($arr);
			die();
        }

		$sql="delete from tire_info where tire_id=$tire_id";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="删除了轮胎信息".$ret['factory_code'];
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK','reason'=>'轮胎删除成功！');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'删除失败！');
			echo json_encode($arr);
			die();
		}
		return;
	}
	/*轮胎库存查询
		brand_id 品牌ID
		norms_id 规格ID
		date 日期
	*/
	function qry_kc(){
		$brand_id = mysql_escape_string(trim($_REQUEST["brand_id"].""));
		$norms_id = mysql_escape_string(trim($_REQUEST["norms_id"].""));
		$date = mysql_escape_string(trim($_REQUEST["date"].""));
		//入库
		$sql = "select COUNT(tire_id),b.tire_param_id,b.brand_id,b.norms_id,c.brand_name,d.norms_name from tire_info as a 
				left join tire_param_info as b on b.tire_param_id=a.tire_param_id 
				left join brand as c on c.brand_id=b.brand_id
				left join brand as d on d.brand_id=b.norms_id
				where a.brand_id!=''";
		if($brand_id!=""){
			$sql .= " and a.brand_id='$brand_id'";
		}
		if($norms_id!=""){
			$sql .= " and b.norms_id='$norms_id'";
		}
		if($date!=""){
			$start_date = $date." 00:00:00";
			$end_date = $date." 23:59:59";
			$sql .= " and add_stamp>='$start_date' and add_stamp<='$end_date'";
		}
		$sql .=" group by brand_id,norms_id";
		$res = $this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
			$rows = array();
			while($rec=$this->conn->fetch_array($res)){
				$row = array();
				$row['rk_num']=$rec[0];//入库数量
				$row['brand']=$rec[brand_name];//品牌
				$row['norms_name']=$rec[norms_name];//规格
                $sql_one = "select * from tire_info where tire_param_id='$rec[tire_param_id]' and status='装上'";
                if($date!=""){
					$start_date = $date." 00:00:00";
					$end_date = $date." 23:59:59";
					$sql_one .= " and add_stamp>='$start_date' and add_stamp<='$end_date'";
				}
                $res_one = $this->conn->query($sql_one);

				$row['ck_num'] = $this->conn->num_rows($res_one);

				$row['kc_num'] = $row['rk_num']-$row['ck_num'];
				array_push($rows,$row);
			}
			
			$arr['count']=$this->conn->num_rows($res);
			$arr['total']=$this->conn->num_rows($res);

			$arr['rows']=$rows;
			//$result = trim(json_encode($arr),"\xEF\xBB\xBF");
			//$result=@iconv("GBK", "UTF-8//IGNORE", $result);
			$result = json_encode($arr);
			echo $result;
			die();
		}else{
			$arr = array ('total'=>0,'count'=>0);
			$result = json_encode($arr);
			//@iconv("GBK", "UTF-8//IGNORE", $result);
			echo $result;
			die();
		}
		return;
	}
}

?>