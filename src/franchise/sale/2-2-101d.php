<?php
$page_title = "���ͽ���ѹ�";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//HTML���᡼������������
//require_once(PATH."include/html_quick.php");

$button[] = $form->addElement("button","calender_denpyou","��ɼ���ѹ�","style=\"width:120pt;height:29pt;font-size:15px;\" onClick=\"returnValue=1;window.close();\"");
$button[] = $form->addElement("button","calender_keiyaku","����ޥ������ѹ�"," style=\"width:120pt;height:29pt;font-size:15px\" onClick=\"returnValue=2;window.close();\"");
$button[] = $form->addElement("button","calender_calcel","����󥻥�","style=\"height:23pt;font-size:15px;\" onClick=\"returnValue=0;window.close();\"");

/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
//$html_footer = Html_Footer();

/****************************/
//��˥塼����
/****************************/
//$page_menu = Create_Menu_f('sale','2');

/****************************/
//���̥إå�������
/****************************/
//$page_header = Create_Header($page_title);





// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'   => "$html_header"
//	'page_menu'     => "$page_menu",
//	'page_header'   => "$page_header",
//	'html_footer'   => "$html_footer",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
