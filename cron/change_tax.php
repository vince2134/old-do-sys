<?php

/******************************
 *  変更履歴
 *      ・（2006-11-17）ROLLBACKした後に、エラー内容をログに出力 <suzuki>
 *      ・（2009-01-24）更新後の消費税が正しく計算されていないバグを修正<watanabe-k>
 *
*******************************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2010/01/10                  aoyama-n    消費税率更新処理のみを行うように変更
 */

//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

//開始出力
$today = date("Y-m-d H:i:s");
error_log("$today 消費税改定開始 \n",3,LOG_FILE);

//エラー変数初期化
$error_con  = NULL;
$error_time = NULL;
$error_msg  = NULL;
$e_contents = NULL;
$error_flg  = NULL;

/****************************/
//消費税変更処理
/****************************/

//本日の日付
$today = date("Y-m-d");

//消費税変更の取引先取得
#2010-01-10 aoyama-n
/*******************
$sql  = "SELECT ";
$sql .= "    client_id, ";     //取引先ID
$sql .= "    tax_rate_c, ";    //改訂後消費税
$sql .= "    tax_rate_n, ";    //消費税
$sql .= "    coax, ";          //金額丸め区分
$sql .= "    tax_franct ";     //消費税端数区分
$sql .= "FROM ";
$sql .= "    t_client ";
$sql .= "WHERE ";
$sql .= "    client_div = 3 ";
$sql .= "AND ";
$sql .= "    tax_rate_cday = '$today' ";
$sql .= "AND ";
$sql .= "    tax_rate_c IS NOT NULL;";
*******************/

$sql  = "SELECT ";
$sql .= "    client_id, ";
$sql .= "    tax_rate_now, ";
$sql .= "    tax_rate_new, ";
$sql .= "    tax_change_day_new ";
$sql .= "FROM ";
$sql .= "    t_client ";
$sql .= "WHERE ";
$sql .= "    ( client_div = 3 OR client_div = 0 ) ";
$sql .= "AND ";
$sql .= "    tax_change_day_new = '$today' ";
$sql .= "AND ";
$sql .= "    tax_rate_new IS NOT NULL ";
$sql .= "AND ";
$sql .= "    tax_change_day_new IS NOT NULL;";

$result = Db_Query($db_con, $sql); 
$data_list = Get_Data($result);

#echo "start\n";

for($i=0;$i<count($data_list);$i++){
	Db_Query($db_con, "BEGIN;");

	$error_msg = NULL;  //エラーメッセージ配列

	/****************************/
	//得意先マスタの消費税変更
	/****************************/
    #2010-01-10 aoyama-n
    /*******************
	$sql  = "UPDATE t_client SET ";
	$sql .= "    tax_rate_n = ".$data_list[$i][1].",";
	$sql .= "    tax_rate_c = NULL ";
#改定日は実行ログとして残すようにする
#	$sql .= "    tax_rate_c = NULL,";
#	$sql .= "    tax_rate_cday = NULL ";
	$sql .= "WHERE ";
	$sql .= "    client_id = ".$data_list[$i][0].";";
    *******************/

    $sql  = "UPDATE t_client SET ";
    $sql .= "    tax_rate_old = '".$data_list[$i][1]."',";
    $sql .= "    tax_rate_now = '".$data_list[$i][2]."',";
    $sql .= "    tax_change_day_now = '".$data_list[$i][3]."',";
    $sql .= "    tax_rate_new = NULL, ";
    $sql .= "    tax_change_day_new = NULL ";
    $sql .= "WHERE ";
    $sql .= "    client_id = ".$data_list[$i][0].";";
	$result = Db_Query($db_con, $sql);
	if($result === false){
/*
	    Db_Query($db_con, "ROLLBACK");
	    exit;
*/
		$error_con = pg_last_error();
		$error_time = date("Y-m-d H:i");
		$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."行目 得意先マスタの消費税改定失敗 \n得意先ID: ".$data_list[$i][0]." \n";
		$error_msg[1] = "$error_con \n\n";
	}


	/****************************/
	//得意先情報取得
	/****************************/
    #2010-01-10 aoyama-n
    /*******************
	$sql  = "SELECT ";
	$sql .= "    tax_rate_n ";    //更新後の消費税
	$sql .= "FROM ";
	$sql .= "    t_client ";
	$sql .= "WHERE ";
	$sql .= "    client_id = ".$data_list[$i][0].";";
	$result = Db_Query($db_con, $sql); 
	$tax_list = Get_Data($result);

	$tax_num    = $tax_list[0][0];
	$coax       = $data_list[$i][3];
	$tax_franct = $data_list[$i][4];
    *******************/

	/****************************/
	//受注ヘッダID取得
	/****************************/
    #2010-01-10 aoyama-n
    /*******************
    $sql  = "SELECT ";
	$sql .= "    t_aorder_h.aord_id,";        //受注ID
	$sql .= "    t_aorder_d.aord_d_id,";      //受注データID
	$sql .= "    t_aorder_d.tax_div,";        //課税区分
	$sql .= "    t_aorder_d.sale_amount ";    //売上金額
	$sql .= "FROM ";
	$sql .= "    t_aorder_h ";
	$sql .= "    INNER JOIN t_aorder_d ON t_aorder_d.aord_id = t_aorder_h.aord_id ";
	$sql .= "WHERE ";
	$sql .= "    t_aorder_h.ord_time > NOW() ";
	#手書きの予定データを抽出も行うため、下記条件はコメントアウト
	#$sql .= "AND ";
	#$sql .= "    t_aorder_h.confirm_flg = 'f' ";
	$sql .= "AND ";
	$sql .= "    t_aorder_d.contract_id IS NOT NULL ";
	$sql .= "AND ";
	$sql .= "    t_aorder_h.shop_id = ".$data_list[$i][0].";";

	$result = Db_Query($db_con, $sql);
	$aord_array = Get_Data($result);

	//ヘッダーごとに連想配列を定義
	for($x=0;$x<count($aord_array);$x++){
		//$m_data[受注ID][受注データID][0] = 課税区分
		//$m_data[受注ID][受注データID][1] = 売上金額
		$aord_id = $aord_array[$x][0];    //受注ID
		$aord_d_id = $aord_array[$x][1];  //受注データID

		$m_data[$aord_id][$aord_d_id][0] = $aord_array[$x][2];
		$m_data[$aord_id][$aord_d_id][1] = $aord_array[$x][3];
	}
    *******************/

	/****************************/
	//受注ヘッダの消費税額変更処理
	/****************************/
    #2010-01-10 aoyama-n
    /*******************
	while($aord_num = each($m_data)){
		//受注ヘッダIDの添字取得
		$aord_id = $aord_num[0];
		$c=0;

		#配列の初期化を行うように修正
		$tax_div = null;
		$sale_data = null;
		while($aord_d_num = each($m_data[$aord_id])){
			//受注データIDの添字取得
			$aord_d_id = $aord_d_num[0];
			//ヘッダーに掛かるデータの金額を取得
			$tax_div[$c]   = $m_data[$aord_id][$aord_d_id][0];
			$sale_data[$c] = $m_data[$aord_id][$aord_d_id][1];
			$c++;
		}

		#echo "aord_id\n";
		#echo $aord_id;
		#echo "\n";

		#echo "tax_div\n";
		#Print_Array($tax_div);

		#echo "sale_amount\n";
		#Print_Array($sale_data);

		//売上金額・消費税額の合計処理
		$total_money = Total_Amount($sale_data, $tax_div,$coax,$tax_franct,$tax_num,$data_list[$i][0],$db_con);
		$sale_tax    = $total_money[1];

		#echo "sale_tax\n";
		#echo $sale_tax;
		#echo "\n";


		$sql  = "UPDATE t_aorder_h SET ";
		$sql .= "    tax_amount = $sale_tax ";
		$sql .= "WHERE ";
		$sql .= "    aord_id = $aord_id;";
		
		$result = Db_Query($db_con, $sql);
	    if($result == false){
    *******************/
		/*
	        Db_Query($db_con, "ROLLBACK");
	        exit;
		*/
    #2010-01-10 aoyama-n
    /*******************
			//得意先更新失敗判定
			if($error_msg == NULL){
				//失敗していなかったら受注のエラー出力
				$error_con = pg_last_error();
				$error_time = date("Y-m-d H:i");
				$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."行目 受注ヘッダテーブルの消費税額改定失敗 \n受注ID: $aord_id \nショップID: ".$data_list[$i][0]." \n";
				$error_msg[1] = "$error_con \n\n";
			}
	    }
	}
    *******************/

	//エラー判定
	if($error_msg == NULL){
		//正常

		Db_Query($db_con, "COMMIT;");
	}else{
		//異常

		Db_Query($db_con, "ROLLBACK");
		//FILEにエラー出力
		$estr = NULL;
		for($e=0;$e<count($error_msg);$e++){
			error_log($error_msg[$e],3,LOG_FILE);
			$e_contents .= $error_msg[$e];
		}

		$error_flg = true;  //異常発生フラグ
	}
}

#echo "end\n";

//正常判定
if($error_flg == false){
	//正常

	$today = date("Y-m-d H:i:s");
	//FILEに出力
	error_log("$today 消費税改定完了 \n\n",3,LOG_FILE);
}else{
	//異常

	//メールでエラー通知
	Error_send_mail($g_error_mail,$g_error_add,"消費税改定処理で異常発生",$e_contents);
}

?>
