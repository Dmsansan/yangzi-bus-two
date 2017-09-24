<?
/*合并TLW上7月28号到9月23号的历史记录数据到南京的数据库*/
//die();
require_once("../config.inc.php");

$nj_conn = new db(DB_TYPE,DB_HOST,"DBTTMS",DB_USER,DB_PASS,true,SYSTEM_PATH.'log');
$tlw_conn = new db(DB_TYPE,"61.155.91.4:63306","DBTTMS",DB_USER,DB_PASS,true,SYSTEM_PATH.'log');

//$date_from="2016-07-28 00:00:00";
//$date_to="2016-09-23 23:59:59";

//$file=fopen("/tmp/id.txt","rt");
//$id=fgets($file);
//fclose($file);

//$id_from=$id;

//$sql="select * from bt_history_log where log_stamp>='$date_from' and log_stamp<='$date_to' and id>$id_from order by id asc";
$sql="select bus_id,tire_id,place from bus_info inner join tire_info where tire_info.plate_no=bus_info.plate_no";
$res=$nj_conn->query($sql);
$i=0;
//echo "test";
while($rec=$nj_conn->fetch_array($res)){
    //echo $rec[place]." ".$rec[tire_id]." ".$rec[bus_id]."<br>";
	
	$sql1="update bt_history_log58 set tire_id".intval($rec[place])."=$rec[tire_id] where bus_id=$rec[bus_id];";
    echo $sql1."<br>";
	$i++;
	/*$ret=$tlw_conn->query_first($sql1);
    if(!$ret)continue;
    echo $i,"，",$rec[id],"，",$ret[plate_no],"<br>";
    $id=$rec[id];
    $lsql="select tire_id,place from tire_info where plate_no='$ret[plate_no]'";
    $lres=$nj_conn->query($lsql);
    while($lrec=$nj_conn->fetch_array($lres)){
        if(intval($lrec[place])>0){
            $t="tire_id".intval($lrec[place]);
        echo $rec[$t],"=>";
            $rec[$t]=$lrec[tire_id];
        echo $rec[$t],"<br>";
        }
    }
    $nj_conn->free_result($lres);

    for($i=0;$i<55;$i++){
        unset($rec[$i]);
    }
    unset($rec[id]);
    
    $values=implode("','",$rec);
    $values="'".$values."'";
    $sql="insert into bt_history_log (bus_id,speed,max_speed,tire_id1,pressure1,overflow_pressure1,temp1,overflow_temp1,tire_id2,pressure2,overflow_pressure2,temp2,overflow_temp2,tire_id3,pressure3,overflow_pressure3,temp3,overflow_temp3,tire_id4,pressure4,overflow_pressure4,temp4,overflow_temp4,tire_id5,pressure5,overflow_pressure5,temp5,overflow_temp5,tire_id6,pressure6,overflow_pressure6,temp6,overflow_temp6,tire_id7,pressure7,overflow_pressure7,temp7,overflow_temp7,tire_id8,pressure8,overflow_pressure8,temp8,overflow_temp8,tire_id9,pressure9,overflow_pressure9,temp9,overflow_temp9,tire_id10,pressure10,overflow_pressure10,temp10,overflow_temp10,log_stamp) values ($values)";

    $nj_conn->query($sql);
    $file=fopen("/tmp/id.txt","wb");
    fprintf($file,"%s",$id);
    fclose($file);
	*/
}
echo $i;

?>