<?php
$page_title = "���ͽ�ꥫ������(��)";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

/****************************/
//�ե��������
/****************************/

$def_fdata = array(
    "form_output"     => "1",
);
$form->setDefaults($def_fdata);

//ͽ��ǯ��
$text1[] =& $form->createElement("text","y_input","�ƥ����ȥե�����",'size="4" maxLength="4" onkeyup="changeText13(this.form,1)"' .$g_form_option);
$text1[] =& $form->createElement("static","","","-");
$text1[] =& $form->createElement("text","m_input","�ƥ����ȥե�����",'size="2" maxLength="2"' .$g_form_option);
$form->addGroup( $text1,"form_date","form_date");

//���Ϸ���
$radio1[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$radio1[] =& $form->createElement( "radio",NULL,NULL, "Ģɼ","2");
$form->addGroup($radio1, "form_output", "���Ϸ���");

//����
$select_value = Select_Get($db_con,'part');
$form->addElement('select', 'form_part_1', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//ô����
$select_value = Select_Get($db_con,'staff');
$form->addElement('select', 'form_staff_1', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//ɽ���ܥ���
$button[] = $form->createElement("submit","indicate_button","ɽ����","onClick=\"javascript:window.open('".FC_DIR."sale/2-2-103.php','_blank','')\"");

//���ꥢ�ܥ���
$button[] = $form->createElement("button","clear_button","���ꥢ","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//����ܥ���
$button[] = $form->createElement("submit","back_button","<<������");

//���ܥ���
$button[] = $form->createElement("submit","next_button","��>>");

$form->addGroup($button, "form_button", "�ܥ���");

//���ͽ��ɽ
$form->addElement("button","form_patrol_button","���ͽ��ɽ","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//ñ���ѹ�
$form->addElement("button","form_single_month_change_button","����ѹ�","onClick=\"javascript:Referer('2-2-101-2.php')\"");
//�ޥ����ѹ�
$form->addElement("button","form_master_change_button","��³�ѹ�","onClick=\"javascript:Referer('2-2-101-3.php')\"");

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
$page_menu = Create_Menu_f('sale','1');

/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex[form_single_month_change_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[form_master_change_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[form_patrol_button]]->toHtml();
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
