<?php
$page_title = "ͽ��ǡ����������";

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
//����
$form_state[] =& $form->createElement( "radio",NULL,NULL, "���ͽ����","1","onClick=\"input_select();\"");
$form_state[] =& $form->createElement( "radio",NULL,NULL, "���ô����","2","onClick=\"input_select();\"");
$form->addGroup($form_state, "form_type", "");

$def_data["form_type"] = "1";
$form->setDefaults($def_data);

// �ڸ�ͽ���������
$text4_1[] =& $form->createElement("text", "y_start", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText5(this.form,1)\" $g_form_option");
$text4_1[] =& $form->createElement("static", "", "", "-");
$text4_1[] =& $form->createElement("text", "m_start", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText6(this.form,1)\" $g_form_option");
$text4_1[] =& $form->createElement("static", "", "", "-");
$text4_1[] =& $form->createElement("text", "d_start", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" $g_form_option");
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

/****************************/
//�ǥ��ѥǡ���
/****************************/
$demo_data = array(
        array("00000001", "2006-6-22","������ҥ��ݥ�21����","��ƣ�칰"),
        array("00000003", "2006-6-24","������ҥ��ݥ�21����������SS","����˥ƥ������"),
        array("00000005", "2006-6-26","������ҥ��ݥ�21������������SS","����˥ƥ������"),
        array("00000007", "2006-6-28","������ҥ��ݥ�21������������ĮSS","����˥ƥ������"),
        array("00000009", "2006-6-30","������ҥ��ݥ�21������������ӣ�","����˥ƥ������"),
);

/****************************/
//js
/****************************/
$js  = "function input_select(){";
$js .= "    var C1 = document.dateForm.form_type[0].checked;\n";
$js .= "    var C2 = document.dateForm.form_type[1].checked;\n";
$js .= "    var B  = \"f_date_b1[y_start]\";\n";
$js .= "    var C  = \"f_date_b1[m_start]\";\n";
$js .= "    var D  = \"f_date_b1[d_start]\";\n";
$js .= "    var E  = \"form_staff_2\";\n";
$js .= "    if(C2 == true){\n";
$js .= "        document.dateForm.elements[B].disabled = true;\n";
$js .= "        document.dateForm.elements[C].disabled = true;\n";
$js .= "        document.dateForm.elements[D].disabled = true;\n";
$js .= "        document.dateForm.elements[B].style.backgroundColor = \"gainsboro\";\n";
$js .= "        document.dateForm.elements[C].style.backgroundColor = \"gainsboro\";\n";
$js .= "        document.dateForm.elements[D].style.backgroundColor = \"gainsboro\";\n";
$js .= "        document.dateForm.elements[E].disabled = false;\n";
$js .= "        document.dateForm.elements[E].style.backgroundColor = \"white\";\n";
$js .= "    }else if(C1 == true){\n";
$js .= "        document.dateForm.elements[B].disabled = false;\n";
$js .= "        document.dateForm.elements[C].disabled = false;\n";
$js .= "        document.dateForm.elements[D].disabled = false;\n";
$js .= "        document.dateForm.elements[B].style.backgroundColor = \"white\";\n";
$js .= "        document.dateForm.elements[C].style.backgroundColor = \"white\";\n";
$js .= "        document.dateForm.elements[D].style.backgroundColor = \"white\";\n";
$js .= "        document.dateForm.elements[E].disabled = true;\n";
$js .= "        document.dateForm.elements[E].style.backgroundColor = \"gainsboro\";\n";
$js .= "    }\n";
$js .= "}\n";

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
    'js'            => "$js",
));

$smarty->assign("demo_data", $demo_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
