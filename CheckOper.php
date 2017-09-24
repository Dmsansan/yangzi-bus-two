<?php
	include './config.inc.php';	
?>
function CheckOper(s)
{	
	<?php
	echo "OperList=\"".$_SESSION["OperList"]."\";";
	?>
	return OperList.indexOf(s)<0;
}
