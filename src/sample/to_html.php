<?php

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm����
$form = new HTML_QuickForm( "dateForm","POST","$_SERVER[PHP_SELF]");

/*
$form->addElement('text', 'test_form','test');
$form->addRule('test_form', '���Ϥ��Ƥ�������', 'required');
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
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'html_footer'   => "$html_footer",
	'test'   => "$test",

));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
