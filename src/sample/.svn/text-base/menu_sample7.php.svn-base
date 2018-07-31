<?php
$page_title = "メニューサンプル";

// パスの定義
define(PATH , "../../");
require_once(PATH."config/global.php");
require_once(PATH."config/config.php");
require_once(PATH."config/define.php");
require_once(PATH."function/session.fnc");
require_once(PATH."function/function.fnc");
require_once(PATH."function/func_qf_rule.inc");
require_once(PATH."function/html.fnc");
require_once(PATH."function/menu_ver6.fnc");
require_once(PATH."function/db.fnc");
// Smarty+QuickForm
require_once("Smarty/Smarty.class.php");
require_once("HTML/QuickForm.php");
require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';
$smarty = new Smarty();   // Smartyオブジェクトを生成
$smarty->template_dir = "templates";
$smarty->compile_dir = "templates_c";

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB接続
$db_con = Db_Connect();

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
