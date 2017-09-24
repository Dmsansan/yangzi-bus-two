<?
/**
 *  global.func.php 公共函数库
 *
 * @copyright
 * @license
 * @lastmodify
 */

function DEBUG($var){
	echo("<pre>");
	var_dump($var);
	echo("</pre>");
	die();
}

function ErrBack($text){
    echo "<Script>alert(\"".$text."\");history.go(-1);</script>";
    die();
}

function Input($body){                  //输入调整
    return eregi_replace("([\x80-\xff])[\x5c]","&7&",$body);
}

function ErrClose($text){
    echo "<Script>alert(\"".$text."\");</script>";
    die();
}

function ErrTo($text,$url){
    echo "<Script>alert(\"".$text."\");</script>";
    ToURL($url);
    die();
}

function Warning($text){
    echo "<Script>alert(\"".$text."\");</script>";
}

function Alert($text){
    echo "<Script>alert(\"".$text."\");</script>";
}

function RefrashToc(){
    echo "<Script>top.fraMenu.location = \"menu.php\";</script>";
}

function BackTo($text,$url){
    echo "<Script>alert(\"".$text."\");</script>";
    ToURL($url);
    die();
}

function ToURL($url){
    die("<Script>window.location='".$url."';</script>");
}

function substrgb($str,$start,$len){
		for($i=0;$i<$start+$len;$i++){
				$tmpstr=(ord($str[$i])>=161 && ord($str[$i])<=247 && ord($str[$i+1])>=161 && ord($str[$i+1])<=254)?$str[$i].$str[++$i]:$str[$i];
				if ($i>=$start&&$i<($start+$len)) $tmp.=$tmpstr;
		}
		return $tmp;
}

function intercept($text,$length){			//截取
    $j=0;
    for($i=0;$i<$length;$i++)
        if(ord(substr($text,$i,1))>0xa0)
        	$j++;
    if($j%2!=0)
    	$length++;
    $str=substr($text,0,$length);
    $str = SysEregi($str);
    return $str;
}

function intercept_big5($text,$length){		//截取
   	$j=0;
 	for($i=0;$i<$length;$i++)
   		if(ord(substr($text,$i,1))>0xa0)
   			$j++;
   	if($j%2!=0)
   		$length++;
   	$str=substr($text,0,$length);
  	$str = SysEregi_big5(gb2big5($str));
	return $str;
}

function eregi_char($text,$length){			//截取内容函数
	$rs1=eregi_replace("&lt;P&gt;","",$text);
    $rs2 =eregi_replace("&amp;nbsp;","",$rs1);
    $rs3 =eregi_replace("&lt;BR&gt;","",$rs2);
    $rs4=intercept($rs3,$length) ;
    return $rs4;
}

function intercept2($text,$length){
   	$j=0;
 	for($i=0;$i<$length;$i++)
   		if(ord(substr($text,$i,1))>0xa0)
   			$j++;
   	if($j%2!=0)
   		$length++;
   	$str=substr($text,0,$length);
 	return $str;
}

function SysEregi_big52($body){
	$body = eregi_replace("&7&\\\\","&#30902;",$body);
	$body = eregi_replace("&7&","&#30902;",$body);
	$body = eregi_replace("&amp;7&amp;","&#30902;",$body);
	$body = eregi_replace("&amp;amp;7&amp;amp;","&#30902;",$body);
	$body = eregi_replace("([\x80-\xff])&7&","&#30902;",$body);
	return $body;
}

function SysEregi_big5($body){
	$body = word($body);
	$body = eregi_replace("&7&\\\\","&#30902;",$body);
	$body = eregi_replace("&7&","&#30902;",$body);
	$body = eregi_replace("&amp;7&amp;","&#30902;",$body);
	$body = eregi_replace("&amp;amp;7&amp;amp;","&#30902;",$body);
	$body = eregi_replace("([\x80-\xff])&7&","&#30902;",$body);
	return $body;
}

function SysEregi_big5_title($body){
	$body = eregi_replace("&7&\\\\","&#30902;",$body);
	$body = eregi_replace("&7&","&#30902;",$body);
	$body = eregi_replace("&amp;7&amp;","&#30902;",$body);
	$body = eregi_replace("&amp;amp;7&amp;amp;","&#30902;",$body);
	$body = eregi_replace("([\x80-\xff])&7&","&#30902;",$body);
	return $body;
}

function nbsp($sum){			//空格
 	for($i=0;$i<$sum;$i++){
    	$html.= "&nbsp;";
    }
  	return $html;
}

function htmlspecialchars2($inf){
	$inf = eregi_replace("&amp;","&",$inf);
	$inf = eregi_replace("&quot;","\"",$inf);
	$inf = eregi_replace("&lt;","<",$inf);
	$inf = eregi_replace("&gt;",">",$inf);
	return $inf;
}

function htmlentities2($inf){
	$inf=htmlspecialchars($inf,ENT_QUOTES);
	$inf=str_replace(" ","&nbsp;",$inf);
	$inf=nl2br($inf);
	return $inf;
}

/**
 * 返回经addslashes处理过的字符串或数组
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function new_addslashes($string){
	if(!is_array($string)) return addslashes($string);
	foreach($string as $key => $val) $string[$key] = new_addslashes($val);
	return $string;
}

/**
 * 返回经stripslashes处理过的字符串或数组
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function new_stripslashes($string) {
	if(!is_array($string)) return stripslashes($string);
	foreach($string as $key => $val) $string[$key] = new_stripslashes($val);
	return $string;
}

/**
 * 返回经htmlspecialchars处理过的字符串或数组
 * @param $obj 需要处理的字符串或数组
 * @return mixed
 */
function new_html_special_chars($string) {
	if(!is_array($string)) return htmlspecialchars($string);
	foreach($string as $key => $val) $string[$key] = new_html_special_chars($val);
	return $string;
}
/**
 * 安全过滤函数
 *
 * @param $string
 * @return string
 */
function safe_replace($string) {
	$string = str_replace('%20','',$string);
	$string = str_replace('%27','',$string);
	$string = str_replace('%2527','',$string);
	$string = str_replace('*','',$string);
	$string = str_replace('"','&quot;',$string);
	$string = str_replace("'",'',$string);
	$string = str_replace('"','',$string);
	$string = str_replace(';','',$string);
	$string = str_replace('<','&lt;',$string);
	$string = str_replace('>','&gt;',$string);
	$string = str_replace("{",'',$string);
	$string = str_replace('}','',$string);
	$string = str_replace('\\','',$string);
	return $string;
}

/**
 * 过滤ASCII码从0-28的控制字符
 * @return String
 */
function trim_unsafe_control_chars($str) {
	$rule = '/[' . chr ( 1 ) . '-' . chr ( 8 ) . chr ( 11 ) . '-' . chr ( 12 ) . chr ( 14 ) . '-' . chr ( 31 ) . ']*/';
	return str_replace ( chr ( 0 ), '', preg_replace ( $rule, '', $str ) );
}

/**
 * 格式化文本域内容
 *
 * @param $string 文本域内容
 * @return string
 */
function trim_textarea($string) {
	$string = nl2br ( str_replace ( ' ', '&nbsp;', $string ) );
	return $string;
}

/**
 * 获取当前页面完整URL地址
 */
function get_url() {
	$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
	$php_self = $_SERVER['PHP_SELF'] ? safe_replace($_SERVER['PHP_SELF']) : safe_replace($_SERVER['SCRIPT_NAME']);
	$path_info = isset($_SERVER['PATH_INFO']) ? safe_replace($_SERVER['PATH_INFO']) : '';
	$relate_url = isset($_SERVER['REQUEST_URI']) ? safe_replace($_SERVER['REQUEST_URI']) : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.safe_replace($_SERVER['QUERY_STRING']) : $path_info);
	return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
}

/**
 * 字符截取 支持UTF8/GBK
 * @param $string
 * @param $length
 * @param $dot
 */
function str_cut($string, $length, $dot = '...') {
	$strlen = strlen($string);
	if($strlen <= $length) return $string;
	$string = str_replace(array(' ','&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array('∵',' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
	$strcut = '';
	if(strtolower(CHARSET) == 'utf-8') {
		$length = intval($length-strlen($dot)-$length/3);
		$n = $tn = $noc = 0;
		while($n < strlen($string)) {
			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t <= 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}
			if($noc >= $length) {
				break;
			}
		}
		if($noc > $length) {
			$n -= $tn;
		}
		$strcut = substr($string, 0, $n);
		$strcut = str_replace(array('∵', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), array(' ', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), $strcut);
	} else {
		$dotlen = strlen($dot);
		$maxi = $length - $dotlen - 1;
		$current_str = '';
		$search_arr = array('&',' ', '"', "'", '“', '”', '—', '<', '>', '·', '…','∵');
		$replace_arr = array('&amp;','&nbsp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;',' ');
		$search_flip = array_flip($search_arr);
		for ($i = 0; $i < $maxi; $i++) {
			$current_str = ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
			if (in_array($current_str, $search_arr)) {
				$key = $search_flip[$current_str];
				$current_str = str_replace($search_arr[$key], $replace_arr[$key], $current_str);
			}
			$strcut .= $current_str;
		}
	}
	return $strcut.$dot;
}

/**
 * 获取请求ip
 *
 * @return ip地址
 */
function ip() {
	if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
		$ip = getenv('HTTP_CLIENT_IP');
	} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
		$ip = getenv('REMOTE_ADDR');
	} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
}

function get_cost_time() {
	$microtime = microtime ( TRUE );
	return $microtime - SYS_START_TIME;
}

/**
 * 程序执行时间
 *
 * @return	int	单位ms
 */
function execute_time() {
	$stime = explode ( ' ', SYS_START_TIME );
	$etime = explode ( ' ', microtime () );
	return number_format ( ($etime [1] + $etime [0] - $stime [1] - $stime [0]), 6 );
}

/**
* 产生随机字符串
*
* @param    int        $length  输出长度
* @param    string     $chars   可选的 ，默认为 0123456789
* @return   string     字符串
*/
function random($length, $chars = '0123456789') {
	$hash = '';
	$max = strlen($chars) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $chars[mt_rand(0, $max)];
	}
	return $hash;
}

/**
* 将字符串转换为数组
*
* @param	string	$data	字符串
* @return	array	返回数组格式，如果，data为空，则返回空数组
*/
function string2array($data) {
	if($data == '') return array();
	@eval("\$array = $data;");
	return $array;
}
/**
* 将数组转换为字符串
*
* @param	array	$data		数组
* @param	bool	$isformdata	如果为0，则不使用new_stripslashes处理，可选参数，默认为1
* @return	string	返回字符串，如果，data为空，则返回空
*/
function array2string($data, $isformdata = 1) {
	if($data == '') return '';
	if($isformdata) $data = new_stripslashes($data);
	return addslashes(var_export($data, TRUE));
}

/**
* 转换字节数为其他单位
*
*
* @param	string	$filesize	字节大小
* @return	string	返回大小
*/
function sizecount($filesize) {
	if ($filesize >= 1073741824) {
		$filesize = round($filesize / 1073741824 * 100) / 100 .' GB';
	} elseif ($filesize >= 1048576) {
		$filesize = round($filesize / 1048576 * 100) / 100 .' MB';
	} elseif($filesize >= 1024) {
		$filesize = round($filesize / 1024 * 100) / 100 . ' KB';
	} else {
		$filesize = $filesize.' Bytes';
	}
	return $filesize;
}
/**
 * 查询字符是否存在于某字符串
 *
 * @param $haystack 字符串
 * @param $needle 要查找的字符
 * @return bool
 */
function str_exists($haystack, $needle)
{
	return !(strpos($haystack, $needle) === FALSE);
}

/**
 * 取得文件扩展
 *
 * @param $filename 文件名
 * @return 扩展名
 */
function fileext($filename) {
	return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
}

/**
 * 生成sql语句，如果传入$in_cloumn 生成格式为 IN('a', 'b', 'c')
 * @param $data 条件数组或者字符串
 * @param $front 连接符
 * @param $in_column 字段名称
 * @return string
 */
function to_sqls($data, $front = ' AND ', $in_column = false) {
	if($in_column && is_array($data)) {
		$ids = '\''.implode('\',\'', $data).'\'';
		$sql = "$in_column IN ($ids)";
		return $sql;
	} else {
		if ($front == '') {
			$front = ' AND ';
		}
		if(is_array($data) && count($data) > 0) {
			$sql = '';
			foreach ($data as $key => $val) {
				$sql .= $sql ? " $front `$key` = '$val' " : " `$key` = '$val' ";
			}
			return $sql;
		} else {
			return $data;
		}
	}
}

/**
 * 判断email格式是否正确
 * @param $email
 */
function is_email($email) {
	return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}

/**
 * IE浏览器判断
 */

function is_ie() {
	$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
	if((strpos($useragent, 'opera') !== false) || (strpos($useragent, 'konqueror') !== false)) return false;
	if(strpos($useragent, 'msie ') !== false) return true;
	return false;
}


/**
 * 文件下载
 * @param $filepath 文件路径
 * @param $filename 文件名称
 */

function file_down($filepath, $filename = '') {
	if(!$filename) $filename = basename($filepath);
	if(is_ie()) $filename = rawurlencode($filename);
	$filetype = fileext($filename);
	$filesize = sprintf("%u", filesize($filepath));
	if(ob_get_length() !== false) @ob_end_clean();
	header('Pragma: public');
	header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: pre-check=0, post-check=0, max-age=0');
	header('Content-Transfer-Encoding: binary');
	header('Content-Encoding: none');
	header('Content-type: '.$filetype);
	header('Content-Disposition: attachment; filename="'.$filename.'"');
	header('Content-length: '.$filesize);
	readfile($filepath);
	exit;
}

function send_pic($filepath, $filename = '') {
	if(!$filename) $filename = basename($filepath);
	if(is_ie()) $filename = rawurlencode($filename);
	$filetype = fileext($filename);
	$filesize = sprintf("%u", filesize($filepath));
	if(ob_get_length() !== false) @ob_end_clean();
	header('Pragma: public');
	header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
	header('Content-type: image/'.$filetype);
	header('Content-length: '.$filesize);
	readfile($filepath);
	exit;
}

/**
 * 判断字符串是否为utf8编码，英文和半角字符返回ture
 * @param $string
 * @return bool
 */
function is_utf8($string) {
	return preg_match('%^(?:
					[\x09\x0A\x0D\x20-\x7E] # ASCII
					| [\xC2-\xDF][\x80-\xBF] # non-overlong 2-byte
					| \xE0[\xA0-\xBF][\x80-\xBF] # excluding overlongs
					| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
					| \xED[\x80-\x9F][\x80-\xBF] # excluding surrogates
					| \xF0[\x90-\xBF][\x80-\xBF]{2} # planes 1-3
					| [\xF1-\xF3][\x80-\xBF]{3} # planes 4-15
					| \xF4[\x80-\x8F][\x80-\xBF]{2} # plane 16
					)*$%xs', $string);
}

/**
 * 对用户的密码进行加密
 * @param $password
 * @param $encrypt //传入加密串，在修改密码时做认证
 * @return array/password
 */
function password($password, $encrypt='') {
	$pwd = array();
	$pwd['encrypt'] =  $encrypt ? $encrypt : create_randomstr();
	$pwd['password'] = md5(md5(trim($password)).$pwd['encrypt']);
	return $encrypt ? $pwd['password'] : $pwd;
}
/**
 * 生成随机字符串
 * @param string $lenth 长度
 * @return string 字符串
 */
function create_randomstr($lenth = 6) {
	return random($lenth, '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
}

/**
 * 检查密码长度是否符合规定
 *
 * @param STRING $password
 * @return 	TRUE or FALSE
 */
function is_password($password) {
	$strlen = strlen($password);
	if($strlen >= 6 && $strlen <= 20) return true;
	return false;
}

 /**
 * 检测输入中是否含有错误字符
 *
 * @param char $string 要检查的字符串名称
 * @return TRUE or FALSE
 */
function is_badword($string) {
	$badwords = array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n","#");
	foreach($badwords as $value){
		if(strpos($string, $value) !== FALSE) {
			return TRUE;
		}
	}
	return FALSE;
}

/**
 * 检查用户名是否符合规定
 *
 * @param STRING $username 要检查的用户名
 * @return 	TRUE or FALSE
 */
function is_username($username) {
	$strlen = strlen($username);
	if(is_badword($username) || !preg_match("/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/", $username)){
		return false;
	} elseif ( 20 < $strlen || $strlen < 2 ) {
		return false;
	}
	return true;
}

/**
 * 检查id是否存在于数组中
 *
 * @param $id
 * @param $ids
 * @param $s
 */
function check_in($id, $ids = '', $s = ',') {
	if(!$ids) return false;
	$ids = explode($s, $ids);
	return is_array($id) ? array_intersect($id, $ids) : in_array($id, $ids);
}

/**
 * 对数据进行编码转换
 * @param array/string $data       数组
 * @param string $input     需要转换的编码
 * @param string $output    转换后的编码
 */
function array_iconv($data, $input = 'gbk', $output = 'utf-8') {
	if (!is_array($data)) {
		return iconv($input, $output, $data);
	} else {
		foreach ($data as $key=>$val) {
			if(is_array($val)) {
				$data[$key] = array_iconv($val, $input, $output);
			} else {
				$data[$key] = iconv($input, $output, $val);
			}
		}
		return $data;
	}
}


function getmicrotime() {
	list($usec, $sec) = explode(" ",microtime());
	return ((float)$usec + (float)$sec);
}

/**
 *
 * 获取远程内容
 * @param $url 接口url地址
 * @param $timeout 超时时间
 */
function pc_file_get_contents($url, $timeout=30) {
	$stream = stream_context_create(array('http' => array('timeout' => $timeout)));
	return @file_get_contents($url, 0, $stream);
}

/**
 *
 * 转换2013-01-04 17:00:02到unixtimestamp
 * @param $timestr
 */
function ymdhis2ts($timestr) {
	$h=strval(substr($timestr,11,2));
	$i=strval(substr($timestr,14,2));
	$s=strval(substr($timestr,17,2));
	$m=strval(substr($timestr,5,2));
	$d=strval(substr($timestr,8,2));
	$y=strval(substr($timestr,0,4));
	return mktime($h,$i,$s,$m,$d,$y);
}

/**
 *
 * 转换unixtimestamp到2013-01-04 17:00:02
 * @param $ts
 */
function ts2ymdhis($ts) {
	return date("Y-m-d H:i:s",$ts);
}

/**
 * 测试文件扩展名是否符合要求
 */
function testsuffix($filename,$exts){
	$suffix = fileext($filename);
	$exts=explode("|",strtolower($exts));
	$ret=array_search($suffix,$exts);

	if($ret!==false)
		return $exts[$ret];
	else
		return false;
}

function file_type($filename){
	$suffix = strtolower(fileext($filename));
	$pics = "jpg|jpeg|png|gif";
	$videos = "avi|mov|mpg|mpeg|wmv";
    $texts = "txt|sql|log|ini|html|htm|js|css";

	$exts=explode("|",strtolower($pics));
	$ret=array_search($suffix,$exts);

	if($ret!==false)
		return 1;       //picture

	$exts=explode("|",strtolower($videos));
	$ret=array_search($suffix,$exts);

	if($ret!==false)
		return 2;       //movies

	$exts=explode("|",strtolower($texts));
	$ret=array_search($suffix,$exts);

	if($ret!==false)
		return 3;       //text
	else
		return 0;
}

/*
function do_log($dbconn, $event, $log_text=""){
    $manager_id=$_SESSION['ManagerID'];
    if(!isset($manager_id))$manager_id=-1;
    $login_name="";

    if($event=="登录"){
        echo"1";
        $login_name=$_REQUEST['admin_name'];
    }
    var_dump($_REQUEST);die;
    $sql="insert into logs (manager_id,login_name,event,log,stamp) values ($manager_id,'$login_name','$event','$log_text',now())";
    
    $dbconn->query($sql);
}
*/
?>
