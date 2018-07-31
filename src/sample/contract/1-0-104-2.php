<?php

//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

/****************************/
//契約関数定義
/****************************/
require_once(INCLUDE_DIR."function_keiyaku_0701.inc");

/****************************/
//ショップごとに、該当する得意先取得
/****************************/
$sql  = "SELECT DISTINCT ";
$sql .= "    shop_id ";
$sql .= "FROM ";
$sql .= "    t_contract ";
$sql .= "ORDER BY ";
$sql .= "    shop_id;";
$shop_result = Db_Query($db_con, $sql); 
while($shop_list = pg_fetch_array($shop_result)){
	Db_Query($db_con, "BEGIN;");
	Db_Query($db_con, "LOCK TABLE t_aorder_h IN EXCLUSIVE MODE;");

	//カレンダー表示期間取得
	$cal_array = Cal_range($db_con,$shop_list[0]);
	$start_day = $cal_array[0];   //対象開始期間
	$end_day = $cal_array[1];     //対象終了期間
	$cal_peri = $cal_array[2];    //カレンダー表示期間

	/****************************/
	//得意先ごとに受注データ作成
	/****************************/
	$sql  = "SELECT DISTINCT ";
	$sql .= "    client_id ";
	$sql .= "FROM ";
	$sql .= "    t_contract ";
	$sql .= "WHERE ";
	$sql .= "    shop_id = ".$shop_list[0];
	$sql .= " ORDER BY ";
	$sql .= "    client_id;";
	$client_result = Db_Query($db_con, $sql); 
	while($client_list = pg_fetch_array($client_result)){
		Aorder_Query($db_con,$shop_list[0],$client_list[0],$start_day,$end_day);
	}
	Db_Query($db_con, "COMMIT;");
}

//ファイルにログを書込み
$today = date("Y-m-d H:i");
shell_exec("echo NOTCE $today suzuki >> /home/postgres/cron.log");

?>
