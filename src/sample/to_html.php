<?php

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickForm作成
$form = new HTML_QuickForm( "dateForm","POST","$_SERVER[PHP_SELF]");

/*
$form->addElement('text', 'test_form','test');
$form->addRule('test_form', '入力してください', 'required');
$form->exportValue('test_form');
$form->getElementValue('test_form');
echo $form->_elements[$form->_elementIndex['test_form']]->toHtml();
echo $form->_elementIndex['test_form'];
*/

for($i=0;$i<10;++$i){
	$form->addElement('text', "name$i",'test');
	$test .= $form->_elements[$form->_elementIndex["name$i"]]->toHtml();
	$test .= "<br>"; 

}
print_r($_POST);

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
	'test'   => "$test",

));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
