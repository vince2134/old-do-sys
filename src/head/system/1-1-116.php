<?php
$page_title = "����ޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

/****************************/
//�ե��������
/****************************/

//�ǥե�����ͤ�����
$def_date = array(
    "f_r_output2"     => "1",
	"f_radio34"     => "1",
);
$form->setDefaults($def_date);

//���Ϸ���
$radio = "";
$radio[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
$form->addGroup($radio, "f_r_output2", "���Ϸ���");
//����
$radio = "";
$radio[] =& $form->createElement( "radio",NULL,NULL, "�����","1",$g_form_option_select);
$radio[] =& $form->createElement( "radio",NULL,NULL, "����ٻ���","2",$g_form_option_select);
$radio[] =& $form->createElement( "radio",NULL,NULL, "����","3",$g_form_option_select);
$form->addGroup($radio, "f_radio34", "����");

//FC/�����襳����
$text23[] =& $form->createElement("text","code1","�ƥ����ȥե�����","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText_shop(this.form)\" ".$g_form_option."\"");
$text23[] =& $form->createElement("static","","","-");
$text23[] =& $form->createElement("text","code2","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" ".$g_form_option."\"");
$text23[] =& $form->createElement("text","name","�ƥ����ȥե�����",'size="34" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');
$form->addGroup( $text23, "f_shop", "f_shop");
//FC/������̾
$form->addElement("text","f_text15","�ƥ����ȥե�����","size=\"34\" maxLength=\"15\" ".$g_form_option."\"");

//FC��������ʬ
$select_value = Select_Get($db_con,'rank');
$form->addElement('select', 'form_rank_1', '���쥯�ȥܥå���', $select_value,$g_form_option_select);
//�϶�
$select_value = Select_Get($db_con,'area');
$form->addElement('select', 'form_area_1', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//ɽ��
$button[] = $form->createElement("submit","hyouji","ɽ����");
//���ꥢ
$button[] = $form->createElement("button","kuria","���ꥢ","onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");
//�ѹ�������
//$form->addElement("button","change_button","�ѹ�������","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","change_button","�ѹ�������",$g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//�������
//$form->addElement("button","all_button","�������","onClick=\"javascript:Referer('1-1-119.php')\"");
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
//��˥塼����
/****************************/
$page_menu = Create_Menu_h('system','1');
/****************************/
//���̥إå�������
/****************************/
$total_count = 7;
$page_title .= "(��".$total_count."��)";
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
//$page_title .= "��".$form->_elements[$form->_elementIndex[all_button]]->toHtml();
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
	'total_count'    => "$total_count",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
