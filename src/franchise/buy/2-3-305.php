<?php
$page_title = "支払入力";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

/****************************/
// フォームパーツ作成
/****************************/
$form->addElement("button", "ok_button", "Ｏ　Ｋ", "onClick=\"location.href='".Make_Rtn_Page("payout")."' \"");

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
$page_menu = Create_Menu_h('buy','3');

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
