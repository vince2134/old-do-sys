<?php
/*
 *
 *
 *
 *
 */

$page_title = "前受金受払一覧";

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
//外部変数取得
/****************************/
// SESSION
$shop_id    = $_SESSION["client_id"];


/****************************/
// フォームパーツ定義
/****************************/
// 得意先リンク
$form->addElement("link", "form_client_link", "", "#", "得意先", "taxindex=\"-1\"
    onClick=\"return Open_SubWin('../dialog/2-0-402.php',
        Array('form_client[cd1]', 'form_client[cd2]', 'form_client[name]', 'client_search_flg'),
        500, 450, 5, 1
    );\"
");

// 得意先
$obj    =   null;
$obj[]  =&  $form->createElement("text", "cd1", "", "
    size=\"7\" maxLength=\"6\" class=\"ime_disabled\"
    onChange=\"javascript: Change_Submit('client_search_flg', '#', 'true', 'form_client[cd2]');\"
    onkeyup=\"changeText(this.form, 'form_client[cd1]', 'form_client[cd2]', 6);\" $g_form_option
");
$obj[]  =&  $form->createElement("static", "", "", "-");
$obj[]  =&  $form->createElement("text", "cd2", "", "
    size=\"4\" maxLength=\"4\" class=\"ime_disabled\"
    onChange=\"javascript: Button_Submit('client_search_flg', '#', 'true');\" $g_form_option
");
$obj[]  =&  $form->createElement("static", "", "", " ");
$obj[]  =&  $form->createElement("text", "name", "", "size=\"34\" $g_text_readonly");
$form->addGroup($obj, "form_client", "", "");

// 集計期間
Addelement_Date_Range($form, "form_count_day", "", "-");

// 表示ボタン
$form->addElement("submit", "form_display", "表　示");

// クリアボタン
$form->addElement("button","form_clear","クリア", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// hidden
$form->addElement("hidden", "client_search_flg");   // 得意先検索フラグ
$form->addElement("hidden", "hdn_client_id");       // 得意先ID


/****************************/
// 得意先フォームの入力・補完処理
/****************************/
// 得意先検索フラグがtrueの場合
if ($_POST["client_search_flg"] == "true"){

    // POSTされた得意先コードを変数へ代入
    $client_cd1 = $_POST["form_client"]["cd1"];
    $client_cd2 = $_POST["form_client"]["cd2"];

    // 得意先の情報を抽出
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
    $sql .= "   client_div = '1' \n";
    $sql .= "AND \n"; 
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= ";"; 
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // 該当データがある場合
    if ($num > 0){
        $client_id      = pg_fetch_result($res, 0, 0);      // 得意先ID
        $client_cname   = pg_fetch_result($res, 0, 1);      // 得意先名略称
    }else{
        $client_id      = ""; 
        $client_cname   = "";
    }

    // 得意先コード入力フラグをクリア
    // 得意先IDをhiddenにセット
    // 得意先名略称フォームにセット
    $client_data["client_search_flg"]   = "";   
    $client_data["hdn_client_id"]       = $client_id;
    $client_data["form_client"]["name"] = $client_cname;
    $form->setConstants($client_data);

}


/****************************/
// 表示ボタン押下時
/****************************/
if ($_POST["form_display"] != null){

    // 日付POSTデータの0埋め
    $_POST["form_count_day"] = Str_Pad_Date($_POST["form_count_day"]);

    /****************************/
    // エラーチェック
    /****************************/
    // ■得意先
    // エラーメッセージ
    $err_msg = "正しい 得意先コード を入力して下さい。";

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

    // 得意先コードの妥当性チェック
    $sql  = "SELECT \n";
    $sql .= "   client_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "WHERE \n";
    $sql .= "   shop_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "   client_cd1 = '".$_POST["form_client"]["cd1"]."' \n";
    $sql .= "AND \n";
    $sql .= "   client_cd2 = '".$_POST["form_client"]["cd2"]."' \n";
    $sql .= "AND \n";
    $sql .= "   client_div = '1' \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        // 得意先が存在する場合は該当得意先情報を変数に代入
        $client_id = pg_fetch_result($res, 0, 0);
    }else{
        // 得意先が存在しない場合はエラーをセット
        $form->setElementError("form_client", $err_msg);
    }

    // ■集計期間
    // 必須チェック
    if (
        $_POST["form_count_day"]["sy"] == null || $_POST["form_count_day"]["sm"] == null || $_POST["form_count_day"]["sd"] == null ||
        $_POST["form_count_day"]["ey"] == null || $_POST["form_count_day"]["em"] == null || $_POST["form_count_day"]["ed"] == null
    ){
        $form->setElementError("form_count_day", "集計期間 は必須です。");
    }else{
        Err_Chk_Date($form, "form_count_day", "集計期間 の日付が妥当ではありません。");
    }

    /****************************/
    // エラーチェック結果集計
    /****************************/
    // チェック適用
    $test = $form->validate();

    // 結果をフラグに
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = true;

}


/****************************/
// 一覧データ取得
/****************************/
if ($post_flg == true && $err_flg != true){

    // 日付POSTデータの0埋め
    $_POST["form_count_day"] = Str_Pad_Date($_POST["form_count_day"]);

    // POSTデータを変数にセット
    $count_day_s    = $_POST["form_count_day"]["sy"].$_POST["form_count_day"]["sm"].$_POST["form_count_day"]["sd"];
    $count_day_e    = $_POST["form_count_day"]["ey"].$_POST["form_count_day"]["em"].$_POST["form_count_day"]["ed"];
    $client_id      = $_POST["hdn_client_id"];

    // 繰越残高取得
    $sql  = "SELECT \n";
    $sql .= "   COALESCE(advance_data.advance_total, 0) - COALESCE(payin_data.payin_total, 0) AS advances_balance \n";
    $sql .= "FROM \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           SUM(amount) AS advance_total \n";
    $sql .= "       FROM \n";
    $sql .= "           t_advance \n";
    $sql .= "       WHERE \n";
    $sql .= "           pay_day < '$count_day_s' \n";
    $sql .= "       AND \n";
    $sql .= "           client_id = $client_id \n";
    $sql .= "       AND \n";
    $sql .= "           shop_id = $shop_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS advance_data, \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           SUM(t_payin_d.amount) AS payin_total \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payin_h \n";
    $sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payin_h.pay_day < '$count_day_s' \n";
    $sql .= "       AND \n";
    $sql .= "           t_payin_d.trade_id = 40 \n";
    $sql .= "       AND \n";
    $sql .= "           client_id = $client_id \n";
    $sql .= "       AND \n";
    $sql .= "           shop_id = $shop_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS payin_data \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $balance_forward = pg_fetch_result($res, 0, 0);
    }else{
        $balance_forward = 0;
    }

    // 明細データ取得
    // 前受額
    $sql  = "SELECT \n";
    $sql .= "   pay_day     AS trading_day, \n";
    $sql .= "   advance_no  AS slip_no, \n";
    $sql .= "   NULL        AS trade_name, \n";
    $sql .= "   '前受金'    AS formal_name, \n";
    $sql .= "   amount      AS advance_amount, \n";
    $sql .= "   NULL        AS advance_offset_amount, \n";
    $sql .= "   0           AS line, \n";
    $sql .= "   't'         AS advance_flg, \n";
    $sql .= "   'f'         AS offset_flg \n";
    $sql .= "FROM \n";
    $sql .= "   t_advance \n";
    $sql .= "WHERE \n";
    $sql .= "   pay_day >= '$count_day_s' \n";
    $sql .= "AND \n";
    $sql .= "   pay_day <= '$count_day_e' \n";
    $sql .= "AND \n";
    $sql .= "   client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = $shop_id \n";
    $sql .= "UNION ALL \n";
    // 前受相殺額
    $sql .= "SELECT \n";
    $sql .= "   t_sale_h.sale_day               AS trading_day, \n";
    $sql .= "   t_sale_h.sale_no                AS slip_no, \n";
    $sql .= "   t_trade.trade_name              AS trade_name, \n";
    $sql .= "   v_sale_d.formal_name            AS formal_name, \n";
    $sql .= "   NULL                            AS advance_amount, \n";
    $sql .= "   v_sale_d.advance_offset_amount  AS advance_offset_amount, \n";
    $sql .= "   v_sale_d.line                   AS line, \n";
    $sql .= "   'f'                             AS advance_flg, \n";
    $sql .= "   't'                             AS offset_flg ";
    $sql .= "FROM \n";
    $sql .= "   t_sale_h \n";
    $sql .= "   INNER JOIN v_sale_d ON t_sale_h.sale_id = v_sale_d.sale_id \n";
    $sql .= "   INNER JOIN t_trade  ON t_sale_h.trade_id = t_trade.trade_id \n";
    $sql .= "WHERE \n";
    $sql .= "   v_sale_d.advance_flg = '2' \n";
    $sql .= "AND \n";
    $sql .= "   t_sale_h.sale_day >= '$count_day_s' \n";
    $sql .= "AND \n";
    $sql .= "   t_sale_h.sale_day <= '$count_day_e' \n";
    $sql .= "AND \n";
    $sql .= "   t_sale_h.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_sale_h.shop_id = $shop_id \n";
    // ソート
    $sql .= "ORDER BY \n";
    $sql .= "   trading_day, \n";
    $sql .= "   slip_no, \n";
    $sql .= "   line \n";
    $sql .= ";";

    // 全件数取得
    $res            = Db_Query($db_con, $sql);
    $total_count    = pg_num_rows($res);
    $ary_data       = Get_Data($res, 2, "ASSOC");

}


/****************************/
// 表示用データ作成
/****************************/
if ($post_flg == true && $err_flg != true){

    // 初期値
    $html_l             = null;
    $sum_advance_amount = 0;                    // 前受金合計
    $sum_advance_offset = 0;                    // 前受相殺額合計
    $sum_balance_amount = $balance_forward;     // 前受金残高合計（初期値を繰越残高に設定）
    $color_row          = 0;                    // 行色番号

    /****************************/
    // html作成（繰越残高行）
    /****************************/
    $html_l .= "    <tr class=\"Result1\">\n";
    $html_l .= "        <td align=\"right\">1</td>\n";
    $html_l .= "        <td></td>\n";
    $html_l .= "        <td></td>\n";
    $html_l .= "        <td></td>\n";
    $html_l .= "        <td align=\"right\">繰越残高</td>\n";
    $html_l .= "        <td></td>\n";
    $html_l .= "        <td></td>\n";
    $html_l .= "        <td align=\"right\">".Numformat_Ortho($balance_forward)."</td>\n";
    $html_l .= "    </tr>\n";

    // 取得データがある場合、データ数分ループ
    if (count($ary_data) > 0){
    foreach ($ary_data as $key => $value){

        /****************************/
        // 前準備
        /****************************/
        // 同じ伝票内の2行目以降は伝票番号等を出力しないようにするためのフラグ
        // 前の行と伝票番号が同じ
        // 前の行と前受金フラグが同じ
        // 前の行と前受相殺フラグが同じ
        if (
            $value["slip_no"]     == $ary_data[$key - 1]["slip_no"]     &&
            $value["advance_flg"] == $ary_data[$key - 1]["advance_flg"] &&
            $value["offset_flg"]  == $ary_data[$key - 1]["offset_flg"]
        ){
            $top_print_flg  = false;
        }else{
            $top_print_flg  = true;
            $color_row     += 1;
        }

        // 同じ伝票内では最後の行のみ前受金残高を出力するためのフラグ
        // 次の行で伝票番号が変わる
        // 次の行で前受金フラグが変わる
        // 次の行で前受相殺フラグが変わる
        if (
            $value["slip_no"]     != $ary_data[$key + 1]["slip_no"]     ||
            $value["advance_flg"] != $ary_data[$key + 1]["advance_flg"] ||
            $value["offset_flg"]  != $ary_data[$key + 1]["offset_flg"]
        ){
            $bottom_print_flg = true;
        }else{
            $bottom_print_flg = false;
        }

        // 前受金合計算出
        // 前受相殺額合計算出
        // 前受金残高合計算出
        if ($value["advance_amount"] != null){
            $sum_advance_amount += $value["advance_amount"];            // 前受金合計
            $sum_balance_amount += $value["advance_amount"];            // 前受金残高
        }
        if ($value["advance_offset_amount"] != null){
            $sum_advance_offset += $value["advance_offset_amount"];     // 前受相殺額合計
            $sum_balance_amount -= $value["advance_offset_amount"];     // 前受金残高
        }

        /****************************/
        // html作成（明細行）
        /****************************/
        $html_l .= "    <tr class=\"".((bcmod($color_row, 2) == 0) ? "Result1" : "Result2")."\">\n";
        $html_l .= "        <td align=\"right\">".($key + 2)."</td>\n";
        if ($top_print_flg == true){
        $html_l .= "        <td align=\"center\">".$value["trading_day"]."</td>\n";
        $html_l .= "        <td align=\"center\">".$value["slip_no"]."</td>\n";
        $html_l .= "        <td align=\"center\">".$value["trade_name"]."</td>\n";
        }else{
        $html_l .= "        <td align=\"center\"></td>\n";
        $html_l .= "        <td align=\"center\"></td>\n";
        $html_l .= "        <td align=\"center\"></td>\n";
        }
        $html_l .= "        <td>".htmlspecialchars($value["formal_name"])."</td>\n";
        $html_l .= "        <td align=\"right\">".Numformat_Ortho($value["advance_amount"], null, true)."</td>\n";
        $html_l .= "        <td align=\"right\">".Numformat_Ortho($value["advance_offset_amount"], null, true)."</td>\n";
        if ($bottom_print_flg == true){
        $html_l .= "        <td align=\"right\">".Numformat_Ortho($sum_balance_amount)."</td>\n";
        }else{
        $html_l .= "        <td align=\"center\"></td>\n";
        }
        $html_l .= "    </tr>\n";

    }
    }

    /****************************/
    // html作成（合計行）
    /****************************/
    $html_g .= "    <tr class=\"Result3\">\n";
    $html_g .= "        <td><b>合計</b></td>\n";
    $html_g .= "        <td></td>\n";
    $html_g .= "        <td></td>\n";
    $html_g .= "        <td></td>\n";
    $html_g .= "        <td></td>\n";
    $html_g .= "        <td align=\"right\">".Numformat_Ortho($sum_advance_amount)."</td>\n";
    $html_g .= "        <td align=\"right\">".Numformat_Ortho($sum_advance_offset)."</td>\n";
    $html_g .= "        <td align=\"right\">".Numformat_Ortho($sum_balance_amount)."</td>\n";
    $html_g .= "    </tr>\n";

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
    "total_count"   => "$total_count",
));

// htmlをassign
$smarty->assign("html", array(
    "html_page"     =>  $html_page,
    "html_page2"    =>  $html_page2,
    "html_l"        =>  $html_l,
    "html_g"        =>  $html_g,
));

// エラーをassign
$errors = $form->_errors;
$smarty->assign("errors", $errors);

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
