<?php
//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

/****************************/
//契約から起こした受注データ削除処理
/****************************/
//本日以降の受注ヘッダー
$today = "2006-07-01";

//契約から起こした受注ID取得
$sql  = "SELECT ";
$sql .= "    t_aorder_h.aord_id ";
$sql .= "FROM ";
$sql .= "    t_aorder_h ";
$sql .= "    INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
$sql .= "WHERE ";
$sql .= "    t_aorder_h.ord_time >= '$today' ";
$sql .= "AND "; 
$sql .= "    (t_aorder_h.confirm_flg = 't' OR t_aorder_h.trust_confirm_flg = 't')";
$sql .= "AND ";
$sql .= "    t_aorder_d.contract_id IS NOT NULL;";
$result = Db_Query($db_con, $sql);
$aord_list = Get_Data($result);

Db_Query($db_con, "BEGIN");
for($a=0;$a<count($aord_list);$a++){

	//対象期間の売上ヘッダを削除
	$sql  = "DELETE FROM ";
	$sql .= "    t_sale_h ";
	$sql .= "WHERE ";
	$sql .= "    aord_id = ".$aord_list[$a][0].";";
	$result = Db_Query($db_con, $sql);
	if($result === false){
	    Db_Query($db_con, "ROLLBACK");
	    exit;
	}

	//対象期間の受注ヘッダを削除
	$sql  = "DELETE FROM ";
	$sql .= "    t_aorder_h ";
	$sql .= "WHERE ";
	$sql .= "    aord_id = ".$aord_list[$a][0].";";
	$result = Db_Query($db_con, $sql);
	if($result === false){
	    Db_Query($db_con, "ROLLBACK");
	    exit;
	}
}
Db_Query($db_con, "COMMIT");
print "契約から起こした売上データ削除<br><br>";

/*
伝票番号テーブル削除
DELETE FROM t_aorder_no_serial;
DELETE FROM t_aorder_no_serial_fc;
DELETE FROM t_payin_no_serial;
INSERT INTO t_aorder_no_serial (SELECT MAX(sale_no) FROM t_sale_h WHERE shop_id = 93);
INSERT INTO t_payin_no_serial (SELECT MAX(pay_no) FROM t_payin_h WHERE shop_id = 93);
*/

?>
