<?php
/****************************
 * 変更履歴
 *      ・（20060811）入力チェックと売上入力に必須マークは削除<watanabe-k>
 *      ・(20060811)売上入力の列は、売上済のデータを「-」でなく「済」と表示するよう変更<watanabe-k>
 *
 *
 *
 *
 *
*****************************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/10/30      08-002      ふ          売上の行っていない分納受注伝票を削除した場合は、残りの分納受注伝票も削除するよう修正
 *  2006/10/30      08-019      ふ          リロードによる伝票削除防止のため、伝票削除時に伝票作成日時と照らし合わせる
 *  2006/10/31      08-059      ふ          売上の行われている伝票の分納受注伝票（未売上）は削除できないよう修正
 *  2006/10/31      08-034      ふ          オフライン受注かつ入力チェック未実施の売上入力欄が「済」になっているバグを修正
 *  2006/10/31      08-032      ふ          日次更新で検索した場合の結果がおかしいバグを修正
 *  2006/11/01      08-011      ふ          売上の行われている受注伝票（分納でない）は削除できないよう修正
 *  2006/11/06      08-033      watanabe-k  受注日に2006-10-2aと入力し、検索した場合にエラーメッセージが表示されないバグの修正
 *  2006/11/06      08-065      watanabe-k  出荷予定日の日付半角数字チェック追加
 *  2006/11/08      08-128      suzuki      得意先を略称表示
 *  2006/12/07      ban_0045    suzuki      日付をゼロ埋め
 *  2007/01/25                  watanabe-k  ボタンの色変更
 *  2007/02/07                  watanabe-k  受注番号、発注番号の表示を変更
 *  2007/03/26                  watanabe-k　削除した場合に、発注取り消しまでは行なわないように修正 
 *  2007-04-05                  fukuda      検索条件復元処理追加
 *  2007-05-07                  fukuda      ソート順を日付の昇順に変更
 *
 *
 */

$page_title = "受注照会";

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
    "form_client"       => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_c_staff"      => array("cd" => "", "select" => ""),
    "form_ware"         => "",
    "form_claim"        => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_multi_staff"  => "",
    "form_aord_day"     => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))
    ),
    "form_arrival_day"  => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_aord_no"      => array("s" => "", "e" => ""),
    "form_aord_type"    => "1",
    "form_ord_no"       => array("s" => "", "e" => ""),
    "form_hope_day"     => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_direct"       => "",
);

// 検索条件復元
Restore_Filter2($form, array("aord", "sale"), "form_show_button", $ary_form_list);


/****************************/
// 外部変数取得
/****************************/
$shop_id  = $_SESSION["client_id"];


/****************************/
// 初期値設定
/****************************/
$form->setDefaults($ary_form_list);

$limit          = null;     // LIMIT
$offset         = "0";      // OFFSET
$total_count    = "0";      // 全件数
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // 表示ページ数


/****************************/
//フォーム作成
/****************************/
/* 共通フォーム */
Search_Form_Aord($db_con, $form, $ary_form_list);

/* モジュール別フォーム */
// 本部受注番号
Addelement_Slip_Range($form, "form_aord_no", "受注番号");

// 受注法式
$item   =   null;
$item[] =   $form->createElement("radio", null, null, "指定なし",   "1");
$item[] =   $form->createElement("radio", null, null, "オンライン", "2");
$item[] =   $form->createElement("radio", null, null, "オフライン", "3");
$form->addGroup($item, "form_aord_type", "");

// FC発注番号
Addelement_Slip_Range($form, "form_ord_no", "発注番号");

// 希望納期
Addelement_Date_Range($form, "form_hope_day", "希望納期", "-");

// ソートリンク
$ary_sort_item = array(
    "sl_aord_no"        => "本部受注番号",
    "sl_ord_no"         => "FC発注番号",
    "sl_direct"         => "直送先",
    "sl_aord_day"       => "受注日",
    "sl_client_cd"      => "FC・取引先コード",
    "sl_client_name"    => "FC・取引先名",
    "sl_hope_day"       => "希望納期",
    "sl_arrival_day"    => "出荷予定日",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_aord_day");

// 表示ボタン
$form->addElement("submit", "form_show_button", "表　示");

// クリア
$form->addElement("button", "form_clear_button", "クリア", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// ヘッダ部リンクボタン
$ary_h_btn_list = array("照会・変更" => $_SERVER["PHP_SELF"], "入　力" => "./1-2-101.php", "受注残一覧" => "./1-2-106.php");
Make_H_Link_Btn($form, $ary_h_btn_list);

// 処理フラグ
$form->addElement("hidden","data_delete_flg");
$form->addElement("hidden","aord_id_flg");
$form->addElement("hidden","hdn_del_enter_date");

// エラーセット用hidden
$form->addElement("text", "err_saled_slip", null, null);


/****************************/
// 削除リンク押下処理
/****************************/
if($_POST["data_delete_flg"] == "true"){

    /*** 削除前調査 ***/
    // 選択されたデータの受注IDを取得
    $aord_id    = $_POST["aord_id_flg"];
    // 選択された受注伝票の作成日次を取得
    $enter_date = $_POST["hdn_del_enter_date"];

    // POSTされた削除受注IDが正当か（伝票作成日時を元に）調べる
    $valid_flg = Update_check($db_con, "t_aorder_h", "aord_id", $aord_id, $enter_date);

    /* 受注伝票がオンライン受注かオフライン受注かを調べる */
    // 正当伝票フラグがtrueの場合
    if ($valid_flg == true){
        $sql  = "SELECT fc_ord_id FROM t_aorder_h WHERE aord_id = $aord_id;";
        $res  = Db_Query($db_con, $sql);
        // オンライン受注の場合は発注IDを、オフライン受注の場合はnullを変数に代入
        $fc_ord_id = (pg_fetch_result($res, 0, 0) != null) ? pg_fetch_result($res, 0, 0) : false;
    }

    /* オフライン受注の場合は分納データの有無を確認 */
    // 正当伝票フラグがtrueかつオンライン受注フラグがtrueの場合
    if ($valid_flg == true && $fc_ord_id != null){
        $sql  = "SELECT \n";
        $sql .= "   aord_id \n";
        $sql .= "FROM \n";
        $sql .= "   t_aorder_h \n";
        $sql .= "WHERE \n";
        $sql .= "   fc_ord_id = (SELECT fc_ord_id FROM t_aorder_h WHERE aord_id = $aord_id) \n";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        if (pg_num_rows($res) > 1){
            $bunnou_flg = true;
            // 削除受注IDの伝票と同じ発注IDを持つ受注ID（分納伝票ID）を配列に代入
            for ($i=0; $i<pg_num_rows($res); $i++){
                $ary_del_aord_id[$i] = pg_fetch_result($res, $i, 0);
            }
        }else{
            $bunnou_flg = false;
        }
    }

    /* 該当伝票から売上が起こされていないか調べるS */
    // 正当伝票フラグがtrueの場合
    if ($valid_flg == true){
        $sql  = "SELECT \n";
        $sql .= "   sale_id \n";
        $sql .= "FROM \n";
        $sql .= "   t_sale_h \n";
        $sql .= "WHERE \n";
        $sql .= "   aord_id IN \n";
        $sql .= "   ( \n";
        // 分納フラグがtrueの場合
        if ($bunnou_flg == true){
            foreach ($ary_del_aord_id as $key => $value){
                $sql .= "       $value";
                $sql .= ($key+1 < count($ary_del_aord_id)) ? ", \n" : " \n";
            }
        // 分納フラグがtrueで無い場合
        }else{
                $sql .= "       $aord_id \n";
        }
        $sql .= "   ) \n";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        $saled_flg = (pg_num_rows($res) > 0) ? true : false;
    }
        
    /*** 削除できない場合（分納伝票で売上が行われている）のエラーメッセージセット ***/
    // 売上フラグがtrueの場合
    if ($saled_flg == true){
        // エラーをセット
        $slip = ($bunnou_flg == true) ? "分納伝票" : "伝票";
        $form->setElementError("err_saled_slip", "売上済の".$slip."があるため、削除できません。");
    }

    /*** 削除処理 ***/
    // 正当伝票フラグがtrueかつ、売上フラグがtrueでない場合（該当受注伝票から売上が起こされていない場合）
    if ($valid_flg == true && $saled_flg != true){

        Db_Query($db_con, "BEGIN;");

        // 受注伝票削除SQL
        $sql  = "DELETE FROM \n";
        $sql .= "   t_aorder_h \n";
        $sql .= "WHERE \n";
        if ($bunnou_flg == true){
            $sql .= "   aord_id IN (";
            foreach ($ary_del_aord_id as $key => $value){
                $sql .= $value;
                $sql .= ($key+1 < count($ary_del_aord_id)) ? ", " : null;
            }
            $sql .= ") \n";
        }else{
            $sql .= "   aord_id = $aord_id \n";
        }
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);

        // 削除エラーの場合はコミット
        if($res === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        // オンライン受注の場合
        if ($fc_ord_id != null){

            // 上記で取得した発注IDを元に、残りの伝票数をカウント
            $sql  = "SELECT ";
            $sql .= "   COUNT(ord_no) ";
            $sql .= "FROM ";
            $sql .= "   t_aorder_h ";
            $sql .= "WHERE ";
            $sql .= "   fc_ord_id = $fc_ord_id ";
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $num = pg_fetch_result($res, 0, 0);

            //伝票数が０の場合
            if($num == 0){
                $sql  = "UPDATE t_order_h SET ";
                $sql .= "   ord_stat = '1' ";
                $sql .= "WHERE ";
                $sql .= "   ord_id = $fc_ord_id ";
                $sql .= ";";
                $res  = Db_Query($db_con, $sql);
                if($res === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
            }
        }

        //06-03-29 kaji 正常終了時のCOMMIT忘れ
        Db_Query($db_con, "COMMIT;");

    }

    // hiddenをクリア
    $clear_hdn["data_delete_flg"]       = "";   
    $clear_hdn["hdn_del_enter_date"]    = "";   
    $form->setConstants($clear_hdn);

}


/****************************/
// 表示ボタン押下処理
/****************************/
if ($_POST["form_show_button"] == "表　示"){

    // 日付POSTデータの0埋め
    $_POST["form_aord_day"]     = Str_Pad_Date($_POST["form_aord_day"]);
    $_POST["form_hope_day"]     = Str_Pad_Date($_POST["form_hope_day"]);
    $_POST["form_arrival_day"]  = Str_Pad_Date($_POST["form_arrival_day"]);

    /****************************/
    // エラーチェック
    /****************************/
    // ■受注担当者
    $err_msg = "受注担当者 は数値のみ入力可能です。";
    Err_Chk_Num($form, "form_c_staff", $err_msg);

    // ■受注担当複数選択
    $err_msg = "受注担当複数選択 は数値と「,」のみ入力可能です。";
    Err_Chk_Delimited($form, "form_multi_staff", $err_msg);

    // ■受注日
    $err_msg = "受注日 の日付が妥当ではありません。";
    Err_Chk_Date($form, "form_aord_day", $err_msg);

    // ■出荷予定日
    $err_msg = "出荷予定日 は数値のみ入力可能です。";
    Err_Chk_Date($form, "form_arrival_day", $err_msg);

    // ■希望納期
    $err_msg = "希望納期 の日付が妥当ではありません。";
    Err_Chk_Date($form, "form_hope_day", $err_msg);

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
if (($_POST["form_show_button"] != null && $err_flg != true) || ($_POST != null && $_POST["form_show_button"] == null)){

    // 日付POSTデータの0埋め
    $_POST["form_aord_day"]     = Str_Pad_Date($_POST["form_aord_day"]);
    $_POST["form_hope_day"]     = Str_Pad_Date($_POST["form_hope_day"]);
    $_POST["form_arrival_day"]  = Str_Pad_Date($_POST["form_arrival_day"]);

    // 1. フォームの値を変数にセット
    // 2. SESSION（hidden用）の値（検索条件復元関数内でセット）を変数にセット
    // 一覧取得クエリ条件に使用
    $display_num    = $_POST["form_display_num"];
    $client_cd1     = $_POST["form_client"]["cd1"];
    $client_cd2     = $_POST["form_client"]["cd2"];
    $client_name    = $_POST["form_client"]["name"];
    $c_staff_cd     = $_POST["form_c_staff"]["cd"];
    $c_staff_select = $_POST["form_c_staff"]["select"];
    $ware           = $_POST["form_ware"];
    $claim_cd1      = $_POST["form_claim"]["cd1"];
    $claim_cd2      = $_POST["form_claim"]["cd2"];
    $claim_name     = $_POST["form_claim"]["name"];
    $multi_staff    = $_POST["form_multi_staff"];
    $aord_day_sy    = $_POST["form_aord_day"]["sy"];
    $aord_day_sm    = $_POST["form_aord_day"]["sm"];
    $aord_day_sd    = $_POST["form_aord_day"]["sd"];
    $aord_day_ey    = $_POST["form_aord_day"]["ey"];
    $aord_day_em    = $_POST["form_aord_day"]["em"];
    $aord_day_ed    = $_POST["form_aord_day"]["ed"];
    $arrival_day_sy = $_POST["form_arrival_day"]["sy"];
    $arrival_day_sm = $_POST["form_arrival_day"]["sm"];
    $arrival_day_sd = $_POST["form_arrival_day"]["sd"];
    $arrival_day_ey = $_POST["form_arrival_day"]["ey"];
    $arrival_day_em = $_POST["form_arrival_day"]["em"];
    $arrival_day_ed = $_POST["form_arrival_day"]["ed"];
    $aord_no_s      = $_POST["form_aord_no"]["s"];
    $aord_no_e      = $_POST["form_aord_no"]["e"];
    $aord_type      = $_POST["form_aord_type"];
    $ord_no_s       = $_POST["form_ord_no"]["s"];
    $ord_no_e       = $_POST["form_ord_no"]["e"];
    $hope_day_sy    = $_POST["form_hope_day"]["sy"];
    $hope_day_sm    = $_POST["form_hope_day"]["sm"];
    $hope_day_sd    = $_POST["form_hope_day"]["sd"];
    $hope_day_ey    = $_POST["form_hope_day"]["ey"];
    $hope_day_em    = $_POST["form_hope_day"]["em"];
    $hope_day_ed    = $_POST["form_hope_day"]["ed"];
    $direct_name    = $_POST["form_direct"];

    $post_flg = true;

}


/****************************/
// 一覧データ取得条件作成
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // FC・取引先コード１
    $sql .= ($client_cd1 != null) ? "AND t_aorder_h.client_cd1 LIKE '$client_cd1%' \n" : null;
    // FC・取引先コード２
    $sql .= ($client_cd2 != null) ? "AND t_aorder_h.client_cd2 LIKE '$client_cd2%' \n" : null;
    // FC・取引先名
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
    // 受注担当者コード
    $sql .= ($c_staff_cd != null) ? "AND t_staff.charge_cd = '$c_staff_cd' \n" : null;
    // 受注担当者セレクト
    $sql .= ($c_staff_select != null) ? "AND t_staff.staff_id = $c_staff_select \n" : null;
    // 倉庫
    $sql .= ($ware != null) ? "AND t_aorder_h.ware_id = $ware \n" : null;
    // 請求先コード１
    $sql .= ($claim_cd1 != null) ? "AND t_client.client_cd1 LIKE '$claim_cd1%' \n" : null;
    // 請求先コード２
    $sql .= ($claim_cd2 != null) ? "AND t_client.client_cd2 LIKE '$claim_cd2%' \n" : null;
    // 請求先名
    if ($claim_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_client.client_name  LIKE '%$claim_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client.client_name2 LIKE '%$claim_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client.client_cname LIKE '%$claim_name%' \n";
        $sql .= "   ) \n";
    }
    // 受注担当複数選択
    if ($multi_staff != null){
        $ary_multi_staff = explode(",", $multi_staff);
        $sql .= "AND \n";
        $sql .= "   t_staff.charge_cd IN (";
        foreach ($ary_multi_staff as $key => $value){
            $sql .= "'".trim($value)."'";
            $sql .= ($key+1 < count($ary_multi_staff)) ? ", " : ") \n";
        }
    }
    // 受注日（開始）
    $aord_day_s = $aord_day_sy."-".$aord_day_sm."-".$aord_day_sd;
    $sql .= ($aord_day_s != "--") ? "AND '$aord_day_s' <= t_aorder_h.ord_time \n" : null;
    // 受注日（終了）
    $aord_day_e = $aord_day_ey."-".$aord_day_em."-".$aord_day_ed;
    $sql .= ($aord_day_e != "--") ? "AND t_aorder_h.ord_time <= '$aord_day_e' \n" : null;
    // 出荷予定日（開始）
    $arrival_day_s = $arrival_day_sy."-".$arrival_day_sm."-".$arrival_day_sd;
    $sql .= ($arrival_day_s != "--") ? "AND '$arrival_day_s' <= t_aorder_h.arrival_day \n" : null;
    // 出荷予定日（終了）
    $arrival_day_e = $arrival_day_ey."-".$arrival_day_em."-".$arrival_day_ed;
    $sql .= ($arrival_day_e != "--") ? "AND t_aorder_h.arrival_day <= '$arrival_day_e' \n" : null;
    // 本部受注番号（開始）
    $sql .= ($aord_no_s != null) ? "AND t_aorder_h.ord_no >= '".str_pad($aord_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // 本部受注番号（終了）
    $sql .= ($aord_no_e != null) ? "AND t_aorder_h.ord_no <= '".str_pad($aord_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // 受注方式
    if ($aord_type == "2"){
        $sql .= "AND t_aorder_h.fc_ord_id IS NOT NULL \n";
    }else
    if ($aord_type == "3"){
        $sql .= "AND t_aorder_h.fc_ord_id IS NULL \n";
    }
    // FC発注番号（開始）
    $sql .= ($ord_no_s != null) ? "AND t_order_h.ord_no >= '".str_pad($ord_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // FC発注番号（終了）
    $sql .= ($ord_no_e != null) ? "AND t_order_h.ord_no <= '".str_pad($ord_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // 希望納期（開始）
    $hope_day_s = $hope_day_sy."-".$hope_day_sm."-".$hope_day_sd;
    $sql .= ($hope_day_s != "--") ? "AND '$hope_day_s' <= t_aorder_h.hope_day \n" : null;
    // 希望納期（終了）
    $hope_day_e = $hope_day_ey."-".$hope_day_em."-".$hope_day_ed;
    $sql .= ($hope_day_e != "--") ? "AND t_aorder_h.hope_day <= '$hope_day_e' \n" : null;
    // 直送先
    if ($direct_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_aorder_h.direct_name  LIKE '%$direct_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_aorder_h.direct_name2 LIKE '%$direct_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_aorder_h.direct_cname LIKE '%$direct_name%' \n";
        $sql .= "   ) \n";
    }

    // 変数詰め替え
    $where_sql = $sql;


    $sql = null;

    // ソート順
    switch ($_POST["hdn_sort_col"]){
        // 本部受注番号
        case "sl_aord_no":
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
            break;
        // FC発注番号
        case "sl_ord_no":
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.ord_time \n";
            break;
        // 直送先
        case "sl_direct":
            $sql .= "   t_aorder_h.direct_cname, \n" ;
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
            break;
        // 受注日
        case "sl_aord_day":
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
            break;
        // FC・取引先コード
        case "sl_client_cd":
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.ord_no \n";
            break;
        // FC・取引先名
        case "sl_client_name":
            $sql .= "   t_aorder_h.client_cname, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
            break;
        // 希望納期
        case "sl_hope_day":
            $sql .= "   t_aorder_h.hope_day, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
            break;
        // 出荷予定日
        case "sl_arrival_day":
            $sql .= "   t_aorder_h.arrival_day, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
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
    $sql .= "   t_aorder_h.aord_id, \n";
    $sql .= "   t_aorder_h.ord_time, \n";
    $sql .= "   t_aorder_h.ord_no as aord_no, \n";
    $sql .= "   t_aorder_h.client_cname, \n";
    $sql .= "   t_aorder_h.net_amount+t_aorder_h.tax_amount, \n";
    $sql .= "   t_aorder_h.hope_day, \n";
    $sql .= "   t_aorder_h.arrival_day, \n";
    $sql .= "   t_aorder_h.check_flg, \n";
    $sql .= "   t_aorder_h.check_user_name, \n";
    $sql .= "   t_order_h.ord_no, \n";
    $sql .= "   t_aorder_h.finish_flg, \n";
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_aorder_h.fc_ord_id IS NULL \n";
    $sql .= "       THEN 'f' \n";
    $sql .= "       ELSE 't' \n";
    $sql .= "   END \n";
    $sql .= "   AS online_flg, \n";
    $sql .= "   t_aorder_h.ps_stat, \n";
    $sql .= "   t_aorder_h.client_cd1, \n";
    $sql .= "   t_aorder_h.client_cd2, \n";
    $sql .= "   to_char(t_aorder_h.renew_day, 'yyyy-mm-dd') AS date, \n";
    $sql .= "   t_aorder_h.enter_day, \n";
    $sql .= "   t_saled_ord.fc_ord_id AS saled_ord_id, \n";
    $sql .= "   t_aorder_h.direct_cname \n";
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "   LEFT JOIN t_order_h ON t_order_h.ord_id = t_aorder_h.fc_ord_id \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_aorder_h.fc_ord_id \n";
    $sql .= "       FROM \n";
    $sql .= "           t_sale_h \n";
    $sql .= "           INNER JOIN t_aorder_h ON t_sale_h.aord_id = t_aorder_h.aord_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_aorder_h.fc_ord_id IS NOT NULL \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           t_aorder_h.fc_ord_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_saled_ord \n";
    $sql .= "   ON t_aorder_h.fc_ord_id = t_saled_ord.fc_ord_id \n";
    $sql .= "   LEFT JOIN t_staff  ON t_aorder_h.c_staff_id = t_staff.staff_id \n";
    $sql .= "   LEFT JOIN t_client ON t_aorder_h.claim_id = t_client.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.shop_id = $shop_id \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;

    // 全件数取得
    $res            = Db_Query($db_con, $sql.";");
    $total_count    = pg_num_rows($res);

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

    // ページ内データ取得
    $limit_offset   = ($limit != null) ? "LIMIT $limit OFFSET $offset " : null;
    $res            = Db_Query($db_con, $sql.$limit_offset.";");
    $num            = pg_num_rows($res);
    $page_data      = Get_Data($res);

}

//合計金額計算
for($i = 0; $i < $num; $i++){
    $total_price = bcadd($total_price,$page_data[$i][4]);
}
$total_price = number_format($total_price);

// 整形
for($i = 0; $i < $num; $i++){
    $page_data[$i][4]  = number_format($page_data[$i][4]);          // 受注金額
}


/****************************/
// JavaScript
/****************************/
$order_delete  = " function Order_Delete(hidden1,hidden2,ord_id,hidden3,enter_date){\n";
$order_delete .= "    res = window.confirm(\"削除します。よろしいですか？\");\n";
$order_delete .= "    if (res == true){\n";
$order_delete .= "        var id = ord_id;\n";
$order_delete .= "        var edate = enter_date;\n";
$order_delete .= "        var hdn1 = hidden1;\n";
$order_delete .= "        var hdn2 = hidden2;\n";
$order_delete .= "        var hdn3 = hidden3;\n";
$order_delete .= "        document.dateForm.elements[hdn1].value = 'true';\n";
$order_delete .= "        document.dateForm.elements[hdn2].value = id;\n";
$order_delete .= "        document.dateForm.elements[hdn3].value = edate;\n";
$order_delete .= "        //同じウィンドウで遷移する\n";
$order_delete .= "        document.dateForm.target=\"_self\";\n";
$order_delete .= "        //自画面に遷移する\n";
$order_delete .= "        document.dateForm.action='".$_SERVER["PHP_SELF"]."';\n";
$order_delete .= "        //POST情報を送信する\n";
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
$html_s .= Search_Table_Aord($form);
$html_s .= "<br style=\"font-size: 4px;\">\n";
// モジュール個別検索テーブル１
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"130px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">本部受注番号</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_aord_no"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">受注方式</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_aord_type"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
// モジュール個別検索テーブル２
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"130px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">FC発注番号</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_ord_no"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">希望納期</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_hope_day"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
// ボタン
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_show_button"]]->toHtml()."　\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_clear_button"]]->toHtml()."\n";
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
$page_menu = Create_Menu_h("sale", "1");

/****************************/
// 画面ヘッダー作成
/****************************/
$page_title .= Print_H_Link_Btn($form, $ary_h_btn_list);
$page_header = Create_Header($page_title);

/****************************/
//ページ作成
/****************************/
$html_page  = Html_Page2($total_count, $page_count, 1, $limit);
$html_page2 = Html_Page2($total_count, $page_count, 2, $limit);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form関連の変数をassign
$smarty->assign("form", $renderer->toArray());
$smarty->assign("row", $page_data);

// その他の変数をassign
$smarty->assign("var", array(
    "html_header"   => "$html_header",
    "page_menu"     => "$page_menu",
    "page_header"   => "$page_header",
    "html_footer"   => "$html_footer",
    "html_page"     => "$html_page",
    "html_page2"    => "$html_page2",
    "total_price"   => "$total_price",
    "order_delete"  => "$order_delete",
    "disabled"      => "$disabled",
    "no"            => ($page_count * $limit - $limit) + 1,
    "post_flg"      => "$post_flg",
    "err_flg"       => "$err_flg",
));

$smarty->assign("html", array(
    "html_s"        => $html_s,
));

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
