<?
	/****说明
	本模块用于输出主工具栏功能模块
	
	样例 {Items:[{type: 'button',text: '系统管理',icon: 'images/icon/62.png',disable: false,click: function () {f_according(1)}},{type: 'button',text: '轮胎管理',icon: 'images/icon/85.png',disable: false,click: function () {f_according(2)}},{type: 'button',text: '车辆管理',icon: 'images/icon/37.png',disable: false,click: function () {f_according(3)}},{type: 'button',text: '监测系统',icon: 'images/icon/71.png',disable: false,click: function () {f_according(4)}},{type: 'button',text: '系统日志',icon: 'images/icon/77.png',disable: false,click: function () {f_according(5)}}]}
	f_according(这里为module_id)
	根据用户的 session 反回该用户的模块(排除模块ID>90的   模块>90的模块为网页端不可见但终端可操作模块)
	****/
include '../../config.inc.php';

$conn = new db(DB_TYPE,DB_HOST,DB_NAME,DB_USER,DB_PASS,true,SYSTEM_PATH.'log');

$sql="select modules_list_val from roles where role_id=".$_SESSION[RoleID];
$ret=$conn->query_first($sql);
//print_r($ret[modules_list_val]);
	$_SESSION['modules_list_val'] = explode(';',$ret[modules_list_val]);
	print_r($_SESSION['modules_list_val']);
	die;
    //$modules_list_val=explode(";",$ret[modules_list_val]);
    //$cnt=count($modules_list_val);
//{Items:[{type: 'button',text: '系统管理',icon: 'images/icon/62.png',disable: false,click: function () {f_according(10)}},{type: 'button',text: '轮胎管理',icon: 'images/icon/85.png',disable: false,click: function () {f_according(11)}},{type: 'button',text: '车辆管理',icon: 'images/icon/cl.png',disable: false,click: function () {f_according(12)}},{type: 'button',text: '监测系统',icon: 'images/icon/jc.png',disable: false,click: function () {f_according(13)}},{type: 'button',text: '系统日志',icon: 'images/icon/29.png',disable: false,click: function () {f_according(14)}}]}
?>
