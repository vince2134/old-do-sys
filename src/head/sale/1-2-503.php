<?php

/*
 *  履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007-05-07      -           fukuda      日次更新未実施伝票も抽出するよう修正
 *  2007-05-07      -           fukuda      入力されたFC・取引先の請求先を取得
 *  2010-04-19      -           hashimoto-y CSV出力機能を追加（Rev.1.5）
 *   2016/01/20                amano  Button_Submit 関数でボタン名が送られない IE11 バグ対応
 * 
 */

// ページ名
$page_title = "取引先元帳";

//環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_motocho.inc");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");
$smarty->register_modifier("number_format","number_format");

//DB接続
$db_con = Db_Connect();

/****************************/
// 権限関連処理
/****************************/
$auth   = Auth_Check($db_con);


/****************************/
// 外部変数取得
/****************************/


/****************************/
// 初期設定
/****************************/
// 表示件数（nullの場合は全件）
$range = null;

/****************************/
// フォームパーツ定義
/****************************/
// 出力形式
$radio = "";
$radio[] =& $form->createElement("radio", null, null, "画面", "1");
#2010-04-19 hashimoto-y
#$radio[] =& $form->createElement("radio", null, null, "帳票", "2");
#$radio[] =& $form->createElement("radio", null, null, "CSV",  "3");
$radio[] =& $form->createElement("radio", null, null, "CSV",  "2");

$form->addGroup($radio, "form_output", "");

// 集計期間
Addelement_Date_Range($form, "form_count_day", "集計期間", "-");

// FC・取引先リンク
$form->addElement("link", "form_client_link", "", "#", "FC・取引先",
    "onClick=\"javascript:return Open_SubWin('../dialog/1-0-250.php',Array('form_client[cd1]', 'form_client[cd2]', 'form_client[name]'), 500, 450, '2-503', 1)\""
);

// FC・取引先
$text = "";
$text[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
    onChange=\"javascript:Change_Submit('client_search_flg','#','true','form_client[cd2]')\"
    onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\" ".$g_form_option."\""
);
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "cd2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
    onChange=\"javascript:Button_Submit('client_search_flg','#','true', this)\" ".$g_form_option."\""
);
$text[] =& $form->createElement("static", "", "", " ");
$text[] =& $form->createElement("text", "name", "", "size=\"34\" $g_text_readonly");
$form->addGroup($text, "form_client", "", "");

// 表示ボタン
$form->addElement("submit", "form_show_button", "表　示", "");

// クリアボタン
$form->addElement("button", "form_clear_button", "クリア", "onClick=\"javascript: location.href('".$_SERVER[PHP_SELF]."');\"");

// hidden  FC・取引先検索フラグ
$form->addElement("hidden", "client_search_flg");

// hidden  FC・取引先情報
$form->addElement("hidden", "hdn_client_id");
$form->addElement("hidden", "hdn_close_day");
$form->addElement("hidden", "hdn_pay_m");
$form->addElement("hidden", "hdn_pay_d");

// hidden  フォームデータ保存用
$form->addElement("hidden", "hdn_output");
$form->addElement("hidden", "hdn_count_day[sy]");
$form->addElement("hidden", "hdn_count_day[sm]");
$form->addElement("hidden", "hdn_count_day[sd]");
$form->addElement("hidden", "hdn_count_day[ey]");
$form->addElement("hidden", "hdn_count_day[em]");
$form->addElement("hidden", "hdn_count_day[ed]");
$form->addElement("hidden", "hdn_client[cd1]");
$form->addElement("hidden", "hdn_client[cd2]");
$form->addElement("hidden", "hdn_client[name]");


/****************************/
// フォーム初期値設定
/****************************/
$def_fdata = array(
    "form_output"  => "1"
);
$form->setDefaults($def_fdata);


/****************************/
// FC・取引先フォームの入力・補完処理
/****************************/
// FC・取引先検索フラグがtrueの場合
if ($_POST["client_search_flg"] == "true"){

    // POSTされたFC・取引先コードを変数へ代入
    $client_cd1 = $_POST["form_client"]["cd1"];
    $client_cd2 = $_POST["form_client"]["cd2"];

    // FC・取引先の情報を抽出
    $sql  = "SELECT \n";
    $sql .= "   client_id, \n";
    $sql .= "   client_cname \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "WHERE \n";
    $sql .= "   client_cd1 = '$client_cd1' \n";
    $sql .= "AND \n"; 
    $sql .= "   client_cd2 = '$client_cd2' \n";
    $sql .= "AND \n"; 
    $sql .= "   client_div = '3' \n";
    $sql .= "AND \n"; 
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= ";"; 
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // 該当データがある場合
    if ($num > 0){
        $client_id      = pg_fetch_result($res, 0, 0);      // FC・取引先ID
        $client_cname   = pg_fetch_result($res, 0, 1);      // FC・取引先名（略称）
    }else{  
        $client_id      = "";   
        $client_cname   = "";   
    }
    // FC・取引先コード入力フラグをクリア
    // FC・取引先ID、FC・取引先名（略称）、請求先区分をフォームにセット
    $client_data["client_search_flg"]   = "";   
    $client_data["hdn_client_id"]       = $client_id;
    $client_data["form_client"]["name"] = $client_cname;
    $form->setConstants($client_data);

}


/****************************/
// エラーチェック
/****************************/
// 表示ボタン押下時
if ($_POST["form_show_button"] != null){

    // 表示ボタン押下フラグ作成
    $post_show_flg = true;

    // POSTデータを変数に代入
    $output         = $_POST["form_output"];
    $start_y        = ($_POST["form_count_day"]["sy"] != null) ? str_pad($_POST["form_count_day"]["sy"], 4, 0, STR_POS_LEFT) : null; 
    $start_m        = ($_POST["form_count_day"]["sm"] != null) ? str_pad($_POST["form_count_day"]["sm"], 2, 0, STR_POS_LEFT) : null; 
    $start_d        = ($_POST["form_count_day"]["sd"] != null) ? str_pad($_POST["form_count_day"]["sd"], 2, 0, STR_POS_LEFT) : null; 
    $end_y          = ($_POST["form_count_day"]["ey"] != null) ? str_pad($_POST["form_count_day"]["ey"], 4, 0, STR_POS_LEFT) : null; 
    $end_m          = ($_POST["form_count_day"]["em"] != null) ? str_pad($_POST["form_count_day"]["em"], 2, 0, STR_POS_LEFT) : null; 
    $end_d          = ($_POST["form_count_day"]["ed"] != null) ? str_pad($_POST["form_count_day"]["ed"], 2, 0, STR_POS_LEFT) : null; 
    $client_cd1     = $_POST["form_client"]["cd1"];
    $client_cd2     = $_POST["form_client"]["cd2"];
    $client_cname   = $_POST["form_client"]["name"];

    // ■集計期間
    // エラーメッセージ
    $err_msg = "集計期間の日付が妥当ではありません。";

    // 必須チェック
    $form->addGroupRule("form_count_day", array(
        "sy" => array(array($err_msg, "required")),
        "sm" => array(array($err_msg, "required")),
        "sd" => array(array($err_msg, "required")),
        "ey" => array(array($err_msg, "required")),
        "em" => array(array($err_msg, "required")),
        "ed" => array(array($err_msg, "required")),
    ));

    // 数値チェック
    $form->addGroupRule("form_count_day", array(
        "sy" => array(array($err_msg, "regex", "/^[0-9]+$/")),
        "sm" => array(array($err_msg, "regex", "/^[0-9]+$/")),
        "sd" => array(array($err_msg, "regex", "/^[0-9]+$/")),
        "ey" => array(array($err_msg, "regex", "/^[0-9]+$/")),
        "em" => array(array($err_msg, "regex", "/^[0-9]+$/")),
        "ed" => array(array($err_msg, "regex", "/^[0-9]+$/")),
    ));

    // どれか1つでも入力がある場合
    if ($start_y != null || $start_m != null || $start_d != null ||
        $end_y   != null || $end_m   != null || $end_d   != null){

        // 日付妥当性チェック（開始）
        if (!checkdate((int)$start_m, (int)$start_d, (int)$start_y)){
            $form->setElementError("form_count_day", $err_msg);
        }

        // 日付妥当性チェック（終了）
        if (!checkdate((int)$end_m,   (int)$end_d,   (int)$end_y)){
            $form->setElementError("form_count_day", $err_msg);
        }    

    }

    // ■FC・取引先
    // エラーメッセージ
    $err_msg = "正しい FC・取引先コード を入力して下さい。";

    // 必須チェック
    $form->addGroupRule("form_client", array(
        "cd1"   => array(array($err_msg, "required")),
        "cd2"   => array(array($err_msg, "required")),
        "name"  => array(array($err_msg, "required")),
    ));

    // 数値チェック
    $form->addGroupRule("form_client", array(
        "cd1"   => array(array($err_msg, "regex", "/^[0-9]+$/")),
        "cd2"   => array(array($err_msg, "regex", "/^[0-9]+$/")),
    ));

    // FC・取引先コードの妥当性チェック
    $sql  = "SELECT \n";
    $sql .= "   client_id, \n";
    $sql .= "   client_cd1, \n";
    $sql .= "   client_cd2, \n";
    $sql .= "   client_cname, \n";
    $sql .= "   close_day, \n";
    $sql .= "   pay_m, \n";
    $sql .= "   pay_d \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "WHERE \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   client_cd1 = '$client_cd1' \n";
    $sql .= "AND \n";
    $sql .= "   client_cd2 = '$client_cd2' \n";
    $sql .= "AND \n";
    $sql .= "   client_div = '3' \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        // FC・取引先が存在する場合は該当FC・取引先情報を変数に代入
        $client_id      = pg_fetch_result($res, 0, 0);
        $client_cd1     = pg_fetch_result($res, 0, 1);
        $client_cd2     = pg_fetch_result($res, 0, 2);
        #2010-04-19 hashimoto-y
        #$client_cname   = htmlspecialchars(pg_fetch_result($res, 0, 3));
        $client_cname   = htmlspecialchars($csv_client_cname = pg_fetch_result($res, 0, 3));
        $close_day      = pg_fetch_result($res, 0, 4);
        $pay_m          = pg_fetch_result($res, 0, 5);
        $pay_d          = pg_fetch_result($res, 0, 6);
    }else{
        // FC・取引先が存在しない場合はエラーをセット
        $form->setElementError("form_client", $err_msg);
    }

    /****************************/
    // エラーチェック/結果集計
    /****************************/
    // チェック適用
    $form->validate();
    // 結果をフラグに
    $err_flg = (count($form->_errors) > 0) ? true : false;

    /****************************/
    // hiddenセット
    /****************************/
    // エラーの無い場合
    if ($err_flg != true){
        // フォームの値をhiddenにセット
        $hdn_set["hdn_output"]          = stripslashes($_POST["form_output"]);
        $hdn_set["hdn_count_day"]["sy"] = stripslashes($_POST["form_count_day"]["sy"]);
        $hdn_set["hdn_count_day"]["sm"] = stripslashes($_POST["form_count_day"]["sm"]);
        $hdn_set["hdn_count_day"]["sd"] = stripslashes($_POST["form_count_day"]["sd"]);
        $hdn_set["hdn_count_day"]["ey"] = stripslashes($_POST["form_count_day"]["ey"]);
        $hdn_set["hdn_count_day"]["em"] = stripslashes($_POST["form_count_day"]["em"]);
        $hdn_set["hdn_count_day"]["ed"] = stripslashes($_POST["form_count_day"]["ed"]);
        $hdn_set["hdn_client"]["cd1"]   = stripslashes($_POST["form_client"]["cd1"]);
        $hdn_set["hdn_client"]["cd2"]   = stripslashes($_POST["form_client"]["cd2"]);
        $hdn_set["hdn_client"]["name"]  = stripslashes($_POST["form_client"]["name"]);
        // FC・取引先情報をhiddenにセット
        $hdn_set["hdn_client_id"]       = $client_id;
        $hdn_set["hdn_close_day"]       = $close_day;
        $hdn_set["hdn_pay_m"]           = $pay_m;
        $hdn_set["hdn_pay_d"]           = $pay_d;
        $form->setConstants($hdn_set);
    }

}


/****************************/
// ページ遷移時の処理
/****************************/
// 表示ボタン未押下かつFC・取引先検索フラグnullかつページ数がPOSTされている場合
if ($_POST["form_show_button"] == null && $_POST["client_search_flg"] == null && $_POST["f_page1"] != null){

    // ページ遷移フラグ作成
    $post_page_flg = true;

    // hiddenのFC・取引先情報を変数に代入
    $client_id      = $_POST["hdn_client_id"];
    $close_day      = $_POST["hdn_close_day"];
    $pay_m          = $_POST["hdn_pay_m"];
    $pay_d          = $_POST["hdn_pay_d"];

    // hiddenの検索データを変数に代入
    $output         = $_POST["hdn_output"];
    $start_y        = ($_POST["hdn_count_day"]["sy"] != null) ? str_pad($_POST["hdn_count_day"]["sy"], 4, 0, STR_POS_LEFT) : null; 
    $start_m        = ($_POST["hdn_count_day"]["sm"] != null) ? str_pad($_POST["hdn_count_day"]["sm"], 2, 0, STR_POS_LEFT) : null; 
    $start_d        = ($_POST["hdn_count_day"]["sd"] != null) ? str_pad($_POST["hdn_count_day"]["sd"], 2, 0, STR_POS_LEFT) : null; 
    $end_y          = ($_POST["hdn_count_day"]["ey"] != null) ? str_pad($_POST["hdn_count_day"]["ey"], 4, 0, STR_POS_LEFT) : null; 
    $end_m          = ($_POST["hdn_count_day"]["em"] != null) ? str_pad($_POST["hdn_count_day"]["em"], 2, 0, STR_POS_LEFT) : null; 
    $end_d          = ($_POST["hdn_count_day"]["ed"] != null) ? str_pad($_POST["hdn_count_day"]["ed"], 2, 0, STR_POS_LEFT) : null; 
    $client_cd1     = $_POST["hdn_client"]["cd1"];
    $client_cd2     = $_POST["hdn_client"]["cd2"];
    $client_cname   = htmlspecialchars(stripslashes($_POST["hdn_client"]["name"]));

    // hiddenの検索データをフォームにセット
    $form_set["form_output"]            = stripslashes($_POST["hdn__output"]);
    $form_set["form_count_day"]["sy"]   = stripslashes($_POST["hdn_count_day"]["sy"]);
    $form_set["form_count_day"]["sm"]   = stripslashes($_POST["hdn_count_day"]["sm"]);
    $form_set["form_count_day"]["sd"]   = stripslashes($_POST["hdn_count_day"]["sd"]);
    $form_set["form_count_day"]["ey"]   = stripslashes($_POST["hdn_count_day"]["ey"]);
    $form_set["form_count_day"]["em"]   = stripslashes($_POST["hdn_count_day"]["em"]);
    $form_set["form_count_day"]["ed"]   = stripslashes($_POST["hdn_count_day"]["ed"]);
    $form_set["form_client"]["cd1"]     = stripslashes($_POST["hdn_client"]["cd1"]);
    $form_set["form_client"]["cd2"]     = stripslashes($_POST["hdn_client"]["cd2"]);
    $form_set["form_client"]["name"]    = stripslashes($_POST["hdn_client"]["name"]);
    $form->setConstants($form_set);

}


/****************************/
// 表示データ取得
/****************************/
// 表示ボタン押下フラグtrue＋エラーの無い場合、またはページ遷移時
if (($post_show_flg == true && $err_flg != true) || $post_page_flg == true){

    // 該当FC・取引先の請求先を取得
    $ary_claim_data = Get_Claim_Data($db_con, $client_id);
    $claim_data = null;
    if ($ary_claim_data != null){
        foreach ($ary_claim_data as $key => $value){
            $claim_data .= $value["client_cd1"]."-".$value["client_cd2"]."　".htmlspecialchars($value["client_cname"])."<br>";
        }
    }

    // POSTされた日付データを日付の型に
    $start_day  = $start_y."-".$start_m."-".$start_d;
    $end_day    = $end_y."-".$end_m."-".$end_d;

    /****************************/
    // 割賦残高取得
    /****************************/
    $sql = Sale_Split_Balance_Sql($end_day, $client_id);
    $res = Db_Query($db_con, $sql);
    $num = pg_num_rows($res);
    // 割賦データがある場合
    if ($num > 0){
        $split_balance_amount = pg_fetch_result($res, 0, 0);
    }

    /****************************/
    // 売掛データ取得
    /****************************/
    // 繰越残高取得
    $ar_balance_amount = Get_Balance_Amount($db_con, $start_day, $client_id, "ar");

    // 取得件数設定
    $limit      =  ($range != null) ? $range : null;
    // 取得開始位置設定
    $offset     = ($post_show_flg == true) ? 0 : ($_POST["f_page1"] - 1) * $range;
    // 表示させるページ
    $page_count = ($post_show_flg == true) ? 1 : $_POST["f_page1"];

    // ページ遷移時かつ1ページ目でない場合
    if ($post_page_flg == true && $_POST["f_page1"] != "1"){
        // 表示するページより前のページの伝票明細データを取得（ページ遷移時の繰越残高取得用）
        $sql = Ar_Particular_Sql($start_day, $end_day, $client_id, $offset);
        $res = Db_Query($db_con, $sql);
        $num = pg_num_rows($res);
        $balance_particular_data = ($num > 0) ? Get_Data($res, 2, "ASSOC") : array(null);
    }

    // 伝票明細データの全件数取得
    $sql = Ar_Particular_Sql($start_day, $end_day, $client_id);
    $res = Db_Query($db_con, $sql);
    $total_count = pg_num_rows($res);
    $count_particular_data  = ($total_count > 0) ? Get_Data($res, 2, "ASSOC") : array(null);

    // 伝票明細データ取得（データが無い場合は空配列作成）
    $sql = Ar_Particular_Sql($start_day, $end_day, $client_id, $limit, $offset);
    $res = Db_Query($db_con, $sql);
    $num = pg_num_rows($res);
    $ary_particular_data    = ($num > 0) ? Get_Data($res, 2, "ASSOC") : array(null);

    // 全件表示の場合
    $range = ($range == null) ? $total_count : $range; 

    /****************************/
    // 買掛データ取得（残高のみ）
    /****************************/
    // 繰越残高取得
    $ap_balance_amount = Get_Balance_Amount($db_con, $start_day, $client_id, "ap");

    // 伝票明細データ取得（データが無い場合は空配列作成）
    $sql = Ap_Particular_Sql($start_day, $end_day, $client_id);
    $res = Db_Query($db_con, $sql);
    $num = pg_num_rows($res);
    $ary_ap_particular_data = ($num > 0) ? Get_Data($res, 2, "ASSOC") : array(null);

    // 買掛残高算出
    foreach ($ary_ap_particular_data as $key => $value){
        $ap_balance_amount += ($value["buy_amount"] - $value["payout_amount"]);
    }

}


/****************************/
// 取得した表示用データの整形
/****************************/
// 表示ボタン押下フラグtrue＋エラーが無い場合、またはページ遷移時
if (($post_show_flg == true && $err_flg != true) || $post_page_flg == true){

    // 締日
    $close_day  = ($close_day == "29") ? "月末" : $close_day."日";

    // 集金日
    $pay_m = ($pay_m == "0")  ? "当月"  : $pay_m;
    $pay_m = ($pay_m == "1")  ? "翌月"  : $pay_m;
    $pay_m = ($pay_m != "当月" && $pay_m != "翌月") ? $pay_m."ヶ月後" : $pay_m;
    $pay_d = ($pay_d == "29") ? "月末"  : $pay_d."日";

    // 売上額/入金額の合計算出（最終ページ用）
    foreach ($count_particular_data as $key => $value){
        $sum_sale_amount    += $value["sale_amount"];
        $sum_payin_amount   += $value["payin_amount"];
    }

    // ページ遷移時かつ1ページ目でない場合
    if ($post_page_flg == true && $_POST["f_page1"] != "1"){
        // 表示するページより前のページの伝票明細データを元に、表示するページに出力する残高を算出
        foreach ($balance_particular_data as $key => $value){
            $ar_balance_amount += ($value["sale_amount"] - $value["payin_amount"]);
        }
    }

    // 残高計算用初期値設定
    $each_balance_amount = $ar_balance_amount;

    // 行数初期値
    $row_num = 0;

    // 伝票明細データ
    foreach ($ary_particular_data as $key => $value){

        // 前/次の参照行を配列に入れて使いやすくしておく
        $back = $ary_particular_data[$key-1];
        $next = $ary_particular_data[$key+1];

        ///// 明細の種類（売上|入金|一括消費税|ロイヤリティ）
        // 売上明細フラグtrue
        if ($value["sale_flg"] == "t"){
            $disp_particular_data[$key]["type"] = "sale";
        // 入金明細フラグtrue
        }elseif ($value["payin_flg"] == "t"){
            $disp_particular_data[$key]["type"] = "payin";
        // 一括消費税フラグtrue
        }elseif ($value["lumptax_flg"] == "t"){
            $disp_particular_data[$key]["type"] = "lumptax";
        // ロイヤリティフラグtrue
        }elseif ($value["royalty_flg"] == "t"){
            $disp_particular_data[$key]["type"] = "royalty";
        }

        ///// 年の出力設定
        // 配列の最初、または前回と今回の年が異なる場合
        if ($key == 0 ||
            substr($back["trade_day"], 0, 4) != substr($value["trade_day"], 0, 4)
        ){
            $trade_y        = substr($value["trade_day"], 0, 4);
        }else{
            $trade_y        = null;
        }

        ///// 月日の出力設定
        // 年がnull、かつ前回と今回の月日が同じ場合
        if ($trade_y == null &&
            substr($back["trade_day"], 5) == substr($value["trade_day"], 5)
        ){
            $trade_d        = null;
        }else{
            $trade_d        = substr($value["trade_day"], 5);
        }

        ///// 伝票番号の出力設定
        // 月日がnull、かつ前回と今回の伝票番号が同じ、かつ前回と今回で明細の種類に変化がない場合
        if ($trade_d == null &&
            $back["slip_no"] == $value["slip_no"] &&
            $disp_particular_data[$key-1]["type"] == $disp_particular_data[$key]["type"]
        ){
            $slip_no        = null;
        }else{
            $slip_no        = $value["slip_no"];
        }

/*
        ///// 伝票番号の表示位置設定
        // 明細の種類が一括消費税またはロイヤリティの場合
        if ($disp_particular_data[$key]["type"] == "lumptax" || $disp_particular_data[$key]["type"] == "royalty"){
            $slip_align     = " align=\"center\" ";
        }else{
            $slip_align     = null;
        }
*/

        ///// 担当者の出力設定
        // 伝票番号がある場合
        if ($slip_no != null){
            #2010-04-19 hashimoto-y
            #$c_staff        = htmlspecialchars($value["c_staff"]);
            $c_staff        = htmlspecialchars( $csv_c_staff = $value["c_staff"] );
        }else{
            #2010-04-19 hashimoto-y
            $c_staff        = $csv_c_staff = null;
        }

        ///// 行色設定
        // 伝票番号がある場合
        if ($slip_no != null){
            $disp_particular_data[$key]["row_col"] = (bcmod(++$row_num, 2) == 0)    ? "Result1" : "Result2";
        }else{
            $disp_particular_data[$key]["row_col"] = (bcmod($row_num, 2) == 0)      ? "Result1" : "Result2";
        }

        ///// 取引区分の出力設定
        // 伝票番号がnull、かつ前回と今回の取引区分が同じ場合
        if ($slip_no == null &&
            $back["trade_cd"] == $value["trade_cd"]
        ){
            $trade_cd       = null;
        }else{
            $trade_cd       = $value["trade_cd"];
        }

        ///// 商品名の表示位置設定
        // 消費税フラグtrue、または一括消費税フラグtrueの場合
        if ($value["tax_flg"] == "t" || $value["lumptax_flg"] == "t"){
            $goods_align    = " align=\"right\"";
        }else{
            $goods_align    = null;
        }

        ///// 数量の出力設定
        // 数量がない、または入金額がある場合
        if ($value["num"] == null || $value["payin_amount"] != null){
            $num            = null;
        }else{
            $num            = number_format($value["num"]);
        }

        ///// 単価の出力設定
        // 数量がない、または入金額がある、または伝票番号がない場合
        if ($value["num"] == null || $value["payin_amount"] != null || $value["slip_no"] == null){
            $sale_price     = null;
        }else{
            $sale_price     = number_format($value["sale_price"], 2);
        }

        ///// 売上額の出力設定
        // 売上額がある場合
        if ($value["sale_amount"] != null){
            $sale_amount    = number_format($value["sale_amount"]);
        }else{
            $sale_amount    = null;
        }

        ///// 入金額の出力設定
        // 入金の場合
        if ($value["payin_amount"] != null){
            $payin_amount   = number_format($value["payin_amount"]);
        }else{
            $payin_amount   = null;
        }

        // 残高算出
        $each_balance_amount+= ($value["sale_amount"] - $value["payin_amount"]);

        ///// 残高の出力設定
        // 売上伝票の場合は、伝票消費税フラグtrueの場合
        // 入金伝票の場合は、今回と次回で伝票番号が異なるまたは次回が入金明細で無い場合
        // 一括消費税の場合、ロイヤリティの場合
        if (
            ($value["sale_flg"]  == "t" && ($value["tax_flg"] == "t")) ||
            ($value["payin_flg"] == "t" && ($value["slip_no"] != $next["slip_no"] || $next["payin_amount"] == null)) ||
            ($value["lumptax_flg"] == "t") ||
            ($value["royalty_flg"] == "t")
        ){
            $print_balance_amount = number_format($each_balance_amount);
        }else{
            $print_balance_amount = null;
        }

        ///// 直送先の出力設定
        // 売上伝票時の1行目のみ出力
        if ($value["sale_flg"] == "t" && $slip_no != null){      
            #2010-04-19 hashimoto-y
            #$direct         = htmlspecialchars($value["direct"]);
            $direct         = htmlspecialchars( $csv_direct = $value["direct"] );
        }else{  
            #2010-04-19 hashimoto-y
            $direct         = $csv_direct = null; 
        }   

        ///// 備考の出力設定
        // 売上伝票時は伝票内の1行目のみ出力（売上：ヘッダ、入金：データに備考が登録されているため）
        if (    
            ($value["sale_flg"] == "t" && $slip_no != null) ||
            $value["payin_flg"] == "t"
        ){      
            #2010-04-19 hashimoto-y
            #$note           = nl2br(htmlspecialchars($value["note"]));
            $note           = nl2br(htmlspecialchars( $csv_note = $value["note"] ));
        }else{  
            #2010-04-19 hashimoto-y
            $note           = $csv_note = null; 
        }   

        #2010-04-19 hashimoto-y
        ///// まとめ
        // 年
        #$disp_particular_data[$key]["trade_y"]          = $trade_y;
        $disp_particular_data[$key]["trade_y"]          = $csv_page_data[$key][0]  = $trade_y;

        // 月日
        #$disp_particular_data[$key]["trade_m"]          = $trade_d;
        $disp_particular_data[$key]["trade_m"]          = $csv_page_data[$key][1]  = $trade_d;

        // 伝票No.
        #$disp_particular_data[$key]["slip_no"]          = $slip_no;
        $disp_particular_data[$key]["slip_no"]          = $csv_page_data[$key][2]  = $slip_no;

        // 伝票No.の表示位置
        //$disp_particular_data[$key]["slip_align"]       = $slip_align;
        // 担当者
        #$disp_particular_data[$key]["c_staff"]          = $c_staff;
        $disp_particular_data[$key]["c_staff"]          = $c_staff;
        $csv_page_data[$key][3]                         = $csv_c_staff;

        // 取引区分
        #$disp_particular_data[$key]["trade_cd"]         = $trade_cd;
        $disp_particular_data[$key]["trade_cd"]         = $csv_page_data[$key][4]  = $trade_cd;

        // 商品名
        #$disp_particular_data[$key]["goods_name"]       = htmlspecialchars($value["goods_name"]);
        $disp_particular_data[$key]["goods_name"]       = htmlspecialchars($value["goods_name"]);
        $csv_page_data[$key][5]                         = $value["goods_name"];

        // 商品名の表示位置
        $disp_particular_data[$key]["goods_align"]      = $goods_align;

        // 数量
        #$disp_particular_data[$key]["num"]              = $num;
        $disp_particular_data[$key]["num"]              = $csv_page_data[$key][6]  = $num;

        // 単価
        #$disp_particular_data[$key]["sale_price"]       = $sale_price;
        $disp_particular_data[$key]["sale_price"]       = $csv_page_data[$key][7]  = $sale_price;

        // 売上額
        #$disp_particular_data[$key]["sale_amount"]      = $sale_amount;
        $disp_particular_data[$key]["sale_amount"]      = $csv_page_data[$key][8]  = $sale_amount;

        // 入金額
        #$disp_particular_data[$key]["payin_amount"]     = $payin_amount;
        $disp_particular_data[$key]["payin_amount"]     = $csv_page_data[$key][9]  = $payin_amount;

        // 残高
        #$disp_particular_data[$key]["balance_amount"]   = $print_balance_amount;
        $disp_particular_data[$key]["balance_amount"]   = $csv_page_data[$key][10] = $print_balance_amount;

        // 直送先
        #$disp_particular_data[$key]["direct"]           = $direct;
        $disp_particular_data[$key]["direct"]           = $csv_page_data[$key][11] = $direct;
        $csv_page_data[$key][11]                        = $csv_direct;

        // 備考
        #$disp_particular_data[$key]["note"]             = $note;
        $disp_particular_data[$key]["note"]             = $note;
        $csv_page_data[$key][12]                        = $csv_note;


    }

}

#2010-04-19 hashimoto-y
#CSV処理追加
if ($post_show_flg == true && $err_flg != true &&  $_POST["form_output"] == 2){

    $csv_header = array(
            "年",
            "月日",
            "伝票No.",
            "担当者",
            "取区",
            "商品",
            "数量",
            "単価",
            "売上",
            "入金",
            "残高",
            "直送先",
            "備考",
          );

    #繰越残高
    $balance_carried = array("","","","","","繰越残高","","","","",number_format($ar_balance_amount),"","");
    array_unshift($csv_page_data, $balance_carried);

    #残高合計
    $total_balance = array("","","","","","合計","","",number_format($sum_sale_amount),number_format($sum_payin_amount),number_format($each_balance_amount),"","");
    array_push($csv_page_data, $total_balance);

    #ヘッダ追加
    #array_unshift($csv_page_data, $csv_addheader);

    #$csv_file_name = "取引先元帳".date("Ymd").".csv";
    $csv_file_name = "取引先元帳_" .$csv_client_cname .$end_y .$end_m .$end_d .".csv";

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($csv_page_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;

}


/****************************/
// HTML作成
/****************************/
// 表示ボタン押下フラグtrue＋エラーが無い場合、またはページ遷移時
if (($post_show_flg == true && $err_flg != true) || $post_page_flg == true){

    // ページ分け
    $html_page  = ($range != $total_count) ? Html_Page($total_count, $page_count, 1, $range) : "全 <b>$total_count</b> 件";
    $html_page2 = ($range != $total_count) ? Html_Page($total_count, $page_count, 2, $range) : null;

    // FC・取引先情報１（コード、名前）
    $html_1  = "<span style=\"font: bold 16px; color: #555555;\">";
    $html_1 .= $client_cd1."-".$client_cd2."　".$client_cname;
    $html_1 .= "</span>\n";

    // FC・取引先情報２
    $html_2 .= "<table class=\"List_Table\" border=\"1\">\n";
    $html_2 .= "<col width=\"60\" style=\"font-weight: bold;\">\n";
    $html_2 .= "<col width=\"120\">\n";
    $html_2 .= "<col width=\"60\" style=\"font-weight: bold;\">\n";
    $html_2 .= "<col width=\"120\">\n";
    $html_2 .= "    <tr>\n";
    $html_2 .= "        <td class=\"Title_Pink\">締日</td>\n";
    $html_2 .= "        <td class=\"Value\">$close_day</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">集金日</td>\n";
    $html_2 .= "        <td class=\"Value\">".$pay_m."の".$pay_d."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "    <tr>\n";
    $html_2 .= "        <td class=\"Title_Pink\">請求先</td>\n";
    $html_2 .= "        <td class=\"Value\" colspan=\"3\">$claim_data</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "</table>\n";

    $html_2 .= "        </td>\n";
    $html_2 .= "        <td align=\"right\">\n";

    $html_2 .= "<table class=\"List_Table\" border=\"1\">\n";
    $html_2 .= "<col width=\"70\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_2 .= "<col width=\"80\">\n";
    $html_2 .= "    <tr>\n";
    $html_2 .= "        <td class=\"Td_Search_3\">買掛残高</td>\n";
    $html_2 .= "        <td class=\"Value\" align=\"right\"".Font_Color($ap_balance_amount).">".number_format($ap_balance_amount)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "    <tr>\n";
    $html_2 .= "        <td class=\"Title_Pink\">売掛残高</td>\n";
    $html_2 .= "        <td class=\"Value\" align=\"right\"".Font_Color($each_balance_amount).">".number_format($each_balance_amount)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "    <tr>\n";
    $html_2 .= "        <td class=\"Title_Pink\">割賦残高</td>\n";
    $html_2 .= "        <td class=\"Value\" align=\"right\"".Font_Color($split_balance_amount).">".number_format($split_balance_amount)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "</table>\n";

    // 明細データ
    $html_3  = "<table class=\"List_Table\" border=\"1\">\n";
    $html_3 .= "<col width=\"40px\">\n";
    $html_3 .= "<col width=\"40px\">\n";
    $html_3 .= "<col width=\"60px\">\n";
    $html_3 .= "<col>\n";
    $html_3 .= "<col width=\"30px\">\n";
    $html_3 .= "<col>\n";
    $html_3 .= "<col width=\"40px\">\n";
    $html_3 .= "<col width=\"80px\" span=\"4\">\n";
    $html_3 .= "    <tr align=\"center\" style=\"font-weight: bold;\">\n";
    $html_3 .= "        <td class=\"Title_Pink\">年</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">月日</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">伝票No.</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">担当者</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">取区</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">商品</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">数量</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">単価</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">売上</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">入金</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">残高</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">直送先</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">備考</td>\n";
    $html_3 .= "    </tr>\n";
    $html_3 .= "    <tr class=\"Result1\">\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td align=\"right\">繰越残高</td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td align=\"right\"".Font_Color($ar_balance_amount).">".number_format($ar_balance_amount)."</td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "    </tr>\n";
    if (is_array($ary_particular_data[0])){
        foreach ($disp_particular_data as $key => $value){
    $html_3 .= "    <tr class=\"".$value["row_col"]."\">\n";
    $html_3 .= "        <td nowrap align=\"center\">".$value["trade_y"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"center\">".$value["trade_m"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"center\">".$value["slip_no"]."</td>\n";
    $html_3 .= "        <td nowrap>".$value["c_staff"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"center\">".$value["trade_cd"]."</td>\n";
    $html_3 .= "        <td nowrap ".$value["goods_align"].">".$value["goods_name"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"right\"".Font_Color($value["num"]).">".$value["num"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"right\"".Font_Color($value["sale_price"]).">".$value["sale_price"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"right\"".Font_Color($value["sale_amount"]).">".$value["sale_amount"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"right\"".Font_Color($value["payin_amount"]).">".$value["payin_amount"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"right\"".Font_Color($value["balance_amount"]).">".$value["balance_amount"]."</td>\n";
    $html_3 .= "        <td nowrap>".$value["direct"]."</td>\n";
    $html_3 .= "        <td nowrap>".$value["note"]."</td>\n";
    $html_3 .= "    </tr>\n";
        }
    }
    // 合計は最終ページのみ出力
    if ($total_count < $page_count * $range + 1){
    $html_3 .= "    <tr class=\"Result3\">\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td align=\"right\"><b>合計</b></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td align=\"right\"".Font_Color($sum_sale_amount).">".number_format($sum_sale_amount)."</td>\n";
    $html_3 .= "        <td align=\"right\"".Font_Color($sum_payin_amount).">".number_format($sum_payin_amount)."</td>\n";
    $html_3 .= "        <td align=\"right\"".Font_Color($each_balance_amount).">".number_format($each_balance_amount)."</td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "    </tr>\n";
    }
    $html_3 .= "</table>\n";

}


/****************************/
// HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
// メニュー作成
/****************************/
$page_menu = Create_Menu_h("sale", "5");

/****************************/
// 画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

/****************************/
// ページ作成
/****************************/
// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form関連の変数をassign
$smarty->assign("form", $renderer->toArray());

// その他の変数をassign
$smarty->assign("var", array(
	"html_header"   => "$html_header",
	"page_menu"     => "$page_menu",
	"page_header"   => "$page_header",
	"html_footer"   => "$html_footer",
	"html_page"     => "$html_page",
	"html_page2"    => "$html_page2",
));
$smarty->assign("html_1", "$html_1");
$smarty->assign("html_2", "$html_2");
$smarty->assign("html_3", "$html_3");

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
