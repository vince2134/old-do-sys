<?php
$page_title = "��������";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

//HTML���᡼������������
//require_once(PATH."include/html_quick.php");

//select����������
//require_once(PATH."include/select_part.php");

/****************************/
// �ե�����ѡ������
/****************************/
// ��������
$text3_1[] =& $form->createElement("text", "y_input", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText3(this.form,1)\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$text3_1[] =& $form->createElement("static", "", "", "-");
$text3_1[] =& $form->createElement("text", "m_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText4(this.form,1)\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$text3_1[] =& $form->createElement("static", "", "", "-");
$text3_1[] =& $form->createElement("text", "d_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$form->addGroup( $text3_1, "f_date_a1", "");

// �����ȼ�
$form->addElement('checkbox', 'form_trans_check', '���꡼�����', '<b>���꡼�����</b>��');

$select_value = Select_Get($db_con, "trans");
$form->addElement("select", "form_trans_1", "", $select_value, $g_form_option_select);

// �в��Ҹ�
$select_value = Select_Get($db_con, "ware");
$form->addElement("select", "form_ware_1", "", $select_value, $g_form_option_select);

// �����ʬ
$select_value = Select_Get($db_con, "trade_aord");
$form->addElement("select", "trade_aord_1", "", $select_value, $g_form_option_select);

// ô����
$select_value = Select_Get($db_con, "staff", null, true);
$form->addElement("select", "form_staff_1", "", $select_value, $g_form_option_select);

// �̿���������谸��
$form->addElement("textarea", "f_textarea", "", "rows=\"2\" cols=\"75\" $g_form_option_area");

// ��ʸ��ȯ�ԥܥ���
$form->addElement("submit", "hattyuusho", "��ʸ��ȯ��", "onClick=\"javascript:window.open('".FC_DIR."buy/2-3-105.php','_blank','')\"");

// ��Ͽ�ܥ���
$form->addElement("button", "touroku", "�С�Ͽ", "onClick=\"javascript:Dialogue4('��Ͽ���ޤ���')\" $disabled");

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
$page_menu = Create_Menu_h('sale','1');
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
    'auth_r_msg'    => "$auth_r_msg",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
