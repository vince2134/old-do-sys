<?php

/*
 *  履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007-04-13      その他159   fukuda      集計期間終了日に本日日付をデフォルトでセット
 *  2009-10-12                  aoyama-n    集計期間開始日を入力可能に修正 
 *  2009-10-19                  hashimoto-y 支店を選択してない場合の処理追加 
 *  2009-10-20                  hashimoto-y 10-19の修正漏れを追加 
 * 
 * 
 */

// ページ名
$page_title = "バッチ表";

// 環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."2-5-105.php.inc");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

// DB接続
$db_con = Db_Connect();


/****************************/
// 権限関連処理
/****************************/
$auth   = Auth_Check($db_con);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null; 


/****************************/
// 外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];
$staff_id   = $_GET["id"];

/****************************/
// 月次更新データ取得
/****************************/
// 最終月次締日
//2009-10-12 aoyama-n
$monthly_renew_day  = Renew_Day($db_con, "monthly", $shop_id);
$mon_renew_day["y"] = substr($monthly_renew_day, 0, 4);
$mon_renew_day["m"] = substr($monthly_renew_day, 5, 2);
$mon_renew_day["d"] = substr($monthly_renew_day, 8,2);

/****************************/
// 初期値設定
/****************************/
// 支店明細時のみ
if ($staff_id == null){
    $def_fdata = array(
        "form_end_day"  => array("y" => date("Y"), "m" => date("m"), "d" => date("d")),
        "hdn_end_day"   => array("y" => date("Y"), "m" => date("m"), "d" => date("d")),
        //2009-10-12 aoyama-n
        "form_start_day"  => array("y" => $mon_renew_day["y"], "m" => $mon_renew_day["m"], "d" => $mon_renew_day["d"])
    );
    $form->setDefaults($def_fdata);
}


#2009-10-19 hashimoto-y
#2009-10-20 hashimoto-y
#if($_POST["form_show_button"] != null && $_POST["form_start_day"] != null && $_POST["form_end_day"] != null){
if( ($_POST["form_show_button"] != null || $_POST["renew_flg"] == "true" ) && $_POST["form_start_day"] != null && $_POST["form_end_day"] != null){
    $start_y    = $_POST["form_start_day"]["y"]; 
    $start_m    = $_POST["form_start_day"]["m"]; 
    $start_d    = $_POST["form_start_day"]["d"]; 
    $start_day  = ($start_y != null && $start_m != null && $start_d != null) ? $start_y."-".$start_m."-".$start_d : null;

    $end_y      = $_POST["form_end_day"]["y"];
    $end_m      = $_POST["form_end_day"]["m"];
    $end_d      = $_POST["form_end_day"]["d"];
    $end_day    = ($end_y != null && $end_m != null && $end_d != null) ? $end_y."-".$end_m."-".$end_d : null;
//2009-10-12 aoyama-n
//担当者一覧から遷移
}elseif($_POST["hdn_start_day"] != null && $_POST["hdn_end_day"] != null){
    $start_y    = $_POST["hdn_start_day"]["y"]; 
    $start_m    = $_POST["hdn_start_day"]["m"]; 
    $start_d    = $_POST["hdn_start_day"]["d"]; 
    $start_day  = ($start_y != null && $start_m != null && $start_d != null) ? $start_y."-".$start_m."-".$start_d : null;

    $end_y      = $_POST["hdn_end_day"]["y"];
    $end_m      = $_POST["hdn_end_day"]["m"];
    $end_d      = $_POST["hdn_end_day"]["d"];
    $end_day    = ($end_y != null && $end_m != null && $end_d != null) ? $end_y."-".$end_m."-".$end_d : null;
}else{
    //2009-10-12 aoyama-n
    // 集計期間開始日付
    $start_day = $monthly_renew_day;

    // 集計期間終了日付
    $end_day = date("Y-m-d");
}


/****************************/
// 担当者IDの妥当性チェック
/****************************/
// 担当者明細時
if ($staff_id != null && $staff_id != "0"){

    // 数値以外の場合はトップへ遷移
    if(!ereg("^[0-9]+$", $staff_id)){
        header("Location: ../top.php");
        exit;
    }

    // 所属マスタ・売上/入金伝票に存在しない担当者の場合はトップへ遷移
    $sql  = "SELECT \n";
    $sql .= "   * \n";
    $sql .= "FROM \n";
    $sql .= "   ( \n";
    $sql .= "       ( \n";
    $sql .= "           SELECT \n";
    $sql .= "               shop_id, \n";
    $sql .= "               staff_id \n";
    $sql .= "           FROM \n";
    $sql .= "               t_attach \n";
    $sql .= "       ) \n";
    $sql .= "       UNION ALL \n";
    $sql .= "       ( \n";
    $sql .= "           SELECT \n";
    $sql .= "               shop_id, \n";
    $sql .= "               main_staff_id AS staff_id \n";
    $sql .= "           FROM \n";
    $sql .= "               t_sale_h_amount \n";
    $sql .= "       ) \n";
    $sql .= "       UNION ALL \n";
    $sql .= "       ( \n";
    $sql .= "           SELECT \n";
    $sql .= "               shop_id, \n";
    $sql .= "               collect_staff_id AS staff_id \n";
    $sql .= "           FROM \n";
    $sql .= "               t_payin_h \n";
    $sql .= "       ) \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_attach_sale_payin \n";
    $sql .= "WHERE \n";
    $sql .= "   shop_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "   staff_id = $staff_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num == "0"){
        header("Location: ../top.php");
        exit;
    }

}


/****************************/
// フォームパーツ定義
/****************************/
// 支店明細時のみ
if ($staff_id == null){

    //2009-10-12 aoyama-n
    // 集計期間（開始）
    Addelement_Date($form, "form_start_day", "", "-");

    // 集計期間
    Addelement_Date($form, "form_end_day", "集計日報", "-");

    // 日次更新ボタン
    $form->addElement("button", "form_renew_button", "日次更新実施", "
        onClick=\"javascript: return Dialogue_1('実行します。', 'true', 'renew_flg');\"
        $disabled
    ");

    // hidden 日次更新フラグセット用
    $form->addElement("hidden", "renew_flg");

    // 表示ボタン
    $form->addElement("submit", "form_show_button", "表　示");

    // 担当者一覧ボタン
    $form->addElement("button", "form_list_button", "担当者一覧へ", "onClick=\"javascript: Submit_Page('./2-5-109.php');\"");

    // クリアボタン
    $form->addElement("button", "form_clear_button", "クリア", "onClick=\"javascript: location.href('".$_SERVER[PHP_SELF]."');\"");

// 支店明細時以外
}elseif ($staff_id != null){

    // 戻るボタン
    $form->addElement("button", "form_return_button", "担当者一覧へ戻る", "onClick=\"javascript: history.back();\"");

}

// 支店
$select_value   = "";
$select_value   = Select_Get($db_con, "branch");
$staff_freeze   = $form->addElement("select", "form_branch", "", $select_value, "$g_form_option_select");
// 担当者明細/代行明細時はフリーズ
if ($staff_id != null){
    $staff_freeze->freeze();
}

//2009-10-12 aoyama-n
// hidden 集計期間(開始)
$hdn_start_day[] = $form->createElement("hidden", "y", "", "");
$hdn_start_day[] = $form->createElement("hidden", "m", "", "");
$hdn_start_day[] = $form->createElement("hidden", "d", "", "");
$form->addGroup($hdn_start_day, "hdn_start_day", "", " - ");

// hidden 集計期間
$hdn_end_day[] = $form->createElement("hidden", "y", "", "");
$hdn_end_day[] = $form->createElement("hidden", "m", "", "");
$hdn_end_day[] = $form->createElement("hidden", "d", "", "");
$form->addGroup($hdn_end_day, "hdn_end_day", "", " - ");

// hidden 支店
$form->addElement("hidden", "hdn_branch", "", "");


/****************************/
// フォームに値をセット
/****************************/
// 担当者明細/代行明細時
if ($staff_id != null){
    $form_set["form_branch"] = $_POST["hdn_branch"];
    $form->setConstants($form_set);
//2009-10-12 aoyama-n
}else{
    //担当者一覧から遷移した場合
    $form_set["form_start_day"]["y"] = $start_y;
    $form_set["form_start_day"]["m"] = $start_m;
    $form_set["form_start_day"]["d"] = $start_d;

    $form_set["form_end_day"]["y"] = $end_y;
    $form_set["form_end_day"]["m"] = $end_m;
    $form_set["form_end_day"]["d"] = $end_d;
    $form_set["form_branch"]       = $_POST["form_branch"];
    $form->setConstants($form_set);

}


/****************************/
// 月次更新データ取得
/****************************/
// 最終月次締日
//2009-10-12 aoyama-n 
#$monthly_renew_day  = Renew_Day($db_con, "monthly", $shop_id);


/****************************/
// POST時の変数代入
/****************************/
// 表示ボタン押下時
if ($_POST["form_show_button"] != null || $_POST["renew_flg"] == "true"){

    //2009-10-12 aoyama-n
    $start_y    = ($_POST["form_start_day"]["y"] != null) ? str_pad($_POST["form_start_day"]["y"], 4, 0, STR_POS_LEFT) : null; 
    $start_m    = ($_POST["form_start_day"]["m"] != null) ? str_pad($_POST["form_start_day"]["m"], 2, 0, STR_POS_LEFT) : null; 
    $start_d    = ($_POST["form_start_day"]["d"] != null) ? str_pad($_POST["form_start_day"]["d"], 2, 0, STR_POS_LEFT) : null; 
    $start_day  = ($start_y != null && $start_m != null && $start_d != null) ? $start_y."-".$start_m."-".$start_d : null;

    $end_y      = ($_POST["form_end_day"]["y"] != null) ? str_pad($_POST["form_end_day"]["y"], 4, 0, STR_POS_LEFT) : null; 
    $end_m      = ($_POST["form_end_day"]["m"] != null) ? str_pad($_POST["form_end_day"]["m"], 2, 0, STR_POS_LEFT) : null; 
    $end_d      = ($_POST["form_end_day"]["d"] != null) ? str_pad($_POST["form_end_day"]["d"], 2, 0, STR_POS_LEFT) : null; 
    $end_day    = ($end_y != null && $end_m != null && $end_d != null) ? $end_y."-".$end_m."-".$end_d : null;
    $branch_id  = $_POST["form_branch"];

// 担当者一覧画面から戻るボタンPOSTが送られた場合
// 担当者一覧画面から担当者リンクPOSTが送られた場合
}elseif ($_POST != null && $_POST["form_show_button"] == null){

    //2009-10-12 aoyama-n
    $start_y    = $_POST["hdn_start_day"]["y"]; 
    $start_m    = $_POST["hdn_start_day"]["m"]; 
    $start_d    = $_POST["hdn_start_day"]["d"]; 
    $start_day  = ($start_y != null && $start_m != null && $start_d != null) ? $start_y."-".$start_m."-".$start_d : null;

    $end_y      = $_POST["hdn_end_day"]["y"];
    $end_m      = $_POST["hdn_end_day"]["m"];
    $end_d      = $_POST["hdn_end_day"]["d"];
    $end_day    = ($end_y != null && $end_m != null && $end_d != null) ? $end_y."-".$end_m."-".$end_d : null;
    $branch_id  = $_POST["hdn_branch"];

}


/****************************/
// 表示ボタン押下時処理
/****************************/
if (isset($_POST["form_show_button"]) || $_POST["renew_flg"] == "true"){

    /****************************/
    // エラーチェック
    /****************************/
    //2009-10-12 aoyama-n
    //集計期間必須チェック
    if ($start_day == null){
        $form->setElementError("form_start_day", "集計期間(開始) は必須です。");
    }
    if($end_day == null){
        $form->setElementError("form_end_day", "集計期間(終了) は必須です。");
    }

    // どれか1つでも入力がある場合
    //2009-10-12 aoyama-n
    #if ($end_y != null || $end_m != null || $end_d != null){
    //集計期間の開始・終了が入力されている場合
    if ($start_day != null && $end_day != null){

        // エラーメッセージ
        //2009-10-12 aoyama-n
        #$err_msg = "集計期間の日付が妥当ではありません。";
        $startday_err_msg = "集計期間(開始) の日付が妥当ではありません。";
        $endday_err_msg = "集計期間(終了) の日付が妥当ではありません。";

        // 必須チェック
        //2009-10-12 aoyama-n
        #$form->addGroupRule("form_end_day", $err_msg, "required");

        // 数値チェック
        //2009-10-12 aoyama-n
        $form->addGroupRule("form_start_day", $startday_err_msg, "regex", "/^[0-9]+$/");
        $form->addGroupRule("form_end_day", $endday_err_msg, "regex", "/^[0-9]+$/");

        // 日付妥当性チェック
        //2009-10-12 aoyama-n
        if (!checkdate((int)$start_m, (int)$start_d, (int)$start_y)){
            $form->setElementError("form_start_day", $startday_err_msg);
        }
        if (!checkdate((int)$end_m, (int)$end_d, (int)$end_y)){
            $form->setElementError("form_end_day", $endday_err_msg);
        }

        // 前回の月次締日より後の日付かチェック
        //2009-10-12 aoyama-n
        #if ((mb_substr($monthly_renew_day, 0, 10) > $end_day) && $err_flg != true){
        #    $form->setElementError("form_end_day", $err_msg);
        #}


    }

    // 日次更新実施ボタン押下時
    if ($_POST["renew_flg"] == "true"){

        // 必須チェック
        //2009-10-12 aoyama-n
        #if ($end_day == null){
        #    $form->setElementError("form_end_day", "集計期間 は必須です。");
        #}

        if ($branch_id == null){
            $form->setElementError("form_branch", "支店 は必須です。");
        }

        // 過去日付かチェック
        //2009-10-12 aoyama-n
        if (date("Y-m-d") < $start_day){
            $form->setElementError("form_start_day", "集計期間(開始) が未来の日付になっています。");
        }
        if (date("Y-m-d") < $end_day){
            //2009-10-12 aoyama-n
            #$form->setElementError("form_end_day", "集計期間 が未来の日付になっています。");
            $form->setElementError("form_end_day", "集計期間(終了) が未来の日付になっています。");
        }


    }

    /****************************/
    // エラーチェック結果集計
    /****************************/
    // チェック適用
    $form->validate();
    // 結果をフラグに
    $err_flg = (count($form->_errors) > 0) ? true : false;
    
    /****************************/
    // エラーの無い場合の処理
    /****************************/
    // エラーのない場合
    if ($err_flg != true){

        // フォームデータをhiddenにセット（担当者一覧画面のフォームセット用）
        //2009-10-12 aoyama-n
        $hdn_set["hdn_start_day"]["y"] = $start_y;
        $hdn_set["hdn_start_day"]["m"] = $start_m;
        $hdn_set["hdn_start_day"]["d"] = $start_d;

        $hdn_set["hdn_end_day"]["y"] = $end_y;
        $hdn_set["hdn_end_day"]["m"] = $end_m;
        $hdn_set["hdn_end_day"]["d"] = $end_d;
        $hdn_set["hdn_branch"]       = $_POST["form_branch"];
        $form->setConstants($hdn_set);

    }

}

/****************************/
// 日次更新実施ボタン押下時
/****************************/
if ($_POST["renew_flg"] == "true"){

    // 日次更新押下hiddenを空に
    $clear_hdn["renew_flg"] = "";
    $form->setConstants($clear_hdn);

    // エラーのない場合
    if ($err_flg != true){

        // FCショップ時
        if ($_SESSION["group_kind"] != "2"){

            // 日次更新対象外の伝票番号を取得
            // オンライン代行時、受託先側の売上伝票
            $sql  = "SELECT \n";
            $sql .= "   t_sale_h.sale_no \n";
            $sql .= "FROM \n";
            $sql .= "   t_sale_h \n";
            $sql .= "   INNER JOIN t_aorder_h \n";
            $sql .= "       ON  t_sale_h.aord_id = t_aorder_h.aord_id \n";
            //$sql .= "       AND t_aorder_h.contract_div = '2' \n";              // オンライン代行
            //$sql .= "       AND t_aorder_h.ps_stat     != '3' \n";              // 処理済でない
            $sql .= "       AND t_aorder_h.confirm_flg  = 'f' \n";              // 未承認
            $sql .= "   INNER JOIN t_client \n";
            $sql .= "       ON  t_sale_h.client_id = t_client.client_id \n";
            $sql .= "       AND t_client.charge_branch_id = $branch_id \n";     // 指定支店
            $sql .= "WHERE \n";
            $sql .= "   t_sale_h.act_request_flg = 't' \n";                     // 代行料伝票
            $sql .= "AND \n";
            $sql .= "   t_sale_h.renew_flg != 't' \n";                          // 日次更新未実施
            //2009-10-12 aoyama-n
            $sql .= "AND \n";
            $sql .= "   t_sale_h.sale_day >= '$start_day' \n";                  // 集計開始日

            $sql .= "AND \n";
            $sql .= "   t_sale_h.sale_day <= '$end_day' \n";                    // 集計終了日
            $sql .= "AND \n";
            $sql .= "   t_sale_h.shop_id = ".$_SESSION["client_id"]." \n";
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);    
            $num  = pg_num_rows($res);

            // 対象の伝票がある場合
            if ($num > 0){

                // 対象伝票取得
                $ary_not_renew = Get_Data($res, 2);

                // エラーメッセージ作成
                $err_not_renew = "以下の売上伝票は、委託先による承認が行われていないため日次更新されませんでした。<br>　　";

                // 対象伝票をエラーメッセージ用に整形（10個毎に改行）
                foreach ($ary_not_renew as $key => $value){
                    $err_not_renew .= (bcmod($key+1, 10) == 0) ? $value[0]."<br>　　" : $value[0]." ";
                }

            }

        }

        // 日次更新実施
        //2009-10-12 aoyama-n
        #$return_renew = Renew_Operate($db_con, $end_day, $branch_id);
        $return_renew = Renew_Operate($db_con, $start_day, $end_day, $branch_id);

        // 日次更新完了メッセージ
        $renew_msg = ($return_renew == true) ? "日次更新完了しました。" : null;

    }

}


/****************************/
// 未実施/実施/合計金額取得
/****************************/
// エラーのない場合
if ($err_flg != true){

    //2009-10-12 aoyama-n
    // 日次未実施累計金額取得
    #$ary_total_daily    = Get_Total_Amount($db_con, "daily",   $staff_id, $shop_id, $branch_id, $monthly_renew_day, $end_day);
    // 日次実施済累計金額取得
    #$ary_total_halfway  = Get_Total_Amount($db_con, "halfway", $staff_id, $shop_id, $branch_id, $monthly_renew_day, $end_day);
    // 合計（税抜金額）金額取得
    #$ary_total_notax    = Get_Total_Amount($db_con, "notax",   $staff_id, $shop_id, $branch_id, $monthly_renew_day, $end_day);
    // 合計（消費税額）金額取得
    #$ary_total_tax      = Get_Total_Amount($db_con, "tax",     $staff_id, $shop_id, $branch_id, $monthly_renew_day, $end_day);
    // 合計（一括消費税）金額取得
    #$ary_total_lump     = Get_Lump_Amount ($db_con, $staff_id, $shop_id, $branch_id, $monthly_renew_day, $end_day);
    // 合計（ロイヤリティ）金額取得
    #$ary_total_royalty  = Get_Royal_Amount($db_con, $staff_id, $shop_id, $branch_id, $monthly_renew_day, $end_day);
    // 合計（合計）金額取得
    #$ary_total_monthly  = Get_Total_Amount($db_con, "monthly", $staff_id, $shop_id, $branch_id, $monthly_renew_day, $end_day);

    // 日次未実施累計金額取得
    $ary_total_daily    = Get_Total_Amount($db_con, "daily",   $staff_id, $shop_id, $branch_id, $start_day, $end_day);
    // 日次実施済累計金額取得
    $ary_total_halfway  = Get_Total_Amount($db_con, "halfway", $staff_id, $shop_id, $branch_id, $start_day, $end_day);
    // 合計（税抜金額）金額取得
    $ary_total_notax    = Get_Total_Amount($db_con, "notax",   $staff_id, $shop_id, $branch_id, $start_day, $end_day);
    // 合計（消費税額）金額取得
    $ary_total_tax      = Get_Total_Amount($db_con, "tax",     $staff_id, $shop_id, $branch_id, $start_day, $end_day);
    // 合計（一括消費税）金額取得
    $ary_total_lump     = Get_Lump_Amount ($db_con, $staff_id, $shop_id, $branch_id, $start_day, $end_day);
    // 合計（ロイヤリティ）金額取得
    $ary_total_royalty  = Get_Royal_Amount($db_con, $staff_id, $shop_id, $branch_id, $start_day, $end_day);
    // 合計（合計）金額取得
    $ary_total_monthly  = Get_Total_Amount($db_con, "monthly", $staff_id, $shop_id, $branch_id, $start_day, $end_day);
}

/****************************/
// 日次/合計金額出力html作成
/****************************/
// エラーのない場合
if ($err_flg != true){

    // 担当者明細時
    $span    = ($staff_id != null && $staff_id != "0") ? "2" : null;
    // 代行明細時
    $span    = ($staff_id == "0")                      ? "2" : $span;
    // 支店明細時
    $span    = ($staff_id == null)                     ? "4" : $span;

    $td_opt  = " class=\"Value\" align=\"right\"";

    $html_t  = "<table class=\"Data_Table\" border=\"1\">\n";
    $html_t .= "<col width=\"40\" style=\"font-weight: bold;\">\n";
    $html_t .= "<col width=\"100\" style=\"font-weight: bold;\">\n";
    $html_t .= "<col span=\"$span\" width=\"100\">\n";
    $html_t .= "<tr align=\"center\" style=\"font-weight: bold;\">\n";
    $html_t .= "    <td class=\"Title_Green\" colspan=\"2\"></td>\n";
    // 担当者明細時
    if ($staff_id != null && $staff_id != "0"){
    $html_t .= "    <td class=\"Title_Green\">売上合計</td>\n";
    $html_t .= "    <td class=\"Title_Green\">入金合計</td>\n";
    // 代行明細時
    }elseif ($staff_id == "0"){
    $html_t .= "    <td class=\"Title_Green\">売上合計</td>\n";
    $html_t .= "    <td class=\"Title_Green\">入金合計</td>\n";
    // 支店明細時
    }elseif ($staff_id == null){
    $html_t .= "    <td class=\"Title_Green\">売上合計</td>\n";
    $html_t .= "    <td class=\"Title_Green\">入金合計</td>\n";
    $html_t .= "    <td class=\"Title_Green\">仕入合計</td>\n";
    $html_t .= "    <td class=\"Title_Green\">支払合計</td>\n";
    }
    $html_t .= "</tr>\n";
    $html_t .= Make_Html_Total_Amount($ary_total_daily,   "daily",   $staff_id);
    $html_t .= Make_Html_Total_Amount($ary_total_halfway, "halfway", $staff_id);
    $html_t .= Make_Html_Total_Amount($ary_total_notax,   "notax",   $staff_id);
    $html_t .= Make_Html_Total_Amount($ary_total_tax,     "tax",     $staff_id);
    if ($staff_id == null){
    $html_t .= Make_Html_Total_Amount($ary_total_lump,    "lump",    $staff_id);
    $html_t .= Make_Html_Total_Amount($ary_total_royalty, "royalty", $staff_id);
    }
    $html_t .= Make_Html_Total_Amount($ary_total_monthly, "monthly", $staff_id, $ary_total_royalty, $ary_total_lump);
    $html_t .= "</table>\n";

}


/****************************/
// 明細金額取得
/****************************/
// エラーの無い場合
if ($err_flg != true){

    /* 売上明細金額取得 */
    // 日次未実施累計
    //2009-10-12 aoyama-n
    #$sql                    = Particular_Sale_Sql("daily",   $staff_id, $shop_id, $branch_id, $monthly_renew_day, $end_day);
    $sql                    = Particular_Sale_Sql("daily",   $staff_id, $shop_id, $branch_id, $start_day, $end_day);
    $res_sale_daily         = Db_Query($db_con, $sql);
    $num_sale_daily         = pg_num_rows($res_sale_daily);
    $ary_sale_daily         = Two_To_Linear(Get_Data($res_sale_daily,   "2", "ASSOC"));
    // 日次実施済累計
    //2009-10-12 aoyama-n
    #$sql                    = Particular_Sale_Sql("halfway", $staff_id, $shop_id, $branch_id, $monthly_renew_day, $end_day);
    $sql                    = Particular_Sale_Sql("halfway", $staff_id, $shop_id, $branch_id, $start_day, $end_day);
    $res_sale_halfway       = Db_Query($db_con, $sql);
    $num_sale_halfway       = pg_num_rows($res_sale_halfway);
    $ary_sale_halfway       = Two_To_Linear(Get_Data($res_sale_halfway, "2", "ASSOC"));
    // 合計
    //2009-10-12 aoyama-n
    #$sql                    = Particular_Sale_Sql("monthly", $staff_id, $shop_id, $branch_id, $monthly_renew_day, $end_day);
    $sql                    = Particular_Sale_Sql("monthly", $staff_id, $shop_id, $branch_id, $start_day, $end_day);
    $res_sale_monthly       = Db_Query($db_con, $sql);
    $num_sale_monthly       = pg_num_rows($res_sale_monthly);
    $ary_sale_monthly       = Two_To_Linear(Get_Data($res_sale_monthly, "2", "ASSOC"));

    /* 仕入明細金額取得 */
    // 日次未実施累計
    // 支店明細時のみ
    if ($staff_id == null){
        //2009-10-12 aoyama-n
        #$sql                = Particular_Buy_Sql("daily",   $staff_id, $shop_id, $branch_id, $monthly_renew_day, $end_day);
        $sql                = Particular_Buy_Sql("daily",   $staff_id, $shop_id, $branch_id, $start_day, $end_day);
        $res_buy_daily      = Db_Query($db_con, $sql);
        $num_buy_daily      = pg_num_rows($res_buy_daily);
        $ary_buy_daily      = Two_To_Linear(Get_Data($res_buy_daily,   "2", "ASSOC"));
    }
    // 日次実施済累計
    // 支店明細時のみ
    if ($staff_id == null){
        //2009-10-12 aoyama-n
        #$sql                = Particular_Buy_Sql("halfway", $staff_id, $shop_id, $branch_id, $monthly_renew_day, $end_day);
        $sql                = Particular_Buy_Sql("halfway", $staff_id, $shop_id, $branch_id, $start_day, $end_day);
        $res_buy_halfway    = Db_Query($db_con, $sql);
        $num_buy_halfway    = pg_num_rows($res_buy_halfway);
        $ary_buy_halfway    = Two_To_Linear(Get_Data($res_buy_halfway, "2", "ASSOC"));
    }
    // 合計
    // 支店明細時のみ
    if ($staff_id == null){
        //2009-10-12 aoyama-n
        #$sql                = Particular_Buy_Sql("monthly", $staff_id, $shop_id, $branch_id, $monthly_renew_day, $end_day);
        $sql                = Particular_Buy_Sql("monthly", $staff_id, $shop_id, $branch_id, $start_day, $end_day);
        $res_buy_monthly    = Db_Query($db_con, $sql);
        $num_buy_monthly    = pg_num_rows($res_buy_monthly);
        $ary_buy_monthly    = Two_To_Linear(Get_Data($res_buy_monthly, "2", "ASSOC"));
    }

    /* 入金明細金額取得 */
    // 支店明細時
    if ($staff_id == null){
        // 銀行を出力する取引区分を設定
        $payin_bank_trade_list = array("32", "33", "35");
        // 銀行を表示する取引区分でループ
        foreach ($payin_bank_trade_list as $key => $trade){
            // 銀行情報取得
            //2009-10-12 aoyama-n
            #$sql                            = Bank_Payin_Sql($shop_id, $branch_id, $trade, $monthly_renew_day, $end_day);
            $sql                            = Bank_Payin_Sql($shop_id, $branch_id, $trade, $start_day, $end_day);
            $res_bank_list_payin            = Db_Query($db_con, $sql);
            $num_bank_list_payin            = pg_num_rows($res_bank_list_payin);
            $ary_bank_list_payin[$trade]    = Get_Data($res_bank_list_payin, "2", "ASSOC");
        }
        // 取引区分毎に取得した銀行情報でループ
        foreach ($ary_bank_list_payin as $key => $value){
            // 該当銀行明細を取得
            //2009-10-12 aoyama-n
            #$ary_payin_bank[$key]           = Get_Payin_Bank($db_con, $value, $shop_id, $branch_id, $monthly_renew_day, $end_day);
            $ary_payin_bank[$key]           = Get_Payin_Bank($db_con, $value, $shop_id, $branch_id, $start_day, $end_day);
        }
    }

    // 銀行を出力しない取引区分を設定
    if ($staff_id != null && $staff_id != "0"){
        $payin_nobank_trade_list            = array("39", "40", "31");
    }elseif ($staff_id == "0"){
        $payin_nobank_trade_list            = array("40", "31");
    }elseif ($staff_id == null){
        $payin_nobank_trade_list            = array("39", "40", "31", "34", "36", "37", "38");
    }
    // 銀行を出力しない取引区分でループ
    foreach ($payin_nobank_trade_list as $key => $trade){
        // 該当取引区分毎明細取得
        $ary_payin_nobank[$trade]           = Get_Payin_Nobank(
            //2009-10-12 aoyama-n
            #$db_con, $trade, $shop_id, $branch_id, $staff_id, $monthly_renew_day, $end_day
            $db_con, $trade, $shop_id, $branch_id, $staff_id, $start_day, $end_day
        );
    }

    /* 支払明細金額取得 */
    // 支店明細時のみ
    if ($staff_id == null){
        // 銀行を出力する取引区分を設定
        $payout_bank_trade_list = array("43", "44", "48");
        // 銀行を表示する取引区分でループ
        foreach ($payout_bank_trade_list as $key => $trade){
            // 銀行情報取得
            //2009-10-12 aoyama-n
            #$sql                            = Bank_Payout_Sql($shop_id, $branch_id, $trade, $monthly_renew_day, $end_day);
            $sql                            = Bank_Payout_Sql($shop_id, $branch_id, $trade, $start_day, $end_day);
            $res_bank_list_payout           = Db_Query($db_con, $sql);
            $num_bank_list_payout           = pg_num_rows($res_bank_list_payout);
            $ary_bank_list_payout[$trade]   = Get_Data($res_bank_list_payout, "2", "ASSOC");
        }
        // 取引区分毎に取得した銀行情報でループ
        foreach ($ary_bank_list_payout as $key => $value){
            // 該当銀行明細を取得
            //2009-10-12 aoyama-n
            #$ary_payout_bank[$key]          = Get_Payout_Bank($db_con, $value, $shop_id, $branch_id, $monthly_renew_day, $end_day);
            $ary_payout_bank[$key]          = Get_Payout_Bank($db_con, $value, $shop_id, $branch_id, $start_day, $end_day);
        }
        // 銀行を出力しない取引区分を設定
        $payout_nobank_trade_list = array("49", "41", "45", "46", "47");
        // 銀行を出力しない取引区分でループ
        foreach ($payout_nobank_trade_list as $key => $trade){
            // 該当取引区分毎明細取得
            $ary_payout_nobank[$trade]      = Get_Payout_Nobank(
                //2009-10-12 aoyama-n
                #$db_con, $trade, $shop_id, $branch_id, $monthly_renew_day, $end_day
                $db_con, $trade, $shop_id, $branch_id, $start_day, $end_day
            );
        }

    }


    /****************************/
    // 取得データを出力用に整形
    /****************************/
    /* 入金明細 */
    // 支店明細時のみ
    if ($staff_id == null){
        // 取引区分毎に取得した銀行データでループ
        foreach ($ary_payin_bank as $key_trade => $value_trade){
            // 該当取引区分にデータがある場合
            if ($value_trade != null){
                // 銀行毎にループ
                foreach ($value_trade as $key_bank => $value_bank){
                    // 銀行コード・支店コード
                    $ary_payin_bank[$key_trade][$key_bank]["bank_b_bank_cd"]      =
                        $value_bank["bank_cd"]."-".
                        $value_bank["b_bank_cd"];
                    // 銀行名・支店名・口座番号
                    $ary_payin_bank[$key_trade][$key_bank]["bank_b_bank_name"]    =
                        htmlspecialchars($value_bank["bank_name"])." ".
                        htmlspecialchars($value_bank["b_bank_name"])." ".
                        $value_bank["account_no"];
                }
            }
        }
    }

    /* 支払明細 */
    // 支店明細時のみ
    if ($staff_id == null){
        // 銀行を出力する取引区分毎に取得したデータのループ
        foreach ($ary_payout_bank as $key_trade => $value_trade){
            // 該当取引区分の取得データがある場合
            if ($value_trade != null){
                // 銀行毎にループ
                foreach ($value_trade as $key_bank => $value_bank){
                    // 銀行コード・支店コード
                    $ary_payout_bank[$key_trade][$key_bank]["bank_b_bank_cd"]     =
                        $value_bank["bank_cd"]."-".
                        $value_bank["b_bank_cd"];
                    // 銀行名・支店名・口座番号
                    $ary_payout_bank[$key_trade][$key_bank]["bank_b_bank_name"]   =
                        htmlspecialchars($value_bank["bank_name"])." ".
                        htmlspecialchars($value_bank["b_bank_name"])." ".
                        $value_bank["account_no"];
                }
            }
        }
    }


    /****************************/
    // 各取引区分の合計を算出
    /****************************/
    /* 売上明細 */
    // ループ用配列（売上明細販売区分）
    if ($staff_id != null && $staff_id != "0"){
        $ary_sale_div   = array("01", "02", "03", "04", "05", "06");
    }elseif ($staff_id == "0"){
        $ary_sale_div   = array("08");
    }elseif ($staff_id == null){
        $ary_sale_div   = array("01", "02", "03", "04", "05", "06", "08");
    }
    foreach ($ary_sale_div as $key => $value){
        // 現金売上 - 金額（日次未実施累計）
        $ary_sale_total["genkin_sale"]      += $ary_sale_daily["genkin_".$value."_sale"];
        // 現金売上 - 金額（日次実施済累計）
        $ary_sale_total["genkin_halfway"]   += $ary_sale_halfway["genkin_".$value."_sale"];
        // 現金売上 - 件数（合計）
        $ary_sale_total["genkin_count"]     += $ary_sale_monthly["genkin_".$value."_count"];
        // 現金売上 - 原価（合計）
        $ary_sale_total["genkin_cost"]      += $ary_sale_monthly["genkin_".$value."_cost"];
        // 現金売上 - 金額（合計）
        $ary_sale_total["genkin_monthly"]   += $ary_sale_monthly["genkin_".$value."_sale"];
        // 掛売上 - 金額（日次未実施累計）
        $ary_sale_total["kake_sale"]        += $ary_sale_daily["kake_".$value."_sale"];
        // 掛売上 - 金額（日次実施済累計）
        $ary_sale_total["kake_halfway"]     += $ary_sale_halfway["kake_".$value."_sale"];
        // 掛売上 - 件数（合計）
        $ary_sale_total["kake_count"]       += $ary_sale_monthly["kake_".$value."_count"];
        // 掛売上 - 原価（合計）
        $ary_sale_total["kake_cost"]        += $ary_sale_monthly["kake_".$value."_cost"];
        // 掛売上 - 金額（合計）
        $ary_sale_total["kake_monthly"]     += $ary_sale_monthly["kake_".$value."_sale"];
    }
    // 現金売上 - 金額（日次未実施累計）
    $ary_sale_total["genkin_sale"]          += $ary_sale_daily["genkin_tax"];
    // 現金売上 - 金額（日次実施済累計）
    $ary_sale_total["genkin_halfway"]       += $ary_sale_halfway["genkin_tax"];
    // 現金売上 - 金額（合計）
    $ary_sale_total["genkin_monthly"]       += $ary_sale_monthly["genkin_tax"];
    // 掛売上 - 金額（日次未実施累計）
    $ary_sale_total["kake_sale"]            += $ary_sale_daily["kake_tax"];
    // 掛売上 - 金額（日次実施済累計）
    $ary_sale_total["kake_halfway"]         += $ary_sale_halfway["kake_tax"];
    // 掛売上 - 金額（合計）
    $ary_sale_total["kake_monthly"]         += $ary_sale_monthly["kake_tax"];

    /* 仕入明細 */
    // 支店明細時のみ
    if ($staff_id == null){
        // 現金仕入 - 金額（日次未実施累計）
        $ary_buy_total["genkin_amount"]     = $ary_buy_daily["genkin_amount"]
                                            + $ary_buy_daily["genkin_tax"];
        // 現金仕入 - 金額（日次実施済累計）
        $ary_buy_total["genkin_halfway"]    = $ary_buy_halfway["genkin_amount"]
                                            + $ary_buy_halfway["genkin_tax"];
        // 現金仕入 - 件数（合計）
        $ary_buy_total["genkin_count"]      = $ary_buy_monthly["genkin_count"];
        // 現金仕入 - 金額（合計）
        $ary_buy_total["genkin_monthly"]    = $ary_buy_monthly["genkin_amount"]
                                            + $ary_buy_monthly["genkin_tax"];
        // 掛仕入 - 金額（日次未実施累計）
        $ary_buy_total["kake_amount"]       = $ary_buy_daily["kake_amount"]
                                            + $ary_buy_daily["kake_tax"];
        // 掛仕入 - 金額（日次実施済累計）
        $ary_buy_total["kake_halfway"]      = $ary_buy_halfway["kake_amount"]
                                            + $ary_buy_halfway["kake_tax"];
        // 掛仕入 - 件数（合計）
        $ary_buy_total["kake_count"]        = $ary_buy_monthly["kake_count"];
        // 掛仕入 - 金額（合計）
        $ary_buy_total["kake_monthly"]      = $ary_buy_monthly["kake_amount"]
                                            + $ary_buy_monthly["kake_tax"];
    }

    /* 入金明細 */
    // 支店明細時のみ
    if ($staff_id == null){
        // 銀行を出力する取引区分毎に取得したデータのループ
        foreach ($ary_payin_bank as $key_trade => $value_trade){
            // 該当取引区分の取得データがある場合
            if ($value_trade != null){
                // 銀行毎にループ
                foreach ($value_trade as $key_bank => $value_bank){
                    // 金額（日次未実施累計）
                    $ary_payin_total[$key_trade]["daily_amount"]    += $value_bank["daily_amount"];
                    // 金額（日次実施済累計）
                    $ary_payin_total[$key_trade]["halfway_amount"]  += $value_bank["halfway_amount"];
                    // 明細件数（合計）
                    $ary_payin_total[$key_trade]["monthly_count"]   += $value_bank["monthly_count"];
                    // 金額（合計）
                    $ary_payin_total[$key_trade]["monthly_amount"]  += $value_bank["monthly_amount"];
                }
            // 該当取引区分の取得データがある場合
            }else{
                // 金額（日次未実施累計）
                $ary_payin_total[$key_trade]["daily_amount"]        += 0;
                // 金額（日次実施済累計）
                $ary_payin_total[$key_trade]["halfway_amount"]      += 0;
                // 明細件数（合計）
                $ary_payin_total[$key_trade]["monthly_count"]       += 0;
                // 金額（合計）
                $ary_payin_total[$key_trade]["monthly_amount"]      += 0;
            }
        }
    }
    // 銀行を出力しない取引区分毎に取得したデータのループ
    foreach ($ary_payin_nobank as $key_trade => $value_trade){
        // 金額（日次未実施累計）
        $ary_payin_total[$key_trade]["daily_amount"]                = $value_trade["daily_amount"];
        // 金額（日次実施済累計）
        $ary_payin_total[$key_trade]["halfway_amount"]              = $value_trade["halfway_amount"];
        // 明細件数（合計）
        $ary_payin_total[$key_trade]["monthly_count"]               = $value_trade["monthly_count"];
        // 金額（合計）
        $ary_payin_total[$key_trade]["monthly_amount"]              = $value_trade["monthly_amount"];
    }

    /* 支払明細 */
    // 支店明細時のみ
    if ($staff_id == null){
        // 銀行を出力する取引区分毎に取得したデータのループ
        foreach ($ary_payout_bank as $key_trade => $value_trade){
            // 該当取引区分の取得データがある場合
            if ($value_trade != null){
                // 銀行毎にループ
                foreach ($value_trade as $key_bank => $value_bank){
                    // 金額（日次未実施累計）
                    $ary_payout_total[$key_trade]["daily_amount"]   += $value_bank["daily_amount"];
                    // 金額（日次実施済累計）
                    $ary_payout_total[$key_trade]["halfway_amount"] += $value_bank["halfway_amount"];
                    // 明細件数（合計）
                    $ary_payout_total[$key_trade]["monthly_count"]  += $value_bank["monthly_count"];
                    // 金額（合計）
                    $ary_payout_total[$key_trade]["monthly_amount"] += $value_bank["monthly_amount"];
                }
            // 該当取引区分の取得データがない場合
            }else{
                // 金額（日次未実施累計）
                $ary_payout_total[$key_trade]["daily_amount"]       += 0;
                // 金額（日次実施済累計）
                $ary_payout_total[$key_trade]["halfway_amount"]     += 0;
                // 明細件数（合計）
                $ary_payout_total[$key_trade]["monthly_count"]      += 0;
                // 金額（合計）
                $ary_payout_total[$key_trade]["monthly_amount"]     += 0;
            }
        }
        // 銀行を出力しない取引区分毎に取得したデータのループ
        foreach ($ary_payout_nobank as $key_trade => $value_trade){
            // 金額（日次未実施累計）
            $ary_payout_total[$key_trade]["daily_amount"]           = $value_trade["daily_amount"];
            // 金額（日次実施済累計）
            $ary_payout_total[$key_trade]["halfway_amount"]         = $value_trade["halfway_amount"];
            // 明細件数（合計）
            $ary_payout_total[$key_trade]["monthly_count"]          = $value_trade["monthly_count"];
            // 金額（合計）
            $ary_payout_total[$key_trade]["monthly_amount"]         = $value_trade["monthly_amount"];
        }
    }


    /****************************/
    // HTML作成
    /****************************/
    $html_m = null; 

    /* 売上明細 */
    $row   = 0;
    // 担当者明細時
    if ($staff_id != null && $staff_id != "0"){
        $ary_genkin_kake    = array(
            "genkin"    => "現金",
            "kake"      => "掛"
        );
        $ary_sale_div       = array(
            "01"        => "リピート",
            "02"        => "商品",
            "03"        => "レンタル",
            "04"        => "リース",
            "05"        => "工事",
            "06"        => "その他",
        );
    // 代行明細時
    }elseif ($staff_id == "0"){
        if ($_SESSION["group_kind"] == "2"){
            $ary_genkin_kake    = array(
                "genkin"    => "現金",
                "kake"      => "掛",
            );
        }else{
            $ary_genkin_kake    = array(
                "kake"      => "掛",
            );
        }
        $ary_sale_div       = array(
            "08"        => "代行"
        );
    // 支店明細時
    }elseif ($staff_id == null){
        $ary_genkin_kake    = array(
            "genkin"    => "現金", 
            "kake"      => "掛"
        );
        $ary_sale_div       = array(
            "01"        => "リピート",
            "02"        => "商品",
            "03"        => "レンタル",
            "04"        => "リース",
            "05"        => "工事",
            "06"        => "その他",
            "08"        => "代行",
        );
    }
    // 売上html作成
    $html_m .= "<tr class=\"Result3\" style=\"font-weight: bold;\">\n";
    $html_m .= "    <td colspan=\"11\">【売上明細】</td> \n";
    $html_m .= "</tr>\n";
    foreach ($ary_genkin_kake as $key_g_k => $value_g_k){
        foreach ($ary_sale_div as $key_s_d => $value_s_d){
            //if ($key_g_k != "genkin" || $key_s_d != "08"){
    // 販売区分毎
    $html_m .= "<tr class=\"Result1\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td>【".$value_g_k."売上】</td>\n";
    $html_m .= "    <td>【".$value_s_d."】</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_daily[$key_g_k."_".$key_s_d."_sale"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_halfway[$key_g_k."_".$key_s_d."_sale"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_monthly[$key_g_k."_".$key_s_d."_count"])."</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_monthly[$key_g_k."_".$key_s_d."_cost"])."</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_monthly[$key_g_k."_".$key_s_d."_sale"])."</td>\n";
    $html_m .= "</tr>\n";
            //}
        }
    // 伝票消費税
    $html_m .= "<tr class=\"Result1\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td>【".$value_g_k."売上】</td>\n";
    $html_m .= "    <td>【伝票消費税】</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_daily[$key_g_k."_tax"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_halfway[$key_g_k."_tax"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"center\">-</td>\n";
    $html_m .= "    <td align=\"center\">-</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_monthly[$key_g_k."_tax"])."</td>\n";
    $html_m .= "</tr>\n";
    // 販売管理外
    $html_m .= "<tr class=\"Result5\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td>【販売管理外商品】</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_daily[$key_g_k."_gai_sale"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_halfway[$key_g_k."_gai_sale"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_monthly[$key_g_k."_gai_count"])."</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_monthly[$key_g_k."_gai_cost"])."</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_monthly[$key_g_k."_gai_sale"])."</td>\n";
    $html_m .= "</tr>\n";
    // 伝票消費税
    $html_m .= "<tr class=\"Result2\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td><b>【合計】</b></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_total[$key_g_k."_sale"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_total[$key_g_k."_halfway"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_total[$key_g_k."_count"])."</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_total[$key_g_k."_cost"])."</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_total[$key_g_k."_monthly"])."</td>\n";
    $html_m .= "</tr>\n";
        if ($key_g_k == "genkin"){
    $html_m .= "<tr class=\"Result1\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "</tr>\n";
        }
    }

    /* 入金明細 */
    $row = 0;
    // 担当者明細時
    if ($staff_id != null && $staff_id != "0"){
        $ary_payin_trade = array(
            "39" => array(false, "現金売上"),
            "40" => array(false, "前受相殺"),
            "31" => array(false, "集金"),
        );
    // 代行明細時
    }elseif ($staff_id == "0"){
        if ($_SESSION["group_kind"] == "2"){
            $ary_payin_trade = array(
                "40" => array(false, "前受相殺"),
                "31" => array(false, "集金"),
            );
        }else{
            $ary_payin_trade = array(
                "31" => array(false, "集金"),
            );
        }
    // 支店明細時
    }elseif ($staff_id == null){
        $ary_payin_trade = array(
            // "取引区分コード" => array(銀行出力有無フラグ, "取引区分名")
            "39" => array(false, "現金売上"),
            "40" => array(false, "前受相殺"),
            "31" => array(false, "集金"),
            "32" => array(true,  "振込入金"),
            "33" => array(true,  "手形入金"),
            "34" => array(false, "相殺"),
            "35" => array(true,  "手数料"),
            "36" => array(false, "その他入金"),
            "37" => array(false, "スイット相殺"),
            "38" => array(false, "入金調整"),
        );
    }
    // 入金html作成
    $html_m .= "<tr class=\"Result3\" style=\"font-weight: bold;\">\n";
    $html_m .= "    <td colspan=\"11\">【入金明細】</td>\n";
    $html_m .= "</tr>\n";
    foreach ($ary_payin_trade as $key_trade1 => $value_trade1){
    $html_m .= "<tr class=\"Result1\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td>【".$value_trade1[1]."】</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "</tr>\n";
        if ($value_trade1[0] == true){
            foreach ($ary_payin_bank as $key_trade2 => $value_trade2){
                if ($key_trade1 == $key_trade2 && $value_trade2 != null){
                    foreach ($value_trade2 as $key_bank => $value_bank){
    $html_m .= "<tr class=\"Result1\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td>".$value_bank["bank_b_bank_cd"]."<br>".$value_bank["bank_b_bank_name"]."<br></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($value_bank["daily_amount"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($value_bank["halfway_amount"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($value_bank["monthly_count"])."</td>\n";
    $html_m .= "    <td align=\"center\">-</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($value_bank["monthly_amount"])."</td>\n";
    $html_m .= "</tr>\n";
                    }
                }
            }
        }
    $html_m .= "<tr class=\"Result2\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td><b>【合計】</b></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_payin_total[$key_trade1]["daily_amount"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_payin_total[$key_trade1]["halfway_amount"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_payin_total[$key_trade1]["monthly_count"])."</td>\n";
    $html_m .= "    <td align=\"center\">-</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_payin_total[$key_trade1]["monthly_amount"])."</td>\n";
    $html_m .= "</tr>\n";
    }

    /* 仕入明細 */
    // 支店明細時のみ
    if ($staff_id == null){
        $row = 0;
        $ary_genkin_kake    = array(
            "genkin"    => "現金",
            "kake"      => "掛",
        );
        // 仕入html作成
        $html_m .= "<tr class=\"Result3\" style=\"font-weight: bold;\">\n";
        $html_m .= "    <td colspan=\"11\">【仕入明細】</td>\n";
        $html_m .= "</tr>\n";
        foreach ($ary_genkin_kake as $key => $value){
        $html_m .= "<tr class=\"Result1\">\n";
        $html_m .= "    <td align=\"right\">".++$row."</td>\n";
        $html_m .= "    <td>【".$value."仕入】</td>\n";
        $html_m .= "    <td>【商品】</td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_daily[$key."_amount"])."</td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_halfway[$key."_amount"])."</td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_monthly[$key."_count"])."</td>\n";
        $html_m .= "    <td align=\"center\">-</td>\n";
        $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_monthly[$key."_amount"])."</td>\n";
        $html_m .= "</tr>\n";
        $html_m .= "<tr class=\"Result1\">\n";
        $html_m .= "    <td align=\"right\">".++$row."</td>\n";
        $html_m .= "    <td>【".$value."仕入】</td>\n";
        $html_m .= "    <td>【伝票消費税】</td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_daily[$key."_tax"])."</td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_halfway[$key."_tax"])."</td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td align=\"center\">-</td>\n";
        $html_m .= "    <td align=\"center\">-</td>\n";
        $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_monthly[$key."_tax"])."</td>\n";
        $html_m .= "</tr>\n";
        $html_m .= "<tr class=\"Result2\">\n";
        $html_m .= "    <td align=\"right\">".++$row."</td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td><b>【合計】</b></td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_total[$key."_amount"])."</td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_total[$key."_halfway"])."</td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_total[$key."_count"])."</td>\n";
        $html_m .= "    <td align=\"center\">-</td>\n";
        $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_total[$key."_monthly"])."</td>\n";
        $html_m .= "</tr>\n";
            if ($key == "genkin"){
        $html_m .= "<tr class=\"Result1\">\n";
        $html_m .= "    <td align=\"right\">".++$row."</td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "</tr>\n";
            }
        }
    }

    /* 支払明細 */
    // 支店明細時のみ
    if ($staff_id == null){
        $row = 0;
        $ary_payout_trade = array(
            // "取引区分コード" => array(銀行出力有無フラグ, "取引区分名")
            "49" => array(false, "現金仕入"),
            "41" => array(false, "現金支払"),
            "43" => array(true,  "振込支払"),
            "44" => array(false, "手形支払"),
            "45" => array(true,  "相殺"),
            "46" => array(false, "支払調整"),
            "47" => array(false, "その他支払"),
            "48" => array(false, "手数料"),
        );
        // 支払html作成
        $html_m .= "<tr class=\"Result3\" style=\"font-weight: bold;\">\n";
        $html_m .= "    <td colspan=\"11\">【支払明細】</td>\n";
        $html_m .= "</tr>\n";
        foreach ($ary_payout_trade as $key_trade1 => $value_trade1){
        $html_m .= "<tr class=\"Result1\">\n";
        $html_m .= "    <td align=\"right\">".++$row."</td>\n";
        $html_m .= "    <td>【".$value_trade1[1]."】</td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "</tr>\n";
            if ($value[0] == true){
                foreach ($ary_payout_bank as $key_trade2 => $value_trade2){
                    if ($key_trade1 == $key_trade2 && $value_trade2 != null){
                        foreach ($value_trade2 as $key_bank => $value_bank){
        $html_m .= "<tr class=\"Result1\">\n";
        $html_m .= "    <td align=\"right\">".++$row."</td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td>".$value_bank["bank_b_bank_cd"]."<br>".$value_bank["bank_b_bank_name"]."<br></td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td align=\"right\">".Numformat_Ortho($value_bank["daily_amount"])."</td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td align=\"right\">".Numformat_Ortho($value_bank["halfway_amount"])."</td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td align=\"right\">".Numformat_Ortho($value_bank["monthly_count"])."</td>\n";
        $html_m .= "    <td align=\"center\">-</td>\n";
        $html_m .= "    <td align=\"right\">".Numformat_Ortho($value_bank["monthly_amount"])."</td>\n";
        $html_m .= "</tr>\n";
                        }
                    }
                }
            }
        $html_m .= "<tr class=\"Result2\">\n";
        $html_m .= "    <td align=\"right\">".++$row."</td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td><b>【合計】</b></td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_payout_total[$key_trade1]["daily_amount"])."</td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_payout_total[$key_trade1]["halfway_amount"])."</td>\n";
        $html_m .= "    <td></td>\n";
        $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_payout_total[$key_trade1]["monthly_count"])."</td>\n";
        $html_m .= "    <td align=\"center\">-</td>\n";
        $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_payout_total[$key_trade1]["monthly_amount"])."</td>\n";
        $html_m .= "</tr>\n";
        }
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
    "err_flg"           => "$err_flg",
    "renew_msg"         => "$renew_msg",
));
$smarty->assign("print", array(
    //2009-10-12
    #"monthly_renew_day" => "$monthly_renew_day",
    "start_day" => "$start_day",
    "end_day"           => "$end_day",
    "staff_name"        => $ary_total_daily[1],
    "err_not_renew"     => $err_not_renew,
));
$smarty->assign("html", array(
    "html_t"            => "$html_t",
    "html_m"            => "$html_m",
));

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
