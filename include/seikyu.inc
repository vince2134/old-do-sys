<?php

define (BILL_AMOUNT_LAST,           "前回御請求残高");
define (PAYIN_AMOUNT,               "当月御入金額");
define (REST_AMOUNT,                "繰越残高額");
define (SALE_AMOUNT,                "当月御買上額");
define (TAX_AMOUNT,                 "消費税額");
define (INTAX_AMOUNT,               "税込御買上額");
define (INSTALLMENT_AMOUNT_THIS,    "今回分割請求額");
define (INSTALLMENT_REST_AMOUNT,    "分割残高");
define (TUNE_AMOUNT,                "調整額");
define (ADBANCE_BALANCE,            "前受金残高");
define (BILL_AMOUNT_THIS,           "当月御請求残高");
define (PAYMENT_THIS,               "今回の御支払額");

/**
 * 概要 請求書を確定する
 *
 * 説明 
 *
 * @param object    $db_con  DBコネクション
 * @param array     $bill_id 請求ヘッダID
 *
 */
function Fix_Bill($db_con, $bill_id){

	//請求ヘッダIDをチェック
	if( !is_array($bill_id) ) {
		return;
	}
	
	Db_Query($db_con, "BEGIN;");

	while ($fix_id = each($bill_id)) {
		//請求IDがfの場合は処理しない
		if ($fix_id[1] != "f") {

    $sql  = "UPDATE";
    $sql .= "   t_bill \n";
    $sql .= "SET\n";
    $sql .= "   fix_flg = 't',\n";
    $sql .= "   fix_staff_name = '".addslashes($_SESSION[staff_name])."',\n";
    $sql .= "   fix_day = NOW() \n";
    $sql .= "WHERE\n";
    $sql .= "   bill_id = ".$fix_id[1]."\n";
    $sql .= " AND\n";
    $sql .= "   shop_id = ".$_SESSION[client_id]."\n";
    $sql .= ";\n";

		$result = Db_Query($db_con, $sql);
		}
	}

	if ($result === false) {
			Db_Query($db_con, "ROLLBACK;");
			exit;
	}
	Db_Query($db_con, "COMMIT;");

}

/**
 * 概要 請求書を更新する
 *
 * 説明 
 *
 * @param object    $db_con  DBコネクション
 * @param array     $bill_id 請求ヘッダID
 *
 */
function Renew_Bill($db_con, $bill_id){

	$shop_id = $_SESSION[client_id];
	$staff_name = addslashes($_SESSION[staff_name]);

	//請求ヘッダIDをチェック
	if( !is_array($bill_id) ) {
		return;
	}

	//請求書IDをカンマ区切りに変換する
	foreach($bill_id AS $key => $var){

		//請求IDがfの場合は結合しない
		if($var != "f"){
			//2回目以降はカンマで結合
			if(isset($bill_id_list)){
				$bill_id_list .= ",";
			}
			$bill_id_list .= $var;
		}
	}

	//更新するIDが無ければ処理終了
	if(isset($bill_id_list)){
		Db_Query($db_con, "BEGIN;");
	
		/****************************/
		//請求更新の対象となる請求先の情報を抽出
		/****************************/
		$sql  = "SELECT\n";
		$sql .= "   claim_id, \n";
		$sql .= "   bill_id, \n";
		$sql .= "   close_day \n";
		$sql .= "FROM\n";
		$sql .= "   t_bill \n";
		$sql .= "WHERE\n";
		$sql .= "   shop_id = $shop_id \n";
		$sql .= "   AND\n";
		$sql .= "   bill_id IN ($bill_id_list) \n";
		//$sql .= "   close_day = '$claim_day'\n";
		$sql .= "   AND\n";
		$sql .= "   fix_flg = 't'\n";
		$sql .= "   AND\n";
		$sql .= "   last_update_flg = 'f' \n";
		$sql .= ";\n";
	
		$result = Db_Query($db_con, $sql);
		$target_count = @pg_num_rows($result);
		$bill_data	 = pg_fetch_all($result);	   //請求先ID

	}
	
	//更新対象があれば処理を実施
	if($target_count > "0"){

		/****************************/
		//請求データのチェック
		/****************************/
		/*
		$sql  = "SELECT\n";
		$sql .= "   COUNT(claim_id) \n";
		$sql .= "FROM\n";
		$sql .= "   t_bill\n";
		$sql .= "WHERE\n";
		$sql .= "   shop_id = $shop_id\n";
		$sql .= "   AND\n";
		$sql .= "   close_day = '$claim_day'\n";
		$sql .= "   AND\n";
		$sql .= "   fix_flg = 'f'\n";
		$sql .= "   AND\n";
		$sql .= "   last_update_flg = 'f' \n";
		$sql .= ";\n";

		$result = Db_Query($db_con, $sql);
		$unconf_count = pg_fetch_result($result,0 ,0);

		//更新対象となる請求データで未確定のデータがある場合には全ての処理終了後、メッセージを表示
		if($unconf_count > 0){
			$unconf_warning = "未確定のデータがありました。";
		}
		*/


		/*****************************/
		//請求更新フラグを「t」に更新する（請求更新の対象となる複数レコード更新）	  
		/*****************************/
		$sql  = "UPDATE\n";
		$sql .= "   t_bill \n";
		$sql .= "SET\n";
		$sql .= "   last_update_flg = 't',\n";
        $sql .= "   fix_staff_name = '".addslashes($_SESSION[staff_name])."',\n";
		$sql .= "   last_update_day = CURRENT_TIMESTAMP \n";
		$sql .= "WHERE\n";
		$sql .= "   shop_id = $shop_id\n";
		$sql .= "   AND\n";
		$sql .= "   bill_id IN ($bill_id_list) \n";
		//$sql .= "   close_day = '$claim_day'\n";
		$sql .= "   AND\n";
		$sql .= "   fix_flg = 't' \n";
		$sql .= "   AND\n";
		$sql .= "   last_update_flg = 'f' \n";
		$sql .= ";\n";

		$result = Db_Query($db_con, $sql);
		if($result === false){
			Db_Query($db_con, "ROLLBACK;");
			exit;
		}

		/******************************/
		//請求更新履歴を登録
		/******************************/
		foreach($bill_data AS $key => $var){

			//履歴更新テーブルの登録
			$sql  = "INSERT INTO t_sys_renew( \n";
			$sql .= "   renew_id,\n";
			$sql .= "   renew_div,\n";
			$sql .= "   renew_time,\n";
			$sql .= "   operation_staff_name,\n";
			$sql .= "   close_day,\n";
			$sql .= "   claim_id,\n";
			$sql .= "   shop_id\n";
			$sql .= ")VALUES(\n";
			$sql .= "   (SELECT COALESCE(MAX(renew_id), 0)+1 FROM t_sys_renew),\n";
			$sql .= "   '3',\n";
			$sql .= "   CURRENT_TIMESTAMP,\n";
			$sql .= "   '$staff_name',\n";
			$sql .= "   '".$var[close_day]."',\n";
			$sql .= "   ".$var[claim_id].",\n";
			$sql .= "   $shop_id\n";
			$sql .= ");\n";

			$result = Db_Query($db_con, $sql);
			if($result === false){
				Db_Query($db_con, "ROLLBACK;");
				exit;
			}

			//請求更新履歴テーブルに登録
			$sql  = "INSERT INTO t_bill_renew( \n";
			$sql .= "   bill_renew_id,\n";
			$sql .= "   close_day,\n";
			$sql .= "   shop_id,\n";
			$sql .= "   claim_id, \n";
			$sql .= "   bill_id \n";
			$sql .= ")VALUES(\n";
			$sql .= "   (SELECT COALESCE(MAX(bill_renew_id), 0)+1 FROM t_bill_renew),\n";
			$sql .= "   '".$var[close_day]."',\n";
			$sql .= "   $shop_id,\n";
			$sql .= "   ".$var[claim_id].",\n";
			$sql .= "   ".$var[bill_id]."\n";
			$sql .= ");\n";

			$result = Db_Query($db_con, $sql);
			if($result === false){
				Db_Query($db_con, "ROLLBACK;");
				exit;
			}
		}

		//更新完了フラグ
		$update_message = "更新しました。";
	}
	Db_Query($db_con, "COMMIT;");

}


/**
 * 概要　請求書を削除する
 *
 * 説明 
 *
 * @param object    $db_con  DBコネクション
 * @param integer   $bill_id 請求ヘッダID
 *
 */
function Delete_Bill($db_con, $bill_id){

		//請求IDがfの場合は処理しない
	if ($bill_id != "f") {

		Db_Query($db_con, "BEGIN;");

        //日次更新の解除
        $result = Cancel_Bill_Target_Renew ($db_con, $bill_id);
        if($result === false){
            return false;
        }

        //削除対象となる請求書に上がっている金額のもととなった回収データの
        //回収データIDをnullでアップデート
        $sql  = "UPDATE";
        $sql .= "   t_bill_d ";
        $sql .= "SET ";
        $sql .= "   collect_bill_d_id = NULL "; 
        $sql .= "WHERE ";
        $sql .= "   collect_bill_d_id IN (";
        $sql .= "                   SELECT ";
        $sql .= "                       bill_d_id ";
        $sql .= "                   FROM ";
        $sql .= "                       t_bill_d ";
        $sql .= "                   WHERE ";
        $sql .= "                       bill_id = $bill_id ";
        $sql .= "                   ) ";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }
    
		$sql ="
			DELETE 
                FROM t_bill 
			WHERE 
                bill_id = '$bill_id'
			    AND 
                shop_id = $_SESSION[client_id]
			    AND
                close_day > (SELECT 
                                COALESCE(MAX(close_day), '".START_DAY."') AS renew_close_day
                            FROM
                                t_sys_renew
                            WHERE
                                renew_div = '2'
                                AND
                                shop_id = $_SESSION[client_id]) 
                AND
                last_update_flg = 'f' ;
		";

		$result = Db_Query($db_con, $sql);
		if ($result === false) {
				Db_Query($db_con, "ROLLBACK;");
				exit;
		}

        $sql  = "UPDATE";
        $sql .= "   t_installment_sales ";
        $sql .= "SET ";
        $sql .= "   bill_id = NULL ";
        $sql .= "WHERE ";
        $sql .= "   bill_id = $bill_id ";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }
		Db_Query($db_con, "COMMIT;");
	}
}



/**
 * 概要 請求書の更新取消を実行する
 *
 * 説明 
 *
 * @param object    $db_con  DBコネクション
 * @param array     $bill_id 請求ヘッダID
 *
 */
function Cancel_Bill($db_con, $bill_id){

	Db_Query($db_con, "BEGIN;");

/*
    //既に請求に対する入金を行なっているかチェック	
    $sql = "
            SELECT 
                t_bill.bill_no, 
                t_payin_h.pay_no 
            FROM 
                t_payin_h 
                    INNER JOIN 
                t_bill 
                ON t_payin_h.bill_id = t_bill.bill_id 
            WHERE 
                t_payin_h.bill_id IN (".str_replace('f', 'null', implode(',',$bill_id)).")
            ;
        ";

    $result = Db_Query($db_con, $sql);
    $data_num = pg_num_rows($result);
    //該当レコードがある場合
    if($data_num > 0){
        $data = pg_fetch_all($result);
        Db_Query($db_con, "ROLLBACK;");
	    return $data;
    }
*/

    //既に請求に対する入金が起こっている場合は、入金ヘッダの請求IDをNULLでアップデート
    $sql = "
            UPDATE 
                t_payin_h 
            SET
                bill_id = null
            WHERE
                t_payin_h.bill_id IN (".str_replace('f', 'null', implode(',',$bill_id)).")
            ;
    ";

    $result = Db_Query($db_con, $sql);
    if(!$result){
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }

	while ($cancel_id = each($bill_id)) {
		//請求IDがfの場合は処理しない
		if ($cancel_id[1] != "f") {
			$sql ="
				UPDATE t_bill SET
					last_update_flg = 'f',
					last_update_day = NULL 
				WHERE  bill_id = '$cancel_id[1]'
				AND shop_id = $_SESSION[client_id]
				AND last_update_flg = 't';
			";
			$result = Db_Query($db_con, $sql);

	        if ($result === false) {
			    Db_Query($db_con, "ROLLBACK;");
			    exit;
	        }

            $sql ="
                DELETE FROM
                    t_bill_renew
                WHERE
                    bill_id = '$cancel_id[1]'
                ;
            ";
            $result = Db_Query($db_con, $sql);

	        if ($result === false) {
			    Db_Query($db_con, "ROLLBACK;");
			    exit;
	        }
		}
	}

	Db_Query($db_con, "COMMIT;");
}

/**
 * ヘッダに表示するボタンを作成
 *
 * 説明 
 *
 * @param object    $page_title  タイトル
 *
 */
function Bill_header($page_title){

    //本部の場合
    if($_SESSION["group_kind"] == '1'){
        $dir = './1-2-';    
    }else{
        $dir = './2-2-';    
    }

    //ヘッダに表示するボタン作成
    $button_array["請求データ作成"] = "<input type=\"button\" value=\"請求データ作成\"    onClick=\"location.href='".$dir."301.php'\">";
//    $button_array["請求照会"]       = "<input type=\"button\" value=\"請求照会\"          onClick=\"location.href='".$dir."306.php'\">";
    $button_array["請求書発行照会"] = "<input type=\"button\" value=\"請求書発行照会\"    onClick=\"location.href='".$dir."302.php'\">";

    //次画面のボタン
    $button_array[$page_title]      = "<input type=\"button\" value=\"".$page_title."\" style=\"background-color:#FDFD88; font-weight:bold;\" onClick=\"location.href='".$_SERVER[PHP_SELF]."'\">";

    $page_title .= "　".$button_array["請求データ作成"];
    $page_title .= "　".$button_array["請求書発行照会"];
//    $page_title .= "　".$button_array["請求照会"];
    $page_header  = Create_Header($page_title);

    return $page_header;
}

//請求取り消し時に日次更新を取消す処理を追加
function Cancel_Bill_Target_Renew($db_con, $bill_id){

    //請求IDを元に各得意先のID、前回締日、今回締日、請求先区分を抽出
    $sql  = "SELECT";
    $sql .= "   client_id, ";
    $sql .= "   claim_div, ";
    $sql .= "   bill_close_day_last, ";
    $sql .= "   bill_close_day_this ";
    $sql .= "FROM ";
    $sql .= "   t_bill_d ";
    $sql .= "WHERE ";
    $sql .= "   bill_id = $bill_id ";
    $sql .= "   AND ";
    $sql .= "   close_day IS NOT NULL ";        //合計請求書のレコードは対象外
    $sql .= ";";

    $result = Db_Query($db_con, $sql);

    $client_bill_data_num = pg_num_rows($result);

    //排他制御
    if($client_bill_data_num == 0){
        Db_Query($db_con, "ROLLBACK;");
        return false;    
    }
    $client_bill_data = pg_fetch_all($result);

    //ショップの最新の月次更新日を抽出
    $sql  = "SELECT ";
    $sql .= "   COALESCE(MAX(close_day), '".START_DAY."') AS close_day ";
    $sql .= "FROM ";
    $sql .= "   t_sys_renew ";
    $sql .= "WHERE ";
    $sql .= "   t_sys_renew.renew_div = '2' ";
    $sql .= "   AND ";
    $sql .= "   t_sys_renew.shop_id = ".$_SESSION["client_id"]."";
    $sql .= ";";

    $result    = Db_Query($db_con, $sql);
    $close_day = pg_fetch_result($result, 0,0);

    foreach($client_bill_data AS $key => $client_data){

        //日次更新解除の対象となる日付
        if($close_day  >= $client_data["bill_close_day_last"]){
            $target_day = $close_day;
        }else{
            $target_day = $client_data["bill_close_day_last"];
        }

        //請求期間内の売上の日次更新を解除
        $sql  = "UPDATE \n";
        $sql .= "   t_sale_h \n";
        $sql .= "SET \n";
        $sql .= "   renew_flg = 'f', \n";
        $sql .= "   renew_day = null \n";
        $sql .= "WHERE \n";
        $sql .= "   client_id = ".$client_data["client_id"]." ";
        $sql .= "   AND ";
        $sql .= "   claim_div = '".$client_data["claim_div"]."' ";
        $sql .= "   AND ";
        $sql .= "   claim_day > '".$target_day."' ";
        $sql .= "   AND ";
        $sql .= "   claim_day <= '".$client_data["bill_close_day_this"]."' ";
        $sql .= "   AND ";
        $sql .= "   sale_day > '".$target_day."' ";
        $sql .= "   AND ";
        $sql .= "   trade_id NOT IN ('61','63','64') ";
        $sql .= ";\n";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK;");
            return false;
        }

        //請求期間内の入金の日次更新を解除
        $sql  = "UPDATE";
        $sql .= "   t_payin_h ";
        $sql .= "SET ";
        $sql .= "   renew_flg = 'f', ";
        $sql .= "   renew_day = null ";
        $sql .= "WHERE ";
        $sql .= "   pay_id IN (SELECT ";
        $sql .= "               t_payin_h.pay_id ";
        $sql .= "           FROM ";
        $sql .= "               t_payin_d ";
        $sql .= "                   INNER JOIN ";
        $sql .= "               t_payin_h ";
        $sql .= "               ON t_payin_d.pay_id = t_payin_h.pay_id ";
        $sql .= "           WHERE ";
        $sql .= "               t_payin_h.client_id = ".$client_data["client_id"]." ";
        $sql .= "               AND ";
        $sql .= "               t_payin_h.claim_div = '".$client_data["claim_div"]."' ";
        $sql .= "               AND ";
        $sql .= "               t_payin_h.pay_day > '$target_day' ";
        $sql .= "               AND ";
        $sql .= "               t_payin_h.pay_day <= '".$client_data["bill_close_day_this"]."' ";
        $sql .= "               AND ";
        $sql .= "               t_payin_d.trade_id != '39' ";
        $sql .= "               AND ";
        $sql .= "               t_payin_h.payin_div = '1' ";
        $sql .= "           ) ";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK;");
            return false;
        }
    }
    return true;
}
?>
