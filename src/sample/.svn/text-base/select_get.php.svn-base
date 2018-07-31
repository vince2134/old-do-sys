<?php

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

/**************HTMLイメージ作成用部品********************/

//部署マスタの値取得
$select_value = Select_Get($db_con,'part');

$select_value =null;
$select_value[0] = "aa";
$select_value[1] = "aa";


$status = $form->addElement('select', 'select_table', 'セレクトボックス');
$status->addOption ("全て", "0", 'style=color:red;' );
$status->addOption ("全て1", "1", 'style=color:red;' );
$status->addOption ("全て2", "2");
$status->addOption ("全て3", "3", 'style=color:red;' );

/*********************************************************/


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
