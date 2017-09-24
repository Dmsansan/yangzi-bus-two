<?php
	/***说明
	获取登陆的用户的信息
	{"admin_id":1664,"admin_name":"QQ20151121085500","real_name":"小宝","email":null,"status":"在职"}
	***/
	include "../../config.inc.php"
?>
{"admin_id":1664,"admin_name":"QQ20151121085500","real_name":"<?php echo $_SESSION["RealName"]; ?>","email":null,"status":"在职"}
