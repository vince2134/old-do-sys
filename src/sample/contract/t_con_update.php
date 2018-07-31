<?php
//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

Db_Query($db_con, "BEGIN;");

/****************************/
//請求先登録処理
/****************************/
$sql  = "SELECT ";
$sql .= "    t_contract.client_id,"; //得意先ID
$sql .= "    t_claim.claim_id, ";    //請求先ID
$sql .= "    t_claim.claim_div ";    //請求先区分
$sql .= "FROM ";
$sql .= "    t_claim ";
$sql .= "    INNER JOIN t_contract ON t_contract.client_id = t_claim.client_id ";
$sql .= "WHERE ";
$sql .= "    t_claim.claim_div = '1';";
$con_result = Db_Query($db_con, $sql);
while($con_list = pg_fetch_array($con_result)){
	
	$client_id   = $con_list[0];      
	$claim_id    = $con_list[1];   
	$claim_div   = $con_list[2];   
	
	$sql  = "UPDATE t_contract SET ";
	$sql .= "    claim_id = $claim_id,";
	$sql .= "    claim_div = '$claim_div' ";
	$sql .= "WHERE ";
	$sql .= "    client_id = $client_id;";
	$up_result = Db_Query($db_con, $sql);
	if($up_result === false){
	    Db_Query($db_con, "ROLLBACK");
	    exit;
	}

	//ファイルにログを書込み(得意先ID・請求先ID・請求区分)
	$fp = fopen("con_log.txt","a");
	fputs($fp,$client_id."　".$claim_id."　".$claim_div."\n");
	fclose($fp);
}

Db_Query($db_con, "COMMIT;");
print "契約マスタ更新完了";

?>
