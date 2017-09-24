<?

require_once("../../config.inc.php");

$conn = new db(DB_TYPE,DB_HOST,DB_NAME,DB_USER,DB_PASS,true,SYSTEM_PATH.'log');

$sql="select * from admins";

$res=$conn->query($sql);
while($rec=$conn->fetch_array($res)){
    var_dump($rec);
}

?>