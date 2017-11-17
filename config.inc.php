<?
/**
 * @copyright			
 * @license				
 * @lastmodify		
 */

ob_start();
session_start();

ini_set("display_errors", "On");
#error_reporting(E_ALL);
error_reporting(E_ERROR);

date_default_timezone_set('PRC');

if (get_magic_quotes_gpc()) {
    function stripslashes_deep($value)
    {
        $value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
        return $value;
    }
    $_POST   = array_map('stripslashes_deep', $_POST);
    $_GET    = array_map('stripslashes_deep', $_GET);
    $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
}

//调试模式开关，目前主要用来关闭会话检查
define('DEBUG', 1);			//1调试模式，0关闭调试模式

//系统平台相关目录
define('SYSTEM_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
define('INCLUDE_PATH', SYSTEM_PATH.'includes'.DIRECTORY_SEPARATOR);
define('CLASSES_PATH', SYSTEM_PATH.'includes'.DIRECTORY_SEPARATOR);
define('MODULES_PATH', SYSTEM_PATH.'ajaction/v1/modules'.DIRECTORY_SEPARATOR);

//允许上传的文件扩展名
define('ALLOW_EXT', 'jpg|gif|png|jpeg');
define('ARCHIVE_EXT', 'zip');
define('DATA_EXT', 'xls');
define('MEDIA_EXT', 'jpg|gif|png|jpeg|swf|wmv|mp3|mp4|avi|mov');

//主机协议
define('SITE_PROTOCOL', isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://');
//当前访问的主机名
define('SITE_URL', isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
//来源
define('HTTP_REFERER', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');

//系统开始时间
define('SYS_START_TIME', microtime());

//数据库参数
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost:3306');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'ttms_yangzi');	
//用户空闲超时(分钟)
define('SESSION_TIMEOUT', 20);

//用户名最短长度
define('USERNAME_LEN_MIN', 1);
//用户密码最短长度
define('USERPASS_LEN_MIN', 1);

//加载公用函数库
include INCLUDE_PATH.'global.func.php';

//加载数据库操作库
include CLASSES_PATH.'db.class.php';
//加载日志操作库
include CLASSES_PATH.'log.class.php';

define('CHARSET' ,'UTF-8');
//define('CHARSET' ,'GB2312');
//输出页面字符集
header('Content-type: text/html; charset='.CHARSET);

define('SYS_TIME', time());

define('ADMIN_NAMES', "admin,dinghf,chenhf");

$tire_position = array(
	'0'=>'未安装',
    '1'=>'左前',
    '2'=>'右前',
    '3'=>'左后外侧',
    '4'=>'左后内侧',
    '5'=>'右后内侧',
    '6'=>'右后外侧',
);

$module_map = array(
	'0' => 'sys',//通用功能
    '101010' => 'roles',//角色管理
    '101011' => 'admins',//用户管理
	'101110' => 'store',//车队(仓库)管理
	'101111' => 'terminal',//手持终端管理
	'101112' => 'brand',//轮胎品牌管理
	'101113' => 'norms',//轮胎规格管理
	'101114' => 'c_class',//轮胎层级管理
	'101115' => 'vehicle_term',//车载终端管理
	'111011' => 'sensor',//传感器管理
    '101117' => 'figure_type',//花纹类型管理
	
	'101116' => 'company',//分公司管理
	'101118' => 'roules',//线路管理
	
    '111010' => 'tire_param_info',//轮胎参数管理
    '111110' => 'tire_info',//轮胎管理
    '111111' => 'tire_delivers',//轮胎配送
    '121010' => 'bus_info',//车辆管理
    '121011' => 'tire_exchg',//轮胎替换管理
    '131510' => 'tire_count',//轮胎统计
    '141010' => 'sys_log',//系统日志

    '131010' => 'realtime_mon',//实时监控管理
    '131110' => 'history_mon',//历史记录管理
    '131112' => 'alarm_mon_store',//胎压告警历史 	//***
    '131210' => 'alarm_history_mon',//告警历史记录管理
    
    '131310' => 'tire_used_time',//轮胎使用情况管理
    '131311' => 'tire_mile_count',//轮胎使用里程管理
    '131610' => 'curve_pt',//轮胎历史曲线 			//***
    '131612' => 'curve_pt_alarm',//轮胎历史告警		//***
    '131614' => 'curve_speed'//车辆车速分析			//***
);

$module_name = array(
	'sys' => '通用功能',
    'roles' => '角色管理',
    'admins' => '用户管理',
	'store' => '车队(仓库)管理',
	'terminal' => '手持终端管理',
	'brand' => '轮胎品牌管理',
	'norms' => '轮胎规格管理',
	'c_class' => '轮胎层级管理',
	'vehicle_term' => '车载终端管理',
	'sensor' => '传感器管理',
	
	'company' => '分公司管理',
	'roules' => '线路管理',
	
    'figure_type' => '花纹类型管理',
    'tire_param_info' => '轮胎参数管理',
    'tire_info' => '轮胎管理',
    'tire_delivers' => '轮胎配送',
    'bus_info' => '车辆管理',
    'tire_exchg' => '轮胎替换管理',
    'realtime_mon' => '实时监控管理',
    'tire_used_time' => '轮胎使用情况管理',
    'tire_count' => '轮胎统计',
    'sys_log' => '系统日志',
    'history_mon' => '历史记录管理',
    'alarm_history_mon' => '告警历史记录管理',
    'tire_mile_count' => '轮胎使用里程管理'
);

$cmd_name = array(
	'add' => '新增',
    'edit' => '修改',
    'del' => '删除',
	'qry' => '列表',
	'exp' => '导出',
	'qrybyone' => '列表',
    'login' => '登录',
    'logout' => '登出',
    'install_tire' => '安装',
    'uninstall_tire' => '卸载'
);

?>
