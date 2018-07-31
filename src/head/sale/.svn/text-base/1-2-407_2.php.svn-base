<?php
$page_title = "入金入力";

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
// 入金データ取込
    /* 未作成 */

// 取込ボタン
$form->addElement("button", "busy", "取　込", "onClick=\"javascript:Dialogue2('取込ます。','#')\"");

// 銀行
$select_value = Select_Get($db_con, "bank");
$form->addElement("select", "form_bank_1", "銀行", $select_value, $g_form_option_select);

// 一括設定ボタン
$form->addElement("button", "collective", "一括設定", "onClick=\"javascript:Dialogue2('一括設定します。','#')\"");

// 入金日
$ary_element[0] = array($text3_1, $text3_3, $text3_5, $text3_7, $text3_9);
$ary_element[1] = array("1", "3", "5", "7" ,"9");
for($x=0; $x<count($ary_element[0]); $x++){
$ary_element[0][$x][] =& $form->createElement("text", "y_input", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText3(this.form,".$ary_element[1][$x].")\" onFocus=\"onForm2(this,this.form,".$ary_element[1][$x].")\" onBlur=\"blurForm(this)\"");
$ary_element[0][$x][] =& $form->createElement("static", "", "", "-");
$ary_element[0][$x][] =& $form->createElement("text", "m_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText4(this.form,".$ary_element[1][$x].")\" onFocus=\"onForm2(this,this.form,".$ary_element[1][$x].")\" onBlur=\"blurForm(this)\"");
$ary_element[0][$x][] =& $form->createElement("static", "", "", "-");
$ary_element[0][$x][] =& $form->createElement("text", "d_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onFocus=\"onForm2(this,this.form,".$ary_element[1][$x].")\" onBlur=\"blurForm(this)\"");
$form->addGroup($ary_element[0][$x], "f_date_a".$ary_element[1][$x]."", "");
}

// 取引区分
$select_value = Select_Get($db_con, "trade_payin");
for ($x=1; $x<=5; $x++){
$form->addElement("select", "trade_payin_".$x, "", $select_value, $g_form_option_select);
}

// 銀行
$select_value = Select_Get($db_con, "bank");
for ($x=1; $x<=5; $x++){
$form->addElement("select", "form_bank_".$x, "", $select_value, $g_form_option_select);
}

// 請求先
$ary_element[0] = array($text36_1, $text36_2, $text36_3, $text36_4, $text36_5);
$ary_element[1] = array("1", "2", "3", "4" ,"5");
for($x=0; $x<count($ary_element[0]); $x++){
$ary_element[0][$x][] =& $form->createElement("text", "code1", "", "size=\"7\" maxLength=\"6\" value=\"\" style=\"$g_form_style\" onKeyUp=\"javascript:display(this,'claim')\" $g_form_option");
$ary_element[0][$x][] =& $form->createElement("static", "", "", "-");
$ary_element[0][$x][] =& $form->createElement("text", "code2", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onKeyUp=\"javascript:display(this,'claim')\" $g_form_option");
$form->addGroup( $ary_element[0][$x], "f_claim".$ary_element[1][$x], "");

$form->addElement("text", "t_claim".$ary_element[1][$x], "", "size=\"34\" value=\"\" style=\"color : #000000; border : #ffffff 1px solid; background-color: #ffffff;\" readonly");
}


// 入金額
$form->addElement("text", "f_text9", "", "class=\"money\" size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"");

// 手数料
$form->addElement("text", "f_text9", "", "class=\"money\" size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"");

// 手形期日
$ary_element[0] = array($text3_2, $text3_4, $text3_6, $text3_8, $text3_10);
$ary_element[1] = array("2", "4", "6", "8" ,"10");
for($x=0; $x<count($ary_element[0]); $x++){
$ary_element[0][$x][] =& $form->createElement("text", "y_input", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText3(this.form,".$ary_element[1][$x].")\" onFocus=\"onForm2(this,this.form,".$ary_element[1][$x].")\" onBlur=\"blurForm(this)\"");
$ary_element[0][$x][] =& $form->createElement("static", "", "", "-");
$ary_element[0][$x][] =& $form->createElement("text", "m_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText4(this.form,".$ary_element[1][$x].")\" onFocus=\"onForm2(this,this.form,".$ary_element[1][$x].")\" onBlur=\"blurForm(this)\"");
$ary_element[0][$x][] =& $form->createElement("static", "", "", "-");
$ary_element[0][$x][] =& $form->createElement("text", "d_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onFocus=\"onForm2(this,this.form,".$ary_element[1][$x].")\" onBlur=\"blurForm(this)\"");
$form->addGroup($ary_element[0][$x], "f_date_a".$ary_element[1][$x]."", "");
}

// 手形券面番号
$form->addElement("text", "f_text8", "", "size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option\"");

// 備考
$form->addElement("text", "f_text20", "", "size=\"34\" maxLength=\"20\" style=\"$g_form_style\" $g_form_option\""); 

// 入金ボタン
$form->addElement("button", "money2", "入　金", "onClick=\"javascript:Dialogue2('入金します。','#')\"");

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
$page_menu = Create_Menu_h('sale','4');
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
