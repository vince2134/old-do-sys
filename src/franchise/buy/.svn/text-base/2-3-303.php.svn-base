<?php
/*
 * 履歴：
 *  日付            B票No.          担当者      内容
 *  -----------------------------------------------------------
 *  2007-04-02      その他作業116~7 fukuda      「決済日」「手形券面番号」の検索項目を追加
 *  2007-04-02                      fukuda      検索条件復元処理追加
 *  2007-05-07                      fukuda      ソート順を日付の昇順に変更
 *
 *
 *
 *
 */

// ページタイトル
$page_title = "支払照会";

// 環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// テンプレート関数をレジスト
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

// DB接続
$db_con = Db_Connect();

// 権限チェック
$auth   = Auth_Check($db_con);


/****************************/
// 検索条件復元関連
/****************************/
// 検索フォーム初期値配列
$ary_form_list = array(
    "form_display_num"      => "1",
    "form_client_branch"    => "",
    "form_client"           => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_pay_no"           => array("s" => "", "e" => ""),
    "form_pay_day"          => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))
    ),
    "form_sum_amount"       => array("s" => "", "e" => ""),
    "form_input_day"        => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""), 
    "form_account_day"      => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""), 
    "form_bank"             => array("cd" => "", "name" => ""),
    "form_b_bank"           => array("cd" => "", "name" => ""),
    "form_account_no"       => "",
    "form_payable_no"       => "",
    "form_deposit_kind"     => "1",
    "form_renew"            => "1",
    "form_trade"            => "",
);

// 検索条件復元
Restore_Filter2($form, "payout", "form_display", $ary_form_list);


/****************************/
// 初期値設定
/****************************/
$form->setDefaults($ary_form_list);

$limit          = null;     // LIMIT
$offset         = "0";      // OFFSET
$total_count    = "0";      // 全件数
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // 表示ページ数


/****************************/
// 外部変数取得
/****************************/
$shop_id = $_SESSION["client_id"];

// 選択されたデータ支払IDを取得
$pay_id = $_POST["pay_h_id"];


//***************************/
// フォームパーツ定義
/****************************/
/* 共通フォーム */
Search_Form_Payout($db_con, $form, $ary_form_list);

/* モジュール別フォーム */
// 銀行
$obj    =   null;
$obj[]  =   $form->createElement("text", "cd", "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", " ");
$obj[]  =   $form->createElement("text", "name", "", "size=\"34\" maxLength=\"15\" $g_form_option");
$form->addGroup($obj, "form_bank", "", "");

// 支店
$obj    =   null;
$obj[]  =   $form->createElement("text", "cd", "", "size=\"3\" maxLength=\"3\" class=\"ime_disabled\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", " ");
$obj[]  =   $form->createElement("text", "name", "", "size=\"34\" maxLength=\"15\" $g_form_option");
$form->addGroup($obj, "form_b_bank", "", "");

// 口座番号
$form->addElement("text", "form_account_no", "", "size=\"8\" maxLength=\"7\" class=\"ime_disabled\" $g_form_option");

// 手形券面番号
$form->addElement("text", "form_payable_no", "", "size=\"13\" maxLength=\"10\" class=\"ime_disabled\" $g_form_option\"");

// 預金種目
$radio = "";
$radio[] =& $form->createElement("radio", null, null, "全て", "1");
$radio[] =& $form->createElement("radio", null, null, "普通", "2");
$radio[] =& $form->createElement("radio", null, null, "当座", "3");
$form->addGroup($radio, "form_deposit_kind", "");

// 日次更新
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "全て",   "1");
$radio[] =& $form->createElement("radio", null, null, "未実施", "2");
$radio[] =& $form->createElement("radio", null, null, "実施済", "3");
$form->addGroup($radio, "form_renew", "");

// 取引区分
$item   =   Select_Get($db_con, "trade_payout");
unset($item[48]);
$form->addElement("select", "form_trade", "", $item, $g_form_option_select);

// ソートリンク
$ary_sort_item = array(
    "sl_slip"           => "支払番号",
    "sl_payout_day"     => "支払日",
    "sl_input_day"      => "入力日",
    "sl_client_cd"      => "仕入先コード",
    "sl_client_name"    => "仕入先名",
    "sl_bank_cd"        => "銀行コード",
    "sl_bank_name"      => "銀行名",
    "sl_b_bank_cd"      => "支店コード",
    "sl_b_bank_name"    => "支店名",
    "sl_deposit_kind"   => "預金種目",
    "sl_account_no"     => "口座番号",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_payout_day");

// 表示ボタン
$form->addElement("submit", "form_display", "表　示");

// クリアボタン
$form->addElement("button", "kuria", "クリア", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// ヘッダ部リンクボタン
$ary_h_btn_list = array("照会・変更" => $_SERVER["PHP_SELF"], "入　力" => "./2-3-302.php");
Make_H_Link_Btn($form, $ary_h_btn_list);

// 処理フラグ
$form->addElement("hidden","data_delete_flg");
$form->addElement("hidden","pay_h_id");


//***************************/
// 削除リンク押下処理
//***************************/
if ($_POST["data_delete_flg"] == "true"){

    // 支払IDによる、支払データを削除するデータ   
    $sql  = "DELETE \n";
    $sql .= "FROM \n";
    $sql .= "   t_payout_h \n";
    $sql .= "WHERE \n";
    $sql .= "   pay_id = ".$_POST["pay_h_id"]." \n";
    $sql .= ";";
    $res = @Db_Query($db_con, $sql);

    // hiddenをクリア
    $clear_hdn["data_delete_flg"] = "";
    $form->setConstants($clear_hdn);

    $post_flg = true;

}


/****************************/
// 表示ボタン押下時
/****************************/
if ($_POST["form_display"] != null){

    // 日付POSTデータの0埋め
    $_POST["form_pay_day"]      = Str_Pad_Date($_POST["form_pay_day"]);
    $_POST["form_input_day"]    = Str_Pad_Date($_POST["form_input_day"]);
    $_POST["form_account_day"]  = Str_Pad_Date($_POST["form_account_day"]);

    /****************************/
    // エラーチェック
    /****************************/
    // ■支払日
    // エラーメッセージ
    $err_msg = "支払日 の日付が妥当ではありません。";
    Err_Chk_Date($form, "form_pay_day", $err_msg);

    // ■合計金額
    // エラーメッセージ
    $err_msg = "合計金額 は数値のみ入力可能です。";
    Err_Chk_Int($form, "form_sum_amount", $err_msg);

    // ■入力日
    // エラーメッセージ
    $err_msg = "入力日 の日付が妥当ではありません。";
    Err_Chk_Date($form, "form_input_day", $err_msg);

    // ■決済日
    // エラーメッセージ
    $err_msg = "決済日 の日付が妥当ではありません。";
    Err_Chk_Date($form, "form_account_day", $err_msg);

    /****************************/
    // エラーチェック結果集計
    /****************************/
    // チェック適用
    $form->validate();

    // 結果をフラグに
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = ($err_flg != true) ? true : false;

}


/****************************/
// 1. 表示ボタン押下＋エラーなし時
// 2. ページ切り替え時
/****************************/
if (($_POST["form_display"] != null && $err_flg != true ) || ($_POST != null && $_POST["form_display"] == null)){ 

    // 日付POSTデータの0埋め
    $_POST["form_pay_day"]      = Str_Pad_Date($_POST["form_pay_day"]);
    $_POST["form_input_day"]    = Str_Pad_Date($_POST["form_input_day"]);
    $_POST["form_account_day"]  = Str_Pad_Date($_POST["form_account_day"]);

    // 1. フォームの値を変数にセット
    // 2. SESSION（hidden用）の値（検索条件復元関数内でセット）を変数にセット
    // 一覧取得クエリ条件に使用
    $display_num        = $_POST["form_display_num"];
    $client_branch      = $_POST["form_client_branch"];
    $client_cd1         = $_POST["form_client"]["cd1"];
    $client_cd2         = $_POST["form_client"]["cd2"];
    $client_name        = $_POST["form_client"]["name"];
    $pay_no_s           = $_POST["form_pay_no"]["s"];
    $pay_no_e           = $_POST["form_pay_no"]["e"];
    $pay_day_sy         = $_POST["form_pay_day"]["sy"];
    $pay_day_sm         = $_POST["form_pay_day"]["sm"];
    $pay_day_sd         = $_POST["form_pay_day"]["sd"];
    $pay_day_ey         = $_POST["form_pay_day"]["ey"];
    $pay_day_em         = $_POST["form_pay_day"]["em"];
    $pay_day_ed         = $_POST["form_pay_day"]["ed"];
    $sum_amount_s       = $_POST["form_sum_amount"]["s"];
    $sum_amount_e       = $_POST["form_sum_amount"]["e"];
    $input_day_sy       = $_POST["form_input_day"]["sy"];
    $input_day_sm       = $_POST["form_input_day"]["sm"];
    $input_day_sd       = $_POST["form_input_day"]["sd"];
    $input_day_ey       = $_POST["form_input_day"]["ey"];
    $input_day_em       = $_POST["form_input_day"]["em"];
    $input_day_ed       = $_POST["form_input_day"]["ed"];
    $account_day_sy     = $_POST["form_account_day"]["sy"];
    $account_day_sm     = $_POST["form_account_day"]["sm"];
    $account_day_sd     = $_POST["form_account_day"]["sd"];
    $account_day_ey     = $_POST["form_account_day"]["ey"];
    $account_day_em     = $_POST["form_account_day"]["em"];
    $account_day_ed     = $_POST["form_account_day"]["ed"];
    $bank_cd            = $_POST["form_bank"]["cd"];
    $bank_name          = $_POST["form_bank"]["name"];
    $b_bank_cd          = $_POST["form_b_bank"]["cd"];
    $b_bank_name        = $_POST["form_b_bank"]["name"];
    $account_no         = $_POST["form_account_no"];
    $payable_no         = $_POST["form_payable_no"];
    $deposit_kind       = $_POST["form_deposit_kind"];
    $renew              = $_POST["form_renew"];
    $trade              = $_POST["form_trade"];

    $post_flg = true;

}


/****************************/
// 一覧データ取得条件作成
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // 顧客担当支店
    if ($client_branch != null){
        $sql .= "AND \n";
        $sql .= "   t_payout_h.client_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           client_id \n";
        $sql .= "       FROM \n";
        $sql .= "           t_client \n";
        $sql .= "       WHERE \n";
        $sql .= "           charge_branch_id = $client_branch \n"; 
        $sql .= "   ) \n";
    }
    // 仕入先コード1
    $sql .= ($client_cd1 != null) ? "AND t_payout_h.client_cd1 LIKE '$client_cd1%' \n" : null; 
    // 仕入先コード2
    $sql .= ($client_cd2 != null) ? "AND t_payout_h.client_cd2 LIKE '$client_cd2%' \n" : null; 
    // 仕入先名
    if ($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_payout_h.client_name  LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_payout_h.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_payout_h.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
    // 支払番号（開始）
    $sql .= ($pay_no_s != null) ? "AND t_payout_h.pay_no >= '".str_pad($pay_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // 支払番号（終了）
    $sql .= ($pay_no_e != null) ? "AND t_payout_h.pay_no <= '".str_pad($pay_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // 支払日（開始）
    $pay_day_s = $pay_day_sy."-".$pay_day_sm."-".$pay_day_sd;
    $sql .= ($pay_day_s != "--") ? "AND '$pay_day_s' <= t_payout_h.pay_day \n" : null;
    // 支払日（終了）
    $pay_day_e = $pay_day_ey."-".$pay_day_em."-".$pay_day_ed;
    $sql .= ($pay_day_e != "--") ? "AND t_payout_h.pay_day <= '$pay_day_e' \n" : null;
    // 合計金額（開始）
    $sql .= ($sum_amount_s != null) ? "AND t_payout_d.pay_amount + t_payout_d_48.pay_amount >= '$sum_amount_s' \n" : null;
    // 合計金額（終了）
    $sql .= ($sum_amount_e != null) ? "AND t_payout_d.pay_amount + t_payout_d_48.pay_amount <= '$sum_amount_e' \n" : null;
    // 入力日（開始）
    $input_day_s = $input_day_sy."-".$input_day_sm."-".$input_day_sd;
    $sql .= ($input_day_s != "--") ? "AND '$input_day_s' <= t_payout_h.input_day \n" : null;
    // 入力日（終了）
    $input_day_e = $input_day_ey."-".$input_day_em."-".$input_day_ed;
    $sql .= ($input_day_e != "--") ? "AND t_payout_h.input_day <= '$input_day_e' \n" : null;
    // 決済日（開始）
    $account_day_s = $account_day_sy."-".$account_day_sm."-".$account_day_sd;
    $sql .= ($account_day_s != "--") ? "AND '$account_day_s' <= t_payout_h.account_day \n" : null;
    // 決済日（終了）
    $account_day_e = $account_day_ey."-".$account_day_em."-".$account_day_ed;
    $sql .= ($account_day_e != "--") ? "AND t_payout_h.account_day <= '$account_day_e' \n" : null;
    // 銀行コード
    $sql .= ($bank_cd != null) ? "AND t_payout_d.bank_cd LIKE '$bank_cd%' \n" : null;
    // 銀行名
    $sql .= ($bank_name != null) ? "AND t_payout_d.bank_name LIKE '%$bank_name%' \n" : null;
    // 支店コード
    $sql .= ($b_bank_cd != null) ? "AND t_payout_d.b_bank_cd LIKE '$b_bank_cd%' \n" : null;
    // 支店名
    $sql .= ($b_bank_name != null) ? "AND t_payout_d.b_bank_name LIKE '%$b_bank_name%' \n" : null;
    // 預金種目
    if ($deposit_kind == "2"){
        $sql .= "AND t_payout_d.deposit_kind = '1' \n";
    }else
    if ($deposit_kind == "3"){
        $sql .= "AND t_payout_d.deposit_kind = '2' \n";
    }
    // 口座番号
    $sql .= ($account_no != null) ? "AND t_payout_d.account_no LIKE '$account_no%' \n" : null;
    // 手形券面番号
    $sql .= ($payable_no != null) ? "AND t_payout_h.payable_no LIKE '$payable_no%' \n" : null;
    // 日次更新
    if ($renew == "2"){
        $sql .= "AND t_payout_h.renew_flg = 'f' \n";
    }elseif ($renew == "3"){
        $sql .= "AND t_payout_h.renew_flg = 't' \n";
    }
    // 取引区分
    if ($trade != null){
        $sql .= "AND t_payout_h.pay_id IN \n";
        $sql .= "   (SELECT pay_id FROM t_payout_d WHERE trade_id = $trade) \n";
    }

    // 変数詰め替え
    $where_sql = $sql;


    $sql = null;

    // ソート順
    switch ($_POST["hdn_sort_col"]){
        // 支払番号
        case "sl_slip":
            $sql .= "   t_payout_h.pay_no, \n";
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2 \n";
            break;
        // 支払日
        case "sl_payout_day":
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.pay_no, \n";
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2 \n";
            break;
        // 入力日
        case "sl_input_day":
            $sql .= "   t_payout_h.input_day, \n";
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.pay_no, \n";
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2 \n";
            break;
        // 仕入先コード
        case "sl_client_cd":
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2, \n";
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.pay_no \n";
            break;
        // 仕入先名
        case "sl_client_name":
            $sql .= "   t_payout_h.client_cname, \n";
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.pay_no, \n";
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2 \n";
            break;
        // 銀行コード
        case "sl_bank_cd":
            $sql .= "   t_payout_d.bank_cd, \n";
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.pay_no, \n";
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2 \n";
            break;
        // 銀行名
        case "sl_bank_name":
            $sql .= "   t_payout_d.bank_name, \n";
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.pay_no, \n";
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2 \n";
            break;
        // 支店コード
        case "sl_b_bank_cd":
            $sql .= "   t_payout_d.b_bank_cd, \n";
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.pay_no, \n";
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2 \n";
            break;
        // 支店名
        case "sl_b_bank_name":
            $sql .= "   t_payout_d.b_bank_name, \n";
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.pay_no, \n";
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2 \n";
            break;
        // 預金種目
        case "sl_deposit_kind":
            $sql .= "   t_payout_d.deposit_kind, \n";
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.pay_no, \n";
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2 \n";
            break;
        // 口座番号
        case "sl_account_no":
            $sql .= "   t_payout_d.account_no, \n";
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.pay_no, \n";
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2 \n";
            break;
    }

    // 変数詰め替え
    $order_sql = $sql;

}


/****************************/
// 一覧データ取得
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   t_payout_h.pay_id, \n";
    $sql .= "   t_payout_h.pay_no, \n";
    $sql .= "   t_payout_h.input_day, \n";
    $sql .= "   t_payout_h.pay_day, \n";
    $sql .= "   t_trade.trade_name, \n";
    $sql .= "   t_payout_d.bank_cd, \n";
    $sql .= "   t_payout_d.bank_name, \n";
    $sql .= "   t_payout_d.b_bank_cd, \n";
    $sql .= "   t_payout_d.b_bank_name, \n";
    $sql .= "   CASE t_payout_d.deposit_kind \n";
    $sql .= "       WHEN '1' THEN '普通' \n";
    $sql .= "       WHEN '2' THEN '当座' \n";
    $sql .= "   END \n";
    $sql .= "   AS deposit, \n";
    $sql .= "   t_payout_d.account_no, \n";
    $sql .= "   t_payout_h.client_cname, \n";
    $sql .= "   t_payout_h.client_cd1, \n";
    $sql .= "   t_payout_h.client_cd2, \n";
    $sql .= "   t_payout_d.pay_amount, \n";
    $sql .= "   t_payout_d_48.pay_amount AS tax_amount, \n";
    $sql .= "   t_payout_d.pay_amount + t_payout_d_48.pay_amount AS sum_amount, \n";
    $sql .= "   t_payout_d.note, \n";
    $sql .= "   t_payout_h.renew_flg, \n";
    $sql .= "   to_char(t_payout_h.renew_day,'yyyy-mm-dd') AS renew_day, \n";
    $sql .= "   t_payout_h.buy_id, \n";
    $sql .= "   t_payout_h.account_day, \n";
    $sql .= "   t_payout_h.payable_no \n";
    $sql .= "FROM \n";
    $sql .= "   t_payout_h \n";
    // 支払データ（手数料以外）
    $sql .= "   LEFT JOIN t_payout_d \n";
    $sql .= "       ON  t_payout_h.pay_id = t_payout_d.pay_id \n";
    $sql .= "       AND t_payout_d.trade_id != 48 \n";
    // 支払データ（手数料のみ)
    $sql .= "   LEFT JOIN t_payout_d AS t_payout_d_48 \n";
    $sql .= "       ON  t_payout_h.pay_id = t_payout_d_48.pay_id \n";
    $sql .= "       AND t_payout_d_48.trade_id = 48 \n";
    // 取引区分名（手数料以外の支払データに対して）
    $sql .= "   INNER JOIN t_trade \n";
    $sql .= "       ON t_payout_d.trade_id = t_trade.trade_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_payout_h.shop_id = $shop_id \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;

    // 全件数取得
    $res            = Db_Query($db_con, $sql.";");
    $total_count    = pg_num_rows($res);

    // LIMIT, OFFSET条件作成
    if ($post_flg == true && $err_flg != true){

        // 表示件数
        switch ($display_num){
            case "1":
                $limit = $total_count;
                break;  
            case "2":
                $limit = "100";
                break;  
        }  

        // 取得開始位置
        $offset = ($page_count != null) ? ($page_count - 1) * $limit : "0";

        // 行削除でページに表示するレコードが無くなる場合の対処
        if($page_count != null){
            // 行削除でtotal_countとoffsetの関係が崩れた場合
            if ($total_count <= $offset){
                // オフセットを選択件前に
                $offset     = $offset - $limit; 
                // 表示するページを1ページ前に（一気に2ページ分削除されていた場合などには対応してないです）
                $page_count = $page_count - 1;
                // 選択件数以下時はページ遷移を出力させない(nullにする)
                $page_count = ($total_count <= $display_num) ? null : $page_count;
            }       
        }else{  
            $offset = 0;
        }       

    }

    // ページ内データ取得
    $limit_offset   = ($limit != null) ? "LIMIT $limit OFFSET $offset " : null; 
    $res            = Db_Query($db_con, $sql.$limit_offset.";");
    $row_count      = pg_num_rows($res);
    $page_data      = Get_Data($res);

}

//echo $total_count_sql2;
//合計金額計算
for($i = 0; $i < $row_count; $i++){
    $sum1 = bcadd($sum1,$page_data[$i][14]);    //支払金額
    $sum2 = bcadd($sum2,$page_data[$i][15]);    //手数料
    $sum3 = bcadd($sum1,$sum2);                 //合計金額
} 

$order_delete  = " function Order_Delete(hidden1,hidden2,pay_id){\n";
$order_delete .= "    res = window.confirm(\"削除します。よろしいですか？\");\n";
$order_delete .= "    if (res == true){\n";
$order_delete .= "        var id = pay_id;\n";
$order_delete .= "        var hdn1 = hidden1;\n";
$order_delete .= "        var hdn2 = hidden2;\n";
$order_delete .= "        document.dateForm.elements[hdn1].value = 'true';\n";
$order_delete .= "        document.dateForm.elements[hdn2].value = id;\n";
$order_delete .= "        // 同じウィンドウで遷移する\n";
$order_delete .= "        document.dateForm.target=\"_self\";\n";
$order_delete .= "        // 自画面に遷移する\n";
$order_delete .= "        document.dateForm.action='".$_SERVER["PHP_SELF"]."';\n";
$order_delete .= "        // POST情報を送信する\n";
$order_delete .= "        document.dateForm.submit();\n";
$order_delete .= "        return true;\n";
$order_delete .= "    }else{\n";
$order_delete .= "        return false;\n";
$order_delete .= "    }\n";
$order_delete .= "}\n";

  
/****************************/
// HTML作成（検索部）
/****************************/
// 共通検索テーブル
$html_s  = Search_Table_Payout($form);
$html_s .= "<br style=\"font-size: 4px;\">\n";
// モジュール個別検索テーブル１
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">銀行</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_bank"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">支店</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_b_bank"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
// モジュール個別検索テーブル２
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">口座番号</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_account_no"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">手形券面番号</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_payable_no"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
// モジュール個別検索テーブル３
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">預金種目</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_deposit_kind"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">日次更新</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_renew"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
// モジュール個別検索テーブル４
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">取引区分</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_trade"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
// ボタン
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_display"]]->toHtml()."　\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["kuria"]]->toHtml()."\n";
$html_s .= "</td></tr></table>";


/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成
/****************************/
$page_menu = Create_Menu_h('buy','3');

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= Print_H_Link_Btn($form, $ary_h_btn_list);
$page_header = Create_Header($page_title);

/****************************/
// ページ作成
/****************************/
$html_page  = Html_Page2($total_count, $page_count, 1, $limit);
$html_page2 = Html_Page2($total_count, $page_count, 2, $limit);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form関連の変数をassign
$smarty->assign("form", $renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'      => "$html_header",
	'page_menu'        => "$page_menu",
	'page_header'      => "$page_header",
	'html_footer'      => "$html_footer",
	'html_page'        => "$html_page",
	'html_page2'       => "$html_page2",
    "pay_day_err"      => "$pay_day_err",
    "pay_all_day_err"  => "$pay_all_day_err",
    "input_day_err"    => "$input_day_err",
    "input_all_day_err"=> "$input_all_day_err",
    "total_count"      => "$total_count",
    "order_delete"     => "$order_delete",
    "sum1"             => "$sum1",
    "sum2"             => "$sum2",
    "sum3"             => "$sum3",
    "r"                => "$limit",
    "auth"             => $auth[0],
    "post_flg"          => "$post_flg",
    "err_flg"           => "$err_flg",
));
$smarty->assign('row',$page_data);

// htmlをassign
$smarty->assign("html", array(
    "html_s"    => $html_s,
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
