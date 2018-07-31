<?php
/*
 *
 *
 *
 *
 */

$page_title = "前受金入力";

// 環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB接続
$db_con = Db_Connect();


/*****************************/
// 権限関連処理
/*****************************/
// 権限チェック
$auth       = Auth_Check($db_con);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/*****************************/
// 再遷移先をSESSIONにセット
/*****************************/
// GET、POSTが無い場合
if ($_GET == null && $_POST == null){
    Set_Rtn_Page("advance");
}


/*****************************/
// 外部変数取得
/*****************************/
// SESSION
$shop_id        = $_SESSION["client_id"];           // ショップID
$group_kind     = $_SESSION["group_kind"];          // グループ種別
$staff_id       = $_SESSION["staff_id"];            // スタッフID
$staff_name     = $_SESSION["staff_name"];          // スタッフ名

// POST
$advance_id     = $_POST["hdn_advance_id"];         // 前受金ID（伝票変更時に使用）
$client_id      = $_POST["hdn_client_id"];          // 得意先ID（伝票変更時に使用）
$enter_day      = $_POST["hdn_enter_day"];          // データ登録日時（伝票変更時に使用）


/****************************/
// GETしたIDの正当性チェック
/****************************/
// 初期表示時＋GETのIDがある場合
if ($_POST["post_flg"] != "true" && $_GET["advance_id"] != null){

    // GETした支払IDの妥当性チェック
    $safe_flg = Get_Id_Check_Db($db_con, $_GET["advance_id"], "advance_id", "t_advance", "num", "shop_id = $shop_id");
    if ($safe_flg === false){ 
        header("Location:../top.php");
        exit;   
    }

    $advance_id = $_GET["advance_id"];      // 前受金ID

    // hiddenに前受金IDをセット
    $hdn_set["hdn_advance_id"] = $advance_id;
    $form->setConstants($hdn_set);

}


/****************************/
// GETしたIDの伝票データ取得
/****************************/
// 初期表示時＋GETのIDがある場合
if ($_POST["post_flg"] != "true" && $_GET["advance_id"] != null){

    // 伝票データ取得クエリ
    $sql  = "SELECT \n";
    $sql .= "   t_advance.advance_id, \n";                                      // 前受金ID
    $sql .= "   t_advance.advance_no, \n";                                      // 伝票番号
    $sql .= "   t_advance.pay_day, \n";                                         // 入金日

    $sql .= "   t_advance.client_id, \n";                                       // 得意先ID
    $sql .= "   t_client.client_cd1, \n";                                       // 得意先コード１
    $sql .= "   t_client.client_cd2, \n";                                       // 得意先コード２
    $sql .= "   t_client.client_cname, \n";                                     // 得意先名略称
    $sql .= "   t_advance.client_cd1            AS client_cd1_fix, \n";         // 得意先コード１（確定済用）
    $sql .= "   t_advance.client_cd2            AS client_cd2_fix, \n";         // 得意先コード２（確定済用）
    $sql .= "   t_advance.client_cname          AS client_cname_fix, \n";       // 得意先名略称（確定済用）

    $sql .= "   t_advance.claim_div, \n";                                       // 請求先区分
    $sql .= "   t_advance.claim_id, \n";                                        // 請求先ID
    $sql .= "   t_advance.claim_cd1             AS claim_cd1_fix, \n";          // 請求先コード１（確定済用）
    $sql .= "   t_advance.claim_cd2             AS claim_cd2_fix, \n";          // 請求先コード２（確定済用）
    $sql .= "   t_advance.claim_cname           AS claim_cname_fix, \n";        // 請求先名略称（確定済用）

    $sql .= "   t_advance.amount, \n";                                          // 金額
    $sql .= "   t_advance.bank_id, \n";                                         // 銀行ID
    $sql .= "   t_advance.bank_cd               AS bank_cd_fix, \n";            // 銀行コード（確定済用）
    $sql .= "   t_advance.bank_name             AS bank_name_fix, \n";          // 銀行名（確定済用）
    $sql .= "   t_advance.b_bank_id, \n";                                       // 支店ID
    $sql .= "   t_advance.b_bank_cd             AS b_bank_cd_fix, \n";          // 支店コード（確定済用）
    $sql .= "   t_advance.b_bank_name           AS b_bank_name_fix, \n";        // 支店名（確定済用）
    $sql .= "   t_advance.account_id, \n";                                      // 口座ID
    $sql .= "   CASE t_advance.deposit_kind \n";
    $sql .= "       WHEN '1' THEN '普通' \n";
    $sql .= "       WHEN '2' THEN '当座' \n";
    $sql .= "   END                             AS deposit_kind_fix, \n";       // 預金種目（確定済用）
    $sql .= "   t_advance.account_no            AS account_no_fix, \n";         // 口座番号（確定済用）

    $sql .= "   t_advance.staff_id, \n";                                        // 担当者ID
    $sql .= "   t_advance.note, \n";                                            // 備考
    $sql .= "   t_advance.fix_day, \n";                                         // 前受金確定日
    $sql .= "   t_advance.enter_day \n";                                        // 伝票作成日時

    $sql .= "FROM \n";
    $sql .= "   t_advance \n";
    $sql .= "   LEFT JOIN t_client \n";
    $sql .= "       ON t_advance.client_id = t_client.client_id \n";
    $sql .= "   LEFT JOIN t_client AS t_c_claim \n";
    $sql .= "       ON t_advance.client_id = t_c_claim.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_advance.advance_id = $advance_id \n";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // レコードがある場合
    if ($num > 0){

        // データ取得
        $get_data = Get_Data($res, "2", "ASSOC");

        // 取得データを変数にセット
        $client_id  = $get_data[0]["client_id"];                           // 得意先ID
        $fix_flg    = ($get_data[0]["fix_day"] != null) ? true : false;    // 確定フラグ

        // 取得データをフォーム・hiddenにセット
        $form_set["hdn_client_id"]          = $get_data[0]["client_id"];
        $form_set["form_advance_no"]        = $get_data[0]["advance_no"];
        $form_set["form_pay_day"]["y"]      = substr($get_data[0]["pay_day"], 0, 4);
        $form_set["form_pay_day"]["m"]      = substr($get_data[0]["pay_day"], 5, 2);
        $form_set["form_pay_day"]["d"]      = substr($get_data[0]["pay_day"], 8, 2);
        if ($fix_flg != true){
            // 未確定時
            $form_set["form_client"]["cd1"] = $get_data[0]["client_cd1"];
            $form_set["form_client"]["cd2"] = $get_data[0]["client_cd2"];
            $form_set["form_client"]["name"]= $get_data[0]["client_cname"];
            $form_set["form_claim"]         = $get_data[0]["claim_div"];
            $form_set["form_bank"][0]       = $get_data[0]["bank_id"];
            $form_set["form_bank"][1]       = $get_data[0]["b_bank_id"];
            $form_set["form_bank"][2]       = $get_data[0]["account_id"];
            $form_set["form_amount"]        = $get_data[0]["amount"];
        }else{
            // 確定済時
            $form_set["form_client"]["cd1"] = $get_data[0]["client_cd1_fix"];
            $form_set["form_client"]["cd2"] = $get_data[0]["client_cd2_fix"];
            $form_set["form_client"]["name"]= $get_data[0]["client_cname_fix"];
            $form_set["form_claim"]         = $get_data[0]["claim_cd1_fix"]."-";
            $form_set["form_claim"]        .= $get_data[0]["claim_cd2_fix"]." ";
            $form_set["form_claim"]        .= htmlspecialchars($get_data[0]["claim_cname_fix"]);
            // 銀行が登録されている場合
            if ($get_data[0]["bank_id"] != null){
                $form_set["form_bank"]      = $get_data[0]["bank_cd_fix"]." ： ";
                $form_set["form_bank"]     .= htmlspecialchars($get_data[0]["bank_name_fix"])."　";
                $form_set["form_bank"]     .= $get_data[0]["b_bank_cd_fix"]." ： ";
                $form_set["form_bank"]     .= htmlspecialchars($get_data[0]["bank_name_fix"])."　";
                $form_set["form_bank"]     .= $get_data[0]["deposit_kind_fix"]." ： ";
                $form_set["form_bank"]     .= $get_data[0]["account_no_fix"];
            // 銀行が登録されていない場合
            }else{
                $form_set["form_bank"]      = null;
            }
            $form_set["form_amount"]        = number_format($get_data[0]["amount"]);
        }
        $form_set["form_staff"]             = $get_data[0]["staff_id"];
        $form_set["form_note"]              = $get_data[0]["note"];
        $form_set["hdn_enter_day"]          = $get_data[0]["enter_day"];
        $form->setConstants($form_set);

    }

}


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
    $sql .= "   client_id,\n";
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
    $sql .= "   shop_id IN ".Rank_Sql2()." \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // 該当データがある場合
    if ($num > 0){
        $client_id      = pg_fetch_result($res, 0, 0);      // 得意先ID
        $client_name    = pg_fetch_result($res, 0, 1);      // 得意先名（略称）
        $claim_div      = 1;                                // 請求先区分１をデフォルトとする
    }else{
        $client_id      = "";
        $client_name    = "";
        $claim_div      = "";
    }
    // 得意先コード入力フラグをクリア
    // 得意先ID、得意先名（略称）、得意先状態、請求先区分をフォームにセット
    $set_client_data["client_search_flg"]   = "";
    $set_client_data["hdn_client_id"]       = $client_id;
    $set_client_data["form_client"]["name"] = $client_name;
    $set_client_data["form_claim_select"]   = $claim_div;
    $form->setConstants($set_client_data);

}


/*****************************/
// 確認画面でナンバーフォーマットされたフォームの数値からカンマを除去
/*****************************/
// 確認ボタン押下時、確認画面の戻るボタン押下時
if ($_POST["ok_button"] != null || $_POST["confirm_flg"] == "false"){

    // ナンバーフォーマットされている金額のPOSTデータからカンマを除去
    $_POST["form_amount"] = $form_set["form_amount"] = str_replace(",", "", $_POST["form_amount"]);

    // フォームにセット
    $form->setConstants($form_set);

}


/*****************************/
// フォームパーツ定義
/*****************************/
// 伝票番号
$form->addElement("text", "form_advance_no", "", "size=\"11\" maxLength=\"8\" tabindex=\"-1\"
    style=\"color: #525552; border: #ffffff 1px solid; background-color: #ffffff; text-align: left\" readonly
");

// 入金日
Addelement_Date($form, "form_pay_day", "入金日", "-");

// 得意先リンク
$form->addElement("link", "form_client_link", "", "#", "得意先", "taxindex=\"-1\"
    onClick=\"return Open_SubWin('../dialog/2-0-402.php',
        Array('form_client[cd1]', 'form_client[cd2]', 'form_client[name]', 'client_search_flg'),
        500, 450, 5, 1
    );\"
");

// 得意先
$text   =   null; 
$text[] =&  $form->createElement("text", "cd1", "", "
    size=\"7\" maxLength=\"6\" class=\"ime_disabled\" $g_form_option
    onChange=\"javascript:Change_Submit('client_search_flg', '#', 'true', 'form_client[cd2]');\"
    onkeyup=\"changeText(this.form, 'form_client[cd1]', 'form_client[cd2]', 6);\"
");
$text[] =&  $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "cd2", "", "
    size=\"4\" maxLength=\"4\" class=\"ime_disabled\" $g_form_option
    onChange=\"javascript:Button_Submit('client_search_flg', '#', 'true');\"
");
$text[] =&  $form->createElement("static", "", "", " ");
$text[] =&  $form->createElement("text", "name", "", "size=\"34\" onKeyDown=\"chgKeycode();\" $g_text_readonly");
$form->addGroup($text, "form_client", "", "");

// 請求先
if ($fix_flg != true){
    $item   =   null;
    $item   =   ($client_id != null) ? Select_Get($db_con, "claim_payin", "t_claim.client_id = $client_id ") : null;
    unset($item[null]);
    $form->addElement("select", "form_claim", "", $item, $g_form_option_select);
}else{
    $form->addElement("static", "form_claim", "", "");
}

// 銀行
if ($fix_flg != true){
    $item   =   null;
    $item   =   Make_Ary_Bank($db_con);
    $obj    =   null;
    $obj    =&  $form->addElement("hierselect", "form_bank", "", "", "　", $g_form_option_select);
    $obj->setOptions($item);
}else{
    $form->addElement("static", "form_bank", "", "");
}

// 金額
$form->addElement("text", "form_amount", "", "
    class=\"money\" size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"
");

// 担当者
$item   =   null;
$item   =   Select_Get($db_con, "round_staff_ms");
$form->addElement("select", "form_staff", "", $item, $g_form_option_select);

// 備考
$form->addElement("text", "form_note", "", "size=\"34\" maxLength=\"20\" $g_form_option");

// 確認画面へボタン
$form->addElement("button", "confirm_button", "確認画面へ", "onClick=\"Button_Submit_1('confirm_flg', '#', 'true');\" $disabled");

// 登録ボタン
$form->addElement("button", "hdn_ok_button", "登　録", "onClick=\"javascript: Double_Post_Prevent2(this);\" $disabled");

// ヘッダ部リンクボタン
$ary_h_btn_list = array("照会・変更" => "./2-2-412.php", "入　力" => $_SERVER["PHP_SELF"]);
Make_H_Link_Btn($form, $ary_h_btn_list, 2);

// hidden
$form->addElement("hidden", "hdn_advance_id");      // 前受金ID
$form->addElement("hidden", "hdn_client_id");       // 得意先ID
$form->addElement("hidden", "hdn_enter_day");       // 伝票作成日時
$form->addElement("hidden", "client_search_flg");   // 得意先検索フラグ
$form->addElement("hidden", "ok_button");           // 登録ボタン押下
$form->addElement("hidden", "confirm_flg");         // 確認画面へボタン押下フラグ（確認画面から戻るボタンを押下した場合はfalse）
$form->addElement("hidden", "post_flg", "true");    // 自画面POST確認フラグ（初期表示時のみnull）

// エラーセット用
$form->addElement("text", "err_illegal_post");      // 得意先コード変更中に確認画面へボタンが押された時にエラーメッセージセット


/****************************/
// 共通エラーチェック
/****************************/
// 確認画面へボタン、確認ボタン押下時
if ($_POST["confirm_flg"] == "true" || $_POST["ok_button"] != null){

    // 確認画面へボタン押下フラグをクリア
    // 確認ボタン押下フラグをクリア
    $hdn_clear["confirm_flg"]   = "";
    $hdn_clear["ok_button"]     = "";
    $form->setConstants($hdn_clear);

    /****************************/
    // エラーチェック前処理
    /****************************/
    // 日付の0埋め
    $_POST["form_pay_day"] = Str_Pad_Date($_POST["form_pay_day"]);

    // 日付を変数に
    $pay_day_y  = $_POST["form_pay_day"]["y"];
    $pay_day_m  = $_POST["form_pay_day"]["m"];
    $pay_day_d  = $_POST["form_pay_day"]["d"];
    $pay_day    = $pay_day_y."-".$pay_day_m."-".$pay_day_d;

    /****************************/
    // エラーチェック
    /****************************/
    // ■入金日

        // 必須チェック
        if ($pay_day_y == null && $pay_day_m == null && $pay_day_d == null){
            $form->setElementError("form_pay_day", "入金日 は必須です。");
        }

        // 半端入力チェック
        elseif (!($pay_day_y != null && $pay_day_m != null && $pay_day_d != null)){
            $form->setElementError("form_pay_day", "入金日 の日付が妥当ではありません。");
        }

        // 数値チェック
        elseif (!ereg("^[0-9]+$", $pay_day_y) || !ereg("^[0-9]+$", $pay_day_m) || !ereg("^[0-9]+$", $pay_day_d)){
            $form->setElementError("form_pay_day", "入金日 の日付が妥当ではありません。");
        }

        // 日付の妥当性チェック
        elseif (!checkdate((int)$pay_day_m, (int)$pay_day_d, (int)$pay_day_y)){
            $form->setElementError("form_pay_day", "入金日 の日付が妥当ではありません。");
        }

        // これまでに日付のエラーがない場合
        if ($form->getElementError("form_pay_day") == null){

            // システム開始日以降チェック関数実行
            $sysup_chk = Sys_Start_Date_Chk($pay_day_y, $pay_day_m, $pay_day_d, "入金日");

            // 得意先ID、請求先区分がある場合
            if ($client_id != null && $_POST["form_claim"] != null){

                // 請求締日以降チェック関数実行
                $close_chk = Check_Bill_Close_Day_Claim($db_con, $client_id, $_POST["form_claim"], $pay_day_y, $pay_day_m, $pay_day_d);

                // 前回の前受相殺日以降チェック関数実行
                $offset_chk = Check_Adv_Offset_Day($db_con, $client_id, $_POST["form_claim"], $pay_day_y, $pay_day_m, $pay_day_d);

            }

            // 未来日付チェック
            if ($pay_day > date("Y-m-d")){
                $form->setElementError("form_pay_day", "入金日 に未来の日付が入力されています。");
            }

            // システム開始日以降チェック
            elseif ($sysup_chk != null){
                $form->setElementError("form_pay_day", "$sysup_chk");
            }

            // 請求締日以降チェック
            elseif ($close_chk === false){
                $form->setElementError("form_pay_day", "入金日 に前回の請求締以前の日付が入力されています。");
            }

            // 前回の前受相殺日以降チェック
            elseif ($offset_chk === false){
                $form->setElementError("form_pay_day", "入金日 に前回の前受相殺日以前の日付が入力されています。");
            }

        }

    // ■得意先

        // 必須チェック
        if ($_POST["form_client"]["cd1"] == null && $_POST["form_client"]["cd2"] == null){
            $form->setElementError("form_client", "得意先 は必須です。");
        }

        // これまでにエラーがない場合
        if ($form->getElementError("form_client") == null){

            // 得意先の妥当性チェック
            if ($client_id == null){
                $form->setElementError("form_client", "得意先 が妥当ではありません。");
            }

            // 得意先検索と同時に確認画面へボタンが押下された場合のチェック
            elseif ($_POST["client_search_flg"] == "true" && $_POST["confirm_flg"] == "true"){
                $form->setElementError("form_client", "得意先情報取得前に 確認画面へボタン が押されました。<br>操作をやり直してください。");
                $client_search_confirm_flg = true;
            }

        }

    // ■請求先

        // 必須チェック（請求先がnull＋得意先検索と同時に確認画面へボタンが押下されていない場合）
        if ($_POST["form_claim"] == null && $client_search_confirm_flg != true){
            $form->setElementError("form_claim", "請求先 は必須です。");
        }

        // 請求先存在チェック
        elseif ($_POST["form_claim"] != null && $client_id != null){
            if (Check_Claim_Alive($db_con, $client_id, $_POST["form_claim"]) === false){
                $form->setElementError("form_claim", "存在しない請求先です。");
            }
        }

    // ■金額

        // 必須チェック
        if ($_POST["form_amount"] == null){
            $form->setElementError("form_amount", "金額 は必須です。");
        }

        // 妥当性チェック
        elseif (!ereg("^[-]?[0-9]+$", $_POST["form_amount"])){
            $form->setElementError("form_amount", "金額 が妥当ではありません。");
        }

    // ■銀行

        // 半端入力チェック
        if ($_POST["form_bank"][0] != null && $_POST["form_bank"][2] == null){
            $form->setElementError("form_bank", "銀行選択時は口座まで指定してください。");
        }

    /****************************/
    // エラーチェック結果集計
    /****************************/
    // チェック適用
    $form->validate();

    // 結果をフラグに
    $err_flg = (count($form->_errors) > 0) ? true : false;

}


/****************************/
// 最終エラーチェック
/****************************/
// OKボタン押下＋エラーのない場合
if ($_POST["ok_button"] != null && $err_flg != true){

    // 伝票変更時
    if ($advance_id != null){

        // ■伝票の正当性チェック（削除チェック）
        if (Update_Check($db_con, "t_advance", "advance_id", $advance_id, $enter_day) === false){
            header("Location: ./2-2-413.php?err=1");
            exit;
        }

        // ■前受金確定チェック
        elseif (Fixed_Check($db_con, "t_advance", "advance_id", $advance_id) === false){
            header("Location: ./2-2-413.php?err=2");
            exit;
        }

    }

}


/****************************/
// DB登録
/****************************/
// OKボタン押下＋エラーのない場合
if ($_POST["ok_button"] != null && $err_flg != true){

    // POSTを変数にセット
    $post_advance_no    = $_POST["form_advance_no"];
    $post_pay_day       = $_POST["form_pay_day"]["y"]."-".$_POST["form_pay_day"]["m"]."-".$_POST["form_pay_day"]["d"];
    $post_client_id     = $_POST["hdn_client_id"];
    $post_claim_div     = $_POST["form_claim"];
    $post_amount        = $_POST["form_amount"];
    $post_bank_id       = $_POST["form_bank"][0];
    $post_b_bank_id     = $_POST["form_bank"][1];
    $post_account_id    = $_POST["form_bank"][2];
    $post_staff_id      = $_POST["form_staff"];
    $post_note          = $_POST["form_note"];

    // トランザクション開始
    Db_Query($db_con, "BEGIN;");

    // 新規登録時
    if ($advance_id == null){

        $sql  = "INSERT INTO \n";
        $sql .= "   t_advance \n";
        $sql .= "( \n";
        $sql .= "   advance_id, \n";            // 前受金ID
        $sql .= "   advance_no, \n";            // 伝票番号
        $sql .= "   pay_day, \n";               // 入金日
        $sql .= "   client_id, \n";             // 得意先ID
        $sql .= "   client_cd1, \n";            // 得意先コード１
        $sql .= "   client_cd2, \n";            // 得意先コード２
        $sql .= "   client_name1, \n";          // 得意先名１
        $sql .= "   client_name2, \n";          // 得意先名２
        $sql .= "   client_cname, \n";          // 得意先名略称
        $sql .= "   claim_div, \n";             // 請求先区分
        $sql .= "   claim_id, \n";              // 請求先ID
        $sql .= "   claim_cd1, \n";             // 請求先コード１
        $sql .= "   claim_cd2, \n";             // 請求先コード２
        $sql .= "   claim_cname, \n";           // 請求先名略称
        $sql .= "   amount, \n";                // 金額
        $sql .= "   bank_id, \n";               // 銀行ID
        $sql .= "   bank_cd, \n";               // 銀行コード
        $sql .= "   bank_name, \n";             // 銀行名
        $sql .= "   b_bank_id, \n";             // 支店ID
        $sql .= "   b_bank_cd, \n";             // 支店コード
        $sql .= "   b_bank_name, \n";           // 支店名
        $sql .= "   account_id, \n";            // 口座ID
        $sql .= "   deposit_kind, \n";          // 預金種目
        $sql .= "   account_no, \n";            // 口座番号
        $sql .= "   staff_id, \n";              // 担当者ID
        $sql .= "   staff_name, \n";            // 担当者名
        $sql .= "   note, \n";                  // 備考
        $sql .= "   input_day, \n";             // 入力日
        $sql .= "   input_staff_id, \n";        // 入力者ID
        $sql .= "   input_staff_name, \n";      // 入力者名
        $sql .= "   fix_day, \n";               // 前受金確定日
        $sql .= "   fix_staff_id, \n";          // 前受金確定者ID
        $sql .= "   fix_staff_name, \n";        // 前受金確定者名
        $sql .= "   shop_id \n";                // ショップID
        $sql .= ") \n";
        $sql .= "VALUES \n";
        $sql .= "( \n";
        $sql .= "   (SELECT COALESCE(MAX(advance_id), 0) + 1 FROM t_advance), \n";
        $sql .= "   '$post_advance_no', \n";
        $sql .= "   '$post_pay_day', \n";
        $sql .= "   $post_client_id, \n";
        $sql .= "   (SELECT client_cd1   FROM t_client WHERE client_id = $post_client_id), \n";
        $sql .= "   (SELECT client_cd2   FROM t_client WHERE client_id = $post_client_id), \n";
        $sql .= "   (SELECT client_name  FROM t_client WHERE client_id = $post_client_id), \n";
        $sql .= "   (SELECT client_name2 FROM t_client WHERE client_id = $post_client_id), \n";
        $sql .= "   (SELECT client_cname FROM t_client WHERE client_id = $post_client_id), \n";
        $sql .= "   '$post_claim_div', \n";
        $ary_col = array("id", "cd1", "cd2", "cname \n");
        foreach ($ary_col as $value){
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_client.client_$value \n";
        $sql .= "       FROM \n";
        $sql .= "           t_claim \n";
        $sql .= "       INNER JOIN t_client ON  t_claim.claim_id = t_client.client_id \n";
        $sql .= "                           AND t_claim.client_id = $post_client_id \n";
        $sql .= "                           AND t_claim.claim_div = '$post_claim_div' \n";
        $sql .= "                           AND t_client.shop_id IN ".Rank_Sql2()." \n";
        $sql .= "   ), \n";
        }
        $sql .= "   $post_amount, \n";
        if ($post_bank_id != null){
        $sql .= "   $post_bank_id, \n";
        $sql .= "   (SELECT bank_cd      FROM t_bank    WHERE bank_id    = $post_bank_id), \n";
        $sql .= "   (SELECT bank_name    FROM t_bank    WHERE bank_id    = $post_bank_id), \n";
        $sql .= "   $post_b_bank_id, \n";
        $sql .= "   (SELECT b_bank_cd    FROM t_b_bank  WHERE b_bank_id  = $post_b_bank_id), \n";
        $sql .= "   (SELECT b_bank_name  FROM t_b_bank  WHERE b_bank_id  = $post_b_bank_id), \n";
        $sql .= "   $post_account_id, \n";
        $sql .= "   (SELECT deposit_kind FROM t_account WHERE account_id = $post_account_id), \n";
        $sql .= "   (SELECT account_no   FROM t_account WHERE account_id = $post_account_id), \n";
        }else{
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        }
        if ($post_staff_id != null){
        $sql .= "   $post_staff_id, \n";
        $sql .= "   (SELECT staff_name   FROM t_staff   WHERE staff_id   = $post_staff_id), \n";
        }else{
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        }
        $sql .= "   '$post_note', \n";
        $sql .= "   NOW(), \n";
        $sql .= "   $staff_id, \n";
        $sql .= "   '".addslashes($staff_name)."', \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   $shop_id \n";
        $sql .= ") \n";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);

        // エラー時
        if ($res === false){
            $err_msg = pg_last_error();         // エラーメッセージ取得
            Db_Query($db_con, "ROLLBACK;");     // ロールバック
            // エラーメッセージに重複が含まれている場合
            if (strstr($err_msg, "t_advance_advance_no_key") == true){
                $duplicate_flg = true;
            }else{
                exit;
            }
        }

    // 伝票変更時
    }else{

        $sql  = "UPDATE \n";
        $sql .= "   t_advance \n";
        $sql .= "SET \n";
        $sql .= "   pay_day         = '$post_pay_day', \n";
        $sql .= "   client_id       = $post_client_id, \n";
        $sql .= "   client_cd1      = (SELECT client_cd1   FROM t_client WHERE client_id = $post_client_id), \n";
        $sql .= "   client_cd2      = (SELECT client_cd2   FROM t_client WHERE client_id = $post_client_id), \n";
        $sql .= "   client_name1    = (SELECT client_name  FROM t_client WHERE client_id = $post_client_id), \n";
        $sql .= "   client_name2    = (SELECT client_name2 FROM t_client WHERE client_id = $post_client_id), \n";
        $sql .= "   client_cname    = (SELECT client_cname FROM t_client WHERE client_id = $post_client_id), \n";
        $sql .= "   claim_div       = '$post_claim_div', \n";
        $ary_col = array("id", "cd1", "cd2", "cname \n");
        foreach ($ary_col as $value){
        $sql .= "   claim_$value    = \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_client.client_$value \n";
        $sql .= "       FROM \n";
        $sql .= "           t_claim \n";
        $sql .= "       INNER JOIN t_client ON  t_claim.claim_id = t_client.client_id \n";
        $sql .= "                           AND t_claim.client_id = $post_client_id \n";
        $sql .= "                           AND t_claim.claim_div = '$post_claim_div' \n";
        $sql .= "                           AND t_client.shop_id IN ".Rank_Sql2()." \n";
        $sql .= "   ), \n";
        }
        $sql .= "   amount          = $post_amount, \n";
        if ($post_bank_id != null){
        $sql .= "   bank_id         = $post_bank_id, \n";
        $sql .= "   bank_cd         = (SELECT bank_cd      FROM t_bank    WHERE bank_id    = $post_bank_id), \n";
        $sql .= "   bank_name       = (SELECT bank_name    FROM t_bank    WHERE bank_id    = $post_bank_id), \n";
        $sql .= "   b_bank_id       = $post_b_bank_id, \n";
        $sql .= "   b_bank_cd       = (SELECT b_bank_cd    FROM t_b_bank  WHERE b_bank_id  = $post_b_bank_id), \n";
        $sql .= "   b_bank_name     = (SELECT b_bank_name  FROM t_b_bank  WHERE b_bank_id  = $post_b_bank_id), \n";
        $sql .= "   account_id      = $post_account_id, \n";
        $sql .= "   deposit_kind    = (SELECT deposit_kind FROM t_account WHERE account_id = $post_account_id), \n";
        $sql .= "   account_no      = (SELECT account_no   FROM t_account WHERE account_id = $post_account_id), \n";
        }else{
        $sql .= "   bank_id         = NULL, \n";
        $sql .= "   bank_cd         = NULL, \n";
        $sql .= "   bank_name       = NULL, \n";
        $sql .= "   b_bank_id       = NULL, \n";
        $sql .= "   b_bank_cd       = NULL, \n";
        $sql .= "   b_bank_name     = NULL, \n";
        $sql .= "   account_id      = NULL, \n";
        $sql .= "   deposit_kind    = NULL, \n";
        $sql .= "   account_no      = NULL, \n";
        }
        if ($post_staff_id != null){
        $sql .= "   staff_id        = $post_staff_id, \n";
        $sql .= "   staff_name      = (SELECT staff_name   FROM t_staff   WHERE staff_id   = $post_staff_id), \n";
        }else{
        $sql .= "   staff_id        = NULL, \n";
        $sql .= "   staff_name      = NULL, \n";
        }
        if ($post_note != null){
        $sql .= "   note            = '$post_note', \n";
        }else{
        $sql .= "   note            = NULL, \n";
        }
        $sql .= "   input_day       = NOW(), \n";
        $sql .= "   input_staff_id  = $staff_id, \n";
        $sql .= "   input_staff_name= '".addslashes($staff_name)."', \n";
        $sql .= "   fix_day         = NULL, \n";
        $sql .= "   fix_staff_id    = NULL, \n";
        $sql .= "   fix_staff_name  = NULL, \n";
        $sql .= "   shop_id         = $shop_id \n";
        $sql .= "WHERE \n";
        $sql .= "   advance_id = $advance_id \n";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);

        if ($res === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

    }

    // 伝票番号重複エラーのない場合
    if ($duplicate_flg != true){

        // トランザクション完結
        Db_Query($db_con, "COMMIT;");

        // 完了画面へページ遷移
        if ($advance_id == null){
            header("Location: ./2-2-413.php?ps=1");
        }else{
            header("Location: ./2-2-413.php?ps=2");
        }

    }

}


/****************************/
// 最新伝票番号取得
/****************************/
// 初期表示時＋GETのIDがない場合（通常時）
// 伝票番号重複時
if (($_POST["post_flg"] != "true" && $advance_id == null) || $duplicate_flg == true){

    // 最新の支払番号取得→１を加算
    $sql  = "SELECT \n";
    $sql .= "   MAX(advance_no) AS max \n";
    $sql .= "FROM \n";
    $sql .= "   t_advance \n";
    $sql .= "WHERE \n";
    $sql .= "   shop_id = $shop_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $advance_data   = pg_fetch_array($res);
    $advance_no_max = $advance_data["max"];
    $advance_no_new = ($advance_no_max != "") ? $advance_no_max + 1 : 1;
    $advance_no_new = str_pad($advance_no_new, 8, "0", STR_PAD_LEFT);

    // フォームにセット
    $form_set["form_advance_no"] = $advance_no_new;
    $form->setConstants($form_set);

}


/****************************/
// 出力メッセージ作成
/****************************/
// 確認ボタン押下＋エラーのない場合
if ($_POST["confirm_flg"] == "true" && $err_flg != true && $duplicate_flg != true){

    // フリーズフラグをtrueに
    $freeze_flg = true;

    // 確認メッセージ作成
    if ($advance_id == null){
        $form->addElement("static", "confirm_msg", "", "<span style=\"font: bold 16px;\">以下の内容で登録しますか？</span><br><br>");
    }else{
        $form->addElement("static", "confirm_msg", "", "<span style=\"font: bold 16px;\">以下の内容で変更しますか？</span><br><br>");
    }

}elseif ($duplicate_flg == true){

    // 重複メッセージ作成
    $form->addElement("text", "err_duplicate");
    $form->setElementError("err_duplicate", "同時に入金を行ったため、伝票番号の付番に失敗しました。<br>もう一度入金を行ってください。");

}


/****************************/
// 動的フォーム作成 戻るボタン
/****************************/
// 戻るボタン
// 確定済伝票の場合
if ($fix_flg == true){
    $form->addElement("button", "back_button", "戻　る", "onClick=\"location.href='".Make_Rtn_Page("advance")."'\"");
}else
// 変更時＋確認画面でない場合
if ($advance_id != null && $_POST["confirm_flg"] != "true"){
    $form->addElement("button", "back_button", "戻　る", "onClick=\"location.href='".Make_Rtn_Page("advance")."'\"");
}
// 変更時＋エラーの場合
if ($advance_id != null && $_POST["confirm_flg"] == "true" && ($err_flg == true || $duplicate_flg == true)){
    $form->addElement("button", "back_button", "戻　る", "onClick=\"location.href='".Make_Rtn_Page("advance")."'\"");
}else
// 確認画面へボタン押下＋エラーのない場合
if ($_POST["confirm_flg"] == "true" && $err_flg != true && $duplicate_flg != true){
    $form->addElement("button", "back_button", "戻　る", "onClick=\"Button_Submit_1('confirm_flg', '#', 'false');\"");
}


/****************************/
// フリーズ設定・出力データ整形
/****************************/
// 前受金確定フラグがtrue、フリーズフラグ（確認）がtrueの場合
if ($fix_flg == true || $freeze_flg == true){

    // フリーズ
    $form->freeze();

    // 確認画面時
    if ($freeze_flg == true){

        // 数値フォームの値をナンバーフォーマット
        $num_format["form_amount"] = number_format($_POST["form_amount"]);
        $form->setConstants($num_format);

    }

}


/****************************/
// 関数
/****************************/
// 確定処理が行われていないかチェック
function Fixed_Check($db_con, $table, $column, $p_id){ 

    $sql  = "SELECT \n";
    $sql .= "   COUNT(*) \n";
    $sql .= "FROM \n";
    $sql .= "   $table \n";
    $sql .= "WHERE \n";
    $sql .= "   $column = $p_id \n";
    $sql .= "AND \n";
    $sql .= "   fix_day IS NULL \n";
    $sql .= ";"; 

    $result = Db_Query($db_con, $sql);
    $row_num = pg_fetch_result($result ,0, 0);

    //該当レコードがある場合
    if($row_num > 0){
        return true;
    //該当レコードがない場合
    }else{  
        return false;
    }

}


/****************************/
// 得意先IDの状態取得
/****************************/
$client_state_print = Get_Client_State($db_con, $client_id);


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
//$page_menu = Create_Menu_f("sale", "4");

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

// エラーをassign
$errors = $form->_errors;
$smarty->assign("errors", $errors);

// その他の変数をassign
$smarty->assign("var", array(
    // 共通
    "html_header"   => "$html_header",
    "page_menu"     => "$page_menu",
    "page_header"   => "$page_header",
    "html_footer"   => "$html_footer",
    // フラグ
    "fix_flg"       => "$fix_flg",
    "freeze_flg"    => "$freeze_flg",
    // その他
    "client_state_print"    => "$client_state_print",
));

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
