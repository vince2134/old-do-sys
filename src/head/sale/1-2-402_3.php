<?php
$page_title = "��������";

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
// ����ǡ������
    /* ̤���� */

// ����ܥ���
$form->addElement("button", "busy", "�衡��", "onClick=\"javascript:Dialogue2('����ޤ���','#')\"");

// ���
$select_value = Select_Get($db_con, "bank");
$form->addElement("select", "form_bank_1", "���", $select_value, $g_form_option_select);

// �������ܥ���
$form->addElement("button", "collective", "�������", "onClick=\"javascript:Dialogue2('������ꤷ�ޤ���','#')\"");

// ������
$ary_element[0] = array($text3_1, $text3_3, $text3_5, $text3_7, $text3_9);
$ary_element[1] = array("1", "3", "5", "7" ,"9");
for($x=0; $x<count($ary_element[0]); $x++){
$ary_element[0][$x][] =& $form->createElement("text", "y_input", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText3(this.form,".$ary_element[1][$x].")\" onFocus=\"onForm2(this,this.form,".$ary_element[1][$x].")\" onBlur=\"blurForm(this)\"");
$ary_element[0][$x][] =& $form->createElement("static", "", "", "-");
$ary_element[0][$x][] =& $form->createElement("text", "m_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText4(this.form,".$ary_element[1][$x].")\" onFocus=\"onForm2(this,this.form,".$ary_element[1][$x].")\" onBlur=\"blurForm(this)\"");
$ary_element[0][$x][] =& $form->createElement("static", "", "", "-");
$ary_element[0][$x][] =& $form->createElement("text", "d_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onFocus=\"onForm2(this,this.form,".$ary_element[1][$x].")\" onBlur=\"blurForm(this)\"");
$form->addGroup($ary_element[0][$x], "f_date_a".$ary_element[1][$x]."", "");
}

// �����ʬ
$select_value = Select_Get($db_con, "trade_payin");
for ($x=1; $x<=5; $x++){
$form->addElement("select", "trade_payin_".$x, "", $select_value, $g_form_option_select);
}

// ���
$select_value = Select_Get($db_con, "bank");
for ($x=1; $x<=5; $x++){
$form->addElement("select", "form_bank_".$x, "", $select_value, $g_form_option_select);
}

// ������
$ary_element[0] = array($text36_1, $text36_2, $text36_3, $text36_4, $text36_5);
$ary_element[1] = array("1", "2", "3", "4" ,"5");
for($x=0; $x<count($ary_element[0]); $x++){
$ary_element[0][$x][] =& $form->createElement("text", "code1", "", "size=\"7\" maxLength=\"6\" value=\"\" style=\"$g_form_style\" onKeyUp=\"javascript:display(this,'claim')\" $g_form_option");
$ary_element[0][$x][] =& $form->createElement("static", "", "", "-");
$ary_element[0][$x][] =& $form->createElement("text", "code2", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onKeyUp=\"javascript:display(this,'claim')\" $g_form_option");
$form->addGroup( $ary_element[0][$x], "f_claim".$ary_element[1][$x], "");

$form->addElement("text", "t_claim".$ary_element[1][$x], "", "size=\"34\" value=\"\" style=\"color : #000000; border : #ffffff 1px solid; background-color: #ffffff;\" readonly");
}


// �����
$form->addElement("text", "f_text9", "", "class=\"money\" size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"");

// �����
$form->addElement("text", "f_text9", "", "class=\"money\" size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"");

// �������
$ary_element[0] = array($text3_2, $text3_4, $text3_6, $text3_8, $text3_10);
$ary_element[1] = array("2", "4", "6", "8" ,"10");
for($x=0; $x<count($ary_element[0]); $x++){
$ary_element[0][$x][] =& $form->createElement("text", "y_input", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText3(this.form,".$ary_element[1][$x].")\" onFocus=\"onForm2(this,this.form,".$ary_element[1][$x].")\" onBlur=\"blurForm(this)\"");
$ary_element[0][$x][] =& $form->createElement("static", "", "", "-");
$ary_element[0][$x][] =& $form->createElement("text", "m_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText4(this.form,".$ary_element[1][$x].")\" onFocus=\"onForm2(this,this.form,".$ary_element[1][$x].")\" onBlur=\"blurForm(this)\"");
$ary_element[0][$x][] =& $form->createElement("static", "", "", "-");
$ary_element[0][$x][] =& $form->createElement("text", "d_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onFocus=\"onForm2(this,this.form,".$ary_element[1][$x].")\" onBlur=\"blurForm(this)\"");
$form->addGroup($ary_element[0][$x], "f_date_a".$ary_element[1][$x]."", "");
}

// ��������ֹ�
$form->addElement("text", "f_text8", "", "size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option\"");

// ����
$form->addElement("text", "f_text20", "", "size=\"34\" maxLength=\"20\" style=\"$g_form_style\" $g_form_option\""); 

// ����ܥ���
$form->addElement("button", "money2", "������", "onClick=\"javascript:Dialogue2('���⤷�ޤ���','#')\"");

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
