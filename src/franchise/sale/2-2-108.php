<?php
$page_title = "予定データ一括訂正";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);

/****************************/
// フォームパーツ定義
/****************************/
// 【現予定】配送日
$text4_1[] =& $form->createElement("text", "y_start", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText5(this.form,1)\" $g_form_option");
$text4_1[] =& $form->createElement("static", "", "", "-");
$text4_1[] =& $form->createElement("text", "m_start", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText6(this.form,1)\" $g_form_option");
$text4_1[] =& $form->createElement("static", "", "", "-");
$text4_1[] =& $form->createElement("text", "d_start", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText7(this.form,1)\" $g_form_option");
$text4_1[] =& $form->createElement("static", "", "", "　〜　");
$text4_1[] =& $form->createElement("text", "y_end", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText8(this.form,1)\" $g_form_option");
$text4_1[] =& $form->createElement("static", "", "", "-");
$text4_1[] =& $form->createElement("text", "m_end", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText9(this.form,1)\" $g_form_option");
$text4_1[] =& $form->createElement("static", "", "", "-");
$text4_1[] =& $form->createElement("text", "d_end", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onFocus=\"onForm(this)\" $g_form_option");
$form->addGroup( $text4_1, "f_date_b1", "");

// 【現予定】巡回担当者
$select_value = Select_Get($db_con, "staff");
$form->addElement("select", "form_staff_2", "", $select_value, $g_form_option_select);

// 【現予定】表示ボタン
$form->addElement("submit", "hyouji", "表　示");

// 【現予定】クリアボタン
$form->addElement("button", "kuria", "クリア", "onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");

// 【訂正項目】配送日
$text3_1[] =& $form->createElement("text", "y_input", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText3(this.form,1)\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$text3_1[] =& $form->createElement("static", "", "", "-");
$text3_1[] =& $form->createElement("text", "m_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText4(this.form,1)\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$text3_1[] =& $form->createElement("static", "", "", "-");
$text3_1[] =& $form->createElement("text", "d_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$form->addGroup($text3_1, "f_date_a1", "");

// 【訂正項目】巡回担当者
$select_value = Select_Get($db_con, "staff");
$form->addElement("select", "form_staff_2", "", $select_value, $g_form_option_select);

// 【訂正項目】訂正理由
$form->addElement("text", "f_text30", "", "size=\"34\" maxLength=\"30\" $g_form_option");

// 【訂正項目】一括訂正ボタン
$form->addElement("button", "collective", "一括設定", "onClick=\"javascript:Dialogue2('一括設定します。','#')\"");

// 【訂正項目】クリアボタン
$form->addElement("button", "kuria", "クリア", "onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");

// 一括訂正ALL
$check13[] =& $form->createElement("checkbox", "allcheck13", "", "一括訂正", "onClick=\"javascript:Allcheck(13)\"");
$form->addGroup($check13, "allcheck13", "");

// 一括訂正
$check13_2[] =& $form->createElement("checkbox", "check", "", "");
$form->addGroup($check13_2, "check13", "");

// 一括訂正へボタン
$form->addElement("button", "ikkatsu_teisei_he", "一括訂正画面へ", " onClick=\"javascript:location.href='2-2-108-2.php'\"");

//得意先コード
$form->addElement(
    "text","form_client_cd1","",
    "size=\"7\" maxLength=\"6\"" 
);
$form->addElement(
    "text","form_client_cd2","",
    "size=\"5\" maxLength=\"4\"" 
);

//得意先名
$form->addElement(
    "text","form_client_name","",
    "size=\"34\" maxLength=\"25\"" 
);

/****************************/
//デモデータ
/****************************/
$demo_data = array(
        array("00000001", "2006-6-22","000001-0000","株式会社アポロ21世紀","伊藤一弘","横浜西口コース"),
        array("00000002", "2006-6-23","000001-0002","株式会社アポロ21世紀　楢原SS","アメニティ西東京","戸塚コース"),
        array("00000003", "2006-6-24","000001-0003","株式会社アポロ21世紀　松木SS","アメニティ西東京","マレーシアコース"),
        array("00000004", "2006-6-25","000001-0004","株式会社アポロ21世紀　立川南SS","アメニティ西東京","フルコース"),
        array("00000005", "2006-6-26","000001-0005","株式会社アポロ21世紀　旭が丘SS","アメニティ西東京","月例コース"),
        array("00000006", "2006-6-27","000001-0006","株式会社アポロ21世紀　さくら小金井SS","アメニティ西東京","横浜東コース"),
        array("00000007", "2006-6-28","000001-0007","株式会社アポロ21世紀　府中緑町SS","アメニティ西東京","横浜北口コース"),
        array("00000008", "2006-6-29","000001-0008","株式会社アポロ21世紀　砂川東SS","佐久間　茂","横浜南口コース"),
        array("00000009", "2006-6-30","000001-0009","株式会社アポロ21世紀　玉川上水ＳＳ","アメニティ西東京","横浜中央口コース"),
        array("00000010", "2006-7-1","000001-0010", "株式会社アポロ21世紀　プリテール八王子ＳＳ","アメニティ西東京","横浜コース"),
);


/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成
/****************************/
$page_menu = Create_Menu_f('sale','1');

/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);


/****************************/
//ページ作成
/****************************/
//仮の件数
$total_count = 100;

//表示範囲指定
$range = "100";

//ページ数を取得
$page_count = $_POST["f_page1"];

$html_page = Html_Page($total_count,$page_count,1,$range);
$html_page2 = Html_Page($total_count,$page_count,2,$range);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'html_page'     => "$html_page",
	'html_page2'    => "$html_page2",
));

$smarty->assign("demo_data",$demo_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
