<?php
$page_title = "�����̷������Ӱ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB��³
$db_con = Db_Connect();

//HTML���᡼������������
//require_once(PATH."include/html_quick.php");

//select����������
//require_once(PATH."include/select_part.php");

/****************************/
// �ե�����ѡ������
/****************************/
// ���ǯ��
$text9_1[] =& $form->createElement("text", "y_start", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText15(this.form,1)\" $g_form_option");
$text9_1[] =& $form->createElement("static", "", "", "-");
$text9_1[] =& $form->createElement("text", "m_start", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText16(this.form,1)\" $g_form_option");
$text9_1[] =& $form->createElement("static", "", "", "��");
$text9_1[] =& $form->createElement("text", "y_end", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText17(this.form,1)\" $g_form_option");
$text9_1[] =& $form->createElement("static", "", "", "-");
$text9_1[] =& $form->createElement("text", "m_end", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" $g_form_option");
$form->addGroup($text9_1, "f_date_d1", "");

// ����
$select_value = Select_Get($db_con, "part");
$form->addElement("select", "form_part_1", "", $select_value, $g_form_option_select);

// ô����
$select_value = Select_Get($db_con, "staff");
$form->addElement("select", "form_staff_1", "", $select_value, $g_form_option_select);

// �оݵ���
$select_value = Select_Get($db_con, "cshop");
$form->addElement("select", "form_cshop_1", "", $select_value, $g_form_option_select);

// ɽ���ܥ���
$form->addElement("submit", "hyouji", "ɽ����");

// ���ꥢ�ܥ���
$form->addElement("button", "kuria", "���ꥢ", "onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");


$def_fdata = array(
    "f_r_output"    => "1"
);

$form->setDefaults($def_fdata);

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
$page_menu = Create_Menu_f('analysis','1');

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
