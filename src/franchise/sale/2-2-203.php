<?php
$page_title = "�����ɼ";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

//HTML���᡼������������
//require_once(PATH."include/html_quick.php");

//select����������
//require_once(PATH."include/select_part.php");
/*
//���
$form->addElement("button","form_make_button","���","onClick=\"javascript:Referer('2-2-201.php')\"");
//������
$form->addElement("button","form_revision_button","������","onClick=\"javascript:Referer('2-2-202.php')\"");
//ȯ����
$form->addElement("button","form_public_button","ȯ����","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
*/

/****************************/
// �ե�����ѡ������
/****************************/
// ��ɼ�ֹ�
$form->addElement("text", "f_text8", "", "size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option");

// ɽ���ܥ���
$form->addElement("submit", "hyouji", "ɽ����");

// �����ɼȯ�ԥܥ���
$form->addElement("submit", "uriage", "�����ɼȯ��", "onClick=\"javascript:window.open('".FC_DIR."sale/2-2-205.php','_blank','')\"");

// ���ܥ���
$form->addElement("button", "modoru", "�ᡡ��", "onClick=\"javascript:history.back()\"");

/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
//��˥塼����
/****************************/
$page_menu = Create_Menu_f('sale','2');

/****************************/
//���̥إå�������
/****************************/
/*
$page_title .= "������".$form->_elements[$form->_elementIndex[form_make_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[form_revision_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[form_public_button]]->toHtml();
*/
$page_header = Create_Header($page_title);





// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
