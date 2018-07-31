<?php
$page_title = "契約マスタ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

/****************************/
//フォーム定義
/****************************/

//デフォルト値の設定
$def_date = array(
    "f_r_output2"     => "1",
	"f_radio34"     => "1",
);
$form->setDefaults($def_date);

//出力形式
$radio = "";
$radio[] =& $form->createElement( "radio",NULL,NULL, "画面","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
$form->addGroup($radio, "f_r_output2", "出力形式");
//状態
$radio = "";
$radio[] =& $form->createElement( "radio",NULL,NULL, "取引中","1",$g_form_option_select);
$radio[] =& $form->createElement( "radio",NULL,NULL, "取引休止中","2",$g_form_option_select);
$radio[] =& $form->createElement( "radio",NULL,NULL, "全て","3",$g_form_option_select);
$form->addGroup($radio, "f_radio34", "状態");

//FC/得意先コード
$text23[] =& $form->createElement("text","code1","テキストフォーム","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText_shop(this.form)\" ".$g_form_option."\"");
$text23[] =& $form->createElement("static","","","-");
$text23[] =& $form->createElement("text","code2","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" ".$g_form_option."\"");
$text23[] =& $form->createElement("text","name","テキストフォーム",'size="34" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');
$form->addGroup( $text23, "f_shop", "f_shop");
//FC/得意先名
$form->addElement("text","f_text15","テキストフォーム","size=\"34\" maxLength=\"15\" ".$g_form_option."\"");

//FC・取引先区分
$select_value = Select_Get($db_con,'rank');
$form->addElement('select', 'form_rank_1', 'セレクトボックス', $select_value,$g_form_option_select);
//地区
$select_value = Select_Get($db_con,'area');
$form->addElement('select', 'form_area_1', 'セレクトボックス', $select_value,$g_form_option_select);

//表示
$button[] = $form->createElement("submit","hyouji","表　示");
//クリア
$button[] = $form->createElement("button","kuria","クリア","onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");
//変更・一覧
//$form->addElement("button","change_button","変更・一覧","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","change_button","変更・一覧",$g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//一括訂正
//$form->addElement("button","all_button","一括訂正","onClick=\"javascript:Referer('1-1-119.php')\"");
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
$page_menu = Create_Menu_h('system','1');
/****************************/
//画面ヘッダー作成
/****************************/
$total_count = 7;
$page_title .= "(全".$total_count."件)";
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
//$page_title .= "　".$form->_elements[$form->_elementIndex[all_button]]->toHtml();
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
	'total_count'    => "$total_count",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
