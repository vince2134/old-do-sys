<?php
//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

/****************************/
//契約関数定義
/****************************/
require_once(INCLUDE_DIR."function_keiyaku.inc");

$client_h_id = $_SESSION["client_id"];  //ログインユーザID

/****************************/
//巡回日計算処理
/****************************/
$cal_array = Cal_range($db_con,$client_h_id);

$start_day = $cal_array[0];   //対象開始期間
$end_day = $cal_array[1];     //対象終了期間
$cal_peri = $cal_array[2];    //カレンダー表示期間

/****************************/
//巡回日情報取得処理
/****************************/
$sql  = "SELECT ";
$sql .= "    contract_id, ";
$sql .= "    round_div,";
$sql .= "    cycle,";
$sql .= "    cale_week,";
$sql .= "    abcd_week,";
$sql .= "    rday,";
$sql .= "    week_rday,";
$sql .= "    stand_day ";
$sql .= "FROM ";
$sql .= "    t_contract ";
$sql .= "WHERE ";
$sql .= "    abcd_week IN('21','22','23','24');";
$result = Db_Query($db_con, $sql); 

while($con_list = pg_fetch_array($result)){

	$contract_id = $con_list[0];  //契約情報ID
	$cycle       = $con_list[2];  //周期
	$cale_week   = $con_list[3];  //週名（１〜４）
	$abcd_week   = $con_list[4];  //週名（ＡＢＣＤ）
	$rday        = $con_list[5];  //指定日
	$week_rday   = $con_list[6];  //指定曜日
	$stand_day   = $con_list[7];  //作業基準日
	$round_div   = $con_list[1];  //巡回区分

	/****************************/
	//巡回日計算処理
	/****************************/
	$date_array = NULL;
	$date_array = Round_day($db_con,$cycle,$cale_week,$abcd_week,$rday,$week_rday,$stand_day,$round_div,$start_day,$end_day,$cal_peri);
	print_array($date_array);
}

//巡回基準日
$sql  = "SELECT stand_day FROM t_stand;";
$result = Db_Query($db_con, $sql); 
$stand_day = pg_fetch_result($result,0,0);   
$day_by = substr($stand_day,0,4);
$day_bm = substr($stand_day,5,2);
$day_bd = substr($stand_day,8,2);

//本日 or 対象終了期間の日付
$day_y = substr($start_day,0,4);
$day_m = substr($start_day,5,2);
$day_d = substr($start_day,8,2);

//本日が何週の何日か取得処理
$base_date = Basic_date($day_by,$day_bm,$day_bd,$day_y,$day_m,$day_d);

print_array($base_date);

?>
