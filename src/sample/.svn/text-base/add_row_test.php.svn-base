<?php
$page_title = "支払い入力のための練習";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

/****************************/
//行数追加
/****************************/
if($_POST["add_row_flg"]== 'true'){
    //最大行に、＋１する
    $max_row = $_POST["max_row"]+1;
    //行数追加フラグをクリア
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}

//hidden
$form->addElement("hidden", "add_row_flg");         //追加行フラグ

/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'               => "$html_header",
    'html'                      => "$html",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
