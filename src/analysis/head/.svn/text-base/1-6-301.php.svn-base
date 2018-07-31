<?php
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/09/10                  kajioka-h   仕入先マスタへの遷移ボタンをなくす
 *
 */


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
"csvh8"  => "業種マスタ",
"csvh20" => "業態マスタ",
"csvh21" => "施設マスタ",
"csvh1"  => "サービスマスタ",
"csvh17" => "構成品マスタ",

"csvh5"  => "スタッフマスタ",
"csvh11" => "Ｍ区分マスタ",
"csvh10" => "管理区分マスタ",
"csvh4"  => "商品分類マスタ",
"csvh15" => "商品マスタ",

"csvh6"  => "部署マスタ",
"csvh7"  => "倉庫マスタ",
"csvh12" => "地区マスタ",
"csvh9"  => "銀行マスタ",
"csvh16" => "製造品マスタ",

"csvh2"  => "FC・取引先マスタ",
"csvh19" => "ＦＣ区分マスタ",
"csvh3"  => "得意先マスタ",
//"csvh13" => "仕入先マスタ",
"csvh14" => "直送先マスタ",
"csvh18" => "運送業者マスタ",
);

//本部マスタ
$button[] = $form->createElement("button","csvh1","出力画面へ", "onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-231.php')\"");
$button[] = $form->createElement("button","csvh2","出力画面へ", "onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-101.php')\"");
$button[] = $form->createElement("button","csvh3","出力画面へ", "onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-113.php')\"");
$button[] = $form->createElement("button","csvh4","出力画面へ", "onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-235.php')\"");
$button[] = $form->createElement("button","csvh5","出力画面へ", "onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-107.php')\"");
$button[] = $form->createElement("button","csvh6","出力画面へ", "onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-201.php')\"");
$button[] = $form->createElement("button","csvh7","出力画面へ", "onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-203.php')\"");
$button[] = $form->createElement("button","csvh8","出力画面へ", "onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-205.php')\"");
$button[] = $form->createElement("button","csvh9","出力画面へ", "onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-207.php')\"");
$button[] = $form->createElement("button","csvh10","出力画面へ","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-209.php')\"");
$button[] = $form->createElement("button","csvh11","出力画面へ","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-211.php')\"");
$button[] = $form->createElement("button","csvh12","出力画面へ","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-213.php')\"");
//$button[] = $form->createElement("button","csvh13","出力画面へ","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-215.php')\"");
$button[] = $form->createElement("button","csvh14","出力画面へ","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-218.php')\"");
$button[] = $form->createElement("button","csvh15","出力画面へ","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-220.php')\"");
$button[] = $form->createElement("button","csvh16","出力画面へ","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-223.php')\"");
$button[] = $form->createElement("button","csvh17","出力画面へ","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-229.php')\"");
$button[] = $form->createElement("button","csvh18","出力画面へ","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-225.php')\"");
$button[] = $form->createElement("button","csvh19","出力画面へ","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-227.php')\"");
$button[] = $form->createElement("button","csvh20","出力画面へ","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-234.php')\"");
$button[] = $form->createElement("button","csvh21","出力画面へ","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-233.php')\"");

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
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
