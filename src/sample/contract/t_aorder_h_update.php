<?php
//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

Db_Query($db_con, "BEGIN;");

/****************************/
//オフラインの受注ID取得
/****************************/
$sql  = "SELECT ";
$sql .= "    distinct t_aorder_h.aord_id "; //受注ID
$sql .= "FROM ";
$sql .= "    t_aorder_d ";
$sql .= "    INNER JOIN t_aorder_h ON t_aorder_d.aord_id = t_aorder_h.aord_id ";
$sql .= "WHERE ";
$sql .= "    t_aorder_h.contract_div = '3';";
$aord_result = Db_Query($db_con, $sql);

while($aord_list = pg_fetch_array($aord_result)){
	
	$aord_id   = $aord_list[0];      
	
	$sql  = "UPDATE t_aorder_h SET ";
	$sql .= "    ware_id = NULL,";
	$sql .= "    ware_name = NULL ";
	$sql .= "WHERE ";
	$sql .= "    aord_id = $aord_id;";
	$up_result = Db_Query($db_con, $sql);
	if($up_result === false){
	    Db_Query($db_con, "ROLLBACK");
	    exit;
	}

	//ファイルにログを書込み(得意先ID・請求先ID・請求区分)
	$fp = fopen("aord_log.txt","a");
	fputs($fp,$client_id."　".$claim_id."　".$claim_div."\n");
	fclose($fp);
}

Db_Query($db_con, "COMMIT;");
print "受注ヘッダ更新完了";

?>
