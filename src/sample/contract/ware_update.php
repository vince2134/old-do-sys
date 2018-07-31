<?php
//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

Db_Query($db_con, "BEGIN;");

//倉庫IDを全て東陽倉庫に更新
$sql  = "SELECT ";
$sql .= "    aord_id ";
$sql .= "FROM ";
$sql .= "    t_aorder_h ";
$sql .= "WHERE ";
$sql .= "    t_aorder_h.shop_id = 93 ";
$sql .= "AND ";
$sql .= "    t_aorder_h.reason_cor IS NOT NULL;";
$aord_result = Db_Query($db_con,$sql);

while($aord_list = pg_fetch_array($aord_result)){
	$aord_id  = $aord_list[0];      

	$sql  = "UPDATE t_aorder_h SET ";
	$sql .= "    ware_id = 7 ";
	$sql .= " WHERE ";
	$sql .= "    aord_id = $aord_id;";
	$up_result = Db_Query($db_con, $sql);
	if($up_result === false){
	    Db_Query($db_con, "ROLLBACK");
	    exit;
	}
}

//受払の倉庫IDを東陽倉庫に更新
$sql  = "SELECT ";
$sql .= "    aord_d_id ";
$sql .= "FROM ";
$sql .= "    t_aorder_h ";
$sql .= "    INNER JOIN t_aorder_d ON t_aorder_d.aord_id = t_aorder_h.aord_id ";
$sql .= "WHERE ";
$sql .= "    t_aorder_h.shop_id = 93 ";
$sql .= "AND ";
$sql .= "    t_aorder_h.reason_cor IS NOT NULL;";
$aord_d_result = Db_Query($db_con,$sql);

while($aord_d_list = pg_fetch_array($aord_d_result)){
	$aord_d_id  = $aord_d_list[0];      

	$sql  = "UPDATE t_stock_hand SET ";
	$sql .= "    ware_id = 7 ";
	$sql .= " WHERE ";
	$sql .= "    aord_d_id = $aord_d_id;";
	$up_result = Db_Query($db_con, $sql);
	if($up_result === false){
	    Db_Query($db_con, "ROLLBACK");
	    exit;
	}
}

Db_Query($db_con, "COMMIT;");
print "倉庫更新完了";

?>
