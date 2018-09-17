<?php

function Get_Claim_Data($db_con){

    // 検索された請求先の情報を抽出
/*
    $sql  = "SELECT \n";
    $sql .= "   DISTINCT \n";
    $sql .= "   t_client.client_id, \n";
    $sql .= "   t_client.client_cname, \n";
    $sql .= "   t_client.pay_name, \n";
    $sql .= "   t_client.account_name \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "   INNER JOIN t_claim ON t_client.client_id = t_claim.claim_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_client.client_cd1 = '".$_POST["form_claim"]["cd1"]."' \n";
    $sql .= "AND \n";
    $sql .= "   t_client.client_cd2 = '".$_POST["form_claim"]["cd2"]."' \n";
    $sql .= "AND \n";
    $sql .= "   t_client.client_div = '1' \n";
//    $sql .= "AND \n";
//    $sql .= "   (t_client.client_gr_id IS NOT NULL OR t_client.parents_flg IS NOT NULL) \n";
    $sql .= "AND \n";
    if ($_SESSION["group_kind"] == "2"){
    $sql .= "   t_client.shop_id IN (".Rank_Sql().") \n";
    }else{  
    $sql .= "   t_client.shop_id = ".$_SESSION["client_id"]." \n";
    }
    $sql .= ";"; 
*/
    $sql  = "SELECT \n";
    $sql .= "   DISTINCT \n";
    $sql .= "   t_client.client_id, \n";
    $sql .= "   t_client.client_cname, \n";
    $sql .= "   t_client.pay_name, \n";
    $sql .= "   t_client.account_name \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "   INNER JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           claim_id \n";
    $sql .= "       FROM \n";
    $sql .= "           t_claim \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           claim_id \n";
    $sql .= "       HAVING \n";
    $sql .= "           COUNT(claim_id) > 1 \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_claim \n";
    $sql .= "   ON t_client.client_id = t_claim.claim_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_client.client_cd1 = '".$_POST["form_claim"]["cd1"]."' \n";
    $sql .= "AND \n";
    $sql .= "   t_client.client_cd2 = '".$_POST["form_claim"]["cd2"]."' \n";
    $sql .= "AND \n";
    $sql .= "   t_client.client_div = '1' \n";
    $sql .= "AND \n";
    if ($_SESSION["group_kind"] == "2"){
    $sql .= "   t_client.shop_id IN (".Rank_Sql().") \n";
    }else{  
    $sql .= "   t_client.shop_id = ".$_SESSION["client_id"]." \n";
    }
    $sql .= ";"; 

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    if ($num > 0){
        return pg_fetch_all($res);
    }else{
        return null;
    }

}


function Get_Payment_Ext($db_con, $claim_id){

    // 該当請求先宛で最新の請求書IDのデータレコードの支払予定額集計期間を取得
    $sql  = "SELECT \n";
    $sql .= "   t_bill_d.payment_extraction_s, \n";
    $sql .= "   t_bill_d.payment_extraction_e, \n";
    $sql .= "   t_bill_d.payment_this \n";
    $sql .= "FROM \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           MAX(bill_id) AS bill_id \n";
    $sql .= "       FROM \n";
    $sql .= "           t_bill \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_bill.claim_id = $claim_id \n";
    $sql .= "       AND \n";
    if ($_SESSION["group_kind"] == "2"){
    $sql .= "           t_bill.shop_id IN (".Rank_Sql().") \n";
    }else{  
    $sql .= "           t_bill.shop_id = ".$_SESSION["client_id"]." \n";
    }       
    $sql .= "   ) \n";
    $sql .= "   AS t_bill_max \n";
    $sql .= "   INNER JOIN t_bill_d ON t_bill_max.bill_id = t_bill_d.bill_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_bill_d.client_id = $claim_id \n";
    $sql .= "   AND t_bill_d.bill_data_div = '0' ";
    $sql .= ";"; 
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    if ($num > 0){
        return pg_fetch_all($res);
    }else{
        return null;
    }

}


function Get_Bill_Data($db_con, $claim_id){

    // 該当請求先宛で最新の請求書データを取得
    $sql  = "SELECT \n";
    $sql .= "   t_bill.bill_id, \n";
    $sql .= "   t_bill.bill_no, \n";
    $sql .= "   t_bill_d.payment_this \n";
    $sql .= "FROM \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           MAX(bill_id) AS bill_id \n";
    $sql .= "       FROM \n";
    $sql .= "           t_bill \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_bill.claim_id = $claim_id \n";
    $sql .= "       AND \n";
    if ($_SESSION["group_kind"] == "2"){
    $sql .= "           t_bill.shop_id IN (".Rank_Sql().") \n";
    }else{  
    $sql .= "           t_bill.shop_id = ".$_SESSION["client_id"]." \n";
    }       
    $sql .= "   ) \n";
    $sql .= "   AS t_bill_max \n";
    $sql .= "   INNER JOIN t_bill_d ON t_bill_max.bill_id = t_bill_d.bill_id \n";
    $sql .= "   INNER JOIN t_bill   ON t_bill_d.bill_id = t_bill.bill_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_bill_d.client_id = $claim_id \n";
    $sql .= "AND \n";
    $sql .= "   t_bill_d.bill_data_div = '0' \n";
    $sql .= ";"; 
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    if ($num > 0){
        return pg_fetch_all($res);
    }else{
        return null;
    }

}


function Illegal_Post_Chk($form, $db_con, $err_set_form, $err_msg){

    // hiddenの請求先IDがある
    if ($_POST["hdn_claim_id"] != null){

        // hiddenに格納されている得意先IDとPOSTされた得意先コードの整合性をチェック
        $sql  = "SELECT \n";
        $sql .= "   client_id \n";
        $sql .= "FROM \n";
        $sql .= "   t_client \n";
        $sql .= "WHERE \n";
        $sql .= "   client_id = ".$_POST["hdn_claim_id"]." \n";
        $sql .= "AND \n";
        $sql .= "   client_cd1 = '".$_POST["form_claim"]["cd1"]."' \n";
        $sql .= "AND \n";
        $sql .= "   client_cd2 = '".$_POST["form_claim"]["cd2"]."' \n";
        $sql .= "AND \n";
        $sql .= "   client_div = '1' \n";
        $sql .= "AND \n";
        if ($_SESSION["group_kind"] == "2"){
            $sql .= "   t_client.shop_id IN (".Rank_Sql().") \n";
        }else{
            $sql .= "   t_client.shop_id = ".$_SESSION["client_id"]." \n";
        }
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        $num  = pg_num_rows($res);

        // 結果を不正POSTフラグに
        $illegal_post_flg = ($num > 0) ? false : true;

    // hiddenの請求先コードがない
    }else{

        $illegal_post_flg = true;

    }

    // 不正POSTフラグtrueの場合はエラーをセット
    if ($illegal_post_flg == true){
        $form->setElementError($err_set_form, $err_msg);
    }

    return $illegal_post_flg;

}


/* 入力された請求番号の種類 */
function Bill_Check($db_con){

    // 請求番号が入力されていない場合
    if ($_POST["form_bill_no"] == null){
        return "bill_null";
    }

    // 入力された請求番号と自動検出した請求番号が同じ場合
    if ($_POST["hdn_bill_id"] != null && strcmp($_POST["hdn_bill_no"], $_POST["form_bill_no"]) == 0){
        return "bill_true";

    // 自動検出した請求番号とは異なる請求番号が入力された場合
    }else{

//        if ($_POST["hdn_bill_id"] != null && $_POST["hdn_bill_no"] != $_POST["form_bill_no"]){

            $sql  = "SELECT \n";
            $sql .= "   t_bill.bill_id \n";
            $sql .= "FROM \n";
            $sql .= "   t_bill \n";
            $sql .= "   INNER JOIN t_bill_d ON t_bill.bill_id = t_bill_d.bill_id \n";
            $sql .= "WHERE \n";
            $sql .= "   t_bill.bill_no = '".$_POST["form_bill_no"]."' \n";
            $sql .= "AND \n";
            $sql .= "   t_bill.claim_id = ".$_POST["hdn_claim_id"]." \n";
            $sql .= "AND \n";
            $sql .= "   t_bill.shop_id = ".$_SESSION["client_id"]." \n";
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $num  = pg_num_rows($res);

            if ($num > 0){
                $bill_id = pg_fetch_result($res,0,0);
                $sql  = "SELECT \n";
                $sql .= "   payment_this \n";
                $sql .= "FROM \n";
                $sql .= "   t_bill_d \n";
                $sql .= "WHERE \n";
                $sql .= "   bill_id = $bill_id \n";
                $sql .= "AND \n";
                $sql .= "   bill_data_div = '0' \n";
                $sql .= ";";
                $res = Db_Query($db_con, $sql);
                $num = pg_num_rows($res);
                if ($num > 0){
                    $bill_found_flg = true;
                    $search_bill_amount = pg_fetch_result($res, 0, 0);
                }
            }
//        }

        // 入力された請求番号が存在する場合
        if ($bill_found_flg == true){
            return "bill_found";
        // 入力された請求番号が存在しない場合
        }else{
            return "bill_false";
        }

    }

}


/* 請求書データ取得 */
function Get_Divide_Data($db_con, $bill_id){

    // 請求書データ取得
    $sql  = "SELECT \n";
    $sql .= "   t_bill_d.client_id, \n";
    $sql .= "   t_bill_d.client_cd1, \n";
    $sql .= "   t_bill_d.client_cd2, \n";
    $sql .= "   t_bill_d.client_cname, \n";
    $sql .= "   t_bill_d.payment_this, \n";
    $sql .= "   t_bill_d.claim_div \n";
    $sql .= "FROM \n";
    $sql .= "   t_bill_d \n";
    $sql .= "   INNER JOIN t_bill ON t_bill_d.bill_id = t_bill.bill_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_bill_d.bill_id = $bill_id \n";
    $sql .= "AND \n";
    $sql .= "   t_bill_d.bill_data_div != '0' \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_bill_d.client_cd1, \n";
    $sql .= "   t_bill_d.client_cd2 \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $ary = pg_fetch_all($res);
    }else{
        $ary = null;
    }
    return $ary;

}


/* 取得した請求書データをフォームにセット */
function Set_Divide_Form($form, $max_row, $get_divide_data){

    // レコード数でループ
    for ($i = 0; $i < $max_row; $i++){

        // 請求データをフォームにセット
        $set_form_data["form_claim_id"][$i]         = $get_divide_data[$i]["client_id"];
        $set_form_data["form_claim_cd"][$i]["cd1"]  = $get_divide_data[$i]["client_cd1"];
        $set_form_data["form_claim_cd"][$i]["cd2"]  = $get_divide_data[$i]["client_cd2"];
        $set_form_data["form_claim_name"][$i]       = $get_divide_data[$i]["client_cname"];
        if ($get_divide_data[$i]["payment_this"] != null){
            $set_form_data["form_base_amount"][$i]  = number_format($get_divide_data[$i]["payment_this"]);
        }else{
            $set_form_data["form_base_amount"][$i]  = $get_divide_data[$i]["payment_this"];
        }
        // 請求額がある場合のみ金額をセット
        if ($get_divide_data[$i]["payment_this"] != null){
            // 請求金額が0の場合は入金額フォームにはnullをセット
            if ($get_divide_data[$i]["payment_this"] == "0"){
                $set_form_data["form_amount"][$i]   = "";
            }else{
                $set_form_data["form_amount"][$i]   = $get_divide_data[$i]["payment_this"];
            }
            $set_form_data["form_rebate"][$i]       = "";
            $set_form_data["form_note"][$i]         = "";
            $set_form_data["hdn_claim_div"][$i]     = $get_divide_data[$i]["claim_div"];
        }else
        // 金額振分ボタン押下時は空をセット
        if ($_POST["divide_flg"] == "true"){
            $set_form_data["form_amount"][$i]       = "";
            $set_form_data["form_rebate"][$i]       = "";
            $set_form_data["form_note"][$i]         = "";
            $set_form_data["hdn_claim_div"][$i]     = $get_divide_data[$i]["claim_div"];
        }

    }

    $form->setConstants($set_form_data);

}


/* 最新＋１の入金番号を取得 */
function Get_New_Payin_No($db_con){

    /*** 最新+1の入金番号を取得 ***/
    $sql  = "SELECT \n";
    $sql .= "   MAX(pay_no) \n";
    $sql .= "FROM \n";
    if ($_SESSION["group_kind"] == "2"){
    $sql .= "   t_payin_no_serial \n";
    }else{
    $sql .= "   t_payin_h \n";
    $sql .= "WHERE \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    }
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    return str_pad(pg_fetch_result($res, 0 ,0)+1, 8, "0", STR_PAD_LEFT);

}


/* 入金ヘッダ登録 */
function Insert_Payin_H($db_con, $payin_no){

    // 日付0埋め
    $_POST["form_payin_day"] = Str_Pad_Date($_POST["form_payin_day"]);
    $_POST["form_limit_day"] = Str_Pad_Date($_POST["form_limit_day"]);

    // POSTデータを変数へ代入
    $payin_day  = $_POST["form_payin_day"]["y"]."-".$_POST["form_payin_day"]["m"]."-".$_POST["form_payin_day"]["d"];
    $limit_day  = $_POST["form_limit_day"]["y"]."-".$_POST["form_limit_day"]["m"]."-".$_POST["form_limit_day"]["d"];

    // INSERT実行
    Db_Query($db_con, "BEGIN;");

    $sql  = "INSERT INTO \n";
    $sql .= "   t_payin_h \n";
    $sql .= "( \n"; 
    $sql .= "   pay_id, \n";
    $sql .= "   pay_no, \n";
    $sql .= "   pay_day, \n";
    $sql .= "   collect_staff_id, \n";
    $sql .= "   collect_staff_name, \n";
    $sql .= "   client_id, \n";
    $sql .= "   client_cd1, \n";
    $sql .= "   client_cd2, \n";
    $sql .= "   client_name, \n";
    $sql .= "   client_name2, \n";
    $sql .= "   client_cname, \n";
    $sql .= "   c_bank_cd, \n";
    $sql .= "   c_bank_name, \n";
    $sql .= "   c_b_bank_cd, \n";
    $sql .= "   c_b_bank_name, \n";
    $sql .= "   c_deposit_kind, \n";
    $sql .= "   c_account_no, \n";
    $sql .= "   claim_div, \n";
    $sql .= "   pay_name, \n";
    $sql .= "   account_name, \n";
    $sql .= "   bill_id, \n";
    $sql .= "   claim_cd1, \n";
    $sql .= "   claim_cd2, \n";
    $sql .= "   claim_cname, \n";
    $sql .= "   input_day, \n";
    $sql .= "   e_staff_id, \n";
    $sql .= "   e_staff_name, \n";
    $sql .= "   ac_staff_id, \n";
    $sql .= "   ac_staff_name, \n";
    $sql .= "   sale_id, \n";
    $sql .= "   renew_flg, \n";
    $sql .= "   renew_day, \n";
    $sql .= "   payin_div, \n";                 //入金区分
    $sql .= "   shop_id \n";
    $sql .= ") \n"; 
    $sql .= "VALUES \n";
    $sql .= "( \n"; 
    $sql .= "   (SELECT COALESCE(MAX(pay_id), 0)+1 FROM t_payin_h), \n";
    $sql .= "   '$payin_no', \n";
    $sql .= "   '$payin_day', \n";
	//-- 20090611 変更	--------------
	if (($_POST["form_collect_staff"]) != null) {
	$sql .= 	$_POST["form_collect_staff"].", \n";	//集金担当者ID
	$sql .= "	(SELECT staff_name FROM t_staff WHERE staff_id = ".$_POST["form_collect_staff"]."), \n";	//集金担当者名
	} 
	else {
    $sql .= "   NULL, \n";
    $sql .= "   NULL, \n";
	}
	//--------------------------------
    $sql .= "   ".$_POST["hdn_claim_id"].", \n";
    $sql .= "   '".$_POST["form_claim"]["cd1"]."', \n";
    $sql .= "   '".$_POST["form_claim"]["cd2"]."', \n";
    $sql .= "   (SELECT client_name FROM t_client WHERE client_id = ".$_POST["hdn_claim_id"]."), \n";
    $sql .= "   (SELECT client_name2 FROM t_client WHERE client_id = ".$_POST["hdn_claim_id"]."), \n";
    $sql .= "   '".$_POST["form_claim"]["name"]."', \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT t_bank.bank_cd FROM t_client \n";
    $sql .= "       LEFT JOIN t_account ON t_client.account_id = t_account.account_id \n";
    $sql .= "       LEFT JOIN t_b_bank ON t_account.b_bank_id = t_b_bank.b_bank_id \n";
    $sql .= "       LEFT JOIN t_bank ON t_b_bank.bank_id = t_bank.bank_id \n";
    $sql .= "       WHERE t_client.client_id = ".$_POST["hdn_claim_id"]." \n";
    $sql .= "   ), \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT t_bank.bank_name FROM t_client \n";
    $sql .= "       LEFT JOIN t_account ON t_client.account_id = t_account.account_id \n";
    $sql .= "       LEFT JOIN t_b_bank ON t_account.b_bank_id = t_b_bank.b_bank_id \n";
    $sql .= "       LEFT JOIN t_bank ON t_b_bank.bank_id = t_bank.bank_id \n";
    $sql .= "       WHERE t_client.client_id = ".$_POST["hdn_claim_id"]." \n";
    $sql .= "   ), \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT t_b_bank.b_bank_cd FROM t_client \n";
    $sql .= "       LEFT JOIN t_account ON t_client.account_id = t_account.account_id \n";
    $sql .= "       LEFT JOIN t_b_bank ON t_account.b_bank_id = t_b_bank.b_bank_id \n";
    $sql .= "       WHERE t_client.client_id = ".$_POST["hdn_claim_id"]." \n";
    $sql .= "   ), \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT t_b_bank.b_bank_name FROM t_client \n";
    $sql .= "       LEFT JOIN t_account ON t_client.account_id = t_account.account_id \n";
    $sql .= "       LEFT JOIN t_b_bank ON t_account.b_bank_id = t_b_bank.b_bank_id \n";
    $sql .= "       WHERE t_client.client_id = ".$_POST["hdn_claim_id"]." \n";
    $sql .= "   ), \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT t_account.deposit_kind FROM t_client \n";
    $sql .= "       LEFT JOIN t_account ON t_client.account_id = t_account.account_id \n";
    $sql .= "       WHERE t_client.client_id = ".$_POST["hdn_claim_id"]." \n";
    $sql .= "   ), \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT t_account.account_no FROM t_client \n";
    $sql .= "       LEFT JOIN t_account ON t_client.account_id = t_account.account_id \n";
    $sql .= "       LEFT JOIN t_b_bank ON t_account.b_bank_id = t_b_bank.b_bank_id \n";
    $sql .= "       WHERE t_client.client_id = ".$_POST["hdn_claim_id"]." \n";
    $sql .= "   ), \n";
    $sql .= "   '1', \n";
    $sql .= "   '".$_POST["form_pay_name"]."', \n";
    $sql .= "   '".$_POST["form_account_name"]."', \n";
    if ($_POST["hdn_bill_id"] != null){
    $sql .= "   ".$_POST["hdn_bill_id"].", \n";
    }else{
    $sql .= "   NULL, \n";
    }
    $sql .= "   '".$_POST["form_claim"]["cd1"]."', \n";
    $sql .= "   '".$_POST["form_claim"]["cd2"]."', \n";
    $sql .= "   '".$_POST["form_claim"]["cname"]."', \n";
    $sql .= "   NOW(), \n";
    $sql .= "   ".$_SESSION["staff_id"].", \n";
    $sql .= "   '".addslashes($_SESSION["staff_name"])."', \n";
    $sql .= "   ".$_SESSION["staff_id"].", \n";
    $sql .= "   '".addslashes($_SESSION["staff_name"])."', \n";
    $sql .= "   NULL, \n";
    $sql .= "   'f', \n";
    $sql .= "   NULL, \n";
    $sql .= "   '2', \n";
    if ($_SESSION["goup_kind"] == "2"){
    $sql .= "   (SELECT cclient_shop FROM t_client_info WHERE client_id = ".$_POST["hdn_claim_id"].") \n";
    }else{
    $sql .= "   ".$_SESSION["client_id"]." \n";
    }
    $sql .= ") \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);

    if ($res === false){
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }

}


function Get_Payin_Id($db_con, $payin_no){

    // POSTデータを変数へ代入
    $claim_id       = $_POST["hdn_claim_id"];

    // 入金ヘッダに登録した入金IDを取得
    $sql  = "SELECT \n";
    $sql .= "   pay_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_payin_h \n";
    $sql .= "WHERE \n";
    $sql .= "   pay_no = '$payin_no' \n";
    $sql .= "AND \n";
    if ($_SESSION["group_kind"] == "2"){
    $sql .= "   shop_id = (SELECT cclient_shop FROM t_client_info WHERE client_id = ".$_POST["hdn_claim_id"].") \n";
    }else{  
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    }
    $sql .= ";"; 
    $res  = Db_Query($db_con, $sql);
    $payin_id = pg_fetch_result($res, 0);

    return $payin_id;

}


/* 入金データ登録 */
function Insert_Payin_D($db_con, $payin_no, $amount_total, $rebate_total, $rebate_flg){

    $_POST["form_limit_day"] = Str_Pad_Date($_POST["form_limit_day"]);
    $limit_day = $_POST["form_limit_day"]["y"]."-".$_POST["form_limit_day"]["m"]."-".$_POST["form_limit_day"]["d"];
    $payin_id   = Get_Payin_Id($db_con, $payin_no);

    // INSERT実行
    $sql  = "INSERT INTO \n";
    $sql .= "   t_payin_d \n";
    $sql .= "( \n";
    $sql .= "   pay_d_id, \n";
    $sql .= "   pay_id, \n";
    $sql .= "   trade_id, \n";
    $sql .= "   amount, \n";
    $sql .= "   bank_cd, \n";
    $sql .= "   bank_name, \n";
    $sql .= "   b_bank_cd, \n";
    $sql .= "   b_bank_name, \n";
    $sql .= "   account_id, \n";
    $sql .= "   deposit_kind, \n";
    $sql .= "   account_no, \n";
    $sql .= "   payable_day, \n";
    $sql .= "   payable_no, \n";
    $sql .= "   note \n";
    $sql .= ") \n";
    $sql .= "VALUES \n";
    $sql .= "( \n";
    $sql .= "   (SELECT COALESCE(MAX(pay_d_id), 0)+1 FROM t_payin_d), \n";
    $sql .= "   $payin_id, \n";
    $sql .= "   ".$_POST["form_trade"].", \n";
    if ($amount_total != null){
    $sql .= "   $amount_total, \n";
    }else{
    $sql .= "   0, \n";
    }
    if ($_POST["form_bank"][0] != null){
    $sql .= "   (SELECT bank_cd   FROM t_bank WHERE bank_id = ".$_POST["form_bank"][0]."), \n";
    $sql .= "   (SELECT bank_name FROM t_bank WHERE bank_id = ".$_POST["form_bank"][0]."), \n";
    }else{
    $sql .= "   NULL, \n";
    $sql .= "   NULL, \n";
    }
    if ($_POST["form_bank"][1] != null){
    $sql .= "   (SELECT b_bank_cd   FROM t_b_bank WHERE b_bank_id = ".$_POST["form_bank"][1]."), \n";
    $sql .= "   (SELECT b_bank_name FROM t_b_bank WHERE b_bank_id = ".$_POST["form_bank"][1]."), \n";
    }else{
    $sql .= "   NULL, \n";
    $sql .= "   NULL, \n";
    }
    if ($_POST["form_bank"][2] != null){
    $sql .= "   ".$_POST["form_bank"][2].", \n";
    $sql .= "   (SELECT deposit_kind FROM t_account WHERE account_id = ".$_POST["form_bank"][2]."), \n";
    $sql .= "   (SELECT account_no   FROM t_account WHERE account_id = ".$_POST["form_bank"][2]."), \n";
    }else{
    $sql .= "   NULL, \n";
    $sql .= "   NULL, \n";
    $sql .= "   NULL, \n";
    }
    if ($limit_day != "--"){
    $sql .= "   '$limit_day', \n";
    }else{
    $sql .= "   NULL, \n";
    }
    if ($_POST["form_bill_paper_no"] != null){
    $sql .= "   '".$_POST["form_bill_paper_no"]."', \n";
    }else{
    $sql .= "   NULL, \n";
    }
    $sql .= "   NULL \n";
    $sql .= ") \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);

    if ($res === false){
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }

    //手数料があった場合
    if ($rebate_flg != null){

        $sql  = "INSERT INTO \n";
        $sql .= "   t_payin_d \n";
        $sql .= "( \n";
        $sql .= "   pay_d_id, \n";
        $sql .= "   pay_id, \n";
        $sql .= "   trade_id, \n";
        $sql .= "   amount, \n";
        $sql .= "   bank_cd, \n";
        $sql .= "   bank_name, \n";
        $sql .= "   b_bank_cd, \n";
        $sql .= "   b_bank_name, \n";
        $sql .= "   account_id, \n";
        $sql .= "   deposit_kind, \n";
        $sql .= "   account_no, \n";
        $sql .= "   payable_day, \n";
        $sql .= "   payable_no, \n";
        $sql .= "   note \n";
        $sql .= ") \n";
        $sql .= "VALUES \n";
        $sql .= "( \n";
        $sql .= "   (SELECT COALESCE(MAX(pay_d_id), 0)+1 FROM t_payin_d), \n";
        $sql .= "   $payin_id, \n";
        $sql .= "   35, \n";
        if ($rebate_total != null){
        $sql .= "   $rebate_total, \n";
        }else{
        $sql .= "   0, \n";
        }
        if ($_POST["form_bank"][0] != null){
        $sql .= "   (SELECT bank_cd   FROM t_bank WHERE bank_id = ".$_POST["form_bank"][0]."), \n";
        $sql .= "   (SELECT bank_name FROM t_bank WHERE bank_id = ".$_POST["form_bank"][0]."), \n";
        }else{
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        }
        if ($_POST["form_bank"][1] != null){
        $sql .= "   (SELECT b_bank_cd   FROM t_b_bank WHERE b_bank_id = ".$_POST["form_bank"][1]."), \n";
        $sql .= "   (SELECT b_bank_name FROM t_b_bank WHERE b_bank_id = ".$_POST["form_bank"][1]."), \n";
        }else{
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        }
        if ($_POST["form_bank"][2] != null){
        $sql .= "   ".$_POST["form_bank"][2].", \n";
        $sql .= "   (SELECT deposit_kind FROM t_account WHERE account_id = ".$_POST["form_bank"][2]."), \n";
        $sql .= "   (SELECT account_no   FROM t_account WHERE account_id = ".$_POST["form_bank"][2]."), \n";
        }else{
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        }
        $sql .= "   NULL, ";
        $sql .= "   NULL, ";
        $sql .= "   NULL ";
        $sql .= ") ";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);

        if ($res === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

    }

}


/* 入金番号テーブル登録 */
function Insert_Serial($db_con, $payin_no){

    // 直営の場合のみ
    if ($_SESSION["group_kind"] == "2"){
        $sql  = "INSERT INTO \n";
        $sql .= "   t_payin_no_serial \n";
        $sql .= "( \n";
        $sql .= "   pay_no \n";
        $sql .= ") \n";
        $sql .= "VALUES \n";
        $sql .= "( \n";
        $sql .= "   '$payin_no' \n";
        $sql .= ") \n";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);

        if ($res === false){ 
            Db_Query($db_con, "ROLLBACK;");
            exit;   
        }       
    } 

}


function Insert_Allocate($db_con, $max_row, $payin_no){

    // 得意先分繰り返す
    for ($i = 0; $i < $max_row; $i++){

        // 手数料が入力されているか
        if ($_POST["form_rebate"][$i] != null){
            //入力がある場合は2回繰り返すように設定
            $rebate_cnt = 2;
        }else{
            $rebate_cnt = 1;
        }

        $amount     = str_replace(",", "", $_POST["form_amount"][$i]);
        $rebate     = str_replace(",", "", $_POST["form_rebate"][$i]);
        $payin_id   = Get_Payin_Id($db_con, $payin_no);

        // 手数料がある場合２回繰り返す
        for ($j = 0; $j < $rebate_cnt; $j++){

            // 振分入金データテーブルへインサート実行
            $sql  = "INSERT INTO \n";
            $sql .= "   t_payallocation_d \n";
            $sql .= "( \n";
            $sql .= "   payallocation_id, \n";
            $sql .= "   pay_id, \n";
            $sql .= "   client_id, \n";
            $sql .= "   client_cd1, \n";
            $sql .= "   client_cd2, \n";
            $sql .= "   client_cname, \n";
            $sql .= "   claim_div, \n";
            $sql .= "   trade_id, \n";
            $sql .= "   amount, \n";
            $sql .= "   note \n";
            $sql .= ") \n";
            $sql .= "VALUES \n";
            $sql .= "( \n";
            $sql .= "   (SELECT COALESCE(MAX(payallocation_id), 0)+1 FROM t_payallocation_d), \n";
            $sql .= "   $payin_id, \n";
            $sql .= "   ".$_POST["form_claim_id"][$i].", \n";
            $sql .= "   (SELECT client_cd1   FROM t_client WHERE client_id = ".$_POST["form_claim_id"][$i]."), \n";
            $sql .= "   (SELECT client_cd2   FROM t_client WHERE client_id = ".$_POST["form_claim_id"][$i]."), \n";
            $sql .= "   (SELECT client_cname FROM t_client WHERE client_id = ".$_POST["form_claim_id"][$i]."), \n";
            if ($_POST["hdn_bill_id"] == null){
            $sql .= "   (SELECT claim_div    FROM t_claim  WHERE client_id = ".$_POST["form_claim_id"][$i]." \n";
            $sql .= "                                        AND claim_id  = ".$_POST["hdn_claim_id"]."), \n";
            }else{
            $sql .= "   ( \n";
            $sql .= "       SELECT \n";
            $sql .= "           t_bill_d.claim_div \n";
            $sql .= "       FROM \n";
            $sql .= "           t_bill \n";
            $sql .= "           INNER JOIN t_bill_d ON  t_bill.bill_id = t_bill_d.bill_id \n";
            $sql .= "                               AND t_bill.bill_id = ".$_POST["hdn_bill_id"]." \n";
            $sql .= "                               AND t_bill_d.client_id = ".$_POST["form_claim_id"][$i]." \n";
            $sql .= "                               AND t_bill_d.bill_data_div != '0' \n";
            $sql .= "   ), \n";
            }
            if ($j == 0){
            $sql .= "   ".$_POST["form_trade"].", \n";
            $sql .= ($amount != null) ? "   $amount, \n" : "   NULL, \n";
            $sql .= "   '".$_POST["form_note"][$i]."' \n";
            }else{
            $sql .= "   35, \n";
            $sql .= ($rebate != null) ? "   $rebate, \n" : "   NULL, \n";
            $sql .= "   NULL \n";
            }
            $sql .= ") ";
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);

            if ($res === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

        }

    }

}


function Update_Payin_H($db_con){

    $_POST["form_payin_day"] = Str_Pad_Date($_POST["form_payin_day"]);

    $payin_day = $_POST["form_payin_day"]["y"]."-".$_POST["form_payin_day"]["m"]."-".$_POST["form_payin_day"]["d"];

    //ヘッダ更新
    $sql = "UPDATE \n";
    $sql .= "   t_payin_h \n";
    $sql .= "SET \n";
    $sql .= "   client_id       = ".$_POST["hdn_claim_id"].", \n";
    $sql .= "   client_cd1      = '".$_POST["form_claim"]["cd1"]."', \n";
    $sql .= "   client_cd2      = '".$_POST["form_claim"]["cd2"]."', \n";
    if ($payin_day != "--"){
    $sql .= "   pay_day         = '$payin_day', \n";
    }else{
    $sql .= "   pay_day         = '', \n";
    }
    $sql .= "   client_cname    = '".$_POST["form_claim"]["name"]."', \n";
    if ($_POST["hdn_bill_id"] != null){
    $sql .= "   bill_id         = ".$_POST["hdn_bill_id"].", \n";
    }else{
    $sql .= "   bill_id         = NULL, \n";
    }
    $sql .= "   claim_cd1       = '".$_POST["form_claim"]["cd1"]."', \n";
    $sql .= "   claim_cd2       = '".$_POST["form_claim"]["cd2"]."', \n";
    $sql .= "   claim_cname     = '".$_POST["form_claim"]["name"]."', \n";
    $sql .= "   input_day       = NOW(), \n";
    $sql .= "   e_staff_id      = ".$_SESSION["staff_id"].", \n";
    $sql .= "   e_staff_name    = '".addslashes($_SESSION["staff_name"])."', \n";
    $sql .= "   ac_staff_id     = ".$_SESSION["staff_id"].", \n";
    $sql .= "   ac_staff_name   = '".addslashes($_SESSION["staff_name"])."', \n";
    if ($_SESSION["group_kind"] == "2"){
    $sql .= "   shop_id         = (SELECT cclient_shop FROM t_client_info WHERE client_id = ".$_POST["hdn_claim_id"]."), \n";
    }else{
    $sql .= "   shop_id         = ".$_SESSION["client_id"].", \n";
    }
	//-- 20090611 追加 ------------
	if ($_POST["form_collect_staff"] != null) {
	$sql .= "	collect_staff_id = ".$_POST["form_collect_staff"].", \n";	//集金担当者ID
	$sql .= "	collect_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = ".$_POST["form_collect_staff"]."), \n"; //集金担当者名
	}else{
	$sql .= "	collect_staff_id 	= NULL, \n";
	$sql .= "	collect_staff_name 	= NULL, \n";
	}
	//-----------------------------
    $sql .= "   client_name     = (SELECT client_name  FROM t_client WHERE client_id = ".$_POST["hdn_claim_id"]."), \n";
    $sql .= "   client_name2    = (SELECT client_name2 FROM t_client WHERE client_id = ".$_POST["hdn_claim_id"]."), \n";
    $sql .= "   pay_name        = '".$_POST["form_pay_name"]."', \n";
    $sql .= "   account_name    = '".$_POST["form_account_name"]."', \n";
    $sql .= "   c_bank_cd       = \n";
    $sql .= "       ( \n";
    $sql .= "           SELECT t_bank.bank_cd \n";
    $sql .= "           FROM t_client \n";
    $sql .= "           LEFT JOIN t_account ON t_client.account_id = t_account.account_id \n";
    $sql .= "           LEFT JOIN t_b_bank  ON t_account.b_bank_id = t_b_bank.b_bank_id \n";
    $sql .= "           LEFT JOIN t_bank    ON t_b_bank.bank_id = t_bank.bank_id \n";
    $sql .= "           WHERE t_client.client_id = ".$_POST["hdn_claim_id"]." \n";
    $sql .= "       ), \n";
    $sql .= "   c_bank_name     = \n";
    $sql .= "       ( \n";
    $sql .= "           SELECT t_bank.bank_name \n";
    $sql .= "           FROM t_client \n";
    $sql .= "           LEFT JOIN t_account ON t_client.account_id = t_account.account_id \n";
    $sql .= "           LEFT JOIN t_b_bank  ON t_account.b_bank_id = t_b_bank.b_bank_id \n";
    $sql .= "           LEFT JOIN t_bank    ON t_b_bank.bank_id = t_bank.bank_id \n";
    $sql .= "           WHERE t_client.client_id = ".$_POST["hdn_claim_id"]." \n";
    $sql .= "       ), \n";
    $sql .= "   c_b_bank_cd     = \n";
    $sql .= "       ( \n";
    $sql .= "           SELECT t_b_bank.b_bank_cd \n";
    $sql .= "           FROM t_client \n";
    $sql .= "           LEFT JOIN t_account ON t_client.account_id = t_account.account_id \n";
    $sql .= "           LEFT JOIN t_b_bank  ON t_account.b_bank_id = t_b_bank.b_bank_id \n";
    $sql .= "           WHERE t_client.client_id = ".$_POST["hdn_claim_id"]." \n";
    $sql .= "       ), \n";
    $sql .= "   c_b_bank_name   = \n";
    $sql .= "       ( \n";
    $sql .= "           SELECT t_b_bank.b_bank_name \n";
    $sql .= "           FROM t_client \n";
    $sql .= "           LEFT JOIN t_account ON t_client.account_id = t_account.account_id \n";
    $sql .= "           LEFT JOIN t_b_bank  ON t_account.b_bank_id = t_b_bank.b_bank_id \n";
    $sql .= "           WHERE t_client.client_id = ".$_POST["hdn_claim_id"]." \n";
    $sql .= "       ), \n";
    $sql .= "   c_deposit_kind  = \n";
    $sql .= "       ( \n";
    $sql .= "           SELECT t_account.deposit_kind \n";
    $sql .= "           FROM t_client \n";
    $sql .= "           LEFT JOIN t_account ON t_client.account_id = t_account.account_id \n";
    $sql .= "           WHERE t_client.client_id = ".$_POST["hdn_claim_id"]." \n";
    $sql .= "       ), \n";
    $sql .= "   c_account_no    = \n";
    $sql .= "       ( \n";
    $sql .= "           SELECT t_account.account_no \n";
    $sql .= "           FROM t_client \n";
    $sql .= "           LEFT JOIN t_account ON t_client.account_id = t_account.account_id \n";
    $sql .= "           WHERE t_client.client_id = ".$_POST["hdn_claim_id"]." \n";
    $sql .= "       ) \n";
    $sql .= "WHERE \n";
    $sql .= "   pay_id = ".$_POST["hdn_payin_id"]." \n";
    $sql .= ";";
    $res  = Db_Query($db_con,$sql);

    if ($res === false){
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }

}


function Update_Payin_D($db_con, $amount_total, $rebate_total, $rebate_flg){

    $_POST["form_limit_day"] = Str_Pad_Date($_POST["form_limit_day"]);
    $limit_day = $_POST["form_limit_day"]["y"]."-".$_POST["form_limit_day"]["m"]."-".$_POST["form_limit_day"]["d"];

    // 入金データ削除
    $sql  = "DELETE FROM \n";
    $sql .= "   t_payin_d \n";
    $sql .= "WHERE \n";
    $sql .= "   pay_id = ".$_POST["hdn_payin_id"]." \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);

    if ($res === false){
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }

    // 入金データ登録
    $sql  = "INSERT INTO \n";
    $sql .= "   t_payin_d \n";
    $sql .= "( \n";
    $sql .= "   pay_d_id, \n";
    $sql .= "   pay_id, \n";
    $sql .= "   trade_id, \n";
    $sql .= "   amount, \n";
    $sql .= "   bank_cd, \n";
    $sql .= "   bank_name, \n";
    $sql .= "   b_bank_cd, \n";
    $sql .= "   b_bank_name, \n";
    $sql .= "   account_id, \n";
    $sql .= "   deposit_kind, \n";
    $sql .= "   account_no, \n";
    $sql .= "   payable_day, \n";
    $sql .= "   payable_no, \n";
    $sql .= "   note \n";
    $sql .= ") \n";
    $sql .= "VALUES \n";
    $sql .= "( \n";
    $sql .= "   (SELECT COALESCE(MAX(pay_d_id), 0)+1 FROM t_payin_d), \n";
    $sql .= "   ".$_POST["hdn_payin_id"].", \n";
    $sql .= "   ".$_POST["form_trade"].", \n";
    if ($amount_total != null){
    $sql .= "   '$amount_total', \n";
    }else{
    $sql .= "   0, \n";
    }
    if ($_POST["form_bank"][0] != null){
    $sql .= "   (SELECT bank_cd   FROM t_bank WHERE bank_id = ".$_POST["form_bank"][0]."), \n";
    $sql .= "   (SELECT bank_name FROM t_bank WHERE bank_id = ".$_POST["form_bank"][0]."), \n";
    }else{
    $sql .= "   NULL, \n";
    $sql .= "   NULL, \n";
    }
    if ($_POST["form_bank"][1] != null){
    $sql .= "   (SELECT b_bank_cd   FROM t_b_bank WHERE b_bank_id = ".$_POST["form_bank"][1]."), \n";
    $sql .= "   (SELECT b_bank_name FROM t_b_bank WHERE b_bank_id = ".$_POST["form_bank"][1]."), \n";
    }else{
    $sql .= "   NULL, \n";
    $sql .= "   NULL, \n";
    }
    if ($_POST["form_bank"][2] != null){
    $sql .= "   ".$_POST["form_bank"][2].", \n";
    $sql .= "   (SELECT deposit_kind FROM t_account WHERE account_id = ".$_POST["form_bank"][2]."), \n";
    $sql .= "   (SELECT account_no   FROM t_account WHERE account_id = ".$_POST["form_bank"][2]."), \n";
    }else{
    $sql .= "   NULL, \n";
    $sql .= "   NULL, \n";
    $sql .= "   NULL, \n";
    }
    if ($limit_day != "--"){
    $sql .= "   '$limit_day', \n";
    }else{
    $sql .= "   NULL, \n";
    }
    if ($_POST["form_bill_paper_no"] != null){
    $sql .= "   '".$_POST["form_bill_paper_no"]."', \n";
    }else{
    $sql .= "   NULL, \n";
    }
    $sql .= "   NULL \n";
    $sql .= ") ";
    $sql .= ";";


    $res  = Db_Query($db_con, $sql);

    if ($res === false){
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }

    // 手数料がある場合はINSERTを実行
    if ($rebate_flg == true){

        $sql  = "INSERT INTO \n";
        $sql .= "   t_payin_d \n";
        $sql .= "( \n";
        $sql .= "   pay_d_id, \n";
        $sql .= "   pay_id, \n";
        $sql .= "   trade_id, \n";
        $sql .= "   amount, \n";
        $sql .= "   bank_cd, \n";
        $sql .= "   bank_name, \n";
        $sql .= "   b_bank_cd, \n";
        $sql .= "   b_bank_name, \n";
        $sql .= "   account_id, \n";
        $sql .= "   deposit_kind, \n";
        $sql .= "   account_no, \n";
        $sql .= "   payable_day, \n";
        $sql .= "   payable_no, \n";
        $sql .= "   note \n";
        $sql .= ") \n";
        $sql .= "VALUES \n";
        $sql .= "( \n";
        $sql .= "   (SELECT COALESCE(MAX(pay_d_id), 0)+1 FROM t_payin_d), \n";
        $sql .= "   ".$_POST["hdn_payin_id"].", \n";
        $sql .= "   35, \n";
        $sql .= "   '$rebate_total', \n";
        if ($_POST["form_bank"][0] != null){
        $sql .= "   (SELECT bank_cd   FROM t_bank WHERE bank_id = ".$_POST["form_bank"][0]."), \n";
        $sql .= "   (SELECT bank_name FROM t_bank WHERE bank_id = ".$_POST["form_bank"][0]."), \n";
        }else{
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        }
        if ($_POST["form_bank"][1] != null){
        $sql .= "   (SELECT b_bank_cd   FROM t_b_bank WHERE b_bank_id = ".$_POST["form_bank"][1]."), \n";
        $sql .= "   (SELECT b_bank_name FROM t_b_bank WHERE b_bank_id = ".$_POST["form_bank"][1]."), \n";
        }else{
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        }
/*配列の添字のして間違い(watanabe-k)2007-05-15
        if ($_POST["form_bank"][3] != null){
        $sql .= "   ".$_POST["form_bank"][3].", \n";
*/
        if ($_POST["form_bank"][2] != null){
        $sql .= "   ".$_POST["form_bank"][2].", \n";
        $sql .= "   (SELECT deposit_kind FROM t_account WHERE account_id = ".$_POST["form_bank"][2]."), \n";
        $sql .= "   (SELECT account_no   FROM t_account WHERE account_id = ".$_POST["form_bank"][2]."), \n";
        }else{
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        }
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL \n";
        $sql .= ") \n";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);

        if ($res === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }
    }

}


function Update_Allocate($db_con, $max_row){

    // 変更するpay_idに基づくデータを削除
    $sql  = "DELETE FROM \n";
    $sql .= "   t_payallocation_d \n";
    $sql .= "WHERE \n";
    $sql .= "   pay_id = ".$_POST["hdn_payin_id"]." \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);

    if ($res === false){
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }

    // 得意先分繰り返す
    for ($i = 0; $i < $max_row; $i++){

        // 手数料が入力されているか
        if ($_POST["form_rebate"][$i] != null){
            //入力がある場合は2回繰り返すように設定
            $rebate_cnt = 2;
        }else{
            $rebate_cnt = 1;
        }

        $amount     = str_replace(",", "", $_POST["form_amount"][$i]);
        $rebate     = str_replace(",", "", $_POST["form_rebate"][$i]);

        // 手数料がある場合２回繰り返す
        for ($j = 0; $j < $rebate_cnt; $j++){
            //振分入金データテーブルへインサート実行
            $sql  = "INSERT INTO \n";
            $sql .= "   t_payallocation_d \n";
            $sql .= "( \n";
            $sql .= "   payallocation_id, \n";
            $sql .= "   pay_id, \n";
            $sql .= "   client_id, \n";
            $sql .= "   client_cd1, \n";
            $sql .= "   client_cd2, \n";
            $sql .= "   client_cname, \n";
            $sql .= "   claim_div, \n";
            $sql .= "   trade_id, \n";
            $sql .= "   amount, \n";
            $sql .= "   note \n";
            $sql .= ") \n";
            $sql .= "VALUES \n";
            $sql .= "( \n";
            $sql .= "   (SELECT COALESCE(MAX(payallocation_id), 0)+1 FROM t_payallocation_d), \n";
            $sql .= "   ".$_POST["hdn_payin_id"].",\n";
            $sql .= "   ".$_POST["form_claim_id"][$i].", \n";
            $sql .= "   (SELECT client_cd1   FROM t_client WHERE client_id = ".$_POST["form_claim_id"][$i]."), \n";
            $sql .= "   (SELECT client_cd2   FROM t_client WHERE client_id = ".$_POST["form_claim_id"][$i]."), \n";
            $sql .= "   (SELECT client_cname FROM t_client WHERE client_id = ".$_POST["form_claim_id"][$i]."), \n";
            if ($_POST["hdn_bill_id"] == null){
            $sql .= "   (SELECT claim_div    FROM t_claim  WHERE client_id = ".$_POST["form_claim_id"][$i]." \n";
            $sql .= "                                        AND claim_id  = ".$_POST["hdn_claim_id"]."), \n";
            }else{
            $sql .= "   ( \n";
            $sql .= "       SELECT \n";
            $sql .= "           t_bill_d.claim_div \n";
            $sql .= "       FROM \n";
            $sql .= "           t_bill \n";
            $sql .= "           INNER JOIN t_bill_d ON  t_bill.bill_id = t_bill_d.bill_id \n";
            $sql .= "                               AND t_bill.bill_id = ".$_POST["hdn_bill_id"]." \n";
            $sql .= "                               AND t_bill_d.client_id = ".$_POST["form_claim_id"][$i]." \n";
            $sql .= "                               AND t_bill_d.bill_data_div != '0' \n";
            $sql .= "   ), \n";
            }
            if ($j == 0){
            $sql .= "   ".$_POST["form_trade"].", \n";
            $sql .= ($amount != null) ? "   $amount, \n" : "   NULL, \n";
            $sql .= "   '".$_POST["form_note"][$i]."' \n";
            }else{
            $sql .= "   35, \n";
            $sql .= ($rebate != null) ? "   $rebate, \n" : "   NULL, \n";
            $sql .= "   NULL\n";
            }
            $sql .= ") \n";
            $sql .= ";\n";
            $res  = Db_Query($db_con, $sql);
            // エラー時はロールバック
            if($res == false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }
        }

    }

}



?>
