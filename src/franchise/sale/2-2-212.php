<?php
$page_title = "商品預け数一覧";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);

//HTMLイメージ作成用部品
//require_once(PATH."include/html_quick.php");

//select作成用部品
//require_once(PATH."include/select_part.php");

/****************************/
// フォームパーツ定義
/****************************/
// 出力形式
$radio5[] =& $form->createElement("radio", null, null, "画面", "1");
$radio5[] =& $form->createElement("radio", null, null, "帳票", "2");
$form->addGroup($radio5, "f_r_output", "");

// 商品コード
$form->addElement("text", "f_text8", "", "size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option");

// 商品名
$form->addElement("text", "f_text30", "", "size=\"34\" maxLength=\"30\" $g_form_option");

// 得意先コード
$text1[] =& $form->createElement("text", "f_text6", "", "size=\"7\" maxLength=\"6\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText1(this.form,1)\" $g_form_option");
$text1[] =& $form->createElement("static", "", "", "-");
$text1[] =& $form->createElement("text", "f_text4", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" $g_form_option");
$form->addGroup($text1, "f_code_a1", "");

// 得意先名
$form->addElement("text", "f_text15", "", "size=\"34\" maxLength=\"15\" $g_form_option");

// 表示ボタン
$form->addElement("submit", "hyouji23", "表　示", "onClick=\"javascript:window.open('".FC_DIR."sale/2-2-213.php','_blank','')\"");

// クリアボタン
$form->addElement("button", "kuria", "クリア", "onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");


$def_fdata = array(
    "f_r_output"    => "1"
);

$form->setDefaults($def_fdata);

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
$page_menu = Create_Menu_f('sale','2');

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
