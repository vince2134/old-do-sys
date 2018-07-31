<?php
$page_title = "商品一覧";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//HTMLイメージ作成用部品
require_once(PATH."include/html_quick.php");

/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

//GETデータ
$place = $_GET['place'];
$link = $_GET['link'];
$display = $_GET['display'];

//DisplayCode識別判定
if($display == 1){
	$row0 = "'00000001','5','個','5','(0)','6','(0)'";
	$row1 = "'00000002','10','個','5','(0)','46','(0)'";
	$row2 = "'00000003','15','個','5','(0)','36','(0)'";
	$row3 = "'00000004','20','個','5','(0)','26','(0)'";
	$row4 = "'00000005','25','個','5','(0)','16','(0)'";
}else{
	$row0 = "'00000001','商品1'";
	$row1 = "'00000002','商品2'";
	$row2 = "'00000003','商品3'";
	$row3 = "'00000004','商品4'";
	$row4 = "'00000005','商品5'";
}

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
	'row0'    => "$row0",
	'row1'    => "$row1",
	'row2'    => "$row2",
	'row3'    => "$row3",
	'row4'    => "$row4",
));
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
