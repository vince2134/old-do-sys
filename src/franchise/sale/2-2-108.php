<?php
$page_title = "ͽ��ǡ����������";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);

/****************************/
// �ե�����ѡ������
/****************************/
// �ڸ�ͽ���������
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
$form->addGroup( $text4_1, "f_date_b1", "");

// �ڸ�ͽ��۽��ô����
$select_value = Select_Get($db_con, "staff");
$form->addElement("select", "form_staff_2", "", $select_value, $g_form_option_select);

// �ڸ�ͽ���ɽ���ܥ���
$form->addElement("submit", "hyouji", "ɽ����");

// �ڸ�ͽ��ۥ��ꥢ�ܥ���
$form->addElement("button", "kuria", "���ꥢ", "onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");

// ���������ܡ�������
$text3_1[] =& $form->createElement("text", "y_input", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText3(this.form,1)\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$text3_1[] =& $form->createElement("static", "", "", "-");
$text3_1[] =& $form->createElement("text", "m_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText4(this.form,1)\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$text3_1[] =& $form->createElement("static", "", "", "-");
$text3_1[] =& $form->createElement("text", "d_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$form->addGroup($text3_1, "f_date_a1", "");

// ���������ܡ۽��ô����
$select_value = Select_Get($db_con, "staff");
$form->addElement("select", "form_staff_2", "", $select_value, $g_form_option_select);

// ���������ܡ�������ͳ
$form->addElement("text", "f_text30", "", "size=\"34\" maxLength=\"30\" $g_form_option");

// ���������ܡ۰�������ܥ���
$form->addElement("button", "collective", "�������", "onClick=\"javascript:Dialogue2('������ꤷ�ޤ���','#')\"");

// ���������ܡۥ��ꥢ�ܥ���
$form->addElement("button", "kuria", "���ꥢ", "onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");

// �������ALL
$check13[] =& $form->createElement("checkbox", "allcheck13", "", "�������", "onClick=\"javascript:Allcheck(13)\"");
$form->addGroup($check13, "allcheck13", "");

// �������
$check13_2[] =& $form->createElement("checkbox", "check", "", "");
$form->addGroup($check13_2, "check13", "");

// ��������إܥ���
$form->addElement("button", "ikkatsu_teisei_he", "����������̤�", " onClick=\"javascript:location.href='2-2-108-2.php'\"");

//�����襳����
$form->addElement(
    "text","form_client_cd1","",
    "size=\"7\" maxLength=\"6\"" 
);
$form->addElement(
    "text","form_client_cd2","",
    "size=\"5\" maxLength=\"4\"" 
);

//������̾
$form->addElement(
    "text","form_client_name","",
    "size=\"34\" maxLength=\"25\"" 
);

/****************************/
//�ǥ�ǡ���
/****************************/
$demo_data = array(
        array("00000001", "2006-6-22","000001-0000","������ҥ��ݥ�21����","��ƣ�칰","��������������"),
        array("00000002", "2006-6-23","000001-0002","������ҥ��ݥ�21�������긶SS","����˥ƥ������","���ͥ�����"),
        array("00000003", "2006-6-24","000001-0003","������ҥ��ݥ�21����������SS","����˥ƥ������","�ޥ졼����������"),
        array("00000004", "2006-6-25","000001-0004","������ҥ��ݥ�21������Ω����SS","����˥ƥ������","�ե륳����"),
        array("00000005", "2006-6-26","000001-0005","������ҥ��ݥ�21������������SS","����˥ƥ������","���㥳����"),
        array("00000006", "2006-6-27","000001-0006","������ҥ��ݥ�21�����������龮���SS","����˥ƥ������","�����쥳����"),
        array("00000007", "2006-6-28","000001-0007","������ҥ��ݥ�21������������ĮSS","����˥ƥ������","�����̸�������"),
        array("00000008", "2006-6-29","000001-0008","������ҥ��ݥ�21������������SS","���״֡���","�������������"),
        array("00000009", "2006-6-30","000001-0009","������ҥ��ݥ�21������������ӣ�","����˥ƥ������","���������������"),
        array("00000010", "2006-7-1","000001-0010", "������ҥ��ݥ�21�������ץ�ơ���Ȭ���ңӣ�","����˥ƥ������","���ͥ�����"),
);


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
$range = "100";

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

$smarty->assign("demo_data",$demo_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
