<?php

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/13      10-015      suzuki      契約マスタへボタン押下時の遷移先変更
*/

$page_title = "レンタルTOレンタル";

// 環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);

/****************************/
//外部変数取得
/****************************/
$rental_id = $_GET["rental_id"];   //レンタルID
$disp_stat = $_GET["disp_stat"];   //レンタル状況
$stat_flg  = $_GET["stat_flg"];    //契約済データ存在判定フラグ
$client_id = $_GET["client_id"];   //得意先ID
$online_flg= $_GET["flg"];   //オンラインフラグ
Get_Id_Check2($disp_stat);

//ボタン名判定
if($rental_id != NULL){
	//変更画面
	$form->addElement("button","input_btn","変更画面へ","onClick=\"location.href='".FC_DIR."system/2-1-141.php?rental_id=$rental_id'\"");
}else{
	//登録画面
	$form->addElement("button","input_btn","登録画面へ","onClick=\"location.href='".FC_DIR."system/2-1-141.php'\"");
}
if ($disp_stat != "1"){
	//一覧画面
	$form->addElement("button","disp_btn","一覧画面へ","onClick=\"location.href='".FC_DIR."system/2-1-142.php?search=1'\"");
}else{
	//一覧画面
	$form->addElement("button","disp_btn","一覧画面へ","onClick=\"location.href='".FC_DIR."system/2-1-142.php'\"");
}
//契約マスタ
$form->addElement("button","con_btn","契約マスタへ","onClick=\"location.href='".FC_DIR."system/2-1-115.php?client_id=$client_id'\"");

//不正判定
Get_ID_Check3($rental_id);
Get_ID_Check3($client_id);

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
$page_menu = Create_Menu_h('sale','2');

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
	'disp_stat'     => "$disp_stat",
	'stat_flg'      => "$stat_flg",
	'online_flg'      => "$online_flg"
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
