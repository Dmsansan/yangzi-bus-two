<?
//59
class tire_count {
	var $conn=0;
	//var $log;

	function do_cmd($cmd){
		$this->conn=new db(DB_TYPE,DB_HOST,DB_NAME,DB_USER,DB_PASS,true,SYSTEM_PATH.'log');
		//$this->log=new log($this->conn);
		
		switch($cmd){
			case "qry":
				$this->qry();
				return;
            case "kc_qry":
                $this->kc_qry();
                return;
			default:
                $arr = array ('status'=>'ERROR','reason'=>'未知的命令！');
                echo json_encode($arr);
                die();
		}
	}
	
/*
  create table tire_count (
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
		轮胎库存查询 : ajaction/v1/?menuid=131510&cmdx=qry&
                brand_no_val=1;3&
                norms_id_val=1
                注意: 令命 cmdx   (用 cmd 可能跟 echarts 有冲突)
        说明:   brand_no_val  参数为 品牌ID列表  多个品牌用;号隔开
                norms_id_val  参数为 规格ID列表  多个规格用;号隔开	

        需要查询  库存中各品牌各规格轮胎数有多少

        成功反回:
        {"status":"OK",
            "legdata":["规格1","规格2","规格3"],
            "xdata":["品牌1","品牌2"],
            "ydata":[{"name":"规格1","data":[110,110]}]}

        legdata为 规格名称数组
        xdata  为 品牌数组
        ydata  为 各规格在每品牌中个数

        失败反回:
        失败反回 {"status":"ERROR","reason":"失败原因"}
    */
	function qry(){
		$brand_no_val=mysql_escape_string(trim($_REQUEST["brand_no_val"].""));
		$norms_id_val=mysql_escape_string(trim($_REQUEST["norms_id_val"].""));
		
        if($brand_no_val==""||$norms_id_val==""){
			$arr = array ('status'=>'ERROR','reason'=>'缺少必要的参数');
			echo json_encode($arr);
			die();
        }
        $brand_no_val=str_replace(";",",",$brand_no_val);
        $norms_id_val=str_replace(";",",",$norms_id_val);
        
        $arr=array();
        //品牌
        $arr_brand_id=array();
        $arr_brand=array();
        $sql="select brand_id,brand_name from brand where brand_id in ($brand_no_val)";
        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
            while ($rec=$this->conn->fetch_array($res)){
				$arr_brand[]=$rec[brand_name];
                $arr_brand_id[]=$rec[brand_id];
			}
            $this->conn->free_result($res);
        }else{
			$arr = array ('status'=>'ERROR','reason'=>'未找到品牌信息');
			echo json_encode($arr);
			die();
        }
       //var_dump($arr_brand);
        
        //规格
        $arr_norms=array();
        $arr_norms_id=array();
        $sql="select brand_id,norms_name from brand where brand_id in ($norms_id_val)";
        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
            while ($rec=$this->conn->fetch_array($res)){
				$arr_norms[]=$rec[norms_name];
				$arr_norms_id[]=$rec[brand_id];
			}
            $this->conn->free_result($res);
        }else{
			$arr = array ('status'=>'ERROR','reason'=>'未找到规格信息');
			echo json_encode($arr);
			die();
        }
        //var_dump($arr_norms);
        //规格+品牌+数量
        $arr_norms_brand=array();
        $arr_norms_brand_item=array();
        foreach($arr_norms_id as $key => $norms_id){
            $arr_norms_brand_item[name]=$arr_norms[$key];
            $arr_cnt=array();
            foreach($arr_brand_id as $key1 => $brand_id){
                // $sql="select count(*) as cnt from tire_info as a left join tire_param_info as b on
                        // a.tire_param_id = b.tire_param_id where a.store_id=0 and b.norms_id=$norms_id and b.brand_id=$brand_id";
                $sql="select count(*) as cnt from tire_info as a left join tire_param_info as b on
                        a.tire_param_id = b.tire_param_id where b.norms_id=$norms_id and b.brand_id=$brand_id";
                //echo $sql."<br>";
                $ret=$this->conn->query_first($sql);
                if($ret){
                    $arr_cnt[]=intval($ret[cnt]);
                }else{
                    $arr_cnt[]=0;
                }
            }
            $arr_norms_brand_item[data]=$arr_cnt;
            //echo"<br>";var_dump($arr_norms_brand_item);
            $arr_norms_brand[]=$arr_norms_brand_item;
            reset($arr_brand_id);
        }
        //var_dump($arr_norms_brand);
        // {"status":"OK",
            // "legdata":["规格1","规格2","规格3"],
            // "xdata":["品牌1","品牌2"],
            // "ydata":[{"name":"规格1","data":[110,110]}]}

        // legdata为 规格名称数组
        // xdata  为 品牌数组
        // ydata  为 各规格在每品牌中个数
        
		$arr['status']="OK";
		$arr['legdata']=$arr_norms;
		$arr['xdata']=$arr_brand;
		$arr['ydata']=$arr_norms_brand;
        echo json_encode($arr);
        die();

		return;
	}

    function kc_qry(){
       $sql ="select * from tire_info";  
    }
}

?>