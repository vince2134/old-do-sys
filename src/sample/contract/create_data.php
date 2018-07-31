<?php

//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

//エラー変数初期化
$error_con  = NULL;
$error_time = NULL;
$error_msg  = NULL;
$e_contents = NULL;
$error_flg  = NULL;

/****************************/
//契約関数定義
/****************************/
require_once(INCLUDE_DIR."function_keiyaku_0701.inc");

//本日の日付
$today_y = date("Y");            
$today_m = date("m");
$today_d = date("d");
$to_date = "$today_y-$today_m-$today_d";

/****************************/
//ショップごとに、該当する得意先取得
/****************************/
$sql  = "SELECT DISTINCT ";
$sql .= "    t_contract.shop_id,";     //ショップID
$sql .= "    t_client.cal_peri_num ";  //カレンダー変更期間
$sql .= "FROM ";
$sql .= "    t_contract ";
$sql .= "    INNER JOIN t_client ON t_contract.shop_id = t_client.client_id ";
$sql .= "WHERE ";
$sql .= "    t_client.state = '1' ";
$sql .= "ORDER BY ";
$sql .= "    t_contract.shop_id;";
$shop_result = Db_Query($db_con, $sql); 
while($shop_list = pg_fetch_array($shop_result)){
	Db_Query($db_con, "BEGIN;");
	$error_msg = NULL;   //エラー内容

	//カレンダー表示期間取得
	$cal_array = Cal_range($db_con,$shop_list[0]);
	$start_day = $cal_array[0];   //対象開始期間(開始にも終了の日付を代入)
	$end_day = $cal_array[1];     //対象終了期間
	$cal_peri = $cal_array[2];    //カレンダー表示期間

	/****************************/
	//得意先ごとに受注データ作成
	/****************************/
	$sql  = "SELECT DISTINCT ";
	$sql .= "    t_contract.client_id ";
	$sql .= "FROM ";
	$sql .= "    t_contract ";
	$sql .= "    INNER JOIN t_client ON t_contract.client_id = t_client.client_id ";
	$sql .= "WHERE ";
	$sql .= "    t_client.state = '1' ";
	$sql .= "AND ";
	$sql .= "    t_contract.shop_id = ".$shop_list[0];
	$sql .= " ORDER BY ";
	$sql .= "    t_contract.client_id;";
	$client_result = Db_Query($db_con, $sql); 
	while($client_list = pg_fetch_array($client_result)){

		/****************************/
		//カレンダー表示期間の巡回日データ追加(通常伝票・オフライン伝票、変則日データ以外)
		/****************************/
		//巡回日情報取得処理
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
		$sql .= "    round_div != '7' ";
		$sql .= "AND ";
		$sql .= "    contract_div IN('1','3') ";
		$sql .= "AND ";
		$sql .= "    request_state = '2' ";
		$sql .= "AND ";
		$sql .= "    shop_id = ".$shop_list[0];
		$sql .= " AND ";
		$sql .= "    client_id = ".$client_list[0].";";
		$con_result = Db_Query($db_con, $sql); 

		while($con_list = pg_fetch_array($con_result)){

			$contract_id  = $con_list[0];  //契約情報ID
			$round_div    = $con_list[1];  //巡回区分
			$cycle        = $con_list[2];  //周期
			$cale_week    = $con_list[3];  //週名（１〜４）
			$abcd_week    = $con_list[4];  //週名（ＡＢＣＤ）
			$rday         = $con_list[5];  //指定日
			$week_rday    = $con_list[6];  //指定曜日
			$stand_day    = $con_list[7];  //作業基準日

			/****************************/
			//巡回日計算処理
			/****************************/
			$date_array = NULL;
			$date_array = Round_day($db_con,$cycle,$cale_week,$abcd_week,$rday,$week_rday,$stand_day,$round_div,$start_day,$end_day,$cal_peri);

		}
		/****************************/
		//受注データ登録関数＆受払テーブルに登録関数     
		/****************************/
		//通常・オフライン伝票作成
		$ao_result = Aorder_Query($db_con,$shop_list[0],$client_list[0],$start_day,$end_day,NULL,true);
		if($ao_result === false){
			//エラー判定
			if($error_msg == NULL){
				//既に異常が発生していなければエラー表示
				$error_con = pg_last_error();
				$error_time = date("Y-m-d H:i");
				$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."行目 受注データ登録関数＆受払テーブル登録関数処理失敗 \nショップID: ".$shop_list[0]." \n得意先ID: ".$client_list[0]." \n代行区分: 通常・オフライン伝票 \n";
				$error_msg[1] = "$error_con \n\n";
			}
		}

		//直営の場合は、オンライン伝票作成
		$sql  = "SELECT ";
		$sql .= "    t_rank.group_kind ";
		$sql .= "FROM ";
		$sql .= "    t_client ";
		$sql .= "    INNER JOIN t_rank ON t_client.rank_cd = t_rank.rank_cd ";
		$sql .= "WHERE ";
		$sql .= "    t_client.client_id = ".$shop_list[0].";";
		$r_result = Db_Query($db_con,$sql);
		$group_kind = pg_fetch_result($r_result,0,0);
		//直営判定
		if($group_kind == "2"){
			/****************************/
			//カレンダー表示期間の巡回日データ追加(オンライン伝票、変則日データ以外)
			/****************************/
			//巡回日情報取得処理
			$sql  = "SELECT ";
			$sql .= "    contract_id, ";
			$sql .= "    round_div,";
			$sql .= "    cycle,";
			$sql .= "    cale_week,";
			$sql .= "    abcd_week,";
			$sql .= "    rday,";
			$sql .= "    week_rday,";
			$sql .= "    stand_day,";
			$sql .= "    contract_div, ";
			$sql .= "    trust_id, ";
			$sql .= "    round_div ";
			$sql .= "FROM ";
			$sql .= "    t_contract ";
			$sql .= "WHERE ";
			$sql .= "    contract_div = '2' ";
			$sql .= "AND ";
			$sql .= "    request_state = '2' ";
			$sql .= "AND ";
			$sql .= "    shop_id = ".$shop_list[0];
			$sql .= " AND ";
			$sql .= "    client_id = ".$client_list[0].";";
			$con_result2 = Db_Query($db_con, $sql); 

			while($con_list2 = pg_fetch_array($con_result2)){

				$contract_id  = $con_list2[0];  //契約情報ID
				$round_div    = $con_list2[1];  //巡回区分
				$cycle        = $con_list2[2];  //周期
				$cale_week    = $con_list2[3];  //週名（１〜４）
				$abcd_week    = $con_list2[4];  //週名（ＡＢＣＤ）
				$rday         = $con_list2[5];  //指定日
				$week_rday    = $con_list2[6];  //指定曜日
				$stand_day    = $con_list2[7];  //作業基準日
				$contract_div = $con_list2[8];  //契約区分
				$trust_id     = $con_list2[9];  //受託先ID
				$round_div    = $con_list2[10]; //巡回区分

				//変則日以外なら巡回テーブルに追加
				if($round_div != 7){
					/****************************/
					//巡回日計算処理
					/****************************/
					$date_array = NULL;
					$date_array = Round_day($db_con,$cycle,$cale_week,$abcd_week,$rday,$week_rday,$stand_day,$round_div,$start_day,$end_day,$cal_peri);
				}
		
				/****************************/
				//受注データ登録関数＆受払テーブルに登録関数     
				/****************************/
				//オンライン伝票作成
				$ao_result = Aorder_Query($db_con,$shop_list[0],$client_list[0],$start_day,$end_day,$trust_id,true);
				if($ao_result === false){
					//エラー判定
					if($error_msg == NULL){
						//既に異常が発生していなければエラー表示
						$error_con = pg_last_error();
						$error_time = date("Y-m-d H:i");
						$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."行目 受注データ登録関数＆受払テーブル登録関数処理失敗 \nショップID: ".$shop_list[0]." \n得意先ID: ".$client_list[0]." \n委託先ID: $trust_id \n";
						$error_msg[1] = "$error_con \n\n";
					}
				}
			}
		}
	}

	//エラー判定
	if($error_msg == NULL){
		//正常

		Db_Query($db_con, "COMMIT;");
	}else{
		//異常

		Db_Query($db_con, "ROLLBACK");
		//FILEにエラー出力
		for($i=0;$i<count($error_msg);$i++){
			error_log($error_msg[$i],3,LOG_FILE);
			$e_contents .= $error_msg[$i];
		}

		$error_flg = true;  //異常発生フラグ
	}
}

//正常判定
if($error_flg == false){
	//正常

	$today = date("Y-m-d H:i");
	//FILEに出力
	error_log("$today 受注伝票作成完了 \n\n",3,LOG_FILE);
}else{
	//異常

	//メールでエラー通知
	Error_send_mail($g_error_mail,$g_error_add,"受注伝票作成処理で異常発生",$e_contents);
}

?>
