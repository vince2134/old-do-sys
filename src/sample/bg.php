<?php

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

/**************HTMLイメージ作成用部品********************/

//日付表示テキスト
$form->addElement("text","form_data","テキストフォーム",'size="15" value="" ');

$form->addElement("text","form_hidden","テキストフォーム",'size="15" value="" ');

//登録ボタン
$form->addElement("submit","touroku","登　録");
//クリア
$form->addElement("button","clear_button","クリア","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");


$form->addElement("hidden", "hidden_data");   

/**********************登録ボタン押下処理*****************/

if($_POST["touroku"] == "登　録"){
	$name   = $_POST["form_data"];
	$hidden = $_POST["hidden_data"];
	
	$data["hidden_data"] = $name;
	$data["form_hidden"] = $name;
	$form->setConstants($data);

}


print "<pre>";
print_r ($_POST);
print "</pre>";

/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'html_footer'   => "$html_footer",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
