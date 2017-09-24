<?
/*
轮胎位置：
    左前:1
    右前:2
    左后外侧:3
    左后内侧:4
    右后内侧:5
    右后外侧:6
*/
        
require_once("../config.inc.php");

$conn = new db(DB_TYPE,DB_HOST,DB_NAME,DB_USER,DB_PASS,true,SYSTEM_PATH.'log');
$log = new log($conn);

//Type,FunctionA,FunctionB
$type=intval($_REQUEST['TYPE']."");

if($type==0)
    die("ERROR, 参数错误！");

/*按车牌号码查询对应轮胎信息
    Type=101
    FunctionA=车牌号码（7位）
    FunctionB=用户名
    查询该车辆上安装的轮胎信息，并按规定格式返还给手持终端
    （返回轮胎ID、额定里程、累计里程、初次装车时间）。
判断及处理方式：
    1)	该车没有安装任何轮胎，返回“1”
    2)	查询成功，返回“0“+轮胎基本信息，
        每个轮胎信息包含：轮胎ID号（8位）+
        额定里程（6位）+
        当前累计里程（6位）+
        初次装车时间（10位），
        不足位数的在前面补”0“，
        并安装左前、右前、左后外侧，左后内侧、右后内侧和右后外侧顺序组包返回给手持终端
操作成功执行以下动作：
    ★添加系统日志表（DailyRecord），记录手持终端操作记录日志，可在【终端操作日志查询】模块中查询；
*/
function f101(){
    global $conn;//,$module_name,$cmd_name;
    $fa=$_REQUEST['FunctionA']."";
    $fb=$_REQUEST['FunctionB']."";

    //$fa=iconv("GB2312", "UTF-8//IGNORE", $fa);      //做编码转换
    $sql="select factory_code,rated_mile,mile_count,fst_place_stamp,place from tire_info where plate_no='$fa' order by place asc";
    $res=$conn->query($sql);
    if($conn->num_rows($res)>0){
        $ret_str="0";
        $arr=array();
        for($i=1;$i<=6;$i++)
            $arr[$i]="000000000000000000000000000000";
        
        while($rec=$conn->fetch_array($res)){
            $factory_code=sprintf("%08s",$rec['factory_code']);
            $rated_mile=sprintf("%06s",$rec['rated_mile']);
            $mile_count=sprintf("%06s",$rec['mile_count']);
            $fst_place_stamp=substr($rec['fst_place_stamp'],0,10);
            $arr[intval($rec[place])]=$factory_code.$rated_mile.$mile_count.$fst_place_stamp;
        }
        for($i=1;$i<=6;$i++)
            $ret_str.=$arr[$i];
        echo($ret_str);die;
    }else{
        echo("1");die;
    }
}

/*轮胎换位
    Type=102
    FunctionA=换位轮胎ID号（每个ID号定长8位）
    FunctionB=用户名
    是指同一辆车上不同位置的轮胎进行位置调换动作，类似四轮换位。
判断及处理方式：
    1)	轮胎不存在，未办理注册入库手续，返回“1”
    2)	所更换的轮胎不在同一辆车上，返回“2”
    3)	换位成功，返回“0”
操作成功执行以下动作：.
    ★修改轮胎基本信息库（TyreBaseInfo），更改轮胎安装位置以及最后一次操作时间；
    ★添加轮胎使用记录表（TyreUseRecord），记录两个轮胎执行一次轮胎换位动作，可
    在【轮胎操作记录】模块中查询；
    ★添加系统日志表（DailyRecord），记录手持终端操作记录日志，可在【终端操作日志
    查询】模块中查询；
*/
function f102(){
    global $conn,$log,$module_name,$cmd_name;
    
    $fa=$_REQUEST['FunctionA']."";
    $fb=$_REQUEST['FunctionB']."";

    $tire_no_A=substr($fa,0,8);
    $tire_no_B=substr($fa,8,8);
    
    $sql="select * from tire_info where (factory_code='$tire_no_A' or factory_code='$tire_no_B') and place > 0";
    $res=$conn->query($sql);
    if($conn->num_rows($res)==2){   //两只
        $rec1=$conn->fetch_array($res);
        $rec2=$conn->fetch_array($res);
        if($rec1[plate_no]!=$rec2[plate_no]){
            echo("2");die;
        }
        
        //卸下,装上
        // $sql="update tire_info set plate_no='',place='0',place_stamp=now(),status='卸下'";
        // $sql.=" where factory_code='$tire_no_A' or factory_code='$tire_no_B'";
        // $conn->query($sql);
        $sql="update tire_info set plate_no='$rec1[plate_no]',place='$rec1[place]',place_stamp=now(),status='装上'";
        $sql.=" where factory_code='$rec2[factory_code]'";
        $conn->query($sql);
        $sql="update tire_info set plate_no='$rec2[plate_no]',place='$rec2[place]',place_stamp=now(),status='装上'";
        $sql.=" where factory_code='$rec1[factory_code]'";
        $conn->query($sql);

        $plate_no=$rec1['plate_no'];
        $sql="select * from bus_info where plate_no='$plate_no'";
        $ret=$conn->query_first($sql);
        $v_term_id=0;
        $bus_id=0;
        if($ret){
            $bus_id=$ret['bus_id'];
            $v_term_id=$ret['v_term_id'];
        }
        
        //卸下
        $sql="select id,install_stamp from tire_exchg_log where tire_id='$rec1[tire_id]' 
                and bus_id='$bus_id' 
                and place='$rec1[place]'
                and uninstall_stamp='0000-00-00 00:00:00'
                and action='装上' order by log_stamp desc limit 1";
        $ret_id=$conn->query_first($sql);
        if(!$ret_id){
            $sql="insert into tire_exchg_log (tire_id,bus_id,v_term_id,place,
                    install_stamp,uninstall_stamp,mile_count,stamp_count,action,log_stamp) value
                    ('$rec1[tire_id]','$bus_id','$v_term_id','$rec1[place]',
                    NOW(),NOW(),'$rec1[mile_count]',0,'装上',NOW())";
        }else{
            //计算使用时长，计算里程，计算
            $curr_tm=time();
            $uninstall_stamp=date("Y-m-d H:i:s",$curr_tm);
            $inst_tm=ymdhis2ts($ret_id[install_stamp]);
            $stamp_count=$curr_tm-$inst_tm;
            
            $sql="update tire_exchg_log set
                    uninstall_stamp='$uninstall_stamp',
                    stamp_count='$stamp_count',
                    action='卸下',
                    log_stamp='$uninstall_stamp' where id=$ret_id[id]";
        }
        $conn->query($sql);

        //卸下
        $sql="select id,install_stamp from tire_exchg_log where tire_id='$rec2[tire_id]' 
                and bus_id='$bus_id' 
                and place='$rec2[place]'
                and uninstall_stamp='0000-00-00 00:00:00'
                and action='装上' order by log_stamp desc limit 1";
        $ret_id=$conn->query_first($sql);
        if(!$ret_id){
            $sql="insert into tire_exchg_log (tire_id,bus_id,v_term_id,place,
                    install_stamp,uninstall_stamp,mile_count,stamp_count,action,log_stamp) value
                    ('$rec2[tire_id]','$bus_id','$v_term_id','$rec2[place]',
                    NOW(),NOW(),'$rec2[mile_count]',0,'装上',NOW())";
        }else{
            //计算使用时长，计算里程，计算
            $curr_tm=time();
            $uninstall_stamp=date("Y-m-d H:i:s",$curr_tm);
            $inst_tm=ymdhis2ts($ret_id[install_stamp]);
            $stamp_count=$curr_tm-$inst_tm;
            
            $sql="update tire_exchg_log set
                    uninstall_stamp='$uninstall_stamp',
                    stamp_count='$stamp_count',
                    action='卸下',
                    log_stamp='$uninstall_stamp' where id=$ret_id[id]";
        }
        $conn->query($sql);
        
        //装上SQL
        $sql="insert into tire_exchg_log (tire_id,bus_id,v_term_id,place,
                    install_stamp,uninstall_stamp,mile_count,stamp_count,action,log_stamp) value
                    ('$rec1[tire_id]','$bus_id','$v_term_id','$rec2[place]',
                    NOW(),'0000-00-00 00:00:00','$rec1[mile_count]',0,'装上',NOW())";
        $conn->query($sql);
        $exchg_id=$conn->insert_id();
        $sql="update tire_info set exchg_id='$exchg_id' where tire_id='$rec1[tire_id]'";
        $conn->query($sql);

        //装上SQL
        $sql="insert into tire_exchg_log (tire_id,bus_id,v_term_id,place,
                    install_stamp,uninstall_stamp,mile_count,stamp_count,action,log_stamp) value
                    ('$rec2[tire_id]','$bus_id','$v_term_id','$rec1[place]',
                    NOW(),'0000-00-00 00:00:00','$rec2[mile_count]',0,'装上',NOW())";
        $conn->query($sql);
        $exchg_id=$conn->insert_id();
        $sql="update tire_info set exchg_id='$exchg_id' where tire_id='$rec2[tire_id]'";
        $conn->query($sql);

        $str="终端用户".$fb."进行了轮胎换位操作";
        $log->do_log("手持终端","轮胎换位",$str,0);
        echo("0");die;
    }else{
        echo("1");die;
    }
}

/*更换轮胎
    Type=103
    FunctionA=被更换轮胎ID号（8位）+新装车的轮胎ID号（8位）
    FunctionB=用户名
    将车辆指定安装位置的轮胎更换为新的轮胎，拆卸下来的轮胎自动入库，标志位库存态。
判断及处理方式：
    1)	轮胎ID号不存在，返回“1“
    2)	被更换的轮胎未装车，无法锁定需要更换的车辆牌照号码，返回“2“
    3)	轮胎更换成功，返回“0“
操作成功执行以下动作：
    ★修改轮胎基本信息库（TyreBaseInfo），将更换下的轮胎转为库存胎，清除之前的车
    牌号码及装车位置，将新装轮胎的状态改为使用态，并记录所装车辆的车牌号码及装车位置，如果为初次装车则记录初次装车时间，并记录最后一次操作时间；
    ★添加轮胎使用记录表（TyreUseRecord），记录两个轮胎执行一次轮胎换位动作，可
    在【轮胎操作记录】模块中查询；
    ★添加系统日志表（DailyRecord），记录手持终端操作记录日志，可在【终端操作日志
    查询】模块中查询；
*/
function f103(){
    global $conn,$log,$module_name,$cmd_name;
    $fa=$_REQUEST['FunctionA']."";
    $fb=$_REQUEST['FunctionB']."";

    $tire_no_A=substr($fa,0,8);
    $tire_no_B=substr($fa,8,8);
    
    $sql="select * from tire_info where factory_code='$tire_no_A' and place > 0";
    $ret1=$conn->query_first($sql);
    if(!$ret1){     //未找到已经安装的轮胎
        echo("1");die;
    }
    $sql="select * from tire_info where factory_code='$tire_no_B' and place = 0";
    $ret2=$conn->query_first($sql);
    if(!$ret2){     //未找到准备安装的轮胎
        echo("1");die;
    }
    
    $plate_no=$ret1['plate_no'];
    $sql="select * from bus_info where plate_no='$plate_no'";
    $ret=$conn->query_first($sql);
    $v_term_id=0;
    $bus_id=0;
    $bus_mile_count=0;
    if($ret){
        $bus_id=$ret['bus_id'];
        $v_term_id=$ret['v_term_id'];
        $bus_mile_count=$ret['mile_count'];
    }

    //卸下
    $sql="update tire_info set tire_mile_count=mile_count,plate_no='',place='0',place_stamp=now(),status='卸下'";
    $sql.=" where factory_code='$tire_no_A'";
    $conn->query($sql);

    //卸下日志处理
    $sql="select id,install_stamp from tire_exchg_log where tire_id='$ret1[tire_id]' 
            and bus_id='$bus_id' 
            and place='$ret1[place]'
            and uninstall_stamp='0000-00-00 00:00:00'
            and action='装上' order by log_stamp desc limit 1";
    $ret_id=$conn->query_first($sql);
    if(!$ret_id){
        $sql="insert into tire_exchg_log (tire_id,bus_id,v_term_id,place,
                install_stamp,uninstall_stamp,mile_count,stamp_count,action,log_stamp) value
                ('$ret1[tire_id]','$bus_id','$v_term_id','$ret1[place]',
                NOW(),NOW(),'$ret1[mile_count]',0,'装上',NOW())";
    }else{
        //计算使用时长，计算里程，计算
        $curr_tm=time();
        $uninstall_stamp=date("Y-m-d H:i:s",$curr_tm);
        $inst_tm=ymdhis2ts($ret_id[install_stamp]);
        $stamp_count=$curr_tm-$inst_tm;
        
        $sql="update tire_exchg_log set
                uninstall_stamp='$uninstall_stamp',
                stamp_count='$stamp_count',
                action='卸下',
                log_stamp='$uninstall_stamp' where id=$ret_id[id]";
    }
    $conn->query($sql);
    
    //装上新轮胎
    $sql="update tire_info set bus_mile_count=$bus_mile_count,plate_no='$plate_no',place='{$ret1[place]}',place_stamp=now(),status='装上'";
    if($ret2[fst_place_stamp]=="0000-00-00 00:00:00"){
        $sql.=",fst_place_stamp=now()";
    }
    $sql.=" where factory_code='$tire_no_B'";
    $conn->query($sql);

    //装上日志
    $sql="insert into tire_exchg_log (tire_id,bus_id,v_term_id,place,
                install_stamp,uninstall_stamp,mile_count,stamp_count,action,log_stamp) value
                ('$ret2[tire_id]','$bus_id','$v_term_id','$ret1[place]',
                NOW(),'0000-00-00 00:00:00','$ret2[mile_count]',0,'装上',NOW())";
    $conn->query($sql);
    $exchg_id=$conn->insert_id();
    $sql="update tire_info set exchg_id='$exchg_id' where tire_id='$ret2[tire_id]'";
    $conn->query($sql);
    
    $str="终端用户".$fb."进行了轮胎更换操作";
    $log->do_log("手持终端","轮胎更换",$str,0);

    echo("0");die;
}

function f104(){
    global $conn,$log,$module_name,$cmd_name;
    $fa=$_REQUEST['FunctionA']."";
    $fb=$_REQUEST['FunctionB']."";
	$DEV=$_REQUEST['DEV']."";

    if($fb=="轮胎注册"){        //指量添加轮胎
        if($fa=="" || strlen($fa)!=8){
            echo("3");die;    
        }
        $sql="select * from tire_addmore where store_id=0 and tire_switch='on' and admin_name='轮胎注册'";
        $ret=$conn->query_first($sql);
        if(!$ret){
            echo("1");die;
        }
        
        $sensor_no=substr($fa,0,5);
        $factory_code=$fa;
        
        $sql="select count(*) as cnt from tire_info where factory_code='$factory_code'";
        $ret1=$conn->query_first($sql);
        if(intval($ret1[cnt])>0){
            echo("2");die;
        }
        //添加传感器，添加轮胎
        $sql="insert into sensor (sensor_no,pressure_ul,pressure_ll,temp_ul,temp_ll,remark)
            values ('$sensor_no','12','6.5','90','0','手持终端自动添加')";
        $conn->query($sql);
        if($conn->affected_rows()==0){
            echo("3");die;            
        }

        $sensor_id=$conn->insert_id();
        
		$sql="insert into tire_info (tire_rfid,sensor_id,factory_code,brand_id,tire_param_id,
                figure_value,rated_mile,rated_hour,order_num,price,p_staff,
                remark)
		values ('$sensor_no','$sensor_id','$factory_code','$ret[brand_id]','$ret[tire_param_id]',
                '500','','','','','','手持终端扫描入库')";
		$conn->query($sql);
		if($conn->affected_rows()>0){
            $str="终端用户添加了新轮胎".$factory_code;
            $log->do_log("手持终端","轮胎入库",$str,0);
            echo("0");die;
		}
    }else{                      //轮胎配送确认
        $sql="select * from tire_info where factory_code='$fa'";
        $ret=$conn->query_first($sql);
        if(!$ret){
            echo("1");die;
        }
		
        if(intval($ret[to_store_id])==0){
            echo("2");die;
        }
		if($DEV!="PC"){
			//电脑端无需此判断
			$ip=ip();
			$sql="select * from terminal where terminal_ip='$ip'";
			$ret1=$conn->query_first($sql);
			if(!$ret1){
				echo("3");die;
			}
			if(intval($ret1[store_id])!=intval($ret[to_store_id])){
				echo("3");die;
			}
		}
        $sql="update tire_info set to_store_id=0,store_id='$ret[to_store_id]' where factory_code='$fa'";
		$conn->query($sql);
		if($conn->affected_rows()>0){
			
            $str="终端用户".$fb."确认了配送的轮胎".$fa;
            if($DEV!="PC"){
				$log->do_log("手持终端","配送确认",$str,0);
			}else{
				$log->do_log("电脑终端","配送确认",$str,0);
			}
            echo("0");die;
		}
		
    }

}

/*终端登录（终端用户认证）
   Tyre=105
   FunctionA=用户名
   FunctionB=密码
判断及处理方式：
    1) 用户名不存在，返回“1”
    2) 密码错误，返回“2”
    3) 登录成功，返回“0”
操作成功执行以下动作：
    ★记录到系统操作日志，可通过“终端操作日志“模块查询。
*/
function f105(){
    global $conn,$log,$module_name,$cmd_name;
    $fa=$_REQUEST['FunctionA']."";
    $fb=$_REQUEST['FunctionB']."";
    $passwd=md5($fb);
    
    $sql="select count(*) as cnt from admins where admin_name='$fa' and is_term='Y'";
    $ret=$conn->query_first($sql);
    if(intval($ret[cnt])==0){       //用户名不存在
        echo "1";die;
    }
    $sql="select * from admins where admin_name='$fa' and password='$passwd' and is_term='Y'";

    $ret=$conn->query_first($sql);
    if($ret){
        $sql="update admins set last_ip='".ip()."', last_stamp=now(), login_times=login_times+1 WHERE admin_name='".$ret['admin_name']."'";
		$conn->query($sql);

        $str="终端用户".$fa."登录了系统";
        $log->do_log("手持终端","登录",$str,0);
        echo "0";die;
    }else{
        echo "2";die;
    }
}

/*装车
    Tyre=106
    FunctionA=车牌（7位）+轮胎ID号（8位）…(按左前、右前、左后外侧、左后内侧，右后内侧和右后外侧顺序组包)
    FunctionB=用户名
判断及处理方式：
    1)	接收FunctionA数据不完整，返回“2“
    2)	所装轮胎未办理入库（注册），返回“1“，系统中查找不到轮胎ID号
    3)	装车成功，返回“0“
操作成功执行以下动作：
    ★修改轮胎基本信息库（TyreBaseInfo），状态为“使用“，记录轮胎对应的车牌号码
    和装车位置，如为初次装车，记录初次装车时间，可在【轮胎状态查询】模块中查询；
    ★添加轮胎使用记录表（TyreUseRecord），记录轮胎执行一次装车动作，可在【轮胎
    操作记录】模块中查询；
    ★添加系统日志表（DailyRecord），记录手持终端操作记录日志，可在【终端操作日志
    查询】模块中查询；
*/
function f106(){
    global $conn,$log,$module_name,$cmd_name;
    $fa=$_REQUEST['FunctionA']."";
    $fb=$_REQUEST['FunctionB']."";

    if(strlen($fa)!=61 && strlen($fa)!=57){
        echo("2");die;
    }
    $plate_no=substr($fa,0,9);
    //$plate_no=iconv("GB2312", "UTF-8//IGNORE", $plate_no);      //做编码转换
    
    $sql="select * from bus_info where plate_no='$plate_no'";
    $ret=$conn->query_first($sql);
    $v_term_id=0;
    $bus_id=0;
    $bus_mile_count=0;
    if($ret){
        $bus_id=$ret['bus_id'];
        $v_term_id=$ret['v_term_id'];
        $bus_mile_count=$ret['mile_count'];
    }else{
        echo("2");die;
    }
    
    $sql="select count(*) as cnt from tire_info where plate_no='$plate_no'";
    $ret=$conn->query_first($sql);
    if(intval($ret[cnt]>0)){
        echo("7");die;
    }
    for($i=1;$i<7;$i++){
        $factory_code=substr($fa,13+($i-1)*8,8);
        // $sql="select count(*) as cnt from tire_info where factory_code='$factory_code' and place>0";
        // $ret=$conn->query_first($sql);
        // if(intval($ret[cnt])>0){
            // echo("8");die;
        // }
        $sql="select * from tire_info where factory_code='$factory_code'";
        $ret=$conn->query_first($sql);
        if(!$ret){
            echo("2");die;
        }else{
            if(intval($ret[place])>0){
                echo("8");die;
            }
        }
    }

    $arr=array();
    for($i=1;$i<7;$i++){
        $arr[$i]=substr($fa,13+($i-1)*8,8);        
        $sql="select * from tire_info where factory_code='$arr[$i]'";
        $ret=$conn->query_first($sql);
        if(!$ret){
            echo("1");die;
        }else{
            if($ret[place]>0 || $ret[plate_no]!="" || status=="装上"){
                echo("7");die;
            }
            
            $sql="update tire_info set bus_mile_count=$bus_mile_count,plate_no='$plate_no',place='$i',place_stamp=now(),status='装上'";
            if($ret[fst_place_stamp]=="0000-00-00 00:00:00"){
                $sql.=",fst_place_stamp=now()";
            }
            $sql.=" where factory_code='$arr[$i]'";
        }
        $conn->query($sql);

        //装上日志
        $sql="insert into tire_exchg_log (tire_id,bus_id,v_term_id,place,
                    install_stamp,uninstall_stamp,mile_count,stamp_count,action,log_stamp) value
                    ('$ret[tire_id]','$bus_id','$v_term_id','$i',
                    NOW(),'0000-00-00 00:00:00','$ret[mile_count]',0,'装上',NOW())";
        $conn->query($sql);
        $exchg_id=$conn->insert_id();
        $sql="update tire_info set exchg_id='$exchg_id' where tire_id='$ret[tire_id]'";
        $conn->query($sql);
    }
    $str="终端用户".$fb."进行了轮胎装车操作";
    $log->do_log("手持终端","轮胎装车",$str,0);
    echo("0");die;
}

/*按轮胎ID号查询轮胎基本信息
    Type=107
    FunctionA=轮胎ID号
    FunctionB=用户名
    查询指定轮胎的基本信息，按既定组包方式返还为手持终端（车牌号码、装车位置、额定里程、累计里程、初次装车时间）。
判断及处理方式：
    1)	轮胎ID号不存在，返回“1“，未办理注册入库
    2)	查询成功，返回“0“+轮胎基本信息，
        包含：所装车辆牌照（7位）+额定里程（6位）+累计里程（6位）+初次装车时间（10位）
操作成功执行以下动作：
    ★添加系统日志表（DailyRecord），记录手持终端操作记录日志，可在【终端操作日志
    查询】模块中查询；
*/
function f107(){
    global $conn;//,$log,$module_name,$cmd_name;
    $fa=$_REQUEST['FunctionA']."";
    $fb=$_REQUEST['FunctionB']."";

    if($fa==""){
        echo("1");die;
    }

    $sql="select * from tire_info where factory_code='$fa'";
    $ret=$conn->query_first($sql);
    if(!$ret){
        echo("1");die;
    }else{
        $plate_no=$ret['plate_no'];
        //$plate_no=iconv("UTF-8", "GB2312//IGNORE", $plate_no);      //做编码转换
        if($plate_no=="")$plate_no="0000000";
        $rated_mile=sprintf("%06s",$ret['rated_mile']);
        $mile_count=sprintf("%06s",$ret['mile_count']);
        $fst_place_stamp=substr($ret['fst_place_stamp'],0,10);
        $ret_str="0".$plate_no.$rated_mile.$mile_count.$fst_place_stamp;
        echo($ret_str);die;
    }
}

/*轮胎拆卸
    Type=108
    FunctionA=轮胎ID号
    FunctionB=用户名
    将拆卸下来的轮胎办理入库手续，系统自动默认入车辆所在车队的库存。
判断及处理方式：
    1)	轮胎ID号不存在，返回“1“
    2)	轮胎拆卸入库成功，返回“0“
操作成功执行以下动作：
    ★修改轮胎基本信息库（TyreBaseInfo），将拆卸下的轮胎转为库存胎，清除之前的车牌号码及装车位置；
    ★添加轮胎使用记录表（TyreUseRecord），记录轮胎执行一次拆卸动作，可在【轮胎操作记录】模块中查询；
    ★添加系统日志表（DailyRecord），记录手持终端操作记录日志，可在【终端操作日志查询】模块中查询；
*/
function f108(){
    global $conn,$log,$module_name,$cmd_name;
    $fa=$_REQUEST['FunctionA']."";
    $fb=$_REQUEST['FunctionB']."";

    if($fa==""){
        echo("1");die;
    }

    $sql="select * from tire_info where factory_code='$fa'";
    $ret=$conn->query_first($sql);
    if(!$ret){
        echo("1");die;
    }else{
        $sql="update tire_info set tire_mile_count=mile_count,plate_no='',place='0',place_stamp=now(),status='卸下'";
        $sql.=" where factory_code='$fa'";
        $conn->query($sql);

        $plate_no=$ret['plate_no'];
        
        $sql="select * from bus_info where plate_no='$plate_no'";
        $ret1=$conn->query_first($sql);
        $v_term_id=0;
        $bus_id=0;
        //$bus_mile_count=0;
        
        if($ret1){
            $bus_id=$ret1['bus_id'];
            $v_term_id=$ret1['v_term_id'];
            //$bus_mile_count=$ret1['mile_count'];
        }
        
        //卸下日志处理
        $sql="select id,install_stamp from tire_exchg_log where tire_id='$ret[tire_id]' 
                and bus_id='$bus_id' 
                and place='$ret[place]'
                and uninstall_stamp='0000-00-00 00:00:00'
                and action='装上' order by log_stamp desc limit 1";
        $ret_id=$conn->query_first($sql);
        if(!$ret_id){
            $sql="insert into tire_exchg_log (tire_id,bus_id,v_term_id,place,
                    install_stamp,uninstall_stamp,mile_count,stamp_count,action,log_stamp) value
                    ('$ret[tire_id]','$bus_id','$v_term_id','$ret[place]',
                    NOW(),NOW(),'$ret[mile_count]',0,'装上',NOW())";
        }else{
            //计算使用时长，计算里程，计算
            $curr_tm=time();
            $uninstall_stamp=date("Y-m-d H:i:s",$curr_tm);
            $inst_tm=ymdhis2ts($ret_id[install_stamp]);
            $stamp_count=$curr_tm-$inst_tm;
            
            $sql="update tire_exchg_log set
                    uninstall_stamp='$uninstall_stamp',
                    stamp_count='$stamp_count',
                    action='卸下',
                    log_stamp='$uninstall_stamp' where id=$ret_id[id]";
        }
        $conn->query($sql);

        $str="终端用户".$fb."进行了轮胎拆卸操作";
        $log->do_log("手持终端","轮胎拆卸",$str,0);
        echo("0");die;
    }
}

/*
轮胎报废
    Type=109
    FunctionA=轮胎ID
    FunctionB=用户名
    可以将车辆上的轮胎或库存轮胎直接转为报废状态。
判断及处理方式：
    1)	轮胎ID号不存在，返回“1“
    2)	轮胎报废处理成功，返回“0“
操作成功执行以下动作：
    ★修改轮胎基本信息库（TyreBaseInfo），将轮胎状态标记为报废，如为已装车轮胎，
    则清除之前的车牌号码及装车位置；
    ★添加轮胎使用记录表（TyreUseRecord），记录轮胎执行一次报废动作，可在【轮胎操作记录】模块中查询；
    ★添加系统日志表（DailyRecord），记录手持终端操作记录日志，可在【终端操作日志查询】模块中查询；
*/
function f109(){
    global $conn,$log,$module_name,$cmd_name;
    $fa=$_REQUEST['FunctionA']."";
    $fb=$_REQUEST['FunctionB']."";

    if($fa==""){
        echo("1");die;
    }

    $sql="select * from tire_info where factory_code='$fa'";
    $ret=$conn->query_first($sql);
    if(!$ret){
        echo("1");die;
    }else{
        $sql="update tire_info set plate_no='',place='0',place_stamp=now(),status='报废'";
        $sql.=" where factory_code='$fa'";
        $conn->query($sql);

        $plate_no=$ret['plate_no'];
        
        $sql="select * from bus_info where plate_no='$plate_no'";
        $ret1=$conn->query_first($sql);
        $v_term_id=0;
        $bus_id=0;
        if($ret1){
            $bus_id=$ret1['bus_id'];
            $v_term_id=$ret1['v_term_id'];
        }
        
        //卸下日志处理
        $sql="select id,install_stamp from tire_exchg_log where tire_id='$ret[tire_id]' 
                and bus_id='$bus_id' 
                and place='$ret[place]'
                and uninstall_stamp='0000-00-00 00:00:00'
                and action='装上' order by log_stamp desc limit 1";
        $ret_id=$conn->query_first($sql);
        if(!$ret_id){
            $sql="insert into tire_exchg_log (tire_id,bus_id,v_term_id,place,
                    install_stamp,uninstall_stamp,mile_count,stamp_count,action,log_stamp) value
                    ('$ret[tire_id]','$bus_id','$v_term_id','$ret[place]',
                    NOW(),NOW(),'$ret[mile_count]',0,'报废',NOW())";
        }else{
            //计算使用时长，计算里程，计算
            $curr_tm=time();
            $uninstall_stamp=date("Y-m-d H:i:s",$curr_tm);
            $inst_tm=ymdhis2ts($ret_id[install_stamp]);
            $stamp_count=$curr_tm-$inst_tm;
            
            $sql="update tire_exchg_log set
                    uninstall_stamp='$uninstall_stamp',
                    stamp_count='$stamp_count',
                    action='报废',
                    log_stamp='$uninstall_stamp' where id=$ret_id[id]";
        }
        $conn->query($sql);

        
        $str="终端用户".$fb."进行了轮胎报废操作";
        $log->do_log("手持终端","轮胎报废",$str,0);
        echo("0");die;
    }
}

/*
库存查询
    Type=110
    FunctionA=NULL（不处理）
    FunctionB=用户名
    自动默认查询手持终端所在车队的库存胎数量和报废胎数量。
判断及处理方式：
    1)	手持终端未注册，返回“1“，即手持终端未与车队信息绑定
    2)	处理成功，返回“0“+库存胎数量（4位）+报废胎数量（4位）
操作成功执行以下动作：
    ★添加系统日志表（DailyRecord），记录手持终端操作记录日志，可在【终端操作日志查询】模块中查询；
*/
function f110(){
    global $conn;//,$log,$module_name,$cmd_name;
    //$fa=$_REQUEST['FunctionA']."";
    $fb=$_REQUEST['FunctionB']."";

    $ip=ip();
    $sql="select * from terminal where terminal_ip='$ip'";
    $ret=$conn->query_first($sql);
    if(!$ret){
        echo("1");die;
    }
    if(intval($ret[store_id])==0){
        echo("1");die;
    }
    
    $sql="select count(*) as cnt from tire_info where place=0 and status<>'报废' and store_id={$ret[store_id]}";
    $ret1=$conn->query_first($sql);
    $sql="select count(*) as cnt from tire_info where status='报废' and store_id={$ret[store_id]}";
    $ret2=$conn->query_first($sql);
    $ret_str=sprintf("0%04s%04s",$ret1['cnt'],$ret2['cnt']);
    echo($ret_str);die;
}

$func="f".$type;
if (function_exists($func))
    eval("$func();");
else
    die("ERROR, 功能代码错误！");

?>