<?php
$page_title = "巡回予定カレンダー(週)";

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
//フォーム定義
/****************************/
//巡回予定表
$form->addElement("button","form_patrol_button","巡回予定表","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//単月変更
$form->addElement("button","form_single_month_change_button","一時変更","onClick=\"javascript:Referer('2-2-102-2.php')\"");
//マスタ変更
$form->addElement("button","form_master_change_button","永続変更","onClick=\"javascript:Referer('2-2-102-3.php')\"");

$def_fdata = array(
    "form_output"     => "1",
);
$form->setDefaults($def_fdata);

//予定年月日
$text3_1[] =& $form->createElement("text","y_input","テキストフォーム",'size="4" maxLength="4" value="" onkeyup="changeText3(this.form,1)" onFocus="onForm2(this,this.form,1)" onBlur="blurForm(this)"');
$text3_1[] =& $form->createElement("static","","","-");
$text3_1[] =& $form->createElement("text","m_input","テキストフォーム",'size="2" maxLength="2" value="" onkeyup="changeText4(this.form,1)" onFocus="onForm2(this,this.form,1)" onBlur="blurForm(this)"');
$text3_1[] =& $form->createElement("static","","","-");
$text3_1[] =& $form->createElement("text","d_input","テキストフォーム",'size="2" maxLength="2" value="" onFocus="onForm2(this,this.form,1)" onBlur="blurForm(this)"');
$form->addGroup( $text3_1,"f_date_a1","f_date_a1");

//出力形式
$radio1[] =& $form->createElement( "radio",NULL,NULL, "画面","1");
$radio1[] =& $form->createElement( "radio",NULL,NULL, "帳票","2");
$form->addGroup($radio1, "form_output", "出力形式");

//部署
$select_value = Select_Get($db_con,'part');
$form->addElement('select', 'form_part_1', 'セレクトボックス', $select_value,$g_form_option_select);


//表示・クリアボタン
$button[] = $form->createElement("submit","hyouji","表　示","onClick=\"javascript:window.open('".FC_DIR."sale/2-2-115-2.php','_blank','')\"");
$button[] = $form->createElement("button","kuria","クリア","onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");
//日付切替ボタン
$button[] = $form->createElement("submit","next3","翌週　>>");
$button[] = $form->createElement("submit","back3","<<　先週");
$button[] = $form->createElement("submit","next4","翌日　>");
$button[] = $form->createElement("submit","back4","<　前日");
$form->addGroup($button, "button", "");


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
$page_title .= "　".$form->_elements[$form->_elementIndex[form_single_month_change_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[form_master_change_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[form_patrol_button]]->toHtml();
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
