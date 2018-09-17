<?php

/******************************
 *  変更履歴
 *      ・（2006-11-17）ROLLBACKした後に、エラー内容をログに出力 <suzuki>
 *
*******************************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/15      10-010      suzuki      商品・単価が同じ行は一つに纏めるように修正
 *  2006/11/15      10-020      suzuki      オフライン発注として伝票を起こす
 *  2006/11/16      10-025      suzuki      レンタル料を起こす際に、「レンタル料」という商品を使用して伝票を起こす
*/

//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

//本日の日付
$today_y = date("Y");  
$today_m = date("m");  
$today_d = date("d");    

//開始
$today = date("Y-m-d H:i:s");
error_log("$today レンタルデータの解約・レンタル料の受発注 開始 \n",3,LOG_FILE);

//エラー変数初期化
$error_con  = NULL;
$error_time = NULL;
$error_msg  = NULL;
$e_contents = NULL;
$error_flg  = NULL;

/****************************/
//ＣＲＯＮ関数定義
/****************************/
require_once(INCLUDE_DIR."function_rental.inc");
//require_once(INCLUDE_DIR."function_cron.inc");

//echo date("Y-m-d H:i");
/****************************/
//全レンタルID取得
/****************************/
$sql  = "SELECT ";
$sql .= "    rental_id ";
$sql .= "FROM ";
$sql .= "    t_rental_h ";
$sql .= "ORDER BY ";
$sql .= "    rental_id;";
$rental_result = Db_Query($db_con, $sql); 
while($rental_list = pg_fetch_array($rental_result)){

	Db_Query($db_con, "BEGIN;");
	$error_msg = NULL;   //エラー内容

	/****************************/
	//解約実行処理     
	/****************************/
	$result = Rental_sql($db_con,$rental_list[0],3);
	if($result === false){

		$error_con = pg_last_error();
		$error_time = date("Y-m-d H:i");
		$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."行目 レンタルデータの解約実行処理失敗 \nレンタルID: ".$rental_list[0]." \n";
		$error_msg[1] = "$error_con \n\n";
	}

	//正常に処理が終了
	if($error_msg == NULL){
		Db_Query($db_con, "COMMIT;");

    //処理に異常があった場合
	}else{
		Db_Query($db_con, "ROLLBACK");
		//FILEにエラー出力
		for($i=0;$i<count($error_msg);$i++){
			error_log($error_msg[$i],3,LOG_FILE);
			$e_contents .= $error_msg[$i];
		}

		$error_flg = true;  //異常発生フラグ
	}
}

//正常
if($error_flg == false){

	$today = date("Y-m-d H:i:s");
	//FILEに出力
	error_log("$today レンタルデータの解約完了 \n\n",3,LOG_FILE);

//異常
}else{

	//メールでエラー通知
	Error_send_mail($g_error_mail,$g_error_add,"レンタル処理で異常発生",$e_contents);
}

?>
