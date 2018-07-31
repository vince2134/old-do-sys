<?php
$page_title = "����ޥ���";
// �Ķ�����ե�����
require_once("ENV_local.php");

// DB����³
$db_con = Db_Connect();

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]", null);

// ɽ���ǡ���
$disp_data[0] = array(
    "Result1",
    "1000",
    "1500",
);

$disp_data[1] = array(
    "Result2",
    "600",
    "1200",
);

$disp_data[2] = array(
    "Result1",
    "2000",
    "3000",
);

/****************************/
// HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
// ��˥塼����
/****************************/
$page_menu = Create_Menu_h("system", "2");

/****************************/
// ���̥إå�������
/****************************/
$page_header = Create_Header($page_title);

/****************************/
// �������
/****************************/
// ���쥯�ȥܥå�����

// ���������
$array_rmonth = array(
	"" => "",
	"1" => "1",
	"2" => "2",
	"3" => "3",
	"4" => "4",
	"5" => "5",
	"6" => "6",
);

// �����ּ���
$array_rweek = array(
	"" => "",
	"1" => "1",
	"2" => "2",
	"3" => "3",
	"4" => "4",
);

// ����
$array_week = array(
	"" => "",
	"1" => "��",
	"2" => "��",
	"3" => "��",
	"4" => "��",
	"5" => "��",
	"6" => "��",
	"7" => "��"
);

// �ե�����Υǥե������
$def_date = array(
	"shop_txt"       => "$shop_name",
	"f_radio72"      => "1",
	"form_round_div" => "1",
	"form_slip_flg"  => "1",
	"form_cost_div"  => "1",
);
$form->setDefaults($def_date);

//���꡼�����
$form->addElement("checkbox", "form_trans_check", "���꡼�����", "<b>���꡼�����</b>��", "onClick=\"javascript:Link_Submit('form_trans_check','trans_check_flg','#','true')\"");

// �����ȼ�
$select_value = Select_Get($db_con, "trans", $where);
$form->addElement("select", "form_trans_select", "", $select_value, $g_form_option_select);

// ľ����
$select_value = Select_Get($db_con, "direct");
$form->addElement("select", "form_direct_select", "", $select_value, $g_form_option_select);

// �в��Ҹ�
$select_value = Select_Get($db_con, "ware");
$form->addElement("select", "form_ware_select", "", $select_value, $g_form_option_select);

// ô����
$select_value = Select_Get($db_con, "staff");
$form->addElement("select", "form_staff_select", "", $select_value, $g_form_option_select);

// �̿���������谸��
$form->addElement("textarea", "form_note_your", "", "rows=\"2\" cols=\"75\" \".$g_form_option_area.\" ");

// ������ʥ饸���ܥ����
$form_round_div[] =& $form->createElement("radio", null, null, "", "1");
$form_round_div[] =& $form->createElement("radio", null, null, "", "2");
$form->addGroup($form_round_div, "form_round_div", "form_round_div", "<br>");

// (1)
// ��
$form->addElement("select", "form_rweek", "", $array_rweek, $g_form_option_select);
$form->addElement("select", "form_week", "", $array_week, $g_form_option_select);

$form_stand_day1[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_stand_day1[y]','form_stand_day1[m]',4)\"".$g_form_option."\"");
$form_stand_day1[] =& $form->createElement("static", "", "", "-");
$form_stand_day1[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" $g_form_option");
$form->addGroup($form_stand_day1, "form_stand_day1", "");

// (2)
$form->addElement("select", "form_rmonth", "", $array_rmonth, $g_form_option_select);
$select_value = Select_Get($db_con, "close");
$form->addElement("select", "form_day", "", $select_value);

$form_stand_day2[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_stand_day2[y]','form_stand_day2[m]',4)\"".$g_form_option."\"");
$form_stand_day2[] =& $form->createElement("static", "", "", "-");
$form_stand_day2[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" $g_form_option");
$form->addGroup($form_stand_day2, "form_stand_day2", "");

// ���ɲåܥ���
$form->addElement("button", "add_row_link", "���ɲ�", "onClick=\"javascript:Button_Submit_1('add_row_flg', '#foot', 'true')\"");

// ��ץܥ���
$form->addElement("button", "form_sum_btn", "�硡��", "onClick=\"javascript:Button_Submit('sum_button_flg','#foot','true')\"");

// ��Ͽ�ܥ���
$form->addElement("button", "entry_button", "�С�Ͽ" ,"onClick=\"javascript:return Dialogue('��Ͽ���ޤ���','1-1-123.php');\"");

// ���ܥ���
$form->addElement("button", "return_button", "�ᡡ��", "onClick=\"javascript:history.back()\"");

/*** ����ɽ���ѤΤ�������˺�ä��Ȥꤢ�����ե������������������������ ***/
// ���ʥ�����
$form->addElement("text", "form_goods_cd", "", "size=\"10\" maxLength=\"8\" style=\"$g_form_opotion\"");
// ����̾
$form->addElement("text", "form_goods_name", "", "size=\"34\" style=\"$g_form_option\"");
// ����
$form->addElement("text", "form_num", "", "size=\"4\"");
// ����ñ��
$text = null;
$text[] = $form->createElement("text", "1", "", "size=\"4\"");
$text[] = $form->createElement("static", "", "", ".");
$text[] = $form->createElement("text", "2", "", "size=\"2\"");
$form->addGroup($text, "form_genkatanka", "");
// ���ñ��
$text = null;
$text[] = $form->createElement("text", "1", "", "size=\"4\"");
$text[] = $form->createElement("static", "", "", ".");
$text[] = $form->createElement("text", "2", "", "size=\"2\"");
$form->addGroup($text, "form_uriagetanka", "");


/****************************/
// �ڡ�������
/****************************/

//  Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

// ����¾���ѿ���assign
$smarty->assign("var", array(
	"html_header"   => $html_header,
	"page_menu"     => $page_menu,
	"page_header"   => $page_header,
	"html_footer"   => $html_footer,
));
$smarty->assign("disp_data", $disp_data);

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
