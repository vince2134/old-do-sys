<?php
$page_title = "��ʧ�ѹ�";

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
// ��ʧ��
$text3_1[] =& $form->createElement("text", "y_input", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText3(this.form,1)\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$text3_1[] =& $form->createElement("static", "", "", "-");
$text3_1[] =& $form->createElement("text", "m_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText4(this.form,1)\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$text3_1[] =& $form->createElement("static", "", "", "-");
$text3_1[] =& $form->createElement("text", "d_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$form->addGroup($text3_1, "f_date_a1", "");

// �����ʬ
$select_value = Select_Get($db_con, "trade_payout");
$form->addElement("select", "trade_payout_1", "", $select_value, $g_form_option_select);

// ���
$select_value = Select_Get($db_con, "bank");
$form->addElement("select", "form_bank_1", "", $select_value, $g_form_option_select);

// ������
$form->addElement("text", "f_layer1", "", "size=\"7\" maxLength=\"6\" value=\"\" style=\"$g_form_style\" onKeyUp=\"javascript:display(this,'layer1')\" $g_form_option");
$form->addElement("text", "t_layer1", "", "size=\"34\" value=\"\" style=\"color : #000000; border : #ffffff 1px solid; background-color: #ffffff;\" readonly");

// ��ʧ���
$form->addElement("text", "f_text9", "", "class=\"money\" size=\"11\" maxLength=\"9\" style=\"text-align: right; $g_form_style\" $g_form_option");

// �����
$form->addElement("text", "f_text9", "", "class=\"money\" size=\"11\" maxLength=\"9\" style=\"text-align: right; $g_form_style\" $g_form_option");


// �������
$text3_2[] =& $form->createElement("text", "y_input", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText3(this.form,2)\" onFocus=\"onForm2(this,this.form,2)\" onBlur=\"blurForm(this)\"");
$text3_2[] =& $form->createElement("static", "", "", "-");
$text3_2[] =& $form->createElement("text", "m_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText4(this.form,2)\" onFocus=\"onForm2(this,this.form,2)\" onBlur=\"blurForm(this)\"");
$text3_2[] =& $form->createElement("static", "", "", "-");
$text3_2[] =& $form->createElement("text", "d_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onFocus=\"onForm2(this,this.form,2)\" onBlur=\"blurForm(this)\"");
$form->addGroup($text3_2,"f_date_a2","");

// ��������ֹ�
$form->addElement("text", "f_text8", "", "size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option");

// ����
$form->addElement("text", "f_text20", "", "size=\"34\" maxLength=\"20\" $g_form_option");

// �ѹ��ܥ���
$form->addElement("button", "f_change4", "�ѡ���", "onClick=\"javascript:Dialogue2('�ѹ����ޤ���','".FC_DIR."buy/2-3-303.php')\"");

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
$page_menu = Create_Menu_f('buy','3');

/****************************/
//���̥إå�������
/****************************/
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
