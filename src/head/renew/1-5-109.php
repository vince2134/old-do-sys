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


/*****************************/
// 権限関連処理
/*****************************/
// 権限チェック
$auth       = Auth_Check($db_con);


/****************************/
// 外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];

$end_y      = ($_POST["form_end_date"]["y"] != null) ? str_pad($_POST["form_end_date"]["y"], 4, 0, STR_POS_LEFT) : null; 
$end_m      = ($_POST["form_end_date"]["m"] != null) ? str_pad($_POST["form_end_date"]["m"], 2, 0, STR_POS_LEFT) : null; 
$end_d      = ($_POST["form_end_date"]["d"] != null) ? str_pad($_POST["form_end_date"]["d"], 2, 0, STR_POS_LEFT) : null; 
$end_day   = ($end_y != null && $end_m != null && $end_d != null) ? $end_y."-".$end_m."-".$end_d : null; 

/****************************/
// フォーム初期値設定
/****************************/
$def_fdata = array(
    "form_output_radio"    => "1"  
);

$form->setDefaults($def_fdata);


/****************************/
// フォームパーツ定義
/****************************/
// 出力形式
$radio = null; 
$radio[] =& $form->createElement("radio", null, null, "画面", "1");
$radio[] =& $form->createElement("radio", null, null, "帳票", "2");
$form->addGroup($radio, "form_output_radio", "");

// 集計期間
$form_end_date[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\"
    style=\"$g_form_style \"
    onkeyup=\"changeText(this.form,'form_end_date[y]','form_end_date[m]',4)\" 
    onFocus=\"onForm_today(this,this.form,'form_end_date[y]','form_end_date[m]','form_end_date[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_end_date[] = $form->createElement(
    "text","m","","size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style \"
    onkeyup=\"changeText(this.form, 'form_end_date[m]','form_end_date[d]',2)\" 
    onFocus=\"onForm_today(this,this.form,'form_end_date[y]','form_end_date[m]','form_end_date[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_end_date[] = $form->createElement(
    "text","d","",
    "size=\"2\" maxLength=\"2\"
    style=\"$g_form_style \" 
    onFocus=\"onForm_today(this,this.form,'form_end_date[y]','form_end_date[m]','form_end_date[d]')\"
    onBlur=\"blurForm(this)\""
);
$form->addGroup($form_end_date, "form_end_date", "", " - "); 

// オペレータ
$select_staff   = null; 
$select_staff   = Select_Get($db_con, "shop_staff");
$form->addElement("select", "form_staff_select", "", $select_staff, "$g_form_option_select");

// 表示ボタン
$form->addElement("submit", "form_show_button", "表　示");

// クリアボタン
$form->addElement("button", "form_clear_button", "クリア", "onClick=\"location.href='$_SERVER[PHP_SELF]'\"");


/* 最終日次更新日 */
$sql  = "SELECT MAX(close_day) ";
$sql .= "FROM   t_sys_renew ";
$sql .= "WHERE  renew_div = '1' ";
$sql .= "AND    shop_id = $shop_id ";
$sql .= ";"; 
$res  = Db_Query($db_con, $sql);
$daily_update_time = pg_fetch_result($res, 0);
if ($daily_update_time != null){
    $ary_daily_update_time = explode("-", $daily_update_time);
    $daily_update_time = date("Y-m-d", mktime(0, 0, 0, $ary_daily_update_time[1] , $ary_daily_update_time[2]+1, $ary_daily_update_time[0]));
}else{
    $daily_update_time = START_DAY;
}

// 最終月次締日
$sql  = "SELECT MAX(close_day) ";
$sql .= "FROM   t_sys_renew ";
$sql .= "WHERE  renew_div = '2' ";
$sql .= "AND    shop_id = $shop_id ";
$sql .= ";"; 
$res  = Db_Query($db_con, $sql);
$monthly_update_time = pg_fetch_result($res, 0);
if ($monthly_update_time != null){
    $ary_monthly_update_time = explode("-", $monthly_update_time);
    $monthly_update_time = date("Y-m-d", mktime(0, 0, 0, $ary_monthly_update_time[1] , $ary_monthly_update_time[2]+1, $ary_monthly_update_time[0]));
}else{
    $monthly_update_time = START_DAY;
}

/****************************/
// 表示ボタン押下時処理
/****************************/
if (isset($_POST["form_show_button"])){

    // エラーフラグ格納先配列
    $ary_err_flg = array(null);

    // POSTされた日付を整形
    $end_y = ($_POST["form_end_date"]["y"] != null) ? str_pad($_POST["form_end_date"]["y"], 4, 0, STR_POS_LEFT) : null;
    $end_m = ($_POST["form_end_date"]["m"] != null) ? str_pad($_POST["form_end_date"]["m"], 2, 0, STR_POS_LEFT) : null;
    $end_d = ($_POST["form_end_date"]["d"] != null) ? str_pad($_POST["form_end_date"]["d"], 2, 0, STR_POS_LEFT) : null;

    /****************************/
    // エラーチェック
    /****************************/
    // どれか1つでも入力がある場合
    if ($end_y != null || $end_m != null || $end_d != null){

        // ■集計期間終了日
        $err_msg = "集計期間の日付が妥当ではありません。";
        $form->addGroupRule("form_end_date", array(
            "y" => array(
                array($err_msg, "required"),
                array($err_msg, "regex", "/^[0-9]+$/")
            ),      
            "m" => array(
                array($err_msg, "required"),
                array($err_msg, "regex", "/^[0-9]+$/")
            ),      
            "d" => array(
                array($err_msg, "required"),
                array($err_msg, "regex", "/^[0-9]+$/")
            )       
        ));  

        // 日付妥当性チェック
        if (!checkdate((int)$end_m, (int)$end_d, (int)$end_y)){
            $form->setElementError("form_end_date", "集計期間の日付が妥当ではありません。");
            $ary_err_flg[] = true;
        }

/*
        // 日次更新より後の日付かチェック
        if (mb_substr($daily_update_time, 0, 10) > $end_y."-".$end_m."-".$end_d){
            $form->setElementError("form_end_date", "集計期間の日付が妥当ではありません。");
            $ary_err_flg[] = true;
        }
*/

        // 月次締日より後の日付かチェック
        if (mb_substr($monthly_update_time, 0, 10) > $end_y."-".$end_m."-".$end_d){
            $form->setElementError("form_end_date", "集計期間の日付が妥当ではありません。");
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
if ($qf_err_flg != true){

/*-----------------------------------
    スタッフ情報＋金額合計取得
-----------------------------------*/
$sql  = "SELECT \n";
$sql .= "   COALESCE(t_sale_data.sale_amount, 0)        AS sale_amount, \n";
$sql .= "   COALESCE(t_payin_data.payin_amount, 0)      AS payin_amount, \n";
$sql .= "   COALESCE(t_buy_data.buy_amount, 0)          AS buy_amount, \n";
$sql .= "   COALESCE(t_payout_data.payout_amount, 0)    AS payout_amount \n";
$sql .= "FROM \n";
// ■ショップ
$sql .= "   ( \n";
$sql .= "       SELECT \n";
$sql .= "           shop_id \n";
$sql .= "       FROM \n";
$sql .= "           ( \n";
$sql .= "               ( \n";
$sql .= "                   SELECT \n";
$sql .= "                       shop_id \n";
$sql .= "                   FROM \n";
$sql .= "                       t_sale_h \n";
$sql .= "               ) \n";
$sql .= "               UNION ALL \n";
$sql .= "               ( \n";
$sql .= "                   SELECT \n";
$sql .= "                       shop_id \n";
$sql .= "                   FROM \n";
$sql .= "                       t_payin_h \n";
$sql .= "               ) \n";
$sql .= "               UNION ALL \n";
$sql .= "               ( \n";
$sql .= "                   SELECT \n";
$sql .= "                       shop_id \n";
$sql .= "                   FROM \n";
$sql .= "                       t_buy_h \n";
$sql .= "               ) \n";
$sql .= "               UNION ALL \n";
$sql .= "               ( \n";
$sql .= "                   SELECT \n";
$sql .= "                       shop_id \n";
$sql .= "                   FROM \n";
$sql .= "                       t_payout_h \n";
$sql .= "               ) \n";
$sql .= "           ) \n";
$sql .= "           AS t_shop_union \n";
$sql .= "       WHERE \n";
$sql .= "           shop_id = $shop_id \n";
$sql .= "       GROUP BY \n";
$sql .= "           shop_id \n";
$sql .= "   ) \n";
$sql .= "   AS t_attach_staff \n";
// ■売上ヘッダ
$sql .= "   LEFT JOIN \n";
$sql .= "   (\n";
$sql .= "       SELECT \n";
$sql .= "           shop_id, \n";
                    // 売上合計
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       trade_id IN (61, 11, 15) \n";
$sql .= "                   THEN \n";
$sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       trade_id IN (63, 64, 13, 14) \n";
$sql .= "                   THEN \n";
$sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS sale_amount \n";
$sql .= "       FROM \n";
$sql .= "           t_sale_h \n";
$sql .= "       WHERE \n";
$sql .= "           renew_flg = 'f' \n";
$sql .= "       AND \n";
$sql .= "           sale_day >= '$monthly_update_time' \n";
if ($end_day != null){
$sql .= "       AND \n";
$sql .= "           sale_day <= '$end_day' \n";
}
$sql .= "       GROUP BY \n";
$sql .= "           shop_id \n";
$sql .= "   ) \n";
$sql .= "   AS t_sale_data \n";
$sql .= "   ON t_attach_staff.shop_id = t_sale_data.shop_id \n";
// ■入金ヘッダ(join 入金データ)
$sql .= "   LEFT JOIN \n";
$sql .= "   ( \n";
$sql .= "       SELECT \n";
$sql .= "           t_payin_h.shop_id, \n";
                    // 入金合計
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       t_payin_d.trade_id IN (31, 32, 33, 34, 35, 36, 37, 38) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_payin_d.amount, 0) * 1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS payin_amount \n";
$sql .= "       FROM \n";
$sql .= "           t_payin_h \n";
$sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
$sql .= "       WHERE \n";
$sql .= "           t_payin_h.renew_flg = 'f' \n";
$sql .= "       AND \n";
$sql .= "           t_payin_h.sale_id IS NULL \n";
$sql .= "       AND \n";
$sql .= "           t_payin_h.pay_day >= '$monthly_update_time' \n";
if ($end_day != null){
$sql .= "       AND \n";
$sql .= "           t_payin_h.pay_day <= '$end_day' \n";
}
$sql .= "       GROUP BY \n";
$sql .= "           t_payin_h.shop_id \n";
$sql .= "   ) \n";
$sql .= "   AS t_payin_data \n";
$sql .= "   ON t_attach_staff.shop_id = t_payin_data.shop_id \n";
// ■仕入ヘッダ
$sql .= "   LEFT JOIN \n";
$sql .= "   (\n";
$sql .= "       SELECT \n";
$sql .= "           shop_id, \n";
                    // 仕入合計
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       trade_id IN (71, 21, 25) \n";
$sql .= "                   THEN \n";
$sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       trade_id IN (73, 74, 23, 24) \n";
$sql .= "                   THEN \n";
$sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS buy_amount \n";
$sql .= "       FROM \n";
$sql .= "           t_buy_h \n";
$sql .= "       WHERE \n";
$sql .= "           renew_flg = 'f' \n";
$sql .= "       AND \n";
$sql .= "           buy_day >= '$monthly_update_time' \n";
if ($end_day != null){
$sql .= "       AND \n";
$sql .= "           buy_day <= '$end_day' \n";
}
$sql .= "       GROUP BY \n";
$sql .= "           shop_id \n";
$sql .= "   ) \n";
$sql .= "   AS t_buy_data \n";
$sql .= "   ON t_attach_staff.shop_id = t_buy_data.shop_id \n";
// 支払ヘッダ(join 仕入データ)
$sql .= "   LEFT JOIN \n";
$sql .= "   ( \n";
$sql .= "       SELECT \n";
$sql .= "           t_payout_h.shop_id, \n";
                    // 支払合計
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       t_payout_d.trade_id IN (41, 42, 43, 44, 45, 46, 47, 48) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_payout_d.pay_amount, 0) * 1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS payout_amount \n";
$sql .= "       FROM \n";
$sql .= "           t_payout_h \n";
$sql .= "           INNER JOIN t_payout_d ON t_payout_h.pay_id = t_payout_d.pay_id \n";
$sql .= "       WHERE \n";
$sql .= "           t_payout_h.renew_flg = 'f' \n";
$sql .= "       AND \n";
$sql .= "           t_payout_h.buy_id IS NULL \n";
$sql .= "       AND \n";
$sql .= "           t_payout_h.pay_day >= '$monthly_update_time' \n";
if ($end_day != null){
$sql .= "       AND \n";
$sql .= "           t_payout_h.pay_day <= '$end_day' \n";
}
$sql .= "       GROUP BY \n";
$sql .= "           t_payout_h.shop_id \n";
$sql .= "   ) \n";
$sql .= "   AS t_payout_data \n";
$sql .= "   ON t_attach_staff.shop_id = t_payout_data.shop_id \n";
$sql .= ";";
$res  = Db_Query($db_con, $sql);
$num  = pg_num_rows($res);

// 1件以上あれば
if ($num > 0){

    // 金額合計算出のため、金額を加算していく
    while($data_list = pg_fetch_array($res)){
        $disp_staff_data[0]  += $data_list["sale_amount"];
        $disp_staff_data[1]  += $data_list["payin_amount"];
        $disp_staff_data[2]  += $data_list["buy_amount"];
        $disp_staff_data[3]  += $data_list["payout_amount"];
    }

// 0件の場合
}else{

    // 0件の場合でも表は出力するため、データを作成
    $disp_staff_data[0]  = 0;
    $disp_staff_data[1]  = 0;
    $disp_staff_data[2]  = 0;
    $disp_staff_data[3]  = 0;

}

/*-----------------------------------
    売上データ取得
-----------------------------------*/
/*** 売上明細データ取得 ***/
$sql  = "SELECT \n";
$sql .= "   COALESCE(t_sale_data.genkin_oroshi_count, 0)    AS sale_genkin_oroshi_count, \n";
$sql .= "   COALESCE(t_sale_data.genkin_oroshi_cost, 0)     AS sale_genkin_oroshi_cost, \n";
$sql .= "   COALESCE(t_sale_data.genkin_oroshi_sale, 0)     AS sale_genkin_oroshi_sale, \n";
$sql .= "   COALESCE(t_sale_data.genkin_hoken_count, 0)     AS sale_genkin_hoken_count, \n";
$sql .= "   COALESCE(t_sale_data.genkin_hoken_cost, 0)      AS sale_genkin_hoken_cost, \n";
$sql .= "   COALESCE(t_sale_data.genkin_hoken_sale, 0)      AS sale_genkin_hoken_sale, \n";
$sql .= "   COALESCE(t_sale_data_tax.genkin_tax_sale, 0)    AS sale_genkin_tax_sale, \n";
$sql .= "   COALESCE(t_sale_data.genkin_gai_count, 0)       AS sale_genkin_gai_count, \n";
$sql .= "   COALESCE(t_sale_data.genkin_gai_cost, 0)        AS sale_genkin_gai_cost, \n";
$sql .= "   COALESCE(t_sale_data.genkin_gai_sale, 0)        AS sale_genkin_gai_sale, \n";
$sql .= "   COALESCE(t_sale_data.kake_oroshi_count, 0)      AS sale_kake_oroshi_count, \n";
$sql .= "   COALESCE(t_sale_data.kake_oroshi_cost, 0)       AS sale_kake_oroshi_cost, \n";
$sql .= "   COALESCE(t_sale_data.kake_oroshi_sale, 0)       AS sale_kake_oroshi_sale, \n";
$sql .= "   COALESCE(t_sale_data.kake_hoken_count, 0)       AS sale_kake_hoken_count, \n";
$sql .= "   COALESCE(t_sale_data.kake_hoken_cost, 0)        AS sale_kake_hoken_cost, \n";
$sql .= "   COALESCE(t_sale_data.kake_hoken_sale, 0)        AS sale_kake_hoken_sale, \n";
$sql .= "   COALESCE(t_sale_data_tax.kake_tax_sale, 0)      AS sale_kake_tax_sale, \n";
$sql .= "   COALESCE(t_sale_data.kake_gai_count, 0)         AS sale_kake_gai_count, \n";
$sql .= "   COALESCE(t_sale_data.kake_gai_cost, 0)          AS sale_kake_gai_cost, \n";
$sql .= "   COALESCE(t_sale_data.kake_gai_sale, 0)          AS sale_kake_gai_sale \n";
$sql .= "FROM \n";
// ■ショップ
$sql .= "   ( \n";
$sql .= "       SELECT \n";
$sql .= "           shop_id \n";
$sql .= "       FROM \n";
$sql .= "           ( \n";
$sql .= "               SELECT \n";
$sql .= "                   shop_id \n";
$sql .= "               FROM \n";
$sql .= "                   t_sale_h \n";
$sql .= "           ) \n";
$sql .= "           AS t_shop \n";
$sql .= "       WHERE \n";
$sql .= "           shop_id = $shop_id \n";
$sql .= "       GROUP BY \n";
$sql .= "           shop_id \n";
$sql .= "   ) \n";
$sql .= "   AS t_attach_staff \n";
// ■売上ヘッダ(join 売上データ join 商品マスタ)
$sql .= "   LEFT JOIN \n";
$sql .= "   (\n";
$sql .= "       SELECT \n";
$sql .= "           t_sale_h.shop_id, \n";
                    // 現金売上 - 卸（保険以外） - 件数
$sql .= "           COUNT( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (61, 63, 64) AND \n";
$sql .= "                           (t_sale_d.sale_div_cd != '08' OR t_sale_d.sale_div_cd IS NULL) \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       t_sale_d.sale_d_id \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS genkin_oroshi_count, \n";
                    // 現金売上 - 卸（保険以外） - 原価
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (61) AND \n";
$sql .= "                           (t_sale_d.sale_div_cd != '08' OR t_sale_d.sale_div_cd IS NULL) \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.cost_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (63, 64) AND \n";
$sql .= "                           (t_sale_d.sale_div_cd != '08' OR t_sale_d.sale_div_cd IS NULL) \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.cost_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS genkin_oroshi_cost, \n";
                    // 現金売上 - 卸（保険以外） - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (61) AND \n";
$sql .= "                           (t_sale_d.sale_div_cd != '08' OR t_sale_d.sale_div_cd IS NULL) \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (63, 64) AND \n";
$sql .= "                           (t_sale_d.sale_div_cd != '08' OR t_sale_d.sale_div_cd IS NULL) \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS genkin_oroshi_sale, \n";
                    // 現金売上 - 保険 - 件数
$sql .= "           COUNT( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (61, 63, 64) AND \n";
$sql .= "                           t_sale_d.sale_div_cd = '08' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       t_sale_d.sale_d_id \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS genkin_hoken_count, \n";
                    // 現金売上 - 保険 - 原価
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (61) AND \n";
$sql .= "                           t_sale_d.sale_div_cd = '08' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.cost_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (63, 64) AND \n";
$sql .= "                           t_sale_d.sale_div_cd = '08' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.cost_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS genkin_hoken_cost, \n";
                    // 現金売上 - 保険 - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (61) AND \n";
$sql .= "                           t_sale_d.sale_div_cd = '08' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (63, 64) AND \n";
$sql .= "                           t_sale_d.sale_div_cd = '08' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS genkin_hoken_sale, \n";
                    // 掛売上 - 卸（保険以外） - 件数
$sql .= "           COUNT( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (11, 13, 14, 15) AND \n";
$sql .= "                           (t_sale_d.sale_div_cd != '08' OR t_sale_d.sale_div_cd IS NULL) \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       t_sale_d.sale_d_id \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS kake_oroshi_count, \n";
                    // 掛売上 - 卸（保険以外） - 原価
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (11, 15) AND \n";
$sql .= "                           (t_sale_d.sale_div_cd != '08' OR t_sale_d.sale_div_cd IS NULL) \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.cost_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (13, 14) AND \n";
$sql .= "                           (t_sale_d.sale_div_cd != '08' OR t_sale_d.sale_div_cd IS NULL) \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.cost_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS kake_oroshi_cost, \n";
                    // 掛売上 - 卸（保険以外） - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (11, 15) AND \n";
$sql .= "                           (t_sale_d.sale_div_cd != '08' OR t_sale_d.sale_div_cd IS NULL) \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (13, 14) AND \n";
$sql .= "                           (t_sale_d.sale_div_cd != '08' OR t_sale_d.sale_div_cd IS NULL) \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS kake_oroshi_sale, \n";
                    // 掛売上 - 保険 - 件数
$sql .= "           COUNT( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (11, 13, 14, 15) AND \n";
$sql .= "                           t_sale_d.sale_div_cd = '08' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       t_sale_d.sale_d_id \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS kake_hoken_count, \n";
                    // 掛売上 - 保険 - 原価
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (11) AND \n";
$sql .= "                           t_sale_d.sale_div_cd = '08' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.cost_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (13, 14) AND \n";
$sql .= "                           t_sale_d.sale_div_cd = '08' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.cost_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS kake_hoken_cost, \n";
                    // 掛売上 - 保険 - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (11, 15) AND \n";
$sql .= "                           t_sale_d.sale_div_cd = '08' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (13, 14) AND \n";
$sql .= "                           t_sale_d.sale_div_cd = '08' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS kake_hoken_sale, \n";
                    // 現金売上 - 販売管理外 - 件数
$sql .= "           COUNT( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (61, 63, 64) AND \n";
$sql .= "                           t_goods.sale_manage = '2' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       t_sale_d.sale_d_id \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS genkin_gai_count, \n";
                    // 現金売上 - 販売管理外 - 原価
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (61) AND \n";
$sql .= "                           t_goods.sale_manage = '2' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.cost_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (63, 64) AND \n";
$sql .= "                           t_goods.sale_manage = '2' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.cost_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS genkin_gai_cost, \n";
                    // 現金売上 - 販売管理外 - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (61) AND \n";
$sql .= "                           t_goods.sale_manage = '2' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (63, 64) AND \n";
$sql .= "                           t_goods.sale_manage = '2' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS genkin_gai_sale, \n";
                    // 掛売上 - 販売管理外 - 件数
$sql .= "           COUNT( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (11, 13, 14, 15) AND \n";
$sql .= "                           t_goods.sale_manage = '2' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       t_sale_d.sale_d_id \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS kake_gai_count, \n";
                    // 掛売上 - 販売管理外 - 原価
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (11, 15) AND \n";
$sql .= "                           t_goods.sale_manage = '2' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.cost_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (13, 14) AND \n";
$sql .= "                           t_goods.sale_manage = '2' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.cost_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS kake_gai_cost, \n";
                    // 掛売上 - 販売管理外 - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (11, 15) AND \n";
$sql .= "                           t_goods.sale_manage = '2' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (63, 64) AND \n";
$sql .= "                           t_goods.sale_manage = '2' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS kake_gai_sale \n";
$sql .= "       FROM \n";
$sql .= "           t_sale_h \n";
$sql .= "           INNER JOIN t_sale_d ON t_sale_h.sale_id = t_sale_d.sale_id \n";
$sql .= "           LEFT JOIN t_goods ON t_sale_d.goods_id = t_goods.goods_id \n";
$sql .= "       WHERE \n";
$sql .= "           t_sale_h.renew_flg = 'f' \n";
$sql .= "       AND \n";
$sql .= "           t_sale_h.sale_day >= '$monthly_update_time' \n";
if ($end_day != null){
$sql .= "       AND \n";
$sql .= "           t_sale_h.sale_day <= '$end_day' \n";
}
$sql .= "       GROUP BY \n";
$sql .= "           t_sale_h.shop_id \n";
$sql .= "   ) \n";
$sql .= "   AS t_sale_data \n";
$sql .= "   ON t_attach_staff.shop_id = t_sale_data.shop_id \n";
// ■売上ヘッダ（join 取引先マスタ）
$sql .= "   LEFT JOIN \n";
$sql .= "   (\n";
$sql .= "       SELECT \n";
$sql .= "           t_sale_h.shop_id, \n";
                    // 現金売上 - 伝票消費税 - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (61) AND \n";
$sql .= "                           t_client.c_tax_div = '1' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_h.tax_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (63, 64) AND \n";
$sql .= "                           t_client.c_tax_div = '1' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_h.tax_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS genkin_tax_sale, \n";
                    // 掛売上 - 伝票消費税 - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (11, 15) AND \n";
$sql .= "                           t_client.c_tax_div = '1' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_h.tax_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (13, 14) AND \n";
$sql .= "                           t_client.c_tax_div = '1' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_h.tax_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS kake_tax_sale \n";
$sql .= "       FROM \n";
$sql .= "           t_sale_h \n";
$sql .= "           LEFT JOIN t_client ON t_sale_h.client_id = t_client.client_id \n";
$sql .= "       WHERE \n";
$sql .= "           t_sale_h.renew_flg = 'f' \n";
$sql .= "       AND \n";
$sql .= "           t_sale_h.sale_day >= '$monthly_update_time' \n";
if ($end_day != null){
$sql .= "       AND \n";
$sql .= "           t_sale_h.sale_day <= '$end_day' \n";
}
$sql .= "       GROUP BY \n";
$sql .= "           t_sale_h.shop_id \n";
$sql .= "   ) \n";
$sql .= "   AS t_sale_data_tax \n";
$sql .= "   ON t_attach_staff.shop_id = t_sale_data_tax.shop_id \n";
$sql .= ";";
$res  = Db_Query($db_con, $sql);
$num  = pg_num_rows($res);
if ($num > 0){
    $ary_sale_daily_data = pg_fetch_array($res, 0);
}else{
    $ary_sale_daily_data = array(null);
}

/*** 売上月次累計データ取得 ***/
$sql  = "SELECT \n";
$sql .= "   COALESCE(t_sale_data.genkin_oroshi_sale, 0)     AS sale_genkin_oroshi_sale, \n";
$sql .= "   COALESCE(t_sale_data.genkin_hoken_sale, 0)      AS sale_genkin_hoken_sale, \n";
$sql .= "   COALESCE(t_sale_data_tax.genkin_tax_sale, 0)    AS sale_genkin_tax_sale, \n";
$sql .= "   COALESCE(t_sale_data.genkin_gai_sale, 0)        AS sale_genkin_gai_sale, \n";
$sql .= "   COALESCE(t_sale_data.kake_oroshi_sale, 0)       AS sale_kake_oroshi_sale, \n";
$sql .= "   COALESCE(t_sale_data.kake_hoken_sale, 0)        AS sale_kake_hoken_sale, \n";
$sql .= "   COALESCE(t_sale_data_tax.kake_tax_sale, 0)      AS sale_kake_tax_sale, \n";
$sql .= "   COALESCE(t_sale_data.kake_gai_sale, 0)          AS sale_kake_gai_sale \n";
$sql .= "FROM \n";
// ■ショップ
$sql .= "   ( \n";
$sql .= "       SELECT \n";
$sql .= "           shop_id \n";
$sql .= "       FROM \n";
$sql .= "           ( \n";
$sql .= "               SELECT \n";
$sql .= "                   shop_id \n";
$sql .= "               FROM \n";
$sql .= "                   t_sale_h \n";
$sql .= "           ) \n";
$sql .= "           AS t_shop \n";
$sql .= "       WHERE \n";
$sql .= "           shop_id = $shop_id \n";
$sql .= "       GROUP BY \n";
$sql .= "           shop_id \n";
$sql .= "   ) \n";
$sql .= "   AS t_attach_staff \n";
// ■売上ヘッダ(join 売上データ join 商品マスタ)
$sql .= "   LEFT JOIN \n";
$sql .= "   (\n";
$sql .= "       SELECT \n";
$sql .= "           t_sale_h.shop_id, \n";
                    // 現金売上 - 卸（保険以外） - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (61) AND \n";
$sql .= "                           (t_sale_d.sale_div_cd != '08' OR t_sale_d.sale_div_cd IS NULL) \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (63, 64) AND \n";
$sql .= "                           (t_sale_d.sale_div_cd != '08' OR t_sale_d.sale_div_cd IS NULL) \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS genkin_oroshi_sale, \n";
                    // 現金売上 - 保険 - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (61) AND \n";
$sql .= "                           t_sale_d.sale_div_cd = '08' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (63, 64) AND \n";
$sql .= "                           t_sale_d.sale_div_cd = '08' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS genkin_hoken_sale, \n";
                    // 掛売上 - 卸（保険以外） - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (11, 15) AND \n";
$sql .= "                           (t_sale_d.sale_div_cd != '08' OR t_sale_d.sale_div_cd IS NULL) \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (13, 14) AND \n";
$sql .= "                           (t_sale_d.sale_div_cd != '08' OR t_sale_d.sale_div_cd IS NULL) \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS kake_oroshi_sale, \n";
                    // 掛売上 - 保険 - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (11, 15) AND \n";
$sql .= "                           t_sale_d.sale_div_cd = '08' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (13, 14) AND \n";
$sql .= "                           t_sale_d.sale_div_cd = '08' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS kake_hoken_sale, \n";
                    // 現金売上 - 販売管理外 - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (61) AND \n";
$sql .= "                           t_goods.sale_manage = '2' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (63, 64) AND \n";
$sql .= "                           t_goods.sale_manage = '2' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS genkin_gai_sale, \n";
                    // 掛売上 - 販売管理外 - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (61) AND \n";
$sql .= "                           t_goods.sale_manage = '2' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (63, 64) AND \n";
$sql .= "                           t_goods.sale_manage = '2' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_d.sale_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS kake_gai_sale \n";
$sql .= "       FROM \n";
$sql .= "           t_sale_h \n";
$sql .= "           INNER JOIN t_sale_d ON t_sale_h.sale_id = t_sale_d.sale_id \n";
$sql .= "           LEFT JOIN t_goods ON t_sale_d.goods_id = t_goods.goods_id \n";
$sql .= "       WHERE \n";
$sql .= "           t_sale_h.sale_id IS NOT NULL \n"; // WHEREの対応がめんどくさいので
//$sql .= "       AND \n";
//$sql .= "           t_sale_h.renew_flg = 't' \n";
$sql .= "       AND \n";
$sql .= "           t_sale_h.sale_day >= '$monthly_update_time' \n";
if ($end_day != null){
$sql .= "       AND \n";
$sql .= "           t_sale_h.sale_day <= '$end_day' \n";
}
$sql .= "       GROUP BY \n";
$sql .= "           t_sale_h.shop_id \n";
$sql .= "   ) \n";
$sql .= "   AS t_sale_data \n";
$sql .= "   ON t_attach_staff.shop_id = t_sale_data.shop_id \n";
// ■売上ヘッダ（join 取引先マスタ）
$sql .= "   LEFT JOIN \n";
$sql .= "   (\n";
$sql .= "       SELECT \n";
$sql .= "           t_sale_h.shop_id, \n";
                    // 現金売上 - 伝票消費税 - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (61) AND \n";
$sql .= "                           t_client.c_tax_div = '1' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_h.tax_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (63, 64) AND \n";
$sql .= "                           t_client.c_tax_div = '1' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_h.tax_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS genkin_tax_sale, \n";
                    // 掛売上 - 伝票消費税 - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (11, 15) AND \n";
$sql .= "                           t_client.c_tax_div = '1' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_h.tax_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_sale_h.trade_id IN (13, 14) AND \n";
$sql .= "                           t_client.c_tax_div = '1' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_sale_h.tax_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS kake_tax_sale \n";
$sql .= "       FROM \n";
$sql .= "           t_sale_h \n";
$sql .= "           LEFT JOIN t_client ON t_sale_h.client_id = t_client.client_id \n";
$sql .= "       WHERE \n";
$sql .= "           t_sale_h.sale_id IS NOT NULL \n"; // WHEREの対応がめんどくさいので
//$sql .= "       AND \n";
//$sql .= "           t_sale_h.renew_flg = 't' \n";
$sql .= "       AND \n";
$sql .= "           t_sale_h.sale_day >= '$monthly_update_time' \n";
if ($end_day != null){
$sql .= "       AND \n";
$sql .= "           t_sale_h.sale_day <= '$end_day' \n";
}
$sql .= "       GROUP BY \n";
$sql .= "           t_sale_h.shop_id \n";
$sql .= "   ) \n";
$sql .= "   AS t_sale_data_tax \n";
$sql .= "   ON t_attach_staff.shop_id = t_sale_data_tax.shop_id \n";
$sql .= ";";

$res  = Db_Query($db_con, $sql);
$num  = pg_num_rows($res);
if ($num > 0){
    $ary_sale_monthly_data = pg_fetch_array($res, 0);
}else{
    $ary_sale_monthly_data = array(null);
}

/* それぞれの合計を算出 */
// 現金売上 - 件数
$ary_sale_total_data["sale_genkin_count"]   = $ary_sale_daily_data["sale_genkin_oroshi_count"]
                                            + $ary_sale_daily_data["sale_genkin_hoken_count"]
                                            ;
// 現金売上 - 原価
$ary_sale_total_data["sale_genkin_cost"]    = $ary_sale_daily_data["sale_genkin_oroshi_cost"]
                                            + $ary_sale_daily_data["sale_genkin_hoken_cost"]
                                            ;
// 現金売上 - 金額
$ary_sale_total_data["sale_genkin_sale"]    = $ary_sale_daily_data["sale_genkin_oroshi_sale"]
                                            + $ary_sale_daily_data["sale_genkin_hoken_sale"]
                                            + $ary_sale_daily_data["sale_genkin_tax_sale"]
                                            ;
// 現金売上 - 月次累計
$ary_sale_total_data["sale_genkin_monthly"] = $ary_sale_monthly_data["sale_genkin_oroshi_sale"]
                                            + $ary_sale_monthly_data["sale_genkin_hoken_sale"]
                                            + $ary_sale_monthly_data["sale_genkin_tax_sale"]
                                            ;
// 掛売上 - 件数
$ary_sale_total_data["sale_kake_count"]     = $ary_sale_daily_data["sale_kake_oroshi_count"]
                                            + $ary_sale_daily_data["sale_kake_hoken_count"]
                                            ;
// 掛売上 - 原価
$ary_sale_total_data["sale_kake_cost"]      = $ary_sale_daily_data["sale_kake_oroshi_cost"]
                                            + $ary_sale_daily_data["sale_kake_hoken_cost"]
                                            ;
// 掛売上 - 金額
$ary_sale_total_data["sale_kake_sale"]      = $ary_sale_daily_data["sale_kake_oroshi_sale"]
                                            + $ary_sale_daily_data["sale_kake_hoken_sale"]
                                            + $ary_sale_daily_data["sale_kake_tax_sale"]
                                            ;
// 掛売上 - 月次累計
$ary_sale_total_data["sale_kake_monthly"]   = $ary_sale_monthly_data["sale_kake_oroshi_sale"]
                                            + $ary_sale_monthly_data["sale_kake_hoken_sale"]
                                            + $ary_sale_monthly_data["sale_kake_tax_sale"]
                                            ;


/*-----------------------------------
    仕入データ取得
-----------------------------------*/
/*** 仕入明細データ取得 ***/
$sql  = "SELECT \n";
$sql .= "   COALESCE(t_buy_data.genkin_all_count, 0)        AS buy_genkin_all_count, \n";
$sql .= "   COALESCE(t_buy_data.genkin_all_amount, 0)       AS buy_genkin_all_amount, \n";
$sql .= "   COALESCE(t_buy_data_tax.genkin_tax_amount, 0)   AS buy_genkin_tax_amount, \n";
$sql .= "   COALESCE(t_buy_data.kake_all_count, 0)          AS buy_kake_all_count, \n";
$sql .= "   COALESCE(t_buy_data.kake_all_amount, 0)         AS buy_kake_all_amount, \n";
$sql .= "   COALESCE(t_buy_data_tax.kake_tax_amount, 0)     AS buy_kake_tax_amount \n";
$sql .= "FROM \n";
// ■ショップ
$sql .= "   ( \n";
$sql .= "       SELECT \n";
$sql .= "           shop_id \n";
$sql .= "       FROM \n";
$sql .= "           ( \n";
$sql .= "               SELECT \n";
$sql .= "                   shop_id \n";
$sql .= "               FROM \n";
$sql .= "                   t_buy_h \n";
$sql .= "           ) \n";
$sql .= "           AS t_shop \n";
$sql .= "       WHERE \n";
$sql .= "           shop_id = $shop_id \n";
$sql .= "       GROUP BY \n";
$sql .= "           shop_id \n";
$sql .= "   ) \n";
$sql .= "   AS t_attach_staff \n";
// ■仕入ヘッダ(join 仕入データ)
$sql .= "   LEFT JOIN \n";
$sql .= "   (\n";
$sql .= "       SELECT \n";
$sql .= "           t_buy_h.shop_id, \n";
                    // 現金仕入 - 商品（全て） - 件数
$sql .= "           COUNT( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       t_buy_h.trade_id IN (71, 73, 74) \n";
$sql .= "                   THEN \n";
$sql .= "                       t_buy_d.buy_d_id \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS genkin_all_count, \n";
                    // 現金仕入 - 商品（全て） - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       t_buy_h.trade_id IN (71) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_buy_d.buy_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       t_buy_h.trade_id IN (73, 74) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_buy_d.buy_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS genkin_all_amount, \n";
                    // 掛仕入 - 商品（全て） - 件数
$sql .= "           COUNT( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       t_buy_h.trade_id IN (21, 23, 24, 25) \n";
$sql .= "                   THEN \n";
$sql .= "                       t_buy_d.buy_d_id \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS kake_all_count, \n";
                    // 現金仕入 - 商品（全て） - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       t_buy_h.trade_id IN (21, 25) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_buy_d.buy_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       t_buy_h.trade_id IN (23, 24) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_buy_d.buy_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS kake_all_amount \n";
$sql .= "       FROM \n";
$sql .= "           t_buy_h \n";
$sql .= "           INNER JOIN t_buy_d ON t_buy_h.buy_id = t_buy_d.buy_id \n";
$sql .= "       WHERE \n";
$sql .= "           t_buy_h.renew_flg = 'f' \n";
$sql .= "       AND \n";
$sql .= "           t_buy_h.buy_day >= '$monthly_update_time' \n";
if ($end_day != null){
$sql .= "       AND \n";
$sql .= "           t_buy_h.buy_day <= '$end_day' \n";
}
$sql .= "       GROUP BY \n";
$sql .= "           t_buy_h.shop_id \n";
$sql .= "   ) \n";
$sql .= "   AS t_buy_data \n";
$sql .= "   ON t_attach_staff.shop_id = t_buy_data.shop_id \n";
// ■仕入ヘッダ（join 取引先マスタ）
$sql .= "   LEFT JOIN \n";
$sql .= "   (\n";
$sql .= "       SELECT \n";
$sql .= "           t_buy_h.shop_id, \n";
                    // 現金仕入 - 伝票消費税 - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_buy_h.trade_id IN (71) AND \n";
$sql .= "                           t_client.c_tax_div = '1' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_buy_h.tax_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_buy_h.trade_id IN (73, 74) AND \n";
$sql .= "                           t_client.c_tax_div = '1' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_buy_h.tax_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS genkin_tax_amount, \n";
                    // 掛仕入 - 伝票消費税 - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_buy_h.trade_id IN (21, 25) AND \n";
$sql .= "                           t_client.c_tax_div = '1' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_buy_h.tax_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_buy_h.trade_id IN (23, 24) AND \n";
$sql .= "                           t_client.c_tax_div = '1' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_buy_h.tax_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS kake_tax_amount \n";
$sql .= "       FROM \n";
$sql .= "           t_buy_h \n";
$sql .= "           LEFT JOIN t_client ON t_buy_h.client_id = t_client.client_id \n";
$sql .= "       WHERE \n";
$sql .= "           t_buy_h.renew_flg = 'f' \n";
$sql .= "       AND \n";
$sql .= "           t_buy_h.buy_day >= '$monthly_update_time' \n";
if ($end_day != null){
$sql .= "       AND \n";
$sql .= "           t_buy_h.buy_day <= '$end_day' \n";
}
$sql .= "       GROUP BY \n";
$sql .= "           t_buy_h.shop_id \n";
$sql .= "   ) \n";
$sql .= "   AS t_buy_data_tax \n";
$sql .= "   ON t_attach_staff.shop_id = t_buy_data_tax.shop_id \n";
$sql .= ";";
$res  = Db_Query($db_con, $sql);
$num  = pg_num_rows($res);
if ($num > 0){
    $ary_buy_daily_data = pg_fetch_array($res, 0);
}else{
    $ary_buy_daily_data = array(null);
}

/*** 仕入月次累計データ取得 ***/
$sql  = "SELECT \n";
$sql .= "   COALESCE(t_buy_data.genkin_all_amount, 0)       AS buy_genkin_all_amount, \n";
$sql .= "   COALESCE(t_buy_data_tax.genkin_tax_amount, 0)   AS buy_genkin_tax_amount, \n";
$sql .= "   COALESCE(t_buy_data.kake_all_amount, 0)         AS buy_kake_all_amount, \n";
$sql .= "   COALESCE(t_buy_data_tax.kake_tax_amount, 0)     AS buy_kake_tax_amount \n";
$sql .= "FROM \n";
// ■ショップ
$sql .= "   ( \n";
$sql .= "       SELECT \n";
$sql .= "           shop_id \n";
$sql .= "       FROM \n";
$sql .= "           ( \n";
$sql .= "               SELECT \n";
$sql .= "                   shop_id \n";
$sql .= "               FROM \n";
$sql .= "                   t_buy_h \n";
$sql .= "           ) \n";
$sql .= "           AS t_shop \n";
$sql .= "       WHERE \n";
$sql .= "           shop_id = $shop_id \n";
$sql .= "       GROUP BY \n";
$sql .= "           shop_id \n";
$sql .= "   ) \n";
$sql .= "   AS t_attach_staff \n";
// ■仕入ヘッダ(join 仕入データ)
$sql .= "   LEFT JOIN \n";
$sql .= "   (\n";
$sql .= "       SELECT \n";
$sql .= "           t_buy_h.shop_id, \n";
                    // 現金仕入 - 商品（全て） - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       t_buy_h.trade_id IN (71) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_buy_d.buy_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       t_buy_h.trade_id IN (73, 74) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_buy_d.buy_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS genkin_all_amount, \n";
                    // 現金仕入 - 商品（全て） - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       t_buy_h.trade_id IN (21, 25) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_buy_d.buy_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       t_buy_h.trade_id IN (23, 24) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_buy_d.buy_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS kake_all_amount \n";
$sql .= "       FROM \n";
$sql .= "           t_buy_h \n";
$sql .= "           INNER JOIN t_buy_d ON t_buy_h.buy_id = t_buy_d.buy_id \n";
$sql .= "       WHERE \n";
//$sql .= "           t_buy_h.renew_flg = 't' \n";
//$sql .= "       AND \n";
$sql .= "           t_buy_h.buy_day >= '$monthly_update_time' \n";
if ($end_day != null){
$sql .= "       AND \n";
$sql .= "           t_buy_h.buy_day <= '$end_day' \n";
}
$sql .= "       GROUP BY \n";
$sql .= "           t_buy_h.shop_id \n";
$sql .= "   ) \n";
$sql .= "   AS t_buy_data \n";
$sql .= "   ON t_attach_staff.shop_id = t_buy_data.shop_id \n";
// ■仕入ヘッダ（join 取引先マスタ）
$sql .= "   LEFT JOIN \n";
$sql .= "   (\n";
$sql .= "       SELECT \n";
$sql .= "           t_buy_h.shop_id, \n";
                    // 現金仕入 - 伝票消費税 - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_buy_h.trade_id IN (71) AND \n";
$sql .= "                           t_client.c_tax_div = '1' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_buy_h.tax_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_buy_h.trade_id IN (73, 74) AND \n";
$sql .= "                           t_client.c_tax_div = '1' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_buy_h.tax_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS genkin_tax_amount, \n";
                    // 掛仕入 - 伝票消費税 - 金額
$sql .= "           SUM( \n";
$sql .= "               CASE \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_buy_h.trade_id IN (21, 25) AND \n";
$sql .= "                           t_client.c_tax_div = '1' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_buy_h.tax_amount, 0) * 1 \n";
$sql .= "                   WHEN \n";
$sql .= "                       ( \n";
$sql .= "                           t_buy_h.trade_id IN (23, 24) AND \n";
$sql .= "                           t_client.c_tax_div = '1' \n";
$sql .= "                       ) \n";
$sql .= "                   THEN \n";
$sql .= "                       COALESCE(t_buy_h.tax_amount, 0) * -1 \n";
$sql .= "                   ELSE 0 \n";
$sql .= "               END \n";
$sql .= "           ) \n";
$sql .= "           AS kake_tax_amount \n";
$sql .= "       FROM \n";
$sql .= "           t_buy_h \n";
$sql .= "           LEFT JOIN t_client ON t_buy_h.client_id = t_client.client_id \n";
$sql .= "       WHERE \n";
$sql .= "           t_buy_h.buy_id IS NOT NULL \n"; // WHEREの対応がめんどくさいので
//$sql .= "       AND \n";
//$sql .= "           t_buy_h.renew_flg = 't' \n";
$sql .= "       AND \n";
$sql .= "           t_buy_h.buy_day >= '$monthly_update_time' \n";
if ($end_day != null){
$sql .= "       AND \n";
$sql .= "           t_buy_h.buy_day <= '$end_day' \n";
}
$sql .= "       GROUP BY \n";
$sql .= "           t_buy_h.shop_id \n";
$sql .= "   ) \n";
$sql .= "   AS t_buy_data_tax \n";
$sql .= "   ON t_attach_staff.shop_id = t_buy_data_tax.shop_id \n";
$sql .= ";";
$res  = Db_Query($db_con, $sql);
$num  = pg_num_rows($res);
if ($num > 0){
    $ary_buy_monthly_data = pg_fetch_array($res, 0);
}else{
    $ary_buy_monthly_data = array(null);
}

/* それぞれの合計を算出 */
// 現金仕入 - 件数
$ary_buy_total_data["buy_genkin_count"] = $ary_buy_daily_data["buy_genkin_all_count"]
                                        ;
// 現金仕入 - 金額
$ary_buy_total_data["buy_genkin_amount"]= $ary_buy_daily_data["buy_genkin_all_amount"]
                                        + $ary_buy_daily_data["buy_genkin_tax_amount"]
                                        ;
// 現金仕入 - 月次累計
$ary_buy_total_data["buy_genkin_total"] = $ary_buy_monthly_data["buy_genkin_all_amount"]
                                        + $ary_buy_monthly_data["buy_genkin_tax_amount"]
                                        ;
// 掛仕入 - 件数
$ary_buy_total_data["buy_kake_count"]   = $ary_buy_daily_data["buy_kake_all_count"]
                                        ;
// 掛仕入 - 金額
$ary_buy_total_data["buy_kake_amount"]  = $ary_buy_daily_data["buy_kake_all_amount"]
                                        + $ary_buy_daily_data["buy_kake_tax_amount"]
                                        ;
// 掛仕入 - 月次累計
$ary_buy_total_data["buy_kake_total"]   = $ary_buy_monthly_data["buy_kake_all_amount"]
                                        + $ary_buy_monthly_data["buy_kake_tax_amount"]
                                        ;


/*----------------------------------
    入金データ取得
-----------------------------------*/
/* 銀行を出力する取引区分を設定 */
$payin_bank_trade_list = array("32", "33", "35");

/* 取引区分毎の銀行一覧取得（月次更新前の銀行一覧を取得） */
foreach ($payin_bank_trade_list as $key => $value){
    $sql  = "SELECT \n";
    $sql .= "   t_payin_d.trade_id, \n";
    $sql .= "   t_payin_d.bank_cd, \n";
    $sql .= "   t_payin_d.bank_name, \n";
    $sql .= "   t_payin_d.b_bank_cd, \n";
    $sql .= "   t_payin_d.b_bank_name, \n";
    $sql .= "   t_payin_d.account_no \n";
    $sql .= "FROM ";
    // ■ショップ
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               SELECT \n";
    $sql .= "                   shop_id \n";
    $sql .= "               FROM \n";
    $sql .= "                   t_payin_h \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_shop \n";
    $sql .= "       WHERE \n";
    $sql .= "           shop_id = $shop_id \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           shop_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_attach_staff \n";
    // ■入金ヘッダ - 月次更新前状態
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_payin_h.pay_id, \n";
    $sql .= "           t_payin_h.shop_id \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payin_h \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payin_h.sale_id IS NULL \n";
    $sql .= "       AND \n";
    $sql .= "           t_payin_h.pay_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "       AND \n";
    $sql .= "           t_payin_h.pay_day <= '$end_day' \n";
    }
    $sql .= "   ) \n";
    $sql .= "   AS t_payin_monthly \n";
    $sql .= "   ON t_attach_staff.shop_id = t_payin_monthly.shop_id \n";
    // 入金データ
    $sql .= "   INNER JOIN t_payin_d \n";
    $sql .= "   ON t_payin_monthly.pay_id = t_payin_d.pay_id \n";
    $sql .= "   AND trade_id = ".$value." \n";
    // 条件
    $sql .= "GROUP BY \n";
    $sql .= "   t_payin_d.trade_id, \n";
    $sql .= "   t_payin_d.bank_cd, t_payin_d.bank_name, \n";
    $sql .= "   t_payin_d.b_bank_cd, t_payin_d.b_bank_name, \n";
    $sql .= "   t_payin_d.account_no \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_payin_d.trade_id, \n";
    $sql .= "   t_payin_d.bank_cd, t_payin_d.bank_name, \n";
    $sql .= "   t_payin_d.b_bank_cd, t_payin_d.b_bank_name, \n";
    $sql .= "   t_payin_d.account_no \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    
    // 取得した銀行データを、取引区分毎で配列へ代入
    if ($num > 0){
        for ($j=0; $j<$num; $j++){
            $ary_payin_trade_bank_list[$value][$j] = pg_fetch_array($res, $j, PGSQL_NUM);
        }
    // 該当取引区分の銀行が1件もない場合でも空配列は作っておく
    }else{
        $ary_payin_trade_bank_list[$value] = null;
    }
}

/* 取得した銀行一覧を元にその銀行の明細を取得 */
foreach ($ary_payin_trade_bank_list as $key => $value){
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
            // ■ショップ
            $sql .= "   ( \n";
            $sql .= "       SELECT \n";
            $sql .= "           shop_id \n";
            $sql .= "       FROM \n";
            $sql .= "           ( \n";
            $sql .= "               SELECT \n";
            $sql .= "                   shop_id \n";
            $sql .= "               FROM \n";
            $sql .= "                   t_payin_h \n";
            $sql .= "           ) \n";
            $sql .= "           AS t_shop \n";
            $sql .= "       WHERE \n";
            $sql .= "           shop_id = $shop_id \n";
            $sql .= "       GROUP BY \n";
            $sql .= "           shop_id \n";
            $sql .= "   ) \n";
            $sql .= "   AS t_attach_staff \n";
            // ■入金ヘッダ(join 入金データ)
            $sql .= "   LEFT JOIN \n";
            $sql .= "   ( \n";
            $sql .= "       SELECT \n";
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
//            $sql .= "           SUM(COALESCE(t_payin_d.amount, 0)) AS monthly_pay_amount \n";
            $sql .= "           SUM( \n";
//            $sql .= "               CASE \n";
//            $sql .= "                   WHEN \n";
//            $sql .= "                       t_payin_h.renew_flg = 't' \n";
//            $sql .= "                   THEN \n";
            $sql .= "                       COALESCE(t_payin_d.amount, 0) \n";
//            $sql .= "                   ELSE 0 \n";
//            $sql .= "               END \n";
            $sql .= "           ) AS monthly_pay_amount \n";
            $sql .= "       FROM \n";
            $sql .= "           t_payin_h \n";
            $sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
            $sql .= "       WHERE \n";
            $sql .= "           t_payin_h.sale_id IS NULL \n";
            $sql .= "       AND \n";
            $sql .= "           t_payin_h.pay_day >= '$monthly_update_time' \n";
            if ($end_day != null){
            $sql .= "       AND \n";
            $sql .= "           t_payin_h.pay_day <= '$end_day' \n";
            }
            $sql .= "       AND \n";
            $sql .= "           t_payin_d.trade_id = ".$value[$j][0]." \n";             // 販売区分
            $sql .= "       AND \n";
            $sql .= "           t_payin_d.bank_cd = '".$value[$j][1]."' \n";            // 銀行コード
            $sql .= "       AND \n";
            $sql .= "           t_payin_d.bank_name = '".addslashes($value[$j][2])."' \n";          // 銀行名
            $sql .= "       AND \n";
            $sql .= "           t_payin_d.b_bank_cd = '".$value[$j][3]."' \n";          // 支店コード
            $sql .= "       AND \n";
            $sql .= "           t_payin_d.b_bank_name = '".addslashes($value[$j][4])."' \n";        // 支店名
            $sql .= "       AND \n";
            $sql .= "           t_payin_d.account_no = '".$value[$j][5]."' \n";         // 口座番号
            $sql .= "       GROUP BY \n";
            $sql .= "           t_payin_h.shop_id, \n";
            $sql .= "           t_payin_d.bank_cd, \n";
            $sql .= "           t_payin_d.bank_name, \n";
            $sql .= "           t_payin_d.b_bank_cd, \n";
            $sql .= "           t_payin_d.b_bank_name, \n";
            $sql .= "           t_payin_d.account_no \n";
            $sql .= "   ) \n";
            $sql .= "   AS t_payin_data \n";
            $sql .= "   ON t_attach_staff.shop_id = t_payin_data.shop_id \n";
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
            $ary_payin_bank_data[$value][$j]["bank_b_bank_name"]    = htmlspecialchars($ary_payin_bank_data[$value][$j]["bank_name"])."　".
                                                                      htmlspecialchars($ary_payin_bank_data[$value][$j]["b_bank_name"])."<br>".
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

foreach ($payin_nonbank_trade_list as $key => $value){
    $sql  = "SELECT \n";
    $sql .= "   t_payin_data.daily_pay_count, \n";
    $sql .= "   COALESCE(t_payin_data.daily_pay_amount, 0) AS daily_pay_amount, \n";
    $sql .= "   COALESCE(t_payin_data.monthly_pay_amount, 0) AS monthly_pay_amount \n";
    $sql .= "FROM \n";
    // ■ショップ
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               SELECT \n";
    $sql .= "                   shop_id \n";
    $sql .= "               FROM \n";
    $sql .= "                   t_payin_h \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_shop \n";
    $sql .= "       WHERE \n";
    $sql .= "           shop_id = $shop_id \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           shop_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_attach_staff \n";
    // ■入金ヘッダ(join 入金データ)
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_payin_h.shop_id, \n";
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
//    $sql .= "           SUM(COALESCE(t_payin_d.amount, 0)) AS monthly_pay_amount \n";
    $sql .= "           SUM( \n";
//    $sql .= "               CASE \n";
//    $sql .= "                   WHEN \n";
//    $sql .= "                       t_payin_h.renew_flg = 't' \n";
//    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payin_d.amount, 0) \n";
//    $sql .= "                   ELSE 0 \n";
//    $sql .= "               END \n";
    $sql .= "           ) AS monthly_pay_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payin_h \n";
    $sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payin_h.sale_id IS NULL \n";
    $sql .= "       AND \n";
    $sql .= "           trade_id = $value \n";
    $sql .= "       AND \n";
    $sql .= "           t_payin_h.pay_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "       AND \n";
    $sql .= "           t_payin_h.pay_day <= '$end_day' \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           t_payin_h.shop_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_payin_data \n";
    $sql .= "   ON t_attach_staff.shop_id = t_payin_data.shop_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $payin_total[$value] = pg_fetch_array($res, 0 ,PGSQL_ASSOC);
    }else{
        $payin_total[$value] = null;
    }

}


/*----------------------------------
    支払データ取得
-----------------------------------*/
/* 銀行を出力する取引区分を設定 */
$payout_bank_trade_list = array("43", "44", "48");

/* 取引区分毎の銀行一覧取得（月次更新前の銀行一覧を取得） */
foreach ($payout_bank_trade_list as $key => $value){
    $sql  = "SELECT \n";
    $sql .= "   t_payout_d.trade_id, \n";
    $sql .= "   t_payout_d.bank_cd, \n";
    $sql .= "   t_payout_d.bank_name, \n";
    $sql .= "   t_payout_d.b_bank_cd, \n";
    $sql .= "   t_payout_d.b_bank_name, \n";
    $sql .= "   t_payout_d.account_no \n";
    $sql .= "FROM ";
    // ■ショップ
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               SELECT \n";
    $sql .= "                   shop_id \n";
    $sql .= "               FROM \n";
    $sql .= "                   t_payout_h \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_shop \n";
    $sql .= "       WHERE \n";
    $sql .= "           shop_id = $shop_id \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           shop_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_attach_staff \n";
    // ■入金ヘッダ - 月次更新前状態
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_payout_h.pay_id, \n";
    $sql .= "           t_payout_h.shop_id \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payout_h \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payout_h.buy_id IS NULL \n";
    $sql .= "       AND \n";
    $sql .= "           t_payout_h.pay_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "       AND \n";
    $sql .= "           t_payout_h.pay_day <= '$end_day' \n";
    }
    $sql .= "   ) \n";
    $sql .= "   AS t_payout_monthly \n";
    $sql .= "   ON t_attach_staff.shop_id = t_payout_monthly.shop_id \n";
    // 支払データ
    $sql .= "   INNER JOIN t_payout_d \n";
    $sql .= "   ON t_payout_monthly.pay_id = t_payout_d.pay_id \n";
    $sql .= "   AND trade_id = ".$value." \n";
    // 条件
    $sql .= "GROUP BY \n";
    $sql .= "   t_payout_d.trade_id, \n";
    $sql .= "   t_payout_d.bank_cd, t_payout_d.bank_name, \n";
    $sql .= "   t_payout_d.b_bank_cd, t_payout_d.b_bank_name, \n";
    $sql .= "   t_payout_d.account_no \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_payout_d.trade_id, \n";
    $sql .= "   t_payout_d.bank_cd, t_payout_d.bank_name, \n";
    $sql .= "   t_payout_d.b_bank_cd, t_payout_d.b_bank_name, \n";
    $sql .= "   t_payout_d.account_no \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // 取得した銀行データを、取引区分毎で配列へ代入
    if ($num > 0){
        for ($j=0; $j<$num; $j++){
            $ary_payout_trade_bank_list[$value][$j] = pg_fetch_array($res, $j, PGSQL_NUM);
        }       
    // 該当取引区分の銀行が1件もない場合でも空配列は作っておく
    }else{  
        $ary_payout_trade_bank_list[$value] = null; 
    }

}

/* 取得した銀行一覧を元にその銀行の明細を取得 */
foreach ($ary_payout_trade_bank_list as $key => $value){
    // 該当取引区分に銀行データがある場合
    if ($value != null){
        for ($j=0; $j<count($value); $j++){
            $sql  = "SELECT \n";
            $sql .= "   t_payout_data.bank_cd, \n";
            $sql .= "   t_payout_data.bank_name, \n";
            $sql .= "   t_payout_data.b_bank_cd, \n";
            $sql .= "   t_payout_data.b_bank_name, \n";
            $sql .= "   t_payout_data.account_no, \n";
            $sql .= "   COALESCE(t_payout_data.daily_pay_count, 0) AS daily_pay_count, \n";
            $sql .= "   COALESCE(t_payout_data.daily_pay_amount, 0) AS daily_pay_amount, \n";
            $sql .= "   COALESCE(t_payout_data.monthly_pay_amount, 0) AS monthly_pay_amount \n";
            $sql .= "FROM \n";
            // ■ショップ
            $sql .= "   ( \n";
            $sql .= "       SELECT \n";
            $sql .= "           shop_id \n";
            $sql .= "       FROM \n";
            $sql .= "           ( \n";
            $sql .= "               SELECT \n";
            $sql .= "                   shop_id \n";
            $sql .= "               FROM \n";
            $sql .= "                   t_payout_h \n";
            $sql .= "           ) \n";
            $sql .= "           AS t_shop \n";
            $sql .= "       WHERE \n";
            $sql .= "           shop_id = $shop_id \n";
            $sql .= "       GROUP BY \n";
            $sql .= "           shop_id \n";
            $sql .= "   ) \n";
            $sql .= "   AS t_attach_staff \n";
            // ■支払ヘッダ(join 支払データ)
            $sql .= "   LEFT JOIN \n";
            $sql .= "   ( \n";
            $sql .= "       SELECT \n";
            $sql .= "           t_payout_h.shop_id, \n";
            $sql .= "           t_payout_d.bank_cd, \n";
            $sql .= "           t_payout_d.bank_name, \n";
            $sql .= "           t_payout_d.b_bank_cd, \n";
            $sql .= "           t_payout_d.b_bank_name, \n";
            $sql .= "           t_payout_d.account_no, \n";
            $sql .= "           COUNT( \n";
            $sql .= "               CASE \n";
            $sql .= "                   WHEN \n";
            $sql .= "                       t_payout_h.renew_flg = 'f' \n";
            $sql .= "                   THEN \n";
            $sql .= "                       t_payout_d.pay_d_id \n";
            $sql .= "               END \n";
            $sql .= "           ) AS daily_pay_count, \n";
            $sql .= "           SUM( \n";
            $sql .= "               CASE \n";
            $sql .= "                   WHEN \n";
            $sql .= "                       t_payout_h.renew_flg = 'f' \n";
            $sql .= "                   THEN \n";
            $sql .= "                       COALESCE(t_payout_d.pay_amount, 0) \n";
            $sql .= "                   ELSE 0 \n";
            $sql .= "               END \n";
            $sql .= "           ) AS daily_pay_amount, \n";
//            $sql .= "           SUM(COALESCE(t_payout_d.pay_amount, 0)) AS monthly_pay_amount \n";
            $sql .= "           SUM( \n";
//            $sql .= "               CASE \n";
//            $sql .= "                   WHEN \n";
//            $sql .= "                       t_payout_h.renew_flg = 't' \n";
//            $sql .= "                   THEN \n";
            $sql .= "                       COALESCE(t_payout_d.pay_amount, 0) \n";
//            $sql .= "                   ELSE 0 \n";
//            $sql .= "               END \n";
            $sql .= "           ) AS monthly_pay_amount \n";
            $sql .= "       FROM \n";
            $sql .= "           t_payout_h \n";
            $sql .= "           INNER JOIN t_payout_d ON t_payout_h.pay_id = t_payout_d.pay_id \n";
            $sql .= "       WHERE \n";
            $sql .= "           t_payout_h.buy_id IS NULL \n";
            $sql .= "       AND \n";
            $sql .= "           t_payout_h.pay_day >= '$monthly_update_time' \n";
            if ($end_day != null){
            $sql .= "       AND \n";
            $sql .= "           t_payout_h.pay_day <= '$end_day' \n";
            }
            $sql .= "       AND \n";
            $sql .= "           t_payout_d.trade_id = ".$value[$j][0]." \n";             // 販売区分
            $sql .= "       AND \n";
            $sql .= "           t_payout_d.bank_cd = '".$value[$j][1]."' \n";            // 銀行コード
            $sql .= "       AND \n";
            $sql .= "           t_payout_d.bank_name = '".addslashes($value[$j][2])."' \n";          // 銀行名
            $sql .= "       AND \n";
            $sql .= "           t_payout_d.b_bank_cd = '".$value[$j][3]."' \n";          // 支店コード
            $sql .= "       AND \n";
            $sql .= "           t_payout_d.b_bank_name = '".addslashes($value[$j][4])."' \n";        // 支店名
            $sql .= "       AND \n";
            $sql .= "           t_payout_d.account_no = '".$value[$j][5]."' \n";         // 口座番号
            $sql .= "       GROUP BY \n";
            $sql .= "           t_payout_h.shop_id, \n";
            $sql .= "           t_payout_d.bank_cd, \n";
            $sql .= "           t_payout_d.bank_name, \n";
            $sql .= "           t_payout_d.b_bank_cd, \n";
            $sql .= "           t_payout_d.b_bank_name, \n";
            $sql .= "           t_payout_d.account_no \n";
            $sql .= "   ) \n";
            $sql .= "   AS t_payout_data \n";
            $sql .= "   ON t_attach_staff.shop_id = t_payout_data.shop_id \n";
            $sql .= "   ORDER BY \n";
            $sql .= "       t_payout_data.bank_cd, \n";
            $sql .= "       t_payout_data.b_bank_cd, \n";
            $sql .= "       t_payout_data.account_no \n";
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $ary_payout_bank_data[$key][$j] = pg_fetch_array($res, 0, PGSQL_ASSOC);
            // データがある場合
            if ($ary_payout_bank_data[$key][$j][0] != null){
                while (list($key2, $value2) = each($ary_payout_bank_data[$key][$j])){
                    $ary_payout_bank_data[$key][$j][$key2] = $value2;
                }
            }
        }
    // 該当取引区分に銀行データが無い場合
    }else{
        $ary_payout_bank_data[$key] = null;
    }
}

/*  銀行出力する明細の、画面表示用一覧配列作成 */
// 取引区分毎ループ
foreach ($payout_bank_trade_list as $key => $value){

    // 該当取引君の取得データが無い場合
    if ($value != null){

        // 月次更新前データの銀行支店毎ループ
        for ($j=0; $j<count($ary_payout_bank_data[$value]); $j++){

            // 日次更新前データ、月次更新前データを配列に代入
            // 銀行コード-支店コード（月次累計データから取得）
            $ary_payout_bank_data[$value][$j]["bank_b_bank_cd"]      = $ary_payout_bank_data[$value][$j]["bank_cd"]."-".
                                                                       $ary_payout_bank_data[$value][$j]["b_bank_cd"];
            // 銀行名　支店名<br>口座番号（月次累計データから取得）
            $ary_payout_bank_data[$value][$j]["bank_b_bank_name"]    = htmlspecialchars($ary_payout_bank_data[$value][$j]["bank_name"])."　".
                                                                       htmlspecialchars($ary_payout_bank_data[$value][$j]["b_bank_name"])."<br>".
                                                                       $ary_payout_bank_data[$value][$j]["account_no"];
            // 件数（日次データ）
            $ary_payout_bank_data[$value][$j]["daily_pay_count"]     = ($ary_payout_bank_data[$value][$j] == null) ? "0"
                                                                     : $ary_payout_bank_data[$value][$j]["daily_pay_count"];
            // 金額（日次データ）
            $ary_payout_bank_data[$value][$j]["daily_pay_amount"]    = ($ary_payout_bank_data[$value][$j] == null) ? "0"
                                                                     : $ary_payout_bank_data[$value][$j]["daily_pay_amount"];
            // 金額（月次累計データ）
            $ary_payout_bank_data[$value][$j]["monthly_pay_amount"]  = $ary_payout_bank_data[$value][$j]["monthly_pay_amount"];

            // 合計算出のため、加算していく
            $payout_total[$value]["daily_pay_count"]     += $ary_payout_bank_data[$value][$j]["daily_pay_count"];
            $payout_total[$value]["daily_pay_amount"]    += $ary_payout_bank_data[$value][$j]["daily_pay_amount"];
            $payout_total[$value]["monthly_pay_amount"]  += $ary_payout_bank_data[$value][$j]["monthly_pay_amount"];

        }

    }

}

/*** 銀行毎出力しない取引区分の明細データ取得 ***/
/* 銀行を出力しない取引区分を設定 */
$payout_nonbank_trade_list = array("41", "45", "46", "47");

foreach ($payout_nonbank_trade_list as $key => $value){
    $sql  = "SELECT \n";
    $sql .= "   t_payout_data.daily_pay_count, \n";
    $sql .= "   COALESCE(t_payout_data.daily_pay_amount, 0) AS daily_pay_amount, \n";
    $sql .= "   COALESCE(t_payout_data.monthly_pay_amount, 0) AS monthly_pay_amount \n";
    $sql .= "FROM \n";
    // ■ショップ
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               SELECT \n";
    $sql .= "                   shop_id \n";
    $sql .= "               FROM \n";
    $sql .= "                   t_payout_h \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_shop \n";
    $sql .= "       WHERE \n";
    $sql .= "           shop_id = $shop_id \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           shop_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_attach_staff \n";
    // ■入金ヘッダ(join 入金データ)
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_payout_h.shop_id, \n";
    $sql .= "           COUNT( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payout_h.renew_flg = 'f' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       t_payout_d.pay_d_id \n";
    $sql .= "               END \n";
    $sql .= "           ) AS daily_pay_count, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payout_h.renew_flg = 'f' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payout_d.pay_amount, 0) \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS daily_pay_amount, \n";
//    $sql .= "           SUM(COALESCE(t_payout_d.pay_amount, 0)) AS monthly_pay_amount \n";
    $sql .= "           SUM( \n";
//    $sql .= "               CASE \n";
//    $sql .= "                   WHEN \n";
//    $sql .= "                       t_payout_h.renew_flg = 't' \n";
//    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payout_d.pay_amount, 0) \n";
//    $sql .= "                   ELSE 0 \n";
//    $sql .= "               END \n";
    $sql .= "           ) AS monthly_pay_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payout_h \n";
    $sql .= "           INNER JOIN t_payout_d ON t_payout_h.pay_id = t_payout_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payout_h.buy_id IS NULL \n";
    $sql .= "       AND \n";
    $sql .= "           trade_id = $value \n";
    $sql .= "       AND \n";
    $sql .= "           t_payout_h.pay_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "       AND \n";
    $sql .= "           t_payout_h.pay_day <= '$end_day' \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           t_payout_h.shop_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_payout_data \n";
    $sql .= "   ON t_attach_staff.shop_id = t_payout_data.shop_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $payout_total[$value] = pg_fetch_array($res, 0 ,PGSQL_ASSOC);
    }else{
        $payout_total[$value] = null;
    }

}


/****************************/
// HTML作成
/****************************/
// フォントカラー設定関数
function Font_Color($num){
    return ($num < 0) ? " style=\"color: #ff0000;\"" : null;
}

$html  = null;

/*** 売上 ***/
$row   = 0;
$ary_genkin_kake    = array("genkin" => "現金", "kake" => "掛");

$html .= "<tr class=\"Result3\" style=\"font-weight: bold;\">\n";
$html .= "  <td colspan=\"8\">【売上明細】</td> \n";
$html .= "</tr>\n";
foreach ($ary_genkin_kake as $key => $value){
$html .= "<tr class=\"Result1\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td>【".$value."売上】</td>\n";
$html .= "  <td>【卸】</td>\n";
$color = Font_Color($ary_sale_daily_data["sale_".$key."_oroshi_count"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data["sale_".$key."_oroshi_count"])."</td>\n";
$color = Font_Color($ary_sale_daily_data["sale_".$key."_oroshi_cost"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data["sale_".$key."_oroshi_cost"])."</td>\n";
$color = Font_Color($ary_sale_daily_data["sale_".$key."_oroshi_sale"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data["sale_".$key."_oroshi_sale"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($ary_sale_monthly_data["sale_".$key."_oroshi_sale"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_monthly_data["sale_".$key."_oroshi_sale"])."</td>\n";
$html .= "</tr>\n";
$html .= "<tr class=\"Result1\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td>【".$value."売上】</td>\n";
$html .= "  <td>【保険】</td>\n";
$color = Font_Color($ary_sale_daily_data["sale_".$key."_hoken_count"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data["sale_".$key."_hoken_count"])."</td>\n";
$color = Font_Color($ary_sale_daily_data["sale_".$key."_hoken_cost"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data["sale_".$key."_hoken_cost"])."</td>\n";
$color = Font_Color($ary_sale_daily_data["sale_".$key."_hoken_sale"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data["sale_".$key."_hoken_sale"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($ary_sale_monthly_data["sale_".$key."_hoken_sale"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_monthly_data["sale_".$key."_hoken_sale"])."</td>\n";
$html .= "</tr>\n";
$html .= "<tr class=\"Result1\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td>【".$value."売上】</td>\n";
$html .= "  <td>【伝票消費税】</td>\n";
$html .= "  <td align=\"center\">-</td>\n";
$html .= "  <td align=\"center\">-</td>\n";
$color = Font_Color($ary_sale_daily_data["sale_".$key."_tax_sale"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data["sale_".$key."_tax_sale"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($ary_sale_monthly_data["sale_".$key."_tax_sale"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_monthly_data["sale_".$key."_tax_sale"])."</td>\n";
$html .= "</tr>\n";
$html .= "<tr class=\"Result5\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td></td>\n";
$html .= "  <td>【販売管理外商品】</td>\n";
$color = Font_Color($ary_sale_daily_data["sale_".$key."_gai_count"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data["sale_".$key."_gai_count"])."</td>\n";
$color = Font_Color($ary_sale_daily_data["sale_".$key."_gai_cost"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data["sale_".$key."_gai_cost"])."</td>\n";
$color = Font_Color($ary_sale_daily_data["sale_".$key."_gai_sale"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data["sale_".$key."_gai_sale"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($ary_sale_monthly_data["sale_".$key."_gai_sale"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_monthly_data["sale_".$key."_gai_sale"])."</td>\n";
$html .= "</tr>\n";
$html .= "<tr class=\"Result2\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td></td>\n";
$html .= "  <td><b>【合計】</b></td>\n";
$color = Font_Color($ary_sale_total_data["sale_".$key."_count"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_total_data["sale_".$key."_count"])."</td>\n";
$color = Font_Color($ary_sale_total_data["sale_".$key."_cost"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_total_data["sale_".$key."_cost"])."</td>\n";
$color = Font_Color($ary_sale_total_data["sale_".$key."_sale"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_total_data["sale_".$key."_sale"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($ary_sale_total_data["sale_".$key."_monthly"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_total_data["sale_".$key."_monthly"])."</td>\n";
$html .= "</tr>\n";
    if ($key == "genkin"){
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

/*** 仕入 ***/
$row = 0;
$ary_genkin_kake    = array("genkin" => "現金", "kake" => "掛");

$html .= "<tr class=\"Result3\" style=\"font-weight: bold;\">\n";
$html .= "  <td colspan=\"8\">【仕入明細】</td>\n";
$html .= "</tr>\n";
foreach ($ary_genkin_kake as $key => $value){
$html .= "<tr class=\"Result1\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td>【".$value."仕入】</td>\n";
$html .= "  <td>【商品】</td>\n";
$color = Font_Color($ary_buy_daily_data["buy_".$key."_all_count"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_buy_daily_data["buy_".$key."_all_count"])."</td>\n";
$html .= "  <td align=\"center\">-</td>\n";
$color = Font_Color($ary_buy_daily_data["buy_".$key."_all_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_buy_daily_data["buy_".$key."_all_amount"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($ary_buy_monthly_data["buy_".$key."_all_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_buy_monthly_data["buy_".$key."_all_amount"])."</td>\n";
$html .= "</tr>\n";
$html .= "<tr class=\"Result1\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td>【".$value."仕入】</td>\n";
$html .= "  <td>【伝票消費税】</td>\n";
$html .= "  <td align=\"center\">-</td>\n";
$html .= "  <td align=\"center\">-</td>\n";
$color = Font_Color($ary_buy_daily_data["buy_".$key."_tax_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_buy_daily_data["buy_".$key."_tax_amount"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($ary_buy_monthly_data["buy_".$key."_tax_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_buy_monthly_data["buy_".$key."_tax_amount"])."</td>\n";
$html .= "</tr>\n";
$html .= "<tr class=\"Result2\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td></td>\n";
$html .= "  <td><b>【合計】</b></td>\n";
$color = Font_Color($ary_buy_total_data["buy_".$key."_count"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_buy_total_data["buy_".$key."_count"])."</td>\n";
$html .= "  <td align=\"center\">-</td>\n";
$color = Font_Color($ary_buy_total_data["buy_".$key."_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_buy_total_data["buy_".$key."_amount"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($ary_buy_total_data["buy_".$key."_total"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_buy_total_data["buy_".$key."_total"])."</td>\n";
$html .= "</tr>\n";
    if ($key == "genkin"){
$html .= "<tr class=\"Result1\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
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

/*** 支払 ***/
$row = 0;
$ary_payout_trade = array(
    // "取引区分コード" => array(銀行出力有無フラグ, "取引区分名")
    "41" => array(false, "現金支払"),
    "43" => array(true,  "振込支払"),
    "44" => array(false, "手形支払"),
    "45" => array(true,  "相殺"),
    "46" => array(false, "支払調整"),
    "47" => array(false, "その他支払"),
    "48" => array(false, "手数料"),
);

$html .= "<tr class=\"Result3\" style=\"font-weight: bold;\">\n";
$html .= "  <td colspan=\"8\">【支払明細】</td>\n";
$html .= "</tr>\n";
foreach ($ary_payout_trade as $key_trade1 => $value_trade1){
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
    if ($value[0] == true){
        foreach ($ary_payout_bank_data as $key_trade2 => $value_trade2){
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
$color = Font_Color($payout_total[$key_trade1]["daily_pay_count"]);
$html .= "  <td align=\"right\"".$color.">".number_format($payout_total[$key_trade1]["daily_pay_count"])."</td>\n";
$html .= "  <td align=\"center\">-</td>\n";
$color = Font_Color($payout_total[$key_trade1]["daily_pay_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($payout_total[$key_trade1]["daily_pay_amount"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($payout_total[$key_trade1]["monthly_pay_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($payout_total[$key_trade1]["monthly_pay_amount"])."</td>\n";
$html .= "</tr>\n";
}


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
    "update_time"       => "$monthly_update_time",
    "now"               => date("Y-m-d"),
    "end_date"          => "$end_day",
    "html"              => $html,
    "qf_err_flg"        => "$qf_err_flg",
));

// 合計
$smarty->assign("disp_staff_data", $disp_staff_data);

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
