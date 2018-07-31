<?php
$page_title = "支払変更";

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
// 支払日
$text3_1[] =& $form->createElement("text", "y_input", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText3(this.form,1)\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$text3_1[] =& $form->createElement("static", "", "", "-");
$text3_1[] =& $form->createElement("text", "m_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText4(this.form,1)\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$text3_1[] =& $form->createElement("static", "", "", "-");
$text3_1[] =& $form->createElement("text", "d_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$form->addGroup($text3_1, "f_date_a1", "");

// 取引区分
$select_value = Select_Get($db_con, "trade_payout");
$form->addElement("select", "trade_payout_1", "", $select_value, $g_form_option_select);

// 銀行
$select_value = Select_Get($db_con, "bank");
$form->addElement("select", "form_bank_1", "", $select_value, $g_form_option_select);

// 仕入先
$form->addElement("text", "f_layer1", "", "size=\"7\" maxLength=\"6\" value=\"\" style=\"$g_form_style\" onKeyUp=\"javascript:display(this,'layer1')\" $g_form_option");
$form->addElement("text", "t_layer1", "", "size=\"34\" value=\"\" style=\"color : #000000; border : #ffffff 1px solid; background-color: #ffffff;\" readonly");

// 支払金額
$form->addElement("text", "f_text9", "", "class=\"money\" size=\"11\" maxLength=\"9\" style=\"text-align: right; $g_form_style\" $g_form_option");

// 手数料
$form->addElement("text", "f_text9", "", "class=\"money\" size=\"11\" maxLength=\"9\" style=\"text-align: right; $g_form_style\" $g_form_option");


// 手形期日
$text3_2[] =& $form->createElement("text", "y_input", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText3(this.form,2)\" onFocus=\"onForm2(this,this.form,2)\" onBlur=\"blurForm(this)\"");
$text3_2[] =& $form->createElement("static", "", "", "-");
$text3_2[] =& $form->createElement("text", "m_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText4(this.form,2)\" onFocus=\"onForm2(this,this.form,2)\" onBlur=\"blurForm(this)\"");
$text3_2[] =& $form->createElement("static", "", "", "-");
$text3_2[] =& $form->createElement("text", "d_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onFocus=\"onForm2(this,this.form,2)\" onBlur=\"blurForm(this)\"");
$form->addGroup($text3_2,"f_date_a2","");

// 手形券面番号
$form->addElement("text", "f_text8", "", "size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option");

// 備考
$form->addElement("text", "f_text20", "", "size=\"34\" maxLength=\"20\" $g_form_option");

// 変更ボタン
$form->addElement("button", "f_change4", "変　更", "onClick=\"javascript:Dialogue2('変更します。','".FC_DIR."buy/2-3-303.php')\"");

// 戻るボタン
$form->addElement("button", "modoru", "戻　る", "onClick=\"javascript:history.back()\"");

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
$page_menu = Create_Menu_f('buy','3');

/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);





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
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
