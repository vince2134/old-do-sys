<?php
//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

/****************************/
//契約関数定義
/****************************/
require_once(INCLUDE_DIR."function_keiyaku_0701.inc");

$client_h_id = $_SESSION["client_id"];  //ログインユーザID

/****************************/
//巡回日計算処理
/****************************/
$cal_array = Cal_range($db_con,$client_h_id);

$start_day = $cal_array[0];   //対象開始期間
$end_day = $cal_array[1];     //対象終了期間
$cal_peri = $cal_array[2];    //カレンダー表示期間

Db_Query($db_con, "BEGIN;");

//巡回日テーブル削除
$sql  = "DELETE FROM t_round;";
$result = Db_Query($db_con, $sql);
if($result === false){
    Db_Query($db_con, "ROLLBACK");
    exit;
}

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
$sql .= "    t_contract;";
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
	/****************************/
	//巡回日テーブル登録
	/****************************/
	for($s=0;$s<count($date_array);$s++){
		//登録

		$sql  = "INSERT INTO t_round( ";
		$sql .= "    contract_id,";
		$sql .= "    round_day ";
		$sql .= "    )VALUES(";
		$sql .= "    $contract_id,";
		$sql .= "    '".$date_array[$s]."' ";
		$sql .= "    );";

		$in_result = Db_Query($db_con, $sql);
		if($in_result === false){
	        Db_Query($db_con, "ROLLBACK");
	        exit;
	    }

		//ファイルにログを書込み(得意先ID)
		$fp = fopen("insert_log.txt","a");
		fputs($fp,$contract_id."　".$date_array[$s]."\n");
		fclose($fp);
	}
}
Db_Query($db_con, "COMMIT;");
print "巡回日テーブル作成完了"
?>
