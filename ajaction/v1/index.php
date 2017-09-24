<?
/**
 *  index.php 入口
 *
 * @copyright			
 * @license				
 * @lastmodify		
 */
 
include '../../config.inc.php';

$cmd=trim($_REQUEST["cmd"]."");
$cmdx=trim($_REQUEST["cmdx"]."");
$menuid=trim($_REQUEST["menuid"]."");

if($menuid == "" || ($cmd == "" && $cmdx == "" )){
	$arr = array ('status'=>'ERROR','reason'=>'非法操作！');
	echo json_encode($arr);
	die();
}

$model_name=$module_map[$menuid];

$page = MODULES_PATH.$model_name.'.php';
require_once($page);

eval("\$model=new $model_name();");

#var_dump($model);
if($cmdx!="")
    $model->do_cmd($cmdx);
else
    $model->do_cmd($cmd);
?>