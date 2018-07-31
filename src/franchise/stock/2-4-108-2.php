<?php
/**
 * 在庫照会（完了後）
 *
 * 在庫照会完了後にメッセージを表示するだけの画面
 * 在庫調整の間違い発見（WATANABE-K）
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/07/12)
 *
 */
/*
 * 変更履歴
 *
 *
 */

$page_title = "在庫調整";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);

/****************************/
//外部変数取得
/****************************/
$done_flg = $_GET["done_flg"];           //完了識別

if($done_flg == null){
//    header("Location: 2-4-112.php");
    header("Location: ../top.php");
}

/****************************/
//部品定義
/****************************/
//OKボタン
$form->addElement("button","ok_button","Ｏ　Ｋ","onClick=\"location.href='2-4-108.php'\"");
//戻る
//$form->addElement("button","return_button","戻　る","onClick=\"javascript:history.back()\"");


//$html = NULL;     //HTML表示データ初期化


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
//$page_menu = Create_Menu_h('sale','1');

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
	//'html'          => "$html",
	'freeze_flg'    => "$freeze_flg",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
