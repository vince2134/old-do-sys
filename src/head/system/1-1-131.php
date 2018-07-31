<?php
$page_title = "�ݸ�����Ͽ";

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
// �ե�����ѡ��ĺ���
/****************************/
// ���ܥ���
$form->addElement("button", "form_back_button", "�ᡡ��", "onClick=\"javascript:location.href='1-1-123.php'\"");

//��Ͽ�ܥ���
$form->addElement("button", "form_add_button", "�С�Ͽ", "onClick=\"javascript:location.href='1-1-123.php'\"");

$form->addElement("button", "new_button", "��Ͽ����", $g_button_color."onClick=\"javascript:location.href='1-1-131.php'\"");
$form->addElement("button", "change_button", "�ѹ�������", "onClick=\"javascript:location.href='1-1-132.php'\"");

//������
$form_day[] =& $form->createElement("text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_day[y]','form_day[m]',4)\" onFocus=\"onForm_today(this,this.form,'form_day[y]','form_day[m]','form_day[d]')\" onBlur=\"blurForm(this)\"");
$form_day[] =& $form->createElement("static","","","-");
$form_day[] =& $form->createElement("text","m","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_day[m]','form_day[d]',2)\" onFocus=\"onForm_today(this,this.form,'form_day[y]','form_day[m]','form_day[d]')\" onBlur=\"blurForm(this)\"");
$form_day[] =& $form->createElement("static","","","-");
$form_day[] =& $form->createElement("text","d","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onBlur=\"blurForm(this)\"");
$form->addGroup( $form_day,"form_day","form_day");

//������(��)
$select_value = Select_Get($db_con,'close');
$form->addElement("select", "form_date", "ȯ����", $select_value);

//����
$form->addElement("text", "form_note","size=\"34\"");

for($i = 0; $i < 1; $i++){
    $form->addElement("text", "form_code[$i]",""," size=\"10\"");
    $form->addElement("text", "form_name[$i]","","");
    $form->addElement("text", "form_num[$i]","","size=\"8\" style=\"text-align:right\"");
    $form->addElement("text", "form_price[$i]","","size=\"8\" style=\"text-align:right\"");
    $form->addElement("text", "form_amount[$i]","","size=\"8\" style=\"text-align:right\"");
}

/****************************/
// ����ɽ����
/****************************/
$disp_data = array(
    array("Result1", "00000001", "�㳲�ݸ�","16", "10,240", "10,240"),
);

for($i = 0; $i < count($disp_data); $i++){
    $def_data["form_code[$i]"]      = $disp_data[$i][1]; 
    $def_data["form_name[$i]"]      = $disp_data[$i][2]; 
    $def_data["form_num[$i]"]       = $disp_data[$i][3]; 
    $def_data["form_price[$i]"]     = $disp_data[$i][4]; 
    $def_data["form_amount[$i]"]    = $disp_data[$i][5]; 
}
$form->setDefaults($def_data);

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
