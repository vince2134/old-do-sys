<?php
/*
 * 履歴：
 *   日付        B票No.        担当者      内容
 *  -----------------------------------------------------------
 *  2015/05/01                  amano  Dialogue,Button_Submit関数でボタン名が送られない IE11 バグ対応
 * * */
$page_title = "売上伝票備考設定";

// 環境設定ファイル
require_once("ENV_local.php");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

//画像のパス設定
$path_sale_slip     = IMAGE_DIR."sale_slip.png";    //お買上伝票
$path_claim_slip    = IMAGE_DIR."claim_slip.png";   //請求書
$path_deli_slip     = IMAGE_DIR."deli_slip.png";    //納品書
$path_receive_slip  = IMAGE_DIR."receive_slip.png"; //領収書

/****************************/
// デフォルト値
/****************************/
$def_data["preview_radio"]          = "1";
$def_data["bill_send_radio"]        = "1";
$def_data["font_size_select_0"]     = "10";
$def_data["font_size_select_1"]     = "10";
$def_data["font_size_select_2"]     = "8";
$def_data["font_size_select_3"]     = "10";
$def_data["font_size_select_4"]     = "6";
$form->setDefaults($def_data);

// ラジオボタンの世話
if ($_POST["bill_send_radio"] != null){
    $radio_post["commit_freeze"]["bill_send_radio"] = $_POST["bill_send_radio"];
    $form->setConstants($radio_post);
}
/****************************/
// 外部変数取得
/****************************/
$client_id  = $_SESSION["client_id"];

/****************************/
// 部品定義
/****************************/
// コメント1
$freeze = $commit_freeze[] = $form->addElement("text", "s_memo1", "", "size=\"25\" maxLength=\"46\" style=\"font-size:10px;\" $g_form_option");
$freeze->freeze();

// コメント2
$freeze = $commit_freeze[] = $form->addElement("text", "s_memo2", "", "size=\"40\" maxLength=\"46\" style=\"font-size:10px;\" $g_form_option");
$freeze->freeze();

// コメント3
$freeze = $commit_freeze[] = $form->addElement("text", "s_memo3", "", "size=\"25\" maxLength=\"46\" style=\"font-size:10px;\" $g_form_option");
$freeze->freeze();

// コメント4
$freeze = $commit_freeze[] = $form->addElement("text", "s_memo4", "", "size=\"40\" maxLength=\"46\" style=\"font-size:10px;\" $g_form_option");
$freeze->freeze();

// コメント5
$freeze = $commit_freeze[] = $form->addElement("textarea", "s_memo5", "", "rows=\"5\" cols=\"78\" style=\"font-size:10px;\" $g_form_option_area");
$freeze->freeze();

// コメント6
$commit_freeze[] = $form->addElement("textarea", "s_memo6", "", "rows=\"8\" cols=\"70\" style=\"font-size:10px;\" $g_form_option_area");

// コメント7
$commit_freeze[] = $form->addElement("textarea", "s_memo7", "", "rows=\"8\" cols=\"70\" style=\"font-size:10px;\" $g_form_option_area");

// コメント8
$freeze = $commit_freeze[] = $form->addElement("textarea", "s_memo8", "", "rows=\"8\" cols=\"70\" style=\"font-size:10px;\" $g_form_option_area");
$freeze->freeze();

// コメント9
$freeze = $commit_freeze[] = $form->addElement("textarea", "s_memo9", "", "rows=\"8\" cols=\"70\" style=\"font-size:10px;\" $g_form_option_area");
$freeze->freeze();

// パターンセレクトボックス
$select_value = Select_Get($db_con, "pattern");
$form->addElement("select", "pattern_select", "", $select_value, "size=\"10\" style=\"width: 350;\"");

// パターン名
$freeze = $commit_freeze[] = $form->addElement("text", "pattern_name", "", "size=\"34\" maxLength=\"30\" $g_form_option");
$freeze->freeze();

// パターン番号
$freeze = $commit_freeze[] = $form->addElement("text", "pattern_no", "", "size=\"2\" maxLength=\"2\" $g_form_option");
$freeze->freeze();

// 請求書ラジオボタン
$radio = null;
$radio[] = $form->createElement("radio", null, null, "渡す", "1");
$radio[] = $form->createElement("radio", null, null, "渡さない", "2");
$freeze = $commit_freeze[] = $form->addGroup($radio, "bill_send_radio", "");
$freeze->freeze();

//プレビュー種別ラジオボタン
$radio = null;
$radio[] = $form->createElement("radio",null,null,"請求書","1");
$radio[] = $form->createElement("radio",null,null,"領収書","2");
$form->addGroup($radio,"preview_radio","");

// 伝票出力ボタン
$form->addElement("submit", "preview_button", "プレビュー", "onClick=\"javascript:PDF_POST('".FC_DIR."system/2-1-309.php')\"");

// 登録ボタン
$form->addElement("submit", "new_button", "登　録", "onClick=\"javascript:return Dialogue('登録します。','#', this)\" $disabled ");

// 変更ボタン
if($_POST[change_button] == "変　更"){
    $form->addElement("submit", "change_button", "変　更", "onClick=\"javascript:Button_Submit('form_update_flg','#','true', this)\" $disabled $g_button_color");
}else{
    $form->addElement("submit", "change_button", "変　更", "onClick=\"javascript:Button_Submit('form_update_flg','#','true', this)\" $disabled ");
}

// クリアボタン
$form->addElement("button", "clear_button", "クリア", "onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

// OKボタン
$form->addElement("button", "ok_button", "Ｏ　Ｋ", "onClick=javascript:location.href='$_SERVER[PHP_SELF]' $disabled");

// hidden
$form->addElement("hidden", "form_new_flg");       // 新規登録ボタンフラグ
$form->addElement("hidden", "form_update_flg");    // 変更ボタンフラグ
$form->addElement("hidden", "h_pattern_id");       // パターン

// フォントサイズ
for($i=0; $i<5; $i++){
    $data["5"]  = "5";
    $data["6"]  = "6";
    $data["7"]  = "7";
    $data["8"]  = "8";
    $data["9"]  = "9";
    $data["10"] = "10";
    $data["11"] = "11";
    $data["12"] = "12";
    $data["13"] = "13";
    $data["14"] = "14";
    $data["15"] = "15";
    $form->addElement("select", "font_size_select_".$i, "", $data);
}

// 変更ボタンが押された場合
if($_POST["change_button"] == "変　更"){

    if($_POST[pattern_select]!=null){
        $sql  = "SELECT ";
        $sql .= "    s_pattern_name,";  // パターン名
        $sql .= "    bill_send_flg,";   // 請求書
        $sql .= "    s_memo1, ";        // 売上伝票コメント1
        $sql .= "    s_memo2, ";        // 売上伝票コメント2
        $sql .= "    s_memo3, ";        // 売上伝票コメント3
        $sql .= "    s_memo4, ";        // 売上伝票コメント4
        $sql .= "    s_memo5, ";        // 売上伝票コメント5
        $sql .= "    s_fsize1,";        // コメント1フォントサイズ
        $sql .= "    s_fsize2,";        // コメント2フォントサイズ
        $sql .= "    s_fsize3,";        // コメント3フォントサイズ
        $sql .= "    s_fsize4,";        // コメント4フォントサイズ
        $sql .= "    s_fsize5,";        // コメント5フォントサイズ
        $sql .= "    s_memo6, ";        // 売上伝票コメント6
        $sql .= "    s_memo7, ";        // 売上伝票コメント7
        $sql .= "    s_memo8, ";        // 売上伝票コメント8
        $sql .= "    s_memo9, ";        // 売上伝票コメント9
        $sql .= "    s_pattern_no ";    // パターン番号
        $sql .= "FROM ";
        $sql .= "    t_slip_sheet ";
        $sql .= "WHERE ";
        $sql .= "    shop_id = $client_id ";
        $sql .= "AND ";
        $sql .= "    s_pattern_id = $_POST[pattern_select];";

        $result = Db_Query($db_con,$sql);
        // DBの値を配列に保存
        $s_memo = Get_Data($result,2);

        // データをフォームにセットする
        $update_button_data["pattern_name"]        = $s_memo[0][0];
        $update_button_data["pattern_no"]          = $s_memo[0][16];
        $update_button_data["bill_send_radio"]     = ($s_memo[0][1] == "t") ? "1" : "2";
        $update_button_data["s_memo1"]             = $s_memo[0][2];
        $update_button_data["s_memo2"]             = $s_memo[0][3];
        $update_button_data["s_memo3"]             = $s_memo[0][4];
        $update_button_data["s_memo4"]             = $s_memo[0][5];
        $update_button_data["s_memo5"]             = $s_memo[0][6];
        $update_button_data["font_size_select_0"]  = $s_memo[0][7];
        $update_button_data["font_size_select_1"]  = $s_memo[0][8];
        $update_button_data["font_size_select_2"]  = $s_memo[0][9];
        $update_button_data["font_size_select_3"]  = $s_memo[0][10];
        $update_button_data["font_size_select_4"]  = $s_memo[0][11];
        $update_button_data["s_memo6"]             = $s_memo[0][12];
        $update_button_data["s_memo7"]             = $s_memo[0][13];
        $update_button_data["s_memo8"]             = $s_memo[0][14];
        $update_button_data["s_memo9"]             = $s_memo[0][15];
        $update_button_data["form_new_flg"]        = false;
        $update_button_data["h_pattern_id"]        = $_POST["pattern_select"];    // 選択されたパターンをhiddenにセットする
    }else{
        $pattern_err = "変更するパターンを選択してください。";
    }
}
$form->setConstants($update_button_data);

/****************************/
// 登録ボタン押下処理
/****************************/
if (isset($_POST["new_button"])){

    /****************************/
    // エラーチェック
    /****************************/
    // コメント5
    // ●文字数チェック
    $form->registerRule("mb_maxlength", "function", "Mb_Maxlength");

    // コメント6
    // ●文字数チェック
    $form->addRule("s_memo6", "�η箴綸蘇爾糧�考は290文字以内です。", "mb_maxlength", "290");

    // コメント7
    // ●文字数チェック
    $form->addRule("s_memo7", "�Ъ莪�銀行は290文字以内です。", "mb_maxlength", "290");

    $qf_err_flg = ($form->validate() == false) ? true : false;
}

if($_POST["new_button"] == "登　録" && $qf_err_flg === false){
    $s_pattern_name = $_POST["pattern_name"];        // パターン名
    $bill_send_flg  = ($_POST["bill_send_radio"] == "1") ? "t" : "f";     // 請求書
    $s_memo6        = $_POST["s_memo6"];             // コメント6
    $s_memo7        = $_POST["s_memo7"];             // コメント7
    $pattern_id     = $_POST["h_pattern_id"];

    Db_Query($db_con, "BEGIN;");

    $sql  = "UPDATE ";
    $sql .= "    t_slip_sheet ";
    $sql .= "SET ";
    $sql .= "    s_memo6 = '$s_memo6', ";
    $sql .= "    s_memo7 = '$s_memo7', ";
    $sql .= "    s_memo8 = '$s_memo6', ";
    $sql .= "    s_memo9 = '$s_memo6' ";
    $sql .= "WHERE ";
    $sql .= "    shop_id = $client_id ";
    $sql .= "AND ";
    $sql .= "    s_pattern_id = $pattern_id;";

    $result = Db_Query($db_con, $sql);
    if($result == false){
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }
    $commit_flg = true;
    Db_Query($db_con, "COMMIT;");
}

if ($commit_flg == true){
    $commit_freeze_form = $form->addGroup($commit_freeze, "commit_freeze", "");
    $commit_freeze_form->freeze();
}

/****************************/
// HTMLヘッダ
/****************************/
//$html_header = Html_Header($page_title);
$html_header = Html_Header($page_title, "amenity.js", "global.css", "slip.css");

/****************************/
// HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
// メニュー作成
/****************************/
$page_menu = Create_Menu_f("system", "2");

/****************************/
// 画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

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
    "pattern_err"   => "$pattern_err",
    "qf_err_flg"    => "$qf_err_flg",
    "commit_flg"    => "$commit_flg",
    "path_sale_slip"    => "$path_sale_slip",
    "path_claim_slip"   => "$path_claim_slip",
    "path_deli_slip"    => "$path_deli_slip",
    "path_receive_slip" => "$path_receive_slip",
));

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
