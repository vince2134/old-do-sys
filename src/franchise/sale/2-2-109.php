<?php
$page_title = "�������������ǧ";

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

/****************************/
// �ե�����ѡ������
/****************************/
// ������
$text4_1[] =& $form->createElement("text", "y_start", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText5(this.form,1)\" $g_form_option");
$text4_1[] =& $form->createElement("static", "", "", "-");
$text4_1[] =& $form->createElement("text", "m_start", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText6(this.form,1)\" $g_form_option");
$text4_1[] =& $form->createElement("static", "", "", "-");
$text4_1[] =& $form->createElement("text", "d_start", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText7(this.form,1)\" $g_form_option");
$text4_1[] =& $form->createElement("static", "", "", "������");
$text4_1[] =& $form->createElement("text", "y_end", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText8(this.form,1)\" $g_form_option");
$text4_1[] =& $form->createElement("static", "", "", "-");
$text4_1[] =& $form->createElement("text", "m_end", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText9(this.form,1)\" $g_form_option");
$text4_1[] =& $form->createElement("static", "", "", "-");
$text4_1[] =& $form->createElement("text", "d_end", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onFocus=\"onForm(this)\" $g_form_option");
$form->addGroup($text4_1, "f_date_b1", "");

// ���ô���ԥ�����
$text44_1[] =& $form->createElement("text", "f_text4_1", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText18(this.form,1)\" $g_form_option");
$text44_1[] =& $form->createElement("static", "", "", "������");
$text44_1[] =& $form->createElement("text", "f_text4_2", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" $g_form_option");
$form->addGroup( $text44_1, "f_code_g1", "");

// ���ô���ԥ����ɡʥ���޶��ڤ��
$form->addElement("text", "f_textx", "", "size=\"34\" style=\"$g_form_style\" $g_form_option");

// �������ô���ԥ����ɡʥ���޶��ڤ��
$form->addElement("text", "f_textx", "", "size=\"34\" style=\"$g_form_style\" $g_form_option");

// ɽ���ܥ���
$form->addElement("submit", "hyouji", "ɽ����");

// ���ꥢ�ܥ���
$form->addElement("button", "kuria", "���ꥢ", "onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");

// ����ALL
$check14[] =& $form->createElement("checkbox", "allcheck14", "", "����", "onClick=\"javascript:Allcheck(14)\"");
$form->addGroup($check14, "allcheck14", "");

// ����
$check14_2[] =& $form->createElement("checkbox", "check", "", "");
$form->addGroup($check14_2, "check14", "");

// �������������ǧɽ�����ܥ���
$form->addElement("submit", "delivery", "�������������ǧɽ����", "onClick=\"javascript:window.open('".FC_DIR."sale/2-2-110.php','_blank','')\"");

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
$page_header = Create_Header($page_title);


/****************************/
//�ڡ�������
/****************************/
//���η��
$total_count = 100;

//ɽ���ϰϻ���
$range = "20";

//�ڡ����������
$page_count = $_POST["f_page1"];

$html_page = Html_Page($total_count,$page_count,1,$range);
$html_page2 = Html_Page($total_count,$page_count,2,$range);

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
	'html_page'     => "$html_page",
	'html_page2'    => "$html_page2",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
