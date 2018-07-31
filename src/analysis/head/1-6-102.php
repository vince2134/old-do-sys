<?php
$page_title = "FC別商品別売上推移";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB接続
$db_con = Db_Connect();

//HTMLイメージ作成用部品
//require_once(PATH."include/html_quick.php");

//select作成用部品
//require_once(PATH."include/select_part.php");

/****************************/
// フォームパーツ定義
/****************************/
// 出力形式
$radio12[] =& $form->createElement("radio", null, null, "画面", "1");
$radio12[] =& $form->createElement("radio", null, null, "CSV", "2");
$form->addGroup($radio12, "f_r_output2", "");

// 出力範囲
$radio28[] =& $form->createElement("radio", null, null, "請求ベース", "1");
$radio28[] =& $form->createElement("radio", null, null, "売上ベース", "2");
$form->addGroup($radio28, "f_radio12", "");

// 取引年月
$text9_1[] =& $form->createElement("text", "y_start", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText15(this.form,1)\" $g_form_option");
$text9_1[] =& $form->createElement("static", "", "", "-");
$text9_1[] =& $form->createElement("text", "m_start", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText16(this.form,1)\" $g_form_option");
$text9_1[] =& $form->createElement("static", "", "", "〜");
$text9_1[] =& $form->createElement("text", "y_end", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText17(this.form,1)\" $g_form_option");
$text9_1[] =& $form->createElement("static", "", "", "-");
$text9_1[] =& $form->createElement("text", "m_end", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" $g_form_option");
$form->addGroup( $text9_1, "f_date_d1", "");

// 出力内容
$radio67[] =& $form->createElement("radio", null, null, "商品別", "1");
$radio67[] =& $form->createElement("radio", null, null, "Ｍ区分別", "2");
$radio67[] =& $form->createElement("radio", null, null, "製品区分別", "3");
$form->addGroup($radio67, "f_radio67", "");

// ショップコード
$text1[] =& $form->createElement("text", "f_text6", "", "size=\"7\" maxLength=\"6\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText1(this.form,1)\" $g_form_option");
$text1[] =& $form->createElement("static", "", "", "-");
$text1[] =& $form->createElement("text", "f_text4", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" $g_form_option");
$form->addGroup( $text1, "f_code_a1", "");

// ショップ名
$form->addElement("text", "f_text15", "", "size=\"34\" maxLength=\"15\" $g_form_option");

// 顧客区分
$select_value = Select_Get($db_con, "rank");
$form->addElement("select", "form_rank_1", "", $select_value, $g_form_option_select);

// 商品コード
$form->addElement("text", "f_text8", "", "size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option");

// 商品名
$form->addElement("text", "f_text30", "", "size=\"34\" maxLength=\"30\" $g_form_option");

// Ｍ区分
$select_value = Select_Get($db_con, "g_goods");
$form->addElement("select", "form_g_goods_1", "", $select_value, $g_form_option_select);

// 製品区分
$select_value = Select_Get($db_con, "product");
$form->addElement("select", "form_product_1", "", $select_value, $g_form_option_select);

// 出力項目
$check3[] =& $form->createElement("checkbox", null, null, "売上数", "1");
$check3[] =& $form->createElement("checkbox", null, null, "売上金額", "2");
$check3[] =& $form->createElement("checkbox", null, null, "粗利益額", "3");
$check3[] =& $form->createElement("checkbox", null, null, "粗利率", "4");
$form->addGroup( $check3, "f_check3", "");

// 表示ボタン
$form->addElement("submit", "hyouji", "表　示");

// クリアボタン
$form->addElement("button", "kuria", "クリア", "onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");


$def_fdata = array(
    "f_r_output2"   => "1",
    "f_radio12"     => "1",
    "f_radio67"     => "1",
    "f_check3"      => "1"
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
$page_menu = Create_Menu_h('analysis','1');

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
