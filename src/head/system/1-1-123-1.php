<?php
$page_title = "契約マスタ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

/****************************/
//フォーム定義
/****************************/

//変更・一覧
$form->addElement("button","change_button","変更・一覧","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//一括訂正
$form->addElement("button","all_button","一括訂正","onClick=\"javascript:Referer('1-1-119-1.php')\"");
//追加
$button[] = $form->createElement("button","insert","追　加","onClick=\"Open_Dialog('1-1-104-1.php',600,700)\"");
//戻る
$button[] = $form->createElement("button","modoru","戻　る","onClick=\"javascript:history.back()\"");
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
//ディレクトリ
/****************************/
$head_page = HEAD_DIR."system/1-1-104.php";

/****************************/
//メニュー作成
/****************************/
$page_menu = Create_Menu_h('system','1');
/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[all_button]]->toHtml();
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
	'head_page'   => "$head_page",	
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
