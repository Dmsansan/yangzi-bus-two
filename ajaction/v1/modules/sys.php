<?

class sys {
	var $conn=0;
	var $log;

	function do_cmd($cmd){
		$this->conn=new db(DB_TYPE,DB_HOST,DB_NAME,DB_USER,DB_PASS,true,SYSTEM_PATH.'log');
		$this->log=new log($this->conn);
		
		switch($cmd){
			case "changepwd":
				$this->changepwd();
				return;
			case "get_all_place":
				$this->get_all_place();
				return;
			case "get_all_tire":
				$this->get_all_tire();
				return;
			case "get_all_vterm":
				$this->get_all_vterm();
				return;
			case "get_all_stores":
				$this->get_all_stores();
				return;
			case "get_all_roles":
				$this->get_all_roles();
				return;
			case "get_all_brand":
				$this->get_all_brand();
				return;
			case "get_all_norms":
				$this->get_all_norms();
				return;
			case "get_all_class":
				$this->get_all_class();
				return;
			case "get_all_figure":
				$this->get_all_figure();
				return;
			case "get_all_sensor":
				$this->get_all_sensor();
				return;
			case "get_all_tireparam":
				$this->get_all_tireparam();
				return;
			case "get_all_modules":
				$this->get_all_modules();
				return;
			case "login":
				$this->login();
				return;
			case "logout":
				$this->logout();
				return;
			case "get_index_data":
				$this->get_index_data();
				return;
			default:
                $arr = array ('status'=>'ERROR','reason'=>'未知的命令！');
                echo json_encode($arr);
                die();
		}
	}

    /*
    /ajaction/v1/?menuid=0&cmd=changepwd&T_oldpwd=老密码&T_newpwd=新密码
        这里的密码就是原文没有 用 md5加密的
        成功反回 {"status":"OK"}
        失败反回 {"status":"ERROR","reason":"失败原因"}
    */
	function changepwd(){
        global $module_name,$cmd_name;
		$T_oldpwd=mysql_escape_string(trim($_REQUEST["T_oldpwd"].""));
		$T_newpwd=mysql_escape_string(trim($_REQUEST["T_newpwd"].""));
		$T_renewpwd=mysql_escape_string(trim($_REQUEST["T_renewpwd"].""));
		if($T_oldpwd == "" || $T_newpwd == "" || $T_renewpwd == ""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}

		if($T_newpwd != $T_renewpwd){
			$arr = array('status'=>'EERROR','reason'=>'两次输入的密码不一致');
			echo json_encode($arr);
			die();
		}

        $md5_pwd=md5($T_oldpwd);
        $sql="select count(*) as cnt from admins where 
                admin_name='{$_SESSION[UserName]}' and password='$md5_pwd'";
                
        $ret=$this->conn->query_first($sql);
        if(intval($ret['cnt']==0)){
			$arr = array ('status'=>'ERROR','reason'=>'原密码错误');
			echo json_encode($arr);
			die();
		}
        
		$md5_pwd=md5($T_newpwd);
        $sql="update admins set password='$md5_pwd' where admin_name='{$_SESSION[UserName]}'";
		$this->conn->query($sql);
		if($this->conn->affected_rows()>0){
            $str=$admin_name."修改了密码";
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'密码未修改');
			echo json_encode($arr);
			die();
		}
		return;
	}

	/*
		命令: /ajaction/v1/?menuid=0&cmd=get_all_place&plate_no=车牌号
        反回:{"status":"OK","items":[{"id":位置编号基1,"name":"位置" }]}
        失败反回:{"status":"ERROR","reason":"失败原因"}
	*/
	function get_all_place(){
		$plate_no=mysql_escape_string(trim($_REQUEST["plate_no"].""));
		if($plate_no == ""){
			$arr = array ('status'=>'ERROR','reason'=>'参数不完整');
			echo json_encode($arr);
			die();
		}
		$sql="select * from bus_info where plate_no='$plate_no'";
        $ret=$this->conn->query_first($sql);
        if(!$ret){
			$arr = array ('status'=>'ERROR','reason'=>'指定的车辆不存在');
			echo json_encode($arr);
			die();
		}
		
        $sql="select place from tire_info where plate_no='$plate_no' order by place asc";
        $res=$this->conn->query($sql);
		$arr = array ();
        $arr_tmp = array ();
		if($this->conn->num_rows($res)>0){
			while ($rec=$this->conn->fetch_array($res)){
				$arr_tmp[$rec[place]]=$rec[place];
			}
			//$this->log->do_log($str);
		}
        $cnt=0;
		$items = array ();
        for($i=1;$i<=intval($ret[wheel_count]);$i++){
            if(array_key_exists($i,$arr_tmp))continue;
            $cnt++;
            $data['id']=$i;
            $data['name']=$i;
            array_push($items,$data);
        }
        if($cnt>0){
			$arr['status']="OK";
			$arr['items']=$items;
			$result = json_encode($arr);
			echo $result;
			die();
        }else{
            $arr = array ('status'=>'ERROR','reason'=>'没有任何空余位置');
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
			//die("404, $str\r\n");
		}
		return;
	}

	/*
		命令: /ajaction/v1/?menuid=0&cmd=get_all_tire&tire_param_id=参数ID
		反回:{"status":"OK","items":[{"id":轮胎ID,"name":"轮胎胎号" }]}
        失败反回:{"status":"ERROR","reason":"失败原因"}
        注意：已经安装过的轮胎或者报废的轮胎都不可以在列表中出现
	*/
	function get_all_tire(){
		$tire_param_id=mysql_escape_string(trim($_REQUEST["tire_param_id"].""));
		$sql="select * from tire_info where status<>'装上' and status<>'报废' and tire_param_id='$tire_param_id'";

        $res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
			$arr = array ();
			$arr['status']="OK";
			$items = array ();
			while ($rec=$this->conn->fetch_array($res)){
				$data['id']=$rec['tire_id'];
				$data['name']=$rec['factory_code'];
				array_push($items,$data);
			}
			$arr['items']=$items;
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
		}else{
            $arr = array ('status'=>'ERROR','reason'=>'没有任何轮胎');
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
			//die("404, $str\r\n");
		}
		return;
	}

	/*
		命令: /ajaction/v1/?menuid=0&cmd=get_all_vterm
		反回:{"status":"OK","items":[{"id":终端ID,"name":"终端编号" }]}
		失败反回:{"status":"ERROR","reason":"失败原因"}	*/
	function get_all_vterm(){       //车载终端
		$sql="select * from vehicle_term";
		$res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
			$arr = array ();
			$arr['status']="OK";
			$items = array ();
			while ($rec=$this->conn->fetch_array($res)){
				$data['id']=$rec['v_term_id'];
				$data['name']=$rec['v_term_no'];
				array_push($items,$data);
			}
			$arr['items']=$items;
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
		}else{
            $arr = array ('status'=>'ERROR','reason'=>'没有任何终端');
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
			//die("404, $str\r\n");
		}
		return;
	}

	/*
		命令: /ajaction/v1/?menuid=0&cmd=get_all_stores
		反回:{"status":"OK","items":[{"store_id":车队编号,"store_name":"车队名" },｛"store_id":车队编号,"store_name":"车队名"｝]}
		失败反回:{"status":"ERROR","reason":"失败原因"}	*/
	function get_all_stores(){
		$sql="select * from store";
		$res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
			$arr = array ();
			$arr['status']="OK";
			$items = array ();
			while ($rec=$this->conn->fetch_array($res)){
				$data['store_id']=$rec['store_id'];
				$data['store_name']=$rec['store_name'];
				array_push($items,$data);
			}
			$arr['items']=$items;
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
		}else{
            $arr = array ('status'=>'ERROR','reason'=>'没有任何车队');
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
			//die("404, $str\r\n");
		}
		return;
	}

	/*
		命令: /ajaction/v1/?menuid=0&cmd=get_all_roles
		反回:{"status":"OK","items":[{"role_title":"角色1","role_id":10 },{"role_title":"角色2","role_id":11}]}
		失败反回:{"status":"ERROR","reason":"失败原因"}
	*/
	function get_all_roles(){
		$sql="select * from roles";
		$res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
			$arr = array ();
			$arr['status']="OK";
			$items = array ();
			while ($rec=$this->conn->fetch_array($res)){
				$data['role_title']=$rec['title'];
				$data['role_id']=$rec['role_id'];
				array_push($items,$data);
			}
			$arr['items']=$items;
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
		}else{
            $arr = array ('status'=>'ERROR','reason'=>'没有任何角色');
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
			//die("404, $str\r\n");
		}
		return;
	}

    /*品牌——规格——层级——花纹表下拉列表信息
        命令: /ajaction/v1/?menuid=0&cmd=get_all_brand
        反回:{"status":"OK","items":[{"id":,"name":"" }]}
        失败反回:{"status":"ERROR","reason":"失败原因"}	*/
	function get_all_brand(){
		$sql="select * from brand";
		$res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
			$arr = array ();
			$arr['status']="OK";
			$items = array ();
			while ($rec=$this->conn->fetch_array($res)){
				$data['id']=$rec['brand_id'];
				$data['name']=$rec['brand_name'];
				array_push($items,$data);
			}
			$arr['items']=$items;
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
		}else{
            $arr = array ('status'=>'ERROR','reason'=>'没有任何品牌信息');
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
			//die("404, $str\r\n");
		}
		return;
	}

    /*品牌——规格——层级——花纹表下拉列表信息
        命令: /ajaction/v1/?menuid=0&cmd=get_all_norms
        反回:{"status":"OK","items":[{"id":,"name":"" }]}
        失败反回:{"status":"ERROR","reason":"失败原因"}	*/
	function get_all_norms(){
		$sql="select * from norms";
		$res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
			$arr = array ();
			$arr['status']="OK";
			$items = array ();
			while ($rec=$this->conn->fetch_array($res)){
				$data['id']=$rec['norms_id'];
				$data['name']=$rec['norms_name'];
				array_push($items,$data);
			}
			$arr['items']=$items;
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
		}else{
            $arr = array ('status'=>'ERROR','reason'=>'没有任何规格信息');
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
			//die("404, $str\r\n");
		}
		return;
	}

    /*品牌——规格——层级——花纹表下拉列表信息
        命令: /ajaction/v1/?menuid=0&cmd=get_all_class
        反回:{"status":"OK","items":[{"id":,"name":"" }]}
        失败反回:{"status":"ERROR","reason":"失败原因"}	*/
	function get_all_class(){
		$sql="select * from class";
		$res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
			$arr = array ();
			$arr['status']="OK";
			$items = array ();
			while ($rec=$this->conn->fetch_array($res)){
				$data['id']=$rec['class_id'];
				$data['name']=$rec['class_name'];
				array_push($items,$data);
			}
			$arr['items']=$items;
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
		}else{
            $arr = array ('status'=>'ERROR','reason'=>'没有任何层级信息');
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
			//die("404, $str\r\n");
		}
		return;
	}

    /*品牌——规格——层级——花纹表下拉列表信息
        命令: /ajaction/v1/?menuid=0&cmd=get_all_figure
        反回:{"status":"OK","items":[{"id":,"name":"" }]}
        失败反回:{"status":"ERROR","reason":"失败原因"}	*/
	function get_all_figure(){
		$sql="select * from figure_type";
		$res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
			$arr = array ();
			$arr['status']="OK";
			$items = array ();
			while ($rec=$this->conn->fetch_array($res)){
				$data['id']=$rec['figure_id'];
				$data['name']=$rec['figure_name'];
				array_push($items,$data);
			}
			$arr['items']=$items;
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
		}else{
            $arr = array ('status'=>'ERROR','reason'=>'没有任何花纹信息');
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
			//die("404, $str\r\n");
		}
		return;
	}

    /*获取传感器列表- 下拉框用
        命令: /ajaction/v1/?menuid=0&cmd=get_all_sensor&state=nouse&tire_id=轮胎ID
        反回:{"status":"OK","items":[{"id":传感器编号,"name":"显示值" }]}
        失败反回:{"status":"ERROR","reason":"失败原因"}
        说明: state = nouse 表示当前传感器是没有被使用的
              tire_id=轮胎ID   如果增加该参数，代表当前传感 器没有被使用的或当前轮胎使用的传感器都显示出
	*/
	function get_all_sensor(){
		$state=mysql_escape_string(trim($_REQUEST["state"].""));
        $tire_id=mysql_escape_string(trim($_REQUEST["tire_id"].""));
        $i=0;
        $items = array ();
		$arr = array ();
        if($tire_id != ""){
            $sql="select * from tire_info where tire_id='$tire_id'";
            $ret=$this->conn->query_first($sql);
            if($ret){
                $data['id']=$ret['sensor_id'];
                $data['name']=$ret['tire_rfid'];
                array_push($items,$data);
                $i++;
            }
        }

        $sql="select * from sensor";
		if($state == "nouse"){
            $sql.=" where sensor_no not in (select tire_rfid from tire_info)";
		}
		$res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
			while ($rec=$this->conn->fetch_array($res)){
				$i++;
                $data['id']=$rec['sensor_id'];
				$data['name']=$rec['sensor_no'];
				array_push($items,$data);
			}
			//$this->log->do_log($str);
		}
        if($i>0){
            $arr['status']="OK";
			$arr['items']=$items;
			$result = json_encode($arr);
			echo $result;
			die();
        }else{
            $arr = array ('status'=>'ERROR','reason'=>'没有任何品牌信息');
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
			//die("404, $str\r\n");
		}
		return;
	}

    /*获取轮胎参数--下拉框使用
        命令: /ajaction/v1/?menuid=0&cmd=get_all_tireparam&brand_id=品牌ID
        反回:{"status":"OK","items":[{"id":参数ID 对应表中的 tire_param_id,"name":"规格 / 层级 / 花纹 " }]}
        失败反回:{"status":"ERROR","reason":"失败原因"}
	*/
	function get_all_tireparam(){
		$brand_id=mysql_escape_string(trim($_REQUEST["brand_id"].""));

		$sql="select a.*,b.norms_name,c.class_name,d.figure_name from tire_param_info as a 
            left join norms as b on a.norms_id=b.norms_id 
            left join class as c on a.class_id=c.class_id
            left join figure_type as d on a.figure_id=d.figure_id
            where a.brand_id='$brand_id'";

        if($brand_id == ""){
            $sql="select a.*,b.norms_name,c.class_name,d.figure_name,e.brand_name from tire_param_info as a 
                left join norms as b on a.norms_id=b.norms_id 
                left join class as c on a.class_id=c.class_id
                left join figure_type as d on a.figure_id=d.figure_id
                left join brand as e on a.brand_id=e.brand_id";
		}

		$res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
			$arr = array ();
			$arr['status']="OK";
			$items = array ();
			while ($rec=$this->conn->fetch_array($res)){
				$data['id']=$rec['tire_param_id'];
				$data['name']=$rec['norms_name']." / ".$rec['class_name']." / ".$rec['figure_name'];
                if($brand_id == "")$data['name'].=(" (".$rec['brand_name'].")");
				array_push($items,$data);
			}
			$arr['items']=$items;
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
		}else{
            $arr = array ('status'=>'ERROR','reason'=>'没有任何参数信息');
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
			//die("404, $str\r\n");
		}
		return;
	}

	function get_module_children($id){
		$sql="select * from modules where parent_id=$id";
		$res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
			$arr = array ();
			while ($rec=$this->conn->fetch_array($res)){
				$data['text']=$rec['title'];
				$data['id']=$rec['module_id'];
				$sql1="select count(*) as cnt from modules where parent_id=".$rec['module_id'];
				$ret=$this->conn->query_first($sql1);
				if(intval($ret['cnt']>0))
					$data['children']=$this->get_module_children($rec['module_id']);
				//else
				//	$data['children']='';
				array_push($arr,$data);
			}
			return $arr;
		}
	}
	/**
	 *  获取所有模块树 :  ?menuid=0&cmd=get_all_modules
		输出: [
		{ "text": "系统管理", "id" : 10, "children": [
			{ "text": "用户权限管理","id":1010 },
			{ "text": "基本数据管理","id":1011, "children": [
					{ "text": "功能菜单" ,"id":101110}，
					{ "text": "功能菜单2","id":101111 }]
			}]
		}
	 */
	function get_all_modules(){
		$sql="select * from modules where parent_id=-1";
		$res=$this->conn->query($sql);
		if($this->conn->num_rows($res)>0){
			$arr = array ();

			while ($rec=$this->conn->fetch_array($res)){
				$data['text']=$rec['title'];
				$data['id']=$rec['module_id'];
				$sql1="select count(*) as cnt from modules where parent_id=".$rec['module_id'];
				$ret1=$this->conn->query_first($sql1);
				if(intval($ret1['cnt']>0))
					$data['children']=$this->get_module_children($rec['module_id']);
				//else
				//	$data['children']='';
				array_push($arr,$data);
			
			}
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
		}else{
            $arr = array ('status'=>'ERROR','reason'=>'没有任何模块');
			$result = json_encode($arr);
			echo $result;
			die();
			//$this->log->do_log($str);
			//die("404, $str\r\n");
		}
		return;
	}

	/*
	用户登陆 :  ?menuid=0&cmd=login&userid=用户名&password=md5后的密码
	成功反回 {"status":"OK"}
	失败反回 {"status":"ERROR","reason":"失败原因"}
	*/
	function login(){
        global $module_name,$cmd_name;

		$admin_name=mysql_escape_string(trim($_REQUEST["userid"].""));
		$password=mysql_escape_string(trim($_REQUEST["password"].""));

		$sql="select * from admins where admin_name='$admin_name' and password='$password'";
		$ret=$this->conn->query_first($sql);
		//echo 3131;die;
		//echo $ret;die;
		if($ret){
			/*先做SESSION处理，后返回JSON结果*/
			$_SESSION["Msg"]="这是您的第".$ret['login_times']."次登录，您上次登录的IP地址是：".$ret['last_ip']."，登录时间是：".$ret['last_stamp']."。";
			$_SESSION["UserName"]=$ret['admin_name'];
			$_SESSION["AdminID"]=$ret['admin_id'];
			$_SESSION["StoreID"]=$ret['store_id'];
			$_SESSION["RealName"]=$ret['real_name'];
			$_SESSION["Email"]=$ret['email'];
			$_SESSION["RoleID"]=$ret['role_id'];
			$_SESSION["IsTerm"]=$ret['is_term'];
			$_SESSION["Remark"]=$ret['remark'];
			$_SESSION["LoginOK"] = true;
            
            $sql="select operlist from roles where role_id=".$_SESSION["RoleID"];
            $ret=$this->conn->query_first($sql);
			$_SESSION["OperList"]=$ret['operlist'];
			$sql="update admins set last_ip='".ip()."', last_stamp=now(), login_times=login_times+1 WHERE admin_name='".$ret['admin_name']."'";
			$this->conn->query($sql);

            $str=$admin_name."登录了系统";
            $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str);
			$arr = array ('status'=>'OK');
			echo json_encode($arr);
			die();
		}else{
			$arr = array ('status'=>'ERROR','reason'=>'登录失败！');
			echo json_encode($arr);
			die();
		}
		return;
	}

	/*
	用户退出: ?menuid=0&cmd=logout
	成功反回 {"status":"OK"}
	失败反回 {"status":"ERROR","reason":"失败原因"}
	*/
	function logout(){
        global $module_name,$cmd_name;
        $admin_name=$_SESSION['UserName'];
        $admin_id=$_SESSION['AdminID'];
        unset($_SESSION['Msg']);
        unset($_SESSION['UserName']);
        unset($_SESSION['AdminID']);
        unset($_SESSION['RealName']);
        unset($_SESSION['Email']);
        unset($_SESSION['RoleID']);
        unset($_SESSION['IsTerm']);
        unset($_SESSION['Remark']);
        unset($_SESSION['LoginOK']);
        unset($_SESSION['OperList']);
        $str=$admin_name."登出了系统";
        $this->log->do_log($module_name[__CLASS__],$cmd_name[__FUNCTION__],$str,$admin_id);
        $arr = array ('status'=>'OK');
        echo json_encode($arr);
        die();	}
    /*
   	首页统计数据获取：/ajaction/v1/?menuid=0/cmd=get_index_data
   	store_id:修理厂ID
     */
    function get_index_data(){
    	global $module_name,$cmd_name;

    	$store_id = mysql_escape_string(trim($_REQUEST["store_id"].""));

    	if($store_id == ''){//所有数据
    		$tire_sql = "select * from tire_info";
    		$res = $this->conn->query($tire_sql);
    		//轮胎总数
    		$tire_count = $this->conn->num_rows($res);
    		//注册轮胎数量=轮胎总数/传感器数量
    		$sensor_sql = "select * from sensor";
    		$sensor_res = $this->conn->query($sensor_sql);
    		$sensor_count = $this->conn->num_rows($sensor_res);
    		//装车轮胎数量
    		$zc_tire_sql = "select * from tire_info where status='è£…ä¸Š'";
    		$zc_tire_res = $this->conn->query($zc_tire_sql);
    		$zc_tire_count = $this->conn->num_rows($zc_tire_res);
    		//库存轮胎数量
    		$kc_tire_sql ="select * from tire_info where status='å¸ä¸‹' and mile_count=0";
    		$kc_tire_res = $this->conn->query($kc_tire_sql);
    		$kc_tire_count = $this->conn->num_rows($kc_tire_res);
    		//报废轮胎数量
    		$bf_tire_sql ="select * from tire_info where status='å¸ä¸‹' and mile_count!=0";
    		$bf_tire_res = $this->conn->query($bf_tire_sql);
    		$bf_tire_count = $this->conn->num_rows($bf_tire_res);
    		//车辆总数
    		$bus_sql = "select * from bus_info";
    		$bus_res = $this->conn->query($bus_sql);
    		$bus_count = $this->conn->num_rows($bus_res);
    		//运营车辆数
    		$yy_bus_sql = "select * from bt_real_log";
    		$yy_bus_res = $this->conn->query($yy_bus_sql);
    		$yy_bus_count = $this->conn->num_rows($yy_bus_res);
    		//报废车辆数
    		$bf_bus_count = $bus_count-$yy_bus_count;
    		//报警记录总数
    		$alarm_sql = "select * from bus_alarm_log";
    		$alarm_res = $this->conn->query($alarm_sql);
    		$alarm_count = $this->conn->num_rows($alarm_res);
    		//高压报警记录总数
    		$height_alarm_sql = "select * from bus_alarm_log where pressure>pressure_ul";
    		$height_alarm_res = $this->conn->query($height_alarm_sql);
    		$height_alarm_count = $this->conn->num_rows($height_alarm_res);
    		//低压报警记录总数
    		$low_alarm_sql = "select * from bus_alarm_log where pressure<pressure_ll";
    		$low_alarm_res = $this->conn->query($low_alarm_sql);
    		$low_alarm_count = $this->conn->num_rows($low_alarm_res);
    		//高温报警记录总数
    		$height_wendu_sql = "select * from bus_alarm_log where temp>temp_ul";
    		$height_wendu_res = $this->conn->query($height_wendu_sql);
    		$height_wendu_count = $this->conn->num_rows($height_wendu_res);
    	}else{
    		$tire_sql = "select * from tire_info";
    	}
    	$arr = array('tire_count'=>$tire_count,'sensor_count'=>$sensor_count,'zc_tire_count'=>$zc_tire_count,'kc_tire_count'=>$kc_tire_count,'bf_tire_count'=>$bf_tire_count,'bus_count'=>$bus_count,'yy_bus_count'=>$yy_bus_count,'bf_bus_count'=>$bf_bus_count,'alarm_count'=>$alarm_count,'height_alarm_count'=>$height_alarm_count,'low_alarm_count'=>$low_alarm_count,'height_wendu_count'=>$height_wendu_count);
    	echo json_encode($arr);
    	die();
    }

}

?>