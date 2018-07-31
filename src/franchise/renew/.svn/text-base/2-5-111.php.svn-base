<?php
// ページ名
$page_title = "バッチ表";

// 環境設定ファイル
require_once("ENV_local.php");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");
$smarty->register_modifier("number_format","number_format");

// DB接続
$db_con = Db_Connect();


/****************************/
// 外部変数取得
/****************************/
$shop_id        = $_SESSION["client_id"];
$group_kind     = $_SESSION["group_kind"];
$staff_id       = $_GET["staff_id"];

$end_y      = ($_POST["form_end_day"]["y"] != null) ? str_pad($_POST["form_end_day"]["y"], 4, 0, STR_POS_LEFT) : null; 
$end_m      = ($_POST["form_end_day"]["m"] != null) ? str_pad($_POST["form_end_day"]["m"], 2, 0, STR_POS_LEFT) : null; 
$end_d      = ($_POST["form_end_day"]["d"] != null) ? str_pad($_POST["form_end_day"]["d"], 2, 0, STR_POS_LEFT) : null; 
$end_day    = ($end_y != null && $end_m != null && $end_d != null) ? $end_y."-".$end_m."-".$end_d : null;


/****************************/
// フォームパーツ定義
/****************************/
/* メインフォーム */
$form->addElement("button", "form_return_button", "戻　る", "onClick=\"javascript:history.back()\"");


/****************************/
// ページ読込時の処理
/****************************/
// 取得したスタッフIDが不正の場合
if ($staff_id != null){
    $sql  = "SELECT staff_id FROM t_ WHERE staff_id = $staff_id;";
//    $res  = Db_Query($db_con, $sql);
//    Get_Id_Check($res);
}


/****************************/
// 関数
/****************************/
function Font_Color($num){
    return ($num < 0) ? "style=\"color: #ff0000;\"" : null; 
}


/****************************/
// フォームパーツ定義
/****************************/
// 出力形式
$radio = null; 
$radio[] =& $form->createElement("radio", null, null, "画面", "1");
$radio[] =& $form->createElement("radio", null, null, "帳票", "2");
$form->addGroup($radio, "form_output_radio", "");

// 集計期間
$form_end_day[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\"
    style=\"$g_form_style \"
    onkeyup=\"changeText(this.form,'form_end_day[y]','form_end_day[m]',4)\" 
    onFocus=\"onForm_today(this,this.form,'form_end_day[y]','form_end_day[m]','form_end_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_end_day[] = $form->createElement(
    "text","m","","size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style \"
    onkeyup=\"changeText(this.form, 'form_end_day[m]','form_end_day[d]',2)\" 
    onFocus=\"onForm_today(this,this.form,'form_end_day[y]','form_end_day[m]','form_end_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_end_day[] = $form->createElement(
    "text","d","",
    "size=\"2\" maxLength=\"2\"
    style=\"$g_form_style \" 
    onFocus=\"onForm_today(this,this.form,'form_end_day[y]','form_end_day[m]','form_end_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form->addGroup($form_end_day, "form_end_day", "", " - "); 

// オペレータ
$select_staff   = null; 
$select_staff   = Select_Get($db_con, "shop_staff");
$form->addElement("select", "form_staff_select", "", $select_staff, "$g_form_option_select");

// 表示ボタン
$form->addElement("submit", "form_show_button", "表　示");

// クリアボタン
$form->addElement("button", "form_clear_button", "クリア", "onClick=\"location.href='$_SERVER[PHP_SELF]'\"");


/****************************/
// 更新日取得取得
/****************************/
/* 最終日次更新日時取得 */
$sql  = "SELECT MAX(close_day) ";
$sql .= "FROM   t_sys_renew ";
$sql .= "WHERE  renew_div = '1' ";
$sql .= "AND    shop_id = $shop_id ";
$sql .= ";"; 
$res  = Db_Query($db_con, $sql);
$daily_update_time = pg_fetch_result($res, 0);

// 月次更新日時取得
$sql  = "SELECT to_date(MAX(close_day), 'YYYY-MM-DD') ";
$sql .= "FROM   t_sys_renew ";
$sql .= "WHERE  renew_div = '2' ";
$sql .= "AND    shop_id = $shop_id ";
$sql .= ";";
$res  = Db_Query($db_con, $sql);
$monthly_update_time = pg_fetch_result($res, 0);


/****************************/
// 表示ボタン押下時処理
/****************************/
if (isset($_POST["form_show_button"])){

    // エラーフラグ格納先配列
    $ary_err_flg = array(null);

    // POSTされた日付を整形
    $end_y = ($_POST["form_end_day"]["y"] != null) ? str_pad($_POST["form_end_day"]["y"], 4, 0, STR_POS_LEFT) : null;
    $end_m = ($_POST["form_end_day"]["m"] != null) ? str_pad($_POST["form_end_day"]["m"], 2, 0, STR_POS_LEFT) : null;
    $end_d = ($_POST["form_end_day"]["d"] != null) ? str_pad($_POST["form_end_day"]["d"], 2, 0, STR_POS_LEFT) : null;

    /****************************/
    // エラーチェック
    /****************************/
    // どれか1つでも入力がある場合
    if ($end_y != null || $end_m != null || $end_d != null){

        // 日付妥当性チェック
        if (!checkdate((int)$end_m, (int)$end_d, (int)$end_y)){
            $form->setElementError("form_end_day", "集計期間の日付が妥当ではありません。");
            $ary_err_flg[] = true;
        }

        // 日次更新より後の日付かチェック
        if (mb_substr($daily_update_time, 0, 10) > $end_y."-".$end_m."-".$end_d){
            $form->setElementError("form_end_day", "集計期間の日付が妥当ではありません。");
            $ary_err_flg[] = true;
        }

        // YYYY-MM-DDの型にしておく
        $end_day = $end_y."-".$end_m."-".$end_d;

    }

    /****************************/
    // チェック結果
    /****************************/
    $qf_err_flg = ($form->validate() === false || in_array(true, $ary_err_flg)) ? true : false;

}


/****************************/
// 一覧表示用データ取得
/****************************/
/* 一覧用データ取得 */
if ($qf_err_flg != true){

    // 選択されたスタッフID取得
    $staff_id = $_POST["form_staff_select"];


    /*-----------------------------------
        売上データ取得
    -----------------------------------*/
    // ループ用配列（販売区分）
    $ary_sale_div   = array("01", "02", "03", "04", "05", "06", "07", "08");
    // ループ用配列（巡回担当者識別）
    $ary_main_sub   = array("main", "sub1", "sub2", "sub3");
    
    /*** 売上データ取得 ***/
    $sql  = "SELECT \n";
    $sql .= "   t_attach_staff.staff_id, \n";
    $sql .= "   t_attach_staff.staff_name, \n";
    foreach ($ary_sale_div as $key => $value){
    $sql .= "   t_sale_data.genkin_".$value."_count, \n";
    $sql .= "   t_sale_data.genkin_".$value."_cost_amount, \n";
    $sql .= "   t_sale_data.genkin_".$value."_sale_amount, \n";
    }
    $sql .= "   t_sale_tax.genkin_tax_amount, \n";
    $sql .= "   t_sale_data.genkin_gai_count, \n";
    $sql .= "   t_sale_data.genkin_gai_cost_amount, \n";
    $sql .= "   t_sale_data.genkin_gai_sale_amount, \n";
    foreach ($ary_sale_div as $key => $value){
    $sql .= "   t_sale_data.kake_".$value."_count, \n";
    $sql .= "   t_sale_data.kake_".$value."_cost_amount, \n";
    $sql .= "   t_sale_data.kake_".$value."_sale_amount, \n";
    }
    $sql .= "   t_sale_tax.kake_tax_amount, \n";
    $sql .= "   t_sale_data.kake_gai_count, \n";
    $sql .= "   t_sale_data.kake_gai_cost_amount, \n";
    $sql .= "   t_sale_data.kake_gai_sale_amount \n";
    $sql .= "FROM \n";
    // ■ショップ・担当者
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_shop_union.shop_id, \n";
    $sql .= "           t_shop_union.staff_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_staff.staff_name \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id, \n";
    $sql .= "                       staff_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       ( \n";
    foreach ($ary_main_sub as $key => $value){
    $sql .= "                           ( \n";
    $sql .= "                               SELECT \n";
    $sql .= "                                   shop_id, \n";
    $sql .= "                                   ".$value."_staff_id AS staff_id \n";
    $sql .= "                               FROM \n";
    $sql .= "                                   t_sale_h_amount \n";
    $sql .= "                           ) \n";
        if ($key+1 < count($ary_main_sub)){
    $sql .= "                           UNION ALL \n";
        }       
    }
    $sql .= "                       ) \n";
    $sql .= "                       AS t_sale_union \n";
    $sql .= "               ) \n";
    $sql .= "               UNION ALL \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id, \n";
    $sql .= "                       collect_staff_id AS staff_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_payin_h \n";
    $sql .= "               ) \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_shop_union \n";
    $sql .= "           INNER JOIN t_staff ON t_shop_union.staff_id = t_staff.staff_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_shop_union.shop_id = $shop_id \n";
    if ($staff_id != null){
    $sql .= "       AND \n";
    $sql .= "           t_shop_union.staff_id = $staff_id \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           t_shop_union.shop_id, \n";
    $sql .= "           t_shop_union.staff_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_staff.staff_name \n";
    $sql .= "       ORDER BY \n";
    $sql .= "           t_staff.charge_cd \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_attach_staff \n";
    // ■売上データ(join 商品マスタ)
    $sql .= "   LEFT JOIN \n";
    $sql .= "   (\n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id, \n";
    $sql .= "           staff_id, \n";
    // 現金売上 - 明細件数
    foreach ($ary_sale_div as $key => $value){
    $sql .= "           COUNT( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (61, 63, 64) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       t_sale_union.sale_d_id \n";
    $sql .= "               END \n";
    $sql .= "           ) AS genkin_".$value."_count, \n";
    }
    // 現金売上 - 原価
    foreach ($ary_sale_div as $key => $value){
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (61) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.cost_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (63, 64) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.cost_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS genkin_".$value."_cost_amount, \n";
    }
    // 現金売上 - 金額
    foreach ($ary_sale_div as $key => $value){
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (61) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (63, 64) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS genkin_".$value."_sale_amount, \n";
    }
    // 現金売上 - 販売管理外件数
    $sql .= "           COUNT( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (61, 63, 64) AND \n";
    $sql .= "                       t_sale_union.sale_manage = '2' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       t_sale_union.sale_d_id \n";
    $sql .= "               END \n";
    $sql .= "           ) AS genkin_gai_count, \n";
    // 現金売上 - 販売管理外原価
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (61) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.cost_amount) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (63, 64) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.cost_amount) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS genkin_gai_cost_amount, \n";
    // 現金売上 - 販売管理外金額
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (61) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (63, 64) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS genkin_gai_sale_amount, \n";
    // 掛売上 - 明細件数
    foreach ($ary_sale_div as $key => $value){
    $sql .= "           COUNT( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (11, 13, 14, 15) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       t_sale_union.sale_d_id \n";
    $sql .= "               END \n";
    $sql .= "           ) AS kake_".$value."_count, \n";
    }
    // 掛売上 - 原価
    foreach ($ary_sale_div as $key => $value){
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (11, 15) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.cost_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (13, 14) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.cost_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS kake_".$value."_cost_amount, \n";
    }
    // 掛売上 - 金額
    foreach ($ary_sale_div as $key => $value){
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (11, 15) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (13, 14) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS kake_".$value."_sale_amount, \n";
    }
    // 掛売上 - 販売管理外件数
    $sql .= "           COUNT( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (11, 13, 14, 15) AND \n";
    $sql .= "                       t_sale_union.sale_manage = '2' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       t_sale_union.sale_d_id \n";
    $sql .= "               END \n";
    $sql .= "           ) AS kake_gai_count, \n";
    // 掛売上 - 販売管理外原価
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (11, 15) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.cost_amount) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (13, 14) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.cost_amount) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS kake_gai_cost_amount, \n";
    // 掛売上 - 販売管理外金額
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (11, 15) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (13, 14) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS kake_gai_sale_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    foreach ($ary_main_sub as $key => $value){
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       t_sale_d_amount.sale_d_id, \n";
    $sql .= "                       t_sale_d_amount.shop_id, \n";
    $sql .= "                       t_sale_d_amount.trade_id, \n";
    $sql .= "                       t_sale_d_amount.sale_div_cd, \n";
    $sql .= "                       t_goods.sale_manage, \n";
    $sql .= "                       t_sale_d_amount.renew_flg, \n";
    $sql .= "                       t_sale_d_amount.sale_day, \n";
    $sql .= "                       t_sale_d_amount.".$value."_staff_id AS staff_id, \n";
    $sql .= "                       COALESCE(t_sale_d_amount.".$value."_cost_amount, 0) AS cost_amount, \n";
    $sql .= "                       COALESCE(t_sale_d_amount.".$value."_sale_amount, 0) AS sale_amount \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_sale_d_amount \n";
    $sql .= "                       LEFT JOIN t_goods ON t_sale_d_amount.goods_id = t_goods.goods_id \n";
    $sql .= "               ) \n";
        if ($key+1 < count($ary_main_sub)){
    $sql .= "               UNION ALL \n";
        }
    }
    $sql .= "           ) \n";
    $sql .= "           AS t_sale_union \n";
    $sql .= "       WHERE \n";
    $sql .= "           renew_flg = 'f' \n";
    if ($end_day != null){
    $sql .= "       AND \n";
    $sql .= "           sale_day <= '$end_day' \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           shop_id, \n";
    $sql .= "           staff_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_sale_data \n";
    $sql .= "   ON t_attach_staff.shop_id = t_sale_data.shop_id \n";
    $sql .= "   AND t_attach_staff.staff_id = t_sale_data.staff_id \n";
    // ■売上ヘッダ(join 取引先マスタ)
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id, \n";
    $sql .= "           staff_id, \n";
    // 現金売上 - 伝票消費税額
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           trade_id = 61 AND \n";
    $sql .= "                           c_tax_div = '1' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(tax_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           trade_id IN (63, 64) AND \n";
    $sql .= "                           c_tax_div = '1' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(tax_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS genkin_tax_amount, \n";
    // 掛売上 - 伝票消費税額
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           trade_id IN (11, 15) AND \n";
    $sql .= "                           c_tax_div = '1' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(tax_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           trade_id IN (13, 14) AND \n";
    $sql .= "                           c_tax_div = '1' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(tax_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS kake_tax_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    foreach ($ary_main_sub as $key => $value){
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       t_sale_h_amount.shop_id, \n";
    $sql .= "                       t_sale_h_amount.trade_id, \n";
    $sql .= "                       t_sale_h_amount.renew_flg, \n";
    $sql .= "                       t_sale_h_amount.sale_day, \n";
    $sql .= "                       t_client.c_tax_div, \n";
    $sql .= "                       t_sale_h_amount.".$value."_staff_id AS staff_id, \n";
    $sql .= "                       COALESCE(t_sale_h_amount.".$value."_tax_amount, 0) AS tax_amount \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_sale_h_amount \n";
    $sql .= "                       LEFT JOIN t_client ON t_sale_h_amount.client_id = t_client.client_id \n";
    $sql .= "               ) \n";
        if ($key+1 < count($ary_main_sub)){
    $sql .= "               UNION ALL \n";
        }
    }
    $sql .= "           ) \n";
    $sql .= "           AS t_sale_union \n";
    $sql .= "       WHERE \n";
    $sql .= "           renew_flg = 'f' \n";
    if ($end_day != null){
    $sql .= "       AND \n";
    $sql .= "           sale_day <= '$end_day' \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           shop_id, \n";
    $sql .= "           staff_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_sale_tax \n";
    $sql .= "   ON t_attach_staff.shop_id = t_sale_tax.shop_id \n";
    $sql .= "   AND t_attach_staff.staff_id = t_sale_tax.staff_id \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_attach_staff.charge_cd \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $ary_sale_daily_data = Get_data($res, "", "ASSOC");
    }else{
        $ary_sale_daily_data = array(null);
    }
    
    /*** 月次売上データ取得 ***/
    $sql  = "SELECT \n";
    $sql .= "   t_attach_staff.staff_id, \n";
    $sql .= "   t_attach_staff.staff_name, \n";
    foreach ($ary_sale_div as $key => $value){
    $sql .= "   t_sale_data.genkin_".$value."_sale_amount, \n";
    }
    $sql .= "   t_sale_tax.genkin_tax_amount, \n";
    $sql .= "   t_sale_data.genkin_gai_sale_amount, \n";
    foreach ($ary_sale_div as $key => $value){
    $sql .= "   t_sale_data.kake_".$value."_sale_amount, \n";
    }
    $sql .= "   t_sale_tax.kake_tax_amount, \n";
    $sql .= "   t_sale_data.kake_gai_sale_amount \n";
    $sql .= "FROM \n";
    // ■ショップ・担当者
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_shop_union.shop_id, \n";
    $sql .= "           t_shop_union.staff_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_staff.staff_name \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id, \n";
    $sql .= "                       staff_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       ( \n";
    foreach ($ary_main_sub as $key => $value){
    $sql .= "                           ( \n";
    $sql .= "                               SELECT \n";
    $sql .= "                                   shop_id, \n";
    $sql .= "                                   ".$value."_staff_id AS staff_id \n";
    $sql .= "                               FROM \n";
    $sql .= "                                   t_sale_h_amount \n";
    $sql .= "                           ) \n";
        if ($key+1 < count($ary_main_sub)){
    $sql .= "                           UNION ALL \n";
        }       
    }
    $sql .= "                       ) \n";
    $sql .= "                       AS t_sale_union \n";
    $sql .= "               ) \n";
    $sql .= "               UNION ALL \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id, \n";
    $sql .= "                       collect_staff_id AS staff_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_payin_h \n";
    $sql .= "               ) \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_shop_union \n";
    $sql .= "           INNER JOIN t_staff ON t_shop_union.staff_id = t_staff.staff_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_shop_union.shop_id = $shop_id \n";
    if ($staff_id != null){
    $sql .= "       AND \n";
    $sql .= "           t_shop_union.staff_id = $staff_id \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           t_shop_union.shop_id, \n";
    $sql .= "           t_shop_union.staff_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_staff.staff_name \n";
    $sql .= "       ORDER BY \n";
    $sql .= "           t_staff.charge_cd \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_attach_staff \n";
    // ■売上データ(join 商品マスタ)
    $sql .= "   LEFT JOIN \n";
    $sql .= "   (\n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id, \n";
    $sql .= "           staff_id, \n";
    // 現金売上 - 金額
    foreach ($ary_sale_div as $key => $value){
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (61) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (63, 64) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS genkin_".$value."_sale_amount, \n";
    }
    // 現金売上 - 販売管理外金額
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (61) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (63, 64) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS genkin_gai_sale_amount, \n";
    // 掛売上 - 金額
    foreach ($ary_sale_div as $key => $value){
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (11, 15) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (13, 14) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS kake_".$value."_sale_amount, \n";
    }
    // 掛売上 - 販売管理外金額
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (11, 15) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (13, 14) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS kake_gai_sale_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    foreach ($ary_main_sub as $key => $value){
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       t_sale_d_amount.sale_d_id, \n";
    $sql .= "                       t_sale_d_amount.shop_id, \n";
    $sql .= "                       t_sale_d_amount.trade_id, \n";
    $sql .= "                       t_sale_d_amount.sale_div_cd, \n";
    $sql .= "                       t_goods.sale_manage, \n";
    $sql .= "                       t_sale_d_amount.sale_day, \n";
    $sql .= "                       t_sale_d_amount.".$value."_staff_id AS staff_id, \n";
    $sql .= "                       COALESCE(t_sale_d_amount.".$value."_sale_amount, 0) AS sale_amount \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_sale_d_amount \n";
    $sql .= "                       LEFT JOIN t_goods ON t_sale_d_amount.goods_id = t_goods.goods_id \n";
    $sql .= "               ) \n";
        if ($key+1 < count($ary_main_sub)){
    $sql .= "               UNION ALL \n";
        }
    }
    $sql .= "           ) \n";
    $sql .= "           AS t_sale_union \n";
    $sql .= "       WHERE \n";
    $sql .= "           sale_d_id IS NOT NULL \n";    // WHEREの対応がめんどくさいので
    if ($end_day != null){
    $sql .= "       AND \n";
    $sql .= "           sale_day <= '$end_day' \n";
    }
    if ($monthly_update_time != null){
    $sql .= "       AND \n";
    $sql .= "           sale_day > $monthly_update_time \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           shop_id, \n";
    $sql .= "           staff_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_sale_data \n";
    $sql .= "   ON t_attach_staff.shop_id = t_sale_data.shop_id \n";
    $sql .= "   AND t_attach_staff.staff_id = t_sale_data.staff_id \n";
    // ■売上ヘッダ(join 取引先マスタ)
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id, \n";
    $sql .= "           staff_id, \n";
    // 現金売上 - 伝票消費税額
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           trade_id = 61 AND \n";
    $sql .= "                           c_tax_div = '1' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(tax_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           trade_id IN (63, 64) AND \n";
    $sql .= "                           c_tax_div = '1' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(tax_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS genkin_tax_amount, \n";
    // 掛売上 - 伝票消費税額
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           trade_id IN (11, 15) AND \n";
    $sql .= "                           c_tax_div = '1' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(tax_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           trade_id IN (13, 14) AND \n";
    $sql .= "                           c_tax_div = '1' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(tax_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS kake_tax_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    foreach ($ary_main_sub as $key => $value){
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       t_sale_h_amount.sale_id, \n";
    $sql .= "                       t_sale_h_amount.shop_id, \n";
    $sql .= "                       t_sale_h_amount.trade_id, \n";
    $sql .= "                       t_sale_h_amount.sale_day, \n";
    $sql .= "                       t_client.c_tax_div, \n";
    $sql .= "                       t_sale_h_amount.".$value."_staff_id AS staff_id, \n";
    $sql .= "                       COALESCE(t_sale_h_amount.".$value."_tax_amount, 0) AS tax_amount \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_sale_h_amount \n";
    $sql .= "                       LEFT JOIN t_client ON t_sale_h_amount.client_id = t_client.client_id \n";
    $sql .= "               ) \n";
        if ($key+1 < count($ary_main_sub)){
    $sql .= "               UNION ALL \n";
        }
    }
    $sql .= "           ) \n";
    $sql .= "           AS t_sale_union \n";
    $sql .= "       WHERE \n";
    $sql .= "           sale_id IS NOT NULL \n";   // WHEREの対応がめんどくさいので
    if ($end_day != null){
    $sql .= "       AND \n";
    $sql .= "           sale_day <= '$end_day' \n";
    }
    if ($monthly_update_time != null){
    $sql .= "       AND \n";
    $sql .= "           sale_day > $monthly_update_time \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           shop_id, \n";
    $sql .= "           staff_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_sale_tax \n";
    $sql .= "   ON t_attach_staff.shop_id = t_sale_tax.shop_id \n";
    $sql .= "   AND t_attach_staff.staff_id = t_sale_tax.staff_id \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_attach_staff.charge_cd \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $ary_sale_monthly_data = Get_Data($res, "", "ASSOC");
    }else{
        $ary_sale_monthly_data = array(null);
    }
print_array($ary_sale_monthly_data);

    /* それぞれの合計を算出 */
    $i = 0;
    foreach ($ary_sale_daily_data as $key => $value){

        // 現金売上 - 件数
        $ary_sale_total_data[$value["staff_id"]]["genkin_count"]        = $ary_sale_daily_data[$i]["genkin_01_count"]
                                                                        + $ary_sale_daily_data[$i]["genkin_02_count"]
                                                                        + $ary_sale_daily_data[$i]["genkin_03_count"]
                                                                        + $ary_sale_daily_data[$i]["genkin_04_count"]
                                                                        + $ary_sale_daily_data[$i]["genkin_05_count"]
                                                                        + $ary_sale_daily_data[$i]["genkin_06_count"]
                                                                        + $ary_sale_daily_data[$i]["genkin_07_count"]
                                                                        + $ary_sale_daily_data[$i]["genkin_08_count"]
                                                                        ;
        // 現金売上 - 原価
        $ary_sale_total_data[$value["staff_id"]]["genkin_cost_amount"]  = $ary_sale_daily_data[$i]["genkin_01_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_02_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_03_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_04_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_05_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_06_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_07_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_08_cost_amount"]
                                                                        ;
        // 現金売上 - 金額
        $ary_sale_total_data[$value["staff_id"]]["genkin_sale_amount"]  = $ary_sale_daily_data[$i]["genkin_01_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_02_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_03_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_04_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_05_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_06_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_07_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_08_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_tax_amount"]
                                                                        ;
        // 現金売上 - 月次累計
        $ary_sale_total_data[$value["staff_id"]]["genkin_monthly_amount"] = $ary_sale_monthly_data[$i]["genkin_01_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["genkin_02_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["genkin_03_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["genkin_04_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["genkin_05_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["genkin_06_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["genkin_07_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["genkin_08_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["genkin_tax_amount"]
                                                                        ;
        // 掛売上 - 件数
        $ary_sale_total_data[$value["staff_id"]]["kake_count"]          = $ary_sale_daily_data[$i]["kake_01_count"]
                                                                        + $ary_sale_daily_data[$i]["kake_02_count"]
                                                                        + $ary_sale_daily_data[$i]["kake_03_count"]
                                                                        + $ary_sale_daily_data[$i]["kake_04_count"]
                                                                        + $ary_sale_daily_data[$i]["kake_05_count"]
                                                                        + $ary_sale_daily_data[$i]["kake_06_count"]
                                                                        + $ary_sale_daily_data[$i]["kake_07_count"]
                                                                        + $ary_sale_daily_data[$i]["kake_08_count"]
                                                                        ;
        // 掛売上 - 原価
        $ary_sale_total_data[$value["staff_id"]]["kake_cost_amount"]    = $ary_sale_daily_data[$i]["kake_01_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_02_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_03_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_04_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_05_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_06_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_07_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_08_cost_amount"]
                                                                        ;
        // 掛売上 - 金額
        $ary_sale_total_data[$value["staff_id"]]["kake_sale_amount"]    = $ary_sale_daily_data[$i]["kake_01_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_02_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_03_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_04_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_05_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_06_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_07_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_08_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_tax_amount"]
                                                                        ;
        // 掛売上 - 月次累計
        $ary_sale_total_data[$value["staff_id"]]["kake_monthly_amount"] = $ary_sale_monthly_data[$i]["kake_01_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["kake_02_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["kake_03_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["kake_04_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["kake_05_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["kake_06_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["kake_07_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["kake_08_sale_amount"]
                                                                        ;    

        $i++;

    }
print_array($ary_sale_total_data);

}

/*----------------------------------
    入金データ取得
-----------------------------------*/
/* 銀行を出力する取引区分を設定 */
$payin_bank_trade_list = array("32", "33", "35");

//$staff_id = 45;

/* 取引区分毎の銀行一覧取得（月次更新前の銀行一覧を取得） */
foreach ($payin_bank_trade_list as $key_trade => $value_trade){
    $sql  = "SELECT \n";
    $sql .= "   t_attach_staff.staff_id, \n";
    $sql .= "   t_attach_staff.staff_name, \n";
    $sql .= "   t_payin_d.trade_id, \n";
    $sql .= "   t_payin_d.bank_cd, \n";
    $sql .= "   t_payin_d.bank_name, \n";
    $sql .= "   t_payin_d.b_bank_cd, \n";
    $sql .= "   t_payin_d.b_bank_name, \n";
    $sql .= "   t_payin_d.account_no \n";
    $sql .= "FROM \n";
    // ■ショップ・担当者
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_shop_union.shop_id, \n";
    $sql .= "           t_shop_union.staff_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_staff.staff_name \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id, \n";
    $sql .= "                       staff_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       ( \n";
    foreach ($ary_main_sub as $key_staff => $value_staff){
    $sql .= "                           ( \n";
    $sql .= "                               SELECT \n";
    $sql .= "                                   shop_id, \n";
    $sql .= "                                   ".$value_staff."_staff_id AS staff_id \n";
    $sql .= "                               FROM \n";
    $sql .= "                                   t_sale_h_amount \n";
    $sql .= "                           ) \n";
        if ($key_staff+1 < count($ary_main_sub)){
    $sql .= "                           UNION ALL \n";
        }       
    }
    $sql .= "                       ) \n";
    $sql .= "                       AS t_sale_union \n";
    $sql .= "               ) \n";
    $sql .= "               UNION ALL \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id, \n";
    $sql .= "                       collect_staff_id AS staff_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_payin_h \n";
    $sql .= "               ) \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_shop_union \n";
    $sql .= "           INNER JOIN t_staff ON t_shop_union.staff_id = t_staff.staff_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_shop_union.shop_id = $shop_id \n";
    if ($staff_id != null){
    $sql .= "       AND \n";
    $sql .= "           t_shop_union.staff_id = $staff_id \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           t_shop_union.shop_id, \n";
    $sql .= "           t_shop_union.staff_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_staff.staff_name \n";
    $sql .= "       ORDER BY \n";
    $sql .= "           t_staff.charge_cd \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_attach_staff \n";
    // 入金ヘッダ - 月次更新前状態
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_payin_h.pay_id, \n";
    if ($staff_id != null){
    $sql .= "           t_payin_h.shop_id, \n";
    $sql .= "           t_payin_h.collect_staff_id AS staff_id \n";
    }else{
    $sql .= "           t_payin_h.shop_id \n";
    }
    $sql .= "       FROM \n";
    $sql .= "           t_payin_h \n";
    $sql .= ($monthly_update_time != null) ? " WHERE pay_day > $monthly_update_time \n" : null;
    $sql .= "   ) \n";
    $sql .= "   AS t_payin_monthly \n";
    $sql .= "   ON t_attach_staff.shop_id = t_payin_monthly.shop_id \n";
    if ($staff_id != null){
    $sql .= "   AND t_attach_staff.staff_id = t_payin_monthly.staff_id \n";
    }
    // 入金データ
    $sql .= "   INNER JOIN t_payin_d \n";
    $sql .= "   ON t_payin_monthly.pay_id = t_payin_d.pay_id \n";
    $sql .= "   AND trade_id = ".$value_trade." \n";
    // 条件
    $sql .= "GROUP BY \n";
    $sql .= "   t_attach_staff.staff_id, \n";
    $sql .= "   t_attach_staff.staff_name, \n";
    $sql .= "   t_attach_staff.charge_cd, \n";
    $sql .= "   t_payin_d.trade_id, \n";
    $sql .= "   t_payin_d.bank_cd, t_payin_d.bank_name, \n";
    $sql .= "   t_payin_d.b_bank_cd, t_payin_d.b_bank_name, \n";
    $sql .= "   account_no \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_attach_staff.charge_cd, \n";
    $sql .= "   t_payin_d.trade_id, \n";
    $sql .= "   t_payin_d.bank_cd, t_payin_d.bank_name, \n";
    $sql .= "   t_payin_d.b_bank_cd, t_payin_d.b_bank_name, \n";
    $sql .= "   account_no \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    if ($num > 0){
        $ary_payin_data_list = Get_Data($res, "", "ASSOC");

        $i = 0;
        foreach ($ary_payin_data_list as $key_data => $value_data){
            $ary_payin_trade_bank_list[$value_data["staff_id"]][$value_trade][$i]["bank_cd"]    = $value_data["bank_cd"];
            $ary_payin_trade_bank_list[$value_data["staff_id"]][$value_trade][$i]["bank_name"]  = $value_data["bank_name"];
            $ary_payin_trade_bank_list[$value_data["staff_id"]][$value_trade][$i]["b_bank_cd"]  = $value_data["b_bank_cd"];
            $ary_payin_trade_bank_list[$value_data["staff_id"]][$value_trade][$i]["b_bank_cd"]  = $value_data["b_bank_cd"];
            $ary_payin_trade_bank_list[$value_data["staff_id"]][$value_trade][$i]["account_no"] = $value_data["account_no"];
            $i++;
        }

    }else{

        $ary_payin_trade_bank_list = array(null);

    }

}
print_array($ary_payin_trade_bank_list);

/* 取得した銀行一覧を元にその銀行の明細を取得 */
foreach ($ary_payin_trade_bank_list as $key_staff1 => $value_staff2){

    


    // 該当取引区分に銀行データがある場合
    if ($value != null){
        for ($j=0; $j<count($value); $j++){
            $sql  = "SELECT \n";
            $sql .= "   t_payin_data.bank_cd, \n";
            $sql .= "   t_payin_data.bank_name, \n";
            $sql .= "   t_payin_data.b_bank_cd, \n";
            $sql .= "   t_payin_data.b_bank_name, \n";
            $sql .= "   t_payin_data.account_no, \n";
            $sql .= "   COALESCE(t_payin_data.daily_pay_count, 0) AS daily_pay_count, \n";
            $sql .= "   COALESCE(t_payin_data.daily_pay_amount, 0) AS daily_pay_amount, \n";
            $sql .= "   COALESCE(t_payin_data.monthly_pay_amount, 0) AS monthly_pay_amount \n";
            $sql .= "FROM \n";
            // ■ショップ・担当者
            $sql .= "   ( \n";
            $sql .= "       SELECT \n";
            $sql .= "           t_shop.shop_id, \n";
            if ($staff_id != null){
            $sql .= "           t_shop.staff_id, \n";
            $sql .= "           t_staff.charge_cd, \n";
            $sql .= "           t_staff.staff_name \n";
            }else{
            $sql .= "           NULL, \n";
            $sql .= "           NULL, \n";
            $sql .= "           NULL \n";
            }
            $sql .= "       FROM \n";
            $sql .= "           ( \n";
            $sql .= "               SELECT \n";
            $sql .= "                   shop_id, \n";
            $sql .= "                   collect_staff_id AS staff_id \n";
            $sql .= "               FROM \n";
            $sql .= "                   t_payin_h \n";
            $sql .= "           ) \n";
            $sql .= "           AS t_shop \n";
            $sql .= "           INNER JOIN t_staff ON t_shop.staff_id = t_staff.staff_id \n";
            $sql .= "       WHERE \n";
            $sql .= "           t_shop.shop_id = $shop_id \n";
            if ($staff_id != null){
            $sql .= "       AND \n";
            $sql .= "           t_shop.staff_id = $staff_id \n";
            $sql .= "       GROUP BY \n";
            $sql .= "           t_shop.shop_id, \n";
            $sql .= "           t_shop.staff_id, \n";
            $sql .= "           t_staff.charge_cd, \n";
            $sql .= "           t_staff.staff_name \n";
            $sql .= "       ORDER BY \n";
            $sql .= "           t_staff.charge_cd \n";
            }else{
            $sql .= "       GROUP BY \n";
            $sql .= "           t_shop.shop_id \n";
            }
            $sql .= "   ) \n";
            $sql .= "   AS t_attach_staff \n";
            // ■入金ヘッダ（JOIN 入金データ）
            $sql .= "   LEFT JOIN \n";
            $sql .= "   ( \n";
            $sql .= "       SELECT \n";
            if ($staff_id != null){
            $sql .= "           t_payin_h.collect_staff_id AS staff_id, \n";
            }
            $sql .= "           t_payin_h.shop_id, \n";
            $sql .= "           t_payin_d.bank_cd, \n";
            $sql .= "           t_payin_d.bank_name, \n";
            $sql .= "           t_payin_d.b_bank_cd, \n";
            $sql .= "           t_payin_d.b_bank_name, \n";
            $sql .= "           t_payin_d.account_no, \n";
            $sql .= "           COUNT( \n";
            $sql .= "               CASE \n";
            $sql .= "                   WHEN \n";
            $sql .= "                       t_payin_h.renew_flg = 'f' \n";
            $sql .= "                   THEN \n";
            $sql .= "                       t_payin_d.pay_d_id \n";
            $sql .= "               END \n";
            $sql .= "           ) AS daily_pay_count, \n";
            $sql .= "           SUM( \n";
            $sql .= "               CASE \n";
            $sql .= "                   WHEN \n";
            $sql .= "                       t_payin_h.renew_flg = 'f' \n";
            $sql .= "                   THEN \n";
            $sql .= "                       COALESCE(t_payin_d.amount, 0) \n";
            $sql .= "                   ELSE 0 \n";
            $sql .= "               END \n";
            $sql .= "           ) AS daily_pay_amount, \n";
            $sql .= "           SUM(COALESCE(t_payin_d.amount, 0)) AS monthly_pay_amount \n";
            $sql .= "       FROM \n";
            $sql .= "           t_payin_h \n";
            $sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
            $sql .= "       WHERE \n";
            $sql .= "           t_payin_h.sale_id IS NULL \n";
            if ($end_date != null){
            $sql .= "       AND \n";
            $sql .= "           t_payin_h.pay_day <= '$end_date' \n";
            }
            $sql .= "       AND \n";
            $sql .= "           trade_id = ".$value[$j][0]." \n";               // 販売区分
            $sql .= "       AND \n";
            $sql .= "           bank_cd = '".$value[$j][1]."' \n";              // 銀行コード
            $sql .= "       AND \n";
            $sql .= "           bank_name = '".$value[$j][2]."' \n";            // 銀行名
            $sql .= "       AND \n";
            $sql .= "           b_bank_cd = '".$value[$j][3]."' \n";            // 支店コード
            $sql .= "       AND \n";
            $sql .= "           b_bank_name = '".$value[$j][4]."' \n";          // 支店名
            $sql .= "       AND \n";
            $sql .= "           account_no = '".$value[$j][5]."' \n";           // 口座番号
            $sql .= "       GROUP BY \n";
            if ($staff_id != null){
            $sql .= "           t_payin_h.collect_staff_id, \n";
            }
            $sql .= "           t_payin_h.shop_id, \n";
            $sql .= "           t_payin_d.bank_cd, \n";
            $sql .= "           t_payin_d.bank_name, \n";
            $sql .= "           t_payin_d.b_bank_cd, \n";
            $sql .= "           t_payin_d.b_bank_name, \n";
            $sql .= "           t_payin_d.account_no \n";
            $sql .= "   ) \n";
            $sql .= "   AS t_payin_data \n";
            $sql .= "   ON t_attach_staff.shop_id = t_payin_data.shop_id \n";
            if ($staff_id != null){
            $sql .= "   AND t_attach_staff.staff_id = t_payin_data.staff_id \n";
            }
            $sql .= "   ORDER BY \n";
            $sql .= "       t_payin_data.bank_cd, \n";
            $sql .= "       t_payin_data.b_bank_cd, \n";
            $sql .= "       t_payin_data.account_no \n";
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $ary_payin_bank_data[$key][$j] = pg_fetch_array($res, 0, PGSQL_ASSOC);
            // データがある場合
            if ($ary_payin_bank_data[$key][$j][0] != null){
                while (list($key2, $value2) = each($ary_payin_bank_data[$key][$j])){
                    $ary_payin_bank_data[$key][$j][$key2] = $value2;
                }
            }
        }
    // 該当取引区分に銀行データが無い場合
    }else{
        $ary_payin_bank_data[$key] = null;
    }
}

/*  銀行出力する明細の、画面表示用一覧配列作成 */
// 取引区分毎ループ
foreach ($payin_bank_trade_list as $key => $value){

    // 該当取引君の取得データが無い場合
    if ($value != null){

        // 月次更新前データの銀行支店毎ループ
        for ($j=0; $j<count($ary_payin_bank_data[$value]); $j++){

            // 日次更新前データ、月次更新前データを配列に代入
            // 銀行コード-支店コード（月次累計データから取得）
            $ary_payin_bank_data[$value][$j]["bank_b_bank_cd"]      = $ary_payin_bank_data[$value][$j]["bank_cd"]."-".
                                                                      $ary_payin_bank_data[$value][$j]["b_bank_cd"];
            // 銀行名　支店名<br>口座番号（月次累計データから取得）
            $ary_payin_bank_data[$value][$j]["bank_b_bank_name"]    = $ary_payin_bank_data[$value][$j]["bank_name"]."　".
                                                                      $ary_payin_bank_data[$value][$j]["b_bank_name"]."<br>".
                                                                      $ary_payin_bank_data[$value][$j]["account_no"];
            // 件数（日次データ）
            $ary_payin_bank_data[$value][$j]["daily_pay_count"]     = ($ary_payin_bank_data[$value][$j] == null) ? "0"
                                                                    : $ary_payin_bank_data[$value][$j]["daily_pay_count"];
            // 金額（日次データ）
            $ary_payin_bank_data[$value][$j]["daily_pay_amount"]    = ($ary_payin_bank_data[$value][$j] == null) ? "0"
                                                                    : $ary_payin_bank_data[$value][$j]["daily_pay_amount"];
            // 金額（月次累計データ）
            $ary_payin_bank_data[$value][$j]["monthly_pay_amount"]  = $ary_payin_bank_data[$value][$j]["monthly_pay_amount"];

            // 合計算出のため、加算していく
            $payin_total[$value]["daily_pay_count"]     += $ary_payin_bank_data[$value][$j]["daily_pay_count"];
            $payin_total[$value]["daily_pay_amount"]    += $ary_payin_bank_data[$value][$j]["daily_pay_amount"];
            $payin_total[$value]["monthly_pay_amount"]  += $ary_payin_bank_data[$value][$j]["monthly_pay_amount"];

        }

    }

}

/*** 銀行毎出力しない取引区分の明細データ取得 ***/

/* 銀行を出力しない取引区分を設定 */
$payin_nonbank_trade_list = array("31", "34", "36", "37", "38");

/* 日次更新前データ取得 */
foreach ($payin_nonbank_trade_list as $key => $value){
    $sql  = "SELECT \n";
    $sql .= "   t_payin_data.daily_pay_count, \n";
    $sql .= "   COALESCE(t_payin_data.daily_pay_amount, 0) AS daily_pay_amount, \n";
    $sql .= "   COALESCE(t_payin_data.monthly_pay_amount, 0) AS monthly_pay_amount \n";
    $sql .= "FROM \n";
    // ■ショップ・担当者
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_shop.shop_id, \n";
    if ($staff_id != null){
    $sql .= "           t_shop.staff_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_staff.staff_name \n";
    }else{
    $sql .= "           NULL, \n";
    $sql .= "           NULL, \n";
    $sql .= "           NULL \n";
    }
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               SELECT \n";
    $sql .= "                   shop_id, \n";
    $sql .= "                   collect_staff_id AS staff_id \n";
    $sql .= "               FROM \n";
    $sql .= "                   t_payin_h \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_shop \n";
    $sql .= "           INNER JOIN t_staff ON t_shop.staff_id = t_staff.staff_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_shop.shop_id = $shop_id \n";
    if ($staff_id != null){
    $sql .= "       AND \n";
    $sql .= "           t_shop.staff_id = $staff_id \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           t_shop.shop_id, \n";
    $sql .= "           t_shop.staff_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_staff.staff_name \n";
    $sql .= "       ORDER BY \n";
    $sql .= "           t_staff.charge_cd \n";
    }else{
    $sql .= "       GROUP BY \n";
    $sql .= "           t_shop.shop_id \n";
    }
    $sql .= "   ) \n";
    $sql .= "   AS t_attach_staff \n";
    // ■入金ヘッダ(join 入金データ)
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_payin_h.shop_id, \n";
    if ($staff_id != null){
    $sql .= "           t_payin_h.collect_staff_id AS staff_id, \n";
    }
    $sql .= "           COUNT( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payin_h.renew_flg = 'f' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       t_payin_d.pay_d_id \n";
    $sql .= "               END \n";
    $sql .= "           ) AS daily_pay_count, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payin_h.renew_flg = 'f' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payin_d.amount, 0) \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS daily_pay_amount, \n";
    $sql .= "           SUM(COALESCE(t_payin_d.amount, 0)) AS monthly_pay_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payin_h \n";
    $sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payin_h.sale_id IS NULL \n";
    $sql .= "       AND \n";
    $sql .= "           trade_id = $value \n";
    if ($monthly_update_date != null){
    $sql .= "       AND \n";
    $sql .= "           t_payin_h.pay_day > '$monthly_update_date' \n";
    }
    $sql .= "       GROUP BY \n";
    if ($staff_id != null){
    $sql .= "           t_payin_h.shop_id, \n";
    $sql .= "           t_payin_h.collect_staff_id \n";
    }else{
    $sql .= "           t_payin_h.shop_id \n";
    }
    $sql .= "   ) \n";
    $sql .= "   AS t_payin_data \n";
    $sql .= "   ON t_attach_staff.shop_id = t_payin_data.shop_id \n";
    if ($staff_id != null){
    $sql .= "   AND t_attach_staff.staff_id = t_payin_data.staff_id \n";
    }
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $payin_total[$value] = pg_fetch_array($res, 0 ,PGSQL_ASSOC);
    }else{
        $payin_total[$value] = null;
    }

}


/****************************/
// HTML作成
/****************************/
$html  = null; 

/*** 売上 ***/
$row   = 0;
$ary_genkin_kake    = array("genkin" => "現金", "kake" => "掛");
$ary_sale_div       = array(
    "01" => "リピート",
    "02" => "商品",
    "03" => "レンタル",
    "04" => "リース",
    "05" => "工事",
    "06" => "その他",
    "07" => "保険",
    "08" => "代行",
);

$html .= "<tr class=\"Result3\" style=\"font-weight: bold;\">\n";
$html .= "  <td colspan=\"8\">【売上明細】</td> \n";
$html .= "</tr>\n";
foreach ($ary_genkin_kake as $key_g_k => $value_g_k){
    foreach ($ary_sale_div as $key_s_d => $value_s_d){
// 販売区分毎
$html .= "<tr class=\"Result1\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td>【".$value_g_k."売上】</td>\n";
$html .= "  <td>【".$value_s_d."】</td>\n";
$color = Font_Color($ary_sale_daily_data[$key_g_k."_".$key_s_d."_count"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data[$key_g_k."_".$key_s_d."_count"])."</td>\n";
$color = Font_Color($ary_sale_daily_data[$key_g_k."_".$key_s_d."_cost_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data[$key_g_k."_".$key_s_d."_cost_amount"])."</td>\n";
$color = Font_Color($ary_sale_daily_data[$key_g_k."_".$key_s_d."_sale_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data[$key_g_k."_".$key_s_d."_sale_amount"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($ary_sale_monthly_data[$key_g_k."_".$key_s_d."_sale_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_monthly_data[$key_g_k."_".$key_s_d."_sale_amount"])."</td>\n";
$html .= "</tr>\n";
    }
// 伝票消費税
$html .= "<tr class=\"Result1\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td>【".$value_g_k."売上】</td>\n";
$html .= "  <td>【伝票消費税】</td>\n";
$html .= "  <td align=\"center\">-</td>\n";
$html .= "  <td align=\"center\">-</td>\n";
$color = Font_Color($ary_sale_daily_data[$key_g_k."_tax_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data[$key_g_k."_tax_amount"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($ary_sale_monthly_data[$key_g_k."_tax_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_monthly_data[$key_g_k."_tax_amount"])."</td>\n";
$html .= "</tr>\n";
// 販売管理外
$html .= "<tr class=\"Result5\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td></td>\n";
$html .= "  <td>【販売管理外商品】</td>\n";
$color = Font_Color($ary_sale_daily_data[$key_g_k."_gai_count"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data[$key_g_k."_gai_count"])."</td>\n";
$color = Font_Color($ary_sale_daily_data[$key_g_k."_gai_cost_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data[$key_g_k."_gai_cost_amount"])."</td>\n";
$color = Font_Color($ary_sale_daily_data[$key_g_k."_gai_sale_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data[$key_g_k."_gai_sale_amount"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($ary_sale_monthly_data[$key_g_k."_gai_sale_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_monthly_data[$key_g_k."_gai_sale_amount"])."</td>\n";
$html .= "</tr>\n";
// 伝票消費税
$html .= "<tr class=\"Result2\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td></td>\n";
$html .= "  <td><b>【合計】</b></td>\n";
$color = Font_Color($ary_sale_total_data[$key_g_k."_count"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_total_data[$key_g_k."_count_amount"])."</td>\n";
$color = Font_Color($ary_sale_total_data[$key_g_k."_cost_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_total_data[$key_g_k."_cost_amount"])."</td>\n";
$color = Font_Color($ary_sale_total_data[$key_g_k."_sale_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_total_data[$key_g_k."_sale_amount"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($ary_sale_total_data[$key_g_k."_monthly_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_total_data[$key_g_k."_monthly_amount"])."</td>\n";
$html .= "</tr>\n";
    if ($key_g_k == "genkin"){
$html .= "<tr class=\"Result1\">\n";
$html .= "<td align=\"right\">".++$row."</td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "</tr>\n";
    }
}

/*** 入金 ***/
$row = 0;
if ($staff_id != null){
    // スタッフが選択された場合は現金入金のみ
    $ary_payin_trade = array("31" => array(false, "現金入金"));
}else{
    $ary_payin_trade = array(
        // "取引区分コード" => array(銀行出力有無フラグ, "取引区分名")
        "31" => array(false, "現金入金"),
        "32" => array(true,  "振込入金"),
        "33" => array(true,  "手形入金"),
        "34" => array(false, "相殺"),
        "35" => array(true,  "手数料"),
        "36" => array(false, "その他入金"),
        "37" => array(false, "スイット相殺"),
        "38" => array(false, "入金調整"),
    );
}

$html .= "<tr class=\"Result3\" style=\"font-weight: bold;\">\n";
$html .= "  <td colspan=\"8\">【入金明細】</td>\n";
$html .= "</tr>\n";
foreach ($ary_payin_trade as $key_trade1 => $value_trade1){
$html .= "<tr class=\"Result1\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td>【".$value_trade1[1]."】</td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "</tr>\n";
    if ($value_trade1[0] == true){
        foreach ($ary_payin_bank_data as $key_trade2 => $value_trade2){
            if ($key_trade1 == $key_trade2 && $value_trade2 != null){
                foreach ($value_trade2 as $key_bank => $value_bank){
$html .= "<tr class=\"Result1\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td>".$value_bank["bank_b_bank_cd"]."</td>\n";
$html .= "  <td>".$value_bank["bank_b_bank_name"]."</td>\n";
$color = Font_Color($value_bank["daily_pay_count"]);
$html .= "  <td align=\"right\"".$color.">".number_format($value_bank["daily_pay_count"])."</td>\n";
$html .= "  <td align=\"center\">-</td>\n";
$color = Font_Color($value_bank["daily_pay_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($value_bank["daily_pay_amount"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($value_bank["monthly_pay_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($value_bank["monthly_pay_amount"])."</td>\n";
$html .= "</tr>\n";
                }
            }
        }
    }
$html .= "<tr class=\"Result2\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td></td>\n";
$html .= "  <td><b>【合計】</b></td>\n";
$color = Font_Color($payin_total[$key_trade1]["daily_pay_count"]);
$html .= "  <td align=\"right\"".$color.">".number_format($payin_total[$key_trade1]["daily_pay_count"])."</td>\n";
$html .= "  <td align=\"center\">-</td>\n";
$color = Font_Color($payin_total[$key_trade1]["daily_pay_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($payin_total[$key_trade1]["daily_pay_amount"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($payin_total[$key_trade1]["monthly_pay_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($payin_total[$key_trade1]["monthly_pay_amount"])."</td>\n";
$html .= "</tr>\n";
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
$page_menu = Create_Menu_h('renew','1');

/****************************/
// 画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

/****************************/
// ページ作成
/****************************/
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
    "daily_update_time" => "$daily_update_time",
    "now"               => date("Y-m-d"),
    "end_day"           => "$end_day",
    "numrows"           => "$numrows",
    "html"              => $html,
));

$smarty->assign("disp_staff_data", $disp_staff_data);

$smarty->assign("sale_daily_data",              $disp_sale_daily_data);
$smarty->assign("sale_monthly_data",            $disp_sale_monthly_data);
$smarty->assign("sale_genkin_total_data",       $disp_sale_genkin_total_data);
$smarty->assign("sale_kake_total_data",         $disp_sale_kake_total_data);

$smarty->assign("disp_payin_bank_data",         $disp_payin_bank_data);
$smarty->assign("disp_payin_bank_total",        $disp_payin_bank_total);
$smarty->assign("disp_payin_nonbank_total",     $disp_payin_nonbank_total);
$smarty->assign("row_count_payin",              $row_count_payin);

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
