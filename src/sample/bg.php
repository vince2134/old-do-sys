<?php

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

/**************HTML���᡼������������********************/

//����ɽ���ƥ�����
$form->addElement("text","form_data","�ƥ����ȥե�����",'size="15" value="" ');

$form->addElement("text","form_hidden","�ƥ����ȥե�����",'size="15" value="" ');

//��Ͽ�ܥ���
$form->addElement("submit","touroku","�С�Ͽ");
//���ꥢ
$form->addElement("button","clear_button","���ꥢ","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");


$form->addElement("hidden", "hidden_data");   

/**********************��Ͽ�ܥ��󲡲�����*****************/

if($_POST["touroku"] == "�С�Ͽ"){
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
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
