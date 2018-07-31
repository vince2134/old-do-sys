<?php
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007-04-09                  fukuda      共通フォームのエラーチェックは関数ひとつで実行できるよう修正
 *
 *
 *
 *
 */

$page_title = "削除伝票一覧";

// 環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB接続
$db_con = Db_Connect();

// 権限チェック
$auth   = Auth_Check($db_con);


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
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))
    ),
    "form_charge_fc"    => array("cd1" => "", "cd2" => "", "name" => "", "select" => array("0" => "", "1" => "")),
    "form_claim_day"    => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""), 
);

// 検索条件復元
Restore_Filter2($form, "contract", "form_display", $ary_form_list);


/****************************/
// 外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];


/****************************/
// 初期値設定
/****************************/
$limit          = null;
$offset         = "0";
$total_count    = "0";
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";


/****************************/
// フォームパーツ定義
/****************************/
/* 共通フォーム */
Search_Form($db_con, $form, $ary_form_list);

/* モジュール別フォーム */
// ソートリンク
$ary_sort_item = array(
    "sl_client_cd"      => "得意先コード",
    "sl_client_name"    => "得意先名",
    "sl_slip"           => "伝票番号",
    "sl_arrival_day"    => "予定巡回日",
    "sl_round_staff"    => "巡回担当者<br>（メイン１）",
    "sl_act_client_cd"  => "代行先コード",
    "sl_act_client_name"=> "代行先名",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_round_staff");

// 表示ボタン
$form->addElement("submit", "form_display", "表　示");

// クリアボタン
$form->addElement("button","form_clear","クリア", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");


/****************************/
// 表示ボタン押下時
/****************************/
if ($_POST["form_display"] != null){

    /****************************/
    // エラーチェック
    /****************************/
    // ■共通フォームチェック
    Search_Err_Chk($form);

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
if (($_POST["form_display"] != null && $err_flg != true) || ($_POST != null && $_POST["form_display"] == null)){

    // 日付POSTデータの0埋め
    $_POST["form_round_day"] = Str_Pad_Date($_POST["form_round_day"]);
    $_POST["form_claim_day"] = Str_Pad_Date($_POST["form_claim_day"]);

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
    $charge_fc_cd1      = $_POST["form_charge_fc"]["cd1"];
    $charge_fc_cd2      = $_POST["form_charge_fc"]["cd2"];
    $charge_fc_name     = $_POST["form_charge_fc"]["name"];
    $charge_fc_select   = $_POST["form_charge_fc"]["select"]["1"];

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
        $sql .= "   t_round_staff.staff_id IN \n";
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
    // 得意先コード１
    $sql .= ($client_cd1 != null) ? "AND t_aorder_h.client_cd1 LIKE '$client_cd1%' \n" : null;
    // 得意先コード２
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
    $sql .= ($round_staff_cd != null) ? "AND t_round_staff.charge_cd = '$round_staff_cd' \n" : null;
    // 巡回担当者セレクト
    $sql .= ($round_staff_select != null) ? "AND t_round_staff.staff_id = $round_staff_select \n" : null;
    // 部署
    $sql .= ($part != null) ? "AND t_round_staff.part_id = $part \n" : null;
    // 請求先コード１   
    $sql .= ($claim_cd1 != null) ? "AND t_client_claim.client_cd1 LIKE '$claim_cd1%' \n" : null;
    // 請求先コード２
    $sql .= ($claim_cd2 != null) ? "AND t_client_claim.client_cd2 LIKE '$claim_cd2%' \n" : null;
    // 請求先名
    if ($client_name != null){
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
        $sql .= "   t_round_staff.charge_cd IN (";
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

    // 変数詰め直し
    $where_sql = $sql;


    $sql = null;

    // ソート順
    switch ($_POST["hdn_sort_col"]){
        // 得意先コード
        case "sl_client_cd":
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2, \n";
            $sql .= "   t_round_staff.charge_cd, \n";
            $sql .= "   t_act_client.client_cd1, \n";
            $sql .= "   t_act_client.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.ord_no \n";
            break;
        // 得意先名
        case "sl_client_name":
            $sql .= "   t_aorder_h.client_cname, \n";
            $sql .= "   t_round_staff.charge_cd, \n";
            $sql .= "   t_act_client.client_cd1, \n";
            $sql .= "   t_act_client.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
            break;
        // 伝票番号
        case "sl_slip":
            $sql .= "   t_aorder_h.ord_no \n";
            break;
        // 予定巡回日
        case "sl_arrival_day":
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_round_staff.charge_cd, \n";
            $sql .= "   t_act_client.client_cd1, \n";
            $sql .= "   t_act_client.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
            break;
        // 巡回担当者（メイン１）
        case "sl_round_staff":
            $sql .= "   t_round_staff.charge_cd, \n";
            $sql .= "   t_act_client.client_cd1, \n";
            $sql .= "   t_act_client.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
            break;
        // 代行先コード
        case "sl_act_client_cd":
            $sql .= "   t_act_client.client_cd1, \n";
            $sql .= "   t_act_client.client_cd2, \n";
            $sql .= "   t_round_staff.charge_cd, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
            break;
        // 代行先名
        case "sl_act_client_name":
            $sql .= "   t_act_client.client_cname, \n";
            $sql .= "   t_act_client.client_cd1, \n";
            $sql .= "   t_act_client.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_round_staff.charge_cd, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
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
    $sql .= "   t_aorder_h.aord_id, \n";                                        // 受注ID
    $sql .= "   t_aorder_h.ord_no, \n";                                         // 受注番号
    $sql .= "   t_aorder_h.client_cd1 || '-' || t_aorder_h.client_cd2 \n";
    $sql .= "   AS client_cd, \n";                                              // 得意先コード
    $sql .= "   t_aorder_h.client_cname, \n";                                   // 得意先略称
    $sql .= "   t_aorder_h.ord_time, \n";                                       // 受注日（予定巡回日）
    $sql .= "   t_round_staff.charge_cd, \n";                                   // 担当者コード
    $sql .= "   t_round_staff.staff_name, \n";                                  // 担当者名
    $sql .= "   t_act_client.client_cd1 || '-' || t_act_client.client_cd2 \n";
    $sql .= "   AS act_cd, \n";                                                 // 代行先コード
    $sql .= "   t_act_client.client_cname AS act_name, \n";                     // 代行先FC略称
    $sql .= "   t_trade.trade_name, \n";
    $sql .= "   t_aorder_h.net_amount, \n";                                     // 売上金額（税抜）
    $sql .= "   t_aorder_h.tax_amount, \n";                                     // 消費税額
    $sql .= "   t_aorder_h.net_amount + t_aorder_h.tax_amount \n";
    $sql .= "   AS price_amount, \n";                                           // 売上金額（税込）
    $sql .= "   t_aorder_h.reason_cor \n";                                      // 訂正理由
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "   INNER JOIN t_client ON t_aorder_h.client_id = t_client.client_id \n";
    $sql .= "   LEFT JOIN t_client AS t_client_claim ON t_aorder_h.claim_id = t_client_claim.client_id \n";
    $sql .= "   LEFT JOIN t_client AS t_act_client   ON t_aorder_h.act_id = t_act_client.client_id \n";
    $sql .= "   LEFT JOIN t_trade ON t_aorder_h.trade_id = t_trade.trade_id \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_aorder_staff.aord_id, \n";
    $sql .= "           t_aorder_staff.staff_id, \n";
    $sql .= "           CAST(LPAD(t_staff.charge_cd, 4, '0') AS TEXT) AS charge_cd, \n";
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
    $sql .= "   AS t_round_staff \n";
    $sql .= "   ON t_aorder_h.aord_id = t_round_staff.aord_id \n";
    // 伝票番号付番済
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.ord_no IS NOT NULL \n";
    // 削除伝票
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.del_flg = 't' \n";
    // 取得対象
    // 直営は契約区分に関係なく全て取得
    // FCは自社巡回伝票と、代行IDが自社のオンライン代行伝票を取得
    $sql .= "AND \n";
    if ($_SESSION["group_kind"] == "2"){
    $sql .= "   t_aorder_h.shop_id IN (".Rank_Sql().") \n";
    }else{
    $sql .= "   ( \n";
    $sql .= "       t_aorder_h.shop_id = $shop_id \n";
    $sql .= "       OR \n";
    $sql .= "       (t_aorder_h.contract_div = '2' AND t_aorder_h.act_id = $shop_id) \n";
    $sql .= "   ) \n";
    }
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
    $limit_offset   = ($limit != null) ? "LIMIT $limit OFFSET $offset \n" : null;
    $res            = Db_Query($db_con, $sql.$limit_offset.";");
    $match_count    = pg_num_rows($res);
    $ary_aord_data  = Get_Data($res, 2, "ASSOC");

}


/****************************/
// 表示用データ作成
/****************************/
if ($post_flg == true && $err_flg != true){

    if ($ary_aord_data != null){
    foreach ($ary_aord_data as $key => $value){

        // 印刷用改行設定
        $ary_aord_data[$key]["return"] = (bcmod($key, 30) == 0 && $key != "0") ? " style=\"page-break-before: always;\"" : null;

        // 伝票番号リンク作成
        $ary_aord_data[$key]["slip_no_link"]  = "<a href=\"./2-2-106.php?aord_id[0]=".$value["aord_id"]."&back_display=reserve\">";
        $ary_aord_data[$key]["slip_no_link"] .= $value["ord_no"];
        $ary_aord_data[$key]["slip_no_link"] .= "</a>";

        // 「担当者コード：担当者名」を作成
        if ($value["charge_cd"] != null){
            $ary_aord_data[$key]["staff"] = str_pad($value["charge_cd"], 4, "0", STR_PAD_LEFT)."：".htmlspecialchars($value["staff_name"]);
        }

        // 掛・現金の税抜・消費税額を算出
        // 掛売上時
        if ($value["trade_name"] == "掛売上"){
            // 現金売上（税抜）算出
            $kake_notax     += $value["net_amount"];
            // 掛消費税算出
            $kake_tax       += $value["tax_amount"];
        // 現金売上時
        }elseif ($value["trade_name"] == "現金売上"){
            // 現金売上（税抜）算出
            $genkin_notax   += $value["net_amount"];
            // 現金消費税算出
            $genkin_tax     += $value["tax_amount"];
        }

        // 代行先コードがハイフンだけの場合はNULLにする
        $ary_aord_data[$key]["act_cd"] = ($value["act_cd"] != "-") ? $value["act_cd"] : "";

    }
    }

    // 売上合計
    $kake_ontax     = $kake_notax + $kake_tax;
    // 現金合計
    $genkin_ontax   = $genkin_notax + $genkin_tax;
    // 税抜合計
    $notax_amount   = $kake_notax + $genkin_notax;
    // 消費税合計
    $tax_amount     = $kake_tax + $genkin_tax;
    // 税込合計
    $ontax_amount   = $kake_ontax + $genkin_ontax;

}


/****************************/
// HTML用関数
/****************************/
function Number_Format_Color($num){
    return ($num < 0) ? "<span style=\"color: #ff0000;\">".number_format($num)."</span>" : number_format($num);
}


/****************************/
// HTML作成（検索部）
/****************************/
// 共通検索テーブル
$html_s .= Search_Table($form);
// モジュール個別検索テーブル
# 無し
// ボタン
$html_s .= "\n";
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_display"]]->toHtml()."　\n";;
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_clear"]]->toHtml()."\n";
$html_s .= "</td></tr></table>\n";
$html_s .= "\n";


/****************************/
// HTML作成（一覧部）
/****************************/
if ($post_flg == true){

    // ページ分け
    $html_page  = Html_Page2($total_count, $page_count, 1, $limit);
    $html_page2 = Html_Page2($total_count, $page_count, 2, $limit);

    // 一覧テーブル
    $html_1  = "\n";
//    $html_1 .= "<table class=\"List_Table\" width=\"100%\" border=\"1\">\n";
    $html_1 .= "<table class=\"List_Table\" border=\"1\">\n";
    $html_1 .= "    <tr align=\"center\" style=\"font-weight: bold;\">\n";
    $html_1 .= "        <td class=\"Title_Pink\">No.</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_client_cd")."<br><br style=\"font-size: 4px;\">".Make_Sort_Link($form, "sl_client_name")."</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_slip")."</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_arrival_day")."</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_round_staff")."</td>\n";
    if ($_SESSION["group_kind"] == "2"){
        $html_1 .= "        <td class=\"Title_Act\">".Make_Sort_Link($form, "sl_act_client_cd")."<br><br style=\"font-size: 4px;\">".Make_Sort_Link($form, "sl_act_client_name")."</td>\n";
    }
    $html_1 .= "        <td class=\"Title_Pink\">取引区分</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">売上金額</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">消費税</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">伝票合計</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">訂正理由</td>\n";
    $html_1 .= "    </tr>\n";
    if ($ary_aord_data != null){
    foreach ($ary_aord_data as $key => $value){
        if (bcmod($key, 2) == 0){
        $html_1 .= "    <tr class=\"Result1\"".$value["return"].">\n";
        }else{
        $html_1 .= "    <tr class=\"Result2\"".$value["return"].">\n";
        }
        $html_1 .= "        <td align=\"right\">".((($page_count - 1) * $limit) + $key + 1)."</td>\n";
        $html_1 .= "        <td>".$value["client_cd"]."<br>".htmlspecialchars($value["client_cname"])."<br></td>\n";
        $html_1 .= "        <td align=\"center\">".$value["slip_no_link"]."</td>\n";
        $html_1 .= "        <td align=\"center\">".$value["ord_time"]."</td>\n";
        $html_1 .= "        <td>".$value["staff"]."</td>\n";
        if ($_SESSION["group_kind"] == "2"){
            $html_1 .= "        <td>".$value["act_cd"]."<br>".htmlspecialchars($value["act_name"])."<br></td>\n";
        }
        $html_1 .= "        <td align=\"center\">".$value["trade_name"]."</td>";
        $html_1 .= "        <td align=\"right\">".Number_Format_Color($value["net_amount"])."</td>\n";
        $html_1 .= "        <td align=\"right\">".Number_Format_Color($value["tax_amount"])."</td>\n";
        $html_1 .= "        <td align=\"right\">".Number_format_Color($value["price_amount"])."</td>\n";
        $html_1 .= "        <td>".htmlspecialchars($value["reason_cor"])."</td>\n";
        $html_1 .= "    </tr>\n";
    }
    }
    $html_1 .= "</table>\n";
    $html_1 .= "\n";

    // 合計テーブル
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
    $html_2 .= "        <td>".Number_format_Color($kake_notax)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">掛売消費税</td>\n";
    $html_2 .= "        <td>".Number_format_Color($kake_tax)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">掛売合計</td>\n";
    $html_2 .= "        <td>".Number_format_Color($kake_ontax)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "    <tr class=\"Result1\">\n";
    $html_2 .= "        <td class=\"Title_Pink\">現金金額</td>\n";
    $html_2 .= "        <td>".Number_format_Color($genkin_notax)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">現金消費税</td>\n";
    $html_2 .= "        <td>".Number_format_Color($genkin_tax)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">現金合計</td>\n";
    $html_2 .= "        <td>".Number_format_Color($genkin_ontax)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "    <tr class=\"Result1\">\n";
    $html_2 .= "        <td class=\"Title_Pink\">税抜合計</td>\n";
    $html_2 .= "        <td>".Number_format_Color($notax_amount)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">消費税合計</td>\n";
    $html_2 .= "        <td>".Number_format_Color($tax_amount)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">税込合計</td>\n";
    $html_2 .= "        <td>".Number_format_Color($ontax_amount)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "</table>\n";
    $html_2 .= "\n";

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
//画面ヘッダー作成
/****************************/
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
    "html_page"     =>  $html_page,
    "html_page2"    =>  $html_page2,
    "html_s"        =>  $html_s,
    "html_1"        =>  $html_1,
    "html_2"        =>  $html_2,
));

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
