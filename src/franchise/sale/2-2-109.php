<?php
$page_title = "配送コース順確認";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

//HTMLイメージ作成用部品
//require_once(PATH."include/html_quick.php");

//select作成用部品
//require_once(PATH."include/select_part.php");

/****************************/
// フォームパーツ定義
/****************************/
// 配送日
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
$form->addGroup($text4_1, "f_date_b1", "");

// 巡回担当者コード
$text44_1[] =& $form->createElement("text", "f_text4_1", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText18(this.form,1)\" $g_form_option");
$text44_1[] =& $form->createElement("static", "", "", "　〜　");
$text44_1[] =& $form->createElement("text", "f_text4_2", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" $g_form_option");
$form->addGroup( $text44_1, "f_code_g1", "");

// 巡回担当者コード（カンマ区切り）
$form->addElement("text", "f_textx", "", "size=\"34\" style=\"$g_form_style\" $g_form_option");

// 除外巡回担当者コード（カンマ区切り）
$form->addElement("text", "f_textx", "", "size=\"34\" style=\"$g_form_style\" $g_form_option");

// 表示ボタン
$form->addElement("submit", "hyouji", "表　示");

// クリアボタン
$form->addElement("button", "kuria", "クリア", "onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");

// 印刷ALL
$check14[] =& $form->createElement("checkbox", "allcheck14", "", "印刷", "onClick=\"javascript:Allcheck(14)\"");
$form->addGroup($check14, "allcheck14", "");

// 印刷
$check14_2[] =& $form->createElement("checkbox", "check", "", "");
$form->addGroup($check14_2, "check14", "");

// 配送コース順確認表印刷ボタン
$form->addElement("submit", "delivery", "配送コース順確認表印刷", "onClick=\"javascript:window.open('".FC_DIR."sale/2-2-110.php','_blank','')\"");

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
$range = "20";

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

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
