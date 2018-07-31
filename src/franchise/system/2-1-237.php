<?php
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/09      03-040      kajioka-h   取消リンクの表示条件修正
 *  2006/11/11      03-042      kajioka-h   保留削除したものは表示しないように修正
 *  2006/11/13      03-036      kajioka-h   承認時、既に承認されていないかチェック処理追加
 *                  03-037      kajioka-h   取消時、既に取消されていないかチェック処理追加
 *                  03-038      kajioka-h   承認時、既に取消されていないかチェック処理追加
 *                  03-039      kajioka-h   取消時、既に日次更新されていないかチェック処理追加
 *  2007/01/06      xx-xxx      kajioka-h   代行伝票（得意先宛）に代行先の情報を残す処理追加
 *  2007/02/21      xx-xxx      watanabe-k  基本出荷倉庫を拠点倉庫に変更
 *  2007/02/27      作業項目67  fukuda-s    一覧を詳細出力
 *  2007/03/05      作業項目67  fukuda-s    金額合計出力
 *  2007/03/05      作業項目12  ふくだ      掛・現金の合計を出力
 *  2007/03/22                  ふくだ      保留削除フラグを削除フラグに変更
 *  2007/03/26      要件12      kajioka-h   承認処理部分を include/fc_sale_accept.inc に出した
 *  2007/04/05      その他25    kajioka-h   代行料・紹介料を本部の仕入する場合のチェック処理追加
 *  2007-04-12                  fukuda      検索条件復元処理追加
 *  2007/05/23      xx-xxx      kajioka-h   代行伝票の現金取引可能により、エラーメッセージ追加
 *  2007/06/14      その他14    kajioka-h   前受ありで予定巡回日 != 請求日の場合エラーメッセージ追加
 *                  xx-xxx      kajioka-h   販売区分：05→工事  06：→その他  に変更
 *  2007-06-22                  fukuda      一覧テーブルに「取引区分」の列を追加
 *  2007/06/25                  fukuda      承認時に予定巡回日が未来の場合はエラー
 *  2007/07/27                  kajioka-h   オンライン代行の取消時に、受託先の代行料売上を削除するように変更
 *
 */

$page_title = "委託巡回（報告一覧／確定）";

// 環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// 確定処理関数定義
require_once(PATH ."function/trade_fc.fnc");

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
    "form_display_num"      => "1", 
    "form_attach_branch"    => "",
    "form_client"           => array("cd1" => "", "cd2" => "", "name" => ""), 
    "form_claim"            => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_round_day"        => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))
    ),
    "form_claim_day"        => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "",  "ed" => ""),
    "form_charge_fc"        => array("cd1" => "", "cd2" => "", "name" => "", "select" => array("0" => "", "1" => "")),
    "form_slip_no"          => array("s" => "", "e" => ""), 
    "form_contract_div"     => "1",
    "form_confirm_flg"      => "1",
);

$ary_pass_list = array(
    "hdn_cancel_id"     => "",
);

// 検索条件復元
Restore_Filter2($form, "sale", "form_display", $ary_form_list, $ary_pass_list);


/****************************/
// 外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];    //ログインID
$staff_id   = $_SESSION["staff_id"];     //ログイン者ID
$staff_name = addslashes($_SESSION["staff_name"]);   //ログイン者名
$group_kind = $_SESSION["group_kind"];   //顧客区分


/****************************/
// 初期値設定
/****************************/
$form->setDefaults($ary_form_list);

if ($_POST["form_display_num"] == "1"){
    $range = null;
}else{
    $range = "100";
}
$offset         = "0";      // OFFSET
$total_count    = "0";      // 全件数
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // 表示ページ数


/****************************/
// 正当性チェック
/****************************/
//FC判定
if ($group_kind != "2"){
    //FC以外は、TOPに遷移
    header("Location: ".FC_DIR."top.php");
    exit;
}


/****************************/
// フォームデフォルト値設定
/****************************/
$form->setDefaults($ary_form_list);


/****************************/
// フォームパーツ定義
/****************************/
/* 共通フォーム */
Search_Form($db_con, $form, $ary_form_list);

// 不要フォームを削除
$form->removeElement("form_attach_branch");
$form->removeElement("form_round_staff");
$form->removeElement("form_multi_staff");
$form->removeElement("form_part");
$form->removeElement("form_ware");

/* モジュール個別フォーム */
// 伝票番号（開始〜終了）
$obj    =   null;
$obj[]  =&  $form->createElement("text", "s", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", "〜");
$obj[]  =&  $form->createElement("text", "e", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");
$form->addGroup($obj, "form_slip_no", "", "");

// 契約区分
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "全て",           "1");
$obj[]  =&  $form->createElement("radio", null, null, "オンライン代行", "3");
$obj[]  =&  $form->createElement("radio", null, null, "オフライン代行", "4");
$form->addGroup($obj, "form_contract_div", "", "");

// 承認処理
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "全て",   "1");
$obj[]  =&  $form->createElement("radio", null, null, "未承認", "2");
$obj[]  =&  $form->createElement("radio", null, null, "承認済", "3");
$form->addGroup($obj, "form_confirm_flg", "", "");

// ソートリンク
$ary_sort_item = array(
    "sl_slip"           => "伝票番号",
    "sl_arrival_day"    => "予定巡回日",
    "sl_claim_day"      => "請求日",
    "sl_client_cd"      => "得意先コード",
    "sl_client_name"    => "得意先名",
    "sl_act_client_cd"  => "代行先コード",
    "sl_act_client_name"=> "代行先名",
    "sl_round_staff"    => "巡回担当者<br>（メイン１）",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_client_cd");

// 表示ボタン
$form->addElement("submit", "form_display", "表　示");

// クリア
$form->addElement("button", "form_clear", "クリア", "onClick=\"javascript: location.href='".$_SERVER["PHP_SELF"]."'\"");

// 合計ボタン
$form->addElement("button", "form_sum", "合　計",
    "onClick=\"javascript: Button_Submit('sum_flg', '".$_SERVER["PHP_SELF"]."#sum', true);\""
);

// 承認ボタン
$form->addElement("button", "form_confirm", "承　認", 
    "onClick=\"javascript: Button_Submit('confirm_flg', '".$_SERVER["PHP_SELF"]."', true)\" $disabled"
);

// ヘッダ部用ボタン 予定伝票売上確定
$form->addElement("button", "kakutei_button", "予定伝票売上確定", "onClick=\"location.href='../sale/2-2-206.php'\"");

// ヘッダ部用ボタン 委託巡回
$form->addElement("button", "act_button", "委託巡回", "$g_button_color onClick=\"location.href='2-1-237.php'\"");

// 処理フラグ
$form->addElement("hidden","confirm_flg");                  //承認フラグ
$form->addElement("hidden","hdn_cancel_id");                //取消売上ID
$form->addElement("hidden","sum_flg");                      //合計フラグ


/***************************/
// 取消リンクが押された場合
/***************************/
if($_POST["hdn_cancel_id"] != null){

    $cancel_id = $_POST["hdn_cancel_id"];  //受注ID

    Db_Query($db_con, "BEGIN");

    $sql = "SELECT contract_div, trust_confirm_flg FROM t_aorder_h WHERE aord_id = $cancel_id;";
    $result = Db_Query($db_con, $sql);
    $contract_div       = pg_fetch_result($result, 0, "contract_div");
    $trust_confirm_flg  = pg_fetch_result($result, 0, "trust_confirm_flg");

    //オンライン代行ですでに取消されている（オフラインの場合は後勝ちのため判定しない）
    if($contract_div == "2" && $trust_confirm_flg == "f"){
        $cancel_err = "取消されているため、取消できません。";
        Db_Query($db_con, "ROLLBACK;");

    //
    }else{

        //売上レコードがあるかチェック
        $sql = "SELECT renew_flg FROM t_sale_h WHERE sale_id = $cancel_id;";
        $result = Db_Query($db_con, $sql);
        if(pg_num_rows($result) != 0){
            $renew_flg = pg_fetch_result($result, 0, "renew_flg");
            //日次更新されている
            if($renew_flg == "t"){
                $renew_err = "日次更新されているため、取消できません。";
                Db_Query($db_con, "ROLLBACK;");
            }
        }

        //日次更新されていない or 売上レコードがない（オンラインで未承認）
        if($renew_err == null){

            //売上データ全て削除SQL
            $sql  = "DELETE FROM t_sale_h ";
            $sql .= "WHERE";
            $sql .= "   sale_id = $cancel_id;";
            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK");
                exit;
            }

            //受託先の代行料売上を削除
            $sql  = "DELETE FROM t_sale_h \n";
            $sql .= "WHERE \n";
            $sql .= "    aord_id = $cancel_id \n";
            $sql .= "    AND act_request_flg = true \n";
            $sql .= ";";
            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

            //受注ヘッダの確定フラグをfalse
            $sql  = "UPDATE t_aorder_h SET";
            $sql .= "   confirm_flg = 'f',";         //確定フラグ
            $sql .= "   trust_confirm_flg = 'f',";   //確定フラグ(受託)
            $sql .= "   cancel_flg = 't',";          //取消フラグ
            $sql .= "   ps_stat = '1' ";             //処理状況
            $sql .= "WHERE";
            $sql .= "   aord_id = $cancel_id;";
            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK");
                exit;
            }

            Db_Query($db_con, "COMMIT");

            $post_flg       = true;                  //POSTフラグ

            $con_data["hdn_cancel_id"] = "";         //初期化
            $form->setConstants($con_data);
        }
    }
}


/****************************/
// 合計ボタン押下時
/****************************/
if ($_POST["sum_flg"] == "true"){

    $con_data["sum_flg"] = "";   //合計ボタン初期化

    $output_id_array = $_POST["output_id_array"];  //受注ID配列
    $check_num_array = $_POST["form_slip_check"];  //伝票チェック

    //伝票にチェックがある場合に行う
    if($check_num_array != NULL){
        $aord_array = NULL;    //伝票出力受注ID配列
        foreach ($check_num_array as $key => $value){
            if ($value == "1"){
                $aord_array[] = $output_id_array[$key];
            }
        }
    }
    
    for($s=0;$s<count($aord_array);$s++){

        $sql  = "SELECT \n";
        $sql .= "    t_trade.trade_name,\n";            //取引区分 
        $sql .= "    t_aorder_h.net_amount,\n";         //売上金額 
        $sql .= "    t_aorder_h.tax_amount \n";         //消費税 
        $sql .= "FROM \n";
        $sql .= "    t_aorder_h \n";
        $sql .= "    INNER JOIN t_trade ON t_aorder_h.trade_id = t_trade.trade_id \n";
        $sql .= "WHERE \n";
        $sql .= "    t_aorder_h.aord_id = ".$aord_array[$s].";";
        $result = Db_Query($db_con, $sql);
        $money_data = Get_Data($result);

        /****************************/
        //掛売上・現金売上金額計算
        /****************************/
        //取引区分判定
        if($money_data[0][0] == '掛売上' || $money_data[0][0] == '掛返品' || $money_data[0][0] == '掛値引' || $money_data[0][0] == '割賦売上'){
            //掛売上金額計算
            $money1 = $money1 + $money_data[0][1];
            //掛売上消費税
            $total_tax1 = $total_tax1 + $money_data[0][2];
            //掛売合計
            $sum_money1 = $money_data[0][1] + $money_data[0][2];
            $total_money1 = $total_money1 + $sum_money1;
        }else{
            //現金売上金額計算
            $money2 = $money2 + $money_data[0][1];
            //現金売上消費税
            $total_tax2 = $total_tax2 + $money_data[0][2];
            //現金売上合計
            $sum_money2 = $money_data[0][1] + $money_data[0][2];
            $total_money2 = $total_money2 + $sum_money2;
        }
        // 掛・現金の合計を算出
        $money3         += $money_data[0][1];
        $total_tax3     += $money_data[0][2];
    }

}


/****************************/
// 承認ボタン押下処理
/****************************/
if($_POST["confirm_flg"] == "true"){

    $con_data["confirm_flg"] = "";   // 承認ボタン初期化

    $output_id_array = $_POST["output_id_array"];  //受注ID配列
    $check_num_array = $_POST["form_slip_check"];  //伝票チェック

    //伝票にチェックがある場合に行う
    if($check_num_array != NULL){
        $aord_array = NULL;    //伝票出力受注ID配列
        while($check_num = each($check_num_array)){
            //この添字の受注IDを使用する
            $check = $check_num[0];

            //未承認行のみ配列に追加
            if($check_num[1] != NULL){
                $aord_array[] = $output_id_array[$check];
            }
        }
    }

    require(INCLUDE_DIR."fc_sale_accept.inc");

}


/****************************/
// 表示ボタン押下時
/****************************/
if ($_POST["form_display"] != null){

    /****************************/
    // エラーチェック
    /****************************/
    // ■共通フォームチェック
    Search_Err_Chk($form);

    // ■伝票番号
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
    $_POST["form_round_day"] = Str_Pad_Date($_POST["form_round_day"]);
    $_POST["form_claim_day"] = Str_Pad_Date($_POST["form_claim_day"]);

    // 1. フォームの値を変数にセット
    // 2. SESSION（hidden用）の値（検索条件復元関数内でセット）を変数にセット
    // 一覧取得クエリ条件に使用
    $display_num        = $_POST["form_display_num"];
    $client_branch      = $_POST["form_client_branch"];
    $client_cd1         = $_POST["form_client"]["cd1"];
    $client_cd2         = $_POST["form_client"]["cd2"];
    $client_name        = $_POST["form_client"]["name"];
    $claim_cd1          = $_POST["form_claim"]["cd1"];
    $claim_cd2          = $_POST["form_claim"]["cd2"];
    $claim_name         = $_POST["form_claim"]["name"];
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
    $charge_fc_cd1      = $_POST["form_charge_fc"]["cd1"];
    $charge_fc_cd2      = $_POST["form_charge_fc"]["cd2"];
    $charge_fc_name     = $_POST["form_charge_fc"]["name"];
    $charge_fc_select   = $_POST["form_charge_fc"]["select"]["1"];
    $slip_no_s          = $_POST["form_slip_no"]["s"];
    $slip_no_e          = $_POST["form_slip_no"]["e"];
    $contract_div       = $_POST["form_contract_div"];
    $confirm_flg        = $_POST["form_confirm_flg"];

    $post_flg = true;

}


/****************************/
// 一覧データ取得条件作成
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // 顧客担当支店
    $sql .= ($client_branch != null) ? "AND t_client.charge_branch_id = $client_branch \n" : null;
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
    // 委託先FCコード１
    $sql .= ($charge_fc_cd1 != null) ? "AND t_aorder_h.act_cd1 LIKE '$charge_fc_cd1%' \n" : null;
    // 委託先FCコード２
    $sql .= ($charge_fc_cd2 != null) ? "AND t_aorder_h.act_cd2 LIKE '$charge_fc_cd2%' \n" : null;
    // 委託先FC名
    if ($charge_fc_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_act_client.client_name  LIKE '%$charge_fc_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_act_client.client_name2 LIKE '%$charge_fc_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_act_client.client_cname LIKE '%$charge_fc_name%' \n";
        $sql .= "   ) \n";
    }
    // 委託先FCセレクト
    $sql .= ($charge_fc_select != null) ? "AND t_aorder_h.act_id = $charge_fc_select \n" : null;
    // 伝票番号（開始）
    $sql .= ($slip_no_s != null) ? "AND t_aorder_h.ord_no >= '".str_pad($slip_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null; 
    // 伝票番号（終了）
    $sql .= ($slip_no_e != null) ? "AND t_aorder_h.ord_no <= '".str_pad($slip_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null; 
    // 契約区分
    if ($contract_div == "2"){
        $sql .= "AND t_aorder_h.contract_div = '1' \n";
    }elseif ($contract_div == "3"){
        $sql .= "AND t_aorder_h.contract_div = '2' \n";
    }elseif ($contract_div == "4"){
        $sql .= "AND t_aorder_h.contract_div = '3' \n";
    }
    // 承認処理
    if ($confirm_flg == "2"){
        $sql .= "AND t_aorder_h.confirm_flg = 'f' \n";
    }elseif ($confirm_flg == "3"){
        $sql .= "AND t_aorder_h.confirm_flg = 't' \n";
    }

    // 変数詰め替え
    $where_sql = $sql; 


    $sql = null;

    // ソート順
    switch ($_POST["hdn_sort_col"]){
        // 伝票番号
        case "sl_slip":
            $sql .= "   ord_no, \n";
            $sql .= "   client_cd, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_time \n";
            break;
        // 予定巡回日
        case "sl_arrival_day":
            $sql .= "   ord_time, \n";
            $sql .= "   client_cd, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_no \n";
            break;
        // 請求日
        case "sl_claim_day":
            $sql .= "   arrival_day, \n";
            $sql .= "   client_cd, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   ord_no \n";
            break;
        // 得意先コード
        case "sl_client_cd":
            $sql .= "   client_cd, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   ord_no \n";
            break;
        // 得意先名
        case "sl_client_name":
            $sql .= "   client_cname, \n";
            $sql .= "   client_cd, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   ord_no \n";
            break;
        // 代行先コード
        case "sl_act_client_cd":
            $sql .= "   act_cd, \n";
            $sql .= "   client_cd, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   ord_no \n";
            break;
        // 代行先名
        case "sl_act_client_name":
            $sql .= "   act_name, \n";
            $sql .= "   act_cd, \n";
            $sql .= "   client_cd, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   ord_no \n";
            break;
        // 巡回担当者（メイン１）
        case "sl_round_staff":
            $sql .= "   charge_cd, \n";
            $sql .= "   client_cd, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   ord_no \n";
            break;
    }

    // 変数詰め替え
    $order_sql = $sql; 

}


/****************************/
// 一覧データ取得
/****************************/
// 表示フラグがあり、エラーのない場合
if ($post_flg == true && $err_flg != true){

    // オンライン代行
    $sql  = "SELECT \n";
    $sql .= "   t_aorder_h.aord_id, \n";                                                // 受注ID
    $sql .= "   t_aorder_h.ord_no, \n";                                                 // 受注番号
    $sql .= "   t_staff_main.charge_cd, \n";                                            // 担当者CD1
    $sql .= "   t_staff_main.staff_name, \n";                                           // 担当者名1
    $sql .= "   t_aorder_h.ord_time, \n";                                               // 予定巡回日
    $sql .= "   t_aorder_h.client_cname, \n";                                           // 略称
    $sql .= "   t_aorder_h.client_cd1 || '-' || t_aorder_h.client_cd2 AS client_cd, \n";// 得意先CD
    $sql .= "   t_act_client.client_cd1 || '-' || t_act_client.client_cd2 AS act_cd, \n";   // 代行先CD
    $sql .= "   t_act_client.client_cname AS act_name, \n";                                 // 代行先名
    $sql .= "   CASE t_aorder_h.confirm_flg \n";
    $sql .= "       WHEN 't' THEN '承認' \n";
    $sql .= "       WHEN 'f' THEN '未承認' \n";
    $sql .= "   END \n";
    $sql .= "   AS confirm_flg, \n";                                                    // 確定フラグ
    $sql .= "   'オン' AS contract_div, \n";                                            // 契約区分
    $sql .= "   t_trade.trade_cd, \n";                                                  // 取引区分コード
    $sql .= "   t_trade.trade_name, \n";                                                // 取引区分
    $sql .= "   t_sale_h.renew_flg, \n";                                                // 日次更新フラグ
    $sql .= "   t_aorder_h.arrival_day, \n";                                            // 請求日
    $sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2 AS claim_cd, \n";     // 請求先コード
    $sql .= "   t_client.client_cname AS claim_cname, \n";                              // 請求先名
    $sql .= "   t_aorder_h.net_amount, \n";                                             // 税抜金額
    $sql .= "   t_aorder_h.tax_amount, \n";                                             // 消費税
    $sql .= "   t_aorder_h.net_amount + t_aorder_h.tax_amount AS net_tax_amount, \n";   // 金額合計
    $sql .= "   t_trade.trade_name \n";
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_aorder_staff.aord_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_aorder_staff.staff_name \n";
    $sql .= "       FROM \n";
    $sql .= "           t_aorder_staff \n";
    $sql .= "           LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_aorder_staff.staff_div = '0' \n";
    $sql .= "       AND \n";
    $sql .= "           t_aorder_staff.sale_rate != '0' \n";
    $sql .= "       AND \n";
    $sql .= "           t_aorder_staff.sale_rate IS NOT NULL \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_staff_main \n";
    $sql .= "   ON t_staff_main.aord_id = t_aorder_h.aord_id \n";
    $sql .= "   LEFT JOIN t_sale_h ON t_sale_h.sale_id = t_aorder_h.aord_id \n";
    $sql .= "   LEFT JOIN t_client ON t_aorder_h.client_id = t_client.client_id \n";
    $sql .= "   LEFT JOIN t_trade  ON t_aorder_h.trade_id = t_trade.trade_id \n";
    $sql .= "   LEFT JOIN t_client AS t_client_claim ON t_aorder_h.claim_id = t_client_claim.client_id \n";
    $sql .= "   LEFT JOIN t_client AS t_act_client   ON t_aorder_h.act_id = t_act_client.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.shop_id IN (".Rank_Sql().") \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.contract_div = '2' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ord_no IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.trust_confirm_flg = 't' \n";
//    $sql .= "AND \n";
//    $sql .= "   t_aorder_h.ps_stat = '2' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.del_flg = 'f' \n";
    $sql .= $where_sql;

    $sql .= "UNION \n";

    // オフライン代行
    $sql .= "SELECT \n";
    $sql .= "   t_aorder_h.aord_id, \n";                                                // 受注ID
    $sql .= "   t_aorder_h.ord_no, \n";                                                 // 受注番号
    $sql .= "   t_staff_main.charge_cd, \n";                                            // 担当者CD1
    $sql .= "   t_staff_main.staff_name, \n";                                           // 担当者名1
    $sql .= "   t_aorder_h.ord_time, \n";                                               // 予定巡回日
    $sql .= "   t_aorder_h.client_cname, \n";                                           // 略称
    $sql .= "   t_aorder_h.client_cd1 || '-' || t_aorder_h.client_cd2 AS client_cd, \n";// 得意先CD
    $sql .= "   t_act_client.client_cd1 || '-' || t_act_client.client_cd2 AS act_cd, \n";   // 代行先CD
    $sql .= "   t_act_client.client_cname AS act_name, \n";                                 // 代行先名
    $sql .= "   CASE t_aorder_h.confirm_flg \n";
    $sql .= "       WHEN 't' THEN '承認' \n";
    $sql .= "       WHEN 'f' THEN '未承認' \n";
    $sql .= "   END \n";
    $sql .= "   AS confirm_flg, \n";                                                    // 確定フラグ
    $sql .= "   'オフ' AS contract_div, \n";                                            // 契約区分
    $sql .= "   t_trade.trade_cd, \n";                                                  // 取引区分コード
    $sql .= "   t_trade.trade_name, \n";                                                // 取引区分
    $sql .= "   t_sale_h.renew_flg, ";                                                  // 日次更新フラグ
    $sql .= "   t_aorder_h.arrival_day, \n";                                            // 請求日
    $sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2 AS claim_cd, \n";     // 請求先コード
    $sql .= "   t_client.client_cname AS claim_cname, \n";                              // 請求先名
    $sql .= "   t_aorder_h.net_amount, \n";                                             // 税抜金額
    $sql .= "   t_aorder_h.tax_amount, \n";                                             // 消費税
    $sql .= "   t_aorder_h.net_amount + t_aorder_h.tax_amount AS net_tax_amount, \n";   // 消費税
    $sql .= "   t_trade.trade_name \n";
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_aorder_staff.aord_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_aorder_staff.staff_name \n";
    $sql .= "       FROM \n";
    $sql .= "           t_aorder_staff \n";
    $sql .= "           LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_aorder_staff.staff_div = '0' \n";
    $sql .= "       AND \n";
    $sql .= "           t_aorder_staff.sale_rate != '0' \n";
    $sql .= "       AND \n";
    $sql .= "           t_aorder_staff.sale_rate IS NOT NULL \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_staff_main \n";
    $sql .= "   ON t_staff_main.aord_id = t_aorder_h.aord_id \n";
    $sql .= "   LEFT JOIN t_sale_h ON t_sale_h.sale_id = t_aorder_h.aord_id \n";
    $sql .= "   LEFT JOIN t_client ON t_aorder_h.client_id = t_client.client_id \n";
    $sql .= "   LEFT JOIN t_trade  ON t_aorder_h.trade_id = t_trade.trade_id \n";
    $sql .= "   LEFT JOIN t_client AS t_client_claim ON t_aorder_h.claim_id = t_client_claim.client_id \n";
    $sql .= "   LEFT JOIN t_client AS t_act_client   ON t_aorder_h.act_id = t_act_client.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.shop_id IN (".Rank_Sql().") \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.contract_div = '3' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ord_no IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.del_flg = 'f' \n";
    $sql .= $where_sql;

    // ソート順
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;

    // 全件取得（件数処理用）
    $res         = Db_Query($db_con, $sql.";");
    $total_count = pg_num_rows($res);

    // OFFSET作成
    if($page_count != null || $range != null){
        $offset = $page_count * $range - $range;
    }else{
        $offset = 0;
    }
    if ($range != null){
        $sql .= "LIMIT $range OFFSET $offset \n";
    }

    // 一覧データ取得（ページ分け用）
    $res_h = Db_Query($db_con, $sql.";");
    $num_h = pg_num_rows($res_h);
    if ($num_h > 0){
        $page_data_h = Get_Data($res_h, 2, "ASSOC");
    }else{
        $page_data_h = array(null);
    }

    // 上記で取得した受注ヘッダに該当する受注データの取得
    if ($num_h > 0){
        $sql  = "SELECT \n";
        $sql .= "   t_aorder_d.aord_id, \n";                // 受注ID
        $sql .= "   t_aorder_d.line, \n ";                  // 行
        $sql .= "   CASE t_aorder_d.sale_div_cd \n";
        $sql .= "       WHEN '01' THEN 'リピート' \n";
        $sql .= "       WHEN '02' THEN '商品' \n";
        $sql .= "       WHEN '03' THEN 'レンタル' \n";
        $sql .= "       WHEN '04' THEN 'リース' \n";
        //$sql .= "       WHEN '05' THEN '卸' \n";
        $sql .= "       WHEN '05' THEN '工事' \n";
        $sql .= "       WHEN '06' THEN 'その他' \n";
        $sql .= "   END \n";
        $sql .= "   AS sale_div_cd, \n";                    // 販売区分
        $sql .= "   CASE \n";
        $sql .= "       WHEN t_aorder_d.serv_print_flg = 't' \n";
        $sql .= "       THEN '○'\n";
        $sql .= "       ELSE '×' \n";
        $sql .= "   END \n";
        $sql .= "   AS serv_print_flg, \n";                 // サービス印字フラグ
        $sql .= "   t_aorder_d.serv_cd, \n";                // サービスコード
        $sql .= "   t_aorder_d.serv_name, \n";              // サービス名
        $sql .= "   CASE \n";
        $sql .= "       WHEN t_aorder_d.goods_print_flg = 't' \n";
        $sql .= "       THEN '○'\n";
        $sql .= "       ELSE '×' \n";
        $sql .= "   END \n";
        $sql .= "   AS goods_print_flg, \n";                // 商品印字フラグ
        $sql .= "   t_aorder_d.goods_cd, \n";               // 商品コード
        $sql .= "   t_aorder_d.official_goods_name, \n";    // 商品名
        $sql .= "   CASE \n";
        $sql .= "       WHEN t_aorder_d.set_flg = 't' \n";
        $sql .= "       THEN '一式<br>'\n";
        $sql .= "       ELSE NULL \n";
        $sql .= "   END \n";
        $sql .= "   AS set_flg, \n";                        // サービス一式フラグ
        $sql .= "   t_aorder_d.num, \n";                    // 数量
        $sql .= "   t_aorder_d.cost_price, \n";             // 営業原価
        $sql .= "   t_aorder_d.sale_price, \n";             // 売上単価
        $sql .= "   t_aorder_d.cost_amount, \n";            // 原価合計額
        $sql .= "   t_aorder_d.sale_amount, \n";            // 売上合計額
        $sql .= "   t_aorder_d.egoods_cd, \n";              // 消耗品コード
        $sql .= "   t_aorder_d.egoods_name, \n";            // 消耗品名
        $sql .= "   t_aorder_d.egoods_num, \n";             // 消耗品数量
        $sql .= "   t_aorder_d.rgoods_cd, \n";              // 本体商品コード
        $sql .= "   t_aorder_d.rgoods_name, \n";            // 本体商品名
        $sql .= "   t_aorder_d.rgoods_num, \n";             // 本体商品数量
        $sql .= "   t_aorder_d.advance_offset_amount \n";   // 前受相殺額
        $sql .= "FROM \n";
        $sql .= "   t_aorder_d \n";
        $sql .= "WHERE \n";
        $sql .= "   t_aorder_d.aord_id IN (";
        foreach ($page_data_h as $key_h => $value_h){
        $sql .= $value_h["aord_id"];  // 受注ヘッダ取得内容の受注ID
        $sql .= ($key_h+1 < $num_h) ? ", " : null;
        }
        $sql .= ") \n";
        $sql .= "ORDER BY \n";
        $sql .= "   t_aorder_d.aord_id, \n";
        $sql .= "   t_aorder_d.line \n";
        $sql .= ";";
        $res_d = Db_Query($db_con, $sql);
        $num_d = pg_num_rows($res_d);
        if ($num_d > 0){
            $page_data_d = Get_Data($res_d, 2, "ASSOC");
        }else{
            $page_data_d = array(null);
        }
    }

}


/****************************/
// html
/****************************/
/* 検索テーブル */
$html_s .= "\n";
$html_s .= "<table>\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td>\n";
// 共通検索テーブル
$html_s .= Search_Table($form);
$html_s .= "<br style=\"font-size: 4px;\">\n";
// モジュール個別検索テーブル
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\" 90px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"350px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">伝票番号</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_slip_no"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">契約区分</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_contract_div"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "        <td class=\"Td_Search_3\">承認処理</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_confirm_flg"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
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
// 表示データ作成
/****************************/
// 金額が負数の場合にセル内の文字色を赤にする関数
function Font_Color($num, $dot = 0){
    return ((int)$num < 0) ? "<font style=\"color: #ff0000;\">".number_format($num, $dot)."</font>" : number_format($num, $dot);
}

// 表示フラグtrue、かつエラーのない場合
if ($post_flg == true && $err_flg != true){

    /****************************/
    // 一覧の合計を算出
    /****************************/
    if ($num_h > 0){
        foreach ($page_data_h as $key_h => $value_h){
            $sum_net_amount     += $value_h["net_amount"];
            $sum_tax_amount     += $value_h["tax_amount"];
            $sum_net_tax_amount += $value_h["net_tax_amount"];
        }
    }

    /****************************/
    // 承認チェックボックス作成用処理
    /****************************/
    //チェックボックス非表示行番号配列
    $hidden_check = array();

    // ヘッダ部でループ
    if ($num_h > 0){

        foreach ($page_data_h as $key_h => $value_h){
            // 受注IDをhiddenに追加
            $form->addElement("hidden","output_id_array[$key_h]");                      // 承認受注ID配列
            $con_data["output_id_array[$key_h]"] = $page_data_h[$key_h]["aord_id"];     // 受注ID
            // 確定判定
            if ($page_data_h[$key_h]["confirm_flg"] != "未承認"){
                // チェックボックス非表示行番号取得
                $hidden_check[] = $key_h;
            }
        }

    }

    /****************************/
    // フォーム動的部品作成
    /****************************/
    // 承認ALLチェック
    $form->addElement("checkbox", "form_slip_all_check", "", "承認",
        "onClick=\"javascript:All_check('form_slip_all_check','form_slip_check',$num_h)\""
    );

    if ($num_h > 0){
        // 承認チェック
        foreach ($page_data_h as $key_h => $value_h){
            // 表示行判定
            if (!in_array($key_h, $hidden_check)){
                // 未承認行はチェックボックス定義
                $form->addElement("checkbox", "form_slip_check[$key_h]","","","","");
            }else{
                // 承認行は非表示にする為にhiddenで定義
                $form->addElement("hidden","form_slip_check[$key_h]","");
            }
        }
    }

    /****************************/
    // POST時にチェック情報初期化
    /****************************/
    if(count($_POST) > 0 && $_POST["sum_flg"] != true){
        foreach ($page_data_h as $key_h => $value_h){
            $con_data["form_slip_check"][$key_h]  = "";   
        }
        $con_data["form_slip_all_check"] = "";   
    }
    $form->setConstants($con_data); 

    /****************************/
    // html作成初期設定
    /****************************/
    // 行色初期設定
    $row_col = "Result2";

    // 行No.初期設定
    $row_num = ($_POST["f_page1"] != null && $_POST["form_display"] == null) ? ($_POST["f_page1"]-1) * $range : 0;

    /****************************/
    // html作成
    /****************************/
    // 件数表示/ページ分け
    $range = ($range == null) ? $num_h : $range;
    $html_page  = Html_Page2($total_count, $page_count, 1, $range);
    $html_page2 = Html_Page2($total_count, $page_count, 2, $range);

    // 明細データ 列タイトル
    $html_l  = "<table class=\"List_Table\" border=\"1\">\n";
    $html_l .= "    <tr align=\"center\" style=\"font-weight: bold;\">\n";
    $html_l .= "        <td class=\"Title_Pink\">No.</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_slip")."</td>\n";
    $html_l .= "        <td class=\"Title_Pink\" style=\"width: 60px\" nowrap>";
    $html_l .=              $form->_elements[$form->_elementIndex["form_slip_all_check"]]->toHtml();
    $html_l .= "        </td>\n";
    $html_l .= "        <td class=\"Title_Pink\">取消</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_arrival_day")."</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_claim_day")."</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_client_cd")."<br><br style=\"font-size: 4px;\">".Make_Sort_Link($form, "sl_client_name")."</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_act_client_cd")."<br><br style=\"font-size: 4px;\">".Make_Sort_Link($form, "sl_act_client_name")."</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">代行<br>区分</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_round_staff")."</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">取引区分</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">販売区分</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">サービスコード<br>サービス名</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">商品コード<br>商品名</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">数量</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">営業原価<br>売上単価</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">原価合計額<br>売上合計額</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">前受<br>相殺額</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">税抜合計</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">消費税</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">伝票金額</td>\n";
    $html_l .= "    </tr>\n";

    // ヘッダ部でループ
    if ($num_h > 0){
    foreach ($page_data_h as $key_h => $value_h){

        $row_col = ($row_col == "Result2") ? "Result1" : "Result2";  // 1->2, 2->1
        $href    = FC_DIR."sale/2-2-106.php?aord_id[0]=".$value_h["aord_id"]."&back_display=round"; // リンク先作成

        // 明細データ データ部の1行目のみ出力するヘッダ部データ その1
        $html_l .= "    <tr class=\"$row_col\">\n";
        $html_l .= "        <td align=\"right\">".++$row_num."</td>\n";                                                 // No.
        $html_l .= "        <td align=\"center\"><a href=\"$href\">".$value_h["ord_no"]."</a></td>\n";                  // 伝票番号
        // 権限あり＋オンライン＋未承認の場合
        if ($disabled == null && $value_h["contract_div"] == "オン" && $value_h["confirm_flg"] == "未承認"){
            $del_link   = "<a href=\"#\" onClick=\"return Dialogue_2('取消します。', '".$_SERVER["PHP_SELF"]."', ".$value_h["aord_id"].", 'hdn_cancel_id');\">取消</a>";
        }else{
            $del_link   = "";
        }
        $html_l .= "        <td align=\"center\">";                                                                     // 承認チェックボックス
        if ($value_h["confirm_flg"] == "承認"){
            $html_l .=              "済";
        }else{
            $html_l .=              $form->_elements[$form->_elementIndex["form_slip_check[$key_h]"]]->toHtml();
        }
        $html_l .= "        </td>\n";
        $html_l .= "        <td align=\"center\">$del_link</td>\n";                                                     // 取消リンク
        $html_l .= "        <td align=\"center\">".$value_h["ord_time"]."</td>\n";                                      // 予定巡回日
        $html_l .= "        <td align=\"center\">".$value_h["arrival_day"]."</td>\n";                                   // 請求日
        $html_l .= "        <td>".$value_h["client_cd"]."<br>".htmlspecialchars($value_h["client_cname"])."<br></td>\n";// 得意先
        $html_l .= "        <td>".$value_h["act_cd"]."<br>".htmlspecialchars($value_h["act_name"])."<br></td>\n";       // 代行先
        $html_l .= "        <td align=\"center\">".$value_h["contract_div"]."</td>\n";                                  // 代行区分
        if ($value_h["charge_cd"] != null){
        $html_l .= "        <td>".str_pad($value_h["charge_cd"], 4, "0", STR_PAD_LEFT)." : ".htmlspecialchars($value_h["staff_name"])."</td>\n";       // 巡回担当者
        }else{
        $html_l .= "        <td></td>\n";
        }
        $html_l .= "        <td>".htmlspecialchars($value_h["trade_name"])."</td>\n";

        $line_cnt = 0;
        // データ部でループ
        foreach ($page_data_d as $key_d => $value_d){
            // ヘッダ部ループの受注IDとデータ部ループの受注IDが同じ場合（該当伝票のデータ部である場合）
            if ($value_h["aord_id"] == $value_d["aord_id"]){
                // データ部ループが1行目でない場合
                //if ($value_d["line"] != "1"){
                if ($line_cnt != 0){
                    // 空tdを配置
                    $html_l .= "    <tr class=\"$row_col\">\n";
                    for ($i=0; $i<11; $i++){
                        // 明細データ ヘッダ部を出力しないデータ部データ その1（2行目以降のデータ部データ）
                        $html_l .= "        <td></td>\n";
                    }
                }
                // 明細データ データ部データ
                $html_l .= "        <td align=\"center\">".$value_d["sale_div_cd"]."</td>\n";                           // 販売区分
                $html_l .= "        <td>\n";
                $html_l .= "            ".$value_d["serv_print_flg"]."　".$value_d["serv_cd"]."<br>\n";                 // 印字/サービスコード
                $html_l .= "            ".htmlspecialchars($value_d["serv_name"])."<br>\n";                             // サービス名
                $html_l .= "        </td>\n";
                $html_l .= "        <td>\n";
                $html_l .= "            ".$value_d["goods_print_flg"]."　".$value_d["goods_cd"]."<br>\n";               // 印字/商品コード
                $html_l .= "            ".htmlspecialchars($value_d["official_goods_name"])."<br>\n";                   // 商品名
                $html_l .= "        </td>\n";
                $html_l .= "        <td align=\"right\">".$value_d["set_flg"].$value_d["num"]."</td>\n";                // 一式/数量
                $html_l .= "        <td align=\"right\">\n";
                $html_l .= "            ".Font_Color($value_d["cost_price"], 2)."<br>\n";                               // 営業原価
                $html_l .= "            ".Font_Color($value_d["sale_price"], 2)."<br>\n";                               // 売上単価
                $html_l .= "        </td>\n";
                $html_l .= "        <td align=\"right\">\n";                                                            
                $html_l .= "            ".Font_Color($value_d["cost_amount"])."<br>\n";                                 // 原価合計額
                $html_l .= "            ".Font_Color($value_d["sale_amount"])."<br>\n";                                 // 売上合計額
                $html_l .= "        </td>\n";
                $html_l .= "        <td align=\"right\">\n";
                $html_l .= "            ".Numformat_Ortho($value_d["advance_offset_amount"], null, true)."\n";          // 前受相殺額
                $html_l .= "        </td>\n";
                // データ部ループが1行目の場合
                //if ($value_d["line"] == "1"){
                if ($line_cnt == 0){
                    // 明細データ データ部の1行目のみ出力するヘッダ部データ その2
                    $html_l .= "        <td align=\"right\">".Font_Color($value_h["net_amount"])."</td>\n";             // 税抜合計
                    $html_l .= "        <td align=\"right\">".Font_Color($value_h["tax_amount"])."</td>\n";             // 消費税
                    $html_l .= "        <td align=\"right\">".Font_Color($value_h["net_tax_amount"])."</td>\n";         // 伝票金額
                // データ部ループが2行目以降の場合
                }else{
                    // 空tdを配置
                    for ($i=0; $i<3; $i++){
                        // 明細データ ヘッダ部を出力しないデータ部データ その2（2行目以降のデータ部データ）
                        $html_l .= "        <td></td>\n";
                    }
                }
                $html_l .= "    </tr>\n";
                $line_cnt++;
            }
        }

    }
    }

    // 最終行
    $html_l .= "    <tr class=\"Result3\">\n";
    $html_l .= "        <td colspan=\"21\" align=\"left\" style=\"padding-left: 82px; color: #0000ff; font-weight: bold;\">\n";
    $html_l .=          $form->_elements[$form->_elementIndex["form_sum"]]->toHtml();
    $html_l .= "        チェックを付けた伝票の金額を計算します</td>\n";
    $html_l .= "    </tr>\n";

    $html_l .= "</table>\n";

    // 合計
    $html_c .= "<table>\n";
    $html_c .= "<table class=\"List_Table\" border=\"1\" width=\"500\" align=\"left\">\n";
    $html_c .= "<col width=\"100\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_c .= "<col width=\"100\" align=\"right\">\n";
    $html_c .= "<col width=\"100\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_c .= "<col width=\"100\" align=\"right\">\n";
    $html_c .= "<col width=\"100\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_c .= "<col width=\"100\" align=\"right\">\n";
    $html_c .= "    <tr class=\"Result1\">\n";
    $html_c .= "        <td class=\"Title_Pink\">掛売金額</td>\n";
    $html_c .= "        <td align=\"right\">".Font_Color($money1)."</td>\n";
    $html_c .= "        <td class=\"Title_Pink\">掛売消費税</td>\n";
    $html_c .= "        <td align=\"right\">".Font_Color($total_tax1)."</td>\n";
    $html_c .= "        <td class=\"Title_Pink\">掛売合計</td>\n";
    $html_c .= "        <td align=\"right\">".Font_Color($total_money1)."</td>\n";
    $html_c .= "    </tr>\n";
    $html_c .= "    <tr class=\"Result1\">\n";
    $html_c .= "        <td class=\"Title_Pink\">現金金額</td>\n";
    $html_c .= "        <td align=\"right\">".Font_Color($money2)."</td>\n";
    $html_c .= "        <td class=\"Title_Pink\">現金消費税</td>\n";
    $html_c .= "        <td align=\"right\">".Font_Color($total_tax2)."</td>\n";
    $html_c .= "        <td class=\"Title_Pink\">現金合計</td> \n";
    $html_c .= "        <td align=\"right\">".Font_Color($total_money2)."</td>\n";
    $html_c .= "    </tr>\n";
    $html_c .= "    <tr class=\"Result1\">\n";
    $html_c .= "        <td class=\"Title_Pink\">税抜金額</td>\n";
    $html_c .= "        <td align=\"right\">".Font_Color($money3)."</td>\n";
    $html_c .= "        <td class=\"Title_Pink\">消費税合計</td>\n";
    $html_c .= "        <td align=\"right\">".Font_Color($total_tax3)."</td>\n";
    $html_c .= "        <td class=\"Title_Pink\">税込合計</td> \n";
    $html_c .= "        <td align=\"right\">".Font_Color($money3 + $total_tax3)."</td>\n";
    $html_c .= "    </tr>\n";
    $html_c .= "</table>\n";

}

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
//$page_menu = Create_Menu_f('sale','2');

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex[kakutei_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[act_button]]->toHtml();
$page_header = Create_Header($page_title);


// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",

    'error_msg'     => "$error_msg",
    'error_msg2'    => "$error_msg2",
    'error_msg3'    => "$error_msg3",
    'error_buy'     => "$error_buy",
    'error_payin'   => "$error_payin",
    'cancel_err'    => "$cancel_err",
    'renew_err'     => "$renew_err",
    'disabled'      => "$disabled",
    'group_kind'    => "$group_kind",
    'link_next'    => "$link_next",
    "post_flg"      => "$post_flg",
    "err_flg"       => "$err_flg",

    "err_day_advance_msg"       => "$err_day_advance_msg",

    // 承認時エラーメッセージ
    "confirm_err"               => "$confirm_err",
    "del_err"                   => "$del_err",
    "cancel_err"                => "$cancel_err",
    "deli_day_renew_err"        => "$deli_day_renew_err",
    "deli_day_act_renew_err"    => "$deli_day_act_renew_err",
    "deli_day_intro_renew_err"  => "$deli_day_intro_renew_err",
    "claim_day_renew_err"       => "$claim_day_renew_err",
    "claim_day_bill_err"        => "$claim_day_bill_err",
    "pay_day_act_err"           => "$pay_day_act_err",
    "pay_day_intro_renew_err"   => "$pay_day_intro_renew_err",
    "error_buy"                 => "$error_buy",
    "err_trade_advance_msg"     => "$err_trade_advance_msg",
    "err_future_date_msg"       => "$err_future_date_msg",
    "err_advance_fix_msg"       => "$err_advance_fix_msg",
    "err_paucity_advance_msg"   => "$err_paucity_advance_msg",

    // 承認時エラー伝票番号
    "confirm_err_no"            => $confirm_err_no,
    "del_err_no"                => $del_err_no,
    "cancel_err_no"             => $cancel_err_no,
    "deli_day_renew_err_no"     => $deli_day_renew_err_no,
    "deli_day_act_renew_err_no" => $deli_day_act_renew_err_no,
    "deli_day_intro_renew_err_no"=> $deli_day_intro_renew_err_no,
    "claim_day_renew_err_no"    => $claim_day_renew_err_no,
    "claim_day_bill_err_no"     => $claim_day_bill_err_no,
    "pay_day_act_err_no"        => $pay_day_act_err_no,
    "pay_day_intro_renew_err_no"=> $pay_day_intro_renew_err_no,
    "error_buy_no"              => $error_buy_no,
    "ary_trade_advance_no"      => $ary_trade_advance_no,
    "ary_future_date_no"        => $ary_future_date_no,
    "ary_advance_fix_no"        => $ary_advance_fix_no,
    "ary_paucity_advance_no"    => $ary_paucity_advance_no,

));

$smarty->assign("html_s", $html_s);
$smarty->assign("html_l", $html_l);
$smarty->assign("html_c", $html_c);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
