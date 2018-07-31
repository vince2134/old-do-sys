<?php
$page_title = "バッチ表";

// 環境設定ファイル
require_once("ENV_local.php");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

// DB接続設定
$db_con = Db_Connect();


/****************************/
// 外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];

/****************************/
// フォーム初期値設定
/****************************/
$def_fdata = array(
    "form_output_radio"    => "1"
);

$form->setDefaults($def_fdata);


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
// 表示用データ取得
/****************************/
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
    $end_y = ($_POST["form_end_day"]["y"] != null) ? str_pad($_POST["form_end_day"]["y"], 4, 0, STR_POS_LEFT) : null;
    $end_m = ($_POST["form_end_day"]["m"] != null) ? str_pad($_POST["form_end_day"]["m"], 2, 0, STR_POS_LEFT) : null;
    $end_d = ($_POST["form_end_day"]["d"] != null) ? str_pad($_POST["form_end_day"]["d"], 2, 0, STR_POS_LEFT) : null;

    /****************************/
    // エラーチェック
    /****************************/
    // どれか1つでも入力がある場合
    if ($end_y != null || $end_m != null || $end_d != null){

        // ■集計期間終了日
        $err_msg = "集計期間の日付が妥当ではありません。";
        $form->addGroupRule("form_end_day", array(
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
            $form->setElementError("form_end_day", "集計期間の日付が妥当ではありません。");
            $ary_err_flg[] = true;
        }

/*
        // 日次更新より後の日付かチェック
        if (mb_substr($daily_update_time, 0, 10) > $end_y."-".$end_m."-".$end_d){
            $form->setElementError("form_end_day", "集計期間の日付が妥当ではありません。");
            $ary_err_flg[] = true;
        }
*/
        // 月次締日より後の日付かチェック
        if (mb_substr($monthly_update_time, 0, 10) > $end_y."-".$end_m."-".$end_d){
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

    // ループ処理用配列（巡回担当者識別）
    $ary_main_sub = array("main", "sub1", "sub2", "sub3");

    /* 一覧表示用金額取得SQL */
    // 売上・入金用
    // 日次累計
    $sql  = "SELECT \n";
    $sql .= "   t_attach_staff.staff_id, \n";
    $sql .= "   t_attach_staff.staff_name, \n";
    $sql .= "   COALESCE(t_sale_data.sale_genkin_amount, 0) AS sale_genkin_amount, \n";
    $sql .= "   COALESCE(t_sale_data.sale_kake_amount, 0) AS sale_kake_amount, \n";
    $sql .= "   SUM(COALESCE(t_payin_data.payin_genkin_amount, 0)) AS payin_genkin_amount \n";
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
    $sql .= "                               WHERE \n";
    $sql .= "                                   shop_id = $shop_id \n";
    $sql .= "                               AND \n";
    $sql .= "                                   renew_flg IN ('t', 'f') \n";
    $sql .= "                               AND \n";
    $sql .= "                                   contract_div = '1' \n";
    $sql .= "                               AND \n";
    $sql .= "                                   ".$value."_staff_id IS NOT NULL \n";
    $sql .= "                               AND \n";
    $sql .= "                                   sale_day >= '$monthly_update_time' \n";
        if ($end_day != null){
    $sql .= "                               AND \n";
    $sql .= "                                   sale_day <= '$end_day' \n";
        }
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
    $sql .= "                       ( \n";
    $sql .= "                           CASE \n";
    $sql .= "                               WHEN \n";
    $sql .= "                                   collect_staff_id IS NULL \n";
    $sql .= "                               THEN \n";
    $sql .= "                                   e_staff_id \n";
    $sql .= "                               ELSE \n";
    $sql .= "                                   collect_staff_id \n";
    $sql .= "                           END \n";
    $sql .= "                       ) \n";
    $sql .= "                       AS staff_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_payin_h \n";
    $sql .= "                   WHERE \n";
    $sql .= "                       shop_id = $shop_id \n";
    $sql .= "                   AND \n";
    $sql .= "                       renew_flg IN ('t', 'f') \n";
    $sql .= "                   AND \n";
    $sql .= "                       sale_id IS NULL \n";
    $sql .= "                   AND \n";
    $sql .= "                       pay_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "                   AND \n";
    $sql .= "                       pay_day <= '$end_day' \n";
    }
    $sql .= "               ) \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_shop_union \n";
    $sql .= "           LEFT JOIN t_staff ON t_shop_union.staff_id = t_staff.staff_id \n";
    if ($staff_id != null){
    $sql .= "       WHERE \n";
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
    // ■売上ヘッダ
    $sql .= "   LEFT JOIN \n";
    $sql .= "   (\n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id, \n";
    $sql .= "           COALESCE(staff_id, 0) AS staff_id, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (61) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(sale_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (63, 64) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(sale_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS sale_genkin_amount, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (11, 15) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(sale_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (13, 14) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(sale_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS sale_kake_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    foreach ($ary_main_sub as $key => $value){
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id, \n";
    $sql .= "                       trade_id, \n";
    $sql .= "                       ".$value."_staff_id AS staff_id, \n";
    $sql .= "                       COALESCE(".$value."_total_amount, 0) AS sale_amount \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_sale_h_amount \n";
    $sql .= "                   WHERE \n";
    $sql .= "                       shop_id = $shop_id \n";
    $sql .= "                   AND \n";
    $sql .= "                       renew_flg = 'f' \n";
    $sql .= "                   AND \n";
    $sql .= "                       contract_div = '1' \n";
    $sql .= "                   AND \n";
    $sql .= "                       ".$value."_staff_id IS NOT NULL \n";
    $sql .= "                   AND \n";
    $sql .= "                       sale_day >= '$monthly_update_time' \n";
        if ($end_day != null){
    $sql .= "                   AND \n";
    $sql .= "                       sale_day <= '$end_day' \n";
        }
    $sql .= "               ) \n";
        if ($key+1 < count($ary_main_sub)){
    $sql .= "               UNION ALL \n";
        }
    }
    $sql .= "           ) \n";
    $sql .= "           AS t_sale_union \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           shop_id, \n";
    $sql .= "           staff_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_sale_data \n";
    $sql .= "   ON t_attach_staff.shop_id = t_sale_data.shop_id \n";
    $sql .= "   AND t_attach_staff.staff_id = t_sale_data.staff_id \n";
    // ■入金ヘッダ(join 入金データ)
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           ( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payin_h.collect_staff_id IS NULL \n";
    $sql .= "                   THEN \n";
    $sql .= "                       t_payin_h.e_staff_id \n";
    $sql .= "                   ELSE \n";
    $sql .= "                       t_payin_h.collect_staff_id \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS collect_staff_id, \n";
    $sql .= "           t_payin_h.shop_id, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payin_d.trade_id IN (31) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payin_d.amount, 0) * 1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS payin_genkin_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payin_h \n";
    $sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payin_h.shop_id = $shop_id \n";
    $sql .= "       AND \n";
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
    $sql .= "           t_payin_h.shop_id, \n";
    $sql .= "           t_payin_h.collect_staff_id, \n";
    $sql .= "           t_payin_h.e_staff_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_payin_data \n";
    $sql .= "   ON t_attach_staff.shop_id = t_payin_data.shop_id \n";
    $sql .= "   AND t_attach_staff.staff_id = t_payin_data.collect_staff_id \n";
    // 条件
    $sql .= "GROUP BY \n";
    $sql .= "   t_attach_staff.staff_id, \n";
    $sql .= "   t_attach_staff.charge_cd, \n";
    $sql .= "   t_attach_staff.staff_name, \n";
    $sql .= "   t_sale_data.sale_genkin_amount, \n";
    $sql .= "   t_sale_data.sale_kake_amount \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_attach_staff.charge_cd \n";
    $sql .= ";";
    $res_daily_1 = Db_Query($db_con, $sql);
    $num_daily_1 = pg_num_rows($res_daily_1);

    // 仕入・支払用
    // 日次累計
    $sql  = "SELECT \n";
    $sql .= "   t_attach_staff.staff_id, \n";
    $sql .= "   t_attach_staff.staff_name, \n";
    $sql .= "   COALESCE(t_buy_data.buy_genkin_amount, 0) AS buy_genkin_amount, \n";
    $sql .= "   COALESCE(t_buy_data.buy_kake_amount, 0) AS buy_kake_amount, \n";
    $sql .= "   SUM(COALESCE(t_payout_data.payout_genkin_amount, 0)) AS payout_genkin_amount \n";
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
    $sql .= "                       c_staff_id AS staff_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_buy_h \n";
    $sql .= "                   WHERE \n";
    $sql .= "                       shop_id = $shop_id \n";
    $sql .= "                   AND \n";
    $sql .= "                       renew_flg IN ('t', 'f') \n";
    $sql .= "                   AND \n";
    $sql .= "                       act_sale_id IS NULL \n";
    $sql .= "                   AND \n";
    $sql .= "                       buy_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "                   AND \n";
    $sql .= "                       buy_day <= '$end_day' \n";
    }
    $sql .= "               ) \n";
    $sql .= "               UNION ALL \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id, \n";
    $sql .= "                       c_staff_id AS staff_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_payout_h \n";
    $sql .= "                   WHERE \n";
    $sql .= "                       shop_id = $shop_id \n";
    $sql .= "                   AND \n";
    $sql .= "                       renew_flg IN ('t', 'f') \n";
    $sql .= "                   AND \n";
    $sql .= "                       buy_id IS NULL \n";
    $sql .= "                   AND \n";
    $sql .= "                       pay_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "                   AND \n";
    $sql .= "                       pay_day <= '$end_day' \n";
    }
    $sql .= "               ) \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_shop_union \n";
    $sql .= "           LEFT JOIN t_staff ON t_shop_union.staff_id = t_staff.staff_id \n";
    if ($staff_id != null){
    $sql .= "       WHERE \n";
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
    // ■仕入ヘッダ
    $sql .= "   LEFT JOIN \n";
    $sql .= "   (\n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id, \n";
    $sql .= "           COALESCE(c_staff_id, 0) AS staff_id, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (71) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (73, 74) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS buy_genkin_amount, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (21, 25) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (23, 24) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS buy_kake_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_buy_h \n";
    $sql .= "       WHERE \n";
    $sql .= "           shop_id = $shop_id \n";
    $sql .= "       AND \n";
    $sql .= "           renew_flg = 'f' \n";
    $sql .= "       AND \n";
    $sql .= "           act_sale_id IS NULL \n";
    $sql .= "       AND \n";
    $sql .= "           buy_day >= '$monthly_update_time' \n";
        if ($end_day != null){
    $sql .= "       AND \n";
    $sql .= "           buy_day <= '$end_day' \n";
        }
    $sql .= "       GROUP BY \n";
    $sql .= "           shop_id, \n";
    $sql .= "           c_staff_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_buy_data \n";
    $sql .= "   ON t_attach_staff.shop_id = t_buy_data.shop_id \n";
    $sql .= "   AND t_attach_staff.staff_id = t_buy_data.staff_id \n";
    // ■支払ヘッダ(join 支払データ)
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_payout_h.shop_id, \n";
    $sql .= "           t_payout_h.c_staff_id AS staff_id, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payout_d.trade_id IN (41) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payout_d.pay_amount, 0) * 1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS payout_genkin_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payout_h \n";
    $sql .= "           INNER JOIN t_payout_d ON t_payout_h.pay_id = t_payout_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payout_h.shop_id = $shop_id \n";
    $sql .= "       AND \n";
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
    $sql .= "           t_payout_h.shop_id, \n";
    $sql .= "           t_payout_h.c_staff_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_payout_data \n";
    $sql .= "   ON t_attach_staff.shop_id = t_payout_data.shop_id \n";
    $sql .= "   AND t_attach_staff.staff_id = t_payout_data.staff_id \n";
    // 条件
    $sql .= "GROUP BY \n";
    $sql .= "   t_attach_staff.staff_id, \n";
    $sql .= "   t_attach_staff.charge_cd, \n";
    $sql .= "   t_attach_staff.staff_name, \n";
    $sql .= "   t_buy_data.buy_genkin_amount, \n";
    $sql .= "   t_buy_data.buy_kake_amount \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_attach_staff.charge_cd \n";
    $sql .= ";";
    $res_daily_2 = Db_Query($db_con, $sql);
    $num_daily_2 = pg_num_rows($res_daily_2);

    // 売上・入金用
    // 月次累計
    $sql  = "SELECT \n";
    $sql .= "   t_attach_staff.staff_id, \n";
    $sql .= "   t_attach_staff.staff_name, \n";
    $sql .= "   COALESCE(t_sale_data.sale_genkin_amount, 0) AS sale_genkin_amount, \n";
    $sql .= "   COALESCE(t_sale_data.sale_kake_amount, 0) AS sale_kake_amount, \n";
    $sql .= "   SUM(COALESCE(t_payin_data.payin_genkin_amount, 0)) AS payin_genkin_amount \n";
    $sql .= "FROM \n";
    // ■ショップ・担当者
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_shop_union.shop_id, \n";
    $sql .= "           COALESCE(t_shop_union.staff_id, 0) AS staff_id, \n";
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
    $sql .= "                               WHERE \n";
    $sql .= "                                   shop_id = $shop_id \n";
    $sql .= "                               AND \n";
    $sql .= "                                   renew_flg IN ('t', 'f') \n";
    $sql .= "                               AND \n";
    $sql .= "                                   contract_div = '1' \n";
    $sql .= "                               AND \n";
    $sql .= "                                   ".$value."_staff_id IS NOT NULL \n";
    $sql .= "                               AND \n";
    $sql .= "                                   sale_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "                               AND \n";
    $sql .= "                                   sale_day <= '$end_day' \n";
    }
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
    $sql .= "                       ( \n";
    $sql .= "                           CASE \n";
    $sql .= "                               WHEN \n";
    $sql .= "                                   collect_staff_id IS NULL \n";
    $sql .= "                               THEN \n";
    $sql .= "                                   e_staff_id \n";
    $sql .= "                               ELSE \n";
    $sql .= "                                   collect_staff_id \n";
    $sql .= "                           END \n";
    $sql .= "                       ) \n";
    $sql .= "                       AS staff_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_payin_h \n";
    $sql .= "                   WHERE \n";
    $sql .= "                       shop_id = $shop_id \n";
    $sql .= "                   AND \n";
    $sql .= "                       renew_flg IN ('t', 'f') \n";
    $sql .= "                   AND \n";
    $sql .= "                       sale_id IS NULL \n";
    $sql .= "                   AND \n";
    $sql .= "                       pay_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "                   AND \n";
    $sql .= "                       pay_day <= '$end_day' \n";
    }
    $sql .= "               ) \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_shop_union \n";
    $sql .= "           LEFT JOIN t_staff ON t_shop_union.staff_id = t_staff.staff_id \n";
    if ($staff_id != null){
    $sql .= "       WHERE \n";
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
    // ■売上ヘッダ
    $sql .= "   LEFT JOIN \n";
    $sql .= "   (\n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id, \n";
    $sql .= "           COALESCE(staff_id, 0) AS staff_id, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (61) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(sale_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (63, 64) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(sale_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS sale_genkin_amount, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (11, 15) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(sale_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (13, 14) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(sale_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS sale_kake_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    foreach ($ary_main_sub as $key => $value){
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id, \n";
    $sql .= "                       trade_id, \n";
    $sql .= "                       ".$value."_staff_id AS staff_id, \n";
    $sql .= "                       COALESCE(".$value."_total_amount, 0) AS sale_amount \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_sale_h_amount \n";
    $sql .= "                   WHERE \n";
    $sql .= "                       shop_id = $shop_id \n";
    $sql .= "                   AND \n";
    $sql .= "                       contract_div = '1' \n";
    $sql .= "                   AND \n";
    $sql .= "                       ".$value."_staff_id IS NOT NULL \n";
    $sql .= "                   AND \n";
    $sql .= "                       sale_day >= '$monthly_update_time' \n";
        if ($end_day != null){
    $sql .= "                   AND \n";
    $sql .= "                       sale_day <= '$end_day' \n";
        }
    $sql .= "               ) \n";
        if ($key+1 < count($ary_main_sub)){
    $sql .= "               UNION ALL \n";
        }
    }
    $sql .= "           ) \n";
    $sql .= "           AS t_sale_union \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           shop_id, \n";
    $sql .= "           staff_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_sale_data \n";
    $sql .= "   ON t_attach_staff.shop_id = t_sale_data.shop_id \n";
    $sql .= "   AND t_attach_staff.staff_id = t_sale_data.staff_id \n";
    // ■入金ヘッダ(join 入金データ)
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           ( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       collect_staff_id IS NULL \n";
    $sql .= "                   THEN \n";
    $sql .= "                       e_staff_id \n";
    $sql .= "                   ELSE \n";
    $sql .= "                       collect_staff_id \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS collect_staff_id, \n";
    $sql .= "           t_payin_h.shop_id, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payin_d.trade_id IN (31) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payin_d.amount, 0) * 1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS payin_genkin_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payin_h \n";
    $sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payin_h.shop_id = $shop_id \n";
    $sql .= "       AND \n";
    $sql .= "           t_payin_h.sale_id IS NULL \n";
    $sql .= "       AND \n";
    $sql .= "           t_payin_h.pay_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "       AND \n";
    $sql .= "           t_payin_h.pay_day <= '$end_day' \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           t_payin_h.shop_id, \n";
    $sql .= "           t_payin_h.collect_staff_id, \n";
    $sql .= "           t_payin_h.e_staff_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_payin_data \n";
    $sql .= "   ON t_attach_staff.shop_id = t_payin_data.shop_id \n";
    $sql .= "   AND t_attach_staff.staff_id = t_payin_data.collect_staff_id \n";
    // 条件
    $sql .= "GROUP BY \n";
    $sql .= "   t_attach_staff.staff_id, \n";
    $sql .= "   t_attach_staff.charge_cd, \n";
    $sql .= "   t_attach_staff.staff_name, \n";
    $sql .= "   t_sale_data.sale_genkin_amount, \n";
    $sql .= "   t_sale_data.sale_kake_amount \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_attach_staff.charge_cd \n";
    $sql .= ";";
    $res_monthly_1  = Db_Query($db_con, $sql);
    $num_monthly_1 = pg_num_rows($res_monthly_1);

    // 仕入・支払用
    // 月次累計
    $sql  = "SELECT \n";
    $sql .= "   t_attach_staff.staff_id, \n";
    $sql .= "   t_attach_staff.staff_name, \n";
    $sql .= "   COALESCE(t_buy_data.buy_genkin_amount, 0) AS buy_genkin_amount, \n";
    $sql .= "   COALESCE(t_buy_data.buy_kake_amount, 0) AS buy_kake_amount, \n";
    $sql .= "   SUM(COALESCE(t_payout_data.payout_genkin_amount, 0)) AS payout_genkin_amount \n";
    $sql .= "FROM \n";
    // ■ショップ・担当者
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_shop_union.shop_id, \n";
    $sql .= "           COALESCE(t_shop_union.staff_id, 0) AS staff_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_staff.staff_name \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id, \n";
    $sql .= "                       c_staff_id AS staff_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_buy_h \n";
    $sql .= "                   WHERE \n";
    $sql .= "                       shop_id = $shop_id \n";
    $sql .= "                   AND \n";
    $sql .= "                       renew_flg IN ('t', 'f') \n";
    $sql .= "                   AND \n";
    $sql .= "                       act_sale_id IS NULL \n";
    $sql .= "                   AND \n";
    $sql .= "                       buy_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "                   AND \n";
    $sql .= "                       buy_day <= '$end_day' \n";
    }
    $sql .= "               ) \n";
    $sql .= "               UNION ALL \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id, \n";
    $sql .= "                       c_staff_id AS staff_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_payout_h \n";
    $sql .= "                   WHERE \n";
    $sql .= "                       shop_id = $shop_id \n";
    $sql .= "                   AND \n";
    $sql .= "                       renew_flg IN ('t', 'f') \n";
    $sql .= "                   AND \n";
    $sql .= "                       buy_id IS NULL \n";
    $sql .= "                   AND \n";
    $sql .= "                       pay_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "                   AND \n";
    $sql .= "                       pay_day <= '$end_day' \n";
    }
    $sql .= "               ) \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_shop_union \n";
    $sql .= "           LEFT JOIN t_staff ON t_shop_union.staff_id = t_staff.staff_id \n";
    if ($staff_id != null){
    $sql .= "       WHERE \n";
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
    // ■仕入ヘッダ
    $sql .= "   LEFT JOIN \n";
    $sql .= "   (\n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id, \n";
    $sql .= "           COALESCE(c_staff_id, 0) AS staff_id, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (71) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (73, 74) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS buy_genkin_amount, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (21, 25) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (23, 24) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS buy_kake_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_buy_h \n";
    $sql .= "       WHERE \n";
    $sql .= "           shop_id = $shop_id \n";
    $sql .= "       AND \n";
    $sql .= "           act_sale_id IS NULL \n";
    $sql .= "       AND \n";
    $sql .= "           buy_day >= '$monthly_update_time' \n";
        if ($end_day != null){
    $sql .= "       AND \n";
    $sql .= "           buy_day <= '$end_day' \n";
        }
    $sql .= "       GROUP BY \n";
    $sql .= "           shop_id, \n";
    $sql .= "           c_staff_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_buy_data \n";
    $sql .= "   ON t_attach_staff.shop_id = t_buy_data.shop_id \n";
    $sql .= "   AND t_attach_staff.staff_id = t_buy_data.staff_id \n";
    // ■支払ヘッダ(join 支払データ)
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_payout_h.shop_id, \n";
    $sql .= "           t_payout_h.c_staff_id AS staff_id, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payout_d.trade_id IN (41) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payout_d.pay_amount, 0) * 1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS payout_genkin_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payout_h \n";
    $sql .= "           INNER JOIN t_payout_d ON t_payout_h.pay_id = t_payout_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payout_h.shop_id = $shop_id \n";
    $sql .= "       AND \n";
    $sql .= "           t_payout_h.buy_id IS NULL \n";
    $sql .= "       AND \n";
    $sql .= "           t_payout_h.pay_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "       AND \n";
    $sql .= "           t_payout_h.pay_day <= '$end_day' \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           t_payout_h.shop_id, \n";
    $sql .= "           t_payout_h.c_staff_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_payout_data \n";
    $sql .= "   ON t_attach_staff.shop_id = t_payout_data.shop_id \n";
    $sql .= "   AND t_attach_staff.staff_id = t_payout_data.staff_id \n";
    // 条件
    $sql .= "GROUP BY \n";
    $sql .= "   t_attach_staff.staff_id, \n";
    $sql .= "   t_attach_staff.charge_cd, \n";
    $sql .= "   t_attach_staff.staff_name, \n";
    $sql .= "   t_buy_data.buy_genkin_amount, \n";
    $sql .= "   t_buy_data.buy_kake_amount \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_attach_staff.charge_cd \n";
    $sql .= ";";
    $res_monthly_2  = Db_Query($db_con, $sql);
    $num_monthly_2 = pg_num_rows($res_monthly_2);

    // 代行（売上・日次累計）
    $sql  = "SELECT \n";
    $sql .= "   0, \n";
    $sql .= "   '代行', \n";
    $sql .= "   COALESCE(t_sale_data.sale_kake_amount, 0) AS sale_kake_amount \n";
    $sql .= "FROM \n";
    // ■売上ヘッダ
    $sql .= "   (\n";
    $sql .= "       SELECT \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (11, 15) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(sale_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (13, 14) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(sale_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS sale_kake_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               SELECT \n";
    $sql .= "                   trade_id, \n";
    $sql .= "                   COALESCE(all_total_amount, 0) AS sale_amount \n";
    $sql .= "               FROM \n";
    $sql .= "                   t_sale_h_amount \n";
    $sql .= "               WHERE \n";
    $sql .= "                   shop_id = $shop_id \n";
    $sql .= "               AND \n";
    $sql .= "                   renew_flg = 'f' \n";
    $sql .= "               AND \n";
    $sql .= "                   contract_div != '1' \n";
    $sql .= "               AND \n";
    $sql .= "                   sale_day >= '$monthly_update_time' \n";
        if ($end_day != null){
    $sql .= "               AND \n";
    $sql .= "                   sale_day <= '$end_day' \n";
    }
    $sql .= "           ) \n";
    $sql .= "           AS t_sale_union \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_sale_data \n";
    // 条件
    $sql .= ";";
    $res_act_daily_1 = Db_Query($db_con, $sql);
    $num_act_daily_1 = pg_num_rows($res_act_daily_1);

    // 代行（売上・月次累計）
    $sql  = "SELECT \n";
    $sql .= "   0, \n";
    $sql .= "   '代行', \n";
    $sql .= "   COALESCE(t_sale_data.sale_kake_amount, 0) AS sale_kake_amount \n";
    $sql .= "FROM \n";
    // ■売上ヘッダ
    $sql .= "   (\n";
    $sql .= "       SELECT \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (11, 15) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(sale_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (13, 14) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(sale_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS sale_kake_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               SELECT \n";
    $sql .= "                   trade_id, \n";
    $sql .= "                   COALESCE(all_total_amount, 0) AS sale_amount \n";
    $sql .= "               FROM \n";
    $sql .= "                   t_sale_h_amount \n";
    $sql .= "               WHERE \n";
    $sql .= "                   shop_id = $shop_id \n";
    $sql .= "               AND \n";
    $sql .= "                   contract_div != '1' \n";
    $sql .= "               AND \n";
    $sql .= "                   sale_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "               AND \n";
    $sql .= "                   sale_day <= '$end_day' \n";
    }
    $sql .= "           ) \n";
    $sql .= "           AS t_sale_union \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_sale_data \n";
    $sql .= ";";
    // 条件
    $res_act_monthly_1 = Db_Query($db_con, $sql);
    $num_act_monthly_1 = pg_num_rows($res_act_monthly_1);

    // 代行（仕入・日次累計）
    $sql  = "SELECT \n";
    $sql .= "   0, \n";
    $sql .= "   '代行', \n";
    $sql .= "   COALESCE(t_buy_data.buy_kake_amount, 0) AS buy_kake_amount \n";
    $sql .= "FROM \n";
    // ■仕入ヘッダ
    $sql .= "   (\n";
    $sql .= "       SELECT \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (21, 25) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (23, 24) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS buy_kake_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               SELECT \n";
    $sql .= "                   trade_id, \n";
    $sql .= "                   COALESCE(net_amount, 0) AS net_amount, \n";
    $sql .= "                   COALESCE(tax_amount, 0) AS tax_amount \n";
    $sql .= "               FROM \n";
    $sql .= "                   t_buy_h \n";
    $sql .= "               WHERE \n";
    $sql .= "                   shop_id = $shop_id \n";
    $sql .= "               AND \n";
    $sql .= "                   renew_flg = 'f' \n";
    $sql .= "               AND \n";
    $sql .= "                   act_sale_id IS NOT NULL \n";
    $sql .= "               AND \n";
    $sql .= "                   buy_day >= '$monthly_update_time' \n";
        if ($end_day != null){
    $sql .= "               AND \n";
    $sql .= "                   buy_day <= '$end_day' \n";
    }
    $sql .= "           ) \n";
    $sql .= "           AS t_buy_union \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_buy_data \n";
    // 条件
    $sql .= ";";
    $res_act_daily_2 = Db_Query($db_con, $sql);
    $num_act_daily_2 = pg_num_rows($res_act_daily_2);

    // 代行（売上・月次累計）
    $sql  = "SELECT \n";
    $sql .= "   0, \n";
    $sql .= "   '代行', \n";
    $sql .= "   COALESCE(t_buy_data.buy_kake_amount, 0) AS buy_kake_amount \n";
    $sql .= "FROM \n";
    // ■仕入ヘッダ
    $sql .= "   (\n";
    $sql .= "       SELECT \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (21, 25) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (23, 24) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS buy_kake_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               SELECT \n";
    $sql .= "                   trade_id, \n";
    $sql .= "                   COALESCE(net_amount, 0) AS net_amount, \n";
    $sql .= "                   COALESCE(tax_amount, 0) AS tax_amount \n";
    $sql .= "               FROM \n";
    $sql .= "                   t_buy_h \n";
    $sql .= "               WHERE \n";
    $sql .= "                   shop_id = $shop_id \n";
    $sql .= "               AND \n";
    $sql .= "                   act_sale_id IS NOT NULL \n";
    $sql .= "               AND \n";
    $sql .= "                   buy_day >= '$monthly_update_time' \n";
        if ($end_day != null){
    $sql .= "               AND \n";
    $sql .= "                   buy_day <= '$end_day' \n";
    }
    $sql .= "           ) \n";
    $sql .= "           AS t_buy_union \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_buy_data \n";
    // 条件
    $sql .= ";";
    // 条件
    $res_act_monthly_2 = Db_Query($db_con, $sql);
    $num_act_monthly_2 = pg_num_rows($res_act_monthly_2);

    // 売上・入金データが1件以上あれば
    if ($num_monthly_1 != 0){

        $html_1 = null;

        $i = 0;
        while ($daily_data_list_1 = pg_fetch_array($res_daily_1)){

            // 日次累計データ取得
            $disp_daily_data_1[$i][0]   = $daily_data_list_1["staff_id"];
            $disp_daily_data_1[$i][1]   = $daily_data_list_1["staff_name"];
            $disp_daily_data_1[$i][2]   = $daily_data_list_1["sale_genkin_amount"];       // 現金売上
            $disp_daily_data_1[$i][3]   = $daily_data_list_1["sale_kake_amount"];         // 掛売上
            $disp_daily_data_1[$i][4]   = $daily_data_list_1["sale_genkin_amount"]        // 売上合計
                                        + $daily_data_list_1["sale_kake_amount"];
            $disp_daily_data_1[$i][5]   = $daily_data_list_1["payin_genkin_amount"];      // 現金入金
            $disp_daily_data_1[$i][6]   = null;
            $disp_daily_data_1[$i][7]   = null;
            $disp_daily_data_1[$i][8]   = null;
            $disp_daily_data_1[$i][9]   = $daily_data_list_1["sale_genkin_amount"]        // 現金合計
                                        + $daily_data_list_1["payin_genkin_amount"];

            // 月次累計データ取得
            $monthly_data_list_1 = pg_fetch_array($res_monthly_1, $i);
            $disp_monthly_data_1[$i][0] = $monthly_data_list_1["staff_id"];
            $disp_monthly_data_1[$i][1] = $monthly_data_list_1["staff_name"];
            $disp_monthly_data_1[$i][2] = $monthly_data_list_1["sale_genkin_amount"];     // 現金売上
            $disp_monthly_data_1[$i][3] = $monthly_data_list_1["sale_kake_amount"];       // 掛売上
            $disp_monthly_data_1[$i][4] = $monthly_data_list_1["sale_genkin_amount"]      // 売上合計
                                        + $monthly_data_list_1["sale_kake_amount"];
            $disp_monthly_data_1[$i][5] = $monthly_data_list_1["payin_genkin_amount"];    // 現金入金
            $disp_monthly_data_1[$i][6] = null;
            $disp_monthly_data_1[$i][7] = null;
            $disp_monthly_data_1[$i][8] = null;
            $disp_monthly_data_1[$i][9] = $monthly_data_list_1["sale_genkin_amount"]      // 現金合計
                                        + $monthly_data_list_1["payin_genkin_amount"];

            // 詳細ページへのリンク作成
            $get_staff  = "?staff_id=".$disp_daily_data_1[$i][0];
            $get_name   = ($disp_daily_data_1[$i][0] == "0") ? "担当者なし" : $disp_daily_data_1[$i][1];
            $form->addElement("link", "form_staff_link_1[".$i."]", "", "", htmlspecialchars($get_name), 
                              "onClick=\"javascript:return Submit_Page2('2-5-109_2.php".$get_staff."')\"");


            // 行色設定
            $row_color = ($i%2 == 0) ? "Result1" : "Result2";
            $row_color = ($disp_daily_data_1[$i][0] == "0") ? "Result7" : $row_color;

            // html1作成
            $html_1 .= "<tr class=\"$row_color\">\n";
            $html_1 .= "    <td>";
            $html_1 .= $form->_elements[$form->_elementIndex["form_staff_link_1[$i]"]]->toHtml();
            $html_1 .= "    </td>\n";
            // 日次累計
            $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_data_1[$i][2]).">".number_format($disp_daily_data_1[$i][2])."</td>\n";
            $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_data_1[$i][3]).">".number_format($disp_daily_data_1[$i][3])."</td>\n";
            $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_data_1[$i][4]).">".number_format($disp_daily_data_1[$i][4])."</td>\n";
            $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_data_1[$i][5]).">".number_format($disp_daily_data_1[$i][5])."</td>\n";
            $html_1 .= "    <td width=\"70\" align=\"center\">-</td>\n";
            $html_1 .= "    <td width=\"70\" align=\"center\">-</td>\n";
            $html_1 .= "    <td width=\"70\" align=\"center\">-</td>\n";
            $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_data_1[$i][9]).">".number_format($disp_daily_data_1[$i][9])."</td>\n";
            $html_1 .= "    <td></td>\n";
            // 月次累計
            $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_data_1[$i][2]).">".number_format($disp_monthly_data_1[$i][2])."</td>\n";
            $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_data_1[$i][3]).">".number_format($disp_monthly_data_1[$i][3])."</td>\n";
            $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_data_1[$i][4]).">".number_format($disp_monthly_data_1[$i][4])."</td>\n";
            $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_data_1[$i][5]).">".number_format($disp_monthly_data_1[$i][5])."</td>\n";
            $html_1 .= "    <td width=\"70\" align=\"center\">-</td>\n";
            $html_1 .= "    <td width=\"70\" align=\"center\">-</td>\n";
            $html_1 .= "    <td width=\"70\" align=\"center\">-</td>\n";
            $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_data_1[$i][9]).">".number_format($disp_monthly_data_1[$i][9])."</td>\n";
            $html_1 .= "</tr>\n";

            $i++;   

        }

    }

    // 仕入・支払データが1件以上あれば
    if ($num_monthly_2 != 0){

        $html_2 = null;

        $i = 0;
        while ($daily_data_list_2 = pg_fetch_array($res_daily_2)){

            // 日次累計データ取得
            $disp_daily_data_2[$i][0]   = $daily_data_list_2["staff_id"];
            $disp_daily_data_2[$i][1]   = $daily_data_list_2["staff_name"];
            $disp_daily_data_2[$i][2]   = $daily_data_list_2["buy_genkin_amount"];        // 現金仕入
            $disp_daily_data_2[$i][3]   = $daily_data_list_2["buy_kake_amount"];          // 掛仕入
            $disp_daily_data_2[$i][4]   = $daily_data_list_2["buy_genkin_amount"]         // 仕入合計
                                        + $daily_data_list_2["buy_kake_amount"];
            $disp_daily_data_2[$i][5]   = $daily_data_list_2["payout_genkin_amount"];     // 現金支払
            $disp_daily_data_2[$i][6]   = null;
            $disp_daily_data_2[$i][7]   = null;
            $disp_daily_data_2[$i][8]   = null;
            $disp_daily_data_2[$i][9]   = $daily_data_list_2["buy_genkin_amount"]        // 現金合計
                                        + $daily_data_list_2["payout_genkin_amount"];

            // 月次累計データ取得
            $monthly_data_list_2 = pg_fetch_array($res_monthly_2, $i);
            $disp_monthly_data_2[$i][0] = $monthly_data_list_2["staff_id"];
            $disp_monthly_data_2[$i][1] = $monthly_data_list_2["staff_name"];
            $disp_monthly_data_2[$i][2] = $monthly_data_list_2["buy_genkin_amount"];      // 現金仕入
            $disp_monthly_data_2[$i][3] = $monthly_data_list_2["buy_kake_amount"];        // 掛仕入
            $disp_monthly_data_2[$i][4] = $monthly_data_list_2["buy_genkin_amount"]       // 仕入合計
                                        + $monthly_data_list_2["buy_kake_amount"];
            $disp_monthly_data_2[$i][5] = $monthly_data_list_2["payout_genkin_amount"];   // 現金支払
            $disp_monthly_data_2[$i][6] = null;
            $disp_monthly_data_2[$i][7] = null;
            $disp_monthly_data_2[$i][8] = null;
            $disp_monthly_data_2[$i][9] = $monthly_data_list_2["buy_genkin_amount"]       // 現金合計
                                        + $monthly_data_list_2["payout_genkin_amount"];

            // 詳細ページへのリンク作成
            $get_staff  = "?staff_id=".$disp_daily_data_2[$i][0];
            $get_name   = ($disp_daily_data_2[$i][0] == "0") ? "担当者なし" : $disp_daily_data_2[$i][1];
            $form->addElement("link", "form_staff_link_2[".$i."]", "", "", htmlspecialchars($get_name), 
                              "onClick=\"javascript:return Submit_Page2('2-5-109_2.php".$get_staff."')\"");


            // 行色設定
            $row_color = ($i%2 == 0) ? "Result1" : "Result2";
            $row_color = ($disp_daily_data_2[$i][0] == "0") ? "Result7" : $row_color;

            // html2作成
            $html_2 .= "<tr class=\"$row_color\">\n";
            $html_2 .= "    <td>";
            $html_2 .= $form->_elements[$form->_elementIndex["form_staff_link_2[$i]"]]->toHtml();
            $html_2 .= "    </td>\n";
            // 日次累計
            $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_data_2[$i][2]).">".number_format($disp_daily_data_2[$i][2])."</td>\n";
            $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_data_2[$i][3]).">".number_format($disp_daily_data_2[$i][3])."</td>\n";
            $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_data_2[$i][4]).">".number_format($disp_daily_data_2[$i][4])."</td>\n";
            $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_data_2[$i][5]).">".number_format($disp_daily_data_2[$i][5])."</td>\n";
            $html_2 .= "    <td width=\"70\" align=\"center\">-</td>\n";
            $html_2 .= "    <td width=\"70\" align=\"center\">-</td>\n";
            $html_2 .= "    <td width=\"70\" align=\"center\">-</td>\n";
            $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_data_2[$i][9]).">".number_format($disp_daily_data_2[$i][9])."</td>\n";
            $html_2 .= "    <td width=\"1\"></td>\n";
            // 月次累計
            $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_data_2[$i][2]).">".number_format($disp_monthly_data_2[$i][2])."</td>\n";
            $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_data_2[$i][3]).">".number_format($disp_monthly_data_2[$i][3])."</td>\n";
            $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_data_2[$i][4]).">".number_format($disp_monthly_data_2[$i][4])."</td>\n";
            $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_data_2[$i][5]).">".number_format($disp_monthly_data_2[$i][5])."</td>\n";
            $html_2 .= "    <td width=\"70\" align=\"center\">-</td>\n";
            $html_2 .= "    <td width=\"70\" align=\"center\">-</td>\n";
            $html_2 .= "    <td width=\"70\" align=\"center\">-</td>\n";
            $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_data_2[$i][9]).">".number_format($disp_monthly_data_2[$i][9])."</td>\n";
            $html_2 .= "</tr>\n";

            $i++;   

        }

    }

    /* 代行出力データ整形（売上） */
    if ($num_act_daily_1 != 0 || $num_act_monthly_1 != 0){

        $act_daily_data_1   = Get_Data($res_act_daily_1);
        $act_monthly_data_1 = Get_Data($res_act_monthly_1);

        $form->addElement("link", "form_staff_link_daikou_1", "", "", htmlspecialchars($act_daily_data_1[0][1]),
                            "onClick=\"javascript:return Submit_Page2('2-5-109_2.php?staff_id=0')\"");

        // html1作成
        $html_1 .= "<tr class=\"Result5\">\n";
        $html_1 .= "    <td>\n";
        $html_1 .= $form->_elements[$form->_elementIndex["form_staff_link_daikou_1"]]->toHtml();
        $html_1 .= "    </td>\n";
        // 日次累計
        $html_1 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($act_daily_data_1[0][2]).">".number_format($act_daily_data_1[0][2])."</td>\n";
        $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($act_daily_data_1[0][2]).">".number_format($act_daily_data_1[0][2])."</td>\n";
        $html_1 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_1 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_1 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_1 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_1 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_1 .= "    <td width=\"1\"></td>\n";
        // 月次累計
        $html_1 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($act_monthly_data_1[0][2]).">".number_format($act_monthly_data_1[0][2])."</td>\n";
        $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($act_monthly_data_1[0][2]).">".number_format($act_monthly_data_1[0][2])."</td>\n";
        $html_1 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_1 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_1 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_1 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_1 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_1 .= "</tr>\n";

    }

    /* 代行出力データ整形（仕入） */
    if ($num_act_daily_2 != 0 || $num_act_monthly_2 != 0){

        $act_daily_data_2   = Get_Data($res_act_daily_2);
        $act_monthly_data_2 = Get_Data($res_act_monthly_2);

        $form->addElement("link", "form_staff_link_daikou_2", "", "", htmlspecialchars($act_daily_data_2[0][1]),
                            "onClick=\"javascript:return Submit_Page2('2-5-109_2.php?staff_id=0')\"");

        // html2作成
        $html_2 .= "<tr class=\"Result5\">\n";
        $html_2 .= "    <td>\n";
        $html_2 .= $form->_elements[$form->_elementIndex["form_staff_link_daikou_2"]]->toHtml();
        $html_2 .= "    </td>\n";
        // 日次累計
        $html_2 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($act_daily_data_2[0][2]).">".number_format($act_daily_data_2[0][2])."</td>\n";
        $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($act_daily_data_2[0][2]).">".number_format($act_daily_data_2[0][2])."</td>\n";
        $html_2 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_2 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_2 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_2 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_2 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_2 .= "    <td width=\"1\"></td>\n";
        // 月次累計
        $html_2 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($act_monthly_data_2[0][2]).">".number_format($act_monthly_data_2[0][2])."</td>\n";
        $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($act_monthly_data_2[0][2]).">".number_format($act_monthly_data_2[0][2])."</td>\n";
        $html_2 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_2 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_2 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_2 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_2 .= "    <td width=\"70\" align=\"center\">-</td>\n";
        $html_2 .= "</tr>\n";

    }

    /* 全社用金額取得SQL */
    // 日次累計
    $sql  = "SELECT \n";
    $sql .= "   COALESCE(t_sale_data.sale_genkin_amount, 0)     AS sale_genkin_amount, \n";
    $sql .= "   COALESCE(t_sale_data.sale_kake_amount, 0)       AS sale_kake_amount, \n";
    $sql .= "   COALESCE(t_payin_data.payin_genkin_amount, 0)   AS payin_genkin_amount, \n";
    $sql .= "   COALESCE(t_payin_data.payin_kake_amount, 0)     AS payin_kake_amount, \n";
    $sql .= "   COALESCE(t_payin_data.payin_rebate_amount, 0)   AS payin_rebate_amount, \n";
    $sql .= "   COALESCE(t_buy_data.buy_genkin_amount, 0)       AS buy_genkin_amount, \n";
    $sql .= "   COALESCE(t_buy_data.buy_kake_amount, 0)         AS buy_kake_amount, \n";
    $sql .= "   COALESCE(t_payout_data.payout_genkin_amount, 0) AS payout_genkin_amount, \n";
    $sql .= "   COALESCE(t_payout_data.payout_kake_amount, 0)   AS payout_kake_amount, \n";
    $sql .= "   COALESCE(t_payout_data.payout_rebate_amount, 0) AS payout_rebate_amount \n";
    $sql .= "FROM \n";
    // ■ショップ
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               ( \n";
    foreach ($ary_main_sub as $key => $value){
    $sql .= "                   ( \n";
    $sql .= "                       SELECT \n";
    $sql .= "                           shop_id \n";
    $sql .= "                       FROM \n";
    $sql .= "                           t_sale_h_amount \n";
    $sql .= "                       WHERE \n";
    $sql .= "                           shop_id = $shop_id \n";
    $sql .= "                       AND \n";
    $sql .= "                           renew_flg = 'f' \n";
    $sql .= "                       AND \n";
    $sql .= "                           contract_div = '1' \n";
    $sql .= "                       AND \n";
    $sql .= "                           ".$value."_staff_id IS NOT NULL \n";
    $sql .= "                       AND \n";
    $sql .= "                           sale_day >= '$monthly_update_time' \n";
        if ($end_day != null){
    $sql .= "                       AND \n";
    $sql .= "                           sale_day <= '$end_day' \n";
        }
    $sql .= "                   ) \n";
        if ($key+1 < count($ary_main_sub)){
    $sql .= "                   UNION ALL \n";
        }
    }
    $sql .= "               ) \n";
    $sql .= "               UNION ALL \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_buy_h \n";
    $sql .= "                   WHERE \n";
    $sql .= "                       shop_id = $shop_id \n";
    $sql .= "                   AND \n";
    $sql .= "                       renew_flg = 'f' \n";
    $sql .= "                   AND \n";
    $sql .= "                       act_sale_id IS NULL \n";
    $sql .= "                   AND \n";
    $sql .= "                       buy_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "                   AND \n";
    $sql .= "                       buy_day <= '$end_day' \n";
    }
    $sql .= "               ) \n";
    $sql .= "               UNION ALL \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_payin_h \n";
    $sql .= "                   WHERE \n";
    $sql .= "                       shop_id = $shop_id \n";
    $sql .= "                   AND \n";
    $sql .= "                       renew_flg = 'f' \n";
    $sql .= "                   AND \n";
    $sql .= "                       sale_id IS NULL \n";
    $sql .= "                   AND \n";
    $sql .= "                       pay_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "                   AND \n";
    $sql .= "                       pay_day <= '$end_day' \n";
    }
    $sql .= "               ) \n";
    $sql .= "               UNION ALL \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_payout_h \n";
    $sql .= "                   WHERE \n";
    $sql .= "                       shop_id = $shop_id \n";
    $sql .= "                   AND \n";
    $sql .= "                       renew_flg = 'f' \n";
    $sql .= "                   AND \n";
    $sql .= "                       buy_id IS NULL \n";
    $sql .= "                   AND \n";
    $sql .= "                       pay_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "                   AND \n";
    $sql .= "                       pay_day <= '$end_day' \n";
    }
    $sql .= "               ) \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_shop_union \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           shop_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_attach_staff \n";
    // ■売上ヘッダ
    $sql .= "   LEFT JOIN \n";
    $sql .= "   (\n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id, \n";
                        // 現金売上
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (61) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (63, 64) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS sale_genkin_amount, \n";
                        // 掛売上
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (11, 15) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (13, 14) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS sale_kake_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    foreach ($ary_main_sub as $key => $value){
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id, \n";
    $sql .= "                       trade_id, \n";
    $sql .= "                       sale_day, \n";
    $sql .= "                       renew_flg, \n";
    $sql .= "                       ".$value."_net_amount AS net_amount, \n";
    $sql .= "                       ".$value."_tax_amount AS tax_amount \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_sale_h_amount \n";
    $sql .= "                   WHERE \n";
    $sql .= "                       shop_id = $shop_id \n";
    $sql .= "                   AND \n";
    $sql .= "                       renew_flg = 'f' \n";
    $sql .= "                   AND \n";
    $sql .= "                       contract_div = '1' \n";
    $sql .= "                   AND \n";
    $sql .= "                       ".$value."_staff_id IS NOT NULL \n";
    $sql .= "                   AND \n";
    $sql .= "                       sale_day >= '$monthly_update_time' \n";
        if ($end_day != null){
    $sql .= "                   AND \n";
    $sql .= "                       sale_day <= '$end_day' \n";
        }
    $sql .= "               ) \n";
        if ($key+1 < count($ary_main_sub)){
    $sql .= "               UNION ALL \n";
        }
    }
    $sql .= "           ) \n";
    $sql .= "           AS t_sale_union \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           shop_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_sale_data \n";
    $sql .= "   ON t_attach_staff.shop_id = t_sale_data.shop_id \n";
    // ■仕入ヘッダ
    $sql .= "   LEFT JOIN \n";
    $sql .= "   (\n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (71) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (73, 74) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS buy_genkin_amount, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (21, 25) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (23, 24) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS buy_kake_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_buy_h \n";
    $sql .= "       WHERE \n";
    $sql .= "           shop_id = $shop_id \n";
    $sql .= "       AND \n";
    $sql .= "           renew_flg = 'f' \n";
    $sql .= "       AND \n";
    $sql .= "           act_sale_id IS NULL \n";
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
    // ■入金ヘッダ(join 入金データ)
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_payin_h.shop_id, \n";
                        // 現金入金
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payin_d.trade_id IN (31) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payin_d.amount, 0) * 1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS payin_genkin_amount, \n";
                        // 現金入金・手数料以外
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payin_d.trade_id IN (32, 33, 34, 36, 37, 38) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payin_d.amount, 0) * 1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS payin_kake_amount, \n";
                        // 手数料
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payin_d.trade_id IN (35) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payin_d.amount, 0) * 1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS payin_rebate_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payin_h \n";
    $sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payin_h.shop_id = $shop_id \n";
    $sql .= "       AND \n";
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
    // ■支払ヘッダ(join 支払データ)
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_payout_h.shop_id, \n";
                        // 現金入金
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payout_d.trade_id IN (41) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payout_d.pay_amount, 0) * 1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS payout_genkin_amount, \n";
                        // 現金入金・手数料以外
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payout_d.trade_id IN (43, 44, 45, 46, 47) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payout_d.pay_amount, 0) * 1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS payout_kake_amount, \n";
                        // 手数料
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payout_d.trade_id IN (48) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payout_d.pay_amount, 0) * 1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS payout_rebate_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payout_h \n";
    $sql .= "           INNER JOIN t_payout_d ON t_payout_h.pay_id = t_payout_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payout_h.shop_id = $shop_id \n";
    $sql .= "       AND \n";
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
    $res_daily_all  = Db_Query($db_con, $sql);
    $num_daily_all = pg_num_rows($res_daily_all);

    // 月次累計
    $sql  = "SELECT \n";
    $sql .= "   COALESCE(t_sale_data.sale_genkin_amount, 0)     AS sale_genkin_amount, \n";
    $sql .= "   COALESCE(t_sale_data.sale_kake_amount, 0)       AS sale_kake_amount, \n";
    $sql .= "   COALESCE(t_payin_data.payin_genkin_amount, 0)   AS payin_genkin_amount, \n";
    $sql .= "   COALESCE(t_payin_data.payin_kake_amount, 0)     AS payin_kake_amount, \n";
    $sql .= "   COALESCE(t_payin_data.payin_rebate_amount, 0)   AS payin_rebate_amount, \n";
    $sql .= "   COALESCE(t_buy_data.buy_genkin_amount, 0)       AS buy_genkin_amount, \n";
    $sql .= "   COALESCE(t_buy_data.buy_kake_amount, 0)         AS buy_kake_amount, \n";
    $sql .= "   COALESCE(t_payout_data.payout_genkin_amount, 0) AS payout_genkin_amount, \n";
    $sql .= "   COALESCE(t_payout_data.payout_kake_amount, 0)   AS payout_kake_amount, \n";
    $sql .= "   COALESCE(t_payout_data.payout_rebate_amount, 0) AS payout_rebate_amount \n";
    $sql .= "FROM \n";
    // ■ショップ
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               ( \n";
    foreach ($ary_main_sub as $key => $value){
    $sql .= "                   ( \n";
    $sql .= "                       SELECT \n";
    $sql .= "                           shop_id \n";
    $sql .= "                       FROM \n";
    $sql .= "                           t_sale_h_amount \n";
    $sql .= "                       WHERE \n";
    $sql .= "                           shop_id = $shop_id \n";
    $sql .= "                       AND \n";
    $sql .= "                           contract_div = '1' \n";
    $sql .= "                       AND \n";
    $sql .= "                           ".$value."_staff_id IS NOT NULL \n";
    $sql .= "                       AND \n";
    $sql .= "                           sale_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "                       AND \n";
    $sql .= "                           sale_day <= '$end_day' \n";
    }
    $sql .= "                   ) \n";
        if ($key+1 < count($ary_main_sub)){
    $sql .= "                   UNION ALL \n";
        }
    }
    $sql .= "               ) \n";
    $sql .= "               UNION ALL \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_buy_h \n";
    $sql .= "                   WHERE \n";
    $sql .= "                       shop_id = $shop_id \n";
    $sql .= "                   AND \n";
    $sql .= "                       act_sale_id IS NULL \n";
    $sql .= "                   AND \n";
    $sql .= "                       buy_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "                   AND \n";
    $sql .= "                       buy_day <= '$end_day' \n";
    }
    $sql .= "               ) \n";
    $sql .= "               UNION ALL \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_payin_h \n";
    $sql .= "                   WHERE \n";
    $sql .= "                       shop_id = $shop_id \n";
    $sql .= "                   AND \n";
    $sql .= "                       sale_id IS NULL \n";
    $sql .= "                   AND \n";
    $sql .= "                       pay_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "                   AND \n";
    $sql .= "                       pay_day <= '$end_day' \n";
    }
    $sql .= "               ) \n";
    $sql .= "               UNION ALL \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_payout_h \n";
    $sql .= "                   WHERE \n";
    $sql .= "                       shop_id = $shop_id \n";
    $sql .= "                   AND \n";
    $sql .= "                       buy_id IS NULL \n";
    $sql .= "                   AND \n";
    $sql .= "                       pay_day >= '$monthly_update_time' \n";
    if ($end_day != null){
    $sql .= "                   AND \n";
    $sql .= "                       pay_day <= '$end_day' \n";
    }
    $sql .= "               ) \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_shop_union \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           shop_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_attach_staff \n";
    // ■売上ヘッダ
    $sql .= "   LEFT JOIN \n";
    $sql .= "   (\n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id, \n";
                        // 現金売上
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (61) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (63, 64) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS sale_genkin_amount, \n";
                        // 掛売上
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (11, 15) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (13, 14) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS sale_kake_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    foreach ($ary_main_sub as $key => $value){
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id, \n";
    $sql .= "                       trade_id, \n";
    $sql .= "                       sale_day, \n";
    $sql .= "                       ".$value."_net_amount AS net_amount, \n";
    $sql .= "                       ".$value."_tax_amount AS tax_amount \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_sale_h_amount \n";
    $sql .= "                   WHERE \n";
    $sql .= "                       shop_id = $shop_id \n";
    $sql .= "                   AND \n";
    $sql .= "                       contract_div = '1' \n";
    $sql .= "                   AND \n";
    $sql .= "                       ".$value."_staff_id IS NOT NULL \n";
    $sql .= "                   AND \n";
    $sql .= "                       sale_day >= '$monthly_update_time' \n";
        if ($end_day != null){
    $sql .= "                   AND \n";
    $sql .= "                       sale_day <= '$end_day' \n";
        }
    $sql .= "               ) \n";
        if ($key+1 < count($ary_main_sub)){
    $sql .= "               UNION ALL \n";
        }
    }
    $sql .= "           ) \n";
    $sql .= "           AS t_sale_union \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           shop_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_sale_data \n";
    $sql .= "   ON t_attach_staff.shop_id = t_sale_data.shop_id \n";
    // ■仕入ヘッダ
    $sql .= "   LEFT JOIN \n";
    $sql .= "   (\n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (71) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (73, 74) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS buy_genkin_amount, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (21, 25) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       trade_id IN (23, 24) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS buy_kake_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_buy_h \n";
    $sql .= "       WHERE \n";
    $sql .= "           shop_id = $shop_id \n";
    $sql .= "       AND \n";
    $sql .= "           act_sale_id IS NULL \n";
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
    // ■入金ヘッダ(join 入金データ)
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_payin_h.shop_id, \n";
                        // 現金入金
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payin_d.trade_id IN (31) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payin_d.amount, 0) * 1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS payin_genkin_amount, \n";
                        // 現金入金・手数料以外
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payin_d.trade_id IN (32, 33, 34, 36, 37, 38) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payin_d.amount, 0) * 1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS payin_kake_amount, \n";
                        // 手数料
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payin_d.trade_id IN (35) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payin_d.amount, 0) * 1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS payin_rebate_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payin_h \n";
    $sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payin_h.shop_id = $shop_id \n";
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
    // ■支払ヘッダ(join 支払データ)
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_payout_h.shop_id, \n";
                        // 現金入金
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payout_d.trade_id IN (41) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payout_d.pay_amount, 0) * 1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS payout_genkin_amount, \n";
                        // 現金入金・手数料以外
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payout_d.trade_id IN (43, 44, 45, 46, 47) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payout_d.pay_amount, 0) * 1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS payout_kake_amount, \n";
                        // 手数料
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payout_d.trade_id IN (48) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payout_d.pay_amount, 0) * 1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS payout_rebate_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payout_h \n";
    $sql .= "           INNER JOIN t_payout_d ON t_payout_h.pay_id = t_payout_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payout_h.shop_id = $shop_id \n";
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
    $res_monthly_all = Db_Query($db_con, $sql);
    $num_monthly_all = pg_num_rows($res_monthly_all);

    // 1件以上あれば
    if ($num_monthly_all > 0){

        // 日次累計
        while ($daily_all_data_list = pg_fetch_array($res_daily_all)){

            // 日次の全社計データを作成するため、金額を加算していく
            $disp_daily_all_data_1[2]   = $daily_all_data_list["sale_genkin_amount"];       // 現金売上
            $disp_daily_all_data_1[3]   = $daily_all_data_list["sale_kake_amount"];         // 掛売上
            $disp_daily_all_data_1[4]   = $daily_all_data_list["sale_genkin_amount"]        // 売上合計
                                        + $daily_all_data_list["sale_kake_amount"];

            $disp_daily_all_data_1[5]   = $daily_all_data_list["payin_genkin_amount"];      // 現金入金
            $disp_daily_all_data_1[6]   = $daily_all_data_list["payin_kake_amount"];        // 振込入金
            $disp_daily_all_data_1[7]   = $daily_all_data_list["payin_rebate_amount"];      // 入金手数料
            $disp_daily_all_data_1[8]   = $daily_all_data_list["payin_genkin_amount"]       // 入金合計
                                        + $daily_all_data_list["payin_kake_amount"]
                                        + $daily_all_data_list["payin_rebate_amount"];

            $disp_daily_all_data_1[9]   = $daily_all_data_list["sale_genkin_amount"]        // 現金合計
                                        + $daily_all_data_list["payin_genkin_amount"];

            $disp_daily_all_data_2[2]   = $daily_all_data_list["buy_genkin_amount"];        // 現金仕入
            $disp_daily_all_data_2[3]   = $daily_all_data_list["buy_kake_amount"];          // 掛仕入
            $disp_daily_all_data_2[4]   = $daily_all_data_list["buy_genkin_amount"]         // 仕入合計
                                        + $daily_all_data_list["buy_kake_amount"];

            $disp_daily_all_data_2[5]   = $daily_all_data_list["payout_genkin_amount"];     // 現金支払
            $disp_daily_all_data_2[6]   = $daily_all_data_list["payout_kake_amount"];       // 振込支払
            $disp_daily_all_data_2[7]   = $daily_all_data_list["payout_rebate_amount"];     // 支払手数料
            $disp_daily_all_data_2[8]   = $daily_all_data_list["payout_genkin_amount"]      // 支払合計
                                        + $daily_all_data_list["payout_kake_amount"]
                                        + $daily_all_data_list["payout_rebate_amount"];

            $disp_daily_all_data_2[9]   = $daily_all_data_list["buy_genkin_amount"]         // 現金合計
                                        + $daily_all_data_list["payout_genkin_amount"];

        }
        // 代行分を加算
        $disp_daily_all_data_1[3] += $act_daily_data_1[0][2];
        $disp_daily_all_data_1[4] += $act_daily_data_1[0][2];
        $disp_daily_all_data_2[3] += $act_daily_data_2[0][2];
        $disp_daily_all_data_2[4] += $act_daily_data_2[0][2];

        // 全社計データに名前等を補完
        $disp_daily_all_data_1[0]   = null;
        $disp_daily_all_data_1[1]   = "全社";

        // 月次累計
        while ($monthly_all_data_list = pg_fetch_array($res_monthly_all)){

            // 月次の全社計データを作成するため、金額を加算していく
            $disp_monthly_all_data_1[2] = $monthly_all_data_list["sale_genkin_amount"];     // 現金売上
            $disp_monthly_all_data_1[3] = $monthly_all_data_list["sale_kake_amount"];       // 掛売上
            $disp_monthly_all_data_1[4] = $monthly_all_data_list["sale_genkin_amount"]      // 売上合計
                                        + $monthly_all_data_list["sale_kake_amount"];

            $disp_monthly_all_data_1[5] = $monthly_all_data_list["payin_genkin_amount"];    // 現金入金
            $disp_monthly_all_data_1[6] = $monthly_all_data_list["payin_kake_amount"];      // 振込入金
            $disp_monthly_all_data_1[7] = $monthly_all_data_list["payin_rebate_amount"];    // 入金手数料
            $disp_monthly_all_data_1[8] = $monthly_all_data_list["payin_genkin_amount"]     // 入金合計
                                        + $monthly_all_data_list["payin_kake_amount"]
                                        + $monthly_all_data_list["payin_rebate_amount"];

            $disp_monthly_all_data_1[9] = $monthly_all_data_list["sale_genkin_amount"]      // 合計
                                        + $monthly_all_data_list["payin_genkin_amount"];

            $disp_monthly_all_data_2[2] = $monthly_all_data_list["buy_genkin_amount"];      // 現金仕入
            $disp_monthly_all_data_2[3] = $monthly_all_data_list["buy_kake_amount"];        // 掛仕入
            $disp_monthly_all_data_2[4] = $monthly_all_data_list["buy_genkin_amount"]       // 仕入合計
                                        + $monthly_all_data_list["buy_kake_amount"];

            $disp_monthly_all_data_2[5] = $monthly_all_data_list["payout_genkin_amount"];   // 現金支払
            $disp_monthly_all_data_2[6] = $monthly_all_data_list["payout_kake_amount"];     // 支払入金
            $disp_monthly_all_data_2[7] = $monthly_all_data_list["payout_rebate_amount"];   // 支払手数料
            $disp_monthly_all_data_2[8] = $monthly_all_data_list["payout_genkin_amount"]    // 支払合計
                                        + $monthly_all_data_list["payout_kake_amount"]
                                        + $monthly_all_data_list["payout_rebate_amount"];

            $disp_monthly_all_data_2[9] = $monthly_all_data_list["buy_genkin_amount"]       // 合計
                                        + $monthly_all_data_list["payout_genkin_amount"];

        }
        // 代行分を加算
        $disp_monthly_all_data_1[3] += $act_monthly_data_1[0][2];
        $disp_monthly_all_data_1[4] += $act_monthly_data_1[0][2];
        $disp_monthly_all_data_2[3] += $act_monthly_data_2[0][2];
        $disp_monthly_all_data_2[4] += $act_monthly_data_2[0][2];

    // クエリ結果が0件の場合
    }else{

        // 0件の場合でも表（全社）は出力するため、データを作成
        $disp_daily_all_data_1[0]    = null;
        $disp_daily_all_data_1[1]    = "全社";
        for ($j=2; $j<=12; $j++){
            $disp_daily_all_data_1[$j]   = 0;
        }

        // 代行分を加算
        $disp_daily_all_data_1[3] += $act_daily_data_1[0][2];
        $disp_daily_all_data_1[4] += $act_daily_data_1[0][2];
        $disp_daily_all_data_2[3] += $act_daily_data_2[0][2];
        $disp_daily_all_data_2[4] += $act_daily_data_2[0][2];
        // 代行分を加算
        $disp_monthly_all_data_1[3] += $act_monthly_data_1[0][2];
        $disp_monthly_all_data_1[4] += $act_monthly_data_1[0][2];
        $disp_monthly_all_data_2[3] += $act_monthly_data_2[0][2];
        $disp_monthly_all_data_2[4] += $act_monthly_data_2[0][2];

    }

    // 詳細ページへのリンク作成
    $form->addElement("link", "form_staff_link_all", "", "", $disp_daily_all_data_1[1], 
                      "onClick=\"javascript:return Submit_Page2('2-5-109_2.php')\"");

    // html1作成
    $html_1 .= "<tr class=\"Result3\" style=\"white-space: nowrap;\">\n";
    $html_1 .= "    <td>";
    $html_1 .= $form->_elements[$form->_elementIndex["form_staff_link_all"]]->toHtml();
    $html_1 .= "    </td>\n";
    // 日次累計
    $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_all_data_1[2]).">".number_format($disp_daily_all_data_1[2])."</td>\n";
    $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_all_data_1[3]).">".number_format($disp_daily_all_data_1[3])."</td>\n";
    $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_all_data_1[4]).">".number_format($disp_daily_all_data_1[4])."</td>\n";
    $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_all_data_1[5]).">".number_format($disp_daily_all_data_1[5])."</td>\n";
    $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_all_data_1[6]).">".number_format($disp_daily_all_data_1[6])."</td>\n";
    $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_all_data_1[7]).">".number_format($disp_daily_all_data_1[7])."</td>\n";
    $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_all_data_1[8]).">".number_format($disp_daily_all_data_1[8])."</td>\n";
    $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_all_data_1[9]).">".number_format($disp_daily_all_data_1[9])."</td>\n";
    $html_1 .= "    <td></td>\n";
    // 月次累計
    $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_all_data_1[2]).">".number_format($disp_monthly_all_data_1[2])."</td>\n";
    $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_all_data_1[3]).">".number_format($disp_monthly_all_data_1[3])."</td>\n";
    $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_all_data_1[4]).">".number_format($disp_monthly_all_data_1[4])."</td>\n";
    $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_all_data_1[5]).">".number_format($disp_monthly_all_data_1[5])."</td>\n";
    $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_all_data_1[6]).">".number_format($disp_monthly_all_data_1[6])."</td>\n";
    $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_all_data_1[7]).">".number_format($disp_monthly_all_data_1[7])."</td>\n";
    $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_all_data_1[8]).">".number_format($disp_monthly_all_data_1[8])."</td>\n";
    $html_1 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_all_data_1[9]).">".number_format($disp_monthly_all_data_1[9])."</td>\n";
    $html_1 .= "</tr>\n";

    // html2作成
    $html_2 .= "<tr class=\"Result3\">\n";
    $html_2 .= "    <td>";
    $html_2 .= $form->_elements[$form->_elementIndex["form_staff_link_all"]]->toHtml();
    $html_2 .= "    </td>\n";
    // 日次累計
    $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_all_data_2[2]).">".number_format($disp_daily_all_data_2[2])."</td>\n";
    $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_all_data_2[3]).">".number_format($disp_daily_all_data_2[3])."</td>\n";
    $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_all_data_2[4]).">".number_format($disp_daily_all_data_2[4])."</td>\n";
    $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_all_data_2[5]).">".number_format($disp_daily_all_data_2[5])."</td>\n";
    $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_all_data_2[6]).">".number_format($disp_daily_all_data_2[6])."</td>\n";
    $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_all_data_2[7]).">".number_format($disp_daily_all_data_2[7])."</td>\n";
    $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_all_data_2[8]).">".number_format($disp_daily_all_data_2[8])."</td>\n";
    $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_daily_all_data_2[9]).">".number_format($disp_daily_all_data_2[9])."</td>\n";
    $html_2 .= "    <td></td>\n";
    // 月次累計
    $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_all_data_2[2]).">".number_format($disp_monthly_all_data_2[2])."</td>\n";
    $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_all_data_2[3]).">".number_format($disp_monthly_all_data_2[3])."</td>\n";
    $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_all_data_2[4]).">".number_format($disp_monthly_all_data_2[4])."</td>\n";
    $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_all_data_2[5]).">".number_format($disp_monthly_all_data_2[5])."</td>\n";
    $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_all_data_2[6]).">".number_format($disp_monthly_all_data_2[6])."</td>\n";
    $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_all_data_2[7]).">".number_format($disp_monthly_all_data_2[7])."</td>\n";
    $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_all_data_2[8]).">".number_format($disp_monthly_all_data_2[8])."</td>\n";
    $html_2 .= "    <td width=\"70\" align=\"right\"".Font_Color($disp_monthly_all_data_2[9]).">".number_format($disp_monthly_all_data_2[9])."</td>\n";
    $html_2 .= "</tr>\n";

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
$page_menu = Create_Menu_f("renew", "1");

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
    "html"              => "$html",
    "html_1"            => "$html_1",
    "html_2"            => "$html_2",
));

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
