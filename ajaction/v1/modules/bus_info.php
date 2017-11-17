<?
include_once SYSTEM_PATH.'Classes/PHPExcel/IOFactory.php';
class bus_info {
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
			case "qry_search":
				$this->qry_search();
				return;
			case "qrybyone":
				$this->qrybyone();
				return;
			case "bus_insert":
				$this->bus_insert();
				return;
			default:
                $arr = array ('status'=>'ERROR','reason'=>'未知的命令！');
                echo json_encode($arr);
                die();
		}
	}
	
/*
  create table bus_info (
    bus_id          int auto_increment,
    plate_no        varchar(20)         comment '车牌号码',
    bus_no          varchar(32)         comment '车辆编号',
    bus_type        varchar(32)         comment '车辆型号',
    curr_speed      float(6,2)          comment '当前速度',
    factory         varchar(100)        comment '厂商',
    wheel_count     int                 comment '轮数',
    store_id        int                 comment '仓库/车队ID',
    v_term_id       int                 comment '车载终端ID',
    remark          varchar(200)        comment '备注',
    primary key (bus_id),
    unique (plate_no)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
*/
	
	/**
		添加：ajaction/v1/?menuid=121010&cmd=add&
                plate_no=车牌号&
                terminal_id_val=终端ID
                remark=备注
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function add(){
        global $module_name,$cmd_name;

		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));
		$bus_no=mysql_escape_string(trim($_REQUEST["bus_no"].""));
		$bus_type=mysql_escape_string(trim($_REQUEST["bus_type"].""));
		$factory=mysql_escape_string(trim($_REQUEST["factory"].""));
        $speed_limit=mysql_escape_string(trim($_REQUEST["speed_limit"].""));
		$wheel_count=mysql_escape_string(trim($_REQUEST["wheel_count_val"].""));
		$v_term_id=mysql_escape_string(trim($_REQUEST["terminal_id_val"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));
		
		if($plate_no == ""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}
		
		$sql="insert into bus_info (plate_no,bus_no,bus_type,factory,wheel_count,speed_limit,
                v_term_id,remark,add_stamp)
		values ('$plate_no','$bus_no','$bus_type','$factory','$wheel_count','$speed_limit',
                '$v_term_id','$remark',now())";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="添加了新车辆".$plate_no;
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'添加车辆失败！');
			echo json_encode($arr);
			die();
			//$this->log->do_log($str);
		}
		return;
	}

	/**
	 *  修改: ajaction/v1/?menuid=121010&cmd=edit&plate_no=车牌号&terminal_id_val=终端IDremark=备注
	 */
	function edit(){
        global $module_name,$cmd_name;

		$bus_no=mysql_escape_string(trim($_REQUEST["bus_no"].""));
		$bus_type=mysql_escape_string(trim($_REQUEST["bus_type"].""));
		$factory=mysql_escape_string(trim($_REQUEST["factory"].""));
        $speed_limit=mysql_escape_string(trim($_REQUEST["speed_limit"].""));
		$wheel_count=mysql_escape_string(trim($_REQUEST["wheel_count_val"].""));
		$v_term_id=mysql_escape_string(trim($_REQUEST["terminal_id_val"].""));
		$remark=mysql_escape_string(trim($_REQUEST["remark"].""));

		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));

		if($plate_no == ""){
			$arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
			echo json_encode($arr);
			die();
		}
		if($bus_no == "" && $bus_type == "" && $factory == "" && $speed_limit == ""
				&& $wheel_count == "" && $v_term_id == "" && $remark==""
                ){
			$arr = array ('status'=>'ERROR','reason'=>'未指定修改项');
			echo json_encode($arr);
			die();
		}
		$sql="update bus_info set";
		$fields=array();
		// if($bus_no!="")$fields[]=" bus_no='$bus_no'";
		// if($bus_type!="")$fields[]=" bus_type='$bus_type'";
		// if($factory!="")$fields[]=" factory='$factory'";
		// if($speed_limit!="")$fields[]=" speed_limit='$speed_limit'";
		// if($wheel_count!="")$fields[]=" wheel_count='$wheel_count'";
		// if($v_term_id!="")$fields[]=" v_term_id='$v_term_id'";
		// if($remark!="")$fields[]=" remark='$remark'";
		$fields[]=" bus_no='$bus_no'";
		$fields[]=" bus_type='$bus_type'";
		$fields[]=" factory='$factory'";
		$fields[]=" speed_limit='$speed_limit'";
		$fields[]=" wheel_count='$wheel_count'";
		$fields[]=" v_term_id='$v_term_id'";
		$fields[]=" remark='$remark'";
		
		$sql.=implode(",",$fields);
		$sql.=" where plate_no='$plate_no'";
		
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="修改了车辆信息".$plate_no;
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
		获取列表 : /ajaction/v1?menuid=121010&cmd=qry&
                sortname=排序字段&
                sortorder=DESC or ASC &
                pagesize=分页条数&
                page=页数&
                plate_no=汽车号码
		返回 {"Rows":[{"bus_id":bus_id,"plate_no":"","v_term_no":"车载编号","remark":"说明"}],"count":1,"Total":11}
                其中 count 表示当前反回条数，Total 反回满足条件总记录数
	*/
	function qry(){
		$sortname=mysql_escape_string(trim($_REQUEST["sortname"].""));
		$sortorder=mysql_escape_string(trim($_REQUEST["sortorder"].""));
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		
		$offset = ($page-1)*$rows;
		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));
		$begin_date=mysql_escape_string(trim($_REQUEST["bdate"].""));
		$end_date=mysql_escape_string(trim($_REQUEST["edate"].""));

		$v_term_no=mysql_escape_string(trim($_REQUEST['vterm_no'].""));

        if($begin_date!="")$begin_date.=" 00:00:00";
        if($end_date!="")$end_date.=" 23:59:59";

		$sql="select a.*,b.v_term_no from bus_info as a left join vehicle_term as b on a.v_term_id=b.v_term_id";
		$sql_cnt="select count(*) as cnt from bus_info";
		$where="";
        $where1="";
		if($plate_no!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.plate_no like '%$plate_no%'";
			if($where1=="")
				$where1=" where";
			else
				$where1.=" and";
			$where1.=" plate_no like '%$plate_no%'";
		}
		if($v_term_no!=""){
			$sql .= " where b.v_term_no='$v_term_no'";
		}
		if($begin_date!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.add_stamp >= '$begin_date'";
			if($where1=="")
				$where1=" where";
			else
				$where1.=" and";
			$where1.=" add_stamp >= '$begin_date'";
		}
		if($end_date!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.add_stamp <= '$end_date'";
			if($where1=="")
				$where1=" where";
			else
				$where1.=" and";
			$where1.=" add_stamp <= '$end_date'";
		}

		$sql.=$where;
		$sql_cnt.=$where1;
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
	
	function qry_search(){
		$sortname=mysql_escape_string(trim($_REQUEST["sortname"].""));
		$sortorder=mysql_escape_string(trim($_REQUEST["sortorder"].""));
		$pagesize=mysql_escape_string(trim($_REQUEST["pagesize"].""));
		$page=mysql_escape_string(trim($_REQUEST["page"].""));
		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));
		$begin_date=mysql_escape_string(trim($_REQUEST["bdate"].""));
		$end_date=mysql_escape_string(trim($_REQUEST["edate"].""));
        if($begin_date!="")$begin_date.=" 00:00:00";
        if($end_date!="")$end_date.=" 23:59:59";

		$sql="select a.*,b.v_term_no from bus_info as a left join vehicle_term as b on a.v_term_id=b.v_term_id";
		$sql_cnt="select count(*) as cnt from bus_info";
		$where="";
        $where1="";
		if($plate_no!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.plate_no like '%$plate_no%'";
			if($where1=="")
				$where1=" where";
			else
				$where1.=" and";
			$where1.=" plate_no like '%$plate_no%'";
		}
		if($begin_date!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.add_stamp >= '$begin_date'";
			if($where1=="")
				$where1=" where";
			else
				$where1.=" and";
			$where1.=" add_stamp >= '$begin_date'";
		}
		if($end_date!=""){
			if($where=="")
				$where=" where";
			else
				$where.=" and";
			$where.=" a.add_stamp <= '$end_date'";
			if($where1=="")
				$where1=" where";
			else
				$where1.=" and";
			$where1.=" add_stamp <= '$end_date'";
		}

		$sql.=$where;
		$sql_cnt.=$where1;
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
		命令 ajaction/v1/?menuid=121010&cmd=qrybyone&plate_no=车牌号
		反回 {"plate_no":"车牌号", "v_term_id":"","remark":"备注"}
	 */
	function qrybyone(){
		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));

		$sql="select * from bus_info where plate_no='$plate_no'";
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
		删除 :  ajaction/v1/?menuid=121010&cmd=del&plate_no=车牌号
		成功反回 {"status":"OK"}
		失败反回 {"status":"ERROR","reason":"失败原因"}
	 */
	function del(){
        global $module_name,$cmd_name;

		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));

		$sql="delete from bus_info where plate_no='$plate_no'";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str="删除了车辆信息".$plate_no;
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
		//Excle数据表格导入
	function bus_insert(){
        global $module_name,$cmd_name;
		//print_r($this->conn);die;
		if(!empty($_FILES['file_stu']['tmp_name'])){
			$tmp_file = $_FILES ['file_stu'] ['tmp_name'];
		    $file_types = explode ( ".", $_FILES ['file_stu'] ['name'] );
		    $file_type = $file_types [count ( $file_types ) - 1];
		     /*判别是不是.xls文件，判别是不是excel文件*/
		     if (strtolower ( $file_type ) != "xlsx")              
			    {
			          echo "不是.xlsx文件，重新上传！";
			    }
		    /*设置上传路径*/
		     $savePath = SYSTEM_PATH . 'upfile/Excel/';
			 //echo $savePath;die;
		    /*以时间来命名上传的文件*/
		     $str = date ( 'Ymdhis' ); 
		     $file_name = $str . "." . $file_type;
		     /*是否上传成功*/
		     if(! copy ( $tmp_file, $savePath . $file_name )) 
		      {
		          echo  "上传失败!";
				  die();
		      }
			  
			echo "文件上传成功！";
			echo "<br>";
			$inputFileName = $tmp_file;
			date_default_timezone_set('PRC');
			// 读取excel文件
			try {
			$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);
			} 
			catch(Exception $e) {
			die('加载文件发生错误："'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			//确定要读取的sheet，什么是sheet，看excel的右下角，真的不懂去百度吧
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			
			// 获取一行的数据
			for ($row = 2; $row <= $highestRow; $row++){
			// Read a row of data into an array
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
			//这里得到的rowData都是一行的数据，得到数据后自行处理，我们这里只打出来看看效果
			
			$bus_no = $rowData[0][0];//车牌号码
			$v_term_no = $rowData[0][1];//车载终端编号
			$remark = $rowData[0][2];//备注
			$wheel_count = $rowData[0][3];//汽车总的轮胎数量
			$brand = $rowData[0][4];//轮胎品牌
			$store_id_val = $rowData[0][5];//所属车队编号
			$company_name = $rowData[0][6];//分公司
			$roules_name = $rowData[0][7];//线路
			
			$company_sql = "select * from company where company_name='$company_name'";
			$company_ret = $this->conn->query_first($company_sql);
			if($company_ret){
				$company_id = $company_ret[id];
			}else{
				$company_insert_sql = "insert into company (company_name,remark) values ('$company_name','')";
				$this->conn->query($company_insert_sql);
				$company_id = $this->conn->insert_id();
			}
			//echo $company_insert_sql."<br>";
			//echo $company_id."<br>";
			$roules_sql = "select * from roules where roules_name='$roules_name'";
			$roules_ret = $this->conn->query_first($roules_sql);
			if($roules_ret){
				$roules_id = $roules_ret[id];
			}else{
				$roules_insert_sql = "insert into roules (roules_name,remark) values ('$roules_name','')";
				$this->conn->query($roules_insert_sql);
				$roules_id = $this->conn->insert_id();
			}
			//echo $roules_insert_sql;
			//echo $roules_id."<br>";
			//车载终端入库
			$v_term_sql_one = "select * from vehicle_term where v_term_no='$v_term_no'";
			$v_term_ret = $this->conn->query_first($v_term_sql_one);
			if($v_term_ret){
				echo "终端：<span style='color:red;'>❤".$v_term_no."❤</span>已存在！";
				echo "<br>";
			}else{
				$v_term_sql = "insert into vehicle_term (v_term_no,v_term_name,plate_no,store_id,remark)
				values ('$v_term_no','$v_term_no','$bus_no','$store_id_val','')";
				
				$this->conn->query($v_term_sql);
				$v_term_id = $this->conn->insert_id();
				//车辆入库
				$bus_sql_one = "select * from bus_info where plate_no='$bus_no'";
				$bus_ret = $this->conn->query_first($bus_sql_one);
				if($bus_ret){
					echo "车辆：<span style='color:red;'>❤".$bus_no."❤</span>已存在！";
					echo "<br>";
				}else{
					$sql="insert into bus_info (plate_no,bus_no,bus_type,factory,wheel_count,speed_limit,
						v_term_id,remark,add_stamp,company_id,roules_id)
						values ('$bus_no','','','','$wheel_count','',
						'$v_term_id','$remark',now(),'$company_id','$roules_id')";
				
				$this->conn->query($sql);
				}
			}
			//echo $v_term_sql;
			//echo "<br>";
			
			//添加对应传感器
			
			$sensor_sql = "select * from sensor where sensor_no = '$v_term_no'";
			$this->conn->query($sensor_sql);
			if($this->conn->affected_rows()>0){//传感器存在
				echo "传感器：".$v_term_no."存在，添加失败！";
				echo "<br>";
			}else{
				//添加传感器以及对应的轮胎
				$pressure_ul = 12;
				$pressure_ll = 6.5;
				$temp_ul = 125;
				$temp_ll = -40;
				for($i=1;$i<=$wheel_count;$i++){
					$sensor_no_X=sprintf("%s%X",$v_term_no,$i);
					$sensor_select_sql = "select * from sensor where sensor_no = '$sensor_no_X'";
					$sensor_ret = $this->conn->query_first($sensor_select_sql);
					if(!$sensor_ret){
							$sensor_inser_sql = "insert into sensor (sensor_no,pressure_ul,pressure_ll,temp_ul,temp_ll,remark)
						values ('$sensor_no_X','$pressure_ul','$pressure_ll','$temp_ul','$temp_ll','')";
						$this->conn->query($sensor_inser_sql);
						if($this->conn->affected_rows()>0){
							//添加对应的轮胎
							$sensor_id_val=$this->conn->insert_id();
							$factory_code=$sensor_no_X."000";
							$brand_sql = "select * from brand where brand_name = '$brand'";
							$ret=$this->conn->query_first($brand_sql);
							$brand_id = $ret['brand_id'];
							
							$tire_param_sql = "select * from tire_param_info where brand_id='$brand_id'";
							$tire_ret = $this->conn->query_first($tire_param_sql);
							$tire_param_id = $tire_ret['tire_param_id'];
							
							$tire_sql = "insert into tire_info (tire_rfid,sensor_id,factory_code,brand_id,tire_param_id,
										figure_value,rated_mile,rated_hour,order_num,price,p_staff,
										remark)
								values ('$sensor_no_X','$sensor_id_val','$factory_code','$brand_id','$tire_param_id',
										'0','0','0','0','0','0','')";
							//echo $tire_sql;
							$this->conn->query($tire_sql);
							if($this->conn->affected_rows() == 0){
								echo "传感器：".$v_term_no."对应的轮胎添加失败！";
								echo "<br>";
							}
							$tire_id_val=$this->conn->insert_id();//安装轮胎ID
							//安装轮胎
							$install_tire_sql= "update tire_info set bus_mile_count=0,status='装上',plate_no='$bus_no', place='$i', place_stamp=now(), 
							fst_place_stamp=now() where tire_id='$tire_id_val'";
							//echo $install_tire_sql;
							$this->conn->query($install_tire_sql);
							if($this->conn->affected_rows() == 0){
								echo "轮胎安装失败！";
								echo "<br>";
							}
						}
					}
					
				}
			}
			//var_dump($rowData);
			}
			die();
		}else{
			echo '无文件上传！';
			die();
		}
	}
}

?>