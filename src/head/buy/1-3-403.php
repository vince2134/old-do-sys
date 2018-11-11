<?php

/*
 *  履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007-05-07      -           fukuda      日次更新未実施伝票も抽出するよう修正
 *  2010-04-27      -           hashimoto-y CSV出力機能を追加（Rev.1.5）
 *   2016/01/22                amano  Button_Submit 関数でボタン名が送られない IE11 バグ対応 
 * 
 */

// ページ名 page name
$page_title = "仕入先元帳";

// 環境設定ファイル env seeting file
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_motocho.inc");

// HTML_QuickFormを作成 create
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB接続 db connect
$db_con = Db_Connect();


/****************************/
// 権限関連処理 set auth related process
/****************************/
$auth   = Auth_Check($db_con);


/****************************/
// 外部変数取得 acquire external variables
/****************************/


/****************************/
// 初期設定 initial setting
/****************************/
// 表示件数（nullの場合は全件）display items (if null then all items)
$range = null;

// 取引先区分（2: 仕入先 3: FC） trade classification (purchase client: 2 FC:2)
// 取引先区分切り替え直後の場合if its right after the change in trade classification
if ($_POST["post_client_div"] != null){
    $client_div = $_POST["post_client_div"];
// それ以外 other than that
}else{
    $client_div = ($_POST["hdn_client_div"] != null) ? $_POST["hdn_client_div"] : "3";
}

/****************************/
// 取引先区分切り替え時 when trade classification is changed
/****************************/
if ($_POST["post_client_div"] != null){

    // 取引先区分（POST用）を取引先区分（保存用）にセット set the trade classification (For POST) in trade classification (FOR SAVE)
    $set_form["hdn_client_div"]     = $_POST["post_client_div"];

    // 仕入先のフォーム値と仕入先に関するhiddenをクリア clear the form value in the purchase client and the hidden related with purchase client
    $set_form["form_client[cd1]"]   = ""; 
    $set_form["form_client[cd2]"]   = ""; 
    $set_form["form_client[name]"]  = ""; 
    $set_form["hdn_client[cd1]"]    = ""; 
    $set_form["hdn_client[cd2]"]    = ""; 
    $set_form["hdn_client[name]"]   = ""; 
    $set_form["hdn_client_id"]      = "";
    $set_form["hdn_close_day"]      = "";
    $set_form["hdn_pay_m"]          = "";
    $set_form["hdn_pay_d"]          = "";

    // 取引先区分（POST用）をクリア clear the trade classification (for post)
    $set_form["post_client_div"]    = "";

    $form->setConstants($set_form);

}


/****************************/
// クリアボタン押下時処理 process when clear button is pressed
/****************************/
if ($_POST["hdn_clear_flg"] == "true"){

    #2010-04-28 hashimoto-y
    #現在仕入先の切替は使用してないので固定値３をセットする 
    // 取引先区分設定 set the trade classification
    #$client_div = $_POST["hdn_client_div"];
    $client_div = 3;

    // クリアフラグ clear flag
    $set_form["hdn_clear_flg"]      = "";

    // 得意先検索フラグ customer search flag
    $set_form["client_search_flg"]  = "";

    // フォーム form
    $set_form["form_count_day[sy]"] = "";
    $set_form["form_count_day[sm]"] = "";
    $set_form["form_count_day[sd]"] = "";
    $set_form["form_count_day[ey]"] = "";
    $set_form["form_count_day[em]"] = "";
    $set_form["form_count_day[ed]"] = "";
    $set_form["form_client[cd1]"]   = ""; 
    $set_form["form_client[cd2]"]   = ""; 
    $set_form["form_client[name]"]  = ""; 

    #2010-04-27 hashimoto-y
    $set_form["form_output"]  = "1"; 

    // フォーム（hidden） form
    $set_form["hdn_client[cd1]"]    = ""; 
    $set_form["hdn_client[cd2]"]    = ""; 
    $set_form["hdn_client[name]"]   = ""; 
    $set_form["hdn_count_day[sy]"]  = "";
    $set_form["hdn_count_day[sm]"]  = "";
    $set_form["hdn_count_day[sd]"]  = "";
    $set_form["hdn_count_day[ey]"]  = "";
    $set_form["hdn_count_day[em]"]  = "";
    $set_form["hdn_count_day[ed]"]  = "";

    #2010-04-27 hashimoto-y
    $set_form["hdn_output"]         = "";

    // 仕入先情報保存（hidden）save purchase client info (hidden)
    $set_form["hdn_client_id"]      = "";
    $set_form["hdn_close_day"]      = "";
    $set_form["hdn_pay_m"]          = "";
    $set_form["hdn_pay_d"]          = "";

    $form->setConstants($set_form);

    // POSTをアンセット unset the POST
    unset($_POST);

}


/****************************/
// フォームパーツ定義 define the form parts
/****************************/
#2010-04-27 hashimoto-y
// 出力形式 output format
$radio = "";
$radio[] =& $form->createElement("radio", null, null, "画面", "1");
#2010-04-19 hashimoto-y
#$radio[] =& $form->createElement("radio", null, null, "帳票", "2");
#$radio[] =& $form->createElement("radio", null, null, "CSV",  "3");
$radio[] =& $form->createElement("radio", null, null, "CSV",  "2");

$form->addGroup($radio, "form_output", "");


// 集計期間 aggregate period
Addelement_Date_Range($form, "form_count_day", "集計期間", "-");

// 仕入先リンク purchase client link
if ($client_div == "3"){
    $form->addElement("link", "form_client_link", "", "#", "FC・取引先",
        "onClick=\"javascript:return Open_SubWin('../dialog/1-0-250.php',
         Array('form_client[cd1]', 'form_client[cd2]', 'form_client[name]'), 500, 450, '3-403', 1)\""
    );
}else{
    $form->addElement("link", "form_client_link", "", "#", "仕入先",
        "onClick=\"javascript:return Open_SubWin('../dialog/1-0-208.php',
         Array('form_client[cd1]', 'form_client[name]'), 500, 450, 5, 1)\""
    );
}

// 仕入先 purchase client
$text = "";
if ($client_div == "3"){
    $text[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
        onChange=\"javascript:Change_Submit('client_search_flg','#','true','form_client[cd2]');\"
        onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6);\" ".$g_form_option."\""
    );
    $text[] =& $form->createElement("static", "", "", "-");
    $text[] =& $form->createElement("text", "cd2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        onChange=\"javascript:Button_Submit('client_search_flg','#','true', this);\" ".$g_form_option."\""
    );
}else{
    $text[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
        onChange=\"javascript:Button_Submit('client_search_flg','#','true', this);\" 
        $g_form_option
    ");
}
$text[] =& $form->createElement("static", "", "", " ");
$text[] =& $form->createElement("text", "name", "", "size=\"34\" $g_text_readonly");
$form->addGroup($text, "form_client", "", "");

// 表示ボタン display button
$form->addElement("submit", "form_show_button", "表　示", "");

// クリアボタン clear button
$form->addElement("button", "form_clear_button", "クリア",
    "onClick=\"javascript:Button_Submit_1('hdn_clear_flg', '".$_SERVER["PHP_SELF"]."', 'true', this)\""
);

/*
// FCボタン FC button
$button_color = ($client_div == "2") ? $g_button_color : null;
$form->addElement("button", "form_client_button_2", "仕入先",
    $button_color." onClick=\"javascript:Button_Submit('post_client_div', '".$_SERVER["PHP_SELF"]."', '2');\"
");

// 仕入先ボタン purchase client button
$button_color = ($client_div == "3") ? $g_button_color : null;
$form->addElement("button", "form_client_button_3", "Ｆ　Ｃ",
    $button_color." onClick=\"javascript:Button_Submit('post_client_div', '".$_SERVER["PHP_SELF"]."', '3');\"
");
*/

// hidden  仕入先検索フラグ purchase client search flag
$form->addElement("hidden", "client_search_flg");

// hidden  クリアフラグ clear flag
$form->addElement("hidden", "hdn_clear_flg");

// hidden  取引先選択内容 trade client selection detail
$form->addElement("hidden", "post_client_div"); // 切り替えた取引先区分をPOSTする用 For POST of trade classification that was changed
$form->addElement("hidden", "hdn_client_div");  // 切り替えた取引先区分を保存する用 For SAVE trade classification that was changed 

// hidden  仕入先情報 purchase client info
$form->addElement("hidden", "hdn_client_id");
$form->addElement("hidden", "hdn_close_day");
$form->addElement("hidden", "hdn_pay_m");
$form->addElement("hidden", "hdn_pay_d");

// hidden  フォームデータ保存用 for save of form data
$form->addElement("hidden", "hdn_count_day[sy]");
$form->addElement("hidden", "hdn_count_day[sm]");
$form->addElement("hidden", "hdn_count_day[sd]");
$form->addElement("hidden", "hdn_count_day[ey]");
$form->addElement("hidden", "hdn_count_day[em]");
$form->addElement("hidden", "hdn_count_day[ed]");
$form->addElement("hidden", "hdn_client[cd1]");
$form->addElement("hidden", "hdn_client[cd2]");
$form->addElement("hidden", "hdn_client[name]");


/****************************/
// フォーム初期値設定 set the initial value of form
/****************************/

#2010-04-27 hashimoto-y
$def_fdata = array(
    "form_output"  => "1"
);
$form->setDefaults($def_fdata);


/****************************/
// 仕入先フォームの入力・補完処理 input or refill process of purchase client form
/****************************/
// 仕入先検索フラグがtrueの場合 if the purchase client search flag is true
if ($_POST["client_search_flg"] == "true"){

    // POSTされた仕入先コードを変数へ代入 substitute into variable the purchase client code that was POST
    $client_cd1 = $_POST["form_client"]["cd1"];
    $client_cd2 = $_POST["form_client"]["cd2"];

    // 仕入先の情報を抽出 extract the purchase client info
    $sql  = "SELECT \n";
    $sql .= "   client_id, \n";
    $sql .= "   client_cname \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "WHERE \n";
    $sql .= "   client_cd1 = '$client_cd1' \n";
    if ($client_div == "3"){
    $sql .= "AND \n";
    $sql .= "   client_cd2 = '$client_cd2' \n";
    }
    $sql .= "AND \n";
    $sql .= ($client_div == "2") ? "   client_div = '2' \n" : "   client_div = '3' \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // 該当データがある場合 if there is a matching data
    if ($num > 0){
        $client_id      = pg_fetch_result($res, 0, 0);      // 仕入先ID purchase client ID
        $client_cname   = pg_fetch_result($res, 0, 1);      // 仕入先名（略称）purchase client name (abbreviation)
    }else{
        $client_id      = "";
        $client_cname   = "";
    }
    // 仕入先コード入力フラグをクリア clear the input purchase client code flag
    // 仕入先ID、仕入先名（略称）、請求先区分をフォームにセット set purchase client code ID, purchsae client name (abbreviation) and billing client classification to the form
    $client_data["client_search_flg"]   = "";
    $client_data["hdn_client_id"]       = $client_id;
    $client_data["form_client"]["name"] = $client_cname;
    $form->setConstants($client_data);

}


/****************************/
// エラーチェック error check
/****************************/
// 表示ボタン押下時 when display button is pressed
if ($_POST["form_show_button"] != null){

    // 表示ボタン押下フラグ作成 craete a flag for when display button is presed
    $post_show_flg = true;

    // POSTデータを変数に代入 substitute POST data to the variable
    $output         = $_POST["form_output"];
    $start_y        = ($_POST["form_count_day"]["sy"] != null) ? str_pad($_POST["form_count_day"]["sy"], 4, 0, STR_POS_LEFT) : null;
    $start_m        = ($_POST["form_count_day"]["sm"] != null) ? str_pad($_POST["form_count_day"]["sm"], 2, 0, STR_POS_LEFT) : null;
    $start_d        = ($_POST["form_count_day"]["sd"] != null) ? str_pad($_POST["form_count_day"]["sd"], 2, 0, STR_POS_LEFT) : null;
    $end_y          = ($_POST["form_count_day"]["ey"] != null) ? str_pad($_POST["form_count_day"]["ey"], 4, 0, STR_POS_LEFT) : null;
    $end_m          = ($_POST["form_count_day"]["em"] != null) ? str_pad($_POST["form_count_day"]["em"], 2, 0, STR_POS_LEFT) : null;
    $end_d          = ($_POST["form_count_day"]["ed"] != null) ? str_pad($_POST["form_count_day"]["ed"], 2, 0, STR_POS_LEFT) : null;
    $client_cd1     = $_POST["form_client"]["cd1"];
    $client_cd2     = $_POST["form_client"]["cd2"];
    $client_cname   = $_POST["form_client"]["name"];

    // ■集計期間 aggregate period
    // エラーメッセージ error message 
    $err_msg = "集計期間の日付が妥当ではありません。";

    // 必須チェック required field
    $form->addGroupRule("form_count_day", array(
        "sy" => array(array($err_msg, "required")),
        "sm" => array(array($err_msg, "required")),
        "sd" => array(array($err_msg, "required")),
        "ey" => array(array($err_msg, "required")),
        "em" => array(array($err_msg, "required")),
        "ed" => array(array($err_msg, "required")),
    ));

    // 数値チェック value check
    $form->addGroupRule("form_count_day", array(
        "sy" => array(array($err_msg, "regex", "/^[0-9]+$/")),
        "sm" => array(array($err_msg, "regex", "/^[0-9]+$/")),
        "sd" => array(array($err_msg, "regex", "/^[0-9]+$/")),
        "ey" => array(array($err_msg, "regex", "/^[0-9]+$/")),
        "em" => array(array($err_msg, "regex", "/^[0-9]+$/")),
        "ed" => array(array($err_msg, "regex", "/^[0-9]+$/")),
    ));

    // どれか1つでも入力がある場合 if there is any input in one of them
    if ($start_y != null || $start_m != null || $start_d != null ||
        $end_y   != null || $end_m   != null || $end_d   != null){

        // 日付妥当性チェック（開始）check the validity of the date (start)
        if (!checkdate((int)$start_m, (int)$start_d, (int)$start_y)){
            $form->setElementError("form_count_day", $err_msg);
        }

        // 日付妥当性チェック（終了）check the validity of the date (end)
        if (!checkdate((int)$end_m,   (int)$end_d,   (int)$end_y)){
            $form->setElementError("form_count_day", $err_msg);
        }

    }

    // ■仕入先 purchase client 
    // エラーメッセージ error message
    $err_msg = "正しい 仕入先コード を入力して下さい。";

    // 必須チェック required field 
    if ($client_div == "3"){
        $form->addGroupRule("form_client", array(
            "cd1"   => array(array($err_msg, "required")),
            "cd2"   => array(array($err_msg, "required")),
            "name"  => array(array($err_msg, "required")),
        ));
    }else{
        $form->addGroupRule("form_client", array(
            "cd1"   => array(array($err_msg, "required")),
            "name"  => array(array($err_msg, "required")),
        ));
    }

    // 数値チェック value check
    if ($client_div == "3"){
        $form->addGroupRule("form_client", array(
            "cd1"   => array(array($err_msg, "regex", "/^[0-9]+$/")),
            "cd2"   => array(array($err_msg, "regex", "/^[0-9]+$/")),
        ));
    }else{
        $form->addGroupRule("form_client", array(
            "cd1"   => array(array($err_msg, "regex", "/^[0-9]+$/")),
        ));
    }

    // 仕入先コードの妥当性チェック check the vailidty of the purchae client code
    $sql  = "SELECT \n";
    $sql .= "   client_id, \n";
    $sql .= "   client_cd1, \n";
    $sql .= "   client_cd2, \n";
    $sql .= "   client_cname, \n";
    $sql .= "   close_day, \n";
    $sql .= "   payout_m, \n";
    $sql .= "   payout_d \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "WHERE \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   client_cd1 = '$client_cd1' \n";
    if ($client_div == "3"){
    $sql .= "AND \n";
    $sql .= "   client_cd2 = '$client_cd2' \n";
    }
    $sql .= "AND \n";
    $sql .= ($client_div == "2") ? "   client_div = '2' \n" : "   client_div = '3' \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        // 仕入先が存在する場合は該当仕入先情報を変数に代入
        $client_id      = pg_fetch_result($res, 0, 0);
        $client_cd1     = pg_fetch_result($res, 0, 1);
        $client_cd2     = pg_fetch_result($res, 0, 2);
        #2010-04-27 hashimoto-y
        #$client_cname   = htmlspecialchars(pg_fetch_result($res, 0, 3));
        $client_cname   = htmlspecialchars($csv_client_cname = pg_fetch_result($res, 0, 3));

        $close_day      = pg_fetch_result($res, 0, 4);
        $pay_m          = pg_fetch_result($res, 0, 5);
        $pay_d          = pg_fetch_result($res, 0, 6);
    }else{
        // 仕入先が存在しない場合はエラーをセット set an error if the purchase client does not exist
        $form->setElementError("form_client", $err_msg);
    }

    /****************************/
    // エラーチェック/結果集計 error check/aggregate result
    /****************************/
    // チェック適用 apply check
    $form->validate();
    // 結果をフラグに flag the result
    $err_flg = (count($form->_errors) > 0) ? true : false;

    /****************************/
    // hiddenセット set to hidden
    /****************************/
    // エラーの無い場合 if no error
    if ($err_flg != true){
        // フォームの値をhiddenにセット set the value of the form to hidden
        $hdn_set["hdn_output"]          = stripslashes($_POST["form_output"]);
        $hdn_set["hdn_count_day"]["sy"] = stripslashes($_POST["form_count_day"]["sy"]);
        $hdn_set["hdn_count_day"]["sm"] = stripslashes($_POST["form_count_day"]["sm"]);
        $hdn_set["hdn_count_day"]["sd"] = stripslashes($_POST["form_count_day"]["sd"]);
        $hdn_set["hdn_count_day"]["ey"] = stripslashes($_POST["form_count_day"]["ey"]);
        $hdn_set["hdn_count_day"]["em"] = stripslashes($_POST["form_count_day"]["em"]);
        $hdn_set["hdn_count_day"]["ed"] = stripslashes($_POST["form_count_day"]["ed"]);
        $hdn_set["hdn_client"]["cd1"]   = stripslashes($_POST["form_client"]["cd1"]);
        $hdn_set["hdn_client"]["cd2"]   = stripslashes($_POST["form_client"]["cd2"]);
        $hdn_set["hdn_client"]["name"]  = stripslashes($_POST["form_client"]["name"]);
        // 仕入先情報をhiddenにセット set the purchase client info to hidden
        $hdn_set["hdn_client_id"]       = $client_id;
        $hdn_set["hdn_close_day"]       = $close_day;
        $hdn_set["hdn_pay_m"]           = $pay_m;
        $hdn_set["hdn_pay_d"]           = $pay_d;
        $form->setConstants($hdn_set);
    }

}


/****************************/
// ページ遷移時の処理 process when the page transition
/****************************/
// 表示ボタン未押下かつ仕入先検索フラグnullかつページ数がPOSTされている場合 if display button is not pressed, purchaese client search is null, and page number is POST 
if ($_POST["form_show_button"] == null && $_POST["client_search_flg"] == null && $_POST["f_page1"] != null){

    // ページ遷移フラグ作成 create page transition flag
    $post_page_flg = true;

    // hiddenの仕入先情報を変数に代入 substitute the, purchase client info that is hidden, to variable
    $client_id      = $_POST["hdn_client_id"];
    $close_day      = $_POST["hdn_close_day"];
    $pay_m          = $_POST["hdn_pay_m"];
    $pay_d          = $_POST["hdn_pay_d"];

    // hiddenの検索データを変数に代入 substitute the search data that is hiddent to the variable
    $output         = $_POST["hdn_output"];
    $start_y        = ($_POST["hdn_count_day"]["sy"] != null) ? str_pad($_POST["hdn_count_day"]["sy"], 4, 0, STR_POS_LEFT) : null;
    $start_m        = ($_POST["hdn_count_day"]["sm"] != null) ? str_pad($_POST["hdn_count_day"]["sm"], 2, 0, STR_POS_LEFT) : null;
    $start_d        = ($_POST["hdn_count_day"]["sd"] != null) ? str_pad($_POST["hdn_count_day"]["sd"], 2, 0, STR_POS_LEFT) : null;
    $end_y          = ($_POST["hdn_count_day"]["ey"] != null) ? str_pad($_POST["hdn_count_day"]["ey"], 4, 0, STR_POS_LEFT) : null;
    $end_m          = ($_POST["hdn_count_day"]["em"] != null) ? str_pad($_POST["hdn_count_day"]["em"], 2, 0, STR_POS_LEFT) : null;
    $end_d          = ($_POST["hdn_count_day"]["ed"] != null) ? str_pad($_POST["hdn_count_day"]["ed"], 2, 0, STR_POS_LEFT) : null;
    $client_cd1     = $_POST["hdn_client"]["cd1"];
    $client_cd2     = $_POST["hdn_client"]["cd2"];
    $client_cname   = htmlspecialchars(stripslashes($_POST["hdn_client"]["name"]));

    // hiddenの検索データをフォームにセット set the search data that is hidden to form
    $form_set["form_output"]            = stripslashes($_POST["hdn__output"]);
    $form_set["form_count_day"]["sy"]   = stripslashes($_POST["hdn_count_day"]["sy"]);
    $form_set["form_count_day"]["sm"]   = stripslashes($_POST["hdn_count_day"]["sm"]);
    $form_set["form_count_day"]["sd"]   = stripslashes($_POST["hdn_count_day"]["sd"]);
    $form_set["form_count_day"]["ey"]   = stripslashes($_POST["hdn_count_day"]["ey"]);
    $form_set["form_count_day"]["em"]   = stripslashes($_POST["hdn_count_day"]["em"]);
    $form_set["form_count_day"]["ed"]   = stripslashes($_POST["hdn_count_day"]["ed"]);
    $form_set["form_client"]["cd1"]     = stripslashes($_POST["hdn_client"]["cd1"]);
    $form_set["form_client"]["cd2"]     = stripslashes($_POST["hdn_client"]["cd2"]);
    $form_set["form_client"]["name"]    = stripslashes($_POST["hdn_client"]["name"]);
    $form->setConstants($form_set);

}


/****************************/
// 表示データ取得 acquire display data 
/****************************/
// 表示ボタン押下フラグtrue＋エラーの無い場合、またはページ遷移時 when page transitioned or flag for when display button is pressed is true + no error
if (($post_show_flg == true && $err_flg != true) || $post_page_flg == true){

    // POSTされた日付データを日付の型に format the date data that was POST into date format
    $start_day  = $start_y."-".$start_m."-".$start_d;
    $end_day    = $end_y."-".$end_m."-".$end_d;

    /****************************/
    // 割賦残高取得 acquire installment balance
    /****************************/
    $sql = Buy_Split_Balance_Sql($end_day, $client_id);
    $res = Db_Query($db_con, $sql);
    $num = pg_num_rows($res);
    // 割賦データがある場合 if there is an installment data
    if ($num > 0){
        $split_balance_amount = pg_fetch_result($res, 0, 0);
    }

    /****************************/
    // 買掛データ取得 acquire payable data
    /****************************/
    // 繰越残高取得 acquire balance
    $ap_balance_amount = Get_Balance_Amount($db_con, $start_day, $client_id, "ap");

    // 取得件数設定 set acquire items 
    $limit      =  ($range != null) ? $range : null;
    // 取得開始位置設定 set the position for starting of acquire
    $offset     = ($post_show_flg == true) ? 0 : ($_POST["f_page1"] - 1) * $range;
    // 表示させるページ page to display 
    $page_count = ($post_show_flg == true) ? 1 : $_POST["f_page1"];

    // ページ遷移時かつ1ページ目でない場合 if its not the first page when page transitioned
    if ($post_page_flg == true && $_POST["f_page1"] != "1"){
        // 表示するページより前のページの伝票明細データを取得（ページ遷移時の繰越残高取得用）acquire the slip detail data of the page previous to the one that will be displayed
        $sql = Ap_Particular_Sql($start_day, $end_day, $client_id, $offset);
        $res = Db_Query($db_con, $sql);
        $num = pg_num_rows($res);
        $balance_particular_data = ($num > 0) ? Get_Data($res, 2, "ASSOC") : array(null);
    }

    // 伝票明細データの全件数取得 acquire all items of the slip detail data
    $sql = Ap_Particular_Sql($start_day, $end_day, $client_id);
    $res = Db_Query($db_con, $sql);
    $total_count = pg_num_rows($res);
    $count_particular_data  = ($total_count > 0) ? Get_Data($res, 2, "ASSOC") : array(null);

    // 伝票明細データ取得（データが無い場合は空配列作成）acquire the slip detail data (if ther eis no data then create a blank array)
    $sql = Ap_Particular_Sql($start_day, $end_day, $client_id, $limit, $offset);
    $res = Db_Query($db_con, $sql);
    $num = pg_num_rows($res);
    $ary_particular_data    = ($num > 0) ? Get_Data($res, 2, "ASSOC") : array(null);

    // 全件表示の場合 if all items is being displayed
    $range = ($range == null) ? $total_count : $range;

    /****************************/
    // 売掛データ取得 acquire the sales receivable data
    /****************************/
    // 繰越残高取得 acquire balance
    $ar_balance_amount = Get_Balance_Amount($db_con, $start_day, $client_id, "ar");

    // 伝票明細データ取得（データが無い場合は空配列作成）acquire slip detail data (if there is no data then create a blank array)
    $sql = Ar_Particular_Sql($start_day, $end_day, $client_id);
    $res = Db_Query($db_con, $sql);
    $num = pg_num_rows($res);
    $ary_ar_particular_data    = ($num > 0) ? Get_Data($res, 2, "ASSOC") : array(null);

    // 買掛残高算出 compute payable balance 
    foreach ($ary_ar_particular_data as $key => $value){
        $ar_balance_amount += ($value["sale_amount"] - $value["payin_amount"]);
    }

}


/****************************/
// 取得した表示用データの整形 fornat the acquire "for display" data
/****************************/
// 表示ボタン押下フラグtrue＋エラーが無い場合、またはページ遷移時  hen page transitioned or flag for when display button is pressed is true + no error
if (($post_show_flg == true && $err_flg != true) || $post_page_flg == true){

    // 締日 closing date
    $close_day  = ($close_day == "29") ? "月末" : $close_day."日";

    // 支払日 payment date
    $pay_m = ($pay_m == "0")  ? "当月"  : $pay_m;
    $pay_m = ($pay_m == "1")  ? "翌月"  : $pay_m;
    $pay_m = ($pay_m != "当月" && $pay_m != "翌月") ? $pay_m."ヶ月後" : $pay_m;
    $pay_d = ($pay_d == "29") ? "月末"  : $pay_d."日";

    // 仕入額/支払額の合計算出（最終ページ用） compute the total of purchase client amount or payment amount (for the last page)
    foreach ($count_particular_data as $key => $value){
        $sum_buy_amount    += $value["buy_amount"];
        $sum_payout_amount  += $value["payout_amount"];
    }

    // ページ遷移時かつ1ページ目でない場合 if its not the first page when page transitioned
    if ($post_page_flg == true && $_POST["f_page1"] != "1"){
        // 表示するページより前のページの伝票明細データを元に、表示するページに出力する残高を算出 compute the balance that will be outputted in the display page from the slip detail data of the previous page
        foreach ($balance_particular_data as $key => $value){
            $ap_balance_amount += ($value["buy_amount"] - $value["payout_amount"]);
        }
    }

    // 残高計算用初期値設定 initial value setting for balance computation
    $each_balance_amount = $ap_balance_amount;

    // 行数初期値 initial value of row number
    $row_num = 0;

    // 伝票明細データ slip detail data
    foreach ($ary_particular_data as $key => $value){

        // 前/次の参照行を配列に入れて使いやすくしておく put the previous/next reference row to the array
        $back = $ary_particular_data[$key-1];
        $next = $ary_particular_data[$key+1];

        ///// 明細の種類（仕入|支払|一括消費税|ロイヤリティ）type of "details" (purchae, payment, lump tax amount, royalty)
        // 仕入明細フラグtrue purchase detail flag true
        if ($value["buy_flg"] == "t"){
            $disp_particular_data[$key]["type"] = "buy";
        // 支払明細フラグtrue payment detail flag is true
        }elseif ($value["payout_flg"] == "t"){
            $disp_particular_data[$key]["type"] = "payout";
        // 一括消費税フラグtrue tax amount flag is true 
        }elseif ($value["lumptax_flg"] == "t"){
            $disp_particular_data[$key]["type"] = "lumptax";
        // ロイヤリティフラグtrue royalty flag is true 
        }elseif ($value["royalty_flg"] == "t"){
            $disp_particular_data[$key]["type"] = "royalty";
        }

        ///// 年の出力設定 ouput setting for year 
        // 配列の最初、または前回と今回の年が異なる場合 if its the beginning of an array, or if the year last time and this time is different
        if ($key == 0 ||
            substr($back["trade_day"], 0, 4) != substr($value["trade_day"], 0, 4)
        ){
            $trade_y        = substr($value["trade_day"], 0, 4);
        }else{
            $trade_y        = null;
        }

        ///// 月日の出力設定 output setting for month and day
        // 年がnull、かつ前回と今回の月日が同じ場合 if year is null and the month and day is the same with the last time
        if ($trade_y == null &&
            substr($back["trade_day"], 5) == substr($value["trade_day"], 5)
        ){
            $trade_d        = null;
        }else{
            $trade_d        = substr($value["trade_day"], 5);
        }

        ///// 伝票番号の出力設定 output setting for slip number
        // 月日がnull、かつ前回と今回の伝票番号が同じ、かつ前回と今回で明細の種類に変化がない場合 if the month/day is null, and the slip number is the same wit h the last time, and if there is no change in the type of "detail" 
        if ($trade_d == null &&
            $back["slip_no"] == $value["slip_no"] &&
            $disp_particular_data[$key-1]["type"] == $disp_particular_data[$key]["type"]
        ){
            $slip_no        = null;
        }else{
            $slip_no        = $value["slip_no"];
        }

/*
        ///// 伝票番号の表示位置設定 set the display position of slip number
        // 明細の種類が一括消費税またはロイヤリティの場合 if the type of detail is lump tax amount or royalty
        if ($disp_particular_data[$key]["type"] == "lumptax" || $disp_particular_data[$key]["type"] == "royalty"){
            $slip_align     = " align=\"center\" ";
        }else{
            $slip_align     = null;
        }
*/

        ///// 担当者の出力設定 output setting for assigned staff
        // 伝票番号がある場合 if there is slip number
        if ($slip_no != null){
            #2010-04-27 hashimoto-y
            #$c_staff        = htmlspecialchars($value["c_staff"]);
            $c_staff        = htmlspecialchars( $csv_c_staff = $value["c_staff"] );
        }else{
            #2010-04-27 hashimoto-y
            #$c_staff        = null;
            $c_staff        = $csv_c_staff = null;
        }

        ///// 行色設定 set row color 
        // 伝票番号がある場合 if there is slip number 
        if ($slip_no != null){
            $disp_particular_data[$key]["row_col"] = (bcmod(++$row_num, 2) == 0)    ? "Result1" : "Result2";
        }else{
            $disp_particular_data[$key]["row_col"] = (bcmod($row_num, 2) == 0)      ? "Result1" : "Result2";
        }

        ///// 取引区分の出力設定 output setting for trade classification
        // 伝票番号がnull、かつ前回と今回の取引区分が同じ場合 if slip number is null and the trade classification is the same with the last time
        if ($slip_no == null &&
            $back["trade_cd"] == $value["trade_cd"]
        ){
            $trade_cd       = null;
        }else{
            $trade_cd       = $value["trade_cd"];
        }

        ///// 商品名の表示位置設定 set the display position of product name
        // 消費税フラグtrue、または一括消費税フラグtrue、またはロイヤリティフラグtrueの場合 if the tax flag is true, or lump tax amount flag is true, or royalty flag is true 
        if ($value["tax_flg"] == "t" || $value["lumptax_flg"] == "t" || $value["royalty_flg"] == "t"){
            $goods_align    = " align=\"right\"";
        }else{
            $goods_align    = null;
        }

        ///// 数量の出力設定 output setting of quantity
        // 数量がない、または支払額がある場合 if there is no quantity or if there is a payment amount
        if ($value["num"] == null || $value["payout_amount"] != null){
            $num            = null;
        }else{
            $num            = number_format($value["num"]);
        }

        ///// 単価の出力設定 output setting of the price per unit
        // 数量がない、または支払額がある、または伝票番号がない場合 if there is no quantity, or if there is payment, or if there is no slip number
        if ($value["num"] == null || $value["payout_amount"] != null || $value["slip_no"] == null){
            $buy_price      = null;
        }else{
            $buy_price      = number_format($value["buy_price"], 2);
        }

        ///// 仕入額の出力設定 output setting for purchase amount
        // 仕入額がある場合 if there is a purchase amount
        if ($value["buy_amount"] != null){
            $buy_amount     = number_format($value["buy_amount"]);
        }else{
            $buy_amount     = null;
        }

        ///// 支払額の出力設定 output setting for payment amount
        // 支払の場合 if its a payment
        if ($value["payout_amount"] != null){
            $payout_amount  = number_format($value["payout_amount"]);
        }else{
            $payout_amount  = null;
        }

        // 残高算出 compute the balance
        $each_balance_amount+= ($value["buy_amount"] - $value["payout_amount"]);

        ///// 残高の出力設定 output setting for balance
        // 仕入伝票の場合は、伝票消費税フラグtrueの場合 if its a purchase slip, this is when slip tax flag is true
        // 支払伝票の場合は、今回と次回で伝票番号が異なるまたは次回が支払明細で無い場合 if its a payment slip, this is when the slip number is different from last time or when there is no next payment detail 
        // 一括消費税の場合、ロイヤリティの場合 if its a lumo tax amount or royalty
        if (
            ($value["buy_flg"]  == "t" && ($value["tax_flg"] == "t")) ||
            ($value["payout_flg"] == "t" && ($value["slip_no"] != $next["slip_no"] || $next["payout_amount"] == null)) ||
            ($value["lumptax_flg"] == "t") ||
            ($value["royalty_flg"] == "t")
        ){
            $print_balance_amount = number_format($each_balance_amount);
        }else{
            $print_balance_amount = null;
        }

        ///// 備考の出力設定 output setting for remark
        // 仕入伝票時は伝票内の1行目のみ出力（売上：ヘッダ、支払：データに備考が登録されているため）output only the first row of the slip if its a purchase slip (since remark is registered in sale: header and payment: data)
        if (    
            ($value["buy_flg"] == "t" && $slip_no != null) ||
            $value["payout_flg"] == "t"
        ){      
            #2010-04-27 hashimoto-y
            #$note           = nl2br(htmlspecialchars($value["note"]));
            $note           = nl2br(htmlspecialchars( $csv_note = $value["note"]));
        }else{  
            #2010-04-27 hashimoto-y
            #$note           = null; 
            $note           = $csv_note = null; 
        }

        #2010-04-27 hashimoto-y
        ///// まとめ all in all
        // 年 year
        #$disp_particular_data[$key]["trade_y"]          = $trade_y;
        $disp_particular_data[$key]["trade_y"]          = $csv_page_data[$key][0]  = $trade_y;

        // 月日 month and day
        #$disp_particular_data[$key]["trade_m"]          = $trade_d;
        $disp_particular_data[$key]["trade_m"]          = $csv_page_data[$key][1]  = $trade_d;

        // 伝票No. slip number
        #$disp_particular_data[$key]["slip_no"]          = $slip_no;
        $disp_particular_data[$key]["slip_no"]          = $csv_page_data[$key][2]  = $slip_no;

        // 伝票No.の表示位置 dispaly position of slip number
        //$disp_particular_data[$key]["slip_align"]       = $slip_align;
        // 担当者 assigned staff
        #$disp_particular_data[$key]["c_staff"]          = $c_staff;
        $disp_particular_data[$key]["c_staff"]          = $c_staff;
        $csv_page_data[$key][3]                         = $csv_c_staff;

        // 取引区分 trade classification
        #$disp_particular_data[$key]["trade_cd"]         = $trade_cd;
        $disp_particular_data[$key]["trade_cd"]         = $csv_page_data[$key][4]  = $trade_cd;

        // 商品名 product name
        #$disp_particular_data[$key]["goods_name"]       = htmlspecialchars($value["goods_name"]);
        $disp_particular_data[$key]["goods_name"]       = htmlspecialchars($value["goods_name"]);
        $csv_page_data[$key][5]                         = $value["goods_name"];

        // 商品名の表示位置 display position of product name
        $disp_particular_data[$key]["goods_align"]      = $goods_align;

        // 数量 quantity
        #$disp_particular_data[$key]["num"]              = $num;
        $disp_particular_data[$key]["num"]              = $csv_page_data[$key][6]  = $num;

        // 単価 price per unit
        #$disp_particular_data[$key]["buy_price"]        = $buy_price;
        $disp_particular_data[$key]["buy_price"]        = $csv_page_data[$key][7]  = $buy_price;

        // 仕入額 purchase amount
        #$disp_particular_data[$key]["buy_amount"]       = $buy_amount;
        $disp_particular_data[$key]["buy_amount"]       = $csv_page_data[$key][8]  = $buy_amount;

        // 支払額 payment amount
        #$disp_particular_data[$key]["payout_amount"]    = $payout_amount;
        $disp_particular_data[$key]["payout_amount"]    = $csv_page_data[$key][9]  = $payout_amount;

        // 残高 balance
        #$disp_particular_data[$key]["balance_amount"]   = $print_balance_amount;
        $disp_particular_data[$key]["balance_amount"]   = $csv_page_data[$key][10] = $print_balance_amount;

        // 備考 remarks
        #$disp_particular_data[$key]["note"]             = $note;
        $disp_particular_data[$key]["note"]             = $note;
        $csv_page_data[$key][11]                        = $csv_note;

    }

}


#2010-04-27 hashimoto-y
#CSV処理追加 add CSV process
if ($post_show_flg == true && $err_flg != true &&  $_POST["form_output"] == 2){

    $csv_header = array(
            "年",
            "月日",
            "伝票No.",
            "担当者",
            "取区",
            "商品",
            "数量",
            "単価",
            "仕入",
            "支払",
            "残高",
            "備考",
          );

    #繰越残高 balance
    $balance_carried = array("","","","","","繰越残高","","","","",number_format($ap_balance_amount),"","");
    array_unshift($csv_page_data, $balance_carried);

    #残高合計 balance total
    $total_balance = array("","","","","","合計","","",number_format($sum_buy_amount),number_format($sum_payout_amount),number_format($each_balance_amount),"","");
    array_push($csv_page_data, $total_balance);

    #ヘッダ追加 ad dheader
    #array_unshift($csv_page_data, $csv_addheader);

    #$csv_file_name = "取引先元帳".date("Ymd").".csv";
    $csv_file_name = "仕入先元帳_". $csv_client_cname .$end_y .$end_m .$end_d .".csv";

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($csv_page_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;

}


/****************************/
// HTML作成 create html
/****************************/
// 表示ボタン押下フラグtrue＋エラーが無い場合、またはページ遷移時 when page transitioned or flag for when display button is pressed is true + no error
if (($post_show_flg == true && $err_flg != true) || $post_page_flg == true){

    // ページ分け page division
    $html_page  = ($range != $total_count) ? Html_Page($total_count, $page_count, 1, $range) : "全 <b>$total_count</b> 件";
    $html_page2 = ($range != $total_count) ? Html_Page($total_count, $page_count, 2, $range) : null;

    // 仕入先情報１（コード、名前）purchase client information 1 (code, name)
    $html_1  = "<span style=\"font: bold 16px; color: #555555;\">";
    if ($client_div == "2"){
    $html_1 .= $client_cd1."　".$client_cname;
    }else{
    $html_1 .= $client_cd1."-".$client_cd2."　".$client_cname;
    }
    $html_1 .= "</span>\n";

    // FC・取引先情報２ FC・trade client info 2
    $html_2 .= "<table class=\"List_Table\" border=\"1\">\n";
    $html_2 .= "<col width=\"60\" style=\"font-weight: bold;\">\n";
    $html_2 .= "<col width=\"120\">\n";
    $html_2 .= "<col width=\"60\" style=\"font-weight: bold;\">\n";
    $html_2 .= "<col width=\"120\">\n";
    $html_2 .= "    <tr>\n";
    $html_2 .= "        <td class=\"Title_Pink\">締日</td>\n";
    $html_2 .= "        <td class=\"Value\">$close_day</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">支払日</td>\n";
    $html_2 .= "        <td class=\"Value\">".$pay_m."の".$pay_d."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "</table>\n";

    $html_2 .= "        </td>\n";
    $html_2 .= "        <td align=\"right\">\n";

    $html_2 .= "<table class=\"List_Table\" border=\"1\">\n";
    $html_2 .= "<col width=\"70\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_2 .= "<col width=\"80\">\n";
    if ($client_div == "3"){
    $html_2 .= "    <tr>\n";
    $html_2 .= "        <td class=\"Td_Search_3\">売掛残高</td>\n";
    $html_2 .= "        <td class=\"Value\" align=\"right\"".Font_Color($ar_balance_amount).">".number_format($ar_balance_amount)."</td>\n";
    $html_2 .= "    </tr>\n";
    }
    $html_2 .= "    <tr>\n";
    $html_2 .= "        <td class=\"Title_Pink\">買掛残高</td>\n";
    $html_2 .= "        <td class=\"Value\" align=\"right\"".Font_Color($each_balance_amount).">".number_format($each_balance_amount)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "    <tr>\n";
    $html_2 .= "        <td class=\"Title_Pink\">割賦残高</td>\n";
    $html_2 .= "        <td class=\"Value\" align=\"right\"".Font_Color($split_balance_amount).">".number_format($split_balance_amount)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "</table>\n";

    // 明細データ detail data
    $html_3  = "<table class=\"List_Table\" border=\"1\">\n";
    $html_3 .= "<col width=\"40px\">\n";
    $html_3 .= "<col width=\"40px\">\n";
    $html_3 .= "<col width=\"60px\">\n";
    $html_3 .= "<col>\n";
    $html_3 .= "<col width=\"30px\">\n";
    $html_3 .= "<col>\n";
    $html_3 .= "<col width=\"40px\">\n";
    $html_3 .= "<col width=\"80px\" span=\"4\">\n";
    $html_3 .= "<col>\n";
    $html_3 .= "    <tr align=\"center\" style=\"font-weight: bold;\">\n";
    $html_3 .= "        <td class=\"Title_Pink\">年</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">月日</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">伝票No.</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">担当者</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">取区</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">商品</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">数量</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">単価</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">仕入</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">支払</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">残高</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">備考</td>\n";
    $html_3 .= "    </tr>\n";
    $html_3 .= "    <tr class=\"Result1\">\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td align=\"right\">繰越残高</td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td align=\"right\"".Font_Color($ap_balance_amount).">".number_format($ap_balance_amount)."</td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "    </tr>\n";
    if (is_array($ary_particular_data[0])){
        foreach ($disp_particular_data as $key => $value){
    $html_3 .= "    <tr class=\"".$value["row_col"]."\">\n";
    $html_3 .= "        <td nowrap align=\"center\">".$value["trade_y"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"center\">".$value["trade_m"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"center\">".$value["slip_no"]."</td>\n";
    $html_3 .= "        <td nowrap nowrap>".$value["c_staff"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"center\">".$value["trade_cd"]."</td>\n";
    $html_3 .= "        <td nowrap nowrap ".$value["goods_align"].">".$value["goods_name"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"right\"".Font_Color($value["num"]).">".$value["num"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"right\"".Font_Color($value["buy_price"]).">".$value["buy_price"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"right\"".Font_Color($value["buy_amount"]).">".$value["buy_amount"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"right\"".Font_Color($value["payout_amount"]).">".$value["payout_amount"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"right\"".Font_Color($value["balance_amount"]).">".$value["balance_amount"]."</td>\n";
    $html_3 .= "        <td nowrap nowrap>".$value["note"]."</td>\n";
    $html_3 .= "    </tr>\n";
        }
    }
    // 合計は最終ページのみ出力 output the total only for the last page
    if ($total_count < $page_count * $range + 1){
    $html_3 .= "    <tr class=\"Result3\">\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td align=\"right\"><b>合計</b></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td align=\"right\"".Font_Color($sum_buy_amount).">".number_format($sum_buy_amount)."</td>\n";
    $html_3 .= "        <td align=\"right\"".Font_Color($sum_payout_amount).">".number_format($sum_payout_amount)."</td>\n";
    $html_3 .= "        <td align=\"right\"".Font_Color($each_balance_amount).">".number_format($each_balance_amount)."</td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "    </tr>\n";
    }
    $html_3 .= "</table>\n";

}


/****************************/
// 選択された仕入先の区分取得 acquire the purchase client classification that was selected
/****************************/
if ($_POST["form_client"]["cd1"] != null && $_POST["form_client"]["cd2"] != null){

    $sql  = "SELECT \n";
    $sql .= "   rank_cd \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "WHERE \n";
    $sql .= "   client_cd1 = '".$_POST["form_client"]["cd1"]."' \n";
    $sql .= "AND \n";
    $sql .= "   client_cd2 = '".$_POST["form_client"]["cd2"]."' \n";
    $sql .= "AND \n";
    $sql .= "   client_div = '3' \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    $rank_cd = ($num > 0) ? pg_fetch_result($res, 0, 0) : null;

    // FC・取引先区分が「仕入先」の場合は出力用メッセージ作成 create the message for output if the FC・trade client classification is purchase client
    $rank = ($rank_cd == "0100") ? " <b>仕入先</b>" : null;

}


/****************************/
// HTMLヘッダ html header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTMLフッタ html footer
/****************************/
$html_footer = Html_Footer();

/****************************/
// メニュー作成 create menu
/****************************/
$page_menu = Create_Menu_h("buy", "4");

/****************************/
// 画面ヘッダー作成 create screen header
/****************************/
$page_header = Create_Header($page_title);

/****************************/
// ページ作成 create page
/****************************/
// Render関連の設定 render related setting
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form関連の変数をassign assign form related variables
$smarty->assign("form", $renderer->toArray());

// その他の変数をassign assign other variables
$smarty->assign("var", array(
    "html_header"   => "$html_header",
    "page_menu"     => "$page_menu",
    "page_header"   => "$page_header",
    "html_footer"   => "$html_footer",
    "html_page"     => "$html_page",
    "html_page2"    => "$html_page2",
    "rank"          => "$rank",
));
$smarty->assign("html_1", "$html_1");
$smarty->assign("html_2", "$html_2");
$smarty->assign("html_3", "$html_3");

// テンプレートへ値を渡す pass the value to template
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
