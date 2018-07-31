<?php
$page_title = "実績データ";

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

//FC蓄積データ
$button[] = $form->createElement("button","csvf23","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."analysis/2-6-103.php')\"");
$button[] = $form->createElement("button","csvf24","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."analysis/2-6-100.php')\"");
$button[] = $form->createElement("button","csvf25","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."analysis/2-6-101.php')\"");
$button[] = $form->createElement("button","csvf26","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."analysis/2-6-108.php')\"");
$button[] = $form->createElement("button","csvf27","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."analysis/2-6-104.php')\"");
$button[] = $form->createElement("button","csvf28","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."analysis/2-6-110.php')\"");
$button[] = $form->createElement("button","csvf29","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."analysis/2-6-106.php')\"");
$button[] = $form->createElement("button","csvf31","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."analysis/2-6-112.php')\"");
$button[] = $form->createElement("button","csvf32","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."analysis/2-6-114.php')\"");
$button[] = $form->createElement("button","csvf34","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."analysis/2-6-122.php')\"");
$button[] = $form->createElement("button","csvf35","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."analysis/2-6-121.php')\"");
$button[] = $form->createElement("button","csvf36","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."analysis/2-6-131.php')\"");
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
$page_menu = Create_Menu_f('analysis','2');

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
