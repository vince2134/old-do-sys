<?php
//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect("amenity");

$sql  = "SELECT DISTINCT ";
$sql .= "    t_aorder_h.aord_id ";
$sql .= "FROM ";
$sql .= "    t_aorder_h ";
$sql .= "    INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
$sql .= "WHERE ";
$sql .= "    t_aorder_d.contract_id IS NOT NULL;";
$result = Db_Query($db_con, $sql); 
$data_list = Get_Data($result);

//受注ヘッダー削除処理処理
Db_Query($db_con, "BEGIN");   
for($i=0;$i<count($data_list);$i++){
	$sql  = "DELETE FROM t_aorder_h ";
	$sql .= "WHERE ";
	$sql .= "    aord_id = ".$data_list[$i][0].";";
	$result = Db_Query($db_con, $sql);                                                   
	if($result === false){                                                               
	    Db_Query($db_con, "ROLLBACK");                                                   
	    exit;
	}
}
Db_Query($db_con, "COMMIT");
print "削除完了";

?>
