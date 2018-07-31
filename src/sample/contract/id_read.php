<?php

//´Ä¶­ÀßÄê¥Õ¥¡¥¤¥ë
require_once("ENV_local.php");

//DBÀÜÂ³
$db_con = Db_Connect();

//·ÀÌóID¼èÆÀ
$fp = fopen("check.txt","r");
while(feof($fp) == false){
	$id = fgets($fp);
	$ok_flg = false;

	$sql  = "SELECT DISTINCT ";
	$sql .= "    t_aorder_d.contract_id,";
	$sql .= "    t_aorder_h.aord_id,";
	$sql .= "    t_aorder_h.ord_no,";
	$sql .= "    t_aorder_h.ord_time ";
	$sql .= "FROM ";
	$sql .= "    t_aorder_h ";
	$sql .= "    INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
	$sql .= "WHERE ";
	$sql .= "    t_aorder_d.contract_id = $id;";
	$con_result = Db_Query($db_con,$sql); 
	$client_list = Get_Data($con_result);

	if($client_list == NULL){
		print "·ÀÌóID:$id<br>";
	}else{
		for($i=0;$i<count($client_list);$i++){
			if($client_list[$i][2] == NULL){
				$ok_flg = true;
			}
		}
	}
	if($ok_flg == false){
		print "·ÀÌóID:$id<br>";
	}
}
fclose($fp);

?>
