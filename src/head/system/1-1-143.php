<?php
$page_title = "��󥿥�TO��󥿥�";

// �Ķ�����ե�����
require_once("ENV_local.php");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]", null);

// DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
($auth[0] == "r") ? $form->freeze() : null;

// GET
$rental_h_id    = $_GET["rental_h_id"];
$state          = $_GET["state"];

// ������󥿥�إå�ID�Υ���åפ�����饤�󤫥��ե饤��Ĵ�٤�
// �ʲ��ν����ϤȤꤢ����
$fshop_network = ($rental_h_id == "5" || $rental_h_id == "6" || $rental_h_id == "7" || $rental_h_id == "8") ? "off" : "on"; 

// ��å���������
$comp_msg  = ($state == null || $state == "new_req") ? "����" : "����";
$comp_msg .= "����������Ԥ��ޤ�����";


/****************************/
// �ե�����ѡ��ĺ���
/****************************/
/*** �إå��ե����� ***/
// ��Ͽ����
$form->addElement("button", "new_button", "��Ͽ����", "style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

// �ѹ�������
$form->addElement("button", "change_button", "�ѹ�������", "onClick=\"javascript:location.href='1-1-142.php'\"");

/*** �ᥤ��ե����� ***/
if ($state == null || $state == "new_req"){
    // ���в٤���ɼ���Ϥ�Ԥʤ��ܥ���
    $form->addElement("button", "form_print_button", "���в٤���ɼ���Ϥ�Ԥʤ�", "onClick=\"location.href='../sale/1-2-101.php'\"");
}else{
    // �������ɼ���Ϥ�Ԥʤ��ܥ���
    $form->addElement("button", "form_print_button", "�������ɼ���Ϥ�Ԥʤ�", "onClick=\"location.href='..buy/1-3-102.php'\"");
}

// ��λ�ܥ���
$form->addElement("button", "form_quit_button", "����λ", "onClick=\"location.href='./1-3-142.php'\"");


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
    "comp_msg"      => "$comp_msg",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
