<?php
$page_title = "FC�̾����������";

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
// ���Ϸ���
$radio12[] =& $form->createElement("radio", null, null, "����", "1");
$radio12[] =& $form->createElement("radio", null, null, "CSV", "2");
$form->addGroup($radio12, "f_r_output2", "");

// �����ϰ�
$radio28[] =& $form->createElement("radio", null, null, "����١���", "1");
$radio28[] =& $form->createElement("radio", null, null, "���١���", "2");
$form->addGroup($radio28, "f_radio12", "");

// ���ǯ��
$text9_1[] =& $form->createElement("text", "y_start", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText15(this.form,1)\" $g_form_option");
$text9_1[] =& $form->createElement("static", "", "", "-");
$text9_1[] =& $form->createElement("text", "m_start", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText16(this.form,1)\" $g_form_option");
$text9_1[] =& $form->createElement("static", "", "", "��");
$text9_1[] =& $form->createElement("text", "y_end", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText17(this.form,1)\" $g_form_option");
$text9_1[] =& $form->createElement("static", "", "", "-");
$text9_1[] =& $form->createElement("text", "m_end", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" $g_form_option");
$form->addGroup( $text9_1, "f_date_d1", "");

// ��������
$radio67[] =& $form->createElement("radio", null, null, "������", "1");
$radio67[] =& $form->createElement("radio", null, null, "�Ͷ�ʬ��", "2");
$radio67[] =& $form->createElement("radio", null, null, "���ʶ�ʬ��", "3");
$form->addGroup($radio67, "f_radio67", "");

// ����åץ�����
$text1[] =& $form->createElement("text", "f_text6", "", "size=\"7\" maxLength=\"6\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText1(this.form,1)\" $g_form_option");
$text1[] =& $form->createElement("static", "", "", "-");
$text1[] =& $form->createElement("text", "f_text4", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" $g_form_option");
$form->addGroup( $text1, "f_code_a1", "");

// ����å�̾
$form->addElement("text", "f_text15", "", "size=\"34\" maxLength=\"15\" $g_form_option");

// �ܵҶ�ʬ
$select_value = Select_Get($db_con, "rank");
$form->addElement("select", "form_rank_1", "", $select_value, $g_form_option_select);

// ���ʥ�����
$form->addElement("text", "f_text8", "", "size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option");

// ����̾
$form->addElement("text", "f_text30", "", "size=\"34\" maxLength=\"30\" $g_form_option");

// �Ͷ�ʬ
$select_value = Select_Get($db_con, "g_goods");
$form->addElement("select", "form_g_goods_1", "", $select_value, $g_form_option_select);

// ���ʶ�ʬ
$select_value = Select_Get($db_con, "product");
$form->addElement("select", "form_product_1", "", $select_value, $g_form_option_select);

// ���Ϲ���
$check3[] =& $form->createElement("checkbox", null, null, "����", "1");
$check3[] =& $form->createElement("checkbox", null, null, "�����", "2");
$check3[] =& $form->createElement("checkbox", null, null, "�����׳�", "3");
$check3[] =& $form->createElement("checkbox", null, null, "����Ψ", "4");
$form->addGroup( $check3, "f_check3", "");

// ɽ���ܥ���
$form->addElement("submit", "hyouji", "ɽ����");

// ���ꥢ�ܥ���
$form->addElement("button", "kuria", "���ꥢ", "onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");


$def_fdata = array(
    "f_r_output2"   => "1",
    "f_radio12"     => "1",
    "f_radio67"     => "1",
    "f_check3"      => "1"
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
$page_menu = Create_Menu_h('analysis','1');

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
