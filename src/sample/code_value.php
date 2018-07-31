<?php
$page_title = "コード・値";

//環境設定ファイル
require_once("ENV_local1.php");


//require_once(PATH."function/test_value.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");


//HTMLイメージ作成用部品
require_once(PATH."include/html_quick1.php");

require_once(PATH."function/db.fnc");
$db_con = Db_Connect(amenity);
print $db_con;

$code_value .= Code_Value("t_ware",$db_con,"WHERE shop_gid = '1'");
$code_value .= Code_Value("t_part",$db_con,"WHERE shop_gid = '1'");
$code_value .= Code_Value("t_g_goods",$db_con,"WHERE shop_gid = '1'");
$code_value .= Code_Value("t_btype",$db_con,"WHERE shop_gid = '1'");

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
$page_menu = Create_Menu_h('buy','0');

/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

/****************************/
//ページ作成
/****************************/

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
	'data'   => "$data",
	'code_value1'   => "$code_value",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
