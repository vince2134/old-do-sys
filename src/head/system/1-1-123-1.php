<?php
$page_title = "����ޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

/****************************/
//�ե��������
/****************************/

//�ѹ�������
$form->addElement("button","change_button","�ѹ�������","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//�������
$form->addElement("button","all_button","�������","onClick=\"javascript:Referer('1-1-119-1.php')\"");
//�ɲ�
$button[] = $form->createElement("button","insert","�ɡ���","onClick=\"Open_Dialog('1-1-104-1.php',600,700)\"");
//���
$button[] = $form->createElement("button","modoru","�ᡡ��","onClick=\"javascript:history.back()\"");
$form->addGroup($button, "button", "");
/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();


/****************************/
//�ǥ��쥯�ȥ�
/****************************/
$head_page = HEAD_DIR."system/1-1-104.php";

/****************************/
//��˥塼����
/****************************/
$page_menu = Create_Menu_h('system','1');
/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[all_button]]->toHtml();
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
	'head_page'   => "$head_page",	
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
