<?php
$page_title = "売上伝票";

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
/*
//作　成
$form->addElement("button","form_make_button","作　成","onClick=\"javascript:Referer('2-2-201.php')\"");
//修　正
$form->addElement("button","form_revision_button","修　正","onClick=\"javascript:Referer('2-2-202.php')\"");
//発　行
$form->addElement("button","form_public_button","発　行","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
*/

/****************************/
// フォームパーツ定義
/****************************/
// 伝票番号
$form->addElement("text", "f_text8", "", "size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option");

// 表示ボタン
$form->addElement("submit", "hyouji", "表　示");

// 売上伝票発行ボタン
$form->addElement("submit", "uriage", "売上伝票発行", "onClick=\"javascript:window.open('".FC_DIR."sale/2-2-205.php','_blank','')\"");

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
$page_menu = Create_Menu_f('sale','2');

/****************************/
//画面ヘッダー作成
/****************************/
/*
$page_title .= "　　　".$form->_elements[$form->_elementIndex[form_make_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[form_revision_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[form_public_button]]->toHtml();
*/
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
