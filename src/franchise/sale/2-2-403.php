<?php

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/10/06      05-006      ふ          入金削除直前に日時更新処理が行われた場合の対処
 *  2006/10/10      05-012      ふ          削除後、リロードボタン押下時に同一IDの伝票があれば削除されてしまうバグを修正
 *  2007/01/25                  watanabe-k  ボタンの色変更 
 *  2007-04-06                  fukuda      検索条件復元処理追加
 *  2007-04-12                  fukuda      一覧の「金額」は「振込入金額」分を含まないよう修正
 *
 */

$page_title = "入金照会";

// 環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// テンプレート関数をレジスト
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

// DB接続
$db_con = Db_Connect();


/*****************************/
// 権限関連処理
/*****************************/
// 権限チェック
$auth   = Auth_Check($db_con);


/****************************/
// 検索条件復元関連
/****************************/
// 検索フォーム初期値配列
$ary_form_list = array(
    "form_display_num"      => "1", 
    "form_client_branch"    => "",  
    "form_attach_branch"    => "",  
    "form_client"           => array("cd1" => "", "cd2" => "", "name" => ""), 
    "form_collect_staff"    => array("cd" => "", "select" => ""), 
    "form_part"             => "",  
    "form_trade"            => "", 
    "form_multi_staff"      => "",  
    "form_payin_day"        => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))),
    "form_act_client"       => array("cd1" => "", "cd2" => "", "name" => "", "select" => array("0" => "", "1" => "")),
    "form_input_day"        => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""), 
    "form_payin_no"         => "",  
    "form_sum_amount"       => array("s" => "", "e" => ""),
    "form_bank"             => array("cd" => "", "name" => ""),
    "form_b_bank"           => array("cd" => "", "name" => ""),
    "form_account_no"       => "",
    "form_payable_no"       => "",
    "form_deposit_kind"     => "1",
    "form_renew"            => "1",
    "form_client_gr"        => array("name" => "", "select" => ""),
);

// 検索条件復元
Restore_Filter2($form, "payin", "form_show_btn", $ary_form_list);


/****************************/
// フォームデフォルト値設定
/****************************/
$form->setDefaults($ary_form_list);

$range          = null;     // LIMIT
$offset         = "0";      // OFFSET
$total_count    = "0";      // 全件数
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // 表示ページ数


/****************************/
// 外部変数取得
/****************************/
// SESSION
$shop_id        = $_SESSION["client_id"];           // ショップID
$group_kind     = $_SESSION["group_kind"];          // グループ種別


/****************************/
// フォームパーツ定義
/****************************/
/* 共通フォーム */
Search_Form_Payin($db_con, $form, $ary_form_list);

/* モジュール別フォーム */
// 入金番号
$obj    =   null;   
$obj[]  =&  $form->createElement("text", "s", "", "size=\"10\" maxlength=\"8\" class=\"ime_disabled\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", "〜");
$obj[]  =&  $form->createElement("text", "e", "", "size=\"10\" maxlength=\"8\" class=\"ime_disabled\" $g_form_option");
$form->addGroup($obj, "form_payin_no", "", "");

// 合計金額
Addelement_Money_Range($form, "form_sum_amount");

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

// グループ
$item   =   null; 
$item   =   Select_Get($db_con, "client_gr");
$obj    =   null;
$obj[]  =   $form->createElement("text", "name", "", "size=\"34\" maxLength=\"25\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", " ");
$obj[]  =   $form->createElement("select", "select", "",$item, $g_form_option_select);
$form->addGroup($obj, "form_client_gr", "", "");

// ソートリンク
$ary_sort_item = array(
    "sl_slip"           => "入金番号",
    "sl_payin_day"      => "入金日",
    "sl_input_day"      => "入力日",
    "sl_client_cd"      => "得意先コード",
    "sl_client_name"    => "得意先名",
    "sl_collect_staff"  => "集金担当者",
    "sl_act_client_cd"  => "代行店コード",
    "sl_act_client_name"=> "代行店名",
    "sl_bank_cd"        => "銀行コード",
    "sl_bank_name"      => "銀行名",
    "sl_b_bank_cd"      => "支店コード",
    "sl_b_bank_name"    => "支店名",
    "sl_deposit_kind"   => "預金種目",
    "sl_account_no"     => "口座番号",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_payin_day");

// 表示ボタン
$form->addElement("submit", "form_show_btn", "表　示");

// クリアボタン
$form->addElement("button", "form_clear_btn", "クリア", "onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

// ヘッダ部リンクボタン
$ary_h_btn_list = array("照会・変更" => $_SERVER["PHP_SELF"], "入　力" => "./2-2-402.php");
Make_H_Link_Btn($form, $ary_h_btn_list);

// 処理フラグ
$form->addElement("hidden", "hdn_del_id");              // 削除伝票ID
$form->addElement("hidden", "hdn_del_enter_date");      // 削除伝票作成日

// エラーセット用
$form->addElement("text", "err_daily_update");


/****************************/
// 削除リンク押下処理
/****************************/
// 削除hiddenに入金IDがsetされている場合
if ($_POST["hdn_del_id"] != null){

    // 削除フラグをtrueに
    $del_flg = true;

    // 対象レコードを確認
    $sql  = "SELECT ";
    $sql .= "   renew_flg ";
    $sql .= "FROM ";
    $sql .= "   t_payin_h ";
    $sql .= "WHERE ";
    $sql .= "   pay_id = ".$_POST["hdn_del_id"]." ";
    $sql .= "AND ";
    $sql .= "   enter_day = '".$_POST["hdn_del_enter_date"]."' ";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $renew_flg = pg_fetch_result($res, 0);
    }

    // 日次更新フラグがtrueの場合
    if ($renew_flg == "t"){
        // エラーをセット
        $form->setElementError("err_daily_update", "日次更新処理が行われているため、削除できません。");
    }

    // 日次更新フラグがfalseの場合
    if ($renew_flg == "f"){
        // 対象レコードを削除
        $sql  = "DELETE FROM ";
        $sql .= "   t_payin_h ";
        $sql .= "WHERE ";
        $sql .= "   pay_id = ".$_POST["hdn_del_id"]." ";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
    }

    // hiddenの削除IDデータをクリア
    $clear_del_data["hdn_del_id"]           = "";
    $clear_del_data["hdn_del_enter_date"]   = "";
    $form->setConstants($clear_del_data);

}


/****************************/
// 表示ボタン押下時
/****************************/
if ($_POST["form_show_btn"] != null){

    // 日付POSTデータの0埋め
    $_POST["form_payin_day"] = Str_Pad_Date($_POST["form_payin_day"]);
    $_POST["form_input_day"] = Str_Pad_Date($_POST["form_input_day"]);

    /****************************/
    // エラーチェック
    /****************************/
    // ■集金担当者
    $err_msg = "集金担当者 は数値のみ入力可能です。";
    Err_Chk_Num($form, "form_collect_staff", $err_msg);

    // ■複数選択
    $err_msg = "集金担当複数選択 は数値と「,」のみ入力可能です。";
    Err_Chk_Delimited($form, "form_multi_staff", $err_msg);

    // ■入金日
    $err_msg = "入金日 の日付が妥当ではありません。";
    Err_Chk_Date($form, "form_payin_day", $err_msg);

    // ■入力日
    $err_msg = "入力日 の日付が妥当ではありません。";
    Err_Chk_Date($form, "form_input_day", $err_msg);

    // ■入金番号
    $err_msg = "入金番号 は数値のみ入力可能です。";
    Err_Chk_Num($form, "form_payin_no", $err_msg);

    // ■合計金額
    $err_msg = "合計金額 は数値のみ入力可能です。";
    Err_Chk_Int($form, "form_sum_amount", $err_msg);

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
if (($_POST["form_show_btn"] != null && $err_flg != true) || ($_POST != null && $_POST["form_show_btn"] == null)){

    // 日付POSTデータの0埋め
    $_POST["form_payin_day"] = Str_Pad_Date($_POST["form_payin_day"]);
    $_POST["form_input_day"] = Str_Pad_Date($_POST["form_input_day"]);

    // 1. フォームの値を変数にセット
    // 2. SESSION（hidden用）の値（検索条件復元関数内でセット）を変数にセット
    // 一覧取得クエリ条件に使用
    $display_num            = $_POST["form_display_num"];
    $client_branch          = $_POST["form_client_branch"];
    $attach_branch          = $_POST["form_attach_branch"];
    $client_cd1             = $_POST["form_client"]["cd1"];
    $client_cd2             = $_POST["form_client"]["cd2"];
    $client_name            = $_POST["form_client"]["name"];
    $collect_staff_cd       = $_POST["form_collect_staff"]["cd"];
    $collect_staff_select   = $_POST["form_collect_staff"]["select"];
    $part                   = $_POST["form_part"];
    $trade                  = $_POST["form_trade"];
    $multi_staff            = $_POST["form_multi_staff"];
    $payin_day_sy           = $_POST["form_payin_day"]["sy"];
    $payin_day_sm           = $_POST["form_payin_day"]["sm"];
    $payin_day_sd           = $_POST["form_payin_day"]["sd"];
    $payin_day_ey           = $_POST["form_payin_day"]["ey"];
    $payin_day_em           = $_POST["form_payin_day"]["em"];
    $payin_day_ed           = $_POST["form_payin_day"]["ed"];
    $input_day_sy           = $_POST["form_input_day"]["sy"];
    $input_day_sm           = $_POST["form_input_day"]["sm"];
    $input_day_sd           = $_POST["form_input_day"]["sd"];
    $input_day_ey           = $_POST["form_input_day"]["ey"];
    $input_day_em           = $_POST["form_input_day"]["em"];
    $input_day_ed           = $_POST["form_input_day"]["ed"];
    $act_client_cd1         = $_POST["form_act_client"]["cd1"];
    $act_client_cd2         = $_POST["form_act_client"]["cd2"];
    $act_client_name        = $_POST["form_act_client"]["name"];
    $act_client_rank        = $_POST["form_act_client"]["select"]["0"];
    $act_client_select      = $_POST["form_act_client"]["select"]["1"];
    $payin_no_s             = $_POST["form_payin_no"]["s"];
    $payin_no_e             = $_POST["form_payin_no"]["e"];
    $sum_amount_s           = $_POST["form_sum_amount"]["s"];
    $sum_amount_e           = $_POST["form_sum_amount"]["e"];
    $bank_cd                = $_POST["form_bank"]["cd"];
    $bank_name              = $_POST["form_bank"]["name"];
    $b_bank_cd              = $_POST["form_b_bank"]["cd"];
    $b_bank_name            = $_POST["form_b_bank"]["name"];
    $account_no             = $_POST["form_account_no"];
    $payable_no             = $_POST["form_payable_no"];
    $deposit_kind           = $_POST["form_deposit_kind"];
    $renew                  = $_POST["form_renew"];
    $client_gr_name         = $_POST["form_client_gr"]["name"];
    $client_gr_select       = $_POST["form_client_gr"]["select"];

    // レンジ設定
    switch ($_POST["form_display_num"]){
        case "1":
            $range  = null;
            break;
        case "2":
            $range  = 100;
            break;
    }

    $post_flg = true;

}


/****************************/
// 一覧データ取得条件作成
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // 顧客担当支店
    $sql .= ($client_branch != null) ? "AND t_client.charge_branch_id = $client_branch \n" : null;
    // 所属本支店
    if ($attach_branch != null){
        $sql .= "AND \n";
        $sql .= "   t_payin_h.collect_staff_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_attach.staff_id \n";
        $sql .= "       FROM \n";
        $sql .= "           t_attach \n";
        $sql .= "           INNER JOIN t_part ON t_attach.part_id = t_part.part_id \n";
        $sql .= "       WHERE \n";
        $sql .= "           t_part.branch_id = $attach_branch \n";
        $sql .= "   ) \n";
    }
    // 得意先コード1
    $sql .= ($client_cd1 != null) ? "AND t_payin_h.client_cd1 LIKE '$client_cd1%' \n" : null;
    // 得意先コード2
    $sql .= ($client_cd2 != null) ? "AND t_payin_h.client_cd2 LIKE '$client_cd2%' \n"           : null;
    // 得意先名（略称）
    if ($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_payin_h.client_name  LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_payin_h.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_payin_h.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
    // 集金担当者コード
    $sql .= ($collect_staff_cd != null) ? "AND t_staff.charge_cd = '$collect_staff_cd' \n" : null;
    // 集金担当者セレクト
    $sql .= ($collect_staff_select != null) ? "AND t_payin_h.collect_staff_id = $collect_staff_select \n" : null;
    // 部署
    $sql .= ($part != null) ? "AND t_attach.part_id = $part \n" : null;
    // 取引区分
    if ($trade != null){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "(SELECT pay_id FROM t_payin_d WHERE trade_id = $trade) \n";
    }
    // 集金担当複数選択
    if ($multi_staff != null){
        $ary_multi_staff = explode(",", $multi_staff);
        $sql .= "AND \n";
        $sql .= "   t_staff.charge_cd IN (";
        foreach ($ary_multi_staff as $key => $value){
            $sql .= "'".trim($value)."'";
            $sql .= ($key+1 < count($ary_multi_staff)) ? ", " : ") \n";
        }
    }
    // 入金日（開始）
    $payin_day_s = $payin_day_sy."-".$payin_day_sm."-".$payin_day_sd;
    $sql .= ($payin_day_s != "--") ? "AND t_payin_h.pay_day >= '$payin_day_s' \n" : null;
    // 入金日（終了）
    $payin_day_e = $payin_day_ey."-".$payin_day_em."-".$payin_day_ed;
    $sql .= ($payin_day_e != "--") ? "AND t_payin_h.pay_day <= '$payin_day_e' \n" : null;
    // 入力日（開始）
    $input_day_s = $input_day_sy."-".$input_day_sm."-".$input_day_sd;
    $sql .= ($input_day_s != "--") ? "AND t_payin_h.input_day >= '$input_day_s' \n" : null;
    // 入力日（終了）
    $input_day_e = $input_day_ey."-".$input_day_em."-".$input_day_ed;
    $sql .= ($input_day_e != "--") ? "AND t_payin_h.input_day <= '$input_day_e' \n" : null;
    // 代行店コード1
    $sql .= ($act_client_cd1 != null) ? "AND t_payin_h.act_client_cd1 LIKE '$act_client_cd1%' \n" : null;
    // 代行店コード2
    $sql .= ($act_client_cd2 != null) ? "AND t_payin_h.act_client_cd2 LIKE '$act_client_cd2%' \n" : null;
    // 代行店名（略称）
    if ($act_client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_act_client.client_name  LIKE '%$act_client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_act_client.client_name2 LIKE '%$act_client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_act_client.client_cname LIKE '%$act_client_name%' \n";
        $sql .= "   ) \n";
    }
    // 代行店セレクト
    $sql .= ($act_client_select != null) ? "AND t_payin_h.act_client_id = $act_client_select \n" : null;
    // 入金番号（開始）
    $sql .= ($payin_no_s != null) ? "AND t_payin_h.pay_no >= '".str_pad($payin_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // 入金番号（終了）
    $sql .= ($payin_no_e != null) ? "AND t_payin_h.pay_no <= '".str_pad($payin_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // 合計金額（開始）
    $sql .= ($sum_amount_s != null) ? "AND pay_data.pay_amount >= '$sum_amount_s' \n" : null;
    // 合計金額（終了）
    $sql .= ($sum_amount_e != null) ? "AND pay_data.pay_amount <= '$sum_amount_e' \n" : null;
    // 銀行コード
    if ($bank_cd != null){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "   (SELECT pay_id FROM t_payin_d WHERE bank_cd LIKE '$bank_cd%') \n";
    }
    // 銀行名
    if ($bank_name != null){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "   (SELECT pay_id FROM t_payin_d WHERE bank_name LIKE '%$bank_name%') \n";
    }
    // 支店コード
    if ($b_bank_cd != null){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "   (SELECT pay_id FROM t_payin_d WHERE b_bank_cd LIKE '$b_bank_cd%') \n";
    }
    // 支店名
    if ($b_bank_name != null){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "   (SELECT pay_id FROM t_payin_d WHERE b_bank_name LIKE '%$b_bank_name%') \n";
    }
    // 口座番号
    if ($account_no != null){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "   (SELECT pay_id FROM t_payin_d WHERE account_no LIKE '$account_no%') \n";
    }
    // 手形券面番号
    if ($payable_no != null){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "   (SELECT pay_id FROM t_payin_d WHERE payable_no = '$payable_no') \n";
    }
    // 預金種目
    if ($deposit_kind == "2"){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "   (SELECT pay_id FROM t_payin_d WHERE deposit_kind = '1') \n";
    }else
    if ($deposit_kind == "3"){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "   (SELECT pay_id FROM t_payin_d WHERE deposit_kind = '2') \n";
    }
    // 日次更新
    if ($renew == "2"){
        $sql .= "AND t_payin_h.renew_flg = 'f' \n";
    }else
    if ($renew == "3"){
        $sql .= "AND t_payin_h.renew_flg = 't' \n";
    }
    // グループ名
    $sql .= ($client_gr_name != null) ? "AND t_client_gr.client_gr_name LIKE '%$client_gr_name%' \n" : null;
    // グループセレクト
    $sql .= ($client_gr_select != null) ? "AND t_client.client_gr_id = $client_gr_select \n" : null;

    // 変数詰め替え
    $where_sql = $sql;


    $sql = null;

    // ソート順
    switch ($_POST["hdn_sort_col"]){
        // 入金番号
        case "sl_slip":
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id \n";
            break;
        // 入金日
        case "sl_payin_day":
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;
        // 入力日
        case "sl_input_day":
            $sql .= "   t_payin_h.input_day, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;
        // 得意先コード
        case "sl_client_cd":
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id \n";
            break;
        // 得意先名
        case "sl_client_name":
            $sql .= "   t_payin_h.client_cname, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;
        // 集金担当者
        case "sl_collect_staff":
            $sql .= "   t_staff.charge_cd, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;
        // 代行店コード
        case "sl_act_client_cd":
            $sql .= "   t_payin_h.act_client_cd1, \n";
            $sql .= "   t_payin_h.act_client_cd2, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;
        // 代行店名
        case "sl_act_client_name":
            $sql .= "   t_payin_h.act_client_cname, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id \n";
            break;
        // 銀行コード
        case "sl_bank_cd":
            $sql .= "   t_payin_d.bank_cd, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;
        // 銀行名
        case "sl_bank_name":
            $sql .= "   t_payin_d.bank_name, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;
        // 支店コード
        case "sl_b_bank_cd":
            $sql .= "   t_payin_d.b_bank_cd, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;
        // 支店名
        case "sl_b_bank_name":
            $sql .= "   t_payin_d.b_bank_name, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;
        // 預金種目
        case "sl_deposit_kind":
            $sql .= "   t_payin_d.deposit_kind, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;
        // 支店名
        case "sl_account_no":
            $sql .= "   t_payin_d.account_no, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
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
    $sql .= "   t_payin_h.pay_id, \n";
    $sql .= "   t_payin_h.pay_no, \n";
    $sql .= "   t_payin_h.pay_day, \n";
    $sql .= "   t_payin_h.input_day, \n";
    $sql .= "   t_payin_h.client_cd1, \n";
    $sql .= "   t_payin_h.client_cd2, \n";
    $sql .= "   t_payin_h.client_cname, \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           trade_name \n";
    $sql .= "       FROM \n";
    $sql .= "           t_trade \n";
    $sql .= "       WHERE \n";
    $sql .= "           trade_id = t_payin_d.trade_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS trade_name, \n";
    $sql .= "   CASE t_payin_d.trade_id \n";
    $sql .= "       WHEN 32 THEN 0 \n";
    $sql .= "       ELSE t_payin_d.amount \n";
    $sql .= "   END \n";
    $sql .= "   AS amount, \n";
    $sql .= "   CASE t_payin_d.trade_id \n";
    $sql .= "       WHEN 32 THEN t_payin_d.amount \n";
    $sql .= "       ELSE 0 \n";
    $sql .= "   END \n";
    $sql .= "   AS bank_amount, \n";
    $sql .= "   trade_data.rebate_amount, \n";      // 手数料
    $sql .= "   pay_data.pay_amount, \n";           // 合計金額
    $sql .= "   t_payin_d.bank_cd, \n";
    $sql .= "   t_payin_d.bank_name, \n";
    $sql .= "   t_payin_d.b_bank_cd, \n";
    $sql .= "   t_payin_d.b_bank_name, \n";
    $sql .= "   CASE t_payin_d.deposit_kind \n";
    $sql .= "       WHEN '1' THEN '普通' \n";
    $sql .= "       WHEN '2' THEN '当座' \n";
    $sql .= "   END \n";
    $sql .= "   AS deposit, \n";
    $sql .= "   t_payin_d.account_no, \n";
    $sql .= "   t_payin_d.payable_day, \n";
    $sql .= "   t_payin_d.payable_no, \n";
    $sql .= "   t_payin_d.note, \n";
    $sql .= "   to_char(t_payin_h.renew_day, 'yyyy-mm-dd') AS renew_day, \n";
    $sql .= "   t_payin_h.sale_id, \n";
    $sql .= "   t_payin_h.collect_staff_name, \n";
    $sql .= "   t_payin_h.enter_day, \n";
    $sql .= "   bank_cd_35, \n";
    $sql .= "   bank_name_35, \n";
    $sql .= "   b_bank_cd_35, \n";
    $sql .= "   b_bank_name_35, \n";
    $sql .= "   CASE deposit_kind_35 \n";
    $sql .= "       WHEN '1' THEN '普通' \n";
    $sql .= "       WHEN '2' THEN '当座' \n";
    $sql .= "   END \n";
    $sql .= "   AS deposit_35, \n";
    $sql .= "   account_no_35, \n";
    $sql .= "   t_act_client.client_cd1 AS act_client_cd1, \n";
    $sql .= "   t_act_client.client_cd2 AS act_client_cd2, \n";
    $sql .= "   t_act_client.client_cname AS act_client_cname, \n";
    $sql .= "   t_payin_h.payin_div \n";
    $sql .= "FROM \n";
    // 入金ヘッダ
    $sql .= "   t_payin_h \n";
    // 入金データ（取引区分35「手数料」以外）
    $sql .= "   LEFT  JOIN t_payin_d  ON  t_payin_h.pay_id = t_payin_d.pay_id AND t_payin_d.trade_id != 35 \n";
    // 得意先マスタ
    $sql .= "   LEFT  JOIN t_client   ON  t_payin_h.client_id = t_client.client_id \n";
    // 得意先マスタ（代行店）
    $sql .= "   LEFT  JOIN t_client AS t_act_client ON t_payin_h.act_client_id = t_act_client.client_id \n";
    // スタッフマスタ
    $sql .= "   LEFT  JOIN t_staff    ON  t_payin_h.collect_staff_id = t_staff.staff_id \n";
    // 所属マスタ
    $sql .= "   LEFT  JOIN t_attach   ON  t_payin_h.collect_staff_id = t_attach.staff_id \n";
    $sql .= "                         AND t_attach.shop_id IN ".Rank_Sql2()." \n";
    // グループ
    $sql .= "   LEFT JOIN t_client_gr ON t_client.client_gr_id = t_client_gr.client_gr_id \n";
    // 入金データ（合計金額用）
    $sql .= "   INNER JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           pay_id, \n";
    $sql .= "           SUM(amount) AS pay_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payin_d \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           pay_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS pay_data \n";
    $sql .= "   ON t_payin_h.pay_id = pay_data.pay_id \n";
    // 入金データ（取引区分別用）
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_32.pay_id, \n";
    $sql .= "           t_32.amount AS bank_amount, \n";
    $sql .= "           t_35.amount AS rebate_amount, \n";
    $sql .= "           t_35.bank_cd AS bank_cd_35, \n";
    $sql .= "           t_35.bank_name AS bank_name_35, \n";
    $sql .= "           t_35.bank_cd AS b_bank_cd_35, \n";
    $sql .= "           t_35.bank_name AS b_bank_name_35, \n";
    $sql .= "           t_35.deposit_kind AS deposit_kind_35, \n";
    $sql .= "           t_35.account_no AS account_no_35 \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               SELECT \n";
    $sql .= "                   pay_id, \n";
    $sql .= "                   SUM (CASE WHEN trade_id = 32 THEN amount END) AS amount \n";
    $sql .= "               FROM \n";
    $sql .= "                   t_payin_d \n";
    $sql .= "               GROUP BY \n";
    $sql .= "                   pay_id \n";
    $sql .= "           ) AS t_32 \n";
    $sql .= "           LEFT JOIN \n";
    $sql .= "           ( \n";
    $sql .= "               SELECT \n";
    $sql .= "                   pay_id, \n";
    $sql .= "                   SUM(amount) AS amount, \n";
    $sql .= "                   bank_cd, \n";
    $sql .= "                   bank_name, \n";
    $sql .= "                   b_bank_cd, \n";
    $sql .= "                   b_bank_name, \n";
    $sql .= "                   deposit_kind, \n";
    $sql .= "                   account_no \n";
    $sql .= "               FROM \n";
    $sql .= "                   t_payin_d \n";
    $sql .= "               WHERE \n";
    $sql .= "                   trade_id = 35 \n";
    $sql .= "               GROUP BY \n";
    $sql .= "                   pay_id, \n";
    $sql .= "                   bank_cd, \n";
    $sql .= "                   bank_name, \n";
    $sql .= "                   b_bank_cd, \n";
    $sql .= "                   b_bank_name, \n";
    $sql .= "                   deposit_kind, \n";
    $sql .= "                   account_no \n";
    $sql .= "           ) AS t_35 \n";
    $sql .= "           ON t_32.pay_id = t_35.pay_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS trade_data \n";
    $sql .= "   ON t_payin_h.pay_id = trade_data.pay_id \n";
    $sql .= "WHERE \n";
    if ($group_kind == "2"){
    $sql .= "   t_payin_h.shop_id IN (".Rank_Sql().") \n";
    }else{  
    $sql .= "   t_payin_h.shop_id = $shop_id \n";
    }
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $all_num = pg_num_rows($res);
    if ($all_num > 0){
        for ($i=0; $i<$all_num; $i++){
            $data_list[$i] = pg_fetch_array($res, $i, PGSQL_ASSOC);
            foreach ($data_list[$i] as $key => $value){
                $ary_list_data[$i][$key] = htmlspecialchars($value);
            }
        }
    }

}


/****************************/
// ページ数遷移時の処理
/****************************/
// 表示ボタン未押下かつページPOSTがある場合
if ($_POST["form_show_btn"] == null && $_POST["f_page1"] != null && $_POST["f_page2"] != null){

    // hiddenにセットしてある検索条件を使用
    $where_sql  = stripslashes($_POST["hdn_where_sql"]);

    // オフセット値設定
    $offset = ($range != null) ? $page_count * $range - $range : 0;

}


/****************************/
// 全取得結果の整形
/****************************/
// エラーのない場合
if ($post_flg == true && $form_err_flg != true){

// rowspan用変数初期設定
$rowspan_num    = 1;
// 行番号用変数初期設定
$row_num        = 1;

// 取得レコード数分ループ
for ($i=0; $i<$all_num; $i++){

    // rowspan
    $all_list_data[$i][0] = ($ary_list_data[$i]["pay_id"] == $ary_list_data[$i-1]["pay_id"] || $i == 0) ? 0 : 1;
    if ($ary_list_data[$i]["pay_id"] != $ary_list_data[$i+1]["pay_id"]){
        $all_list_data[$i-$rowspan_num+1][0] = $rowspan_num;
        $rowspan_num = 1;
    }else{
        $rowspan_num++;
    }
    // 行番号
    $all_list_data[$i][1] = $row_num;
    ($ary_list_data[$i]["pay_id"] != $ary_list_data[$i+1]["pay_id"]) ? $row_num++ : $row_num;
    // 入金ID
    $all_list_data[$i][2]   = $ary_list_data[$i]["pay_id"];
    // 入金番号
    $all_list_data[$i][3]   = $ary_list_data[$i]["pay_no"];
    // 入金日・入力日
    $all_list_data[$i][4]   = $ary_list_data[$i]["pay_day"]."<br>".
                              $ary_list_data[$i]["input_day"];
    // 得意先コード・得意先名
    $all_list_data[$i][5]   = $ary_list_data[$i]["client_cd1"]."-".
                              $ary_list_data[$i]["client_cd2"]."<br>".
                              $ary_list_data[$i]["client_cname"];
    // 代行店コード・代行店名
    $all_list_data[$i][19]  = $ary_list_data[$i]["act_client_cd1"]."-".
                              $ary_list_data[$i]["act_client_cd2"]."<br>".
                              $ary_list_data[$i]["act_client_cname"];
    // 取引区分
    $all_list_data[$i][6]   = $ary_list_data[$i]["trade_name"];
    // 集金担当者
    $all_list_data[$i][17]  = $ary_list_data[$i]["collect_staff_name"];
    // 金額
    $all_list_data[$i][7]   = $ary_list_data[$i]["amount"];
    // 振込入金額
    $all_list_data[$i][9]   = $ary_list_data[$i]["bank_amount"];
    // 手数料
    $all_list_data[$i][18]  = $ary_list_data[$i]["rebate_amount"];
    // 合計金額
    $all_list_data[$i][8]   = $ary_list_data[$i]["pay_amount"];
    // 銀行コード・銀行名
    $all_list_data[$i][10]  = ($ary_list_data[$i]["trade_name"] != null)
                            ? $ary_list_data[$i]["bank_cd"]."<br>".$ary_list_data[$i]["bank_name"]."<br>"
                            : $ary_list_data[$i]["bank_cd_35"]."<br>".$ary_list_data[$i]["bank_name_35"]."<br>";
    // 支店コード・支店名
    $all_list_data[$i][11]  = ($ary_list_data[$i]["trade_name"] != null)
                            ? $ary_list_data[$i]["b_bank_cd"]."<br>".$ary_list_data[$i]["b_bank_name"]."<br>"
                            : $ary_list_data[$i]["b_bank_cd_35"]."<br>".$ary_list_data[$i]["b_bank_name_35"]."<br>";
    // 口座番号
    $all_list_data[$i][12]  = ($ary_list_data[$i]["trade_name"] != null)
                            ? $ary_list_data[$i]["deposit"]."<br>".$ary_list_data[$i]["account_no"]."<br>"
                            : $ary_list_data[$i]["deposit_35"]."<br>".$ary_list_data[$i]["account_no_35"]."<br>";
    // 手形期日・手形券面番号
    $all_list_data[$i][13]  = $ary_list_data[$i]["payable_day"]."<br>".
                              $ary_list_data[$i]["payable_no"]."<br>";
    // 備考
    $all_list_data[$i][14]  = $ary_list_data[$i]["note"];
    // 日次更新
    $all_list_data[$i][15]  = $ary_list_data[$i]["renew_day"];
    // 削除
    $all_list_data[$i][16]  = ($ary_list_data[$i]["sale_id"] != null) ? "削除Link" : null;

    // 伝票作成日時
    $enter_date[$i]         = $ary_list_data[$i]["enter_day"];
    // 入金区分
    $all_list_data[$i][20]  = $ary_list_data[$i]["payin_div"];

}


// レコード件数（行番号最大値-1）
$total_count = $row_num-1;

}


/****************************/
// 行削除時に表示するレコードが無くなる場合の対処
/****************************/
// 行削除でtotal_countとoffsetの関係が崩れた場合
if ($post_flg == true && $total_count == $offset){
    // オフセットを選択件前に
    $offset     = $offset-$range;
    // 表示するページを1ページ前に
    $page_count = $page_count-1;
    // 選択件数以下時はページ遷移を出力させない(nullにする)
    $page_count = ($total_count <= $range) ? null : $page_count;
}


/****************************/
// エラー時の件数
/****************************/
if ($form_err_flg == true){

    $total_count    = 0;
    $page_count     = 0;

}


/****************************/
// 整形済データから表示用データの抜き出し
/****************************/
// エラーのない場合
if ($post_flg == true && $form_err_flg != true){

// ループカウンタセット
$j = 0;
// 合計金額用変数初期設定
$sum_amount = 0;

// 取得レコード数分ループ
for ($i=0; $i<$all_num; $i++){

    // 取得最大行数（行番号）
    $limit = ($range != null) ? $offset+$range : $all_num;

    // OFFSET < 整形時に採番した行番号 <= OFFSET+LIMIT の場合
    if ($offset < $all_list_data[$i][1] && $all_list_data[$i][1] <= $limit){
        // 取得レコードを、OFFSET, OFFSET+LIMITの範囲内でループ
        foreach ($all_list_data[$i] as $key => $value){
            // データを一覧表示用配列へ代入
            $disp_list_data[$j][$key] = $value;
            // 金額を算出
            $calc_sum           += ($key == 7) ? $value : 0;
            // 振込入金額合計を算出
            $calc_sum_bank      += ($key == 9) ? $value : 0;
            // pay_idが前回参照レコードと異なる場合
            if ($all_list_data[$i][2] != $all_list_data[$i-1][2]){
                // 手数料合計を算出
                $calc_sum_rebate    += ($key == 18) ? $value : 0;
                // 金額合計の合計を算出
                $calc_sum_amount    += ($key == 8) ? $value : 0;
            }
        }

        /****************************/
        // 可変フォームパーツ定義
        /****************************/
        // 削除リンク
        // 表示権限のみ時は表示しない
        $del_str = ($auth[0] == "w") ? "削除" : null;
        // rowspan用の値が0で無い、かつ日次更新日が無い、かつ売上IDが無い場合
        if ($all_list_data[$i][0] != 0 && $all_list_data[$i][15] == null && $ary_list_data[$i]["sale_id"] == null){
            $form->addElement("link", "form_del_link[$j]", "", "#", "$del_str", 
                "TABINDEX=-1 onClick=\"javascript:Dialogue_5('削除します。', '".$all_list_data[$i][2]."', 'hdn_del_id', '".$enter_date[$i]."', 'hdn_del_enter_date', '".$_SERVER["PHP_SELF"]."'); return false;\""
            );
        }

        // ループカウンタ+1
        $j++;

    }

}

}


/****************************/
// HTML作成（検索部）
/****************************/
// 共通検索テーブル
$html_s  = Search_Table_Payin($form);
$html_s .= "<br style=\"font-size: 4px;\">\n";
// モジュール個別検索テーブル１
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"130px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">入金番号</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_payin_no"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">合計金額</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_sum_amount"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
// モジュール個別検索テーブル２
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"130px\" style=\"font-weight: bold;\">\n";
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
// モジュール個別検索テーブル３
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"130px\" style=\"font-weight: bold;\">\n";
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
// モジュール個別検索テーブル４
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"130px\" style=\"font-weight: bold;\">\n";
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
// モジュール個別検索テーブル５
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"736px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">グループ</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_client_gr"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
// ボタン
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_show_btn"]]->toHtml()."　\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_clear_btn"]]->toHtml()."\n";
$html_s .= "</td></tr></table>";
$html_s .= "\n";


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
$page_menu = Create_Menu_f("sale", "4");

/****************************/
// 画面ヘッダー作成
/****************************/
$page_title .= Print_H_Link_Btn($form, $ary_h_btn_list);
$page_header = Create_Header($page_title);

/****************************/
// ページ作成
/****************************/
$range = ($range != null) ? $range : $all_num;
$html_page  = Html_Page2($total_count, $page_count, 1, $range);
$html_page2 = Html_Page2($total_count, $page_count, 2, $range);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form関連の変数をassign
$smarty->assign("form", $renderer->toArray());

// その他の変数をassign
$smarty->assign("var", array(
	"html_header"       => "$html_header",
	"page_menu"         => "$page_menu",
	"page_header"       => "$page_header",
	"html_footer"       => "$html_footer",
	"html_page"         => "$html_page",
	"html_page2"        => "$html_page2",
    "calc_sum"          => $calc_sum,
    "calc_sum_amount"   => $calc_sum_amount,
    "calc_sum_bank"     => $calc_sum_bank,
    "calc_sum_rebate"   => $calc_sum_rebate,
    "group_kind"        => "$group_kind",
    "post_flg"          => $post_flg,
    "err_flg"           => $err_flg,
));

// htmlをassign
$smarty->assign("html", array(
    "html_s"        =>  $html_s,
));

$smarty->assign("disp_list_data", $disp_list_data);

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
