<?php

/***说明
	获取对应模块的 滑动菜单
	传入参数module_id 
	用户session
	以下简易输出
****/

include '../../config.inc.php';

$conn = new db(DB_TYPE,DB_HOST,DB_NAME,DB_USER,DB_PASS,true,SYSTEM_PATH.'log');

$sql="select modules_list_val from roles where role_id=".$_SESSION[RoleID];
$ret=$conn->query_first($sql);
$modules_list_val="";
if($ret){
    $modules_list_val=str_replace(";",",",$ret[modules_list_val]);
}

$module_id = $_REQUEST['module_id'];
$sub_module_from=$module_id."00";
$sub_module_to=$module_id."99";

$sql="select * from modules where module_id in (
    select distinct parent_id
    from modules
    where module_id >=100000 and 
				module_id in(
					$modules_list_val
				) and parent_id >=$sub_module_from and parent_id<=$sub_module_to )
    order by parent_id asc,module_id asc
";
$res=$conn->query($sql);

$l2cnt=$conn->num_rows($res);

if($l2cnt>0){
    echo "[";
    $i=0;
    while($rec=$conn->fetch_array($res)){
        echo "{";

        echo "'Menu_id': '$rec[module_id]',";
        echo "'Menu_name': '$rec[menu_name]',";
        echo "'parentid': '$rec[parent_id]',";
        echo "'Menu_url': '$rec[menu_url]',";
        echo "'Menu_icon': '$rec[ico]',";
        echo "'Menu_handler': '',";
        echo "'Menu_order': '$rec[seq]',";
        echo "'Menu_type': 'sys',";
        echo "'children': [";
        
        $sql="select * from modules where module_id in ($modules_list_val) and parent_id=$rec[module_id]";
        $res1=$conn->query($sql);

        $l3cnt=$conn->num_rows($res1);

        if($l3cnt>0){
            $j=0;
            while($rec1=$conn->fetch_array($res1)){
                echo "{";
                echo "'Menu_id': '$rec1[module_id]',";
                echo "'Menu_name': '$rec1[menu_name]',";
                echo "'parentid': '$rec1[parent_id]',";
                echo "'Menu_url': '$rec1[menu_url]',";
                echo "'Menu_icon': '$rec1[ico]',";
                echo "'Menu_handler': '',";
                echo "'Menu_order': '$rec1[seq]',";
                echo "'Menu_type': 'sys'";
                echo "}";            
                $j++;
                if($j<$l3cnt)
                    echo ",";
            }
        }
        
/*    {
		"Menu_id": "131110",
		"Menu_name": "车辆轮胎历史状态",
		"parentid": "1311",
		"Menu_url": "module_13/sys.his_show.php",
		"Menu_icon": "images/icon/37.png",
		"Menu_handler": "",
		"Menu_order": "20",
		"Menu_type": "sys"
	},
	{
		"Menu_id": "131210",
		"Menu_name": "告警历史状态",
		"parentid": "1311",
		"Menu_url": "module_13/sys.alarm_his131210_show.php",
		"Menu_icon": "images/icon/37.png",
		"Menu_handler": "",
		"Menu_order": "20",
		"Menu_type": "sys"
	}*/
        echo "]";


        echo "}";
        $i++;
        if($i<$l2cnt)
            echo ",";
    }
    echo "]";
}
?>