<?php
/**
 * 売上伝票確定処理
 *
 *
 * 変更履歴
 *    1.0.0 (2006//) (suzuki takaaki)
 *      ・新規作成
 *    1.0.1 (2006/07/26) (kaji)
 *      ・1ページの表示件数を100件に変更
 *    (2006/07/27) (watanabe-k)
 *      ・略称表示するように変更
 *    1.0.3 (2006/09/06) (kaji)
 *      ・削除伝票は一覧に表示しないように変更
 *      ・保留伝票変更への遷移を変更
 *    1.0.4 (2006/09/20) (kaji)
 *      ・月次更新、請求締処理より先の日付かチェック処理追加
 *    1.0.5 (2006/09/30) (kaji)
 *      ・請求締日以前の請求日のデータがあった場合のエラーメッセージ変更
 *    2006/10/10 (suzuki)
 *      ・０件を表示し、再度検索するとエラーになるのを修正
 *    2006/10/26 (suzuki)
 *      ・売上率が0%の担当者も表示するように変更
 *      ・巡回担当者（メイン）のみ表示
 *    2006-11-02 ・カレンダー表示期間分表示<suzuki>
 *    2006-12-04 ・商品分類名・正式名称の抽出SQLを変更<suzuki>
 *               ・チェックを付けた伝票の金額を表示<suzuki>
 *    2006-12-05 ・確定された伝票は合計金額を計算しないように修正<suzuki>
 *    2006/12/14  ページ処理修正 suzuki
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/11      03-017      kajioka-h   配送日にシステム開始日以前の日付がないかチェック追加
 *                  03-018      kajioka-h   請求日にシステム開始日以前の日付がないかチェック追加
 *                  03-020      kajioka-h   確定直前に確定されていないかチェック処理追加
 *                  03-021      kajioka-h   確定直前に保留削除されていないかチェック処理追加
 *  2006-12-08      03-0102     suzuki      日付をゼロ埋め
 *  2006-12-27                  watanabe-k  部署での検索機能を追加
 *                  0006        kajioka-h   部署で検索すると、他の検索条件が反映されないバグ修正
 *                              kajioka-h   ソート順を配送日、担当者CD、得意先CD、伝票番号に変更
 *  2007-01-05                  kajioka-h   部署での検索条件を持たせるhiddenがなかったのを追加
 *  2007/02/19      要件5-1     kajioka-h   商品出荷予定で在庫移動未実施の予定データが選択されていた場合に警告メッセージを表示する処理追加
 *  2007/02/21                  watanage-k  基本出荷倉庫ではなく拠点倉庫を使用するように修正
 *  2007/02/23      B0702-008   kajioka-h   商品予定出荷で在庫移動したかどうかの判定ミス修正
 *  2007/03/02                  watanabe-k  ボタン名と画面名の変更
 *  2007/03/05      作業項目12  ふくだ      掛・現金の合計を出力
 *  2007/03/05      B0702-013   kajioka-h   商品予定出荷していない伝票の伝票番号が重複して表示されるバグ修正
 *  2007/03/22      要件21      kajioka-h   保留区分の検索条件、一覧の表示を削除
 *  2007/03/23                  kajioka-h   確定処理部分を include/fc_sale_confirm.inc に出した
 *  2007/03/27                  watanabe-k  巡回担当者のリストをスタッフマスタを元に作成するように修正
 *  2007/04/05      その他25    kajioka-h   紹介料を本部の仕入する場合のチェック処理追加
 *  2007-04-09                  fukuda      検索条件復元処理追加
 *  2007-04-09                  fukuda      検索項目共通化
 *  2007-04-13                  fukuda      「変更」リンクと列タイトルを「変更／削除」に修正
 *  2007-04-23      その他167   fukuda      発行状況の検索項目を削除し、確定処理の検索項目を追加
 *  2007-04-23      その他167   fukuda      ↑に合わせて、確定済伝票も抽出するよう修正
 *  2007-06-07                  fukuda      一覧テーブルに前受相殺額を追加
 *  2007-06-20                  fukuda      一覧テーブルの列でソート機能追加
 *  2007/06/25                  fukuda      確定時に予定巡回日が未来の場合はエラー
 *
 */

$page_title = "予定伝票売上確定";

// 環境設定ファイル
require_once("ENV_local.php");

// 確定処理関数定義
require_once(PATH ."function/trade_fc.fnc");
require_once(INCLUDE_DIR."common_quickform.inc");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// 削除ボタンDisabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;


/****************************/
// 検索条件復元関連
/****************************/
// 検索フォーム初期値配列
$ary_form_list = array(
    "form_display_num"  => "1",
    "form_client_branch"=> "",
    "form_attach_branch"=> "",
    "form_client"       => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_round_staff"  => array("cd" => "", "select" => ""),
    "form_part"         => "",
    "form_claim"        => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_multi_staff"  => "",
    "form_ware"         => "",
    "form_round_day"    => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))),
    "form_claim_day"    => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_slip_type"    => "1",
//    "form_out_state"    => "1",
    "form_slip_state"   => "2",
    "form_slip_no"      => array("s" => "", "e" => ""),
);

// 合計・確定ボタン押下時
if ($_POST["sum_flg"] == "true" || $_POST["confirm_flg"] == "true"){
    // チェック状態をSESSIONに保持しておく
    $_SESSION[Get_Mod_No()]["all"]["form_slip_check"] = $_POST["form_slip_check"];
}

// 最遷移時
if ($_GET["search"] == "1"){
    // 保持しておいたSESSIONをPOSTにセットする用の配列を作成
    $ary_pass_list = array(
        "form_slip_check"   => $_SESSION[Get_Mod_No()]["all"]["form_slip_check"],
    );
}

// 検索条件復元
Restore_Filter2($form, "contract", "form_display", $ary_form_list, $ary_pass_list);


/****************************/
// 外部変数取得
/****************************/
$shop_id     = $_SESSION["client_id"];    //ログインID
$staff_id    = $_SESSION["staff_id"];     //ログイン者ID
$staff_name  = $_SESSION["staff_name"];   //ログイン者名


/****************************/
// 初期表示
/****************************/
$limit          = null;     // LIMIT
$offset         = "0";      // OFFSET
$total_count    = "0";      // 全件数
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // 表示ページ数


/****************************/
// フォームパーツ定義
/****************************/
/* 共通フォーム */
Search_Form($db_con, $form, $ary_form_list);

// 不要モジュールの削除
$form->removeElement("form_charge_fc");

/* モジュール別フォーム */
// 伝票形式
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "全て",      "1");
$obj[]  =&  $form->createElement("radio", null, null, "自社伝票",  "2");
$obj[]  =&  $form->createElement("radio", null, null, "指定伝票",  "3");
$form->addGroup($obj, "form_slip_type", "", "");

/*
// 発行状況
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "全て",    "1");
$obj[]  =&  $form->createElement("radio", null, null, "発行済",  "2");
$obj[]  =&  $form->createElement("radio", null, null, "未発行",  "3");
$form->addGroup($obj, "form_out_state", "", "");
*/

// 確定処理
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "全て",    "1");
$obj[]  =&  $form->createElement("radio", null, null, "未確定",  "2");
$obj[]  =&  $form->createElement("radio", null, null, "確定済",  "3");
$form->addGroup($obj, "form_slip_state", "", "");

// 伝票番号（開始〜終了）
$obj    =   null;   
$obj[]  =&  $form->createElement("text", "s", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", "〜");
$obj[]  =&  $form->createElement("text", "e", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");
$form->addGroup($obj, "form_slip_no", "", "");

// ソートリンク
$ary_sort_item = array(
    "sl_client_cd"      => "得意先コード",
    "sl_client_name"    => "得意先名",
    "sl_slip"           => "伝票番号",
    "sl_arrival_day"    => "巡回配送日",
    "sl_round_staff"    => "巡回担当者<br>（メイン１）",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_arrival_day");

// 表示ボタン
$form->addElement("submit", "form_display", "表　示");

// クリアボタン
$form->addElement("button", "form_clear", "クリア", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// 確定ボタン
$form->addElement("button", "form_confirm", "確　定",
    "onClick=\"javascript: Button_Submit('confirm_flg', '".$_SERVER["PHP_SELF"]."', true);\" $disabled"
);

// 合計ボタン
$form->addElement("button", "form_sum", "合　計",
    "onClick=\"javascript: Button_Submit('sum_flg','".$_SERVER["PHP_SELF"]."#sum', true);\""
);

// 予定伝票売上確定リンクボタン
$form->addElement("button", "comp_button", "予定伝票売上確定", "$g_button_color onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

// 委託巡回/受託巡回リンクボタン
if ($_SESSION["group_kind"] == "2"){
    $form->addElement("button", "act_button", "委託巡回", "onClick=\"location.href='../system/2-1-237.php'\"");
}else{
    $form->addElement("button", "act_button", "受託巡回", "onClick=\"location.href='../system/2-1-238.php'\"");
}

// 処理フラグ
$form->addElement("hidden", "confirm_flg");  // 確定フラグ
$form->addElement("hidden", "sum_flg");      // 合計フラグ


/****************************/
// 合計ボタン押下時
/****************************/
if ($_POST["sum_flg"] == "true"){

    $con_data["sum_flg"] = "";   // 合計ボタン初期化

    $output_id_array = $_POST["output_id_array"];  // 受注ID配列
    $check_num_array = $_POST["form_slip_check"];  // 伝票チェック

    // 伝票にチェックがある場合に行う
    if ($check_num_array != null){
        $aord_array = null;    // 伝票出力受注ID配列
        while ($check_num = each($check_num_array)){
            // この添字の受注IDを使用する
            $check = $check_num[0];
            if ($check_num[1] == "1"){  // 4/23 fukuda
                $aord_array[] = $output_id_array[$check];
            }
        }
    }

    if (count($aord_array) > 0){

        // チェックのついた伝票でループ
        for ($s = 0; $s < count($aord_array); $s++){
            $aord_text .= $aord_array[$s];
            $aord_text .= ($s+1 < count($aord_array)) ? ", " : null;
        }

        // 金額データ取得
        $sql  = "SELECT \n";
        $sql .= "   SUM(CASE t_trade.trade_id WHEN 11 THEN t_aorder_h.net_amount ELSE 0 END) AS kake_notax, \n";
        $sql .= "   SUM(CASE t_trade.trade_id WHEN 61 THEN t_aorder_h.net_amount ELSE 0 END) AS genkin_notax, \n";
        $sql .= "   SUM(CASE t_trade.trade_id WHEN 11 THEN t_aorder_h.tax_amount ELSE 0 END) AS kake_tax, \n";
        $sql .= "   SUM(CASE t_trade.trade_id WHEN 61 THEN t_aorder_h.tax_amount ELSE 0 END) AS genkin_tax, \n";
        $sql .= "   SUM(CASE t_trade.trade_id WHEN 11 THEN t_aorder_h.net_amount + t_aorder_h.tax_amount ELSE 0 END) AS kake_ontax, \n";
        $sql .= "   SUM(CASE t_trade.trade_id WHEN 61 THEN t_aorder_h.net_amount + t_aorder_h.tax_amount ELSE 0 END) AS genkin_ontax \n";
        $sql .= "FROM \n";
        $sql .= "   t_aorder_h \n";
        $sql .= "   INNER JOIN t_trade ON t_aorder_h.trade_id = t_trade.trade_id \n";
        $sql .= "WHERE \n";
        $sql .= "   t_aorder_h.aord_id IN ($aord_text) \n";
        $sql .= ";";
        $res = Db_Query($db_con, $sql);
        $money_data = Get_Data($res, 2, "ASSOC");

        // 金額形式変更
        $kake_notax     = $money_data[0]["kake_notax"];
        $genkin_notax   = $money_data[0]["genkin_notax"];
        $kake_tax       = $money_data[0]["kake_tax"];
        $genkin_tax     = $money_data[0]["genkin_tax"];
        $kake_ontax     = $money_data[0]["kake_ontax"];
        $genkin_ontax   = $money_data[0]["genkin_ontax"];
        $notax_amount   = $money_data[0]["kake_notax"] + $money_data[0]["genkin_notax"];
        $tax_amount     = $money_data[0]["kake_tax"]   + $money_data[0]["genkin_tax"];
        $ontax_amount   = $money_data[0]["kake_ontax"] + $money_data[0]["genkin_ontax"];

    }

}


/****************************/
// 確定ボタン押下処理
/****************************/
if ($_POST["confirm_flg"] == "true" || $_POST["warn_confirm_flg"] == "true"){

    $con_data["confirm_flg"] = "";                  // 確定ボタン初期化

    $output_id_array = $_POST["output_id_array"];   // 受注ID配列
    $check_num_array = $_POST["form_slip_check"];   // 伝票チェック

    $alert_flg = false;

    //伝票にチェックがある場合に行う
    if ($check_num_array != null){
        $aord_array = null;    //伝票出力受注ID配列
        while ($check_num = each($check_num_array)){
            //この添字の受注IDを使用する
            $check = $check_num[0];
            if ($check_num[1] == "1"){  // 4/23 fukuda
                $aord_array[] = $output_id_array[$check];
            }
        }
    }

    require(INCLUDE_DIR."fc_sale_confirm.inc");

    // 確定エラーフラグ
    if (
        $move_warning           != null ||
        $error_pay              != null ||
        $error_buy              != null ||
        $deli_day_renew_err     != null ||
        $deli_day_start_err     != null ||
        $claim_day_renew_err    != null ||
        $claim_day_bill_err     != null ||
        $claim_day_start_err    != null ||
        $confirm_err            != null ||
        $del_err                != null ||
        $buy_err_mess1          != null ||
        $buy_err_mess2          != null ||
        $buy_err_mess3          != null ||
        $err_trade_advance_msg  != null ||
        $err_future_date_msg    != null ||
        $err_advance_fix        != null ||
        $err_paucity_advance_msg!= null
    ){
        $confirm_err_flg = true;
    }

}


/****************************/
// 表示ボタン押下時
/****************************/
if ($_POST["form_display"] != null){

    // 日付POSTデータの0埋め
    $_POST["form_round_day"] = Str_Pad_Date($_POST["form_round_day"]);
    $_POST["form_claim_day"] = Str_Pad_Date($_POST["form_claim_day"]);

    /****************************/
    // エラーチェック
    /****************************/
    // ■共通フォームチェック
    Search_Err_Chk($form);

    // ■請求番号
    // エラーメッセージ
    $err_msg = "伝票番号 は数値のみ入力可能です。";
    Err_Chk_Num($form, "form_slip_no", $err_msg);

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
// 2. ページ切り替え時、その他のPOST時
/****************************/
if (($_POST["form_display"] != null && $err_flg != true) || ($_POST != null && $_POST["form_display"] == null)){

    // 日付POSTデータの0埋め
    $_POST["form_claim_day"] = Str_Pad_Date($_POST["form_claim_day"]);
    $_POST["form_round_day"] = Str_Pad_Date($_POST["form_round_day"]);

    // 1. フォームの値を変数にセット
    // 2. SESSION（hidden用）の値（検索条件復元関数内でセット）を変数にセット
    // 一覧取得クエリ条件に使用
    $display_num        = $_POST["form_display_num"];
    $client_branch      = $_POST["form_client_branch"];
    $attach_branch      = $_POST["form_attach_branch"];
    $client_cd1         = $_POST["form_client"]["cd1"];
    $client_cd2         = $_POST["form_client"]["cd2"];
    $client_name        = $_POST["form_client"]["name"];
    $round_staff_cd     = $_POST["form_round_staff"]["cd"];
    $round_staff_select = $_POST["form_round_staff"]["select"];
    $part               = $_POST["form_part"];
    $claim_cd1          = $_POST["form_claim"]["cd1"];
    $claim_cd2          = $_POST["form_claim"]["cd2"];
    $claim_name         = $_POST["form_claim"]["name"];
    $multi_staff        = $_POST["form_multi_staff"];
    $ware               = $_POST["form_ware"];
    $round_day_sy       = $_POST["form_round_day"]["sy"];
    $round_day_sm       = $_POST["form_round_day"]["sm"];
    $round_day_sd       = $_POST["form_round_day"]["sd"];
    $round_day_ey       = $_POST["form_round_day"]["ey"];
    $round_day_em       = $_POST["form_round_day"]["em"];
    $round_day_ed       = $_POST["form_round_day"]["ed"];
    $claim_day_sy       = $_POST["form_claim_day"]["sy"];
    $claim_day_sm       = $_POST["form_claim_day"]["sm"];
    $claim_day_sd       = $_POST["form_claim_day"]["sd"];
    $claim_day_ey       = $_POST["form_claim_day"]["ey"];
    $claim_day_em       = $_POST["form_claim_day"]["em"];
    $claim_day_ed       = $_POST["form_claim_day"]["ed"];
    $slip_type          = $_POST["form_slip_type"];
//    $out_state          = $_POST["form_out_state"];
    $slip_state         = $_POST["form_slip_state"];
    $slip_no_s          = $_POST["form_slip_no"]["s"];
    $slip_no_e          = $_POST["form_slip_no"]["e"];

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
        $sql .= "   t_staff_main.staff_id IN \n";
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
    $sql .= ($client_cd1 != null) ? "AND t_aorder_h.client_cd1 LIKE '$client_cd1%' \n" : null;
    // 得意先コード2
    $sql .= ($client_cd2 != null) ? "AND t_aorder_h.client_cd2 LIKE '$client_cd2%' \n" : null;
    // 得意先名
    if ($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_aorder_h.client_name  LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_aorder_h.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_aorder_h.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
    // 巡回担当者コード
    $sql .= ($round_staff_cd != null) ? "AND t_staff_main.charge_cd = '$round_staff_cd' \n" : null;
    // 巡回担当者セレクト
    $sql .= ($round_staff_select != null) ? "AND t_staff_main.staff_id = $round_staff_select \n" : null;
    // 部署
    $sql .= ($part != null) ? "AND t_staff_main.part_id = $part \n" : null;
    // 請求先コード１   
    $sql .= ($claim_cd1 != null) ? "AND t_client_claim.client_cd1 LIKE '$claim_cd1%' \n" : null;
    // 請求先コード２
    $sql .= ($claim_cd2 != null) ? "AND t_client_claim.client_cd2 LIKE '$claim_cd2%' \n" : null;
    // 請求先名
    if ($claim_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_client_claim.client_name  LIKE '%$claim_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client_claim.client_name2 LIKE '%$claim_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client_claim.client_cname LIKE '%$claim_name%' \n";
        $sql .= "   ) \n";
    }
    // 複数選択
    if ($multi_staff != null){
        $ary_multi_staff = explode(",", $multi_staff);
        $sql .= "AND \n";
        $sql .= "   t_staff_main.charge_cd IN (";
        foreach ($ary_multi_staff as $key => $value){
            $sql .= "'".trim($value)."'";
            $sql .= ($key+1 < count($ary_multi_staff)) ? ", " : ") \n";
        }
    }
    // 倉庫
    $sql .= ($ware != null) ? "AND t_aorder_h.ware_id = $ware \n" : null;
    // 予定巡回日（開始）
    $round_day_s = $round_day_sy."-".$round_day_sm."-".$round_day_sd;
    $sql .= ($round_day_s != "--") ? "AND t_aorder_h.ord_time >= '$round_day_s' \n" : null;
    // 予定巡回日（終了）
    $round_day_e = $round_day_ey."-".$round_day_em."-".$round_day_ed;
    $sql .= ($round_day_e != "--") ? "AND t_aorder_h.ord_time <= '$round_day_e' \n" : null;
    // 請求日（開始）
    $claim_day_s  = $claim_day_sy."-".$claim_day_sm."-".$claim_day_sd;
    $sql .= ($claim_day_s != "--") ? "AND t_aorder_h.arrival_day >= '$claim_day_s' \n" : null;
    // 請求日（終了）
    $claim_day_e  = $claim_day_ey."-".$claim_day_em."-".$claim_day_ed;
    $sql .= ($claim_day_e != "--") ? "AND t_aorder_h.arrival_day <= '$claim_day_e' \n" : null;
    // 伝票形式
    if ($slip_type == "2"){
        $sql .= "AND t_aorder_h.slip_out = '1' \n";
    }else
    if ($slip_type == "3"){
        $sql .= "AND t_aorder_h.slip_out = '2' \n";
    }
/*
    // 発行状況
    if ($out_state == "2"){
        $sql .= "AND t_aorder_h.slip_flg = 't' \n";
    }else
    if ($out_state == "3"){
        $sql .= "AND t_aorder_h.slip_flg = 'f' \n";
    }
*/
    // 確定処理
    if ($slip_state == "2"){
        $sql .= "AND t_aorder_h.confirm_flg = 'f' \n";
    }else
    if ($slip_state == "3"){
        $sql .= "AND t_aorder_h.confirm_flg = 't' \n";
    }
    // 伝票番号（開始）
    $sql .= ($slip_no_s != null) ? "AND t_aorder_h.ord_no >= '".str_pad($slip_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // 伝票番号（終了）
    $sql .= ($slip_no_e != null) ? "AND t_aorder_h.ord_no <= '".str_pad($slip_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;

    // 変数詰め替え
    $where_sql = $sql;


    $sql = null;

    // ソート順
    switch ($_POST["hdn_sort_col"]){
        // 得意先コード
        case "sl_client_cd":
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_staff_main.charge_cd, \n";
            $sql .= "   t_aorder_h.ord_no \n";
            break;
        // 得意先名
        case "sl_client_name":
            $sql .= "   t_aorder_h.client_cname, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_staff_main.charge_cd, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_no \n";
            break;
        // 伝票番号
        case "sl_slip":
            $sql .= "   t_aorder_h.ord_no \n";
            break;
        // 予定巡回日
        case "sl_arrival_day":
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_staff_main.charge_cd, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_no \n";
            break;
        // 巡回担当者（メイン１）
        case "sl_round_staff":
            $sql .= "   t_staff_main.charge_cd, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_no \n";
            break;
    }

    // 変数詰め替え
    $order_sql = $sql;

}


/****************************/
// 一覧データ取得
/****************************/
if ($post_flg == true && $err_flg != true){

    // カレンダ表示期間取得
    require_once(INCLUDE_DIR."function_keiyaku.inc");
    $cal_array = Cal_range($db_con, $shop_id, true);
    $end_day   = $cal_array[1];     // 対象終了期間

    $sql  = "SELECT \n";
    $sql .= "   t_aorder_h.aord_id, \n";
    $sql .= "   t_aorder_h.ord_no, \n";
    $sql .= "   t_staff_main.charge_cd, \n";
    $sql .= "   CAST(LPAD(t_staff_main.charge_cd, 4, '0') AS TEXT) AS charge_cd, \n";
    $sql .= "   t_staff_main.staff_name, \n";
    $sql .= "   t_aorder_h.ord_time, \n";
    $sql .= "   t_aorder_h.client_name, \n";
    $sql .= "   t_trade.trade_name, \n";
    $sql .= "   t_aorder_h.net_amount, \n";
    $sql .= "   t_aorder_h.tax_amount, \n";
    $sql .= "   CASE t_aorder_h.change_flg \n";
    $sql .= "       WHEN 't' THEN '有り' \n";
    $sql .= "       WHEN 'f' THEN '' \n";
    $sql .= "   END \n";
    $sql .= "   AS change_flg, \n";
    $sql .= "   NULL, \n";
    $sql .= "   NULL, \n";
    $sql .= "   t_aorder_h.route, \n";
    $sql .= "   t_aorder_h.client_cname, \n";
    $sql .= "   t_aorder_h.client_cd1 || '-' || t_aorder_h.client_cd2 AS client_cd, \n";
    $sql .= "   t_aorder_h.confirm_flg, \n";
    $sql .= "   t_aorder_h.advance_offset_totalamount \n";
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "   INNER JOIN t_client ON t_aorder_h.client_id = t_client.client_id \n";
    $sql .= "   INNER JOIN t_client AS t_client_claim ON t_aorder_h.claim_id = t_client_claim.client_id \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_aorder_staff.aord_id, \n";
    $sql .= "           t_aorder_staff.staff_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_aorder_staff.staff_name, \n";
    $sql .= "           t_attach.part_id \n";
    $sql .= "       FROM \n";
    $sql .= "           t_aorder_staff \n";
    $sql .= "           LEFT JOIN t_staff ON t_aorder_staff.staff_id = t_staff.staff_id \n";
    $sql .= "           LEFT JOIN t_attach ON t_aorder_staff.staff_id = t_attach.staff_id \n";
    $sql .= "           AND t_attach.shop_id = $shop_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_aorder_staff.staff_div = '0' \n";
    $sql .= "       AND \n";
    $sql .= "           t_aorder_staff.sale_rate IS NOT NULL \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_staff_main \n";
    $sql .= "   ON t_aorder_h.aord_id = t_staff_main.aord_id \n";
    $sql .= "   LEFT  JOIN t_attach ON  t_staff_main.staff_id = t_attach.staff_id \n";
    $sql .= "                       AND t_attach.h_staff_flg = 'f' \n";
    $sql .= "   INNER JOIN t_trade  ON  t_aorder_h.trade_id = t_trade.trade_id \n";
    $sql .= "WHERE \n";
    if ($_SESSION["group_kind"] == "2"){
    $sql .= "   t_aorder_h.shop_id IN (".Rank_Sql().") \n";
    }else{
    $sql .= "   t_aorder_h.shop_id = $shop_id \n";
    }
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.contract_div = '1' \n";
//    $sql .= "AND \n";
//    $sql .= "   t_aorder_h.confirm_flg = 'f' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ord_no IS NOT NULL \n";
//    $sql .= "AND \n";
//    $sql .= "   (t_aorder_h.ps_stat = '1' OR t_aorder_h.ps_stat = '2') \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.del_flg = 'f' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ord_time <= '$end_day' \n";
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
    $match_count    = pg_num_rows($res);
    $page_data      = Get_Data($res, 2, "ASSOC");

}


/****************************/
// 表示用データ作成
/****************************/
if ($post_flg == true && $err_flg != true){

    if (count($page_data) > 0){

        foreach ($page_data as $key => $value){

            // No.
            $page_data[$key]["no"]      = (($page_count - 1) * $limit) + $key + 1;

            // 得意先
            $page_data[$key]["client"]  = $value["client_cd"]."<br>".htmlspecialchars($value["client_cname"])."<br>";

            // 伝票番号リンク
            $link_url  = "./2-2-106.php?aord_id[0]=".$value["aord_id"]."&back_display=confirm";
            $link_tag  = "<a href=\"#\" onClick=\"Submit_Page('$link_url');\">";
            $link_tag .= ($value["ord_no"] != null) ? $value["ord_no"] : "未設定";
            $link_tag .= "</a>";
            $page_data[$key]["slip_no_link"] = $link_tag;

            // 巡回担当者（メイン１）
            if ($value["charge_cd"] != null){
                $page_data[$key]["staff_main"] = $value["charge_cd"]." : ".htmlspecialchars($value["staff_name"]);
            }

            // 伝票合計
            $page_data[$key]["ontax_amount"] = $value["net_amount"] + $value["tax_amount"];

            // 変更／削除リンク
            if ($value["confirm_flg"] == "f"){
                $link_tag  = "<a href=\"#\" onClick=\"Submit_Page('$link_url');\">";
                $link_tag .= "変更／削除";
                $link_tag .= "</a>";
            }else{
                $link_tag  = null;
            }
            $page_data[$key]["slip_chg_link"] = $link_tag;

            // 確定チェック
            if ($value["confirm_flg"] == "f"){
                $form->addElement("checkbox", "form_slip_check[$key]", ""," ", "", "");
            }else{
                $form->addElement("hidden",   "form_slip_check[$key]");
            }

            // 受注IDをhiddenに追加
            $form->addElement("hidden","output_id_array[$key]");             //確定受注ID配列
            $con_data["output_id_array[$key]"] = $value["aord_id"];          //受注ID

        }

    }

}


/****************************/
// フォーム動的部品作成
/****************************/
// 確定ALLチェック
$form->addElement("checkbox", "form_slip_all_check", "", "確定",
    "onClick=\"javascript: All_check('form_slip_all_check', 'form_slip_check', $match_count);\""
);

/*
// 確定チェック
for ($i = 0; $i < $match_count; $i++){
    $form->addElement("checkbox", "form_slip_check[$i]", ""," ", "", "");
}
*/


/****************************/
// POST時にチェック情報初期化
// ・表示ボタン押下＋再遷移フラグnull時
// ・ページ切り替え時
// ・確定押下＋確定エラー時
// ・フォームエラー時
/****************************/
if (
    ($_POST["form_display"] != null && $_GET["search"] == null) ||
    ($_POST["switch_page_flg"] == "t") ||
    ($_POST["confirm_flg"] == "true" && $confirm_err_flg != true) ||
    $err_flg == true
){
    for($i = 0; $i < $match_count; $i++){
        $con_data["form_slip_check"][$i]  = "";
    }
    $con_data["form_slip_all_check"] = "";
}


/****************************/
// setConstants
/****************************/
$form->setConstants($con_data); 


/****************************/
// html作成
/****************************/
/* 検索テーブル */
$html_s .= "\n";
$html_s .= "<table>\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td>\n";
// 共通検索テーブル
$html_s .= Search_Table($form);
$html_s .= "<br style=\"font-size: 4px;\">\n";
// モジュール個別検索テーブル１
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\" 90px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"350px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">伝票形式</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_slip_type"]]->toHtml()."</td>\n";
//$html_s .= "        <td class=\"Td_Search_3\">発行状況</td>\n";
//$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_out_state"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">確定処理</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_slip_state"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
// モジュール個別検索テーブル２
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
if ($_SESSION["group_kind"] == "2"){
$html_s .= "    <col width=\" 90px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"350px\">\n";
}
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">伝票番号</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_slip_no"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
// ボタン
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_display"]]->toHtml()."　\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_clear"]]->toHtml()."\n";
$html_s .= "</td></tr></table>\n";
$html_s .= "        </td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";


/****************************/
// HTML作成（一覧部）
/****************************/
if ($post_flg == true){

    // ページ分け
    $html_page  = Html_Page2($total_count, $page_count, 1, $limit);
    $html_page2 = Html_Page2($total_count, $page_count, 2, $limit);

    /* 一覧テーブル */
    $html_1 .= "\n";
    $html_1 .= "<table class=\"List_Table\" width=\"100%\" border=\"1\">\n";
    $html_1 .= "    <tr align=\"center\" style=\"font-weight: bold;\">\n";
    $html_1 .= "        <td class=\"Title_Pink\">No.</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_client_cd")."<br><br style=\"font-size: 4px;\">".Make_Sort_Link($form, "sl_client_name")."</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_slip")."</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_arrival_day")."</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_round_staff")."<br></td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">取引区分</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">売上金額<br>消費税</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">伝票合計</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">前受<br>相殺額</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">確定前変更</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">変更／削除</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">";
    $html_1 .=          $form->_elements[$form->_elementIndex["form_slip_all_check"]]->toHtml()."</td>\n";
    $html_1 .= "    </tr>\n";
    if ($page_data != null){
    foreach ($page_data as $key => $value){
        if (bcmod($key, 2) == 0){
        $html_1 .= "    <tr class=\"Result1\">\n";
        }else{
        $html_1 .= "    <tr class=\"Result2\">\n";
        }
        $html_1 .= "        <td align=\"right\">".$value["no"]."</td>\n";
        $html_1 .= "        <td>".$value["client"]."</td>\n";
        $html_1 .= "        <td align=\"center\">".$value["slip_no_link"]."</td>\n";
        $html_1 .= "        <td align=\"center\">".$value["ord_time"]."</td>\n";
        $html_1 .= "        <td>".$value["staff_main"]."</td>\n";
        $html_1 .= "        <td align=\"center\">".$value["trade_name"]."</td>";
        $html_1 .= "        <td align=\"right\">".number_format($value["net_amount"])."<br>".number_format($value["tax_amount"])."</td>\n";
        $html_1 .= "        <td align=\"right\">".number_format($value["ontax_amount"])."</td>\n";
        $html_1 .= "        <td align=\"right\">".Numformat_Ortho($value["advance_offset_totalamount"], null, true)."</td>\n";
        $html_1 .= "        <td align=\"center\">".$value["change_flg"]."</td>\n";
        $html_1 .= "        <td align=\"center\">".$value["slip_chg_link"]."</td>\n";
        $html_1 .= "        <td align=\"center\">".$form->_elements[$form->_elementIndex["form_slip_check[$key]"]]->toHtml()."</td>\n";
        $html_1 .= "    </tr>\n";
    }
    }
    $html_1 .= "    <tr class=\"Result3\">\n";
    $html_1 .= "        <td colspan=\"12\" align=\"right\" colspan=\"3\"><b><font color=\"#0000ff\">";
    $html_1 .= "            <li>チェックを付けた伝票の金額を計算します。</font></b>\n";
    $html_1 .=              $form->_elements[$form->_elementIndex["form_sum"]]->toHtml();
    $html_1 .= "        </td>\n";
    $html_1 .= "    </tr>\n";
    $html_1 .= "</table>\n";
    $html_1 .= "\n";

    /* 合計テーブル */
    $html_2  = "\n"; 
    $html_2 .= "<table class=\"List_Table\" border=\"1\" width=\"500px\" align=\"right\">\n";
    $html_2 .= "    <col width=\"100px\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_2 .= "    <col width=\"100px\" align=\"right\">\n";
    $html_2 .= "    <col width=\"100px\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_2 .= "    <col width=\"100px\" align=\"right\">\n";
    $html_2 .= "    <col width=\"100px\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_2 .= "    <col width=\"100px\" align=\"right\">\n";
    $html_2 .= "    <tr class=\"Result1\">\n";
    $html_2 .= "        <td class=\"Title_Pink\">掛売金額</td>\n";
    $html_2 .= "        <td align=\"right\">".number_format($kake_notax)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">掛売消費税</td>\n";
    $html_2 .= "        <td align=\"right\">".number_format($kake_tax)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">掛売合計</td>\n";
    $html_2 .= "        <td align=\"right\">".number_format($kake_ontax)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "    <tr class=\"Result1\">\n";
    $html_2 .= "        <td class=\"Title_Pink\">現金金額</td>\n";
    $html_2 .= "        <td align=\"right\">".number_format($genkin_notax)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">現金消費税</td>\n";
    $html_2 .= "        <td align=\"right\">".number_format($genkin_tax)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">現金合計</td>\n";
    $html_2 .= "        <td align=\"right\">".number_format($genkin_ontax)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "    <tr class=\"Result1\">\n";
    $html_2 .= "        <td class=\"Title_Pink\">税抜合計</td>\n";
    $html_2 .= "        <td align=\"right\">".number_format($notax_amount)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">消費税合計</td>\n";
    $html_2 .= "        <td align=\"right\">".number_format($tax_amount)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">税込合計</td>\n";
    $html_2 .= "        <td align=\"right\">".number_format($ontax_amount)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "</table>\n";
    $html_2 .= "\n";

    /* テーブルまとめ */
    $html_l .= "\n";
    $html_l .= "    <table>\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td>$html_page</td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td>$html_1</td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td><A NAME=\"sum\">$html_2</A></td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td align=\"right\">".$form->_elements[$form->_elementIndex["form_confirm"]]->toHtml()."</td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td>$html_page2</td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "</table>\n";
    $html_l .= "\n";

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

/****************************/
// 画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex[comp_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[act_button]]->toHtml();
$page_header = Create_Header($page_title);

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
));

// htmlをassign
$smarty->assign("html", array(
    "html_page"     => $html_page,
    "html_page2"    => $html_page2,
    "html_s"        => $html_s,
    "html_l"        => $html_l,
));

// msgをassign
$smarty->assign("msg", array(
    "move_warning"              => "$move_warning",
    // エラーメッセージ
    "confirm_err"               => "$confirm_err",
    "del_err"                   => "$del_err",
    "deli_day_renew_err"        => "$deli_day_renew_err",
    "deli_day_start_err"        => "$deli_day_start_err",
    "claim_day_renew_err"       => "$claim_day_renew_err",
    "claim_day_start_err"       => "$claim_day_start_err",
    "claim_day_bill_err"        => "$claim_day_bill_err",
    "buy_err_mess1"             => "$buy_err_mess1",
    "buy_err_mess2"             => "$buy_err_mess2",
    "buy_err_mess3"             => "$buy_err_mess3",
    "err_trade_advance_msg"     => "$err_trade_advance_msg",
    "err_future_date_msg"       => "$err_future_date_msg",
    "err_advance_fix_msg"       => "$err_advance_fix_msg",
    "err_paucity_advance_msg"   => "$err_paucity_advance_msg",
    "error_pay_no"              => "$error_pay_no",
    "error_buy_no"              => "$error_buy_no",
    // エラーのあった伝票番号配列
    "ary_err_confirm"           => $ary_err_confirm,
    "ary_err_del"               => $ary_err_del,
    "ary_err_deli_day_renew"    => $ary_err_deli_day_renew,
    "ary_err_deli_day_start"    => $ary_err_deli_day_start,
    "ary_err_claim_day_renew"   => $ary_err_claim_day_renew,
    "ary_err_claim_day_start"   => $ary_err_claim_day_start,
    "ary_err_claim_day_bill"    => $ary_err_claim_day_bill,
    "ary_err_trade_advance"     => $ary_err_trade_advance,
    "ary_err_future_date"       => $ary_err_future_date,
    "ary_err_advance_fix"       => $ary_err_advance_fix,
    "ary_err_paucity_advance"   => $ary_err_paucity_advance,
    "ary_err_buy1"              => $ary_err_buy1,
    "ary_err_buy2"              => $ary_err_buy2,
    "ary_err_buy3"              => $ary_err_buy3,
    "ary_err_pay_no"            => $ary_err_pay_no,
    "ary_err_buy_no"            => $ary_err_buy_no,
));

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
