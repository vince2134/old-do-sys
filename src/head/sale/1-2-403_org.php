<?php
$page_title = "����Ȳ�";

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
// �ե�����ѡ��ĺ���
/****************************/
// ���Ϸ���
$radio54[] =& $form->createElement("radio", null, null, "����", "1");
$radio54[] =& $form->createElement("radio", null, null, "Ģɼ", "2");
$radio54[] =& $form->createElement("radio", null, null, "CSV", "3");
$form->addGroup($radio54, "f_r_output23", "");

// �����ֹ�
$form->addElement("text", "f_text8", "", "size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option");

// ������
$text4_1[] =& $form->createElement("text", "y_start", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText5(this.form,1)\" $g_form_option");$text4_1[] =& $form->createElement("static", "", "", "-");
$text4_1[] =& $form->createElement("text", "m_start", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText6(this.form,1)\" $g_form_option");
$text4_1[] =& $form->createElement("static", "", "", "-");$text4_1[] =& $form->createElement("text", "d_start", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText7(this.form,1)\" $g_form_option");
$text4_1[] =& $form->createElement("static", "", "", "������");
$text4_1[] =& $form->createElement("text", "y_end", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText8(this.form,1)\" $g_form_option");
$text4_1[] =& $form->createElement("static", "", "", "-");$text4_1[] =& $form->createElement("text", "m_end", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText9(this.form,1)\" $g_form_option");
$text4_1[] =& $form->createElement("static", "", "", "-");$text4_1[] =& $form->createElement("text", "d_end", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onFocus=\"onForm(this)\" $g_form_option");
$form->addGroup( $text4_1, "f_date_b1", "");

// ������
$text4_2[] =& $form->createElement("text", "y_start", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText5(this.form,2)\" $g_form_option");$text4_1[] =& $form->createElement("static", "", "", "-");
$text4_2[] =& $form->createElement("static", "", "", "-");
$text4_2[] =& $form->createElement("text", "m_start", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText6(this.form,2)\" $g_form_option");
$text4_2[] =& $form->createElement("static", "", "", "-");
$text4_2[] =& $form->createElement("text", "d_start", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText7(this.form,2)\" $g_form_option");
$text4_2[] =& $form->createElement("static", "", "", "������");
$text4_2[] =& $form->createElement("text", "y_end", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText8(this.form,2)\" $g_form_option");
$text4_2[] =& $form->createElement("static", "", "", "-");
$text4_2[] =& $form->createElement("text", "m_end", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText9(this.form,2)\" $g_form_option");
$text4_2[] =& $form->createElement("static", "", "", "-");
$text4_2[] =& $form->createElement("text", "d_end", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onFocus=\"onForm(this)\" $g_form_option");
$form->addGroup( $text4_2, "f_date_b2", "");

// �����ʬ
$select_value = Select_Get($db_con, "trade_payin");
$form->addElement("select", "trade_payin_1", "", $select_value, $g_form_option_select);

// ���
$select_value = Select_Get($db_con, "bank");
$form->addElement("select", "form_bank_1", "", $select_value, $g_form_option_select);

// �����襳����
$text1[] =& $form->createElement("text", "f_text6", "", "size=\"7\" maxLength=\"6\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText1(this.form,1)\" $g_form_option");
$text1[] =& $form->createElement("static", "", "", "-");
$text1[] =& $form->createElement("text", "f_text4", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" $g_form_option");
$form->addGroup( $text1, "f_code_a1", "");

// ������̾
$form->addElement("text", "f_text15", "", "size=\"34\" maxLength=\"15\" $g_form_option");

// �����
$text7_1[] =& $form->createElement("text", "f_text9_1", "", "size=\"11\" maxLength=\"9\" value=\"\" onkeyup=\"changeText12(this.form,1)\" $g_form_option style=\"text-align: right; $g_form_style\"");
$text7_1[] =& $form->createElement("static", "", "", "������");
$text7_1[] =& $form->createElement("text", "f_text9_2", "", "size=\"11\" maxLength=\"9\" value=\"\" style=\"text-align: right; $g_form_style\"");
$form->addGroup( $text7_1, "f_code_e1", "");

// �����
$text7_3[] =& $form->createElement("text", "f_text9_1", "", "size=\"11\" maxLength=\"9\" value=\"\" onkeyup=\"changeText12(this.form,3)\" $g_form_option style=\"text-align: right; $g_form_style\"");
$text7_3[] =& $form->createElement("static", "", "", "������");
$text7_3[] =& $form->createElement("text", "f_text9_2", "", "size=\"11\" maxLength=\"9\" value=\"\" $g_form_option style=\"text-align: right; $g_form_style\"");
$form->addGroup($text7_3, "f_code_e3", "");

// �����
$text7_2[] =& $form->createElement("text", "f_text9_1", "", "size=\"11\" maxLength=\"9\" value=\"\" onkeyup=\"changeText12(this.form,2)\" $g_form_option style=\"text-align: right; $g_form_style\"");
$text7_2[] =& $form->createElement("static", "", "", "������");
$text7_2[] =& $form->createElement("text", "f_text9_2", "", "size=\"11\" maxLength=\"9\" value=\"\" $g_form_option style=\"text-align: right; $g_form_style\"");
$form->addGroup($text7_2, "f_code_e2", "");


// ����
$text7_4[] =& $form->createElement("text", "f_text9_1", "", "size=\"11\" maxLength=\"9\" value=\"\" onkeyup=\"changeText12(this.form,4)\" $g_form_option style=\"text-align: right; $g_form_style\"");
$text7_4[] =& $form->createElement("static", "", "", "������");
$text7_4[] =& $form->createElement("text", "f_text9_2", "", "size=\"11\" maxLength=\"9\" value=\"\" $g_form_option style=\"text-align: right; $g_form_style\"");
$form->addGroup($text7_4, "f_code_e4", "");


// ��������
$radio11[] =& $form->createElement("radio", null, null, "����ʤ�", "1");
$radio11[] =& $form->createElement("radio", null, null, "�»ܺ�", "2");
$radio11[] =& $form->createElement("radio", null, null, "̤�»�", "3");
$form->addGroup($radio11, "f_radio11", "");

// ɽ���ܥ���
$form->addElement("submit", "hyouji3", "ɽ����", "onClick=\"javascript:window.open('".HEAD_DIR."sale/1-2-406.php','_blank','')\"");

// ���ꥢ�ܥ���
$form->addElement("button", "form_clear_button", "���ꥢ", "onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");


$def_fdata = array(
    "f_r_output23"  => "1",
    "f_radio11"     => "1"
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
$page_menu = Create_Menu_h('sale','4');
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
