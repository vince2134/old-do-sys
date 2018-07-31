<?php
/****************************
 *　変更履歴
 *     (20060807) 本部の発注データを抽出しているバグ修正<watanabe-k>
*****************************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/10/31      08-025      ふ          検索日付の日付フォームにフォーカスを合わせても本日の日付が表示されないバグを修正
 *  2006/11/01      08-018      ふ          最新伝票取消後の、ブラウザのリロード（再SUBMIT）により新たに作成された伝票が削除されるバグを修正
 *  2006/11/03      08-009      suzuki      既に受注を起こしているデータを取消したときにエラーメッセージ表示
 *                  08-024      suzuki      得意先CD表示
 *  2006/11/09      08-148      suzuki      エラー時にはデータを表示しない
 *  2006/12/07      ban_0044    suzuki      日付をゼロ埋め
 *  2007/02/05                  watanabe-k  「FC発注日」「希望納期」「得意先」を以下に変更
                                            「ショップ名」「FC発注日」「発注番号」「希望納期」
 *  2007/02/05                  watanabe-k  「出荷予定日」列の入力ボタンは伝票毎に一つに纏める
 *  2007/02/07                  watanabe-k  ＦＣ発注関連の列で黄色を表示
 *  2007-04-05                  fukuda      検索条件復元処理追加
 *
 *
 */

$page_title = "受注納期返信(オンライン)";

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


/****************************/
// 検索条件復元関連
/****************************/
// 検索フォーム初期値配列
$ary_form_list = array(
    "form_display_num"  => "1",
    "form_client"       => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_ord_day"      => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y"))),
    ),
    "form_ord_no"       => array("s" => "", "e" => ""),
    "form_hope_day"     => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_direct"       => "",
);

// 検索条件復元
Restore_Filter2($form, "aord", "show_button", $ary_form_list);


/****************************/
// 外部変数取得
/****************************/
$staff_id = $_SESSION["staff_id"];
$shop_id  = $_SESSION["shop_id"];

//選択されたデータの発注IDを取得
$ord_id = $_POST["ord_id_flg"];


/****************************/
// 初期値設定
/****************************/
$form->setDefaults($ary_form_list);

$limit          = null;     // LIMIT
$offset         = "0";      // OFFSET
$total_count    = "0";      // 全件数
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // 表示ページ数


/****************************/
// フォームパーツ定義
/****************************/
// 表示件数
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "全て", "1");
$obj[]  =&  $form->createElement("radio", null, null, "100",  "2");
$form->addGroup($obj, "form_display_num", "", "");

// FC・取引先
Addelement_Client_64n($form, "form_client", "FC・取引先", "-");

// FC発注日
Addelement_Date_Range($form, "form_ord_day", "FC発注日", "-");

// FC発注番号
Addelement_Slip_Range($form, "form_ord_no", "FC発注番号", "-");

// 希望納期
Addelement_Date_Range($form, "form_hope_day", "希望納期", "-");

// 直送先
$form->addElement("text", "form_direct", "", "size=\"34\" maxLength=\"15\" $g_form_option");

// 受注納期一覧表
$form->addElement("button", "aord_limit", "受注納期一覧表", "onClick=\"javascript:window.open('".HEAD_DIR."sale/1-2-109.php')\"");

// ソートリンク
$ary_sort_item = array(
    "sl_client_cd"      => "FC・取引先コード",
    "sl_client_name"    => "FC・取引先名",
    "sl_fc_ord_day"     => "FC発注日",
    "sl_fc_ord_no"      => "FC発注番号",
    "sl_direct"         => "直送先",
    "sl_hope_day"       => "希望納期",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_fc_ord_day");

// 表示ボタン
$form->addElement("submit", "show_button", "表　示");

// クリアボタン
$form->addElement("button", "clear_button", "クリア", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// 処理フラグ
$form->addElement("hidden", "data_cancel_flg");
$form->addElement("hidden", "ord_id_flg");
$form->addElement("hidden", "hdn_del_enter_date");


/****************************/
// 取消リンク押下時
/****************************/
if ($_POST["data_cancel_flg"] == "true"){

    $hdn_del_enter_date = $_POST["hdn_del_enter_date"];

    //受注データを起こしているか判定
    $sql  = "SELECT fc_ord_id FROM t_aorder_h WHERE fc_ord_id = $ord_id;";
    $result = Db_Query($db_con,$sql);
    $check_num = pg_num_rows($result);

    if ($check_num != 0){

        //既に受注を起こしている為エラー表示
        $error_msg = "既に受注データが存在している為取消できません。";

    }else{
        //発注取消処理

        Db_Query($db_con, "BEGIN;");

        $data_cancel  = "UPDATE \n";
        $data_cancel .= "   t_order_h \n";
        $data_cancel .= "SET \n";
        $data_cancel .= "   ord_stat = '3', \n";
        $data_cancel .= "   can_staff_id = $staff_id, \n";
        $data_cancel .= "   can_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $staff_id), \n";
        $data_cancel .= "   can_day = NOW() \n";
        $data_cancel .= "WHERE \n";
        $data_cancel .= "   ord_id = $ord_id \n";
        $data_cancel .= "AND \n";
        $data_cancel .= "   enter_day = '$hdn_del_enter_date' \n";
        $data_cancel .= ";";
        //該当データ件数
        $result = Db_Query($db_con, $data_cancel);

        if($result == false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        Db_Query($db_con, "COMMIT;");
    }

    // hiddenをクリア
    $clear_hdn["data_cancel_flg"]       = "";
    $clear_hdn["hdn_del_enter_date"]    = "";
    $form->setConstants($clear_hdn);

    $post_flg = true;

}


/****************************/
// 表示ボタン押下処理
/****************************/
if ($_POST["show_button"] == "表　示"){

    // 日付POSTデータの0埋め
    $_POST["form_ord_day"]  = Str_Pad_Date($_POST["form_ord_day"]);
    $_POST["form_hope_day"] = Str_Pad_Date($_POST["form_hope_day"]);

    /****************************/
    // エラーチェック
    /****************************/
    // ■FC発注日
    // エラーメッセージ
    $err_msg = "FC発注日 の日付が妥当ではありません。";
    Err_Chk_Date($form, "form_ord_day", $err_msg);

    // ■希望納期
    // エラーメッセージ
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
if (($_POST["show_button"] != null && $err_flg != true) || ($_POST != null && $_POST["show_button"] == null)){

    // 日付POSTデータの0埋め
    $_POST["form_ord_day"]  = Str_Pad_Date($_POST["form_ord_day"]);
    $_POST["form_hope_day"] = Str_Pad_Date($_POST["form_hope_day"]);

    // 1. フォームの値を変数にセット
    // 2. SESSION（hidden用）の値（検索条件復元関数内でセット）を変数にセット
    // 一覧取得クエリ条件に使用
    $display_num    = $_POST["form_display_num"];
    $client_cd1     = $_POST["form_client"]["cd1"];
    $client_cd2     = $_POST["form_client"]["cd2"];
    $client_name    = $_POST["form_client"]["name"];
    $ord_day_sy     = $_POST["form_ord_day"]["sy"];
    $ord_day_sm     = $_POST["form_ord_day"]["sm"];
    $ord_day_sd     = $_POST["form_ord_day"]["sd"];
    $ord_day_ey     = $_POST["form_ord_day"]["ey"];
    $ord_day_em     = $_POST["form_ord_day"]["em"];
    $ord_day_ed     = $_POST["form_ord_day"]["ed"];
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
    $sql .= ($client_cd1 != null) ? "AND t_client.client_cd1 LIKE '$client_cd1%' \n" : null;
    // FC・取引先コード２
    $sql .= ($client_cd2 != null) ? "AND t_client.client_cd2 LIKE '$client_cd2%' \n" : null;
    // FC・取引先名
    if ($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_client.client_name  LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
    // FC発注日（開始）
    $ord_day_s = $ord_day_sy."-".$ord_day_sm."-".$ord_day_sd;
    $sql .= ($ord_day_s != "--") ? "AND '$ord_day_s 00:00:00' <= t_order_h.ord_time \n" : null;
    // FC発注日（終了）
    $ord_day_e = $ord_day_ey."-".$ord_day_em."-".$ord_day_ed;
    $sql .= ($ord_day_e != "--") ? "AND t_order_h.ord_time <= '$ord_day_e 23:59:59' \n" : null;
    // FC発注番号（開始）
    $sql .= ($ord_no_s != null) ? "AND t_order_h.ord_no >= '".str_pad($ord_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // FC発注番号（終了）
    $sql .= ($ord_no_e != null) ? "AND t_order_h.ord_no <= '".str_pad($ord_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // 希望納期（開始）
    $hope_day_s = $hope_day_sy."-".$hope_day_sm."-".$hope_day_sd;
    $sql .= ($hope_day_s != "--") ? "AND '$hope_day_s' <= t_order_h.hope_day \n" : null;
    // 希望納期（終了）
    $hope_day_e = $hope_day_ey."-".$hope_day_em."-".$hope_day_ed;
    $sql .= ($hope_day_e != "--") ? "AND t_order_h.hope_day <= '$hope_day_e' \n" : null;
    // 直送先
    if ($direct_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_order_h.direct_name  LIKE '%$direct_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_order_h.direct_name2 LIKE '%$direct_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_order_h.direct_cname LIKE '%$direct_name%' \n";
        $sql .= "   ) \n";
    }

    // 変数詰め替え
    $where_sql = $sql;


    $sql = null;

    // ソート順
    switch ($_POST["hdn_sort_col"]){
        // FC・取引先コード
        case "sl_client_cd":
            $sql .= "   t_client.client_cd1, \n";
            $sql .= "   t_client.client_cd2, \n";
            $sql .= "   t_order_h.send_date, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_order_d.line \n";
            break;
        // FC・取引先名
        case "sl_client_name":
            $sql .= "   t_client.client_cname, \n";
            $sql .= "   t_order_h.send_date, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_client.client_cd1, \n";
            $sql .= "   t_client.client_cd2, \n";
            $sql .= "   t_order_d.line \n";
            break;
        // FC発注日
        case "sl_fc_ord_day":
            $sql .= "   t_order_h.send_date, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_client.client_cd1, \n";
            $sql .= "   t_client.client_cd2, \n";
            $sql .= "   t_order_d.line \n";
            break;
        // FC発注番号
        case "sl_fc_ord_no":
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_order_h.send_date, \n";
            $sql .= "   t_client.client_cd1, \n";
            $sql .= "   t_client.client_cd2, \n";
            $sql .= "   t_order_d.line \n";
            break;
        // 直送先
        case "sl_direct":
            $sql .= "   t_direct.direct_cname, \n";
            $sql .= "   t_order_h.send_date, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_client.client_cd1, \n";
            $sql .= "   t_client.client_cd2, \n";
            $sql .= "   t_order_d.line \n";
            break;
        // 希望納期
        case "sl_hope_day":
            $sql .= "   t_order_h.hope_day, \n";
            $sql .= "   t_order_h.send_date, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_client.client_cd1, \n";
            $sql .= "   t_client.client_cd2, \n";
            $sql .= "   t_order_d.line \n";
            break;
    }

    // 変数詰め替え
    $order_sql = $sql;

}


/****************************/
// 出力する伝票をリストアップ
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   t_order_h.ord_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_order_h \n";
    $sql .= "   INNER JOIN t_client  ON t_order_h.shop_id = t_client.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_order_h.ord_stat = '1' \n";
    $sql .= $where_sql;

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
    $match_count    = pg_num_rows($res);
    $ary_list_data  = Get_Data($res, 2, "ASSOC");

}


/****************************/
// 発注残データ取得SQL
/****************************/
if ($match_count > 0 && $post_flg == true && $err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   t_order_h.ord_id, \n";
    $sql .= "   to_char(t_order_h.send_date, 'yyyy-mm-dd') AS ord_day, \n";
    $sql .= "   to_char(t_order_h.send_date, 'hh24:mi') AS ord_day_time, \n";
    $sql .= "   t_order_h.hope_day, \n";
    $sql .= "   t_client.client_cd1, \n";
    $sql .= "   t_client.client_cd2, \n";
    $sql .= "   t_client.client_cname, \n";
    $sql .= "   t_order_d.goods_cd, \n";
    $sql .= "   t_order_d.goods_name, \n";
    $sql .= "   t_order_d.buy_price, \n";
    $sql .= "   t_order_d.num, \n";
    $sql .= "   t_order_d.buy_amount, \n";
    $sql .= "   t_order_h.enter_day, \n";
    $sql .= "   t_order_h.ord_no, \n";
    $sql .= "   t_order_h.note_your, \n";
    $sql .= "   t_direct.direct_cname \n";
    $sql .= "FROM \n";
    $sql .= "   t_order_h \n";
    $sql .= "   INNER JOIN t_order_d ON t_order_h.ord_id = t_order_d.ord_id \n";
    $sql .= "   INNER JOIN t_client  ON t_order_h.shop_id = t_client.client_id \n";
    $sql .= "   LEFT  JOIN t_direct  ON t_order_h.direct_id = t_direct.direct_id \n";
    $sql .= "   INNER JOIN t_goods   ON t_order_d.goods_id = t_goods.goods_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_order_h.ord_stat = '1' \n";
    $sql .= "AND \n";
    $sql .= "   t_order_h.ord_id IN (";
    foreach ($ary_list_data as $key => $value){
    $sql .= $value["ord_id"];
    $sql .= ($key+1 < count($ary_list_data)) ? ", " : ") \n"; 
    }
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);

    // ページ内データ取得
    $res        = Db_Query($db_con, $sql);
    $ary_data   = Get_Data($res, 2, "ASSOC");

}


/****************************/
// 表示用データ作成
/****************************/
if ($post_flg == true && $err_flg != true){

    /****************************/
    // 表示用データ整形
    /****************************/
    // ページ内データでループ
    if (count($ary_data) > 0){
        // No.初期値
        $i = 0;
        // 行数初期値
        $row = 0;
        // 
        $html_l = null;
        foreach ($ary_data as $key => $value){

            // 前・次の参照行を変数に入れて使いやすくしておく
            $back = $ary_data[$key-1];
            $next = $ary_data[$key+1];

            // ■No.の出力設定
            // 配列の最初、または前回と今回の発注IDが異なる場合
            if ($key == 0 || $back["ord_id"] != $value["ord_id"]){
                $no             = ++$i;
            }else{
                $no             = null;
            }
            // ■FC・取引先
            // No.がある場合
            if ($no != null){
                $client         = $value["client_cd1"];
                $client        .= ($value["client_cd2"] != null) ? "-".$value["client_cd2"] : null;
                $client        .= "<br>";
                $client        .= htmlspecialchars($value["client_cname"]);
                $client        .= "<br>";
            }else{
                $client         = null;
            }
            // ■FC発注日
            // No.がある場合
            if ($no != null){
                $ord_date       = $value["ord_day"]."<br>".$value["ord_day_time"]."<br>";
            }else{
                $ord_date       = null;
            }
            // ■直送先
            // No.がある場合
            if ($no != null){
                $direct         = htmlspecialchars($value["direct_cname"]);
            }else{
                $direct         = null;
            }
            // ■FC発注番号
            // No.がある場合
            if ($no != null){
                $ord_no         = $value["ord_no"];
            }else{
                $ord_no         = null;
            }
            // ■希望納期
            // No.がある場合
            if ($no != null){
                $hope_day       = $value["hope_day"];
            }else{
                $hope_day       = null;
            }
            // ■商品
            $goods              = $value["goods_cd"]."<br>".htmlspecialchars($value["goods_name"]);
            // ■単価
            $buy_price          = number_format($value["buy_price"], 2);
            // ■数量
            $num                = number_format($value["num"]);
            // ■合計金額
            $buy_amount         = number_format($value["buy_amount"]);
            // ■通信欄（本部宛）
            // No.がある場合
            if ($no != null){
                $note_your      = htmlspecialchars($value["note_your"]);
            }else{
                $note_your      = null;
            }
            // ■出荷予定日返信リンク
            // No.がある場合
            if ($no != null){
                $arrival_link   = "<a href=\"./1-2-104.php?ord_id=".$value["ord_id"]."&return_flg=1\">入力</a>";
            }else{
                $arrival_link   = null;
            }
            // ■取消リンク
            // No.がある場合かつ権限がある場合
            if ($no != null && $disabled == null){
                $can_link       = "<a href=\"#\" onClick=\"Order_Cancel('data_cancel_flg', 'ord_id_flg', ".$value["ord_id"].", 'hdn_del_enter_date', '".$value["enter_day"]."');\">取消</a></td>";
            }else{
                $can_link       = null;
            }
            // ■行色css
            if ($no != null){
                $css            = (bcmod($no, 2) == 0) ? "Result2" : "Result1";
            }else{
                $css            = $css;
            }

            // ■まとめ
            // 行色css
            $disp_data[$row]["css"]             = $css;
            // No.
            $disp_data[$row]["no"]              = $no;
            // FC・取引先
            $disp_data[$row]["client"]          = $client;
            // FC発注日
            $disp_data[$row]["ord_date"]        = $ord_date;
            // FC発注番号
            $disp_data[$row]["ord_no"]          = $ord_no;
            // 直送先
            $disp_data[$row]["direct"]          = $direct;
            // 希望納期
            $disp_data[$row]["hope_day"]        = $hope_day;
            // 商品
            $disp_data[$row]["goods"]           = $goods;
            // 単価
            $disp_data[$row]["buy_price"]       = $buy_price;
            // 数量
            $disp_data[$row]["num"]             = $num;
            // 合計金額
            $disp_data[$row]["buy_amount"]      = $buy_amount;
            // 通信欄（本部宛）
            $disp_data[$row]["note_your"]       = $note_your;
            // 出荷予定日返信リンク
            $disp_data[$row]["arrival_link"]    = $arrival_link;
            // 取消リンク
            $disp_data[$row]["can_link"]        = $can_link;

            // 一覧html作成
            $html_l .= "    <tr class=\"$css\">\n";
            $html_l .= "        <td align=\"right\">$no</td>\n";
            $html_l .= "        <td>$client</td>\n";
            $html_l .= "        <td align=\"center\">$ord_date</td>\n";
            $html_l .= "        <td align=\"center\">$ord_no</td>\n";
            $html_l .= "        <td>$direct</td>\n";
            $html_l .= "        <td align=\"center\">$hope_day</td>\n";
            $html_l .= "        <td>$goods</td>\n";
            $html_l .= "        <td align=\"right\">$buy_price</td>\n";
            $html_l .= "        <td align=\"right\">$num</td>\n";
            $html_l .= "        <td align=\"right\">$buy_amount</td>\n";
            $html_l .= "        <td>$note_your</td>\n";
            $html_l .= "        <td align=\"center\" class=\"color\">$arrival_link</td>\n";
            $html_l .= "        <td align=\"center\">$can_link</td>\n";
            $html_l .= "    </tr>\n";

            // 行数加算
            $row++;

        }
    }

}


/****************************/
// js
/****************************/
$order_cancel  = " function Order_Cancel(hidden1,hidden2,ord_id,hidden3,enter_date){\n";
$order_cancel .= "    res = window.confirm(\"取消します。よろしいですか？\");\n";
$order_cancel .= "    if (res == true){\n";
$order_cancel .= "        var id = ord_id;\n";
$order_cancel .= "        var edate = enter_date;\n";
$order_cancel .= "        var hdn1 = hidden1;\n";
$order_cancel .= "        var hdn2 = hidden2;\n";
$order_cancel .= "        var hdn3 = hidden3;\n";
$order_cancel .= "        document.dateForm.elements[hdn1].value = 'true';\n";
$order_cancel .= "        document.dateForm.elements[hdn2].value = id;\n";
$order_cancel .= "        document.dateForm.elements[hdn3].value = edate;\n";
$order_cancel .= "        //同じウィンドウで遷移する\n";
$order_cancel .= "        document.dateForm.target=\"_self\";\n";
$order_cancel .= "        //自画面に遷移する\n";
$order_cancel .= "        document.dateForm.action='".$_SERVER["PHP_SELF"]."';\n";
$order_cancel .= "        //POST情報を送信する\n";
$order_cancel .= "        document.dateForm.submit();\n";
$order_cancel .= "        return true;\n";
$order_cancel .= "  }else{\n";
$order_cancel .= "        return false;\n";
$order_cancel .= "  }\n";
$order_cancel .= "}\n";


/****************************/
// HTML作成（検索部）
/****************************/
// 検索項目
$html_s .= "\n";
$html_s .= "<table width=\"100%\">\n";
$html_s .= "    <tr style=\"color: #555555;\">\n";
$html_s .= "        <td colspan=\"2\">\n";
$html_s .= "            <b>表示件数</b>".($form->_elements[$form->_elementIndex["form_display_num"]]->toHtml())."\n";
$html_s .= "            　　<span style=\"color: #0000ff; font-weight: bold;\">・「FC・取引先」検索は名前もしくは略称です</span>\n";
$html_s .= "        </td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
$html_s .= "<table class=\"Table_Search\" width=\"700px\">\n";
$html_s .= "    <col width=\" 90px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col>\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_1\">FC・取引先</td>\n";
$html_s .= "        <td class=\"Td_Search_1\">".($form->_elements[$form->_elementIndex["form_client"]]->toHtml())."</td>\n";
$html_s .= "        <td class=\"Td_Search_1\">FC発注日</td>\n";
$html_s .= "        <td class=\"Td_Search_1\">".($form->_elements[$form->_elementIndex["form_ord_day"]]->toHtml())."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "    </tr>\n";
$html_s .= "        <td class=\"Td_Search_1\">FC発注番号</td>\n";
$html_s .= "        <td class=\"Td_Search_1\">".($form->_elements[$form->_elementIndex["form_ord_no"]]->toHtml())."</td>\n";
$html_s .= "        <td class=\"Td_Search_1\">希望納期</td>\n";
$html_s .= "        <td class=\"Td_Search_1\">".($form->_elements[$form->_elementIndex["form_hope_day"]]->toHtml())."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "    </tr>\n";
$html_s .= "        <td class=\"Td_Search_1\">直送先</td>\n";
$html_s .= "        <td class=\"Td_Search_1\" colspan=\"3\">".($form->_elements[$form->_elementIndex["form_direct"]]->toHtml())."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
// ボタン
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["show_button"]]->toHtml()."　\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["clear_button"]]->toHtml()."\n";
$html_s .= "</td></tr></table>";
$html_s .= "\n";

$html_page  = Html_Page2($total_count, $page_count, 1, $limit);
$html_page2 = Html_Page2($total_count, $page_count, 2, $limit);


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
$page_menu = Create_Menu_h('sale','1');
/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

/****************************/
//ページ作成
/****************************/
// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//初期表示判定
$smarty->assign('row',$page_data);

//その他の変数をassign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    'order_cancel'  => "$order_cancel",
    'ord_day_err'   => "$ord_day_err",
    'hope_day_err'  => "$hope_day_err",
    'auth_r_msg'    => "$auth_r_msg",
    'total_count'   => "$total_count",
    'disabled'      => "$disabled",
    'error_msg'     => "$error_msg",
    "post_flg"      => "$post_flg",
    "err_flg"       => "$err_flg",
));

$smarty->assign("html", array(
    "html_s"        => $html_s,
    "html_l"        => $html_l,
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
