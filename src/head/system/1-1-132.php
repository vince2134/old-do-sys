<?php
$page_title = "�ݸ�������";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]", null);

// DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
($auth[0] == "r") ? $form->freeze() : null;


/****************************/
//�ǥե����������
/****************************/
$def_fdata = array(
    "form_output_type"     => "1",
    "form_day_y"    =>"2006",
    "form_day_m"    =>"05",
);
$form->setDefaults($def_fdata);

/****************************/
// �ե�����ѡ��ĺ���
/****************************/

//���Ϸ���
$radio1[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$radio1[] =& $form->createElement( "radio",NULL,NULL, "Ģɼ","2");
$form->addGroup($radio1, "form_output_type", "���Ϸ���");

//ɽ���ܥ���
$form->addElement("button","form_show_button","ɽ����"); 
//���ꥢ�ܥ���
$form->addElement("button","form_clear_button","���ꥢ","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");// ���ܥ���
$form->addElement("button", "form_back_button", "�ᡡ��", "onClick=\"javascript:history.back()\"");

//��Ͽ�ܥ���
$form->addElement("button", "form_add_button", "�С�Ͽ");

$form->addElement("button", "new_button", "��Ͽ����", " onClick=\"javascript:location.href='1-1-131.php'\"");
$form->addElement("button", "change_button", "�ѹ�������", $g_button_color."onClick=\"javascript:location.href='1-1-132.php'\"");

//ǯ��
$form->addElement("text","form_day_y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_day[y]','form_day[m]',4)\" onFocus=\"onForm_today(this,this.form,'form_day[y]','form_day[m]','form_day[d]')\" onBlur=\"blurForm(this)\"");
$form->addElement("text","form_day_m","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_day[m]','form_day[d]',2)\" onFocus=\"onForm_today(this,this.form,'form_day[y]','form_day[m]','form_day[d]')\" onBlur=\"blurForm(this)\"");

/****************************/
// ����ɽ����
/****************************/

$disp_data[0] = array(
    "Result1",
    "1",
    "����",
    "�㳲�ݸ�",
    "16",
    "10,240",
    "10,240",
    "67,730",
    "",
    "����ݸ�",
    "16",
    "9,490",
    "9,490",
    "���ѡ���ɽ�ԡ�",
    "0",
    "6,000",
    "0",
    "���ѡʽ��Ȱ���",
    "16",
    "3,000",
    "48,000",
);

$disp_data[1] = array(
    "Result2",
    "2",
    "��ǥ�����",
    "�㳲�ݸ�",
    "3",
    "1,920",
    "1,920",
    "40,270",
    "",
    "����ݸ�",
    "3",
    "2,350",
    "2,350",
    "���ѡ���ɽ�ԡ�",
    "0",
    "6,000",
    "0",
    "���ѡʽ��Ȱ���",
    "12",
    "3,000",
    "36,000",
);

$disp_data[2] = array(
    "Result1",
    "3",
    "�͹�",
    "�㳲�ݸ�",
    "2",
    "1,280",
    "1,280",
    "12,000",
    "",
    "����ݸ�",
    "2",
    "1,720",
    "1,720",
    "���ѡ���ɽ�ԡ�",
    "0",
    "6,000",
    "0",
    "���ѡʽ��Ȱ���",
    "3",
    "3,000",
    "9,000",
);

$disp_data[3] = array(
    "Result2",
    "4",
    "�����ƥ�",
    "�㳲�ݸ�",
    "3",
    "1,920",
    "1,920",
    "21,640",
    "",
    "����ݸ�",
    "3",
    "1,720",
    "1,720",
    "���ѡ���ɽ�ԡ�",
    "0",
    "6,000",
    "0",
    "���ѡʽ��Ȱ���",
    "6",
    "3,000",
    "18,000",
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
//�ǥ��쥯�ȥ�
/****************************/
$head_page = HEAD_DIR."system/1-1-104.php";

/****************************/
//��˥塼����
/****************************/
$page_menu = Create_Menu_h("system", "1");

/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);


// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

//����¾���ѿ���assign
$smarty->assign("var", array(
	"html_header"   => "$html_header",
	"page_menu"     => "$page_menu",
	"page_header"   => "$page_header",
	"html_footer"   => "$html_footer",
	"head_page"     => "$head_page",	
));

//ɽ���ǡ���
$smarty->assign("disp_data", $disp_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
