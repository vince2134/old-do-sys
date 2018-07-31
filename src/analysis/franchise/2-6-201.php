<?php
$page_title = "マスタデータ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);


//表示順を変更する場合は、この配列の順番を変更します。
$page_list = array(
"csvf1"  => "支店マスタ",
"csvf2"  => "部署マスタ",
"csvf3"  => "倉庫マスタ",
"csvf4"  => "地区マスタ",
"csvf5"  => "銀行マスタ",
"csvf6"  => "グループマスタ",
"csvf7"  => "得意先マスタ",
"csvf8"  => "契約マスタ",
"csvf9"  => "仕入先マスタ",
"csvf10" => "直送先マスタ",
"csvf11" => "運送業者マスタ",
"csvf12" => "スタッフマスタ",
"csvf13" => "Ｍ区分マスタ",
"csvf14" => "管理区分マスタ",
"csvf15" => "商品分類マスタ",
"csvf16" => "商品マスタ",
"csvf17" => "業種マスタ",
"csvf18" => "業態マスタ",
"csvf19" => "施設マスタ",
"csvf20" => "サービスマスタ",
"csvf21" => "構成品マスタ",

);


//FCマスタ
$button[] = $form->createElement("button","csvf1","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-200.php')\"");
$button[] = $form->createElement("button","csvf2","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-201.php')\"");
$button[] = $form->createElement("button","csvf3","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-203.php')\"");
$button[] = $form->createElement("button","csvf4","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-213.php')\"");
$button[] = $form->createElement("button","csvf5","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-207.php')\"");
$button[] = $form->createElement("button","csvf6","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-113.php')\"");
$button[] = $form->createElement("button","csvf7","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-101.php')\"");
$button[] = $form->createElement("button","csvf8","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-111.php')\"");
$button[] = $form->createElement("button","csvf9","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-215.php')\"");
$button[] = $form->createElement("button","csvf10","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-218.php')\"");
$button[] = $form->createElement("button","csvf11","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-225.php')\"");
$button[] = $form->createElement("button","csvf12","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-107.php')\"");
$button[] = $form->createElement("button","csvf13","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-211.php')\"");
$button[] = $form->createElement("button","csvf14","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-209.php')\"");
$button[] = $form->createElement("button","csvf15","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-241.php')\"");
$button[] = $form->createElement("button","csvf16","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-220.php')\"");
$button[] = $form->createElement("button","csvf17","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-231.php')\"");
$button[] = $form->createElement("button","csvf18","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-234.php')\"");
$button[] = $form->createElement("button","csvf19","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-233.php')\"");
$button[] = $form->createElement("button","csvf20","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-232.php')\"");
$button[] = $form->createElement("button","csvf21","出力画面へ","onClick=\"javascript:location.href('".FC_DIR."system/2-1-229.php')\"");
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

//一覧リスト
$smarty->assign('page_list',$page_list);

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
