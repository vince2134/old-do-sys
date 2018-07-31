<?php
$page_title = "オペレータ入力情報";

// 環境設定ファイル
require_once("ENV_local.php");

//請求関連で使用する関数ファイル
require_once(INCLUDE_DIR."op_nyuryoku.inc");


$s_time = microtime();


// HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");
$smarty->register_modifier("number_format","number_format");

// DB接続設定
$db_con = Db_Connect();

// 権限チェック
$auth = Auth_Check($db_con);

/****************************/
// 外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];

/****************************/
// スタッフ取得
/****************************/
$sql  = "SELECT \n";
$sql .= "   t_attach.staff_id, t_staff.charge_cd, t_staff.staff_name \n";
$sql .= "FROM \n";
$sql .= "   t_attach \n";
$sql .= "   INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id AND state = '在職中' \n";
$sql .= "   INNER JOIN t_login ON t_attach.staff_id = t_login.staff_id \n";
$sql .= "WHERE \n";
$sql .= "   t_attach.shop_id = ".$_SESSION["client_id"]." \n";
$sql .= "ORDER BY \n";
$sql .= "   t_staff.charge_cd \n";
$sql .= ";";
$result = Db_Query($db_con, $sql);
$select_value[""] = "";
while($data_list = pg_fetch_array($result)){
    $data_list[0] = htmlspecialchars($data_list[0]);
    $data_list[1] = htmlspecialchars($data_list[1]);
    $data_list[1] = str_pad($data_list[1], 4, 0, STR_POS_LEFT);
    $data_list[2] = htmlspecialchars($data_list[2]);
    $select_value[$data_list[0]] = $data_list[1]." ： ".$data_list[2];
}

/****************************/
// フォーム初期値設定
/****************************/
$def_fdata["form_count_type"]       = "1";
$def_fdata["f_r_output"]            = "1";
$def_fdata["form_count_date"]["sy"] = date("Y");
$def_fdata["form_count_date"]["sm"] = date("m");
$def_fdata["form_count_date"]["sd"] = date("d");
$def_fdata["form_count_date"]["ey"] = date("Y");
$def_fdata["form_count_date"]["em"] = date("m");
$def_fdata["form_count_date"]["ed"] = date("d");

#2010-04-27 hashimoto-y
$def_fdata["form_e_staff_slct"]     = $_SESSION["staff_id"];

$form->setDefaults($def_fdata);

$count_type = ($_POST["form_count_type"] != null) ? $_POST["form_count_type"] : "1";

/****************************/
// 前回の月次更新日＋１取得
/****************************/
$sql  = "SELECT MAX(close_day) FROM t_sys_renew WHERE renew_div = '2' AND shop_id = ".$_SESSION["client_id"].";";
$res  = Db_Query($db_con, $sql);
$result_date = pg_fetch_result($res, 0);
// 月次更新が行われている場合
if ($result_date != null){
    $close_date         = pg_fetch_result($res, 0);
    $ary_close_date     = explode("-", $close_date);
    $close_date_plus    = date("Y-m-d", mktime(0, 0, 0, $ary_close_date[1] , $ary_close_date[2]+1, $ary_close_date[0]));
    $info_msg           = "※前回の月次締日($close_date)より後の日付を指定してください";
// 月次更新が行われていない場合
}else{
    $sys_start_date     = START_DAY;
    $info_msg           = "※システム開始日($sys_start_date)以降の日付を指定してください";
}

/****************************/
// フォームパーツ定義
/****************************/
// 出力形式
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "画面", "1");
$radio[] =& $form->createElement("radio", null, null, "帳票", "2");
$form->addGroup($radio, "f_r_output", "");

// 集計日
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "入力日", "1");
$radio[] =& $form->createElement("radio", null, null, "計上日", "2");
$form->addGroup($radio, "form_count_type", "");

// 集計期間
$text = null; 
$text[] =& $form->createElement("text", "sy", "",
        "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_count_date[sy]', 'form_count_date[sm]',4)\"
         onFocus=\"onForm_today(this,this.form,'form_count_date[sy]','form_count_date[sm]','form_count_date[sd]')\"
         onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "sm", "",
        "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_count_date[sm]', 'form_count_date[sd]',2)\"
         onFocus=\"onForm_today(this,this.form,'form_count_date[sy]','form_count_date[sm]','form_count_date[sd]')\"
         onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "sd", "",
        "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_count_date[sd]','form_count_date[ey]',2)\"
         onFocus=\"onForm_today(this,this.form,'form_count_date[sy]','form_count_date[sm]','form_count_date[sd]')\"
         onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static","","","〜");
$text[] =& $form->createElement("text", "ey", "",
        "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_count_date[ey]', 'form_count_date[em]',4)\"
         onFocus=\"onForm_today(this,this.form,'form_count_date[ey]','form_count_date[em]','form_count_date[ed]')\"
         onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text", "em", "",
        "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_count_date[em]', 'form_count_date[ed]',2)\"
         onFocus=\"onForm_today(this,this.form,'form_count_date[ey]','form_count_date[em]','form_count_date[ed]')\"
         onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text", "ed", "",
        "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
         onFocus=\"onForm_today(this,this.form,'form_count_date[ey]','form_count_date[em]','form_count_date[ed]')\"
         onBlur=\"blurForm(this)\""
);
$form->addGroup($text, "form_count_date", "");

// オペレータ
$form->addElement("select", "form_e_staff_slct", "", $select_value, $g_form_option_select);

// 表示ボタン
$form->addElement("submit", "form_show_button", "表　示");

// クリアボタン
$form->addElement("button", "form_clear_button", "クリア", "onClick=\"javascript:Referer('$_SERVER[PHP_SELF]')\"");


/****************************/
// エラーチェック(AddRule)
/****************************/
/*** 集計期間 ***/
// ■必須チェック
// ■半角数字チェック
$err_msg = "集計期間 の日付が妥当ではありません";
$form->addGroupRule("form_count_date", array(
    "sy" => array(
        array($err_msg, "required"),
        array($err_msg, "regex", "/^[0-9]+$/")
    ),
    "sm" => array(
        array($err_msg, "required"),
        array($err_msg, "regex", "/^[0-9]+$/")
    ),
    "sd" => array(
        array($err_msg, "required"),
        array($err_msg, "regex", "/^[0-9]+$/")
    ),
    "ey" => array(
        array($err_msg, "required"),
        array($err_msg, "regex", "/^[0-9]+$/")
    ),
    "em" => array(
        array($err_msg, "required"),
        array($err_msg, "regex", "/^[0-9]+$/")
    ),
    "ed" => array(
        array($err_msg, "required"),
        array($err_msg, "regex", "/^[0-9]+$/")
    )
));
// ■日付としての妥当性チェック
$form->registerRule("check_date_qf2", "function", "Check_Date_Qf2");
$form->addRule("form_count_date", $err_msg, "check_date_qf2");

// ■前回の月次締日（orシステム開始日）以降かチェック
if ($close_date_plus != null && $_POST["form_show_button"] != null){
    if ($close_date_plus > $_POST["form_count_date"]["sy"]."-".$_POST["form_count_date"]["sm"]."-".$_POST["form_count_date"]["sd"]){
        $form->setElementError("form_count_date", $err_msg);
    }
    if ($close_date_plus > $_POST["form_count_date"]["ey"]."-".$_POST["form_count_date"]["em"]."-".$_POST["form_count_date"]["ed"]){
        $form->setElementError("form_count_date", $err_msg);
    }
}elseif ($sys_start_date != null && $_POST["form_show_button"] != null){
    if ($sys_start_date > $_POST["form_count_date"]["sy"]."-".$_POST["form_count_date"]["sm"]."-".$_POST["form_count_date"]["sd"]){
        $form->setElementError("form_count_date", $err_msg);
    }
    if ($sys_start_date > $_POST["form_count_date"]["ey"]."-".$_POST["form_count_date"]["em"]."-".$_POST["form_count_date"]["ed"]){
        $form->setElementError("form_count_date", $err_msg);
    }
}

/****************************/
// addRule適用結果収集
/****************************/
/*** チェック適用 ***/
$form->validate();

/****************************/
// addRule適用結果収集
/****************************/
/*** チェック適用 ***/
$form->validate();

/*** 結果集計 ***/
// エラーのあるフォームのフォーム名を格納するための配列を作成
$ary_addrule_err_forms = array();
// エラーのあるフォームのフォーム名を配列に格納
foreach ($form as $key1 => $value1){
    if ($key1 == "_errors"){
        foreach ($value1 as $key2 => $value2){
            $ary_addrule_err_forms[] = $key2;
        }
    }
}

/****************************/
// エラーチェック(AddRule)
/****************************/
/*** 集計期間 ***/
// ■前回の月次更新日以前の日付は駄目
// addRuleでエラーがない ＆ 月次締日がある ＆ 表示ボタンが押された ＆ フォーム値＜月次締日
if (!in_array("form_count_date", $ary_addrule_err_forms) && $close_date_plus != null && $_POST["form_show_button"] != null &&
        ($close_date_plus > $_POST["form_count_date"]["sy"]."-".$_POST["form_count_date"]["sm"]."-".$_POST["form_count_date"]["sd"] ||
         $close_date_plus > $_POST["form_count_date"]["ey"]."-".$_POST["form_count_date"]["em"]."-".$_POST["form_count_date"]["ed"])
    ){
    $form->setElementError("form_count_date", "集計期間に 前回の月次締日より前の日付が指定されています");
}

/****************************
// 全エラーチェック結果集計
/****************************/
if ($_POST["form_show_button"] != null){

    /*** 結果集計 ***/
    // エラーのあるフォームのフォーム名を格納するための配列を作成
    $ary_all_err_forms = array();
    // エラーのあるフォームのフォーム名を配列に格納
    foreach ($form as $key1 => $value1){
        if ($key1 == "_errors"){
            foreach ($value1 as $key2 => $value2){
                $ary_all_err_forms[] = $key2;
            }
        }
    }
    // エラー件数が0件の場合は確認フラグをtrueにする
    $verify_flg = (count($ary_all_err_forms) == 0) ? true : false;

}


/****************************/
// 表示フラグ
/****************************/
// エラーの場合は一覧表は表示しない用にするフラグ
if ($_POST["form_show_button"] != null && $verify_flg != true){
    $select_query_flg   = false;
    $all_query_flg      = false;
}else{
    $select_query_flg   = true;
    $all_query_flg      = true;
}

// 集計期間作成
if ($verify_flg == true){
    $count_date_s = $_POST["form_count_date"]["sy"]."-".$_POST["form_count_date"]["sm"]."-".$_POST["form_count_date"]["sd"];
    $count_date_e = $_POST["form_count_date"]["ey"]."-".$_POST["form_count_date"]["em"]."-".$_POST["form_count_date"]["ed"];
}else{
    $count_date_s = date("Y-m-d");
    $count_date_e = date("Y-m-d");
}

/****************************/
// 選択されたオペレータのIDを取得
/****************************/
// 表示ボタンが押下された場合
if ($_POST["form_show_button"] != null){

    // 特定のスタッフが選択された場合
    if ($_POST["form_e_staff_slct"] != null){
        // 選択されたスタッフのIDを配列へ
        $ary_select_e_staff_id[]    = $_POST["form_e_staff_slct"];
        $select_staff_csv           = $_POST["form_e_staff_slct"];
        $all_staff_csv = null;
        foreach ($select_value as $key => $value){
            if ($key != null){
                $all_staff_csv = ($all_staff_csv != null) ? $all_staff_csv.", ".$key : $key;
            }
        }
    // スタッフ選択がNULLの場合
    }else{
        // プルダウン内のスタッフのIDをを全て配列へ
        $all_staff_csv      = null;
        $select_staff_csv   = null;
        foreach ($select_value as $key => $value){
            if ($key != null){
                $ary_select_e_staff_id[] = $key;
                $select_staff_csv = $all_staff_csv = ($select_staff_csv != null) ? $select_staff_csv.", ".$key : $key;
            }
        }
    }

// 表示ボタンが押下されていない（デフォルト表示）の場合
}else{

    #2010-04-27 hashimoto-y
    #// プルダウン内のスタッフのIDをを全て配列へ
    #$all_staff_csv      = null;
    #$select_staff_csv   = null;
    #foreach ($select_value as $key => $value){
    #    if ($key != null){
    #        $ary_select_e_staff_id[] = $key;
    #        $select_staff_csv = $all_staff_csv = ($select_staff_csv != null) ? $select_staff_csv.", ".$key : $key;
    #    }
    #}

    $ary_select_e_staff_id[]    = $_SESSION["staff_id"];
    $select_staff_csv           = $_SESSION["staff_id"];
    $all_staff_csv = null;
    foreach ($select_value as $key => $value){
        if ($key != null){
            $all_staff_csv = ($all_staff_csv != null) ? $all_staff_csv.", ".$key : $key;
        }
    }

}


/****************************/
// 一覧用データ取得
/****************************/
// オペレータ選択フラグがtrueの場合
if ($select_query_flg == true){

    /****************************/
    // 売上（オペレータ別）
    /****************************/
    $sql  = "SELECT \n";
    $sql .= "   t_attach_e_staff.e_staff_id, \n";
    $sql .= "   t_attach_e_staff.e_staff_name, \n";
    $sql .= "   t_sale_data.c_part_id, \n";
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_sale_data.act_id IS NULL ";
    $sql .= "       THEN t_sale_data.c_staff_name \n";
    $sql .= "       ELSE t_sale_data.act_cname \n";
    $sql .= "   END \n";
    $sql .= "   AS c_staff_name, \n";
    $sql .= "   t_sale_data.sale_day AS sale_day, \n";
    $sql .= "   SUM( \n";
    $sql .= "       CASE \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 61 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.net_amount, 0) * 1 \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 63 OR \n";
    $sql .= "               t_sale_data.trade_id = 64 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.net_amount, 0) * -1 \n";
    $sql .= "           ELSE 0 \n";
    $sql .= "       END \n";
    $sql .= "   ) AS sum_genkin_net_amount, \n";
    $sql .= "   SUM( \n";
    $sql .= "       CASE \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 11 OR \n";
    $sql .= "               t_sale_data.trade_id = 15 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.net_amount, 0) * 1 \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 13 OR \n";
    $sql .= "               t_sale_data.trade_id = 14 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.net_amount, 0) * -1 \n";
    $sql .= "           ELSE 0 \n";
    $sql .= "       END \n";
    $sql .= "   ) AS sum_kake_net_amount, \n";
    $sql .= "   SUM( \n";
    $sql .= "       CASE \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 11 OR \n";
    $sql .= "               t_sale_data.trade_id = 15 OR \n";
    $sql .= "               t_sale_data.trade_id = 61 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.net_amount, 0) * 1 \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 13 OR \n";
    $sql .= "               t_sale_data.trade_id = 14 OR \n";
    $sql .= "               t_sale_data.trade_id = 63 OR \n";
    $sql .= "               t_sale_data.trade_id = 64 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.net_amount, 0) * -1 \n";
    $sql .= "           ELSE 0 \n";
    $sql .= "       END \n";
    $sql .= "   ) AS sum_all_net_amount, \n";
    $sql .= "   SUM( \n";
    $sql .= "       CASE \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 61 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.tax_amount, 0) * 1 \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 63 OR \n";
    $sql .= "               t_sale_data.trade_id = 64 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.tax_amount, 0) * -1 \n";
    $sql .= "           ELSE 0 \n";
    $sql .= "       END \n";
    $sql .= "   ) AS sum_genkin_tax_amount, \n";
    $sql .= "   SUM( \n";
    $sql .= "       CASE \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 11 OR \n";
    $sql .= "               t_sale_data.trade_id = 15 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.tax_amount, 0) * 1 \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 13 OR \n";
    $sql .= "               t_sale_data.trade_id = 14 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.tax_amount, 0) * -1 \n";
    $sql .= "           ELSE 0 \n";
    $sql .= "       END \n";
    $sql .= "   ) AS sum_kake_tax_amount, \n";
    $sql .= "   SUM( \n";
    $sql .= "       CASE \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 61 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.total_amount, 0) * 1 \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 63 OR \n";
    $sql .= "               t_sale_data.trade_id = 64 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.total_amount, 0) * -1 \n";
    $sql .= "           ELSE 0 \n";
    $sql .= "       END \n";
    $sql .= "   ) AS sum_genkin_total_amount, \n";
    $sql .= "   SUM( \n";
    $sql .= "       CASE \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 11 OR \n";
    $sql .= "               t_sale_data.trade_id = 15 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.total_amount, 0) * 1 \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 13 OR \n";
    $sql .= "               t_sale_data.trade_id = 14 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.total_amount, 0) * -1 \n";
    $sql .= "           ELSE 0 \n";
    $sql .= "       END \n";
    $sql .= "   ) AS sum_kake_total_amount, \n";
    $sql .= "   SUM( \n";
    $sql .= "       CASE \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 11 OR \n";
    $sql .= "               t_sale_data.trade_id = 15 OR \n";
    $sql .= "               t_sale_data.trade_id = 61 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.total_amount, 0) * 1 \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 13 OR \n";
    $sql .= "               t_sale_data.trade_id = 14 OR \n";
    $sql .= "               t_sale_data.trade_id = 63 OR \n";
    $sql .= "               t_sale_data.trade_id = 64 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.total_amount, 0) * -1 \n";
    $sql .= "           ELSE 0 \n";
    $sql .= "       END \n";
    $sql .= "   ) AS sum_all_amount, \n";
    $sql .= "   SUM( \n";
    $sql .= "       CASE \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 11 OR \n";
    $sql .= "               t_sale_data.trade_id = 15 OR \n";
    $sql .= "               t_sale_data.trade_id = 61 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.margin, 0) * 1 \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 13 OR \n";
    $sql .= "               t_sale_data.trade_id = 14 OR \n";
    $sql .= "               t_sale_data.trade_id = 63 OR \n";
    $sql .= "               t_sale_data.trade_id = 64 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.margin, 0) * -1 \n";
    $sql .= "           ELSE 0 \n";
    $sql .= "       END \n";
    $sql .= "   ) AS sum_margin \n";
    $sql .= "FROM \n";
    // オペレータ
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_attach.staff_id AS e_staff_id, \n";
    $sql .= "           t_staff.staff_name AS e_staff_name, \n";
    $sql .= "           t_staff.charge_cd AS e_charge_cd \n";
    $sql .= "       FROM \n";
    $sql .= "           t_attach \n";
    $sql .= "           INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_attach.staff_id IN (".$select_staff_csv.")\n";
    $sql .= "       AND \n";
    $sql .= "           t_attach.shop_id = $shop_id ";
    $sql .= "   ) \n";
    $sql .= "   AS t_attach_e_staff \n";
    // 売上ヘッダ
    $sql .= "   INNER JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_sale_h.e_staff_id, \n";
    $sql .= "           t_sale_h.e_staff_name, \n";
    $sql .= "           t_attach_c_staff.part_id AS c_part_id, \n";
    $sql .= "           t_staff_c_staff.charge_cd AS c_charge_cd, \n";
    $sql .= "           t_staff_c_staff.staff_name AS c_staff_name, \n";
    $sql .= "           t_sale_h.sale_day, \n";
    $sql .= "           t_sale_h.trade_id, \n";
    $sql .= "           COALESCE(t_sale_h.net_amount, 0) AS net_amount, \n";
    $sql .= "           COALESCE(t_sale_h.tax_amount, 0) AS tax_amount, \n";
    $sql .= "           COALESCE(t_sale_h.net_amount, 0) + COALESCE(t_sale_h.tax_amount, 0) AS total_amount, \n";
    $sql .= "           COALESCE(t_sale_h.margin_amount, 0) AS margin, \n";
    $sql .= "           t_sale_h_act.act_id, \n";
    $sql .= "           t_client_act.client_cname AS act_cname \n";
    $sql .= "       FROM \n";

        // ここから
    $sql .= "           ( \n";
    $ary_main_sub = array("main", "sub1", "sub2", "sub3");
    foreach ($ary_main_sub as $key => $value){
        $sql .= "               ( \n";
        $sql .= "                   SELECT \n";
        $sql .= "                       t_sale_h_amount.sale_id, \n";
        $sql .= "                       t_sale_h_amount.e_staff_id, \n";
        $sql .= "                       t_sale_h_amount.e_staff_name, \n";
        $sql .= "                       t_sale_h_amount.sale_day, \n";
        $sql .= "                       t_sale_h_amount.trade_id, \n";
        $sql .= "                       t_sale_h_amount.enter_day, \n";
        $sql .= "                       t_sale_h_amount.shop_id, \n";
        // むりやり
        $sql .= "                       CASE \n";
        $sql .= "                           WHEN \n";
        $sql .= "                               t_sale_h_amount.".$value."_staff_id IN \n";
        $sql .= "                               (SELECT staff_id FROM t_attach WHERE shop_id = $shop_id) \n";
        $sql .= "                           THEN \n";
        $sql .= "                               t_sale_h_amount.".$value."_staff_id \n";
        $sql .= "                           ELSE NULL \n";
        $sql .= "                       END \n";
        $sql .= "                       AS c_staff_id, \n";
//        $sql .= "                       t_sale_h_amount.".$value."_staff_id AS c_staff_id, \n";
        $sql .= "                       t_sale_h_amount.".$value."_net_amount AS net_amount, \n";
        $sql .= "                       t_sale_h_amount.".$value."_tax_amount AS tax_amount, \n";
        $sql .= "                       t_sale_h_amount.".$value."_total_amount AS total_amount, \n";
        $sql .= "                       t_sale_h_amount.".$value."_margin_amount AS margin_amount \n";
        $sql .= "                   FROM t_sale_h_amount \n";
        if ($key != 0){
        $sql .= "                       INNER JOIN t_sale_staff ON  t_sale_h_amount.sale_id = t_sale_staff.sale_id \n";
        $sql .= "                                               AND t_sale_h_amount.".$value."_staff_id = t_sale_staff.staff_id \n";
        $sql .= "                                               AND t_sale_staff.sale_rate IS NOT NULL \n";
        }
        if ($count_type == "1"){
        $sql .= "                   WHERE \n";
        $sql .= "                       t_sale_h_amount.enter_day >= '$count_date_s 00:00:00' \n";
        $sql .= "                   AND \n";
        $sql .= "                       t_sale_h_amount.enter_day <= '$count_date_e 23:59:59' \n";
        }else{
        $sql .= "                   WHERE \n";
        $sql .= "                       t_sale_h_amount.sale_day >= '$count_date_s 00:00:00' \n";
        $sql .= "                   AND \n";
        $sql .= "                       t_sale_h_amount.sale_day <= '$count_date_e 23:59:59' \n";
        }
        $sql .= "                   AND \n";
        $sql .= "                       t_sale_h_amount.shop_id = $shop_id \n";
        $sql .= "               ) \n";
        $sql .= ($key+1 < count($ary_main_sub)) ? " UNION ALL \n" : null;
    }
    $sql .= "           ) \n";
    $sql .= "           AS \n";
        // ここまで

    $sql .= "           t_sale_h \n";
    $sql .= "           LEFT JOIN t_attach AS t_attach_c_staff \n";
    $sql .= "           ON t_sale_h.c_staff_id = t_attach_c_staff.staff_id \n";
    $sql .= "           AND t_sale_h.shop_id = t_attach_c_staff.shop_id \n";
    $sql .= "           LEFT JOIN t_staff AS t_staff_c_staff\n";
    $sql .= "           ON t_sale_h.c_staff_id = t_staff_c_staff.staff_id \n";
    $sql .= "           LEFT JOIN t_sale_h AS t_sale_h_act ON t_sale_h.sale_Id = t_sale_h_act.sale_id \n";
    $sql .= "           LEFT JOIN t_client AS t_client_act ON t_sale_h_act.act_id = t_client_act.client_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_sale_h.shop_id = $shop_id \n";
    if ($count_type == "1"){
    $sql .= "       AND \n";
    $sql .= "           t_sale_h.enter_day >= '$count_date_s 00:00:00' \n";
    $sql .= "       AND \n";
    $sql .= "           t_sale_h.enter_day <= '$count_date_e 23:59:59' \n";
    }else{
    $sql .= "       AND \n";
    $sql .= "           t_sale_h.sale_day >= '$count_date_s 00:00:00' \n";
    $sql .= "       AND \n";
    $sql .= "           t_sale_h.sale_day <= '$count_date_e 23:59:59' \n";
    }
    $sql .= "       AND \n";
    $sql .= "           (t_staff_c_staff.charge_cd IS NOT NULL OR t_sale_h_act.act_id IS NOT NULL) \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_sale_data \n";
    $sql .= "   ON t_attach_e_staff.e_staff_id = t_sale_data.e_staff_id \n";
    // 条件
    $sql .= "GROUP BY \n";
    $sql .= "   t_attach_e_staff.e_staff_id, \n";
    $sql .= "   t_attach_e_staff.e_staff_name, \n";
    $sql .= "   t_sale_data.c_part_id, \n";
    $sql .= "   t_sale_data.c_charge_cd, \n";
    $sql .= "   t_sale_data.c_staff_name, \n";
    $sql .= "   t_sale_data.sale_day, \n";
    $sql .= "   t_attach_e_staff.e_charge_cd, \n";
    $sql .= "   t_sale_data.act_id, \n";
    $sql .= "   t_sale_data.act_cname \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_attach_e_staff.e_charge_cd, \n";
    $sql .= "   t_attach_e_staff.e_staff_id, \n";
    $sql .= "   t_sale_data.c_part_id, \n";
    $sql .= "   t_sale_data.c_charge_cd, \n";
    $sql .= "   t_sale_data.c_staff_name, \n";
    $sql .= "   t_sale_data.act_cname, \n";
    $sql .= "   t_sale_data.sale_day \n";
    $sql .= ";\n";
    $res  = Db_Query($db_con, $sql);
        while ($ary_res = pg_fetch_array($res)){
            //オペレータ名
            $e_staff_id = $ary_res[e_staff_id];

            $ary_sale_select_data[$e_staff_id][] = $ary_res;
        }

/*
        $num_sale_select = pg_num_rows($res);
        // 取得結果があれば配列に
        if ($num_sale_select > 0){
            $i = 0; 
            while ($ary_res = @pg_fetch_array($res, $i, PGSQL_NUM)){
                foreach ($ary_res as $key => $value){
                    $ary_sale_select_data[$i][$key] = $value;
                }
                $i++;
            }
        }
*/


/*  

    $res  = Db_Query($db_con, $sql);

    $num_buy_select = pg_num_rows($res);
    // 取得結果があれば配列に
    if ($num_buy_select > 0){
        $i = 0; 
        while ($ary_res = @pg_fetch_array($res, $i, PGSQL_NUM)){
            foreach ($ary_res as $key => $value){
                $ary_buy_select_data[$i][$key] = $value;
            }
            $i++;
        }
    }
*/

    /****************************/
    //仕入（オペレータ別）
    /****************************/
    $sql  = "

        SELECT
            t_attach_e_staff.e_staff_id,
            t_attach_e_staff.e_staff_name,
            t_buy_data.c_part_cd,
            t_buy_data.c_staff_name,
            t_buy_data.buy_day,
            t_buy_data.net_genkin,
            t_buy_data.net_kake,
            (t_buy_data.net_genkin + t_buy_data.net_kake) AS net_amount,
            t_buy_data.tax_genkin,
            t_buy_data.tax_kake,
            (t_buy_data.net_genkin + t_buy_data.tax_genkin) AS genkin_amount,
            (t_buy_data.net_kake + t_buy_data.tax_kake) AS kake_amount,
            (t_buy_data.net_genkin + t_buy_data.net_kake + t_buy_data.tax_genkin + t_buy_data.tax_kake) AS all_amount
        FROM 
        ( 
            SELECT 
                t_attach.staff_id AS e_staff_id, 
                t_staff.staff_name AS e_staff_name,
                t_staff.charge_cd AS e_staff_cd
            FROM 
                t_attach 
                INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id 
            WHERE 
                t_attach.staff_id IN ( ".$select_staff_csv .")
            AND 
                t_attach.shop_id = $shop_id
            ORDER BY t_attach.staff_id
        ) AS t_attach_e_staff 
        
        INNER JOIN
        (
        
            SELECT 
            t_buy_h.e_staff_id,
            t_buy_h.e_staff_name,
            t_buy_h.c_staff_id,
            t_buy_h.c_staff_name,
            t_staff.charge_cd AS c_staff_cd,
            t_part.part_cd AS c_part_cd,
            t_buy_h.buy_day,
        
            SUM( 
                CASE
                    WHEN
                        t_buy_h.trade_id = 71
                    THEN
                        COALESCE(t_buy_h.net_amount, 0) * 1
                    WHEN
                        t_buy_h.trade_id = 73 OR
                        t_buy_h.trade_id = 74
                    THEN
                        COALESCE(t_buy_h.net_amount, 0) * -1
                    ELSE 0
                END
            ) AS net_genkin ,
        
            SUM( 
                CASE
                    WHEN
                        t_buy_h.trade_id = 21 OR
                        t_buy_h.trade_id = 25
                    THEN
                        COALESCE(t_buy_h.net_amount, 0) * 1
                    WHEN
                        t_buy_h.trade_id = 23 OR
                        t_buy_h.trade_id = 24
                    THEN
                        COALESCE(t_buy_h.net_amount, 0) * -1
                    ELSE 0
                END
            ) AS net_kake,
        
            SUM( 
                CASE
                    WHEN
                        t_buy_h.trade_id = 71
                    THEN
                        COALESCE(t_buy_h.tax_amount, 0) * 1
                    WHEN
                        t_buy_h.trade_id = 73 OR
                        t_buy_h.trade_id = 74
                    THEN
                        COALESCE(t_buy_h.tax_amount, 0) * -1
                    ELSE 0
                END
            ) AS tax_genkin ,
        
            SUM( 
                CASE
                    WHEN
                        t_buy_h.trade_id = 21 OR
                        t_buy_h.trade_id = 25
                    THEN
                        COALESCE(t_buy_h.tax_amount, 0) * 1
                    WHEN
                        t_buy_h.trade_id = 23 OR
                        t_buy_h.trade_id = 24
                    THEN
                        COALESCE(t_buy_h.tax_amount, 0) * -1
                    ELSE 0
                END
            ) AS tax_kake
        
            --SUM(net_amount) AS 仕入合計,
            --SUM(tax_amount) AS 消費税合計
        
            FROM
            t_buy_h
            LEFT JOIN t_attach
            ON t_buy_h.c_staff_id = t_attach.staff_id
            AND t_buy_h.shop_id = t_attach.shop_id
            LEFT JOIN t_staff
            ON t_buy_h.c_staff_id = t_staff.staff_id
            LEFT JOIN t_part
            ON t_attach.part_id = t_part.part_id
            
            WHERE t_buy_h.shop_id = $shop_id
            AND t_buy_h.".(($count_type == "1") ? "enter_day" : "buy_day")." >= '$count_date_s 00:00:00'
            AND t_buy_h.".(($count_type == "1") ? "enter_day" : "buy_day")." <= '$count_date_e 23:59:59'
            GROUP BY 
            t_buy_h.e_staff_id,
            t_buy_h.e_staff_name,
            t_buy_h.c_staff_id,
            t_buy_h.c_staff_name,
            t_staff.charge_cd,
            t_part.part_cd,
            t_buy_h.buy_day
            
            ORDER BY t_buy_h.c_staff_id,t_buy_h.buy_day
        ) AS t_buy_data
        ON t_attach_e_staff.e_staff_id = t_buy_data.e_staff_id
        
        ORDER BY 
        t_attach_e_staff.e_staff_cd,
        t_buy_data.c_part_cd,
        t_buy_data.c_staff_cd,
        t_buy_data.buy_day
    ";
    $res  = Db_Query($db_con, $sql);
        while ($ary_res = pg_fetch_array($res)){
            //オペレータ名
            $e_staff_id = $ary_res[e_staff_id];
            
            $ary_buy_select_data[$e_staff_id][] = $ary_res;
        }

    /****************************/
    //入金（オペレータ別）
    /****************************/
    $sql  = "
            SELECT 
               t_attach_e_staff.e_staff_id, 
               t_payin_data.pay_day,
               t_payin_data.payin_31,
               t_payin_data.payin_32,
               t_payin_data.payin_33,
               t_payin_data.payin_another,
               t_payin_data.payin_35
            
            FROM 
            ( 
                SELECT 
                    t_attach.staff_id AS e_staff_id, 
                    t_staff.charge_cd AS e_charge_cd 
                FROM 
                    t_attach 
                    INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id 
                WHERE 
                    t_attach.staff_id IN ($select_staff_csv)
                AND 
                    t_attach.shop_id = $shop_id
                ORDER BY t_attach.staff_id
            ) AS t_attach_e_staff 
            
            INNER JOIN 
            (
                SELECT 
                    t_payin_h.e_staff_id,
                    t_payin_h.pay_day, 
            
                    SUM( 
                        CASE t_payin_d.trade_id 
                            WHEN 31 THEN t_payin_d.amount 
                            ELSE 0 
                        END
                    ) AS payin_31, 
            
                    SUM(        
                        CASE t_payin_d.trade_id 
                            WHEN 32 THEN t_payin_d.amount 
                            ELSE 0 
                        END 
                    ) AS payin_32, 
            
                    SUM( 
                        CASE t_payin_d.trade_id 
                            WHEN 33 THEN t_payin_d.amount 
                            ELSE 0 
                        END 
                    ) AS payin_33, 
            
                    SUM( 
                        CASE t_payin_d.trade_id 
                            WHEN 34 THEN t_payin_d.amount 
                            WHEN 36 THEN t_payin_d.amount 
                            WHEN 37 THEN t_payin_d.amount 
                            WHEN 38 THEN t_payin_d.amount 
                            ELSE 0 
                        END 
                    ) AS payin_another, 
            
                    SUM( 
                        CASE t_payin_d.trade_id 
                            WHEN 35 THEN t_payin_d.amount 
                            ELSE 0 
                        END 
                    ) AS payin_35
            
                FROM 
                    t_payin_h 
                    LEFT JOIN t_payin_d 
                    ON t_payin_h.pay_id = t_payin_d.pay_id 
                WHERE 
                    t_payin_h.shop_id = $shop_id
                AND 
                    t_payin_h.".(($count_type == "1") ? "enter_day" : "pay_day")." >= '$count_date_s 00:00:00' 
                AND
                    t_payin_h.".(($count_type == "1") ? "enter_day" : "pay_day")." <= '$count_date_e 23:59:59' 
                AND 
                    t_payin_h.sale_id IS NULL
                AND 
                    t_payin_h.e_staff_id IN ( $select_staff_csv )
                GROUP BY 
                    t_payin_h.e_staff_id,
                    t_payin_h.pay_day
                ORDER BY 
                    t_payin_h.e_staff_id,
                    t_payin_h.pay_day
            ) AS t_payin_data 
            ON t_attach_e_staff.e_staff_id = t_payin_data.e_staff_id
            ORDER BY 
               t_attach_e_staff.e_charge_cd, 
               t_attach_e_staff.e_staff_id, 
               t_payin_data.pay_day 
            ;
        ";
        $res  = Db_Query($db_con, $sql);
        while ($ary_res = pg_fetch_array($res)){
            //オペレータ名
            $e_staff_id = $ary_res[e_staff_id];
            
            $ary_payin_select_data[$e_staff_id][] = $ary_res;
        }

/*
        $num_payin_select = pg_num_rows($res);
        if ($num_payin_select > 0){
            $i = 0; 
            while ($ary_res = @pg_fetch_array($res, $i, PGSQL_NUM)){
                foreach ($ary_res as $key => $value){
                    $ary_payin_select_data[$i][$key] = $value;
                }
                $i++;
            }
        }

*/


    /****************************/
    //支払（オペレータ別）
    /****************************/
    $sql  = "
            SELECT 
               t_attach_e_staff.e_staff_id, 
               t_payout_data.pay_day,
               t_payout_data.payout_41,
               t_payout_data.payout_43,
               t_payout_data.payout_44,
               t_payout_data.payout_another,
               t_payout_data.payout_48
            
            FROM 
            ( 
                SELECT 
                    t_attach.staff_id AS e_staff_id, 
                    t_staff.charge_cd AS e_charge_cd 
                FROM 
                    t_attach 
                    INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id 
                WHERE 
                    t_attach.staff_id IN ($select_staff_csv)
                AND 
                    t_attach.shop_id = $_SESSION[client_id]
                ORDER BY t_attach.staff_id
            ) AS t_attach_e_staff 
            
            INNER JOIN 
            (
                SELECT 
                    t_payout_h.e_staff_id,
                    t_payout_h.pay_day, 
            
                    SUM( 
                        CASE t_payout_d.trade_id 
                            WHEN 41 THEN t_payout_d.pay_amount 
                            ELSE 0 
                        END 
                    ) AS payout_41, 
            
                    SUM(        
                        CASE t_payout_d.trade_id 
                            WHEN 43 THEN t_payout_d.pay_amount 
                            ELSE 0 
                        END 
                    ) AS payout_43, 
            
                    SUM( 
                        CASE t_payout_d.trade_id 
                            WHEN 44 THEN t_payout_d.pay_amount 
                            ELSE 0 
                        END 
                    ) AS payout_44, 
            
                    SUM( 
                        CASE t_payout_d.trade_id 
                            WHEN 45 THEN t_payout_d.pay_amount 
                            WHEN 46 THEN t_payout_d.pay_amount 
                            WHEN 47 THEN t_payout_d.pay_amount 
                            ELSE 0 
                        END 
                    ) AS payout_another, 
            
                    SUM( 
                        CASE t_payout_d.trade_id 
                            WHEN 48 THEN t_payout_d.pay_amount 
                            ELSE 0 
                        END 
                    ) AS payout_48
            
                FROM 
                    t_payout_h 
                    LEFT JOIN t_payout_d 
                    ON t_payout_h.pay_id = t_payout_d.pay_id 
                WHERE 
                    t_payout_h.shop_id = $shop_id
                AND 
                    t_payout_h.buy_id IS NULL
                AND 
                    t_payout_h.".(($count_type == "1") ? "enter_day" : "pay_day")." >= '$count_date_s 00:00:00' 
                AND 
                    t_payout_h.".(($count_type == "1") ? "enter_day" : "pay_day")." <= '$count_date_e 23:59:59' 
                AND 
                    t_payout_h.e_staff_id IN ( $select_staff_csv )
            
                GROUP BY 
                    t_payout_h.e_staff_id,
                    t_payout_h.pay_day
                ORDER BY 
                    t_payout_h.e_staff_id,
                    t_payout_h.pay_day
            ) AS t_payout_data 
            ON t_attach_e_staff.e_staff_id = t_payout_data.e_staff_id
            ORDER BY 
               t_attach_e_staff.e_charge_cd, 
               t_attach_e_staff.e_staff_id, 
               t_payout_data.pay_day 
            ;
        ";
        $res  = Db_Query($db_con, $sql);
        while ($ary_res = pg_fetch_array($res)){
            //オペレータ名
            $e_staff_id = $ary_res[e_staff_id];
            
            $ary_payout_select_data[$e_staff_id][] = $ary_res;
        }

/*      $num_payout_select = pg_num_rows($res);
        if ($num_payout_select > 0){
            $i = 0; 
            while ($ary_res = @pg_fetch_array($res, $i, PGSQL_NUM)){
                foreach ($ary_res as $key => $value){
                    $ary_payout_select_data[$i][$key] = $value;
                }
                $i++;
            }
        }*/

}

if ($all_query_flg == true){
        /****************************/
        //売上（全社）
        /****************************/
    $sql  = "SELECT \n";
    $sql .= "   NULL, \n";
    $sql .= "   '全社', \n";
    $sql .= "   t_sale_data.c_part_id, \n";
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_sale_data.act_id IS NULL ";
    $sql .= "       THEN t_sale_data.c_staff_name \n";
    $sql .= "       ELSE t_sale_data.act_cname \n";
    $sql .= "   END \n";
    $sql .= "   AS c_staff_name, \n";
    $sql .= "   t_sale_data.sale_day AS sale_day, \n";
    $sql .= "   SUM( \n";
    $sql .= "       CASE \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 61 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.net_amount, 0) * 1 \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 63 OR \n";
    $sql .= "               t_sale_data.trade_id = 64 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.net_amount, 0) * -1 \n";
    $sql .= "           ELSE 0 \n";
    $sql .= "       END \n";
    $sql .= "   ) AS sum_genkin_net_amount, \n";
    $sql .= "   SUM( \n";
    $sql .= "       CASE \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 11 OR \n";
    $sql .= "               t_sale_data.trade_id = 15 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.net_amount, 0) * 1 \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 13 OR \n";
    $sql .= "               t_sale_data.trade_id = 14 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.net_amount, 0) * -1 \n";
    $sql .= "           ELSE 0 \n";
    $sql .= "       END \n";
    $sql .= "   ) AS sum_kake_net_amount, \n";
    $sql .= "   SUM( \n";
    $sql .= "       CASE \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 11 OR \n";
    $sql .= "               t_sale_data.trade_id = 15 OR \n";
    $sql .= "               t_sale_data.trade_id = 61 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.net_amount, 0) * 1 \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 13 OR \n";
    $sql .= "               t_sale_data.trade_id = 14 OR \n";
    $sql .= "               t_sale_data.trade_id = 63 OR \n";
    $sql .= "               t_sale_data.trade_id = 64 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.net_amount, 0) * -1 \n";
    $sql .= "           ELSE 0 \n";
    $sql .= "       END \n";
    $sql .= "   ) AS sum_all_net_amount, \n";
    $sql .= "   SUM( \n";
    $sql .= "       CASE \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 61 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.tax_amount, 0) * 1 \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 63 OR \n";
    $sql .= "               t_sale_data.trade_id = 64 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.tax_amount, 0) * -1 \n";
    $sql .= "           ELSE 0 \n";
    $sql .= "       END \n";
    $sql .= "   ) AS sum_genkin_tax_amount, \n";
    $sql .= "   SUM( \n";
    $sql .= "       CASE \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 11 OR \n";
    $sql .= "               t_sale_data.trade_id = 15 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.tax_amount, 0) * 1 \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 13 OR \n";
    $sql .= "               t_sale_data.trade_id = 14 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.tax_amount, 0) * -1 \n";
    $sql .= "           ELSE 0 \n";
    $sql .= "       END \n";
    $sql .= "   ) AS sum_kake_tax_amount, \n";
    $sql .= "   SUM( \n";
    $sql .= "       CASE \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 61 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.total_amount, 0) * 1 \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 63 OR \n";
    $sql .= "               t_sale_data.trade_id = 64 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.total_amount, 0) * -1 \n";
    $sql .= "           ELSE 0 \n";
    $sql .= "       END \n";
    $sql .= "   ) AS sum_genkin_total_amount, \n";
    $sql .= "   SUM( \n";
    $sql .= "       CASE \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 11 OR \n";
    $sql .= "               t_sale_data.trade_id = 15 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.total_amount, 0) * 1 \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 13 OR \n";
    $sql .= "               t_sale_data.trade_id = 14 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.total_amount, 0) * -1 \n";
    $sql .= "           ELSE 0 \n";
    $sql .= "       END \n";
    $sql .= "   ) AS sum_kake_total_amount, \n";
    $sql .= "   SUM( \n";
    $sql .= "       CASE \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 11 OR \n";
    $sql .= "               t_sale_data.trade_id = 15 OR \n";
    $sql .= "               t_sale_data.trade_id = 61 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.total_amount, 0) * 1 \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 13 OR \n";
    $sql .= "               t_sale_data.trade_id = 14 OR \n";
    $sql .= "               t_sale_data.trade_id = 63 OR \n";
    $sql .= "               t_sale_data.trade_id = 64 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.total_amount, 0) * -1 \n";
    $sql .= "           ELSE 0 \n";
    $sql .= "       END \n";
    $sql .= "   ) AS sum_all_amount, \n";
    $sql .= "   SUM( \n";
    $sql .= "       CASE \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 11 OR \n";
    $sql .= "               t_sale_data.trade_id = 15 OR \n";
    $sql .= "               t_sale_data.trade_id = 61 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.margin, 0) * 1 \n";
    $sql .= "           WHEN \n";
    $sql .= "               t_sale_data.trade_id = 13 OR \n";
    $sql .= "               t_sale_data.trade_id = 14 OR \n";
    $sql .= "               t_sale_data.trade_id = 63 OR \n";
    $sql .= "               t_sale_data.trade_id = 64 \n";
    $sql .= "           THEN \n";
    $sql .= "               COALESCE(t_sale_data.margin, 0) * -1 \n";
    $sql .= "           ELSE 0 \n";
    $sql .= "       END \n";
    $sql .= "   ) AS sum_margin \n";
    $sql .= "FROM \n";
    // オペレータ
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_attach.staff_id AS e_staff_id, \n";
    $sql .= "           t_staff.staff_name AS e_staff_name, \n";
    $sql .= "           t_staff.charge_cd AS e_charge_cd \n";
    $sql .= "       FROM \n";
    $sql .= "           t_attach \n";
    $sql .= "           INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_attach.staff_id IN (".$all_staff_csv.")\n";
    $sql .= "       AND \n";
    $sql .= "           t_attach.shop_id = $shop_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_attach_e_staff \n";
    // 売上ヘッダ
    $sql .= "   INNER JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_sale_h.e_staff_id, \n";
    $sql .= "           t_sale_h.e_staff_name, \n";
    $sql .= "           t_attach_c_staff.part_id AS c_part_id, \n";
    $sql .= "           t_staff_c_staff.charge_cd AS c_charge_cd, \n";
    $sql .= "           t_staff_c_staff.staff_name AS c_staff_name, \n";
    $sql .= "           t_sale_h.sale_day, \n";
    $sql .= "           t_sale_h.trade_id, \n";
    $sql .= "           COALESCE(t_sale_h.net_amount, 0) AS net_amount, \n";
    $sql .= "           COALESCE(t_sale_h.tax_amount, 0) AS tax_amount, \n";
    $sql .= "           COALESCE(t_sale_h.net_amount, 0) + COALESCE(t_sale_h.tax_amount, 0) AS total_amount, \n";
    $sql .= "           COALESCE(t_sale_h.margin_amount, 0) AS margin, \n";
    $sql .= "           t_sale_h_act.act_id, \n";
    $sql .= "           t_client_act.client_cname AS act_cname \n";
    $sql .= "       FROM \n";

        // ここから
    $sql .= "           ( \n";
    $ary_main_sub = array("main", "sub1", "sub2", "sub3");
    foreach ($ary_main_sub as $key => $value){
        $sql .= "               ( \n";
        $sql .= "                   SELECT \n";
        $sql .= "                       t_sale_h_amount.sale_id, \n";
        $sql .= "                       t_sale_h_amount.e_staff_id, \n";
        $sql .= "                       t_sale_h_amount.e_staff_name, \n";
        $sql .= "                       t_sale_h_amount.sale_day, \n";
        $sql .= "                       t_sale_h_amount.trade_id, \n";
        $sql .= "                       t_sale_h_amount.enter_day, \n";
        $sql .= "                       t_sale_h_amount.shop_id, \n";
        // むりやり
        $sql .= "                       CASE \n";
        $sql .= "                           WHEN \n";
        $sql .= "                               t_sale_h_amount.".$value."_staff_id IN \n";
        $sql .= "                               (SELECT staff_id FROM t_attach WHERE shop_id = $shop_id) \n";
        $sql .= "                           THEN \n";
        $sql .= "                               t_sale_h_amount.".$value."_staff_id \n";
        $sql .= "                           ELSE NULL \n";
        $sql .= "                       END \n";
        $sql .= "                       AS c_staff_id, \n";
//        $sql .= "                       t_sale_h_amount.".$value."_staff_id AS c_staff_id, \n";
        $sql .= "                       t_sale_h_amount.".$value."_net_amount AS net_amount, \n";
        $sql .= "                       t_sale_h_amount.".$value."_tax_amount AS tax_amount, \n";
        $sql .= "                       t_sale_h_amount.".$value."_total_amount AS total_amount, \n";
        $sql .= "                       t_sale_h_amount.".$value."_margin_amount AS margin_amount \n";
        $sql .= "                   FROM t_sale_h_amount \n";
        if ($key != 0){
        $sql .= "                       INNER JOIN t_sale_staff ON  t_sale_h_amount.sale_id = t_sale_staff.sale_id \n";
        $sql .= "                                               AND t_sale_h_amount.".$value."_staff_id = t_sale_staff.staff_id \n";
        $sql .= "                                               AND t_sale_staff.sale_rate IS NOT NULL \n";
        }
        if ($count_type == "1"){
        $sql .= "                   WHERE \n";
        $sql .= "                       t_sale_h_amount.enter_day >= '$count_date_s 00:00:00' \n";
        $sql .= "                   AND \n";
        $sql .= "                       t_sale_h_amount.enter_day <= '$count_date_e 23:59:59' \n";
        }else{
        $sql .= "                   WHERE \n";
        $sql .= "                       t_sale_h_amount.sale_day >= '$count_date_s 00:00:00' \n";
        $sql .= "                   AND \n";
        $sql .= "                       t_sale_h_amount.sale_day <= '$count_date_e 23:59:59' \n";
        }
        $sql .= "                   AND \n";
        $sql .= "                       t_sale_h_amount.shop_id = $shop_id \n";
        $sql .= "               ) \n";
        $sql .= ($key+1 < count($ary_main_sub)) ? " UNION ALL \n" : null;
    }
    $sql .= "           ) \n";
    $sql .= "           AS \n";
        // ここまで

    $sql .= "           t_sale_h \n";
    $sql .= "           LEFT JOIN t_attach AS t_attach_c_staff \n";
    $sql .= "           ON t_sale_h.c_staff_id = t_attach_c_staff.staff_id \n";
    $sql .= "           AND t_sale_h.shop_id = t_attach_c_staff.shop_id \n";
    $sql .= "           LEFT JOIN t_staff AS t_staff_c_staff\n";
    $sql .= "           ON t_sale_h.c_staff_id = t_staff_c_staff.staff_id \n";
    $sql .= "           LEFT JOIN t_sale_h AS t_sale_h_act ON t_sale_h.sale_Id = t_sale_h_act.sale_id \n";
    $sql .= "           LEFT JOIN t_client AS t_client_act ON t_sale_h_act.act_id = t_client_act.client_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_sale_h.shop_id = $shop_id \n";
    if ($count_type == "1"){
    $sql .= "       AND \n";
    $sql .= "           t_sale_h.enter_day >= '$count_date_s 00:00:00' \n";
    $sql .= "       AND \n";
    $sql .= "           t_sale_h.enter_day <= '$count_date_e 23:59:59' \n";
    }else{
    $sql .= "       AND \n";
    $sql .= "           t_sale_h.sale_day >= '$count_date_s 00:00:00' \n";
    $sql .= "       AND \n";
    $sql .= "           t_sale_h.sale_day <= '$count_date_e 23:59:59' \n";
    }
    $sql .= "       AND \n";
    $sql .= "           (t_staff_c_staff.charge_cd IS NOT NULL OR t_sale_h_act.act_id IS NOT NULL) \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_sale_data \n";
    $sql .= "   ON t_attach_e_staff.e_staff_id = t_sale_data.e_staff_id \n";
    // 条件
    $sql .= "GROUP BY \n";
    $sql .= "   t_sale_data.c_part_id, \n";
    $sql .= "   t_sale_data.c_charge_cd, \n";
    $sql .= "   t_sale_data.c_staff_name, \n";
    $sql .= "   t_sale_data.sale_day, \n";
    $sql .= "   t_attach_e_staff.e_charge_cd, \n";
    $sql .= "   t_sale_data.act_id, \n";
    $sql .= "   t_sale_data.act_cname \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_sale_data.c_part_id, \n";
    $sql .= "   t_sale_data.c_charge_cd, \n";
    $sql .= "   t_sale_data.c_staff_name, \n";
    $sql .= "   t_sale_data.act_cname, \n";
    $sql .= "   t_sale_data.sale_day \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num_sale_all = pg_num_rows($res);

// 取得結果があれば配列に
if ($num_sale_all > 0){
    $i = 0; 
    while ($ary_res = @pg_fetch_array($res, $i, PGSQL_NUM)){
        foreach ($ary_res as $key => $value){
            $ary_sale_all_data[$i][$key] = $value;
        }
        $i++;
    }
}


    /****************************/
    //仕入（全社）
    /****************************/
    $sql  = "
        SELECT
            NULL,
            '全社',
            t_buy_data.c_part_cd,
            t_buy_data.c_staff_name,
            t_buy_data.buy_day,
            SUM(t_buy_data.net_genkin),
            SUM(t_buy_data.net_kake),
            SUM(t_buy_data.net_genkin + t_buy_data.net_kake) AS net_amount,
            SUM(t_buy_data.tax_genkin),
            SUM(t_buy_data.tax_kake),
            SUM(t_buy_data.net_genkin + t_buy_data.tax_genkin) AS genkin_amount,
            SUM(t_buy_data.net_kake + t_buy_data.tax_kake) AS kake_amount,
            SUM(t_buy_data.net_genkin + t_buy_data.net_kake + t_buy_data.tax_genkin + t_buy_data.tax_kake) AS all_amount
        FROM 
        ( 
            SELECT 
                t_attach.staff_id AS e_staff_id, 
                t_staff.staff_name AS e_staff_name,
                t_staff.charge_cd AS e_staff_cd
            FROM 
                t_attach 
                INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id 
            WHERE 
                t_attach.staff_id IN ( $all_staff_csv )
            AND 
                t_attach.shop_id = $shop_id
            ORDER BY t_attach.staff_id
        ) AS t_attach_e_staff 
        
        INNER JOIN
        (
        
            SELECT 
            t_buy_h.e_staff_id,
            t_buy_h.e_staff_name,
            t_buy_h.c_staff_id,
            t_buy_h.c_staff_name,
            t_staff.charge_cd AS c_staff_cd,
            t_part.part_cd AS c_part_cd,
            t_buy_h.buy_day,
        
            SUM( 
                CASE
                    WHEN
                        t_buy_h.trade_id = 71
                    THEN
                        COALESCE(t_buy_h.net_amount, 0) * 1
                    WHEN
                        t_buy_h.trade_id = 73 OR
                        t_buy_h.trade_id = 74
                    THEN
                        COALESCE(t_buy_h.net_amount, 0) * -1
                    ELSE 0
                END
            ) AS net_genkin ,
        
            SUM( 
                CASE
                    WHEN
                        t_buy_h.trade_id = 21 OR
                        t_buy_h.trade_id = 25
                    THEN
                        COALESCE(t_buy_h.net_amount, 0) * 1
                    WHEN
                        t_buy_h.trade_id = 23 OR
                        t_buy_h.trade_id = 24
                    THEN
                        COALESCE(t_buy_h.net_amount, 0) * -1
                    ELSE 0
                END
            ) AS net_kake,
        
            SUM( 
                CASE
                    WHEN
                        t_buy_h.trade_id = 71
                    THEN
                        COALESCE(t_buy_h.tax_amount, 0) * 1
                    WHEN
                        t_buy_h.trade_id = 73 OR
                        t_buy_h.trade_id = 74
                    THEN
                        COALESCE(t_buy_h.tax_amount, 0) * -1
                    ELSE 0
                END
            ) AS tax_genkin ,
        
            SUM( 
                CASE
                    WHEN
                        t_buy_h.trade_id = 21 OR
                        t_buy_h.trade_id = 25
                    THEN
                        COALESCE(t_buy_h.tax_amount, 0) * 1
                    WHEN
                        t_buy_h.trade_id = 23 OR
                        t_buy_h.trade_id = 24
                    THEN
                        COALESCE(t_buy_h.tax_amount, 0) * -1
                    ELSE 0
                END
            ) AS tax_kake
                
            FROM
            t_buy_h
            LEFT JOIN t_attach
            ON t_buy_h.c_staff_id = t_attach.staff_id
            AND t_buy_h.shop_id = t_attach.shop_id
            LEFT JOIN t_staff
            ON t_buy_h.c_staff_id = t_staff.staff_id
            LEFT JOIN t_part
            ON t_attach.part_id = t_part.part_id
            
            WHERE t_buy_h.shop_id = $shop_id
            AND t_buy_h.".(($count_type == "1") ? "enter_day" : "buy_day")." >= '$count_date_s 00:00:00'
            AND t_buy_h.".(($count_type == "1") ? "enter_day" : "buy_day")." <= '$count_date_e 23:59:59'
            GROUP BY 
            t_buy_h.e_staff_id,
            t_buy_h.e_staff_name,
            t_buy_h.c_staff_id,
            t_buy_h.c_staff_name,
            t_staff.charge_cd,
            t_part.part_cd,
            t_buy_h.buy_day
            
            ORDER BY t_buy_h.c_staff_id,t_buy_h.buy_day
        ) AS t_buy_data
        ON t_attach_e_staff.e_staff_id = t_buy_data.e_staff_id
        
        GROUP BY 
            t_buy_data.c_part_cd, 
            t_buy_data.c_staff_cd,  
            t_buy_data.c_staff_name,  
            t_buy_data.buy_day
        
        ORDER BY 
            t_buy_data.c_part_cd,
            t_buy_data.c_staff_cd,
            t_buy_data.buy_day
    ";
    $res  = Db_Query($db_con, $sql);
    $num_buy_all = pg_num_rows($res);
    // 取得結果があれば配列に
    if ($num_buy_all > 0){
        $i = 0; 
        while ($ary_res = @pg_fetch_array($res, $i, PGSQL_NUM)){
            foreach ($ary_res as $key => $value){
                $ary_buy_all_data[$i][$key] = $value;
            }
            $i++;
        }
    }

    
        /****************************/
        //入金（全オペレータ）
        /****************************/
    $sql  = "
            SELECT 
                NULL,
                t_payin_h.pay_day, 
            
                SUM( 
                    CASE t_payin_d.trade_id 
                        WHEN 31 THEN t_payin_d.amount 
                        ELSE 0 
                    END 
                ) AS payin_31, 
            
                SUM(        
                    CASE t_payin_d.trade_id 
                        WHEN 32 THEN t_payin_d.amount 
                        ELSE 0 
                    END 
                ) AS payin_32, 
            
                SUM( 
                    CASE t_payin_d.trade_id 
                        WHEN 33 THEN t_payin_d.amount 
                        ELSE 0 
                    END 
                ) AS payin_33, 
            
                SUM( 
                    CASE t_payin_d.trade_id 
                        WHEN 34 THEN t_payin_d.amount 
                        WHEN 36 THEN t_payin_d.amount 
                        WHEN 37 THEN t_payin_d.amount 
                        WHEN 38 THEN t_payin_d.amount 
                        ELSE 0 
                    END 
                ) AS payin_another, 
            
                SUM( 
                    CASE t_payin_d.trade_id 
                        WHEN 35 THEN t_payin_d.amount 
                        ELSE 0 
                    END 
                ) AS payin_35
            
            
            FROM 
                t_payin_h 
                LEFT JOIN t_payin_d 
                ON t_payin_h.pay_id = t_payin_d.pay_id 
            WHERE 
                t_payin_h.shop_id = $shop_id
            AND 
                t_payin_h.".(($count_type == "1") ? "enter_day" : "pay_day")." >= '$count_date_s 00:00:00' 
            AND 
                t_payin_h.".(($count_type == "1") ? "enter_day" : "pay_day")." <= '$count_date_e 23:59:59' 
            AND 
                t_payin_h.sale_id IS NULL
            AND 
                t_payin_h.e_staff_id IN ( $all_staff_csv )
            GROUP BY 
                t_payin_h.pay_day
            ORDER BY pay_day
            ;

        ";
        $res  = Db_Query($db_con, $sql);
        $num_payin_all = pg_num_rows($res);
        if ($num_payin_all > 0){
            $i = 0; 
            while ($ary_res = @pg_fetch_array($res, $i, PGSQL_NUM)){
                foreach ($ary_res as $key => $value){
                    $ary_payin_all_data[$i][$key] = $value;
                }
                $i++;
            }
        }
        

        /****************************/
        //支払（全オペレータ）
        /****************************/
    $sql  = "
            SELECT 
                NULL,
                t_payout_h.pay_day, 

                SUM( 
                    CASE t_payout_d.trade_id 
                        WHEN 41 THEN t_payout_d.pay_amount 
                        ELSE 0 
                    END 
                ) AS payout_41, 

                SUM(        
                    CASE t_payout_d.trade_id 
                        WHEN 43 THEN t_payout_d.pay_amount 
                        ELSE 0 
                    END 
                ) AS payout_43, 

                SUM( 
                    CASE t_payout_d.trade_id 
                        WHEN 44 THEN t_payout_d.pay_amount 
                        ELSE 0 
                    END 
                ) AS payout_44, 

                SUM( 
                    CASE t_payout_d.trade_id 
                        WHEN 45 THEN t_payout_d.pay_amount 
                        WHEN 46 THEN t_payout_d.pay_amount 
                        WHEN 47 THEN t_payout_d.pay_amount 
                        ELSE 0 
                    END 
                ) AS payout_45, 

                SUM( 
                    CASE t_payout_d.trade_id 
                        WHEN 48 THEN t_payout_d.pay_amount 
                        ELSE 0 
                    END 
                ) AS payout_48

            FROM 
                t_payout_h 
                LEFT JOIN t_payout_d 
                ON t_payout_h.pay_id = t_payout_d.pay_id 
            WHERE 
                t_payout_h.shop_id = $shop_id
            AND 
                t_payout_h.buy_id IS NULL
            AND 
                t_payout_h.".(($count_type == "1") ? "enter_day" : "pay_day")." >= '$count_date_s 00:00:00' 
            AND 
                t_payout_h.".(($count_type == "1") ? "enter_day" : "pay_day")." <= '$count_date_e 23:59:59' 
            AND 
                t_payout_h.e_staff_id IN ( $all_staff_csv )

            GROUP BY 
                t_payout_h.pay_day
            ORDER BY pay_day
        ";

        $res  = Db_Query($db_con, $sql);
        $num_payout_all = pg_num_rows($res);
        if ($num_payout_all > 0){
            $i = 0; 
            while ($ary_res = @pg_fetch_array($res, $i, PGSQL_NUM)){
                foreach ($ary_res as $key => $value){
                    $ary_payout_all_data[$i][$key] = $value;
                }
                $i++;
            }
        }
}
/****************************/
// 一覧表示HTML作成
/****************************/
// html格納配列定義
$html = null;
$e_staff_id = null;
// 取得フラグtrueの場合
if ($select_query_flg == true){

    // 売上、仕入、入金、支払のデータがあるスタッフを取得する
    if ($count_type == "1"){
        $whe  = " WHERE enter_day >= '$count_date_s 00:00:00' AND enter_day <= '$count_date_e 23:59:59' AND shop_id = ".$_SESSION["client_id"]." ";
        $sql  = "(SELECT e_staff_id AS stafd_id FROM t_sale_h_amount $whe) UNION \n";
        $sql .= "(SELECT e_staff_id AS stafd_id FROM t_buy_h         $whe) UNION \n";
        $sql .= "(SELECT e_staff_id AS stafd_id FROM t_payin_h       $whe) UNION \n";
        $sql .= "(SELECT e_staff_id AS stafd_id FROM t_payout_h      $whe) \n";
    }else{
        $whe_sale  = " WHERE sale_day >= '$count_date_s 00:00:00' AND sale_day <= '$count_date_e 23:59:59' AND shop_id = ".$_SESSION["client_id"]." ";
        $whe_buy   = " WHERE buy_day >= '$count_date_s 00:00:00' AND buy_day <= '$count_date_e 23:59:59' AND shop_id = ".$_SESSION["client_id"]." ";
        $whe_pay   = " WHERE pay_day >= '$count_date_s 00:00:00' AND pay_day <= '$count_date_e 23:59:59' AND shop_id = ".$_SESSION["client_id"]." ";
        $sql  = "(SELECT e_staff_id AS stafd_id FROM t_sale_h_amount $whe_sale) UNION \n";
        $sql .= "(SELECT e_staff_id AS stafd_id FROM t_buy_h         $whe_buy) UNION \n";
        $sql .= "(SELECT e_staff_id AS stafd_id FROM t_payin_h       $whe_pay) UNION \n";
        $sql .= "(SELECT e_staff_id AS stafd_id FROM t_payout_h      $whe_pay) \n";
    }
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $select_staff_src   = Get_Data($res);
        foreach ($select_staff_src as $key => $value){
            $select_staff[] = $value[0];
        }
    }else{
        $select_staff       = array(null);
    }

    foreach ($ary_select_e_staff_id as $e_staff_id){

        if (in_array($e_staff_id, $select_staff)){

            $html .= "<fieldset>\n";
            $html .= "<legend><span style=\"font: bold 15px; color: #555555;\">【".$select_value[$e_staff_id]."】</span></legend>\n";
            $html .= "<br>\n";
            //売上テーブルを表示
            $html .= Op_All_Sale_Html($ary_sale_select_data[$e_staff_id]);

            //仕入テーブルを表示
            $html .= Op_All_Buy_Html($ary_buy_select_data[$e_staff_id]);

            //入金テーブルを表示
            $html .= "<table align=\"left\"><tr><td>\n";
            $html .= Op_All_Payin_Html($ary_payin_select_data[$e_staff_id]);
            $html .= "</td></tr></table>\n";

            //支払テーブルを表示
            $html .= "<table align=\"right\"><tr><td>\n";
            $html .= Op_All_Payout_Html($ary_payout_select_data[$e_staff_id]);
            $html .= "</td></tr></table>\n";

            $html .= "</fieldset>\n";
            $html .= "<br>\n";

        }

    }
}

function p_op_all_html(){}
/*** 全件数htmlデータ作成 ***/
// オペレータリストが空でないフラグがtrueの場合
if ($all_query_flg == true){
    $html .= "<fieldset>\n";
    $html .= "<legend><span style=\"font: bold 15px; color: #555555;\">【全社】</span></legend>\n";
    $html .= "<br>\n";

    //売上テーブルを表示
    $html .= Op_All_Sale_Html($ary_sale_all_data,$num_sale_all);

    //仕入テーブルを表示
    $html .= Op_All_Buy_Html($ary_buy_all_data,$num_buy_all);

    //入金テーブルを表示
    $html .= "<table align=\"left\"><tr><td>\n";
    $html .= Op_All_Payin_Html($ary_payin_all_data,$num_payin_all);
    $html .= "</td></tr></table>\n";

    //支払テーブルを表示
    $html .= "<table align=\"right\"><tr><td>\n";
    $html .= Op_All_Payout_Html($ary_payout_all_data,$num_payout_all);
    $html .= "</td></tr></table>\n";
    
    $html .= "</fieldset>\n";

}

// オペレータリストが空でないフラグがfalseの場合（表示させるデータが全く居ない場合）
if ($verify_flg == true && $all_query_flg != true){
    $html .= "<span style=\"font: bold 20px; color: #ff0000;\">・「売上」「仕入」「入金」「支払」データがありません </span>\n";
}

// フォームエラーの場合
if ($verify_flg != true && $all_query_flg != true){
    $html .= "";
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
$page_menu = Create_Menu_f('renew','1');

/****************************/
// 画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

/****************************/
//テンプレートへの処理
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
    "html"              => "$html",
    "info_msg"          => "$info_msg",
));

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));


/*

$e_time = microtime();
echo "$s_time"."<br>";
echo "$e_time"."<br>";

echo "<pre>";
//print_r($_SESSION);
print_r($_POST);
echo "</pre>";
*/
function p_foot(){}

?>
