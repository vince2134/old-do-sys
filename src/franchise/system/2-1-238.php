<?php
/*
 * 変更履歴
 * 2006-10-12 suzuki 在庫管理しない商品は受払に登録しないように修正
 * 2006-10-12 kaji   受払に略称を登録するように修正
 *                   検索に得意先名、得意先名2、得意先名（略称）を検索するように修正
 *                   在庫管理しない商品は受払に登録するように戻す
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/11      03-030      kajioka-h   配送日の月次更新日チェック処理追加
 *                  03-031      kajioka-h   配送日のシステム開始日チェック処理追加
 *                  03-035      kajioka-h   既に報告されていないかチェック処理追加
 *                  03-045      kajioka-h   保留削除された伝票は表示しない処理追加
 *                  03-048      kajioka-h   委託先は各ショップの得意先マスタに登録されている東陽を使うように
 *  2006/11/14      03-053      kajioka-h   配送日の委託先の月次更新日チェック処理修正
 *  2006/12/10      03-076      suzuki      受払いテーブル登録変数初期化するように修正
 *  2006/12/15      0082        suzuki      受払テーブルに登録する出荷倉庫IDは受注の出荷倉庫IDを使用するように修正
 *  2007/02/19      要件5-1     kajioka-h   商品出荷予定で在庫移動未実施の代行伝票が選択されていた場合に警告メッセージを表示する処理追加
 *  2007/02/28      作業項目67  fukuda-s    一覧を詳細出力
 *  2007/03/05      作業項目67  fukuda-s    金額合計出力
 *  2007/03/05      作業項目12  ふくだ      掛・現金の合計を出力
 *  2007/03/22                  ふくだ      保留削除フラグを削除フラグに変更
 *  2007/03/26      要件12      kajioka-h   報告処理部分を include/fc_sale_report.inc に出した
 *  2007-04-12                  fukuda      検索条件復元処理追加
 *  2007/04/27      他79,152    kajioka-h   代行料の仕様変更
 *  2007/05/31      xx-xxx      kajioka-h   代行伝票報告時に処理状況を「2」にしないようにしたため、抽出条件を変えた
 *  2007/06/14      xx-xxx      kajioka-h   販売区分：05→工事  06：→その他  に変更
 *
 */

$page_title = "受託巡回（報告一覧／確定）";

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
    "form_display_num"  => "1", 
    "form_client_branch"=> "",
    "form_client"       => array("cd1" => "", "cd2" => "", "name" => ""), 
    "form_claim"        => array("cd1" => "", "cd2" => "", "name" => ""), 
    "form_round_day"    => array(
        "sy" => date("Y"), "sm" => date("m"), "sd" => date("d"), "ey" => date("Y"), "em" => date("m"), "ed" => date("d")
    ), 
    "form_claim_day"    => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""), 
    "form_charge_fc"    => array("cd1" => "", "cd2" => "", "name" => "", "select" => ""), 
    "form_slip_no"      => array("s" => "", "e" => ""), 
    "form_contract_div" => "1", 
);

// 検索条件復元
Restore_Filter2($form, "sale", "form_display", $ary_form_list);


/****************************/
//外部変数取得
/****************************/
$shop_id   = $_SESSION["client_id"];  //ログインID
$staff_id  = $_SESSION["staff_id"];   //ログイン者ID


/****************************/
// 初期値設定
/****************************/
$offset         = "0";      // OFFSET
$total_count    = "0";      // 全件数
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // 表示ページ数

// 表示ボタン押下時はPOSTされたフォーム値
if ($_POST["form_display"] != null){
    $range = $_POST["form_range_select"];
// 表示ボタン以外のPOST時はhiddenの値
}elseif ($_POST != null && $_POST["form_display"] == null){
    $range = $_POST["hdn_range_select"];
// POSTがない場合はデフォルトの100件
}else{
    $range = 100;
}


/****************************/
// フォームデフォルト値設定
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
// フォームデフォルト値設定
/****************************/
$form->setDefaults($ary_form_list);


/****************************/
// フォームパーツ定義
/****************************/
/* 共通フォーム */
Search_Form($db_con, $form, $ary_form_list);

// 不要フォームを削除
$form->removeElement("form_client_branch");
$form->removeElement("form_claim");
$form->removeElement("form_claim_day");
$form->removeElement("form_charge_fc");

/* モジュール個別フォーム */
// 伝票番号（開始〜終了）
$obj    =   null;
$obj[]  =&  $form->createElement("text", "s", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", "〜");
$obj[]  =&  $form->createElement("text", "e", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");
$form->addGroup($obj, "form_slip_no", "", "");

// ソートリンク
$ary_sort_item = array(
    "sl_slip"           => "伝票番号",
    "sl_arrival_day"    => "予定巡回日",
    "sl_client_cd"      => "得意先コード",
    "sl_client_name"    => "得意先名",
    "sl_round_staff"    => "巡回担当者<br>（メイン１）",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_arrival_day");

// 表示ボタン
$form->addElement("submit", "form_display", "表　示");

//クリア
$form->addElement("button", "form_clear", "クリア", "onClick=\"javascript:location.href='".$_SERVER["PHP_SELF"]."';\"");

// 合計ボタン
$form->addElement("button", "form_sum", "合　計",
    "onClick=\"javascript: Button_Submit('sum_flg', '".$_SERVER["PHP_SELF"]."#sum', true)\""
);

// 確定ボタン
$form->addElement("button", "form_confirm", "報　告",
    "onClick=\"javascript: Button_Submit('report_flg','".$_SERVER["PHP_SELF"]."', true)\" $disabled"
);

// ヘッダ部用ボタン 予定伝票売上確定
$form->addElement("button", "kakutei_button", "予定伝票売上確定", "onClick=\"location.href='../sale/2-2-206.php'\"");

// ヘッダ部用ボタン 受託巡回
$form->addElement("button", "act_button", "受託巡回", "$g_button_color onClick=\"location.href='2-1-238.php'\"");

// 処理フラグ
$form->addElement("hidden","report_flg");   // 報告フラグ
$form->addElement("hidden","sum_flg");      // 合計フラグ


/****************************/
// 合計ボタン押下時
/****************************/
if ($_POST["sum_flg"] == "true"){

    $con_data["sum_flg"] = false;   //合計ボタン初期化

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
// 確定ボタン押下処理
/****************************/
if($_POST["report_flg"] == "true" || $_POST["warn_report_flg"] == "true"){
    $output_id_array = $_POST["output_id_array"];  //受注ID配列
    $check_num_array = $_POST["form_slip_check"];  //伝票チェック

    //伝票にチェックがある場合に行う
    if($check_num_array != NULL){
        $aord_array = NULL;    //伝票出力受注ID配列
        while($check_num = each($check_num_array)){
            //この添字の受注IDを使用する
            $check = $check_num[0];
            $aord_array[] = $output_id_array[$check];
        }
    }

    require(INCLUDE_DIR."fc_sale_report.inc");

    // 確定用のエラーフラグに名前を変える
    if ($err_flg == true){
        $confirm_err_flg    = true;
        $err_flg            = null;
    }

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

    // 1. フォームの値を変数にセット
    // 2. SESSION（hidden用）の値（検索条件復元関数内でセット）を変数にセット
    // 一覧取得クエリ条件に使用
    $display_num        = $_POST["form_display_num"];
    $attach_branch      = $_POST["form_attach_branch"];
    $client_cd1         = $_POST["form_client"]["cd1"];
    $client_cd2         = $_POST["form_client"]["cd2"];
    $client_name        = $_POST["form_client"]["name"];
    $round_staff_cd     = $_POST["form_round_staff"]["cd"];
    $round_staff_select = $_POST["form_round_staff"]["select"];
    $part               = $_POST["form_part"];
    $multi_staff        = $_POST["form_multi_staff"];
    $ware               = $_POST["form_ware"];
    $round_day_sy       = $_POST["form_round_day"]["sy"];
    $round_day_sm       = $_POST["form_round_day"]["sm"];
    $round_day_sd       = $_POST["form_round_day"]["sd"];
    $round_day_ey       = $_POST["form_round_day"]["ey"];
    $round_day_em       = $_POST["form_round_day"]["em"];
    $round_day_ed       = $_POST["form_round_day"]["ed"];
    $charge_fc_cd1      = $_POST["form_charge_fc"]["cd1"];
    $charge_fc_cd2      = $_POST["form_charge_fc"]["cd2"];
    $charge_fc_name     = $_POST["form_charge_fc"]["name"];
    $charge_fc_select   = $_POST["form_charge_fc"]["select"];
    $slip_no_s          = $_POST["form_slip_no"]["s"];
    $slip_no_e          = $_POST["form_slip_no"]["e"];

    $post_flg = true;

}


/****************************/
// 一覧データ取得条件作成
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null; 

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
    // 巡回担当者（複数選択）
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
    // 伝票番号（開始）
    $sql .= ($slip_no_s != null) ? "AND t_aorder_h.ord_no >= '".str_pad($slip_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // 伝票番号（終了）
    $sql .= ($slip_no_e != null) ? "AND t_aorder_h.ord_no <= '".str_pad($slip_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;

    // 変数詰め替え
    $where_sql = $sql;


    $sql = null;

    // ソート順
    switch ($_POST["hdn_sort_col"]){
        // 伝票番号
        case "sl_slip":
            $sql .= "   ord_no, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   client_cd \n";
            break;
        // 予定巡回日
        case "sl_arrival_day":
            $sql .= "   ord_time, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_no, \n";
            $sql .= "   client_cd \n";
            break;
        // 請求日
        case "sl_claim_day":
            $sql .= "   arrival_day, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_no, \n";
            $sql .= "   client_cd \n";
            break;
        // 得意先コード
        case "sl_client_cd":
            $sql .= "   client_cd, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_no \n";
            break;
        // 得意先名
        case "sl_client_name":
            $sql .= "   client_cname, \n";
            $sql .= "   client_cd, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_no \n";
            break;
        // 巡回担当者（メイン１）
        case "sl_round_staff":
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   ord_no, \n";
            $sql .= "   client_cd \n";
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

    $sql  = "SELECT \n";
    $sql .= "   t_aorder_h.aord_id, \n";                                                    // 受注ID
    $sql .= "   t_aorder_h.ord_no, \n";                                                     // 受注番号
    $sql .= "   t_staff_main.charge_cd, \n";                                                // 担当者CD
    $sql .= "   t_staff_main.staff_name, \n";                                               // 担当者名
    $sql .= "   t_trade.trade_cd, \n";                                                      // 取引区分コード
    $sql .= "   t_trade.trade_name, \n";                                                    // 取引区分
    $sql .= "   t_aorder_h.ord_time, \n";                                                   // 予定巡回日
    $sql .= "   t_aorder_h.client_cname, \n";                                               // 略称
    $sql .= "   t_aorder_h.client_cd1 || '-' || t_aorder_h.client_cd2 AS client_cd, \n";    // 得意先CD
    $sql .= "   t_aorder_h.net_amount, \n";                                                 // 税抜き金額
    $sql .= "   t_aorder_h.tax_amount, \n";                                                 // 消費税
    $sql .= "   t_aorder_h.net_amount + t_aorder_h.tax_amount AS net_tax_amount \n";        // 消費税
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_aorder_staff.aord_id, \n";
    $sql .= "           t_staff.staff_id, \n";
    $sql .= "           CAST(LPAD(t_staff.charge_cd, 4, '0') AS TEXT) AS charge_cd, \n";
    $sql .= "           t_aorder_staff.staff_name, \n";
    $sql .= "           t_attach.part_id \n";
    $sql .= "        FROM \n";
    $sql .= "           t_aorder_staff \n";
    $sql .= "           LEFT JOIN  t_staff  ON t_staff.staff_id = t_aorder_staff.staff_id \n";
    $sql .= "           INNER JOIN t_attach ON t_staff.staff_id = t_attach.staff_id \n";
    $sql .= "        WHERE \n";
    $sql .= "           t_aorder_staff.staff_div = '0' \n";
    $sql .= "        AND \n";
    $sql .= "           t_aorder_staff.sale_rate != '0' \n";
    $sql .= "        AND \n";
    $sql .= "           t_aorder_staff.sale_rate IS NOT NULL \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_staff_main \n";
    $sql .= "   ON t_staff_main.aord_id = t_aorder_h.aord_id \n";
    $sql .= "   LEFT JOIN t_trade ON t_aorder_h.trade_id = t_trade.trade_id \n";
    $sql .= "   LEFT JOIN t_client AS t_client_claim ON t_aorder_h.claim_id = t_client_claim.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.act_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.contract_div = '2' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ord_no IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.trust_confirm_flg = 'f' \n";
    $sql .= "AND \n";
    //$sql .= "   t_aorder_h.ps_stat IN ('1', '2') \n";
    $sql .= "   t_aorder_h.ps_stat = '1' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.del_flg = 'f' \n";
    $sql .= $where_sql;
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
        $sql .= "   t_aorder_d.trust_cost_price, \n";       // 営業原価（受託先）
        $sql .= "   t_aorder_d.sale_price, \n";             // 売上単価
        $sql .= "   t_aorder_d.trust_cost_amount, \n";      // 原価合計額（受託先）
        $sql .= "   t_aorder_d.sale_amount, \n";            // 売上合計額
        $sql .= "   t_aorder_d.egoods_cd, \n";              // 消耗品コード
        $sql .= "   t_aorder_d.egoods_name, \n";            // 消耗品名
        $sql .= "   t_aorder_d.egoods_num, \n";             // 消耗品数量
        $sql .= "   t_aorder_d.rgoods_cd, \n";              // 本体商品コード
        $sql .= "   t_aorder_d.rgoods_name, \n";            // 本体商品名
        $sql .= "   t_aorder_d.rgoods_num \n";              // 本体商品数量
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
// POST時にチェック情報初期化
/****************************/
if(count($_POST)>0 && $move_warning == null && $_POST["sum_flg"] != true){
    for($i = 0; $i < $num_h; $i++){
        $con_data["form_slip_check"][$i] = "";
    }
    $con_data["form_slip_all_check"] = "";   
    $form->setConstants($con_data);
}


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

// エラーのない場合
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
    // フォーム動的部品作成
    /****************************/
    // 報告ALLチェック
    $form->addElement("checkbox", "form_slip_all_check", "", "報告",
        "onClick=\"javascript:All_check('form_slip_all_check','form_slip_check',$num_h)\""
    );
    // ヘッダ部データが1件以上ある場合
    if ($num_h > 0){
        // 報告チェック
        foreach ($page_data_h as $key_h => $value_h){
            $con_data = "";
            // 受注IDをhiddenに追加
            $form->addElement("hidden","output_id_array[$key_h]");                      // 報告受注ID配列
            $con_data["output_id_array[$key_h]"] = $page_data_h[$key_h]["aord_id"];     // 受注ID
            // 報告チェックボックス
            $form->addElement("checkbox", "form_slip_check[$key_h]","","","","");
            $form->setConstants($con_data);
        }
    }

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
    $html_1  = "<table class=\"List_Table\" border=\"1\" width=\"100%\">\n";
    $html_1 .= "    <tr align=\"center\" style=\"font-weight: bold;\">\n";
    $html_1 .= "        <td class=\"Title_Pink\">No.</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_slip")."</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_arrival_day")."</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_client_cd")."<br><br style=\"font-size: 4px;\">".Make_Sort_Link($form, "sl_client_name")."</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_round_staff")."</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">税抜合計</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">消費税</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">伝票金額</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">販売区分</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">サービスコード<br>サービス名</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">商品コード<br>商品名</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">数量</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">営業原価<br>売上単価</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">原価合計額<br>売上合計額</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">消耗品コード<br>消耗品名</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">数量</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">本体商品コード<br>本体商品名</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">数量</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">変更</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\" width=\"150\">";
    $html_1 .=              $form->_elements[$form->_elementIndex["form_slip_all_check"]]->toHtml();
    $html_1 .= "        </td>\n";
    $html_1 .= "    </tr>\n";

    // ヘッダ部でループ
    if ($num_h > 0){
    foreach ($page_data_h as $key_h => $value_h){

        $row_col = ($row_col == "Result2") ? "Result1" : "Result2";  // 1->2, 2->1
        $href    = FC_DIR."sale/2-2-106.php?aord_id[0]=".$value_h["aord_id"]."&back_display=round_act"; // リンク先作成

        // 明細データ データ部の1行目のみ出力するヘッダ部データ その1
        $html_1 .= "    <tr class=\"$row_col\">\n";
        $html_1 .= "        <td align=\"right\">".++$row_num."</td>\n";                                                 // No.
        $html_1 .= "        <td align=\"center\">".$value_h["ord_no"]."</td>\n";                                        // 伝票番号
        $html_1 .= "        <td align=\"center\">".$value_h["ord_time"]."</td>\n";                                      // 予定巡回日
        $html_1 .= "        <td>".$value_h["client_cd"]."<br>".htmlspecialchars($value_h["client_cname"])."<br></td>\n";// 得意先
        if ($value_h["charge_cd"] != null){
        $html_1 .= "        <td>".$value_h["charge_cd"]." : ".htmlspecialchars($value_h["staff_name"])."</td>\n";       // 巡回担当者
        }else{
        $html_1 .= "        <td></td>\n";
        }
        $html_1 .= "        <td align=\"right\">".Font_Color($value_h["net_amount"])."</td>\n";                         // 税抜合計
        $html_1 .= "        <td align=\"right\">".Font_Color($value_h["tax_amount"])."</td>\n";                         // 消費税
        $html_1 .= "        <td align=\"right\">".Font_Color($value_h["net_tax_amount"])."</td>\n";                     // 伝票金額

        $line_cnt = 0;
        // データ部でループ
        foreach ($page_data_d as $key_d => $value_d){
            // ヘッダ部ループの受注IDとデータ部ループの受注IDが同じ場合（該当伝票のデータ部である場合）
            if ($value_h["aord_id"] == $value_d["aord_id"]){
                // データ部ループが1行目でない場合
                //if ($value_d["line"] != "1"){
                if ($line_cnt != 0){
                    // 空tdを配置（8個）
                    $html_1 .= "    <tr class=\"$row_col\">\n";
                    for ($i=0; $i<8; $i++){
                        // 明細データ ヘッダ部を出力しないデータ部データ その1（2行目以降のデータ部データ）
                        $html_1 .= "        <td></td>\n";
                    }
                }
                // 明細データ データ部データ
                $html_1 .= "        <td align=\"center\">".$value_d["sale_div_cd"]."</td>\n";                           // 販売区分
                $html_1 .= "        <td>\n";
                $html_1 .= "            ".$value_d["serv_print_flg"]."　".$value_d["serv_cd"]."<br>\n";                 // 印字/サービスコード
                $html_1 .= "            ".htmlspecialchars($value_d["serv_name"])."<br>\n";                             // サービス名
                $html_1 .= "        </td>\n";
                $html_1 .= "        <td>\n";
                $html_1 .= "            ".$value_d["goods_print_flg"]."　".$value_d["goods_cd"]."<br>\n";               // 商品コード
                $html_1 .= "            ".htmlspecialchars($value_d["official_goods_name"])."<br>\n";                   // 商品名
                $html_1 .= "        </td>\n";
                $html_1 .= "        <td align=\"right\">".$value_d["set_flg"].$value_d["num"]."</td>\n";                // 一式/数量
                $html_1 .= "        <td align=\"right\">\n";
                $html_1 .= "            ".Font_Color($value_d["trust_cost_price"], 2)."<br>\n";                         // 営業原価（受託先）
                $html_1 .= "            ".Font_Color($value_d["sale_price"], 2)."<br>\n";                               // 売上単価
                $html_1 .= "        </td>\n";
                $html_1 .= "        <td align=\"right\">\n";
                $html_1 .= "            ".Font_Color($value_d["trust_cost_amount"])."<br>\n";                           // 原価合計額（受託先）
                $html_1 .= "            ".Font_Color($value_d["sale_amount"])."<br>\n";                                 // 売上合計額
                $html_1 .= "        </td>\n";
                $html_1 .= "        <td>\n";
                $html_1 .= "            ".$value_d["egoods_cd"]."<br>\n";                                               // 消耗品コード
                $html_1 .= "            ".htmlspecialchars($value_d["egoods_name"])."<br>\n";                           // 消耗品名
                $html_1 .= "        </td>\n";
                $html_1 .= "        <td align=\"right\">".$value_d["egoods_num"]."</td>\n";                             // 数量
                $html_1 .= "        <td>\n";
                $html_1 .= "            ".$value_d["rgoods_cd"]."<br>\n";                                               // 本体商品コード
                $html_1 .= "            ".htmlspecialchars($value_d["rgoods_name"])."<br>\n";                           // 本体商品名
                $html_1 .= "        </td>\n";
                $html_1 .= "        <td align=\"right\">".$value_d["rgoods_num"]."</td>\n";                             // 数量
                // データ部ループが1行目の場合
                //if ($value_d["line"] == "1"){
                if ($line_cnt == 0){
                    $html_1 .= "        <td align=\"center\"><a href=\"$href\">変更</a></td>\n";                        // 変更リンク
                    $html_1 .= "        <td align=\"center\">\n";                                                       // 報告チェックボックス
                    $html_1 .= "            ".$form->_elements[$form->_elementIndex["form_slip_check[$key_h]"]]->toHtml()."\n";
                    $html_1 .= "        </td>\n";
                // データ部ループが2行目以降の場合
                }else{
                    // 空tdを配置（2個）
                    for ($i=0; $i<2; $i++){
                        // 明細データ ヘッダ部を出力しないデータ部データ その2（2行目以降のデータ部データ）
                        $html_1 .= "        <td></td>\n";
                    }
                }
                $html_1 .= "    </tr>\n";
                $line_cnt++;
            }
        }

        // 掛・現金の合計算出
        switch ($value_h["trade_cd"]){
            case "11":
            case "15":
            case "13":
            case "14":
                $kake_nuki_amount   += $value_h["net_amount"];
                $kake_tax_amount    += $value_h["tax_amount"];
                $kake_komi_amount   += $value_h["net_tax_amount"];
                break;
            case "61":
            case "63":
            case "64":
                $genkin_nuki_amount += $value_h["net_amount"];
                $genkin_tax_amount  += $value_h["tax_amount"];
                $genkin_komi_amount += $value_h["net_tax_amount"];
                break;
        }

    }
    }

    // 最終行
    $html_1 .= "    <tr class=\"Result3\">\n";
    for ($i=0; $i<5; $i++){
        $html_1 .= "        <td></td>\n";
    }
    $html_1 .= "        <td align=\"right\">".Font_Color($sum_net_amount)."</td>";
    $html_1 .= "        <td align=\"right\">".Font_Color($sum_tax_amount)."</td>";
    $html_1 .= "        <td align=\"right\">".Font_Color($sum_net_tax_amount)."</td>";
    for ($i=0; $i<11; $i++){
        $html_1 .= "        <td></td>\n";
    }
    $html_1 .= "        <td align=\"center\">".$form->_elements[$form->_elementIndex["form_sum"]]->toHtml()."</td>\n";
    $html_1 .= "    </tr>\n";

    $html_1 .= "</table>\n";

    // 合計
    $html_2 .= "<table>\n";
    $html_2 .= "<table class=\"List_Table\" border=\"1\" width=\"500\" align=\"right\">\n";
    $html_2 .= "<col width=\"100\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_2 .= "<col width=\"100\" align=\"right\">\n";
    $html_2 .= "<col width=\"100\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_2 .= "<col width=\"100\" align=\"right\">\n";
    $html_2 .= "<col width=\"100\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_2 .= "<col width=\"100\" align=\"right\">\n";
    $html_2 .= "    <tr class=\"Result1\">\n";
    $html_2 .= "        <td class=\"Title_Pink\">掛売金額</td>\n";
    $html_2 .= "        <td align=\"right\">".Font_Color($money1)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">掛売消費税</td>\n";
    $html_2 .= "        <td align=\"right\">".Font_Color($total_tax1)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">掛売合計</td>\n";
    $html_2 .= "        <td align=\"right\">".Font_Color($total_money1)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "    <tr class=\"Result1\">\n";
    $html_2 .= "        <td class=\"Title_Pink\">現金金額</td>\n";
    $html_2 .= "        <td align=\"right\">".Font_Color($money2)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">現金消費税</td>\n";
    $html_2 .= "        <td align=\"right\">".Font_Color($total_tax2)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">現金合計</td> \n";
    $html_2 .= "        <td align=\"right\">".Font_Color($total_money2)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "    <tr class=\"Result1\">\n";
    $html_2 .= "        <td class=\"Title_Pink\">税抜金額</td>\n";
    $html_2 .= "        <td align=\"right\">".Font_Color($money3)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">消費税合計</td>\n";
    $html_2 .= "        <td align=\"right\">".Font_Color($total_tax3)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">税込合計</td> \n";
    $html_2 .= "        <td align=\"right\">".Font_Color($money3 + $total_tax3)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "</table>\n";

    // まとめ
    $html_l  = "<table width=\"100%\">\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td>\n";
    $html_l .=              $html_page;
    $html_l .= "        </td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td>\n";
    $html_l .=              $html_1;
    $html_l .= "        </td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td>\n";
    $html_l .=              $html_2;
    $html_l .= "        </td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td>\n";
    $html_l .=              $html_page2;
    $html_l .= "        </td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td>\n";
    $html_l .= "<A NAME=\"sum\">\n";
    $html_l .= "<table align=\"right\">\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td>\n";
    $html_l .= $form->_elements[$form->_elementIndex["form_confirm"]]->toHtml();
    $html_l .= "        </td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "</table>\n";
    $html_l .= "        </td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "</table>\n";

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
//$page_menu = Create_Menu_f('sale','2');

/****************************/
// 画面ヘッダー作成
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
    //'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    'error_msg'     => "$error_msg",
    'error_msg2'    => "$error_msg2",
    'error_msg3'    => "$error_msg3",
    'error_sale'    => "$error_sale",
    'auth_r_msg'    => "$auth_r_msg",
    'ord_time_err'  => "$ord_time_err",
    'ord_time_itaku_err'    => "$ord_time_itaku_err",
    'trust_confirm_err'     => "$trust_confirm_err",
    'del_err'       => "$del_err",
    'move_warning'  => "$move_warning",
    'group_kind'    => "$group_kind",

    // 報告時エラーメッセージ
    "trust_confirm_err"         => "$trust_confirm_err",    // 既に巡回報告されていないかチェック
    "ord_time_itaku_err"        => "$ord_time_itaku_err",   // 巡回日チェック月次（委託先が得意先に対して月次やってたら売上確定できないので）
    "ord_time_start_err"        => "$ord_time_start_err",   // システム開始日チェック
    "del_err"                   => "$del_err",              // 削除されているかチェック
    "ord_time_err"              => "$ord_time_err",         // 巡回日チェック月次（自分が委託先に対して月次やってたらダメ）
    "claim_day_bill_err"        => "$claim_day_bill_err",   // 前回の請求締日以降かチェック
    "error_sale"                => "$error_sale",           // 番号が重複した場合
    "err_future_date_msg"       => "$err_future_date_msg",  // 予定巡回日が未来日付の場合のエラー

    // 報告時エラーの伝票番号
    "trust_confirm_no"          => $trust_confirm_no,
    "ord_time_itaku_no"         => $ord_time_itaku_no,
    "ord_time_start_no"         => $ord_time_start_no,
    "del_no"                    => $del_no,
    "ord_time_no"               => $ord_time_no,
    "claim_day_bill_no"         => $claim_day_bill_no,
    "err_sale_no"               => $err_sale_no,
    "ary_future_date_no"        => $ary_future_date_no,
));

$smarty->assign("html_s",$html_s);
$smarty->assign("html_l",$html_l);

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
