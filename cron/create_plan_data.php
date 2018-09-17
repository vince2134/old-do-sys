<?php

/*
変更履歴
 ・ 2006-11-02 カレンダー表示期間変更時に受注伝票（削除・作成）処理<suzuki>
 ・ 2006-11-17 ROLLBACKした後に、エラー内容をログに出力 <suzuki>
 ・ 2006-11-28 依頼中の契約の巡回日も作成するように修正<suzuki>
    理由：契約登録時には巡回日を作成している為、依頼中のままだとCRONを実行しても依頼中の巡回日は作成されない
          本当なら受託した時に作成すればいいのだが、変更ステップ数が大きい為、CRON側を修正
 ・ 2007-04-05 伝票の作成は、「得意先の取引状況」でなく「契約の取引状況」を判断するように修正<morita-d>
 ・ 2007-06-05 伝票の作成は、「得意先単位」でなく「契約単位」で実施するように修正<morita-d>

*/


/*
 * ■不具合の対応方法（例：3月23日からCRONが実施されていなかった）
 * １．以下の変数を定義
 * $update_flg = "t";
 * $day_y = "2007";
 * $day_m = "03";
 * $day_d = "23";
 *
 * ２．postgresユーザで「php create_plan_data.php」を実行
 *
 */
//不具合により「3月23日」以降に作成された伝票を作り直す場合は以下を有効にします
/*
$update_flg = "t";
$day_y = "2007";
$day_m = "04";
$day_d = "12";
*/

//環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_keiyaku.inc"); //契約関数定義

//DB接続
$db_con = Db_Connect();

//本日の日付を取得
$today_y = date("Y");            
$today_m = date("m");
$today_d = date("d");
$to_date = "$today_y-$today_m-$today_d";
$today   = date("Y-m-d H:i:s");

//開始出力
error_log("$today 受注伝票作成開始 \n",3,LOG_FILE);

//エラー変数初期化（ループ処理の前に変数を初期化しても意味ない）
$error_con  = NULL;
$error_time = NULL;
$error_msg  = NULL;
$e_contents = NULL;
$error_flg  = NULL;

/****************************/
//ショップ情報を取得（ショップ単位で伝票を作成する）
/****************************/
$sql  = "SELECT DISTINCT ";
$sql .= "    t_contract.shop_id,";     //ショップID
$sql .= "    t_client.cal_peri_num ";  //カレンダー変更期間
$sql .= "FROM ";
$sql .= "    t_contract ";
$sql .= "    INNER JOIN t_client ON t_contract.shop_id = t_client.client_id ";
//$sql .= "WHERE ";
//$sql .= "    t_contract.shop_id != '93' ";
//$sql .= "    t_client.state = '1' ";
$sql .= "ORDER BY ";
$sql .= "    t_contract.shop_id;";
$shop_result = Db_Query($db_con, $sql); 


while($shop_list = pg_fetch_array($shop_result)){
	Db_Query($db_con, "BEGIN;");
	$error_msg = NULL;   //エラー内容

	//カレンダー表示期間取得
	$cal_array = Cal_range($db_con,$shop_list[0]);
	$start_day = $cal_array[1];   //対象開始期間(開始にも終了の日付を代入)
	$end_day   = $cal_array[1];   //対象終了期間
	$cal_peri  = $cal_array[2];   //カレンダー表示期間


	/****************************/
	//不具合対応の処理(通常は必要ない処理ですが消さないで下さい。)
	/****************************/
	if($update_flg == "t"){
		//対象期間（終了）取得
		$start     = mktime(0, 0, 0, $day_m,$day_d+$cal_array[3],$day_y);
		$start_day = date("Y-m-d",$start);
		echo "伝票を再作成します。 shop_id:".$shop_list[0]. " s_day:".$start_day." e_day:".$end_day."\n";

	}


	/* 2006-11-02 カレンダー表示期間変更時に受注伝票（削除・作成）処理<suzuki> */

	//****************************
	//カレンダー表示期間が減った場合
	//****************************
	if($shop_list[1] < 0 && $shop_list[1] != NULL){

		//■削除期間の巡回日を削除(変則日データ以外)
		$sql  = "DELETE FROM ";
		$sql .= "    t_round ";
		$sql .= "WHERE ";
		$sql .= "    contract_id IN(";
		$sql .= "        SELECT ";
		$sql .= "            contract_id ";
		$sql .= "        FROM ";
		$sql .= "            t_contract ";
		$sql .= "        WHERE ";
		$sql .= "            round_div != '7' ";
		$sql .= "        AND ";
		$sql .= "            shop_id = ".$shop_list[0].") ";
		$sql .= "AND ";
		$sql .= "    round_day >= '$end_day';";
		$del_result = Db_Query($db_con, $sql);
		if($del_result === false){
			$error_con = pg_last_error();
			$error_time = date("Y-m-d H:i");
			$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."行目 削除期間の巡回日削除処理失敗 \nショップID: ".$shop_list[0]." \n";
			$error_msg[1] = "$error_con \n\n";
		}

		//■受注番号が振られていない伝票のみ削除
		$delsql  = "DELETE FROM t_aorder_h WHERE aord_id IN (";
		$delsql .= "SELECT "; 
		$delsql .= "   t_aorder_h.aord_id ";
		$delsql .= "FROM ";
		$delsql .= "    t_aorder_h ";
		$delsql .= "   INNER JOIN t_aorder_d ON t_aorder_d.aord_id = t_aorder_h.aord_id ";
		$delsql .= "   INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id  ";
		$delsql .= "WHERE ";
		$delsql .= "   t_aorder_h.shop_id = ".$shop_list[0];
		$delsql .= " AND ";
		$delsql .= "   t_aorder_d.contract_id IS NOT NULL ";
		$delsql .= "AND ";
		$delsql .= "   t_aorder_h.ord_no IS NULL ";
		$delsql .= "AND ";
		$delsql .= "   t_aorder_h.ord_time >= '$end_day' ";
		$delsql .= ");";

		$result = Db_Query($db_con,$delsql);
		if($result === false){
			//エラー判定
			if($error_msg == NULL){
				//既に異常が発生していなければエラー表示
				$error_con = pg_last_error();
				$error_time = date("Y-m-d H:i");
				$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."行目 削除期間の受注ヘッダ削除処理失敗 \nショップID: ".$shop_list[0]." \n";
				$error_msg[1] = "$error_con \n\n";
			}
		}
	}


	//****************************
	//カレンダー表示期間が増えた場合
	//****************************
	if($shop_list[1] > 0){

		//カレンダー表示期間を取得
		$sql  = "SELECT ";
		$sql .= "    cal_peri ";           //カレンダー表示期間
		$sql .= "FROM ";
		$sql .= "    t_client ";
		$sql .= "WHERE ";
		$sql .= "    client_id = ".$shop_list[0].";";
		$result       = Db_Query($db_con, $sql);
		$cal_peri_num = pg_fetch_result($result,0,0);

		//カレンダー表示日数
		$cal_day = 31 * (($cal_peri_num - $shop_list[1])+1);

		//対象期間（終了）取得
		$start = mktime(0, 0, 0, $today_m,$today_d+$cal_day,$today_y);
		$c_start_day = date("Y-m-d",$start);

		//■作成期間の巡回日を削除(変則日データ以外)
		$sql  = "DELETE FROM ";
		$sql .= "    t_round ";
		$sql .= "WHERE ";
		$sql .= "    contract_id IN(";
		$sql .= "        SELECT ";
		$sql .= "            contract_id ";
		$sql .= "        FROM ";
		$sql .= "            t_contract ";
		$sql .= "        WHERE ";
		$sql .= "            round_div != '7' ";
		$sql .= "        AND ";
		$sql .= "            shop_id = ".$shop_list[0].") ";
		$sql .= "AND ";
		$sql .= "    round_day >= '$c_start_day';";
		$del_result = Db_Query($db_con, $sql);
		if($del_result === false){

			//エラー判定
			if($error_msg == NULL){
				//既に異常が発生していなければエラー表示
				$error_con = pg_last_error();
				$error_time = date("Y-m-d H:i");
				$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."行目 削除期間の巡回日削除処理失敗 \nショップID: ".$shop_list[0]." \n";
				$error_msg[1] = "$error_con \n\n";
			}
		}


		$sql  = "SELECT DISTINCT ";
		$sql .= "    t_contract.client_id ";
		$sql .= "FROM ";
		$sql .= "    t_contract ";
		$sql .= "    INNER JOIN t_client ON t_contract.client_id = t_client.client_id ";
		$sql .= "WHERE ";
		//$sql .= "    t_client.state = '1' ";
		//$sql .= "AND ";
		$sql .= "    t_contract.shop_id = ".$shop_list[0];
		$sql .= " ORDER BY ";
		$sql .= "    t_contract.client_id;";
		$client_result2 = Db_Query($db_con, $sql);


		/****************************/
		//増えた期間の受注データ作成（得意先単位）
		/****************************/
		while($client_list = pg_fetch_array($client_result2)){
			
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
			$sql .= "    state = '1' "; //取引中の契約
/*
			$sql .= "AND ";
			$sql .= "    request_state = '2' ";
*/
			$sql .= "AND ";
			$sql .= "    shop_id = ".$shop_list[0];
			$sql .= " AND ";
			$sql .= "    client_id = ".$client_list[0].";";
			$c_con_result = Db_Query($db_con, $sql); 

			/****************************/
			//カレンダー表示期間の巡回日データ追加(通常伝票・オフライン伝票、変則日データ以外)
			/****************************/
			while($con_list = pg_fetch_array($c_con_result)){

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
				//$date_array = Round_day($db_con,$cycle,$cale_week,$abcd_week,$rday,$week_rday,$stand_day,$round_div,$c_start_day,$end_day,$cal_peri);


				$date_array = Get_Round_Day($db_con,$contract_id,$c_start_day,$end_day);
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
						//エラー判定
						if($error_msg == NULL){
							//既に異常が発生していなければエラー表示
							$error_con = pg_last_error();
							$error_time = date("Y-m-d H:i");
							$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."行目 カレンダー表示期間の巡回日データ追加処理失敗 \n契約ID: $contract_id \n代行区分: 通常・オフライン伝票 \n";
							$error_msg[1] = "$error_con \n\n";
						}
					}
				}
			}

			/****************************/
			//受注データ登録関数＆受払テーブルに登録関数     
			/****************************/
			//通常・オフライン伝票作成
			//$ao_result = Aorder_Query($db_con,$shop_list[0],$client_list[0],$c_start_day,$end_day,NULL,true);
			$ao_result = Regist_Aord_Client($db_con,$shop_list[0],$client_list[0],$c_start_day,$end_day,NULL,true);

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
			//直営の場合は、オンライン伝票作成
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
				$sql .= "    state = '1' "; //取引中の契約
				$sql .= "AND ";
				$sql .= "    shop_id = ".$shop_list[0];
				$sql .= " AND ";
				$sql .= "    client_id = ".$client_list[0].";";
				$trust_result = Db_Query($db_con, $sql); 
				//委託先分作成
				while($trust_list = pg_fetch_array($trust_result)){
					$contract_id  = $trust_list[0];  //契約情報ID
					$round_div    = $trust_list[1];  //巡回区分
					$cycle        = $trust_list[2];  //周期
					$cale_week    = $trust_list[3];  //週名（１〜４）
					$abcd_week    = $trust_list[4];  //週名（ＡＢＣＤ）
					$rday         = $trust_list[5];  //指定日
					$week_rday    = $trust_list[6];  //指定曜日
					$stand_day    = $trust_list[7];  //作業基準日
					$contract_div = $trust_list[8];  //契約区分
					$trust_id     = $trust_list[9];  //受託先ID
					$round_div    = $trust_list[10]; //巡回区分

					//変則日以外なら巡回テーブルに追加
					if($round_div != 7){
						/****************************/
						//巡回日計算処理
						/****************************/
						$date_array = NULL;
						//$date_array = Round_day($db_con,$cycle,$cale_week,$abcd_week,$rday,$week_rday,$stand_day,$round_div,$c_start_day,$end_day,$cal_peri);
						$date_array = Get_Round_Day($db_con,$contract_id,$c_start_day,$end_day);

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
								//エラー判定
								if($error_msg == NULL){
									//既に異常が発生していなければエラー表示
									$error_con = pg_last_error();
									$error_time = date("Y-m-d H:i");
									$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."行目 カレンダー表示期間の巡回日データ追加処理失敗 \n契約ID: $contract_id \n代行区分: オンライン伝票 \n";
									$error_msg[1] = "$error_con \n\n";
								}
							}
						}
					}

					/****************************/
					//受注データ登録関数＆受払テーブルに登録関数     
					/****************************/
					//オンライン伝票作成
					//$ao_result = Aorder_Query($db_con,$shop_list[0],$client_list[0],$c_start_day,$end_day,$trust_id,true);
					$ao_result = Regist_Aord_Client($db_con,$shop_list[0],$client_list[0],$c_start_day,$end_day,$trust_id,true);
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
	}

	//カレンダー表示期間変更判定
	if($shop_list[1] != NULL){
		$sql = "UPDATE t_client SET cal_peri_num = NULL WHERE client_id = ".$shop_list[0].";";
		$result = Db_Query($db_con,$sql);
		if($result === false){
			//エラー判定
			if($error_msg == NULL){
				//既に異常が発生していなければエラー表示
				$error_con = pg_last_error();
				$error_time = date("Y-m-d H:i");
				$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."行目 カレンダー表示期間変更数初期化処理失敗 \nショップID: ".$shop_list[0]." \n";
				$error_msg[1] = "$error_con \n\n";
			}
		}
	}

	/****************************/
	//得意先ごとに受注データ作成
	/****************************/
	$sql  = "SELECT DISTINCT ";
	$sql .= "    t_contract.client_id ";
	$sql .= "FROM ";
	$sql .= "    t_contract ";
	$sql .= "    INNER JOIN t_client ON t_contract.client_id = t_client.client_id ";
	$sql .= "WHERE ";
	//$sql .= "    t_client.state = '1' ";
	//$sql .= "AND ";
	$sql .= "    t_contract.shop_id = ".$shop_list[0];
	$sql .= " ORDER BY ";
	$sql .= "    t_contract.client_id;";
	$client_result = Db_Query($db_con, $sql); 
	while($client_list = pg_fetch_array($client_result)){
		
		/****************************/
		//本日より前の日付の巡回日データ削除(変則日データ以外)
		/****************************/
		$sql  = "DELETE FROM ";
		$sql .= "    t_round ";
		$sql .= "WHERE ";
		$sql .= "    contract_id IN(";
		$sql .= "        SELECT ";
		$sql .= "            contract_id ";
		$sql .= "        FROM ";
		$sql .= "            t_contract ";
		$sql .= "        WHERE ";
		$sql .= "            round_div != '7' ";
		$sql .= "        AND ";
		$sql .= "            client_id = ".$client_list[0].") ";
		$sql .= "AND ";
		$sql .= "    round_day < '$to_date';";
		$del_result = Db_Query($db_con, $sql);
		if($del_result === false){
			//エラー判定
			if($error_msg == NULL){
				//既に異常が発生していなければエラー表示
				$error_con = pg_last_error();
				$error_time = date("Y-m-d H:i");
				$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."行目 本日より前の日付の巡回日削除処理失敗 \n得意先ID: ".$client_list[0]." \n";
				$error_msg[1] = "$error_con \n\n";
			}
		}

		/****************************/
		//対象期間(終了)の巡回日データ削除(変則日データ以外)
		/****************************/
		$sql  = "DELETE FROM ";
		$sql .= "    t_round ";
		$sql .= "WHERE ";
		$sql .= "    contract_id IN(";
		$sql .= "        SELECT ";
		$sql .= "            contract_id ";
		$sql .= "        FROM ";
		$sql .= "            t_contract ";
		$sql .= "        WHERE ";
		$sql .= "            round_div != '7' ";
		$sql .= "        AND ";
		$sql .= "            client_id = ".$client_list[0].") ";
		$sql .= "AND ";
		if($update_flg == "t"){
			$sql .= "    round_day >= '$start_day';";
		}else{
			$sql .= "    round_day = '$end_day';";
		}
		$del_result = Db_Query($db_con, $sql);
		if($del_result === false){
			//エラー判定
			if($error_msg == NULL){
				//既に異常が発生していなければエラー表示
				$error_con = pg_last_error();
				$error_time = date("Y-m-d H:i");
				$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."行目 対象期間(終了)の巡回日削除処理失敗 \n得意先ID: ".$client_list[0]." \n";
				$error_msg[1] = "$error_con \n\n";
			}
		}

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
		$sql .= "    state = '1' "; //取引中の契約

/*
		$sql .= "AND ";
		$sql .= "    request_state = '2' ";
*/
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
			//$date_array = Round_day($db_con,$cycle,$cale_week,$abcd_week,$rday,$week_rday,$stand_day,$round_div,$start_day,$end_day,$cal_peri);
			$date_array = Get_Round_Day($db_con,$contract_id,$start_day,$end_day);

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
					//エラー判定
					if($error_msg == NULL){
						//既に異常が発生していなければエラー表示
						$error_con = pg_last_error();
						$error_time = date("Y-m-d H:i");
						$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."行目 巡回日テーブル登録処理失敗 \n契約ID: $contract_id \n代行区分: 通常・オフライン伝票 \n";
						$error_msg[1] = "$error_con \n\n";
					}
				}
			}
		}
		/****************************/
		//受注データ登録関数＆受払テーブルに登録関数     
		/****************************/
		//通常・オフライン伝票作成
		//$ao_result = Aorder_Query($db_con,$shop_list[0],$client_list[0],$start_day,$end_day,NULL,true);
		$ao_result = Regist_Aord_Client($db_con,$shop_list[0],$client_list[0],$start_day,$end_day,NULL,true);
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
			$sql .= "    state = '1' "; //取引中の契約
/*
			$sql .= "AND ";
			$sql .= "    request_state = '2' ";
*/
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
					//$date_array = Round_day($db_con,$cycle,$cale_week,$abcd_week,$rday,$week_rday,$stand_day,$round_div,$start_day,$end_day,$cal_peri);
					$date_array = Get_Round_Day($db_con,$contract_id,$start_day,$end_day);

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
							//エラー判定
							if($error_msg == NULL){
								//既に異常が発生していなければエラー表示
								$error_con = pg_last_error();
								$error_time = date("Y-m-d H:i");
								$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."行目 巡回日テーブル登録処理失敗 \n契約ID: $contract_id \n代行区分: オンライン伝票 \n";
								$error_msg[1] = "$error_con \n\n";
							}
						}
					}
				}
		
				/****************************/
				//受注データ登録関数＆受払テーブルに登録関数     
				/****************************/
				//オンライン伝票作成
				//$ao_result = Aorder_Query($db_con,$shop_list[0],$client_list[0],$start_day,$end_day,$trust_id,true);
				$ao_result = Regist_Aord_Client($db_con,$shop_list[0],$client_list[0],$start_day,$end_day,$trust_id,true);
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

	//処理が正常の場合
	if($error_msg == NULL){
		Db_Query($db_con, "COMMIT;");

	//処理が異常の場合
	}else{
		Db_Query($db_con, "ROLLBACK");
		$error_flg = true;  //異常発生フラグ

		//FILEにエラー出力
		for($i=0;$i<count($error_msg);$i++){
			error_log($error_msg[$i],3,LOG_FILE);
			$e_contents .= $error_msg[$i];
		}

	}
}

//処理が正常に終了した場合
if($error_flg == false){
	$today = date("Y-m-d H:i:s");
	//FILEに出力
	error_log("$today 受注伝票作成完了 \n\n",3,LOG_FILE);

//処理に異常があった場合
}else{
	//メールでエラー通知
	Error_send_mail($g_error_mail,$g_error_add,"受注伝票作成処理で異常発生",$e_contents);
}

//コマンドラインで伝票を再作成した場合
if($update_flg == "t"){
	echo "■伝票を再作成した場合は、必ずupdate_flgを元に戻して下さい";
}

?>
