<?php
/*****************************/
//  変更履歴
//      （20060920）月次更新日、請求締日のチェックを追加＜WATANABE-k＞
//       2006/10/23 07-001 kaku-m 一括設定の日付欄が空欄の場合、00と表示されないように変更
//       2006/10/23 07-004 kaku-m 仕入締日チェックのメッセージ内容を修正
//       2006/10/23 07-008 kaku-m 登録時に銀行データを保持する変数を初期化するように修正
//       2006/10/24 07-014 kaku-m 登録データチェックの取得配列の変更・チェック項目の追加・修正。支払金額の初期化。
//       2006/10/24 07-006 kaku-m 手形支払は銀行必須のチェックをするように修正
//       2006/10/25 07-005 kaku-m hidden変数・処理の追加をし、メッセージ表示を修正。
//       2006/10/25 kaku-m 登録確認画面で、登録行以外を空白に、銀行入力ないときはコンボボックスを非表示に修正
//       2006/10/26 kaku-m 予定一覧画面からの変数受け渡しをSESSIONに変更
//       2006/10/26 kaku-m GETの値チェックを追加
//       2006/12/01 kaku-m 支払先と支払日（月まで）を変更したときに、手数料を空白にするように修正
//       2007/01/24 kaku-m 仕入先区分のチェックによって、ダイアログに表示する内容を変更するため、引数を追加変更。
//       2007/01/24 kaku-m 仕入先区分のJavaScriptをonClickに変更。区分が変わったときにのみサブミットするように処理を修正
//       2007/01/24 kaku-m 「−」の表示がフリーズ画面のときに正しくなかった部分を修正
//       2007/03/27 kaku-m 日付チェック後にmktime実行場所を変更
//       2007/03/28 kaku-m 確認画面で金額をナンバーフォーマットするように修正
/*****************************/

/*
 * 履歴：
 * 　日付　　　　B票No.　　　  担当者　　　内容　
 * 　2006/12/16　scl_0083　　　watanabe-k　変更時に支払予定額が表示されないバグの修正
 * 　2007/01/07　        　　　watanabe-k　本部宛機能追加
 * 　2007/01/25　        　　　watanabe-k　ボタンの色変更
 * 　2007/06/09　        　　　watanabe-k　支払予定額に初期残高を含めないように修正
 * 　2007/07/03　        　　　watanabe-k　登録時にクエリエラーが表示されるバグの修正
 *  2007-07-12                  fukuda      「支払締」を「仕入締」に変更
 *   2007/10/22                watanabe-k  支払確認画面で一行目の金額がNumber_formatされていないバグの修正
 *  2016/01/19                  amano  Dialogue_2, Dialogue_3, Button_Submit_1 関数でボタン名が送られない IE11 バグ対応
 */

$page_title = "支払入力";

// 環境設定ファイル env setting file
require_once("ENV_local.php");

// HTML_QuickFormを作成 create 
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB接続 connect 
$db_con = Db_Connect();

// 権限チェック auth check
$auth   = Auth_Check($db_con);

// ボタンDisabled button
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/*****************************/
// 再遷移先をSESSIONにセット set the the page that will be transitioned back to SESSION
/*****************************/
// GET、POSTが無い場合 if there is no GET and POST
if ($_GET == null && $_POST == null && $_SESSION["schedule_payment_id"] == null){
    Set_Rtn_Page("payout");
}


/****************************/
// 外部変数取得 acquire external variable
/****************************/
$shop_id    = $_SESSION["client_id"];
$staff_id   = $_SESSION["staff_id"];
$staff_name = $_SESSION["staff_name"];
$group_kind = $_SESSION['group_kind'];


/****************************/
// 支払IDの取り扱い use of payment ID
/****************************/
// 支払IDがPOSTされている場合 if the payment ID is being POST
if ($_POST["pay_id"] != null){

    // POSTの支払IDを変数とhiddenにセット set the POST's payment ID in the variable and hidden
    $pay_id             = $_POST["pay_id"];
    $set_hdn["pay_id"]  = $pay_id;

    // ゲットフラグtrueを変数とhiddenにセット set the get flag true in variable and in hidden
    $get_flg            = "true";
    $set_hdn["get_flg"] = $get_flg;

}else
// GETに支払IDがある場合 if there is a payment ID in GET
if ($_GET["pay_id"] != null){

    // GETした支払IDの妥当性チェック check the validity of the payment ID that was GET
    $safe_flg = Get_Id_Check_Db($db_con, $_GET["pay_id"], "pay_id", "t_payout_h", "num", "shop_id = $shop_id");
    if ($safe_flg === false){
        header("Location:../top.php");
        exit;
    }

    // GETの支払IDを変数とhiddenにセット set the GET's payment ID in variable and in hidden
    $pay_id             = $_GET["pay_id"];
    $set_hdn["pay_id"]  = $pay_id;

    // ゲットフラグtrueを変数とhiddenにセット set the get flag true in variable and in hidden
    $get_flg            = "true";
    $set_hdn["get_flg"] = $get_flg;

}else
// POST、GETに支払IDがない場合 if there is no payment ID in POST and GET
if ($_POST["pay_id"] == null && $_GET["pay_id"] == null){

    // ゲットフラグfalseを変数とhiddenにセット set the get flag false in variable and in hidden
    $get_flg             = "";
    $set_hdn["get_flg"]  = $get_flg;

}

$form->setConstants($set_hdn);


/****************************/
// 初期設定 initial setting
/****************************/
// 表示行数 no of rows being displayed
if (isset($_POST["max_row"])){
    $max_row = $_POST["max_row"];
}else{
    $max_row = 5;
}


/****************************/
// 行数追加 add row number
/****************************/
if ($_POST["add_row_flg"]== "true"){
    // 最大行に、＋５する +5 in the max row
    $max_row = $_POST["max_row"] + 5;
    // 行数追加フラグをクリア clear the add row flag
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}


/****************************/
// 行削除処理 delete row process
/****************************/
if (isset($_POST["del_row"])){
    // 削除リストを取得 acquire the delete list
    $del_row = $_POST["del_row"];
    // 削除履歴を配列にする。 make array of delete history
    $ary_del_rows = explode(",", $del_row);
    unset($ary_del_rows[0]);
}else{
    // 削除履歴配列の初期値作成 create initial value of delete history array
    $ary_del_rows = array();
}


/***************************/
// 初期値設定 inital value setting
/***************************/
// 現在の最大行数をhiddenにセット set the current max row number in hidden
$max_data["max_row"] = $max_row;
$form->setConstants($max_data);

// 支払日（一括設定） payment date (set all at once)
$setdate["form_pay_day_all"]["y"] = date("Y");
$setdate["form_pay_day_all"]["m"] = date("m");
$setdate["form_pay_day_all"]["d"] = date("d");
$form->setDefaults($setdate);


/****************************/
// フォーム作成（固定） create form (fixed)
/****************************/
// ヘッダ部リンクボタン header link button
$ary_h_btn_list = array("照会・変更" => "./1-3-303.php", "入　力" => $_SERVER["PHP_SELF"]);
Make_H_Link_Btn($form, $ary_h_btn_list);

// 支払日（一括設定） payment (set all at once)
Addelement_Date($form, "form_pay_day_all", "", "-");

// 取引区分（一括設定） trade classification (set all at once)
$trade_value = Select_Get($db_con, "trade_payout");
unset($trade_value[48]);
unset($trade_value[49]);
$form->addElement("select", "form_trade_all", "", $trade_value, $g_form_option_select);

// 銀行（一括設定）bank (set all at once)
$bank_value = Make_Ary_Bank($db_con);
$obj    =   null;
$obj    =&  $form->addElement("hierselect", "form_bank_all", "", "", " ");
$obj->setOptions($bank_value);

// 一括設定ボタン set all at once button
$form->addElement("button", "all_set_button", "一括設定", "onClick=\"javascript: Button_Submit_1('all_set_flg', '#', 'true', this);\"");

// 行追加ボタン add row button
$form->addElement("button", "add_row_button", "行追加", "onClick=\"javascript: Button_Submit_1('add_row_flg', '#foot', 'true', this);\"");

// hidden
$form->addElement("hidden", "del_row");         // 削除行 delete row
$form->addElement("hidden", "add_row_flg");     // 追加行フラグ add row flag
$form->addElement("hidden", "max_row");         // 最大行数 max row number
$form->addElement("hidden", "layer");           // 取引先 trade partner
$form->addElement("hidden", "div_flg");         // 取引先区分 trade classification
$form->addElement("hidden", "get_flg");         // 変更・明細（支払照会から）フラグ change/detaik(from the payment inquiry)
$form->addElement("hidden", "pay_id");          // 支払ID payment ID
$form->addElement("hidden", "pay_no");          // 支払番号 payment number 
$form->addelement("hidden", "all_set_flg");     // 一括設定フラグ set all at once flag
$form->addElement("hidden", "payout_flg");      // 支払ボタン押下フラグ payment button pressed flag
$form->addElement("hidden", "date_chg");        // 日付変更サブミットフラグ change date submit flag
$form->addElement("hidden", "confirm_flg");     // 確認画面へボタン押下フラグ flag for when To confirmation screen is pressed
$form->addElement("hidden", "post_flg", "1");   // 初期表示判断用フラグ flag for determining initial display


/****************************/
// 一括設定処理 set all at once process
/****************************/
if($_POST["all_set_flg"] == "true"){

    // 支払日（一括）を0埋め fill payment date (all at once) with 0s
    $_POST["form_pay_day_all"]   = Str_Pad_Date($_POST["form_pay_day_all"]);
    $all_set["form_pay_day_all"] = $_POST["form_pay_day_all"];

    for ($i = 0; $i < $_POST["max_row"]; $i++){
        // 支払日 payment date
        $all_set["form_pay_day_$i"]["y"]    = ($_POST["form_pay_day_all"]["y"] != "") ? $_POST["form_pay_day_all"]["y"] : "";
        $all_set["form_pay_day_$i"]["m"]    = ($_POST["form_pay_day_all"]["m"] != "") ? $_POST["form_pay_day_all"]["m"] : "";
        $all_set["form_pay_day_$i"]["d"]    = ($_POST["form_pay_day_all"]["d"] != "") ? $_POST["form_pay_day_all"]["d"] : "";
        // 取引区分 trade classification
        $all_set["form_trade_$i"]           = $_POST["form_trade_all"];
        // 銀行 bank
        $all_set["form_bank_$i"][0]         = $_POST["form_bank_all"][0];
        $all_set["form_bank_$i"][1]         = $_POST["form_bank_all"][1];
        $all_set["form_bank_$i"][2]         = $_POST["form_bank_all"][2];
    }

    // 一括設定hidden set all at once setting hidden
    $all_set["all_set_flg"] = "";

    $form->setConstants($all_set);

}


/****************************/
// 仕入先コード・支払年月入力処理 supplier code/payment date input process
/****************************/
// 処理対象行番号がある場合 if there is a row number to be processed
if ($_POST["layer"] != ""){

    $row            = $_POST["layer"];                  // 行番号 row number 
    $supplier_cd    = $_POST["form_client_cd1_$row"];   // 仕入先コード１ supplier code 1
    $supplier_cd2   = $_POST["form_client_cd2_$row"];   // 仕入先コード２ supplier code 2
    $div_select     = "3";                              // 仕入先・FC・取引先区分 suppler/FC/trade classification

    // FC区分の仕入先抽出sql sql that extract FC classification`s supplier 
    $sql  = "SELECT \n";
    $sql .= "   t_client.client_id, \n";       // 仕入先ID supplier ID
    $sql .= "   t_client.client_cd1, \n";      // 仕入先コード１ supplier code 1
    $sql .= "   t_client.client_cd2, \n";      // 仕入先コード２ supplier code 2
    $sql .= "   t_client.client_cname, \n";    // 仕入先名 supplier name
    $sql .= "   t_client.b_bank_name \n";      // 振込口座略称 abbreviation for the deposti account
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    if ($client_id == ""){
        $sql .= "WHERE t_client.client_cd1 = '$supplier_cd' \n";
        $sql .= "AND   t_client.client_cd2 = '$supplier_cd2' \n";
        $sql .= "AND   t_client.client_div = '3' \n";
    }else{
        $sql .= "WHERE t_client.client_id = $client_id \n";
    }
    $sql .= " ;";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // 仕入先が存在する場合 if there is a supplier
    if ($num > 0){

        $get_data = pg_fetch_array($res);

        $set_client_data["hdn_client_id"][$row]     = $get_data["client_id"];       // 仕入先ID supplier ID
        $set_client_data["form_client_cd1_$row"]    = $get_data["client_cd1"];      // 仕入先コード１ supplier code 1
        $set_client_data["form_client_cd2_$row"]    = $get_data["client_cd2"];      // 仕入先コード２ supplier code 2
        $set_client_data["form_client_name_$row"]   = $get_data["client_cname"];    // 仕入先名 supplier name
        $set_client_data["form_pay_bank_$row"]      = $get_data["b_bank_name"];     // 振込口座略称 abbrevication for the deposit account

        // 仕入先IDを変数にセット set the supplier ID to variable
        $search_client_id = $get_data["client_id"];

        // 最新の支払金額を取得 acquire the latest payment amount
        $sql  = "SELECT \n";
        $sql .= "   t_schedule_payment.schedule_of_payment_this \n";
        $sql .= "FROM \n";
        $sql .= "   t_schedule_payment \n";
        $sql .= "WHERE \n";
        $sql .= "   t_schedule_payment.client_id = ".$get_data["client_id"]." \n";
        $sql .= "AND \n";
        $sql .= "   t_schedule_payment.first_set_flg = 'f' \n";
        $sql .= "ORDER BY \n";
        $sql .= "   payment_expected_date DESC \n";
        $sql .= "LIMIT 1 \n";
        $sql .= ";"; 
        $res  = Db_Query($db_con, $sql);

        // 予定額レコードがある場合 if there is a planned amount record
        if (pg_num_rows($res) > 0){
            $get_pay_mon = pg_fetch_result($res, 0, 0);
        // 予定額レコードなしの場合 if there is no planned amount record
        }else{
            $get_pay_mon = "";
        }

        // 金額セット set the amount
        if ($get_pay_mon != ""){
        $set_client_data["form_pay_mon_plan_$row"]  = number_format($get_pay_mon);  // 支払予定額（ナンバーフォーマット）planned payment amount (number format)
        }else{
        $set_client_data["form_pay_mon_plan_$row"]  = $get_pay_mon;                 // 支払予定額 planned payment amount
        }
        $set_client_data["form_pay_mon_$row"]       = $get_pay_mon;                 // 支払額 payment amount
        $set_client_data["form_pay_fee_$row"]       = "";                           // 手数料 fee

    // 仕入先が存在しない場合 if there is no supplier
    }else{

        $set_client_data["hdn_client_id"][$row]     = "";
        $set_client_data["form_client_name_$row"]   = "";
        $set_client_data["form_pay_bank_$row"]      = "";
        $set_client_data["form_pay_mon_plan_$row"]  = "";
        $set_client_data["form_pay_mon_$row"]       = "";
        $set_client_data["form_pay_fee_$row"]       = "";
        $search_client_id = null;

    }

    // POST情報をクリア clear the POST info
    $set_client_data["layer"]       = "";   // 行数 row number
    $set_client_data["date_chg"]    = "";   // ?
    $form->setConstants($set_client_data);

}


/****************************/
// 支払確認画面へボタン押下処理 process when the payment confirmation screen button is pressed
/****************************/
// 支払確認ボタン押下、または支払ボタン押下フラグがtrueの場合 if the flag for when payment confirmation button or payment button is pressed is true
if ($_POST["confirm_button"] == "支払確認画面へ" || $_POST["payout_flg"] == "true"){

    // 支払ボタン押下hiddenをクリア clear the pressed flag for payment button 
    $clear_hdn["payout_flg"] = "";
    $form->setconstants($clear_hdn);

    // 合計金額初期値 initialize the total amount
    $sum_pay_mon = 0;
    $sum_pay_fee = 0;

    $ary_input_id_row = null;
    // 現在の最大桁数繰り返し repeat for the current max digits
    for ($i = 0; $i < $max_row; $i++){
        // 空白行を除いた仕入先IDの配列作成 create an array of supplier ID excluding the blank rows
        if ($ary_client_id[$i] != ""){
            $ary_input_id_row[] = $i;
        }
    }

    // 仕入先ID配列を変数にセット set the supplier ID array to variable
    $ary_client_id  = $_POST["hdn_client_id"];

    // 最大行数を変数にセット set the max row number to variable
    $max_row        = $_POST["max_row"];

    // 最大行数でループ loop throught the max row number
    for ($key = 0, $row = 0; $key < $max_row; $key++){

        // 現在の参照行が削除行配列に存在しない場合 if the current reference row does not exist in the deleted row array
        if (!in_array($key, $ary_del_rows)){

            // 参照行数を加算 add the reference row number
            $row++;

            // 日付の0埋め fill the date with 0s
            $_POST["form_pay_day_$key"]     = Str_Pad_Date($_POST["form_pay_day_$key"]);
            $_POST["form_account_day_$key"] = Str_Pad_Date($_POST["form_account_day_$key"]);

            // POSTデータを変数にセット set the POST data to variable
            $post_client_id[$key]       = $_POST["hdn_client_id"][$key];           // 仕入先ID supplier ID
            $post_client_cd1[$key]      = $_POST["form_client_cd1_$key"];          // 仕入先コード１ supplier code 1
            $post_client_cd2[$key]      = $_POST["form_client_cd2_$key"];          // 仕入先コード２ supplier code 2
            $post_pay_day_y[$key]       = $_POST["form_pay_day_$key"]["y"];        // 支払日（年） payment date year
            $post_pay_day_m[$key]       = $_POST["form_pay_day_$key"]["m"];        // 支払日（月） payment date month
            $post_pay_day_d[$key]       = $_POST["form_pay_day_$key"]["d"];        // 支払日（日） payment date day
            $post_pay_bank[$key]        = $_POST["form_pay_bank_$key"];            // 振込銀行略称 deposit bank abbreviation
            $post_trade[$key]           = $_POST["form_trade_$key"];               // 取引区分 trade classification
            $post_bank[$key]            = $_POST["form_bank_$key"];                // 銀行・支店・口座（配列） bank, branch, account (array)
            $post_pay_mon[$key]         = $_POST["form_pay_mon_$key"];             // 支払額 payment amount
            $post_pay_fee[$key]         = $_POST["form_pay_fee_$key"];             // 手数料 fee
            $post_account_day_y[$key]   = $_POST["form_account_day_$key"]["y"];    // 決済日（年）settlement date year
            $post_account_day_m[$key]   = $_POST["form_account_day_$key"]["m"];    // 決済日（月）settlement date month
            $post_account_day_d[$key]   = $_POST["form_account_day_$key"]["d"];    // 決済日（日）settlement date day
            $post_payable_no[$key]      = $_POST["form_payable_no_$key"];          // 手形券面番号 bill number
            $post_note[$key]            = $_POST["form_note_$key"];                // 備考 remark

            // 支払ボタン押下時は金額のカンマ除去 take out the comma in the amount when the payment button is pressed
            if ($_POST["payout_flg"] == "true"){
                if ($post_pay_mon[$key] != null){
                    $post_pay_mon[$key] = str_replace(",", "", $post_pay_mon[$key]);
                }
                if ($post_pay_fee[$key] != null){
                    $post_pay_fee[$key] = str_replace(",", "", $post_pay_fee[$key]);
                }
            }

            // 入力のない行をカウント count the row with no input
            if ($ary_client_id[$key] == null){
                $null_row += 1;
            }

            /****************************/
            // 合計金額算出（出力用） comput the total amount (for output)
            /****************************/
            // 仕入先IDのある行のみ rows that have supplier ID
            if ($ary_client_id[$key] != null){
                $sum_pay_mon += $post_pay_mon[$key];    // 支払金額 payment amount
                $sum_pay_fee += $post_pay_fee[$key];    // 手数料 fee
            }

            /****************************/
            // エラーチェック error check
            /****************************/
            // ■仕入先 supplier
            // 必須チェック１ required field 1
            if ($ary_client_id[$key] == null && ($post_client_cd1[$key] != null || $post_client_cd2[$key] != null)){
                $form->setElementError("form_client_cd1_$key", $row."行目　正しい仕入先を入力してください。");
            }

            // 以降、一括設定以外のフォームに入力があった場合にチェックを行う from here, check only if forms that have no all at once setting had inputs
            if (
                $ary_client_id[$key]        != null ||  // 仕入先ID supplier Id
                $post_client_cd1[$key]      != null ||  // 仕入先コード１ supplier code 1
                $post_client_cd2[$key]      != null ||  // 仕入先コード２ supplier code 2
                $post_pay_mon[$key]         != null ||  // 支払金額 payment amount
                $post_pay_fee[$key]         != null ||  // 手数料 fee
                $post_account_day_y[$key]   != null ||  // 決済日（年） settlement date year
                $post_account_day_m[$key]   != null ||  // 決済日（月） settlement date month
                $post_account_day_d[$key]   != null ||  // 決済日（日） settlement date day
                $post_payable_no[$key]      != null ||  // 手形券面番号 bill number 
                $post_note[$key]            != null     // 備考 remarks
            ){

                // ■支払日 payment date
                // 必須チェック required field
                if ($post_pay_day_y[$key] == null && $post_pay_day_m[$key] == null && $post_pay_day_d[$key] == null){
                    $form->setElementError("form_pay_day_$key", $row."行目　支払日は必須です。");
                }else
                // 数値チェック check value
                if (
                    !ereg("^[0-9]+$", $post_pay_day_y[$key]) ||
                    !ereg("^[0-9]+$", $post_pay_day_m[$key]) ||
                    !ereg("^[0-9]+$", $post_pay_day_d[$key])
                ){
                    $form->setElementError("form_pay_day_$key", $row."行目　支払日が妥当ではありません。");
                }else
                // 妥当性チェック check validity
                if (!checkdate((int)$post_pay_day_m[$key], (int)$post_pay_day_d[$key], (int)$post_pay_day_y[$key])){
                    $form->setElementError("form_pay_day_$key", $row."行目　支払日が妥当ではありません。");
                // それ以外 other than that
                }else{
                    // 本日以前チェック check if its a date previous than today
                    if (date("Y-m-d") < $post_pay_day_y[$key]."-".$post_pay_day_m[$key]."-".$$post_pay_day_d[$key]){
                        $form->addElement("text", "err_pay_day_1_$key");
                        $form->setElementError("err_pay_day_1_$key", $row."行目　支払日に未来の日付が入力されています。");
                    }
                    // システム開始日以降チェック check if it is a day that was after the system started
                    $pay_day_sys_chk[$key] = Sys_Start_Date_Chk($post_pay_day_y[$key], $post_pay_day_m[$key], $post_pay_day_d[$key], "支払日");
                    if ($pay_day_sys_chk[$key] != null){
                        $form->addElement("text", "err_pay_day_2_$key");
                        $form->setElementError("err_pay_day_2_$key", $row."行目　$pay_day_sys_chk[$key]");
                    }
                    // 月次更新以降チェック check if it is after monthly update
                    if (
                        Check_Monthly_Renew(
                            $db_con,
                            $ary_client_id[$key],
                            "3",
                            $post_pay_day_y[$key],
                            $post_pay_day_m[$key],
                            $post_pay_day_d[$key]
                        ) === false
                    ){
                        $form->addElement("text", "err_pay_day_3_$key");
                        $form->setElementError("err_pay_day_3_$key", $row."行目　支払日に前回の月次更新以前の日付が入力されています。");
                    }
                    // 仕入締日以降チェック check if it is after supply closing date
                    if (
                        Check_Payment_Close_Day(
                            $db_con,
                            $ary_client_id[$key],
                            $post_pay_day_y[$key],
                            $post_pay_day_m[$key],
                            $post_pay_day_d[$key]
                        ) === false
                    ){
                        $form->addElement("text", "err_pay_day_4_$key");
                        $form->setElementError("err_pay_day_4_$key", $row."行目　支払日に前回の仕入締以前の日付が入力されています。");
                    }
                }

                // ■取引区分 trade classification
                // 必須チェック required field
                if ($post_trade[$key] == null){
                    $form->setElementError("form_trade_$key", $row."行目　取引区分は必須です。");
                }

                // ■銀行 bank
                // 全て選択チェック check the *select all* 
                if ($post_bank[$key][0] != null && $post_bank[$key][2] == null){
                    $form->setElementError("form_bank_$key", $row."行目　銀行指定時は口座番号まで指定してください。");
                }else
                // 条件付き必須チェック１ required filed check with condition 1
                if (($post_trade[$key] == "43" || $post_trade[$key] == "44") && $post_bank[$key][2] == null){
                    $form->setElementError("form_bank_$key", $row."行目　振込支払・手形支払時には口座番号を指定してください。");
                }else
                // 条件付き必須チェック２ required filed check with condition 2
                if ($post_pay_fee[$key] != null && $post_bank[$key][2] == null){
                    $form->setElementError("form_bank_$key", $row."行目　手数料入力時は銀行を指定してください。");
                }

                // ■支払金額 payment amount
                // 必須チェック required field
                if ($post_pay_mon[$key] == null){
                    $form->setElementError("form_pay_mon_$key", $row."行目　支払金額は必須です。");
                }else
                // 数値チェック value check
                if (!ereg("^[-]?[0-9]+$", $post_pay_mon[$key])){
                    $form->setElementError("form_pay_mon_$key", $row."行目　支払金額が妥当ではありません。");
                }

                // ■手数料 fee
                // 数値チェック value check
                if ($post_pay_fee[$key] != null && !ereg("^[-]?[0-9]+$", $post_pay_fee[$key])){
                    $form->setElementError("form_pay_fee_$key", $row."行目　手数料が妥当ではありません。");
                }

                // ■決済日 settlement date
                // 未入力時 if not inputted
                if ($post_account_day_y[$key] == null && $post_account_day_m[$key] == null && $post_account_day_d[$key] == null){
                    if ($post_trade[$key] == "44"){
                        $form->setElementError("form_account_day_$key", $row."行目　手形支払時には決済日を入力してください。");
                    }
                }else
                // 数値チェック value check
                if (
                    !ereg("^[0-9]+$", $post_account_day_y[$key]) ||
                    !ereg("^[0-9]+$", $post_account_day_m[$key]) ||
                    !ereg("^[0-9]+$", $post_account_day_d[$key])
                ){
                    $form->setElementError("form_account_day_$key", $row."行目　決済日が妥当ではありません。");
                }else
                // 妥当性チェック validty check
                if (!checkdate((int)$post_account_day_m[$key], (int)$post_account_day_d[$key], (int)$post_account_day_y[$key])){
                    $form->setElementError("form_account_day_$key", $row."行目　決済日が妥当ではありません。");
                }

            }

        }

    }

    // ■データ入力チェック data input check
    if ($row == $null_row){
        $form->addElement("text", "err_no_data");
        $form->setElementError("err_no_data", "支払データを入力してください。");
    }

    // ■伝票変更中に伝票削除されていた場合 if the slip was deleted while the slip was edited
    if ($get_flg == "true"){
        $sql  = "SELECT \n";
        $sql .= "   pay_id \n";
        $sql .= "FROM \n";
        $sql .= "   t_payout_h \n";
        $sql .= "WHERE \n";
        $sql .= "   pay_id = $pay_id \n";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        $num  = pg_num_rows($res);
        if ($num == 0){
            header("Location: ./1-3-305.php?err=1");
            exit;
        }
    }

    // ■伝票変更中に日次更新されていた場合 if daily update was done while the slip was edited
    if ($get_flg == "true"){
        $sql  = "SELECT \n";
        $sql .= "   pay_id \n";
        $sql .= "FROM \n";
        $sql .= "   t_payout_h \n";
        $sql .= "WHERE \n";
        $sql .= "   pay_id = $pay_id \n";
        $sql .= "AND \n";
        $sql .= "   renew_flg = 'f' \n";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        $num  = pg_num_rows($res);
        if ($num == 0){
            header("Location: ./1-3-305.php?err=2");
            exit;
        }
    }

    /****************************/
    // エラーチェック結果集計 collect error check result
    /****************************/
    // チェック適用 apply check
    $test = $form->validate();

    // 結果をフラグに flag the result
    $err_flg = (count($form->_errors) > 0) ? true : false;


    /****************************/
    // DB登録処理 registration process
    /****************************/
    // 支払ボタン押下時＋エラーのない場合 when payment button is pressed and if there is no error
    if ($_POST["payout_flg"] == "true" && $err_flg != true){

        $ary_input_id_row = null;
        // 現在の最大桁数繰り返し repeat through the current max digits
        for ($i = 0; $i < $max_row; $i++){
            // 空白行を除いた仕入先IDの配列作成 create an array of supplier ID without the blank rows
            if ($ary_client_id[$i] != ""){
                $ary_input_id_row[] = $i;
            }
        }

        // トランザクション開始 start the transaction
        Db_Query($db_con, "BEGIN;");

        // 削除行判定 determine the delete row
        foreach ($ary_input_id_row as $key){

            // 日付の0埋め fill the dates with 0s
            $_POST["form_pay_day_$key"]     = Str_Pad_Date($_POST["form_pay_day_$key"]);
            $_POST["form_account_day_$key"] = Str_Pad_Date($_POST["form_account_day_$key"]);

            // POSTデータを変数にセット set the POST data in variable
            $post_client_id[$key]       = $_POST["hdn_client_id"][$key];            // 仕入先ID supplier ID
            $post_client_cd1[$key]      = $_POST["form_client_cd1_$key"];           // 仕入先コード１ supplier code 1
            $post_client_cd2[$key]      = $_POST["form_client_cd2_$key"];           // 仕入先コード２ supplier code 2
            $post_pay_day_y[$key]       = $_POST["form_pay_day_$key"]["y"];         // 支払日（年） payment date year
            $post_pay_day_m[$key]       = $_POST["form_pay_day_$key"]["m"];         // 支払日（月）payment date month
            $post_pay_day_d[$key]       = $_POST["form_pay_day_$key"]["d"];         // 支払日（日）payment date dau
            $post_pay_bank[$key]        = $_POST["form_pay_bank_$key"];             // 振込銀行略称 deposit bank abbreviation
            $post_trade[$key]           = $_POST["form_trade_$key"];                // 取引区分 trade classifcaiton
            $post_bank[$key]            = $_POST["form_bank_$key"];                 // 銀行・支店・口座（配列） bank, branch, account (arryu)
            $post_pay_mon[$key]         = $_POST["form_pay_mon_$key"];              // 支払額 paymet
            $post_pay_fee[$key]         = $_POST["form_pay_fee_$key"];              // 手数料 fee
            $post_account_day_y[$key]   = $_POST["form_account_day_$key"]["y"];     // 決済日（年）settlement date year
            $post_account_day_m[$key]   = $_POST["form_account_day_$key"]["m"];     // 決済日（月）settlement date month
            $post_account_day_d[$key]   = $_POST["form_account_day_$key"]["d"];     // 決済日（日）settlement date dau
            $post_payable_no[$key]      = $_POST["form_payable_no_$key"];           // 手形券面番号 bill number
            $post_note[$key]            = $_POST["form_note_$key"];                 // 備考 remarks

            // 日付POSTを使いやすく to make it easy to use the date POST
            $post_pay_day[$key]     = $post_pay_day_y[$key]."-".$post_pay_day_m[$key]."-".$post_pay_day_d[$key];
            $post_account_day[$key] = $post_account_day_y[$key]."-".$post_account_day_m[$key]."-".$post_account_day_d[$key];

            // 新規支払時 if its a new payment
            if ($get_flg != "true"){

                // 最新の支払番号＋１ new payment number plus 1
                $sql  = "SELECT \n";
                $sql .= "   MAX(pay_no) AS max \n";
                $sql .= "FROM \n";
                $sql .= "   t_payout_h \n";
                $sql .= "WHERE \n";
                $sql .= "   shop_id = $shop_id \n";
                $sql .= ";";
                $res  = Db_Query($db_con, $sql);
                $pay_data    = pg_fetch_array($res);
                $pay_no_max  = $pay_data["max"];
                $pay_no_max += 1;
                $pay_no_max  = str_pad($pay_no_max, 8, "0", STR_PAD_LEFT);

                // 支払ヘッダINSERT INSERT the payment header
                $sql  = "INSERT INTO \n";
                $sql .= "   t_payout_h \n";
                $sql .= "( \n";
                $sql .= "   pay_id, \n";                // 支払ID payment ID
                $sql .= "   pay_no, \n";                // 支払番号 payment number
                $sql .= "   pay_day, \n";               // 支払日 payment date
                $sql .= "   client_id, \n";             // 仕入先ID supplier ID
                $sql .= "   client_cd1, \n";            // 仕入先コード１ supplier code 1
                $sql .= "   client_cd2, \n";            // 仕入先コード２ supplier code 2
                $sql .= "   client_name, \n";           // 仕入先名１ supplier name 1
                $sql .= "   client_name2, \n";          // 仕入先名２ supplier name  2
                $sql .= "   client_cname, \n";          // 仕入先名略称 supplier name abbreviation
                $sql .= "   input_day, \n";             // 入力日 input date
                $sql .= "   buy_id, \n";                // 仕入ID supplier ID
                $sql .= "   renew_flg, \n";             // 日次更新フラグ daily update flag
                $sql .= "   renew_day, \n";             // 日次更新日 daily update date
                $sql .= "   schedule_payment_id, \n";   // 支払予定ID planned payment ID
                $sql .= "   shop_id, \n";               // ショップID shop ID
                $sql .= "   e_staff_id, \n";            // 入力者ID entrant ID
                $sql .= "   e_staff_name, \n";          // 入力者名 entrant name 
                $sql .= "   c_staff_id, \n";            // 担当者ID staff ID
                $sql .= "   c_staff_name, \n";          // 担当者名 staff name
                $sql .= "   account_day, \n";           // 決済日 settlement date
                $sql .= "   payable_no \n";             // 手形券面番号 bill number
                $sql .= ") \n";
                $sql .= "VALUES \n";
                $sql .= "( \n";
                $sql .= "   (SELECT COALESCE(MAX(pay_id), 0)+1 FROM t_payout_h), \n";
                $sql .= "   '$pay_no_max', \n";
                $sql .= "   '".$post_pay_day[$key]."', \n";
                $sql .= "   ".$post_client_id[$key].", \n";
                $sql .= "   (SELECT client_cd1   FROM t_client WHERE client_id = ".$post_client_id[$key]."), \n";
                $sql .= "   (SELECT client_cd2   FROM t_client WHERE client_id = ".$post_client_id[$key]."), \n";
                $sql .= "   (SELECT client_name  FROM t_client WHERE client_id = ".$post_client_id[$key]."), \n";
                $sql .= "   (SELECT client_name2 FROM t_client WHERE client_id = ".$post_client_id[$key]."), \n";
                $sql .= "   (SELECT client_cname FROM t_client WHERE client_id = ".$post_client_id[$key]."), \n";
                $sql .= "   NOW(), \n";
                $sql .= "   NULL, \n";
                $sql .= "   'f', \n";
                $sql .= "   NULL, \n";
                $sql .= "   ( \n";
                $sql .= "       SELECT \n";
                $sql .= "           MAX(schedule_payment_id) \n";
                $sql .= "       FROM \n";
                $sql .= "           t_schedule_payment \n";
                $sql .= "       WHERE \n";
                $sql .= "           payment_expected_date LIKE '".substr($post_pay_day[$key], 0, 7)."%"."' \n";
                $sql .= "       AND \n";
                $sql .= "           t_schedule_payment.client_id = ".$post_client_id[$key]." \n";
                $sql .= "       AND \n";
                $sql .= "           t_schedule_payment.shop_id = $shop_id \n";
                $sql .= "       AND \n";
                $sql .= "           t_schedule_payment.first_set_flg = 'f' ";
                $sql .= "   ), \n";
                $sql .= "   $shop_id, \n";
                $sql .= "   $staff_id, \n";
                $sql .= "   '".addslashes($staff_name)."', \n";
                $sql .= "   $staff_id, \n";
                $sql .= "   '".addslashes($staff_name)."', \n";
                if ($post_account_day[$key] != "--"){
                    $sql .= "   '".$post_account_day[$key]."', \n";
                }else{
                    $sql .= "   NULL, \n";
                }
                $sql .= "   '".addslashes($post_payable_no[$key])."' \n";
                $sql .= ") \n";
                $sql .= ";";
                $res  = Db_Query($db_con, $sql);
                if ($res === false){ 
                    $err_mes = pg_last_error();             // エラーメッセージ取得 acquire error message
                    $err_format = "t_payout_h_pay_no_key";  // ユニーク制約の制約名 unique restriction's restriction name
                    Db_Query($db_con, "ROLLBACK;");         // ロールバック rollback
                    // エラーメッセージにユニーク制約が含まれていたら if the uniqeu restraint was included in the error message
                    if (strstr($err_mes, $err_format) != false){ 
                        $duplicate_err  = "支払入力が同時に行われたため、支払番号の付番に失敗しました。";
                        $duplicate_flg  = true;             // 制約エラーフラグにtrueをセット set the restriction error flag to true
                        $err_flg        = true;
                        break;
                    // その他のエラー other errors
                    }else{  
                        exit;                               // 強制終了 force end
                    }
                }

            // 支払変更時 when payment is edited
            }else{

                // 支払ヘッダUPDATE UPDATE payment header
                $sql  = "UPDATE \n";
                $sql .= "   t_payout_h \n";
                $sql .= "SET \n";
                $sql .= "   client_id    = ".$post_client_id[$key].", \n";
                $sql .= "   client_cd1   = (SELECT client_cd1   FROM t_client WHERE client_id = ".$post_client_id[$key]."), \n";
                $sql .= "   client_cd2   = (SELECT client_cd2   FROM t_client WHERE client_id = ".$post_client_id[$key]."), \n";
                $sql .= "   client_name  = (SELECT client_name  FROM t_client WHERE client_id = ".$post_client_id[$key]."), \n";
                $sql .= "   client_name2 = (SELECT client_name2 FROM t_client WHERE client_id = ".$post_client_id[$key]."), \n";
                $sql .= "   client_cname = (SELECT client_cname FROM t_client WHERE client_id = ".$post_client_id[$key]."), \n";
                $sql .= "   pay_day      = '".$post_pay_day[$key]."', \n";
                if ($post_account_day[$key] != "--"){
                    $sql .= "   account_day  = '".$post_account_day[$key]."', \n";
                }else{
                    $sql .= "   account_day  = NULL, \n";
                }
                $sql .= "   payable_no   = '".$post_payable_no[$key]."' \n";
                $sql .= "WHERE \n";
                $sql .= "   pay_id = $pay_id \n";
                $sql .= ";";
                $res  = Db_Query($db_con, $sql);
                if ($res === false){
                    Db_Query($db_con, "ROLLBACK;");
                    break;
                }

                // 支払データDELETE payment data DELETE
                $sql  = "DELETE FROM \n";
                $sql .= "   t_payout_d \n";
                $sql .= "WHERE \n";
                $sql .= "   pay_id = $pay_id \n";
                $sql .= ";";
                $res  = Db_Query($db_con, $sql);
                if ($res === false){
                    Db_Query($db_con, "ROLLBACK;");
                    break;
                }

            }

            // 手数料に入力/未入力に応じてループ数を設定 set the nunmber of loops depending on the fee inputted or not inputted
            if ($post_pay_fee[$key] == ""){
                $d_insert_cnt = 1;
            }else{
                $d_insert_cnt = 2;
            }

            for ($i = 0; $i < $d_insert_cnt; $i++){

                // 支払データINSERT INSERT the payment data
                $sql  = "INSERT INTO \n";
                $sql .= "   t_payout_d \n";
                $sql .= "( \n";
                $sql .= "   pay_d_id, \n";          // 支払データID payment data ID
                $sql .= "   pay_id, \n";            // 支払ID payment ID
                $sql .= "   pay_amount, \n";        // 支払金額/手数料 payment amount/fee
                $sql .= "   trade_id, \n";          // 取引区分 trade classification
                $sql .= "   bank_name2, \n";        // 振込銀行略称 deposit bank abbreviation
                $sql .= "   bank_cd, \n";           // 銀行コード bank code
                $sql .= "   bank_name, \n";         // 銀行名 bank name
                $sql .= "   b_bank_cd, \n";         // 支店コード branch code
                $sql .= "   b_bank_name, \n";       // 支店名branch name
                $sql .= "   account_id, \n";        // 口座ID account ID
                $sql .= "   account_no, \n";        // 口座番号 account number
                $sql .= "   deposit_kind, \n";      // 預金種目 deposit type
                $sql .= "   note \n";               // 備考 remarks
                $sql .= ") \n";
                $sql .= "VALUES \n";
                $sql .= "( \n";
                $sql .= "   (SELECT COALESCE(MAX(pay_d_id), 0)+1 FROM t_payout_d),  \n";
                if ($get_flg == "true"){
                    $sql .= "   $pay_id, \n";
                }else{
                    $sql .= "   (SELECT pay_id FROM t_payout_h WHERE pay_no = '$pay_no_max' AND shop_id = $shop_id), \n";
                }
                if ($i == 0){
                    $sql .= "   ".str_replace(",", "", $post_pay_mon[$key]).", \n";
                    $sql .= "   ".$post_trade[$key].", \n";
                }else{
                    $sql .= "   ".str_replace(",", "", $post_pay_fee[$key]).", \n";
                    $sql .= "   48, \n";
                }
                $sql .= "   '".addslashes($post_pay_bank[$key])."', \n";
                if ($post_bank[$key][0] != null){
                    $sql .= "   (SELECT bank_cd      FROM t_bank    WHERE bank_id    = ".$post_bank[$key][0]."), \n";
                    $sql .= "   (SELECT bank_name    FROM t_bank    WHERE bank_id    = ".$post_bank[$key][0]."), \n";
                }else{
                    $sql .= "   NULL, \n";
                    $sql .= "   NULL, \n";
                }
                if ($post_bank[$key][1] != null){
                    $sql .= "   (SELECT b_bank_cd    FROM t_b_bank  WHERE b_bank_id  = ".$post_bank[$key][1]."), \n";
                    $sql .= "   (SELECT b_bank_name  FROM t_b_bank  WHERE b_bank_id  = ".$post_bank[$key][1]."), \n";
                }else{
                    $sql .= "   NULL, \n";
                    $sql .= "   NULL, \n";
                }
                if ($post_bank[$key][2] != null){
                    $sql .= "   ".$post_bank[$key][2].", \n";
                    $sql .= "   (SELECT account_no   FROM t_account WHERE account_id = ".$post_bank[$key][2]."), \n";
                    $sql .= "   (SELECT deposit_kind FROM t_account WHERE account_id = ".$post_bank[$key][2]."), \n";
                }else{
                    $sql .= "   NULL, \n";
                    $sql .= "   NULL, \n";
                    $sql .= "   NULL, \n";
                }
                if ($i == 0){
                    $sql .= "   '".addslashes($post_note[$key])."' \n";
                }else{
                    $sql .= "   NULL \n";
                }
                $sql .= ") \n";
                $sql .= ";";
                $res  = Db_Query($db_con, $sql);
                if ($res === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

            }

        }

        // トランザクション終了 finish transaction
        Db_Query($db_con, "COMMIT;");

        // 重複エラーない場合 if there is no duplication error
        if ($err_flg != true && $duplicate_flg != true){
            // 完了画面へ遷移 transition to process complete screen
            header("Location: ./1-3-305.php?flg=".$_POST["get_flg"]."&pay_id=".$pay_id);
            exit;
        }

    }

}


/*****************************/
// 照会画面から遷移 if it transitioned from the inquuiry (list) page
/*****************************/
// 初期表示時＋支払IDがある＋GETがある場合 if there is a initial display, with payment id, and GET
if ($_POST["post_flg"] == null && $pay_id != null && $get_flg == "true"){

    $henkousyoki_meisai = true;

    // 日次更新の有無により、抽出データを変更 edit the extracted data depending if it was daily updated or not
    $sql  = "SELECT \n";
    $sql .= "   t_payout_h.pay_id, \n";                             // 支払ID payment ID
    $sql .= "   t_payout_h.pay_no, \n";                             // 支払番号 payment number
    $sql .= "   t_payout_h.pay_day, \n";                            // 支払日 payment date
    $sql .= "   t_client.client_div, \n";                           // 仕入先区分 supplier classification
    $sql .= "   t_payout_h.client_id, \n";                          // 仕入先ID supplier ID
    $sql .= "   t_client.client_cd1, \n";                           // 仕入先コード１ supplier code 1 
    $sql .= "   t_client.client_cd2, \n";                           // 仕入先コード２ supllier code 2
    $sql .= "   t_client.client_cname, \n";                         // 仕入先名 supplier name 
    $sql .= "   t_payout_h.buy_id, \n";                             // 仕入ID supplier ID
    $sql .= "   t_payout_d.trade_id, \n";                           // 取引区分ID trade classification Id
    $sql .= "   t_schedule_payment.schedule_of_payment_this, \n";   // 今回支払予定額 payment planned amount this time
    $sql .= "   t_payout_d.pay_amount, \n";                         // 支払金額 payment amount 
    $sql .= "   t_payout_d_fee.pay_amount AS fee_amount, \n";       // 手数料 fee
    $sql .= "   t_payout_d.bank_name2, \n";                         // 振込銀行略称 deposit bank abbreviaiton
    $sql .= "   CAST(t_b_bank.bank_id AS varchar), \n";             // 銀行ID bank ID
    $sql .= "   CAST(t_b_bank.b_bank_id AS varchar), \n";           // 支店ID brnach ID
    $sql .= "   CAST(t_payout_d.account_id AS varchar), \n";        // 口座ID account Id
    $sql .= "   t_payout_d.note, \n";                               // 備考 remarks
    $sql .= "   t_payout_h.renew_flg, \n";                          // 日次更新フラグ daily update flag
    $sql .= "   t_payout_h.account_day, \n";                        // 決済日 settlement date
    $sql .= "   t_payout_h.payable_no \n";                          // 手形券面番号 bill number
    $sql .= "FROM \n";
    $sql .= "   t_payout_h \n";
    $sql .= "   LEFT  JOIN t_schedule_payment ON  t_payout_h.schedule_payment_id = t_schedule_payment.schedule_payment_id \n";
    $sql .= "   INNER JOIN t_payout_d         ON  t_payout_h.pay_id = t_payout_d.pay_id \n";
    $sql .= "                                 AND t_payout_d.trade_id != 48 \n";
    $sql .= "   INNER JOIN t_client           ON  t_payout_h.client_id = t_client.client_id \n";
    $sql .= "   LEFT  JOIN t_payout_d \n";
    $sql .= "           AS t_payout_d_fee     ON  t_payout_h.pay_id = t_payout_d_fee.pay_id \n"; 
    $sql .= "                                 AND t_payout_d_fee.trade_id = 48 \n";
    $sql .= "   LEFT  JOIN t_account          ON  t_account.account_id = t_payout_d.account_id \n";
    $sql .= "   LEFT  JOIN t_b_bank           ON  t_account.b_bank_id = t_b_bank.b_bank_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_payout_h.pay_id = $pay_id \n";
    $sql .= "AND \n";
    $sql .= "   t_payout_h.renew_flg = 'f' \n";

    $sql .= "UNION ALL \n";

    $sql .= "SELECT \n";
    $sql .= "   t_payout_h.pay_id, \n";                             // 支払ID payment ID
    $sql .= "   t_payout_h.pay_no, \n";                             // 支払番号 payment number
    $sql .= "   t_payout_h.pay_day, \n";                            // 支払日 payment date
    $sql .= "   t_client.client_div, \n";                           // 仕入先区分 supplier classifcaiton
    $sql .= "   t_payout_h.client_id, \n";                          // 仕入先ID supplier ID
    $sql .= "   t_payout_h.client_cd1, \n";                         // 仕入先コード１ supplier code 1
    $sql .= "   t_payout_h.client_cd2, \n";                         // 仕入先コード２ supplier code 2
    $sql .= "   t_payout_h.client_cname, \n";                       // 仕入先名 supplier name
    $sql .= "   t_payout_h.buy_id, \n";                             // 仕入ID supplier ID
    $sql .= "   t_payout_d.trade_id, \n";                           // 取引区分ID trade classification ID
    $sql .= "   t_schedule_payment.schedule_of_payment_this, \n";   // 今回支払予定額 this time's planned payment amount 
    $sql .= "   t_payout_d.pay_amount, \n";                         // 支払金額 payment amount 
    $sql .= "   t_payout_d_fee.pay_amount AS fee_amount, \n";       // 手数料 fee
    $sql .= "   t_payout_d.bank_name2, \n";                         // 振込銀行略称 deposit bank abbreviation
    $sql .= "   t_payout_d.bank_cd  || '：' || t_payout_d.bank_name, \n";       // 銀行コード：銀行名 bank code: bank name
    $sql .= "   t_payout_d.b_bank_cd || '：' || t_payout_d.b_bank_name, \n";    // 支店コード：支店名 branch code: branch name
    $sql .= "   CASE t_payout_d.deposit_kind \n";
    $sql .= "       WHEN '1' THEN '普通：' || t_payout_d.account_no \n";        // 預金種目：口座番号 deposit type: account number
    $sql .= "       WHEN '2' THEN '当座：' || t_payout_d.account_no \n";
    $sql .= "   END AS account_id, \n";
    $sql .= "   t_payout_d.note, \n";                               // 備考 remark
    $sql .= "   t_payout_h.renew_flg, \n";                          // 日次更新フラグ daily update flag
    $sql .= "   t_payout_h.account_day, \n";                        // 決済日 settlement date
    $sql .= "   t_payout_h.payable_no \n";                          // 手形券面番号 bill number
    $sql .= "FROM \n";
    $sql .= "   t_payout_h \n";
    $sql .= "   LEFT  JOIN t_schedule_payment ON  t_payout_h.schedule_payment_id = t_schedule_payment.schedule_payment_id \n";
    $sql .= "   INNER JOIN t_payout_d         ON  t_payout_h.pay_id = t_payout_d.pay_id \n";
    $sql .= "                                 AND t_payout_d.trade_id != 48 \n";
    $sql .= "   INNER JOIN t_client           ON  t_payout_h.client_id = t_client.client_id \n";
    $sql .= "   LEFT  JOIN t_payout_d \n";
    $sql .= "           AS t_payout_d_fee     ON  t_payout_h.pay_id = t_payout_d_fee.pay_id \n";
    $sql .= "                                 AND t_payout_d_fee.trade_id = 48 \n";
    $sql .= "WHERE \n";
    $sql .= "   t_payout_h.pay_id = $pay_id \n";
    $sql .= "AND \n";
    $sql .= "   t_payout_h.renew_flg = 't' \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);

    $num = pg_num_rows($res);

    // データが存在する場合 if there is data
    if ($num > 0){

        $refdata = pg_fetch_array($res);

        // データ取得 acquire data
        $getdata["pay_id"]                  = $refdata["pay_id"];                   // 支払ID payment Id
        $getdata["pay_no"]                  = $refdata["pay_no"];                   // 支払番号 payment number
        $get_pay_day                        = explode("-",$refdata['pay_day']);     // 支払日(配列） payment date array
        $getdata["form_pay_day_0"]["y"]     = $get_pay_day[0];                      // 年 year
        $getdata["form_pay_day_0"]["m"]     = $get_pay_day[1];                      // 月 month
        $getdata["form_pay_day_0"]["d"]     = $get_pay_day[2];                      // 日 day
        $getdata["hdn_client_id"][]         = $refdata["client_id"];                // 仕入先ID supplier ID
        $get_client_div                     = $refdata["client_div"];               // 取引先区分 trade classifcation
        $getdata["form_client_cd1_0"]       = $refdata["client_cd1"];               // 仕入先コード１ supplier code 1
        if ($get_client_div == "3"){
            $getdata["form_client_cd2_0"]   = $refdata["client_cd2"];               // 仕入先コード２ supplier code 2
        }
        $getdata["form_client_name_0"]      = $refdata["client_cname"];             // 仕入先名 supplier name
        $getdata["form_pay_bank_0"]         = $refdata["bank_name2"];               // 振込銀行略称 deposit bank abbreviation
        $getdata["form_trade_0"]            = $refdata["trade_id"];                 // 取引区分ID trade classification Id
        $get_bank_id                        = $refdata["bank_id"];                  // 銀行ID OR 銀行コード＋銀行名 bank ID or bank code+bank name
        $get_b_bank_id                      = $refdata["b_bank_id"];                // 支店ID OR 支店コード＋支店名 branch Id or branch code+branch name
        $get_account_id                     = $refdata["account_id"];               // 口座ID OR 口座種目＋口座番号 account ID or account type+ account number
        $getdata["form_note_0"]             = $refdata["note"];                     // 備考 remarks 
        $get_buy_id                         = $refdata['buy_id'];                   // 仕入ID supplier ID
        $get_renew_flg                      = $refdata['renew_flg'];                // 日次更新フラグ dailyup update flag

        // フリーズ設定 set freeze
        // 日次更新済、または自動支払 if it iwas dailyupdated or if it is an automatic payment
        if ($get_renew_flg == "t" || $get_buy_id != null){
            $freeze_flg = true;
        }

        // 日次更新未実施かつ自動支払でない場合 if its not a daily update and not automatic payment
        if ($get_renew_flg == "f" && $get_buy_id == ""){
            // ヒアセレクトフォームに to here select form
            $getdata["form_bank_0"][0]      = $get_bank_id;
            $getdata["form_bank_0"][1]      = $get_b_bank_id;
            $getdata["form_bank_0"][2]      = $get_account_id;
        }else{
            // リードオンリーフォームに to readonly form
            $getdata["bank_name_0"]         = $get_bank_id;
            $getdata["b_bank_name_0"]       = $get_b_bank_id;
            $getdata["account_id_0"]        = $get_account_id;
        }

        // ナンバーフォーマット処理 number format process
        // フリーズする場合 if it will freeze
        if($get_renew_flg == "t" || $get_buy_id != ""){
            $getdata["form_pay_mon_0"] = number_format($refdata["pay_amount"]);
            $getdata["form_pay_fee_0"] = ($refdata["fee_amount"] != null) ? number_format($refdata["fee_amount"]) : "";
        // フリーズしない場合 if it wont freeze
        }else{
            $getdata["form_pay_mon_0"] = $refdata["pay_amount"];
            $getdata["form_pay_fee_0"] = $refdata["fee_amount"];
        } 

        if ($refdata["schedule_of_payment_this"] != null){
            $getdata["form_pay_mon_plan_0"] = number_format($refdata['schedule_of_payment_this']);
        }else{
            $getdata["form_pay_mon_plan_0"] = "";
        }

        $get_account_day = explode("-", $refdata["account_day"]);       // 決済日(配列） settlement date array
        $getdata["form_account_day_0"]["y"] = $get_account_day[0];      // 年 year
        $getdata["form_account_day_0"]["m"] = $get_account_day[1];      // 月 month
        $getdata["form_account_day_0"]["d"] = $get_account_day[2];      // 日 day
        $getdata["form_payable_no_0"] = $refdata["payable_no"];         // 手形券面番号 bill number

        // 変更・明細フラグにtrueをセット set edit/detail flag to true
        $get_flg = "true";
        $getdata["get_flg"] = $get_flg;
        $form->setConstants($getdata);

        // 最大行数をセット set the max row number 
        $max_row = 1;
        $max_data["max_row"] = $max_row;
        $form->setConstants($max_data);

        $disp_client_id = $refdata["client_id"];

    // データが存在しない場合 if there is no data
    }else{

        header("Location:../top.php");

    }

}


/*****************************/
// パターンとフリーズ patter and freeze
/*****************************/
// 新規支払時 if its a new payment
if (
    $get_flg != "true" && 
    ($_POST["confirm_button"] == null || ($_POST["confirm_button"] != null && $err_flg == true))
){

    // パターン pattern
    $disp_pattern = "1";

}else
// 伝票取得時（変更） when slip was acquired (edit)
if (
    $get_flg == "true" && 
    ($_POST["confirm_button"] == null || ($_POST["confirm_button"] != null && $err_flg == true)) &&
    ($get_renew_flg != "t" && $get_buy_id == null)
){

    // パターン pattern
    $disp_pattern = "2";

}else
// 伝票取得時（明細）  when slip was acquired (detail)
if (
    $get_flg == "true" && 
    ($_POST["confirm_button"] == null || ($_POST["confirm_button"] != null && $err_flg == true)) &&
    ($get_renew_flg == "t" || $get_buy_id != null)
){

    // パターン pattern
    $disp_pattern = "3";

    // フォームをフリーズ freeze the form
    $form->freeze();

}else
// 確認画面へボタン押下＋エラーなし when the to confirmation screen is button is pressed and there is no error
if ($_POST["confirm_button"] != null && $err_flg != true){

    // パターン pattern
    $disp_pattern = "4";

    // フォームをフリーズ freeze the form
    $form->freeze();

}


/*****************************/
// ・カンマ除去・ナンバーフォーマット delete comma, number format
// ・登録しない行の入力内容を消す（確認画面のみ）delete the input detail of the rows that will not be registered (only in the confirmation screen)
/*****************************/
$ary_input_id_row = null;
// 現在の最大桁数繰り返し repeat with the current max digit
for ($i = 0; $i < $max_row; $i++){
    // 空白行を除いた仕入先IDの配列作成 create an array of supplier ID without the blank row
    if ($ary_client_id[$i] != ""){
        $ary_input_id_row[] = $i;
    }
}

// 最大行数でループ loop throught the max rows 
for ($i = 0; $i < $max_row; $i++){

    // 削除行判定＋仕入先が変更されていない行 rows with delete decision not made and supplier not edited
    if (!in_array($i, $ary_del_rows) && $_POST["layer"] !== $i){

        // カンマ除去 delete comma 
        // フリーズしない場合 if it wont freeze
        if ($disp_pattern == "1" || $disp_pattern == "2"){
            // 値のある場合のみ if there is a value
            if ($_POST["form_pay_mon_$i"] != null){
                $set_num_format["form_pay_mon_$i"] = str_replace(",", "", $_POST["form_pay_mon_$i"]);
            }
            if ($_POST["form_pay_fee_$i"] != null){
                $set_num_format["form_pay_fee_$i"] = str_replace(",", "", $_POST["form_pay_fee_$i"]);
            }
        }else

        // ナンバーフォーマット number format
        // フリーズしている場合 if it is freeze
        if ($disp_pattern == "3" || $disp_pattern == "4"){
            // 値のある場合のみ only if there is a value
            if ($_POST["form_pay_mon_$i"] != null){
                $set_num_format["form_pay_mon_$i"] = number_format($_POST["form_pay_mon_$i"]);
            }
            if ($_POST["form_pay_fee_$i"] != null){
                $set_num_format["form_pay_fee_$i"] = number_format($_POST["form_pay_fee_$i"]);
            }
        }

        // 確認画面では登録しない行の入力内容を消す in the confirmation screen delete the input detail that wil notbe registered
        // 確認画面時 in thye confirmation screen
        if ($disp_pattern == "4"){
            if (!in_array($i, $ary_input_id_row)){
                $clear_form["hdn_client_id_$i"]         = "";
                $clear_form["form_client_cd1_$i"]       = "";
                $clear_form["form_client_cd2_$i"]       = "";
                $clear_form["form_client_name_$i"]      = "";
                $clear_form["form_pay_bank_$i"]         = "";
                $clear_form["form_pay_day_$i"]["y"]     = "";
                $clear_form["form_pay_day_$i"]["m"]     = "";
                $clear_form["form_pay_day_$i"]["d"]     = "";
                $clear_form["form_trade_$i"]            = "";
                $clear_form["form_bank_$i"][0]          = "";
                $clear_form["form_bank_$i"][1]          = "";
                $clear_form["form_bank_$i"][2]          = "";
                $clear_form["form_pay_mon_plan_$i"]     = "";
                $clear_form["form_pay_mon_$i"]          = "";
                $clear_form["form_pay_fee_$i"]          = "";
                $clear_form["form_account_day_$i"]["y"] = "";
                $clear_form["form_account_day_$i"]["m"] = "";
                $clear_form["form_account_day_$i"]["d"] = "";
                $clear_form["form_payable_no_$i"]       = "";
                $clear_form["form_note_$i"]             = "";
            }
        }
    }
}

// カンマ除去・ナンバーフォーマット関連 comma deletion and number format related stuff
$form->setConstants($set_num_format);
// フォームデータ削除関連 form data delete related stuff
$form->setConstants($clear_form);


/*****************************/
// フォーム作成（変動） create form (fluctuate)
/*****************************/
// 行番号カウンタ row number counter
$row_num = 1;

$html_l = null;

// 最大行数でループ loop through the max row number
for ($i = 0; $i < $max_row; $i++){

    // 削除行判定 determine the deletion row
    if (!in_array($i, $ary_del_rows)){

        // 削除履歴 delete history
        $del_data = $del_row.",".$i;

        // 仕入先 supplier
        $form->addElement("text", "form_client_cd1_$i", "", "
            size=\"7\" maxLength=\"6\" class=\"ime_disabled\"
            onkeyup=\"change_client_cd(this.form, $i);\"
            onChange=\"Change_f2layer(this.form, 'layer', '#$row_num', $i);\"
            $g_form_option
        ");
        $form->addElement("text", "form_client_cd2_$i", "", "
            size=\"4\" maxLength=\"4\" class=\"ime_disabled\"
            onkeyup=\"change_client_cd(this.form, $i);\"
            onChange=\"Change_f2layer(this.form, 'layer', '#$row_num', $i);\"
            $g_form_option
        ");

        $form->addElement("text", "form_client_name_$i", "", "
            size=\"43\"
            style=\"color: #000000; border: #ffffff 1px solid; background-color: #ffffff;\"
            readonly
        ");

        // 振込銀行略称 deposit bank abbreviation
        $form->addElement("text", "form_pay_bank_$i", "", "
            size=\"20\" maxLength=\"20\"
            style=\"color: #000000; border: #ffffff 1px solid; background-color: #ffffff;\" 
            readonly
        ");

/*
        // 支払日 payment date
        $ary_element[0][$i][] =& $form->createElement("text", "y", "", "
            size=\"4\" maxLength=\"4\" $g_form_option class=\"ime_disabled\"
            onkeyup=\"changeText3_row(this.form, $i);\" 
            onChange=\"change_ym(this.form, $i);\"
        ");
        $ary_element[0][$i][] =& $form->createElement("static", "", "", "-");
        $ary_element[0][$i][] =& $form->createElement("text", "m", "", "
            size=\"1\" maxLength=\"2\" $g_form_option class=\"ime_disabled\"
            onkeyup=\"changeText4_row(this.form, $i);\" 
            onChange=\"change_ym(this.form, $i);\"
        ");
        $ary_element[0][$i][] =& $form->createElement("static", "", "", "-");
        $ary_element[0][$i][] =& $form->createElement("text", "d", "", "
            size=\"1\" maxLength=\"2\" $g_form_option class=\"ime_disabled\"
        ");
        $form->addGroup($ary_element[0][$i], "form_pay_day_$i", "", "");
*/
        Addelement_Date($form, "form_pay_day_$i", "", "-");

        // 取引区分 trade classifciation
        $form->addElement("select", "form_trade_$i", "", $trade_value, $g_form_option_select);

        // 銀行・支店・口座 bank, branch, account
        $obj_bank_select =& $form->addElement("hierselect", "form_bank_$i", "", "", "<br>");
        $obj_bank_select->setOptions($bank_value);
 
        // 銀行名 bank name
        $form->addElement("text", "bank_name_$i", "", "
            size=\"32\"
            style=\"color: #000000; border: none; backgrount-color: #ffffff;\" 
            readonly
        ");
        // 支店名 branch name
        $form->addElement("text", "b_bank_name_$i", "", "
            size=\"32\"
            style=\"color: #000000; border: none; backgrount-color: #ffffff;\"
            readonly
        ");
        // 口座番号 account number
        $form->addElement("text", "account_id_$i", "", "
            size=\"20\"
            style=\"color: #000000; border: none; backgrount-color: #ffffff;\"
            readonly
        ");

        // 支払予定額 planned payment amount
        $form->addElement("text", "form_pay_mon_plan_$i", "", "
            size=\"11\" maxLength=\"9\" 
            style=\"text-align: right; color: #000000; border: none; background-color: #ffffff;\"
            readonly
        ");

        // 支払金額 payment amount
        $form->addElement("text", "form_pay_mon_$i", "", "
            class=\"money\" size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"
        ");

        // 手数料 fee
        $form->addElement("text", "form_pay_fee_$i", "", "
            class=\"money\" size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"
        ");

        // 決済日 settlemetn date
        Addelement_Date($form, "form_account_day_$i", "決済日", "-");

        // 手形券面番号 bill number
        $form->addElement("text", "form_payable_no_$i", "", "size=\"13\" maxLength=\"10\" $g_form_option class=\"ime_disabled\"");

        // 備考 remarks
        $form->addElement("text", "form_note_$i", "", "size=\"34\" maxLength=\"15\" $g_form_option");

        // 新規支払時 when new payment
        if ($disp_pattern == "1"){

            // 支払確認画面へボタン *to payment confirmation screen* button
            $form->addElement("submit", "confirm_button", "支払確認画面へ",
                "onClick=\"Button_Submit_1('confirm_flg', '#', 'true', this);\" $disabled"
            );

            // 削除リンク delete link
            if ($row_num == $max_row - $del_num){
                $form->addElement("link", "form_del_row_$i", "", "#", "<font color=\"#fefefe\">削除</font>",
                    "TABINDEX=-1 onClick=\"javascript:Dialogue_3('削除します。', '$del_data', 'del_row', $row_num-1, this); return false;\""
                );
            // 最終行以外を削除する場合、削除する行と同じNo.の行に合わせる match with the row number that will be deleted unless it is the las row
            }else{
                $form->addElement("link", "form_del_row_$i", "", "#", "<font color=\"#fefefe\">削除</font>",
                    "TABINDEX=-1 onClick=\"javascript:Dialogue_3('削除します。', '$del_data', 'del_row', $row_num, this  ); return false;\""
                );
            }

        }else
        // 伝票取得時（変更） when slip is acquired (edit)
        if ($disp_pattern == "2"){

            // 支払確認画面へボタン *go to payment screen confirmation* button
            $form->addElement("submit", "confirm_button", "支払確認画面へ",
                "onClick=\"Button_Submit_1('confirm_flg', '#', 'true', this);\" $disabled"
            );

        }else
        // 伝票取得時（明細） when slip is acquired (detail)
        if ($disp_pattern == "3"){

            // 戻るボタン back button
            $form->addElement("button", "back_btn", "戻　る", "onClick=\"location.href='".Make_Rtn_Page("payout")."'\"");

        }else
        // 確認画面時 when in the confirmation screen 
        if ($disp_pattern == "4"){

            // 支払ボタン payment button
            $form->addElement("button", "payout_button", "支　払",
                "onClick=\"Dialogue_2('支払います。', '#', 'true', 'payout_flg', this); return false;\" $disabled"
            );

            // 戻るボタン back button
            $form->addElement("submit", "back_btn", "戻　る", "onClick=\"Button_Submit_1('confirm_flg', '#', 'false', this);\"");

            // 合計金額 total amount
            $form->addElement("text","sum_mon", "", "
                size=\"11\"
                style=\"color: #000000; border: none; background-color: transparent; text-align: right;\" 
                readonly
            ");

            // 合計手数料 total fee
            $form->addElement("text", "sum_fee", "", "
                size=\"11\"
                style=\"color: #000000; border: none; background-color: transparent; text-align: right;\" 
                readonly
            ");

        }

        // 仕入先ID supplier ID
        $form->addElement("hidden","hdn_client_id[$i]");

        // 支払予定ID planned payment ID
        $form->addElement("hidden","schedule_payment_id[$i]");


        /****************************/
        // 仕入先IDの状態取得 acquire the supplier ID status
        /****************************/
        // 仕入先選択時 when a supplier is selected 
        if ($_POST["layer"] == "$i"){
            $client_state_print[$i] = Get_Client_State($db_con, $search_client_id);
        }else   
        // 変更画面初期時、明細画面時 first of edit screen, and also detail screen 
        if ($henkousyoki_meisai == true){
            $client_state_print[$i] = Get_Client_State($db_con, $disp_client_id);
        // その他 others
        }else{  
            $client_state_print[$i] = Get_Client_State($db_con, $_POST["hdn_client_id"][$i]);
        }


        /****************************/
        //表示用HTML作成 for creation of display HTML
        /****************************/
        $html_l .= "    <tr class=\"Result1\">\n";

        // ■ページ内リンク link in the page
        $html_l .= "        <A NAME=\"$row_num\"></A>\n";

        // ■行No. row number
        $html_l .= "        <td align=\"right\">$row_num</td>\n";

        // ■仕入先コード１ supplier code 1
        // ■仕入先コード２ supplier code 2
        // ■（検索） search
        // ■仕入先名 supplier name
        // ■振込銀行略称 deposti bank abbreviation
        $html_l .= "        <td align=\"left\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_client_cd1_$i"]]->toHtml());
        // 変更・明細画面＋仕入先区分が仕入先の場合（仕入先区分が仕入先になっている全ての伝票が日次更新され、明細表示されることが前提）edit, detail screen,+ if the supplier classification is "supplier" (the assumption is that all slips that has *supplier* in their supplier classfication is daily updated, and that their detail will be displayed)
        if ($get_flg == "true" && $get_client_div == "2"){
            // なし none
        }else{
        $html_l .=              "-".($form->_elements[$form->_elementIndex["form_client_cd2_$i"]]->toHtml())."\n";
        }
        if ($disp_pattern == "1" || $disp_pattern == "2"){
        $html_l .=              "（<a href=\"#\" onClick=\"return Open_SubWin_2('../dialog/1-0-302.php', ";
        $html_l .=              "Array('form_client_cd1_$i', 'form_client_cd2_$i','form_client_name_$i','hdn_client_id[$i]','div_flg', 'layer'), ";
        $html_l .=              "600, 450, 3, $i, $i, $row_num);\">検索</a>）\n";
        }
        $html_l .=              " ".$client_state_print[$i];
        $html_l .= "            <br>\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_client_name_$i"]]->toHtml())."\n";
        $html_l .= "            <br>\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_pay_bank_$i"]]->toHtml())."\n";
        $html_l .= "            <br>\n";
        $html_l .= "        </td>\n";

        // ■支払日 pament date
        $html_l .= "        <td align=\"center\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_pay_day_$i"]]->toHtml())."\n";
        $html_l .= "        </td>\n";

        // ■取引区分 trade classification
        $html_l .= "        <td>\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_trade_$i"]]->toHtml())."\n";
        $html_l .= "        </td>\n";

        // ■銀行 bank
        $html_l .= "        <td>\n";
        if ($disp_pattern == "1" || $disp_pattern == "2"){
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_bank_$i"]]->toHtml())."\n";
        }else
        if ($disp_pattern == "3"){
        $html_l .= "            ".($form->_elements[$form->_elementIndex["bank_name_$i"]]->toHtml())."\n";
        $html_l .= "            <br>";
        $html_l .= "            &nbsp;".($form->_elements[$form->_elementIndex["b_bank_name_$i"]]->toHtml())."\n";
        $html_l .= "            <br>";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["account_id_$i"]]->toHtml())."\n";
        $html_l .= "            <br>";
        }else
        if ($disp_pattern == "4"){
            // 正しい仕入先が選択されている＋銀行が選択されている場合のみ表示する only display if the correct sypplier is chosen + bank is being selected
            if ($_POST["form_bank_$i"][0] != null){
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_bank_$i"]]->toHtml())."\n";
            }
        }
        $html_l .= "        </td>\n";

        // ■支払予定額 planned payment amount
        $html_l .= "        <td align=\"right\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_pay_mon_plan_$i"]]->toHtml())."\n";
        $html_l .= "        </td>\n";

        // ■支払い金額 payment amount
        // ■手数料 fee
        $html_l .= "        <td align=\"right\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_pay_mon_$i"]]->toHtml())."\n";
        $html_l .= "            <br>\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_pay_fee_$i"]]->toHtml())."\n";
        $html_l .= "            <br>\n";
        $html_l .= "        </td>\n";

        // ■手形券面番号 bill number
        // ■決済日 settlement date
        $html_l .= "        <td>\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_account_day_$i"]]->toHtml())."\n";
        $html_l .= "            <br>\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_payable_no_$i"]]->toHtml())."\n";
        $html_l .= "            <br>\n";
        $html_l .= "        </td>\n";

        // ■備考 remarks
        $html_l .= "        <td align=\"left\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_note_$i"]]->toHtml())."\n";
        $html_l .= "        </td>\n";

        // ■削除リンク delete link
        if ($disp_pattern == "1"){
        $html_l .= "        <td align=\"center\" class=\"Title_Add\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_del_row_$i"]]->toHtml())."\n";
        $html_l .= "        </td>\n";
        }
        $html_l .= "    </tr>\n";

        // 行番号加算 add row number
        $row_num++;

    }

}


/****************************/
// JavaScript
/****************************/
$js = "
function change_client_cd(me, num){
    var cd1 = \"form_client_cd1_\"+num;
    var cd2 = \"form_client_cd2_\"+num;
    len = me.elements[cd1].value.length;
    if(6 == len){
        me.elements[cd2].focus();
    }
}

function change_ym(form, layer){

    var yinput = \"form_pay_day_\"+layer+\"[y]\";
    var minput = \"form_pay_day_\"+layer+\"[m]\";
    var row    = layer + 1;

    if (form.elements[yinput].value.length == 4 && form.elements[minput].value.length >= 1){
        form.elements[\"layer\"].value = layer;
        form.elements[\"form_pay_mon_\"+layer].value = \"\";
        form.elements[\"date_chg\"].value = true;
        document.dateForm.target=\"_self\";
        document.dateForm.action=\"".$_SERVER["PHP_SELF"]."#\"+row+\"\";
        document.dateForm.submit();
    }

}

function changeText3_row(me,num){
    var Y = \"form_pay_day_\"+num+\"[y]\";
    var M = \"form_pay_day_\"+num+\"[m]\";
    len = me.elements[Y].value.length;
    if (4 == len){
        me.elements[M].focus();
    }
}

function changeText4_row(me,num){
    var M = \"form_pay_day_\"+num+\"[m]\";
    var D = \"form_pay_day_\"+num+\"[d]\";
    len = me.elements[M].value.length;
    if (2 <= len){
        me.elements[D].focus();
    }
}

function Change_f2layer(form, hidden, url, num){

    var hdn     = hidden;
    var hla     = \"hdn_client_id[\"+num+\"]\";
    var fla     = \"form_client_cd1_\"+num;
    var fla2    = \"form_client_cd2_\"+num;
    var fla_v   = form.elements[fla].value;
    var fla2_v  = form.elements[fla2].value;

    if (fla_v.length == 6 && fla2_v.length == 4){
        form.elements[hdn].value = num;
        form.elements[\"form_pay_mon_\"+num].value = '';
        form.elements[\"form_pay_fee_\"+num].value = '';
        form.target=\"_self\";
        form.action=url;
        form.submit();
    }else
    if(form.elements[hla].value != ''){
        form.elements['layer'].value = num;
        form.elements[\"form_pay_mon_\"+num].value = '';
        form.elements[\"form_pay_fee_\"+num].value = '';
        form.target=\"_self\";
        form.action=url;
        form.submit();
    }

}
";


/****************************/
// HTMLヘッダ html header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTMLフッタ footer
/****************************/
$html_footer = Html_Footer();

/****************************/
// メニュー作成 create menu
/****************************/
//$page_menu = Create_Menu_h("buy", "3");

/****************************/
// 画面ヘッダー作成 create screen header
/****************************/
$page_title .= Print_H_Link_Btn($form, $ary_h_btn_list);
$page_header = Create_Header($page_title);

// Render関連の設定 render related setting
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form関連の変数をassign assign form related setting
$smarty->assign("form", $renderer->toArray());

// その他の変数をassign assign other variables
$smarty->assign("var", array(
    // 共通 common
    "html_header"       => "$html_header",
    "page_menu"         => "$page_menu",
    "page_header"       => "$page_header",
    "html_footer"       => "$html_footer",

    // html
    "html_l"            => "$html_l",
    "js"                => "$js",

    // フラグ関連 flag related
    "confirm_flg"       => "$confirm_flg",
    "get_flg"           => "$get_flg",
    "get_renew_flg"     => "$get_renew_flg",
    "disp_pattern"      => "$disp_pattern",

    // 金額合計・消費税合計 amount total, vat total
    "sum_pay_mon"       => "$sum_pay_mon",
    "sum_pay_fee"       => "$sum_pay_fee",

    // 支払番号重複エラーメッセージ payment number duplicatyion error message
    "duplicate_err"     => "$duplicate_err",
)); 

// エラーをassign assign error
$errors = $form->_errors;
$smarty->assign("errors", $errors);

// テンプレートへ値を渡す pass the value to template
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
