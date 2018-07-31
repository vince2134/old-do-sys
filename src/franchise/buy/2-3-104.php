<?php
/*
 * 変更履歴
 *    2006/12/13 (suzuki)
 *      ・レンタル料は変更不可
*/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/11      06-097      ふ          リロードによる伝票削除防止のため、伝票削除時に伝票作成日時と照らし合わせる
 *  2006/11/11      06-089      ふ          仕入入力済の伝票を削除できないよう修正
 *  2006/12/06      ban_0037    suzuki      日付にゼロ埋め追加
 *  2006/12/06      ban_0038    suzuki      日付不正時にエラー出力
 *  2006/12/19      wat-0133    watanabe-k  発注番号押下時の遷移先選択処理の修正    
 *  2007/02/05                  watanabe-k  発注書発行はオフライン発注の時のみ必要になるので、列を右端に移動し、「未発行」「発行済み」という表現は修正 
 *  2007/02/05                  watanabe-k  本部確認「未」「済」「取消」とし、「未」は赤で表示、「取消」は緑の色で表示   
 *  2007/02/05                  wataanbe-k  日次更新は発注には関係ないため不要
 *  2007/02/07                  wataanbe-k  発注書発行を発注書印刷に変更 オンライン発注の場合は発注書を出力しない
 *  2007/03/28                  fukuda      検索条件復元処理追加
 *  2007/06/06                  watanabe-k  発注書の発行リンクが表示されていないバグの修正
 *  2007/08/22                  kajioka-h   ソート条件に希望納期を追加
 *  2008/08/27                  aoyama-n    通信欄を表示する 
 */

$page_title = "発注照会";

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
    "form_attach_branch"    => "",  
    "form_client"           => array("cd1" => "", "name" => ""), 
    "form_c_staff"          => array("cd" => "", "select" => ""), 
    "form_part"             => "",  
    "form_ord_day"          => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))
    ),
    "form_ord_no"           => array("s" => "", "e" => ""), 
    "form_multi_staff"      => "",  
    "form_ware"             => "",
    "form_hope_day"         => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_direct"           => "",
);

// 検索条件復元
Restore_Filter2($form, "ord", "show_button", $ary_form_list);


/****************************/
// 外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];
$ord_id     = $_POST["ord_id_flg"];


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
/* 共通フォーム */
Search_Form_Ord($db_con, $form, $ary_form_list);

/* モジュール別フォーム */
// ソートリンク
$ary_sort_item = array(
    "sl_ord_day"        => "発注日",
    "sl_slip"           => "発注番号",
    "sl_client_cd"      => "発注先コード",
    "sl_client_name"    => "発注先名",
    "sl_hope_day"       => "希望納期",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_ord_day");

// 表示
$form->addElement("submit", "show_button", "表　示");

// クリア
$form->addElement("button", "clear_button", "クリア", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// 処理フラグ
$form->addElement("hidden", "data_delete_flg");
$form->addElement("hidden", "order_sheet_flg");
$form->addElement("hidden", "ord_id_flg");
$form->addElement("hidden", "hdn_del_enter_date");

// エラーセット用hidden
$form->addElement("text", "err_bought_slip");

/* ヘッダ部ボタン */
// 発注残一覧
$form->addElement("button", "ord_button", "発注残一覧", "onClick=\"javascript:location.href('2-3-106.php')\"");
// 入力・変更
$form->addElement("button", "new_button", "入　力", "onClick=\"location.href('2-3-102.php')\"");
// 照会
$form->addElement("button", "chg_button", "照会・変更", "$g_button_color onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."')\"");


/****************************/
// 発注書発行リンク押下処理
/****************************/
if ($_POST["order_sheet_flg"] == "true"){

    $sql  = "UPDATE \n";
    $sql .= "   t_order_h \n";
    $sql .= "SET \n";
    $sql .= "   ord_sheet_flg = 't' \n";
    $sql .= "WHERE \n";
    $sql .= "   ord_id = $ord_id \n";
    $sql .= ";";
    $res  = @Db_Query($db_con, $sql);

    $clear_hdn["order_sheet_flg"] = "";
    $form->setConstants($clear_hdn);

    $post_flg = true;

}


/****************************/
// 削除リンク押下処理
/****************************/
if ($_POST["data_delete_flg"] == "true"){

    // 選択された発注伝票の作成日次を取得
    $enter_date = $_POST["hdn_del_enter_date"];

    /* 削除しようとしている発注伝票から仕入が起こっていないか調べる */
    $sql  = "SELECT \n";
    $sql .= "   * \n";
    $sql .= "FROM \n";
    $sql .= "   t_buy_h \n";
    $sql .= "WHERE \n";
    $sql .= "   ord_id = $ord_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $bought_flg = (pg_num_rows($res) == 0) ? false : true;
    // 仕入が起こっていた場合、エラーメッセージをセット
    if ($bought_flg == true){
        $form->setElementError("err_bought_slip", "仕入済のため、発注伝票を削除できません。");
    }

    /* 削除しようとしている発注伝票が、正当か調べる */
    // POSTされた削除受注IDが正当か（伝票作成日時を元に）調べる
    $valid_flg = Update_check($db_con, "t_order_h", "ord_id", $ord_id, $enter_date);

    /* 仕入が起こっていない＆正当な場合のみ削除処理を行う */
    if ($bought_flg == false && $valid_flg == true){
        $data_delete  = "DELETE FROM t_order_h WHERE ord_id = $ord_id;";
        //該当データ件数
        $result = @Db_Query($db_con, $data_delete);
    }

    // hiddenをクリア
    $clear_hdn["data_delete_flg"]       = "";
    $clear_hdn["hdn_del_enter_date"]    = "";
    $form->setConstants($clear_hdn);

    $post_flg = true;

}


/****************************/
// 表示ボタン押下処理
/****************************/
if($_POST["show_button"] == "表　示"){

    // 日付POSTデータの0埋め
    $_POST["form_ord_day"] = Str_Pad_Date($_POST["form_ord_day"]);

    /****************************/
    // エラーチェック
    /****************************/
    // ■発注担当者
    $err_msg = "発注担当者 は数値のみ入力可能です。";
    Err_Chk_Num($form, "form_c_staff", $err_msg);

    // ■発注日
    $err_msg = "発注日 の日付が妥当ではありません。";
    Err_Chk_Date($form, "form_ord_day", $err_msg);

    // ■発注担当者（複数選択）
    $err_msg = "発注担当者（複数選択） は数値と「,」のみ入力可能です。";
    Err_Chk_Delimited($form, "form_multi_staff", $err_msg);

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
if (($_POST["show_button"] != null && $err_flg != true) || ($_POST != null && $_POST["show_button"] == null)){

    // 日付POSTデータの0埋め
    $_POST["form_ord_day"] = Str_Pad_Date($_POST["form_ord_day"]);

    // 1. フォームの値を変数にセット
    // 2. SESSION（hidden用）の値（検索条件復元関数内でセット）を変数にセット
    // 一覧取得クエリ条件に使用
    $display_num    = $_POST["form_display_num"];
    $client_branch  = $_POST["form_client_branch"];
    $attach_branch  = $_POST["form_attach_branch"];
    $client_cd1     = $_POST["form_client"]["cd1"];
    $client_name    = $_POST["form_client"]["name"];
    $c_staff_cd     = $_POST["form_c_staff"]["cd"];
    $c_staff_select = $_POST["form_c_staff"]["select"];
    $part           = $_POST["form_part"];
    $ord_day_sy     = $_POST["form_ord_day"]["sy"];
    $ord_day_sm     = $_POST["form_ord_day"]["sm"];
    $ord_day_sd     = $_POST["form_ord_day"]["sd"];
    $ord_day_ey     = $_POST["form_ord_day"]["ey"];
    $ord_day_em     = $_POST["form_ord_day"]["em"];
    $ord_day_ed     = $_POST["form_ord_day"]["ed"];
    $ord_no_s       = $_POST["form_ord_no"]["s"];
    $ord_no_e       = $_POST["form_ord_no"]["e"];
    $multi_staff    = $_POST["form_multi_staff"];
    $ware           = $_POST["form_ware"];
    $hope_day_sy    = $_POST["form_hope_day"]["sy"];
    $hope_day_sm    = $_POST["form_hope_day"]["sm"];
    $hope_day_sd    = $_POST["form_hope_day"]["sd"];
    $hope_day_ey    = $_POST["form_hope_day"]["ey"];
    $hope_day_em    = $_POST["form_hope_day"]["em"];
    $hope_day_ed    = $_POST["form_hope_day"]["ed"];
    $direct_name    = $_POST["form_direct"];

    $post_flg   = true;

}


/****************************/
// 一覧データ取得条件作成
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // 顧客担当支店
    if ($client_branch != null){
        $sql .= "AND \n";
        $sql .= "   t_order_h.client_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           client_id \n";
        $sql .= "       FROM \n";
        $sql .= "           t_client \n";
        $sql .= "       WHERE \n";
        $sql .= "           charge_branch_id = $client_branch \n";
        $sql .= "   ) \n";
    }
    // 所属本支店
    if ($attach_branch != null){
        $sql .= "AND \n";
        $sql .= "   t_order_h.c_staff_id IN \n";
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
    // 発注先コード１
    $sql .= ($client_cd1 != null) ? "AND t_order_h.client_cd1 LIKE '$client_cd1%' \n" : null;
    // 発注先名
    if ($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_order_h.client_name  LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_order_h.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_order_h.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
    // 発注担当者コード
    $sql .= ($c_staff_cd != null) ? "AND t_staff.charge_cd = '$c_staff_cd' \n" : null;
    // 発注担当者セレクト
    $sql .= ($c_staff_select != null) ? "AND t_staff.staff_id = $c_staff_select \n" : null;
    // 部署
    $sql .= ($part != null) ? "AND t_attach.part_id = $part \n" : null;
    // 発注日（開始）
    $ord_day_s = $ord_day_sy."-".$ord_day_sm."-".$ord_day_sd;
    $sql .= ($ord_day_s != "--") ? "AND t_order_h.ord_time >= '$ord_day_s 00:00:00' \n" : null;
    // 発注日（終了）
    $ord_day_e = $ord_day_ey."-".$ord_day_em."-".$ord_day_ed;
    $sql .= ($ord_day_e != "--") ? "AND t_order_h.ord_time <= '$ord_day_e 23:59:59' \n" : null;
    // 発注番号（開始）
    $sql .= ($ord_no_s != null) ? "AND t_order_h.ord_no >= '".str_pad($ord_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // 発注番号（終了）
    $sql .= ($ord_no_e != null) ? "AND t_order_h.ord_no <= '".str_pad($ord_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // 発注担当者（複数選択）
    if ($multi_staff != null){
        $ary_multi_staff = explode(",", $multi_staff);
        $sql .= "AND \n";
        $sql .= "   t_staff.charge_cd IN (";
        foreach ($ary_multi_staff as $key => $value){
            $sql .= "'".trim($value)."'";
            $sql .= ($key+1 < count($ary_multi_staff)) ? ", " : ") \n";
        }
    }
    // 倉庫
    $sql .= ($ware != null) ? "AND t_order_h.ware_id = $ware \n" : null;
    // 希望納期（開始）
    $hope_day_s = $hope_day_sy."-".$hope_day_sm."-".$hope_day_sd;
    $sql .= ($hope_day_s != "--") ? "AND t_order_h.hope_day >= '$hope_day_s' \n" : null;
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
        // 発注日
        case "sl_ord_day":
            $sql .= "   date, \n";
            $sql .= "   time, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_order_h.client_cd1 \n";
            break;
        // 発注番号
        case "sl_slip":
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   date, \n";
            $sql .= "   time, \n";
            $sql .= "   t_order_h.client_cd1 \n";
            break;
        // 得意先コード
        case "sl_client_cd":
            $sql .= "   t_order_h.client_cd1, \n";
            $sql .= "   date, \n";
            $sql .= "   time, \n";
            $sql .= "   t_order_h.ord_no \n";
            break;
        // 発注先名
        case "sl_client_name":
            $sql .= "   t_order_h.client_cname, \n";
            $sql .= "   date, \n";
            $sql .= "   time, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_order_h.client_cd1 \n";
            break;
        // 希望納期
        case "sl_hope_day":
            $sql .= "   t_order_h.hope_day, \n";
            $sql .= "   date, \n";
            $sql .= "   time, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_order_h.client_cd1 \n";
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
    $sql .= "   t_order_h.ord_id, \n";
    $sql .= "   to_char(t_order_h.ord_time, 'yyyy-mm-dd')   AS date, \n";
    $sql .= "   to_char(t_order_h.ord_time, 'hh24:mi')      AS time, \n";
    $sql .= "   t_order_h.ord_no, \n";
    $sql .= "   t_order_h.client_cname, \n";
    $sql .= "   t_order_h.ord_stat, \n";
    $sql .= "   t_order.buy_money, \n";
    $sql .= "   t_order_h.ord_sheet_flg, \n";
    $sql .= "   t_order_h.ps_stat, \n";
    $sql .= "   t_order_h.finish_flg, \n ";
    $sql .= "   t_client.head_flg, \n";
    $sql .= "   t_order_h.client_cd1, \n";
    $sql .= "   to_char(t_order_h.renew_day, 'yyyy-mm-dd'), \n";
    $sql .= "   t_order_h.enter_day, \n";
	$sql .= "   t_order_h.rental_flg, \n";
    //aoyama-n 2009-08-27
    #$sql .= "   t_order_h.hope_day \n";
    $sql .= "   t_order_h.hope_day, \n";
    $sql .= "   recital.note_your \n";
    $sql .= "FROM \n";
    $sql .= "   t_order_h \n";
    $sql .= "   INNER JOIN t_client ON t_order_h.client_id = t_client.client_id \n";
    $sql .= "   INNER JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           ord_id, \n";
    $sql .= "           net_amount + tax_amount AS buy_money \n";
    $sql .= "       FROM \n";
    $sql .= "           t_order_h \n";
    $sql .= "       ORDER BY \n";
    $sql .= "           ord_id DESC \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_order \n";
    $sql .= "   ON t_order_h.ord_id = t_order.ord_id \n";
    $sql .= "   LEFT JOIN t_attach  ON  t_order_h.c_staff_id = t_attach.staff_id \n";
    $sql .= "                       AND t_attach.shop_id = $shop_id \n";
    $sql .= "   LEFT JOIN t_staff   ON  t_order_h.c_staff_id = t_staff.staff_id \n";
    //aoyama-n 2009-08-27
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           fc_ord_id, \n";
    $sql .= "           MIN(aord_id), \n";
    $sql .= "           note_your \n";
    $sql .= "       FROM \n";
    $sql .= "           t_aorder_h \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           fc_ord_id,note_your \n";
    $sql .= "   ) AS recital\n";
    $sql .= "   ON t_order_h.ord_id = recital.fc_ord_id \n";

    $sql .= "WHERE \n";
    $sql .= "   t_order_h.shop_id = $shop_id \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;

    // 全件数取得
    $res            = Db_Query($db_con, $sql.";");
    $total_count    = pg_num_rows($res);
    $limit          = $total_count;

    // OFFSET条件作成
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
    $ary_ord_data   = Get_Data($res);

}


/****************************/
// HTML作成（検索部）
/****************************/
// 共通検索テーブル
$html_s .= Search_Table_Ord($form);
// ボタン
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["show_button"]]->toHtml()."　\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["clear_button"]]->toHtml()."\n";
$html_s .= "</td></tr></table>";
$html_s .= "\n";


/****************************/
// JavaScript
/****************************/
$js  = "function Order_Delete(hidden1,hidden2,ord_id,hidden3,enter_date){\n";
$js .= "    res = window.confirm(\"削除します。よろしいですか？\");\n";
$js .= "    if (res == true){\n";
$js .= "        var id = ord_id;\n";
$js .= "        var edate = enter_date;\n";
$js .= "        var hdn1 = hidden1;\n";
$js .= "        var hdn2 = hidden2;\n";
$js .= "        var hdn3 = hidden3;\n";
$js .= "        document.dateForm.elements[hdn1].value = 'true';\n";
$js .= "        document.dateForm.elements[hdn2].value = id;\n";
$js .= "        document.dateForm.elements[hdn3].value = edate;\n";
$js .= "        //同じウィンドウで遷移する\n";
$js .= "        document.dateForm.target=\"_self\";\n";
$js .= "        //自画面に遷移する\n";
$js .= "        document.dateForm.action='".$_SERVER["PHP_SELF"]."';\n";
$js .= "        //POST情報を送信する\n";
$js .= "        document.dateForm.submit();\n";
$js .= "        return true;\n";
$js .= "    }else{\n";
$js .= "        return false;\n";
$js .= "    }\n";
$js .= "}\n";

$js .= "function Order_Sheet(hidden1,hidden2,which,ord_id,renew){\n";
//$js .= "    res = window.confirm(\"発注書を発行します。よろしいですか？\");\n";
//$js .= "    if (res == true){\n";
$js .= "        var id = ord_id;\n";
$js .= "        if (which == '1'){\n";
$js .= "            window.open('../../franchise/buy/2-3-107.php?ord_id='+id,'_blank','');\n";
$js .= "        }else if (which == '2'){\n";
$js .= "            window.open('../../franchise/buy/2-3-105.php?ord_id='+id,'_blank','');\n";
$js .= "        }\n";
$js .= "        var hdn1 = hidden1;\n";
$js .= "        var hdn2 = hidden2;\n";
$js .= "        if (renew != '4'){\n";
$js .= "            document.dateForm.elements[hdn1].value = 'true';\n";
$js .= "        }\n";
$js .= "        document.dateForm.elements[hdn2].value = id;\n";
$js .= "        //同じウィンドウで遷移する\n";
$js .= "        document.dateForm.target=\"_self\";\n";
$js .= "        //自画面に遷移する\n";
$js .= "        document.dateForm.action='".$_SERVER["PHP_SELF"]."';\n";
$js .= "        //POST情報を送信する\n";
$js .= "        document.dateForm.submit();\n";
$js .= "        return true;\n";
//$js .= "   }else{\n";
//$js .= "        return false;\n";
//$js .= "    }\n";
$js .= "}\n";


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
$page_menu = Create_Menu_f("buy", "1");

/****************************/
// 画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex[chg_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[ord_button]]->toHtml();
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

// その他の変数をassign
$smarty->assign("var", array(
    "html_header"   => "$html_header",
    "page_menu"     => "$page_menu",
    "page_header"   => "$page_header",
    "html_footer"   => "$html_footer",
    "auth"          => $auth[0],
    "no"            => ($page_count - 1) * $limit,
    "post_flg"      => "$post_flg",
    "err_flg"       => "$err_flg",
));

$smarty->assign("html", array(
    "html_s"        => "$html_s",
    "html_page"     => "$html_page",
    "html_page2"    => "$html_page2",
    "js"            => "$js",
));

$smarty->assign("row", $ary_ord_data);

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
