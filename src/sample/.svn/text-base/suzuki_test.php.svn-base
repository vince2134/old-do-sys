<?php

$page_title = "日付入力";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "dateForm","POST");

/**************HTMLイメージ作成用部品********************/

//普通の週
$array_week = array(
	"" => "",
	"1" => "1",
	"2" => "2",
	"3" => "3",
	"4" => "4"
);
$form->addElement('select', 'test', 'セレクトボックス',$array_week);

//登録ボタン
$form->addElement("submit","button","登　録");

//クリア
$form->addElement("button","form_clear","クリア",
        "onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\""
);

print_r ($_POST);
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
	'java_sheet'        => "$java_sheet",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
