<?php
/*
 *  2007-08-28       watanabe-k     前受入金額と前受操作医学を表示
 *
 *
 *
 */

$page_title = "前受金残高一覧";

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
    "form_count_day"    => array(
        "y" => date("Y"),
        "m" => date("m"),
        "d" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))
    ),
    "form_display_num"  => "50",
    "form_client"       => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_group"        => array("name" => "", "select" => ""),
    "form_state"        => "1",
);

// 検索条件復元
Restore_Filter2($form, "advance", "form_display", $ary_form_list);


/****************************/
//外部変数取得
/****************************/
// SESSION
$shop_id    = $_SESSION["client_id"];


/****************************/
// 初期値設定
/****************************/
$limit          = "50";     // LIMIT
$offset         = "0";      // OFFSET
$display_num    = $limit;   // 表示件数
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // 表示ページ数

$form->setDefaults($ary_form_list);


/****************************/
// フォームパーツ定義
/****************************/
// 集計日
Addelement_Date($form, "form_count_day", "", "-");

// 表示件数
$item   =   null;
$item   =   array("10" => "10", "50" => "50", "100" => "100", null => "全て");
$form->addElement("select", "form_display_num", "", $item, $g_form_option_select);

// 得意先
Addelement_Client_64n($form, "form_client", "", "-");

// グループ
$item   =   null;
$item   =   Select_Get($db_con, "client_gr");
$obj    =   null;
$obj[]  =   $form->createElement("text", "name", "", "size=\"34\" maxLength=\"25\" $g_form_option");
$obj[]  =   $form->createElement("static", "", "", " ");
$obj[]  =   $form->createElement("select", "select", "", $item, $g_form_option_select);
$form->addGroup($obj, "form_group", "", "");

// 状態（取引先）
$obj    =   null;   
$obj[]  =&  $form->createElement("radio", null, null, "取引中",       "1");   
$obj[]  =&  $form->createElement("radio", null, null, "解約・休止中", "2");
$obj[]  =&  $form->createElement("radio", null, null, "全て",         "0");   
$form->addGroup($obj, "form_state", "");

// 表示ボタン
$form->addElement("submit", "form_display", "表　示");

// クリアボタン
$form->addElement("button","form_clear","クリア", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");


/****************************/
// 表示ボタン押下時
/****************************/
if ($_POST["form_display"] != null){

    // 日付POSTデータの0埋め
    $_POST["form_count_day"] = Str_Pad_Date($_POST["form_count_day"]);

    /****************************/
    // エラーチェック
    /****************************/
    // ■集計日
    // 必須チェック
    if ($_POST["form_count_day"]["y"] == null || $_POST["form_count_day"]["m"] == null || $_POST["form_count_day"]["d"] == null){
        $form->setElementError("form_count_day", "集計日 は必須です。");
    }else{
        Err_Chk_Date($form, "form_count_day", "集計日 の日付が妥当ではありません。");
    }

    /****************************/
    // エラーチェック結果集計
    /****************************/
    // チェック適用
    $test = $form->validate();

    // 結果をフラグに
    $err_flg = (count($form->_errors) > 0) ? true : false;

}


/****************************/
// POSTを変数にセット
/****************************/
if ($_POST != null && $err_flg != true){

    // 日付POSTデータの0埋め
    $_POST["form_count_day"] = Str_Pad_Date($_POST["form_count_day"]);

    // POSTデータを変数にセット
    $count_day_y    = $_POST["form_count_day"]["y"];
    $count_day_m    = $_POST["form_count_day"]["m"];
    $count_day_d    = $_POST["form_count_day"]["d"];
    $display_num    = $_POST["form_display_num"];
    $client_cd1     = $_POST["form_client"]["cd1"];
    $client_cd2     = $_POST["form_client"]["cd2"];
    $client_name    = $_POST["form_client"]["name"];
    $group_name     = $_POST["form_group"]["name"];
    $group_select   = $_POST["form_group"]["select"];
    $state          = $_POST["form_state"];

    $post_flg = true;

}


/****************************/
// 一覧データ取得条件作成
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // 集計日
    $count_day = $count_day_y.$count_day_m.$count_day_d;
    $count_day = ($count_day != null) ? $count_day : date("Ymd");
    // 得意先コード１
    $sql .= ($client_cd1 != null) ? "AND t_client.client_cd1 LIKE '$client_cd1%' \n" : null;
    // 得意先コード２
    $sql .= ($client_cd2 != null) ? "AND t_client.client_cd2 LIKE '$client_cd2%' \n" : null;
    // 得意先名
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
    // グループ名
    $sql .= ($group_name != null) ? "AND t_client_gr.client_gr_name LIKE '%$group_name%' \n" : null;
    // グループセレクト
    $sql .= ($group_select != null) ? "AND t_client_gr.client_gr_id = $group_select \n" : null;
    // 取引状態
    $sql .= ($state != "0") ? "AND t_client.state = $state \n" : null;

    // 変数詰め替え
    $where_sql = $sql;

}


/****************************/
// 一覧データ取得
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2 AS client_cd, \n";
    $sql .= "   t_client.client_cname, \n";
    $sql .= "   advance_data.advance_total, \n";
    $sql .= "   payin_data.payin_total, \n";
    $sql .= "   COALESCE(advance_data.advance_total, 0) - COALESCE(payin_data.payin_total, 0) AS advances_balance \n";
    $sql .= "FROM \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           client_id \n";
    $sql .= "       FROM \n";
    $sql .= "           t_advance \n";
    $sql .= "       WHERE \n";
    $sql .= "           pay_day <= '$count_day' \n";
    $sql .= "       AND \n";
    $sql .= "           shop_id = $shop_id \n";
    $sql .= "       UNION \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_payin_h.client_id \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payin_h \n";
    $sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payin_h.pay_day <= '$count_day' \n";
    $sql .= "       AND \n";
    $sql .= "           t_payin_d.trade_id = 40 \n";
    $sql .= "       AND \n";
    $sql .= "           t_payin_h.shop_id = $shop_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS client_list \n";
    $sql .= "   INNER JOIN t_client    ON client_list.client_id = t_client.client_id \n";
    $sql .= "   LEFT  JOIN t_client_gr ON t_client.client_gr_id = t_client_gr.client_gr_id \n";
    $sql .= "   LEFT  JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           client_id, \n";
    $sql .= "           SUM(amount) AS advance_total \n";
    $sql .= "       FROM \n";
    $sql .= "           t_advance \n";
    $sql .= "       WHERE \n";
    $sql .= "           pay_day <= '$count_day' \n";
    $sql .= "       AND \n";
    $sql .= "           shop_id = $shop_id \n";
    $sql .= "       GROUP \n";
    $sql .= "           BY client_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS advance_data \n";
    $sql .= "   ON t_client.client_id = advance_data.client_id \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           client_id, \n";
    $sql .= "           SUM(t_payin_d.amount) AS payin_total \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payin_h \n";
    $sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payin_h.pay_day <= '$count_day' \n";
    $sql .= "       AND \n";
    $sql .= "           t_payin_d.trade_id = 40 \n";
    $sql .= "       AND \n";
    $sql .= "           shop_id = $shop_id \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           client_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS payin_data \n";
    $sql .= "   ON t_client.client_id = payin_data.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_client.shop_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "   t_client.client_div = '1' \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= "   client_cd1, \n";
    $sql .= "   client_cd2 \n";

    // 全件数取得
    $res            = Db_Query($db_con, $sql.";");
    $total_count    = pg_num_rows($res);

    // 表示件数
    switch ($display_num){
        case "10":
            $limit = "10";
            break;
        case "50":
            $limit = "50";
            break;
        case "100":
            $limit = "100";
            break;
        case null:
            $limit = $total_count;
            break;
    }

    // 取得開始位置
    $offset = ($page_count != null) ? ($page_count - 1) * $limit : "0";

    // ページ内データ取得
    $limit_offset   = ($limit != null) ? "LIMIT $limit OFFSET $offset " : null;
    $res            = Db_Query($db_con, $sql.$limit_offset.";");
    $match_count    = pg_num_rows($res);
    $ary_data       = Get_Data($res, 2, "ASSOC");

}


/****************************/
// 表示用データ作成
/****************************/
if ($post_flg == true && $err_flg != true){

    // 初期値
    $html_l     = null;
    $sum_amount = 0;

    // 取得データがある場合、データ数分ループ
    if (count($ary_data) > 0){
    foreach ($ary_data as $key => $value){

        /****************************/
        // 前準備
        /****************************/
        // 行色
        $ary_disp_data[$key]["css"]     = (bcmod($key, 2) == 0) ? "Result1" : "Result2";

        // No.
        $ary_disp_data[$key]["no"]      = (($page_count - 1) * $limit) + $key + 1;

        // 得意先
        $ary_disp_data[$key]["client"]  = $value["client_cd"]."<br>".htmlspecialchars($value["client_cname"])."<br>";

        // 前受金
        $ary_disp_data[$key]["advance"] = $value["advance_total"];

        // 相殺額
        $ary_disp_data[$key]["payin"]   = $value["payin_total"];

        // 金額(前受金残高)
        $ary_disp_data[$key]["amount"]  = $value["advances_balance"];

        // 合計金額加算
        $advance_amount += $value["advance_total"];
        $payin_amount   += $value["payin_total"];
        $sum_amount     += $value["advances_balance"];

        /****************************/
        // html作成
        /****************************/
        $html_l .= "    <tr class=\"".$ary_disp_data[$key]["css"]."\">\n";
        $html_l .= "        <td align=\"right\">".$ary_disp_data[$key]["no"]."</td>\n";
        $html_l .= "        <td>".$ary_disp_data[$key]["client"]."</td>\n";
        $html_l .= "        <td align=\"right\">".Numformat_Ortho($ary_disp_data[$key]["advance"])."</td>\n";
        $html_l .= "        <td align=\"right\">".Numformat_Ortho($ary_disp_data[$key]["payin"])."</td>\n";
        $html_l .= "        <td align=\"right\">".Numformat_Ortho($ary_disp_data[$key]["amount"])."</td>\n";
        $html_l .= "    </tr>\n";

    }
    }

    // 合計行作成
    $html_g  = "    <tr class=\"Result3\">\n";
    $html_g .= "        <td><b>合計</b></td>\n";
    $html_g .= "        <td></td>\n";
    $html_g .= "        <td align=\"right\">".Numformat_Ortho($advance_amount)."</td>\n";
    $html_g .= "        <td align=\"right\">".Numformat_Ortho($payin_amount)."</td>\n";
    $html_g .= "        <td align=\"right\">".Numformat_Ortho($sum_amount)."</td>\n";
    $html_g .= "    </tr>\n";

    // ページ分けhtml作成
    $html_page1 = Html_Page2($total_count, $page_count, 1, $limit);
    $html_page2 = Html_Page2($total_count, $page_count, 2, $limit);

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
// 画面ヘッダー作成
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
    "post_flg"      => "$post_flg",
    "err_flg"       => "$err_flg",
    "match_count"   => "$match_count",
));

// htmlをassign
$smarty->assign("html", array(
    "html_page1"    =>  $html_page1,
    "html_page2"    =>  $html_page2,
    "html_s"        =>  $html_s,
    "html_l"        =>  $html_l,
    "html_g"        =>  $html_g,
));

// エラーをassign
$errors = $form->_errors;
$smarty->assign("errors", $errors);

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
