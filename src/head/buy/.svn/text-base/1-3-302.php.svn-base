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
 */

$page_title = "支払入力";

// 環境設定ファイル
require_once("ENV_local.php");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB接続
$db_con = Db_Connect();

// 権限チェック
$auth   = Auth_Check($db_con);

// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/*****************************/
// 再遷移先をSESSIONにセット
/*****************************/
// GET、POSTが無い場合
if ($_GET == null && $_POST == null && $_SESSION["schedule_payment_id"] == null){
    Set_Rtn_Page("payout");
}


/****************************/
// 外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];
$staff_id   = $_SESSION["staff_id"];
$staff_name = $_SESSION["staff_name"];
$group_kind = $_SESSION['group_kind'];


/****************************/
// 支払IDの取り扱い
/****************************/
// 支払IDがPOSTされている場合
if ($_POST["pay_id"] != null){

    // POSTの支払IDを変数とhiddenにセット
    $pay_id             = $_POST["pay_id"];
    $set_hdn["pay_id"]  = $pay_id;

    // ゲットフラグtrueを変数とhiddenにセット
    $get_flg            = "true";
    $set_hdn["get_flg"] = $get_flg;

}else
// GETに支払IDがある場合
if ($_GET["pay_id"] != null){

    // GETした支払IDの妥当性チェック
    $safe_flg = Get_Id_Check_Db($db_con, $_GET["pay_id"], "pay_id", "t_payout_h", "num", "shop_id = $shop_id");
    if ($safe_flg === false){
        header("Location:../top.php");
        exit;
    }

    // GETの支払IDを変数とhiddenにセット
    $pay_id             = $_GET["pay_id"];
    $set_hdn["pay_id"]  = $pay_id;

    // ゲットフラグtrueを変数とhiddenにセット
    $get_flg            = "true";
    $set_hdn["get_flg"] = $get_flg;

}else
// POST、GETに支払IDがない場合
if ($_POST["pay_id"] == null && $_GET["pay_id"] == null){

    // ゲットフラグfalseを変数とhiddenにセット
    $get_flg             = "";
    $set_hdn["get_flg"]  = $get_flg;

}

$form->setConstants($set_hdn);


/****************************/
// 初期設定
/****************************/
// 表示行数
if (isset($_POST["max_row"])){
    $max_row = $_POST["max_row"];
}else{
    $max_row = 5;
}


/****************************/
// 行数追加
/****************************/
if ($_POST["add_row_flg"]== "true"){
    // 最大行に、＋５する
    $max_row = $_POST["max_row"] + 5;
    // 行数追加フラグをクリア
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}


/****************************/
// 行削除処理
/****************************/
if (isset($_POST["del_row"])){
    // 削除リストを取得
    $del_row = $_POST["del_row"];
    // 削除履歴を配列にする。
    $ary_del_rows = explode(",", $del_row);
    unset($ary_del_rows[0]);
}else{
    // 削除履歴配列の初期値作成
    $ary_del_rows = array();
}


/***************************/
// 初期値設定
/***************************/
// 現在の最大行数をhiddenにセット
$max_data["max_row"] = $max_row;
$form->setConstants($max_data);

// 支払日（一括設定）
$setdate["form_pay_day_all"]["y"] = date("Y");
$setdate["form_pay_day_all"]["m"] = date("m");
$setdate["form_pay_day_all"]["d"] = date("d");
$form->setDefaults($setdate);


/****************************/
// フォーム作成（固定）
/****************************/
// ヘッダ部リンクボタン
$ary_h_btn_list = array("照会・変更" => "./1-3-303.php", "入　力" => $_SERVER["PHP_SELF"]);
Make_H_Link_Btn($form, $ary_h_btn_list);

// 支払日（一括設定）
Addelement_Date($form, "form_pay_day_all", "", "-");

// 取引区分（一括設定）
$trade_value = Select_Get($db_con, "trade_payout");
unset($trade_value[48]);
unset($trade_value[49]);
$form->addElement("select", "form_trade_all", "", $trade_value, $g_form_option_select);

// 銀行（一括設定）
$bank_value = Make_Ary_Bank($db_con);
$obj    =   null;
$obj    =&  $form->addElement("hierselect", "form_bank_all", "", "", " ");
$obj->setOptions($bank_value);

// 一括設定ボタン
$form->addElement("button", "all_set_button", "一括設定", "onClick=\"javascript: Button_Submit_1('all_set_flg', '#', 'true');\"");

// 行追加ボタン
$form->addElement("button", "add_row_button", "行追加", "onClick=\"javascript: Button_Submit_1('add_row_flg', '#foot', 'true');\"");

// hidden
$form->addElement("hidden", "del_row");         // 削除行
$form->addElement("hidden", "add_row_flg");     // 追加行フラグ
$form->addElement("hidden", "max_row");         // 最大行数
$form->addElement("hidden", "layer");           // 取引先
$form->addElement("hidden", "div_flg");         // 取引先区分
$form->addElement("hidden", "get_flg");         // 変更・明細（支払照会から）フラグ
$form->addElement("hidden", "pay_id");          // 支払ID
$form->addElement("hidden", "pay_no");          // 支払番号
$form->addelement("hidden", "all_set_flg");     // 一括設定フラグ
$form->addElement("hidden", "payout_flg");      // 支払ボタン押下フラグ
$form->addElement("hidden", "date_chg");        // 日付変更サブミットフラグ
$form->addElement("hidden", "confirm_flg");     // 確認画面へボタン押下フラグ
$form->addElement("hidden", "post_flg", "1");   // 初期表示判断用フラグ


/****************************/
// 一括設定処理
/****************************/
if($_POST["all_set_flg"] == "true"){

    // 支払日（一括）を0埋め
    $_POST["form_pay_day_all"]   = Str_Pad_Date($_POST["form_pay_day_all"]);
    $all_set["form_pay_day_all"] = $_POST["form_pay_day_all"];

    for ($i = 0; $i < $_POST["max_row"]; $i++){
        // 支払日
        $all_set["form_pay_day_$i"]["y"]    = ($_POST["form_pay_day_all"]["y"] != "") ? $_POST["form_pay_day_all"]["y"] : "";
        $all_set["form_pay_day_$i"]["m"]    = ($_POST["form_pay_day_all"]["m"] != "") ? $_POST["form_pay_day_all"]["m"] : "";
        $all_set["form_pay_day_$i"]["d"]    = ($_POST["form_pay_day_all"]["d"] != "") ? $_POST["form_pay_day_all"]["d"] : "";
        // 取引区分
        $all_set["form_trade_$i"]           = $_POST["form_trade_all"];
        // 銀行
        $all_set["form_bank_$i"][0]         = $_POST["form_bank_all"][0];
        $all_set["form_bank_$i"][1]         = $_POST["form_bank_all"][1];
        $all_set["form_bank_$i"][2]         = $_POST["form_bank_all"][2];
    }

    // 一括設定hidden
    $all_set["all_set_flg"] = "";

    $form->setConstants($all_set);

}


/****************************/
// 仕入先コード・支払年月入力処理
/****************************/
// 処理対象行番号がある場合
if ($_POST["layer"] != ""){

    $row            = $_POST["layer"];                  // 行番号
    $supplier_cd    = $_POST["form_client_cd1_$row"];   // 仕入先コード１
    $supplier_cd2   = $_POST["form_client_cd2_$row"];   // 仕入先コード２
    $div_select     = "3";                              // 仕入先・FC・取引先区分

    // FC区分の仕入先抽出sql
    $sql  = "SELECT \n";
    $sql .= "   t_client.client_id, \n";       // 仕入先ID
    $sql .= "   t_client.client_cd1, \n";      // 仕入先コード１
    $sql .= "   t_client.client_cd2, \n";      // 仕入先コード２
    $sql .= "   t_client.client_cname, \n";    // 仕入先名
    $sql .= "   t_client.b_bank_name \n";      // 振込口座略称
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

    // 仕入先が存在する場合
    if ($num > 0){

        $get_data = pg_fetch_array($res);

        $set_client_data["hdn_client_id"][$row]     = $get_data["client_id"];       // 仕入先ID
        $set_client_data["form_client_cd1_$row"]    = $get_data["client_cd1"];      // 仕入先コード１
        $set_client_data["form_client_cd2_$row"]    = $get_data["client_cd2"];      // 仕入先コード２
        $set_client_data["form_client_name_$row"]   = $get_data["client_cname"];    // 仕入先名
        $set_client_data["form_pay_bank_$row"]      = $get_data["b_bank_name"];     // 振込口座略称

        // 仕入先IDを変数にセット
        $search_client_id = $get_data["client_id"];

        // 最新の支払金額を取得
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

        // 予定額レコードがある場合
        if (pg_num_rows($res) > 0){
            $get_pay_mon = pg_fetch_result($res, 0, 0);
        // 予定額レコードなしの場合
        }else{
            $get_pay_mon = "";
        }

        // 金額セット
        if ($get_pay_mon != ""){
        $set_client_data["form_pay_mon_plan_$row"]  = number_format($get_pay_mon);  // 支払予定額（ナンバーフォーマット）
        }else{
        $set_client_data["form_pay_mon_plan_$row"]  = $get_pay_mon;                 // 支払予定額
        }
        $set_client_data["form_pay_mon_$row"]       = $get_pay_mon;                 // 支払額
        $set_client_data["form_pay_fee_$row"]       = "";                           // 手数料

    // 仕入先が存在しない場合
    }else{

        $set_client_data["hdn_client_id"][$row]     = "";
        $set_client_data["form_client_name_$row"]   = "";
        $set_client_data["form_pay_bank_$row"]      = "";
        $set_client_data["form_pay_mon_plan_$row"]  = "";
        $set_client_data["form_pay_mon_$row"]       = "";
        $set_client_data["form_pay_fee_$row"]       = "";
        $search_client_id = null;

    }

    // POST情報をクリア
    $set_client_data["layer"]       = "";   // 行数
    $set_client_data["date_chg"]    = "";   // ?
    $form->setConstants($set_client_data);

}


/****************************/
// 支払確認画面へボタン押下処理
/****************************/
// 支払確認ボタン押下、または支払ボタン押下フラグがtrueの場合
if ($_POST["confirm_button"] == "支払確認画面へ" || $_POST["payout_flg"] == "true"){

    // 支払ボタン押下hiddenをクリア
    $clear_hdn["payout_flg"] = "";
    $form->setconstants($clear_hdn);

    // 合計金額初期値
    $sum_pay_mon = 0;
    $sum_pay_fee = 0;

    $ary_input_id_row = null;
    // 現在の最大桁数繰り返し
    for ($i = 0; $i < $max_row; $i++){
        // 空白行を除いた仕入先IDの配列作成
        if ($ary_client_id[$i] != ""){
            $ary_input_id_row[] = $i;
        }
    }

    // 仕入先ID配列を変数にセット
    $ary_client_id  = $_POST["hdn_client_id"];

    // 最大行数を変数にセット
    $max_row        = $_POST["max_row"];

    // 最大行数でループ
    for ($key = 0, $row = 0; $key < $max_row; $key++){

        // 現在の参照行が削除行配列に存在しない場合
        if (!in_array($key, $ary_del_rows)){

            // 参照行数を加算
            $row++;

            // 日付の0埋め
            $_POST["form_pay_day_$key"]     = Str_Pad_Date($_POST["form_pay_day_$key"]);
            $_POST["form_account_day_$key"] = Str_Pad_Date($_POST["form_account_day_$key"]);

            // POSTデータを変数にセット
            $post_client_id[$key]       = $_POST["hdn_client_id"][$key];           // 仕入先ID
            $post_client_cd1[$key]      = $_POST["form_client_cd1_$key"];          // 仕入先コード１
            $post_client_cd2[$key]      = $_POST["form_client_cd2_$key"];          // 仕入先コード２
            $post_pay_day_y[$key]       = $_POST["form_pay_day_$key"]["y"];        // 支払日（年）
            $post_pay_day_m[$key]       = $_POST["form_pay_day_$key"]["m"];        // 支払日（月）
            $post_pay_day_d[$key]       = $_POST["form_pay_day_$key"]["d"];        // 支払日（日）
            $post_pay_bank[$key]        = $_POST["form_pay_bank_$key"];            // 振込銀行略称
            $post_trade[$key]           = $_POST["form_trade_$key"];               // 取引区分
            $post_bank[$key]            = $_POST["form_bank_$key"];                // 銀行・支店・口座（配列）
            $post_pay_mon[$key]         = $_POST["form_pay_mon_$key"];             // 支払額
            $post_pay_fee[$key]         = $_POST["form_pay_fee_$key"];             // 手数料
            $post_account_day_y[$key]   = $_POST["form_account_day_$key"]["y"];    // 決済日（年）
            $post_account_day_m[$key]   = $_POST["form_account_day_$key"]["m"];    // 決済日（月）
            $post_account_day_d[$key]   = $_POST["form_account_day_$key"]["d"];    // 決済日（日）
            $post_payable_no[$key]      = $_POST["form_payable_no_$key"];          // 手形券面番号
            $post_note[$key]            = $_POST["form_note_$key"];                // 備考

            // 支払ボタン押下時は金額のカンマ除去
            if ($_POST["payout_flg"] == "true"){
                if ($post_pay_mon[$key] != null){
                    $post_pay_mon[$key] = str_replace(",", "", $post_pay_mon[$key]);
                }
                if ($post_pay_fee[$key] != null){
                    $post_pay_fee[$key] = str_replace(",", "", $post_pay_fee[$key]);
                }
            }

            // 入力のない行をカウント
            if ($ary_client_id[$key] == null){
                $null_row += 1;
            }

            /****************************/
            // 合計金額算出（出力用）
            /****************************/
            // 仕入先IDのある行のみ
            if ($ary_client_id[$key] != null){
                $sum_pay_mon += $post_pay_mon[$key];    // 支払金額
                $sum_pay_fee += $post_pay_fee[$key];    // 手数料
            }

            /****************************/
            // エラーチェック
            /****************************/
            // ■仕入先
            // 必須チェック１
            if ($ary_client_id[$key] == null && ($post_client_cd1[$key] != null || $post_client_cd2[$key] != null)){
                $form->setElementError("form_client_cd1_$key", $row."行目　正しい仕入先を入力してください。");
            }

            // 以降、一括設定以外のフォームに入力があった場合にチェックを行う
            if (
                $ary_client_id[$key]        != null ||  // 仕入先ID
                $post_client_cd1[$key]      != null ||  // 仕入先コード１
                $post_client_cd2[$key]      != null ||  // 仕入先コード２
                $post_pay_mon[$key]         != null ||  // 支払金額
                $post_pay_fee[$key]         != null ||  // 手数料
                $post_account_day_y[$key]   != null ||  // 決済日（年）
                $post_account_day_m[$key]   != null ||  // 決済日（月）
                $post_account_day_d[$key]   != null ||  // 決済日（日）
                $post_payable_no[$key]      != null ||  // 手形券面番号
                $post_note[$key]            != null     // 備考
            ){

                // ■支払日
                // 必須チェック
                if ($post_pay_day_y[$key] == null && $post_pay_day_m[$key] == null && $post_pay_day_d[$key] == null){
                    $form->setElementError("form_pay_day_$key", $row."行目　支払日は必須です。");
                }else
                // 数値チェック
                if (
                    !ereg("^[0-9]+$", $post_pay_day_y[$key]) ||
                    !ereg("^[0-9]+$", $post_pay_day_m[$key]) ||
                    !ereg("^[0-9]+$", $post_pay_day_d[$key])
                ){
                    $form->setElementError("form_pay_day_$key", $row."行目　支払日が妥当ではありません。");
                }else
                // 妥当性チェック
                if (!checkdate((int)$post_pay_day_m[$key], (int)$post_pay_day_d[$key], (int)$post_pay_day_y[$key])){
                    $form->setElementError("form_pay_day_$key", $row."行目　支払日が妥当ではありません。");
                // それ以外
                }else{
                    // 本日以前チェック
                    if (date("Y-m-d") < $post_pay_day_y[$key]."-".$post_pay_day_m[$key]."-".$$post_pay_day_d[$key]){
                        $form->addElement("text", "err_pay_day_1_$key");
                        $form->setElementError("err_pay_day_1_$key", $row."行目　支払日に未来の日付が入力されています。");
                    }
                    // システム開始日以降チェック
                    $pay_day_sys_chk[$key] = Sys_Start_Date_Chk($post_pay_day_y[$key], $post_pay_day_m[$key], $post_pay_day_d[$key], "支払日");
                    if ($pay_day_sys_chk[$key] != null){
                        $form->addElement("text", "err_pay_day_2_$key");
                        $form->setElementError("err_pay_day_2_$key", $row."行目　$pay_day_sys_chk[$key]");
                    }
                    // 月次更新以降チェック
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
                    // 仕入締日以降チェック
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

                // ■取引区分
                // 必須チェック
                if ($post_trade[$key] == null){
                    $form->setElementError("form_trade_$key", $row."行目　取引区分は必須です。");
                }

                // ■銀行
                // 全て選択チェック
                if ($post_bank[$key][0] != null && $post_bank[$key][2] == null){
                    $form->setElementError("form_bank_$key", $row."行目　銀行指定時は口座番号まで指定してください。");
                }else
                // 条件付き必須チェック１
                if (($post_trade[$key] == "43" || $post_trade[$key] == "44") && $post_bank[$key][2] == null){
                    $form->setElementError("form_bank_$key", $row."行目　振込支払・手形支払時には口座番号を指定してください。");
                }else
                // 条件付き必須チェック２
                if ($post_pay_fee[$key] != null && $post_bank[$key][2] == null){
                    $form->setElementError("form_bank_$key", $row."行目　手数料入力時は銀行を指定してください。");
                }

                // ■支払金額
                // 必須チェック
                if ($post_pay_mon[$key] == null){
                    $form->setElementError("form_pay_mon_$key", $row."行目　支払金額は必須です。");
                }else
                // 数値チェック
                if (!ereg("^[-]?[0-9]+$", $post_pay_mon[$key])){
                    $form->setElementError("form_pay_mon_$key", $row."行目　支払金額が妥当ではありません。");
                }

                // ■手数料
                // 数値チェック
                if ($post_pay_fee[$key] != null && !ereg("^[-]?[0-9]+$", $post_pay_fee[$key])){
                    $form->setElementError("form_pay_fee_$key", $row."行目　手数料が妥当ではありません。");
                }

                // ■決済日
                // 未入力時
                if ($post_account_day_y[$key] == null && $post_account_day_m[$key] == null && $post_account_day_d[$key] == null){
                    if ($post_trade[$key] == "44"){
                        $form->setElementError("form_account_day_$key", $row."行目　手形支払時には決済日を入力してください。");
                    }
                }else
                // 数値チェック
                if (
                    !ereg("^[0-9]+$", $post_account_day_y[$key]) ||
                    !ereg("^[0-9]+$", $post_account_day_m[$key]) ||
                    !ereg("^[0-9]+$", $post_account_day_d[$key])
                ){
                    $form->setElementError("form_account_day_$key", $row."行目　決済日が妥当ではありません。");
                }else
                // 妥当性チェック
                if (!checkdate((int)$post_account_day_m[$key], (int)$post_account_day_d[$key], (int)$post_account_day_y[$key])){
                    $form->setElementError("form_account_day_$key", $row."行目　決済日が妥当ではありません。");
                }

            }

        }

    }

    // ■データ入力チェック
    if ($row == $null_row){
        $form->addElement("text", "err_no_data");
        $form->setElementError("err_no_data", "支払データを入力してください。");
    }

    // ■伝票変更中に伝票削除されていた場合
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

    // ■伝票変更中に日次更新されていた場合
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
    // エラーチェック結果集計
    /****************************/
    // チェック適用
    $test = $form->validate();

    // 結果をフラグに
    $err_flg = (count($form->_errors) > 0) ? true : false;


    /****************************/
    // DB登録処理
    /****************************/
    // 支払ボタン押下時＋エラーのない場合
    if ($_POST["payout_flg"] == "true" && $err_flg != true){

        $ary_input_id_row = null;
        // 現在の最大桁数繰り返し
        for ($i = 0; $i < $max_row; $i++){
            // 空白行を除いた仕入先IDの配列作成
            if ($ary_client_id[$i] != ""){
                $ary_input_id_row[] = $i;
            }
        }

        // トランザクション開始
        Db_Query($db_con, "BEGIN;");

        // 削除行判定
        foreach ($ary_input_id_row as $key){

            // 日付の0埋め
            $_POST["form_pay_day_$key"]     = Str_Pad_Date($_POST["form_pay_day_$key"]);
            $_POST["form_account_day_$key"] = Str_Pad_Date($_POST["form_account_day_$key"]);

            // POSTデータを変数にセット
            $post_client_id[$key]       = $_POST["hdn_client_id"][$key];            // 仕入先ID
            $post_client_cd1[$key]      = $_POST["form_client_cd1_$key"];           // 仕入先コード１
            $post_client_cd2[$key]      = $_POST["form_client_cd2_$key"];           // 仕入先コード２
            $post_pay_day_y[$key]       = $_POST["form_pay_day_$key"]["y"];         // 支払日（年）
            $post_pay_day_m[$key]       = $_POST["form_pay_day_$key"]["m"];         // 支払日（月）
            $post_pay_day_d[$key]       = $_POST["form_pay_day_$key"]["d"];         // 支払日（日）
            $post_pay_bank[$key]        = $_POST["form_pay_bank_$key"];             // 振込銀行略称
            $post_trade[$key]           = $_POST["form_trade_$key"];                // 取引区分
            $post_bank[$key]            = $_POST["form_bank_$key"];                 // 銀行・支店・口座（配列）
            $post_pay_mon[$key]         = $_POST["form_pay_mon_$key"];              // 支払額
            $post_pay_fee[$key]         = $_POST["form_pay_fee_$key"];              // 手数料
            $post_account_day_y[$key]   = $_POST["form_account_day_$key"]["y"];     // 決済日（年）
            $post_account_day_m[$key]   = $_POST["form_account_day_$key"]["m"];     // 決済日（月）
            $post_account_day_d[$key]   = $_POST["form_account_day_$key"]["d"];     // 決済日（日）
            $post_payable_no[$key]      = $_POST["form_payable_no_$key"];           // 手形券面番号
            $post_note[$key]            = $_POST["form_note_$key"];                 // 備考

            // 日付POSTを使いやすく
            $post_pay_day[$key]     = $post_pay_day_y[$key]."-".$post_pay_day_m[$key]."-".$post_pay_day_d[$key];
            $post_account_day[$key] = $post_account_day_y[$key]."-".$post_account_day_m[$key]."-".$post_account_day_d[$key];

            // 新規支払時
            if ($get_flg != "true"){

                // 最新の支払番号＋１
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

                // 支払ヘッダINSERT
                $sql  = "INSERT INTO \n";
                $sql .= "   t_payout_h \n";
                $sql .= "( \n";
                $sql .= "   pay_id, \n";                // 支払ID
                $sql .= "   pay_no, \n";                // 支払番号
                $sql .= "   pay_day, \n";               // 支払日
                $sql .= "   client_id, \n";             // 仕入先ID
                $sql .= "   client_cd1, \n";            // 仕入先コード１
                $sql .= "   client_cd2, \n";            // 仕入先コード２
                $sql .= "   client_name, \n";           // 仕入先名１
                $sql .= "   client_name2, \n";          // 仕入先名２
                $sql .= "   client_cname, \n";          // 仕入先名略称
                $sql .= "   input_day, \n";             // 入力日
                $sql .= "   buy_id, \n";                // 仕入ID
                $sql .= "   renew_flg, \n";             // 日次更新フラグ
                $sql .= "   renew_day, \n";             // 日次更新日
                $sql .= "   schedule_payment_id, \n";   // 支払予定ID
                $sql .= "   shop_id, \n";               // ショップID
                $sql .= "   e_staff_id, \n";            // 入力者ID
                $sql .= "   e_staff_name, \n";          // 入力者名
                $sql .= "   c_staff_id, \n";            // 担当者ID
                $sql .= "   c_staff_name, \n";          // 担当者名
                $sql .= "   account_day, \n";           // 決済日
                $sql .= "   payable_no \n";             // 手形券面番号
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
                    $err_mes = pg_last_error();             // エラーメッセージ取得
                    $err_format = "t_payout_h_pay_no_key";  // ユニーク制約の制約名
                    Db_Query($db_con, "ROLLBACK;");         // ロールバック
                    // エラーメッセージにユニーク制約が含まれていたら
                    if (strstr($err_mes, $err_format) != false){ 
                        $duplicate_err  = "支払入力が同時に行われたため、支払番号の付番に失敗しました。";
                        $duplicate_flg  = true;             // 制約エラーフラグにtrueをセット
                        $err_flg        = true;
                        break;
                    // その他のエラー
                    }else{  
                        exit;                               // 強制終了
                    }
                }

            // 支払変更時
            }else{

                // 支払ヘッダUPDATE
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

                // 支払データDELETE
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

            // 手数料に入力/未入力に応じてループ数を設定
            if ($post_pay_fee[$key] == ""){
                $d_insert_cnt = 1;
            }else{
                $d_insert_cnt = 2;
            }

            for ($i = 0; $i < $d_insert_cnt; $i++){

                // 支払データINSERT
                $sql  = "INSERT INTO \n";
                $sql .= "   t_payout_d \n";
                $sql .= "( \n";
                $sql .= "   pay_d_id, \n";          // 支払データID
                $sql .= "   pay_id, \n";            // 支払ID
                $sql .= "   pay_amount, \n";        // 支払金額/手数料
                $sql .= "   trade_id, \n";          // 取引区分
                $sql .= "   bank_name2, \n";        // 振込銀行略称
                $sql .= "   bank_cd, \n";           // 銀行コード
                $sql .= "   bank_name, \n";         // 銀行名
                $sql .= "   b_bank_cd, \n";         // 支店コード
                $sql .= "   b_bank_name, \n";       // 支店名
                $sql .= "   account_id, \n";        // 口座ID
                $sql .= "   account_no, \n";        // 口座番号
                $sql .= "   deposit_kind, \n";      // 預金種目
                $sql .= "   note \n";               // 備考
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

        // トランザクション終了
        Db_Query($db_con, "COMMIT;");

        // 重複エラーない場合
        if ($err_flg != true && $duplicate_flg != true){
            // 完了画面へ遷移
            header("Location: ./1-3-305.php?flg=".$_POST["get_flg"]."&pay_id=".$pay_id);
            exit;
        }

    }

}


/*****************************/
// 照会画面から遷移
/*****************************/
// 初期表示時＋支払IDがある＋GETがある場合
if ($_POST["post_flg"] == null && $pay_id != null && $get_flg == "true"){

    $henkousyoki_meisai = true;

    // 日次更新の有無により、抽出データを変更
    $sql  = "SELECT \n";
    $sql .= "   t_payout_h.pay_id, \n";                             // 支払ID
    $sql .= "   t_payout_h.pay_no, \n";                             // 支払番号
    $sql .= "   t_payout_h.pay_day, \n";                            // 支払日
    $sql .= "   t_client.client_div, \n";                           // 仕入先区分
    $sql .= "   t_payout_h.client_id, \n";                          // 仕入先ID
    $sql .= "   t_client.client_cd1, \n";                           // 仕入先コード１
    $sql .= "   t_client.client_cd2, \n";                           // 仕入先コード２
    $sql .= "   t_client.client_cname, \n";                         // 仕入先名
    $sql .= "   t_payout_h.buy_id, \n";                             // 仕入ID
    $sql .= "   t_payout_d.trade_id, \n";                           // 取引区分ID
    $sql .= "   t_schedule_payment.schedule_of_payment_this, \n";   // 今回支払予定額
    $sql .= "   t_payout_d.pay_amount, \n";                         // 支払金額
    $sql .= "   t_payout_d_fee.pay_amount AS fee_amount, \n";       // 手数料
    $sql .= "   t_payout_d.bank_name2, \n";                         // 振込銀行略称
    $sql .= "   CAST(t_b_bank.bank_id AS varchar), \n";             // 銀行ID
    $sql .= "   CAST(t_b_bank.b_bank_id AS varchar), \n";           // 支店ID
    $sql .= "   CAST(t_payout_d.account_id AS varchar), \n";        // 口座ID
    $sql .= "   t_payout_d.note, \n";                               // 備考
    $sql .= "   t_payout_h.renew_flg, \n";                          // 日次更新フラグ
    $sql .= "   t_payout_h.account_day, \n";                        // 決済日
    $sql .= "   t_payout_h.payable_no \n";                          // 手形券面番号
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
    $sql .= "   t_payout_h.pay_id, \n";                             // 支払ID
    $sql .= "   t_payout_h.pay_no, \n";                             // 支払番号
    $sql .= "   t_payout_h.pay_day, \n";                            // 支払日
    $sql .= "   t_client.client_div, \n";                           // 仕入先区分
    $sql .= "   t_payout_h.client_id, \n";                          // 仕入先ID
    $sql .= "   t_payout_h.client_cd1, \n";                         // 仕入先コード１
    $sql .= "   t_payout_h.client_cd2, \n";                         // 仕入先コード２
    $sql .= "   t_payout_h.client_cname, \n";                       // 仕入先名
    $sql .= "   t_payout_h.buy_id, \n";                             // 仕入ID
    $sql .= "   t_payout_d.trade_id, \n";                           // 取引区分ID
    $sql .= "   t_schedule_payment.schedule_of_payment_this, \n";   // 今回支払予定額
    $sql .= "   t_payout_d.pay_amount, \n";                         // 支払金額
    $sql .= "   t_payout_d_fee.pay_amount AS fee_amount, \n";       // 手数料
    $sql .= "   t_payout_d.bank_name2, \n";                         // 振込銀行略称
    $sql .= "   t_payout_d.bank_cd  || '：' || t_payout_d.bank_name, \n";       // 銀行コード：銀行名
    $sql .= "   t_payout_d.b_bank_cd || '：' || t_payout_d.b_bank_name, \n";    // 支店コード：支店名
    $sql .= "   CASE t_payout_d.deposit_kind \n";
    $sql .= "       WHEN '1' THEN '普通：' || t_payout_d.account_no \n";        // 預金種目：口座番号
    $sql .= "       WHEN '2' THEN '当座：' || t_payout_d.account_no \n";
    $sql .= "   END AS account_id, \n";
    $sql .= "   t_payout_d.note, \n";                               // 備考
    $sql .= "   t_payout_h.renew_flg, \n";                          // 日次更新フラグ
    $sql .= "   t_payout_h.account_day, \n";                        // 決済日
    $sql .= "   t_payout_h.payable_no \n";                          // 手形券面番号
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

    // データが存在する場合
    if ($num > 0){

        $refdata = pg_fetch_array($res);

        // データ取得
        $getdata["pay_id"]                  = $refdata["pay_id"];                   // 支払ID
        $getdata["pay_no"]                  = $refdata["pay_no"];                   // 支払番号
        $get_pay_day                        = explode("-",$refdata['pay_day']);     // 支払日(配列）
        $getdata["form_pay_day_0"]["y"]     = $get_pay_day[0];                      // 年
        $getdata["form_pay_day_0"]["m"]     = $get_pay_day[1];                      // 月
        $getdata["form_pay_day_0"]["d"]     = $get_pay_day[2];                      // 日
        $getdata["hdn_client_id"][]         = $refdata["client_id"];                // 仕入先ID
        $get_client_div                     = $refdata["client_div"];               // 取引先区分
        $getdata["form_client_cd1_0"]       = $refdata["client_cd1"];               // 仕入先コード１
        if ($get_client_div == "3"){
            $getdata["form_client_cd2_0"]   = $refdata["client_cd2"];               // 仕入先コード２
        }
        $getdata["form_client_name_0"]      = $refdata["client_cname"];             // 仕入先名
        $getdata["form_pay_bank_0"]         = $refdata["bank_name2"];               // 振込銀行略称
        $getdata["form_trade_0"]            = $refdata["trade_id"];                 // 取引区分ID
        $get_bank_id                        = $refdata["bank_id"];                  // 銀行ID OR 銀行コード＋銀行名
        $get_b_bank_id                      = $refdata["b_bank_id"];                // 支店ID OR 支店コード＋支店名
        $get_account_id                     = $refdata["account_id"];               // 口座ID OR 口座種目＋口座番号
        $getdata["form_note_0"]             = $refdata["note"];                     // 備考
        $get_buy_id                         = $refdata['buy_id'];                   // 仕入ID
        $get_renew_flg                      = $refdata['renew_flg'];                // 日次更新フラグ

        // フリーズ設定
        // 日次更新済、または自動支払
        if ($get_renew_flg == "t" || $get_buy_id != null){
            $freeze_flg = true;
        }

        // 日次更新未実施かつ自動支払でない場合
        if ($get_renew_flg == "f" && $get_buy_id == ""){
            // ヒアセレクトフォームに
            $getdata["form_bank_0"][0]      = $get_bank_id;
            $getdata["form_bank_0"][1]      = $get_b_bank_id;
            $getdata["form_bank_0"][2]      = $get_account_id;
        }else{
            // リードオンリーフォームに
            $getdata["bank_name_0"]         = $get_bank_id;
            $getdata["b_bank_name_0"]       = $get_b_bank_id;
            $getdata["account_id_0"]        = $get_account_id;
        }

        // ナンバーフォーマット処理
        // フリーズする場合
        if($get_renew_flg == "t" || $get_buy_id != ""){
            $getdata["form_pay_mon_0"] = number_format($refdata["pay_amount"]);
            $getdata["form_pay_fee_0"] = ($refdata["fee_amount"] != null) ? number_format($refdata["fee_amount"]) : "";
        // フリーズしない場合
        }else{
            $getdata["form_pay_mon_0"] = $refdata["pay_amount"];
            $getdata["form_pay_fee_0"] = $refdata["fee_amount"];
        } 

        if ($refdata["schedule_of_payment_this"] != null){
            $getdata["form_pay_mon_plan_0"] = number_format($refdata['schedule_of_payment_this']);
        }else{
            $getdata["form_pay_mon_plan_0"] = "";
        }

        $get_account_day = explode("-", $refdata["account_day"]);       // 決済日(配列）
        $getdata["form_account_day_0"]["y"] = $get_account_day[0];      // 年
        $getdata["form_account_day_0"]["m"] = $get_account_day[1];      // 月
        $getdata["form_account_day_0"]["d"] = $get_account_day[2];      // 日
        $getdata["form_payable_no_0"] = $refdata["payable_no"];         // 手形券面番号

        // 変更・明細フラグにtrueをセット
        $get_flg = "true";
        $getdata["get_flg"] = $get_flg;
        $form->setConstants($getdata);

        // 最大行数をセット
        $max_row = 1;
        $max_data["max_row"] = $max_row;
        $form->setConstants($max_data);

        $disp_client_id = $refdata["client_id"];

    // データが存在しない場合
    }else{

        header("Location:../top.php");

    }

}


/*****************************/
// パターンとフリーズ
/*****************************/
// 新規支払時
if (
    $get_flg != "true" && 
    ($_POST["confirm_button"] == null || ($_POST["confirm_button"] != null && $err_flg == true))
){

    // パターン
    $disp_pattern = "1";

}else
// 伝票取得時（変更）
if (
    $get_flg == "true" && 
    ($_POST["confirm_button"] == null || ($_POST["confirm_button"] != null && $err_flg == true)) &&
    ($get_renew_flg != "t" && $get_buy_id == null)
){

    // パターン
    $disp_pattern = "2";

}else
// 伝票取得時（明細）
if (
    $get_flg == "true" && 
    ($_POST["confirm_button"] == null || ($_POST["confirm_button"] != null && $err_flg == true)) &&
    ($get_renew_flg == "t" || $get_buy_id != null)
){

    // パターン
    $disp_pattern = "3";

    // フォームをフリーズ
    $form->freeze();

}else
// 確認画面へボタン押下＋エラーなし
if ($_POST["confirm_button"] != null && $err_flg != true){

    // パターン
    $disp_pattern = "4";

    // フォームをフリーズ
    $form->freeze();

}


/*****************************/
// ・カンマ除去・ナンバーフォーマット
// ・登録しない行の入力内容を消す（確認画面のみ）
/*****************************/
$ary_input_id_row = null;
// 現在の最大桁数繰り返し
for ($i = 0; $i < $max_row; $i++){
    // 空白行を除いた仕入先IDの配列作成
    if ($ary_client_id[$i] != ""){
        $ary_input_id_row[] = $i;
    }
}

// 最大行数でループ
for ($i = 0; $i < $max_row; $i++){

    // 削除行判定＋仕入先が変更されていない行
    if (!in_array($i, $ary_del_rows) && $_POST["layer"] !== $i){

        // カンマ除去
        // フリーズしない場合
        if ($disp_pattern == "1" || $disp_pattern == "2"){
            // 値のある場合のみ
            if ($_POST["form_pay_mon_$i"] != null){
                $set_num_format["form_pay_mon_$i"] = str_replace(",", "", $_POST["form_pay_mon_$i"]);
            }
            if ($_POST["form_pay_fee_$i"] != null){
                $set_num_format["form_pay_fee_$i"] = str_replace(",", "", $_POST["form_pay_fee_$i"]);
            }
        }else

        // ナンバーフォーマット
        // フリーズしている場合
        if ($disp_pattern == "3" || $disp_pattern == "4"){
            // 値のある場合のみ
            if ($_POST["form_pay_mon_$i"] != null){
                $set_num_format["form_pay_mon_$i"] = number_format($_POST["form_pay_mon_$i"]);
            }
            if ($_POST["form_pay_fee_$i"] != null){
                $set_num_format["form_pay_fee_$i"] = number_format($_POST["form_pay_fee_$i"]);
            }
        }

        // 確認画面では登録しない行の入力内容を消す
        // 確認画面時
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

// カンマ除去・ナンバーフォーマット関連
$form->setConstants($set_num_format);
// フォームデータ削除関連
$form->setConstants($clear_form);


/*****************************/
// フォーム作成（変動）
/*****************************/
// 行番号カウンタ
$row_num = 1;

$html_l = null;

// 最大行数でループ
for ($i = 0; $i < $max_row; $i++){

    // 削除行判定
    if (!in_array($i, $ary_del_rows)){

        // 削除履歴
        $del_data = $del_row.",".$i;

        // 仕入先
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

        // 振込銀行略称
        $form->addElement("text", "form_pay_bank_$i", "", "
            size=\"20\" maxLength=\"20\"
            style=\"color: #000000; border: #ffffff 1px solid; background-color: #ffffff;\" 
            readonly
        ");

/*
        // 支払日
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

        // 取引区分
        $form->addElement("select", "form_trade_$i", "", $trade_value, $g_form_option_select);

        // 銀行・支店・口座
        $obj_bank_select =& $form->addElement("hierselect", "form_bank_$i", "", "", "<br>");
        $obj_bank_select->setOptions($bank_value);
 
        // 銀行名
        $form->addElement("text", "bank_name_$i", "", "
            size=\"32\"
            style=\"color: #000000; border: none; backgrount-color: #ffffff;\" 
            readonly
        ");
        // 支店名
        $form->addElement("text", "b_bank_name_$i", "", "
            size=\"32\"
            style=\"color: #000000; border: none; backgrount-color: #ffffff;\"
            readonly
        ");
        // 口座番号
        $form->addElement("text", "account_id_$i", "", "
            size=\"20\"
            style=\"color: #000000; border: none; backgrount-color: #ffffff;\"
            readonly
        ");

        // 支払予定額
        $form->addElement("text", "form_pay_mon_plan_$i", "", "
            size=\"11\" maxLength=\"9\" 
            style=\"text-align: right; color: #000000; border: none; background-color: #ffffff;\"
            readonly
        ");

        // 支払金額
        $form->addElement("text", "form_pay_mon_$i", "", "
            class=\"money\" size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"
        ");

        // 手数料
        $form->addElement("text", "form_pay_fee_$i", "", "
            class=\"money\" size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"
        ");

        // 決済日
        Addelement_Date($form, "form_account_day_$i", "決済日", "-");

        // 手形券面番号
        $form->addElement("text", "form_payable_no_$i", "", "size=\"13\" maxLength=\"10\" $g_form_option class=\"ime_disabled\"");

        // 備考
        $form->addElement("text", "form_note_$i", "", "size=\"34\" maxLength=\"15\" $g_form_option");

        // 新規支払時
        if ($disp_pattern == "1"){

            // 支払確認画面へボタン
            $form->addElement("submit", "confirm_button", "支払確認画面へ",
                "onClick=\"Button_Submit_1('confirm_flg', '#', 'true');\" $disabled"
            );

            // 削除リンク
            if ($row_num == $max_row - $del_num){
                $form->addElement("link", "form_del_row_$i", "", "#", "<font color=\"#fefefe\">削除</font>",
                    "TABINDEX=-1 onClick=\"javascript:Dialogue_3('削除します。', '$del_data', 'del_row', $row_num-1); return false;\""
                );
            // 最終行以外を削除する場合、削除する行と同じNo.の行に合わせる
            }else{
                $form->addElement("link", "form_del_row_$i", "", "#", "<font color=\"#fefefe\">削除</font>",
                    "TABINDEX=-1 onClick=\"javascript:Dialogue_3('削除します。', '$del_data', 'del_row', $row_num  ); return false;\""
                );
            }

        }else
        // 伝票取得時（変更）
        if ($disp_pattern == "2"){

            // 支払確認画面へボタン
            $form->addElement("submit", "confirm_button", "支払確認画面へ",
                "onClick=\"Button_Submit_1('confirm_flg', '#', 'true');\" $disabled"
            );

        }else
        // 伝票取得時（明細）
        if ($disp_pattern == "3"){

            // 戻るボタン
            $form->addElement("button", "back_btn", "戻　る", "onClick=\"location.href='".Make_Rtn_Page("payout")."'\"");

        }else
        // 確認画面時
        if ($disp_pattern == "4"){

            // 支払ボタン
            $form->addElement("button", "payout_button", "支　払",
                "onClick=\"Dialogue_2('支払います。', '#', 'true', 'payout_flg'); return false;\" $disabled"
            );

            // 戻るボタン
            $form->addElement("submit", "back_btn", "戻　る", "onClick=\"Button_Submit_1('confirm_flg', '#', 'false');\"");

            // 合計金額
            $form->addElement("text","sum_mon", "", "
                size=\"11\"
                style=\"color: #000000; border: none; background-color: transparent; text-align: right;\" 
                readonly
            ");

            // 合計手数料
            $form->addElement("text", "sum_fee", "", "
                size=\"11\"
                style=\"color: #000000; border: none; background-color: transparent; text-align: right;\" 
                readonly
            ");

        }

        // 仕入先ID
        $form->addElement("hidden","hdn_client_id[$i]");

        // 支払予定ID
        $form->addElement("hidden","schedule_payment_id[$i]");


        /****************************/
        // 仕入先IDの状態取得
        /****************************/
        // 仕入先選択時
        if ($_POST["layer"] == "$i"){
            $client_state_print[$i] = Get_Client_State($db_con, $search_client_id);
        }else   
        // 変更画面初期時、明細画面時
        if ($henkousyoki_meisai == true){
            $client_state_print[$i] = Get_Client_State($db_con, $disp_client_id);
        // その他
        }else{  
            $client_state_print[$i] = Get_Client_State($db_con, $_POST["hdn_client_id"][$i]);
        }


        /****************************/
        //表示用HTML作成
        /****************************/
        $html_l .= "    <tr class=\"Result1\">\n";

        // ■ページ内リンク
        $html_l .= "        <A NAME=\"$row_num\"></A>\n";

        // ■行No.
        $html_l .= "        <td align=\"right\">$row_num</td>\n";

        // ■仕入先コード１
        // ■仕入先コード２
        // ■（検索）
        // ■仕入先名
        // ■振込銀行略称
        $html_l .= "        <td align=\"left\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_client_cd1_$i"]]->toHtml());
        // 変更・明細画面＋仕入先区分が仕入先の場合（仕入先区分が仕入先になっている全ての伝票が日次更新され、明細表示されることが前提）
        if ($get_flg == "true" && $get_client_div == "2"){
            // なし
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

        // ■支払日
        $html_l .= "        <td align=\"center\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_pay_day_$i"]]->toHtml())."\n";
        $html_l .= "        </td>\n";

        // ■取引区分
        $html_l .= "        <td>\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_trade_$i"]]->toHtml())."\n";
        $html_l .= "        </td>\n";

        // ■銀行
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
            // 正しい仕入先が選択されている＋銀行が選択されている場合のみ表示する
            if ($_POST["form_bank_$i"][0] != null){
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_bank_$i"]]->toHtml())."\n";
            }
        }
        $html_l .= "        </td>\n";

        // ■支払予定額
        $html_l .= "        <td align=\"right\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_pay_mon_plan_$i"]]->toHtml())."\n";
        $html_l .= "        </td>\n";

        // ■支払い金額
        // ■手数料
        $html_l .= "        <td align=\"right\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_pay_mon_$i"]]->toHtml())."\n";
        $html_l .= "            <br>\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_pay_fee_$i"]]->toHtml())."\n";
        $html_l .= "            <br>\n";
        $html_l .= "        </td>\n";

        // ■手形券面番号
        // ■決済日
        $html_l .= "        <td>\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_account_day_$i"]]->toHtml())."\n";
        $html_l .= "            <br>\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_payable_no_$i"]]->toHtml())."\n";
        $html_l .= "            <br>\n";
        $html_l .= "        </td>\n";

        // ■備考
        $html_l .= "        <td align=\"left\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_note_$i"]]->toHtml())."\n";
        $html_l .= "        </td>\n";

        // ■削除リンク
        if ($disp_pattern == "1"){
        $html_l .= "        <td align=\"center\" class=\"Title_Add\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_del_row_$i"]]->toHtml())."\n";
        $html_l .= "        </td>\n";
        }
        $html_l .= "    </tr>\n";

        // 行番号加算
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
//$page_menu = Create_Menu_h("buy", "3");

/****************************/
// 画面ヘッダー作成
/****************************/
$page_title .= Print_H_Link_Btn($form, $ary_h_btn_list);
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form関連の変数をassign
$smarty->assign("form", $renderer->toArray());

// その他の変数をassign
$smarty->assign("var", array(
    // 共通
    "html_header"       => "$html_header",
    "page_menu"         => "$page_menu",
    "page_header"       => "$page_header",
    "html_footer"       => "$html_footer",

    // html
    "html_l"            => "$html_l",
    "js"                => "$js",

    // フラグ関連
    "confirm_flg"       => "$confirm_flg",
    "get_flg"           => "$get_flg",
    "get_renew_flg"     => "$get_renew_flg",
    "disp_pattern"      => "$disp_pattern",

    // 金額合計・消費税合計
    "sum_pay_mon"       => "$sum_pay_mon",
    "sum_pay_fee"       => "$sum_pay_fee",

    // 支払番号重複エラーメッセージ
    "duplicate_err"     => "$duplicate_err",
));

// エラーをassign
$errors = $form->_errors;
$smarty->assign("errors", $errors);

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
