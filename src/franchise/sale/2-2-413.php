<?php
/*
 *
 *
 *
 *
 */

$page_title = "����������";

// �Ķ�����ե�����
require_once("ENV_local.php");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth   = Auth_Check($db_con);


/****************************/
// �����ѿ�����
/****************************/
$staff_id   = $_SESSION["staff_id"];
$shop_id    = $_SESSION["client_id"];


/****************************/
// ��������
/****************************/
if ($_GET["ps"] == null && $_GET["err"] == null){
    header("Location:../top.php");
    exit;
}


/****************************/
// �ե�����ѡ������
/****************************/
$form->addElement("button", "ok_button", "�ϡ���", "onClick=\"location.href('".Make_Rtn_Page("advance")."');\"");


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
//$page_menu = Create_Menu_f("sale", "4");

/****************************/
// ���̥إå�������
/****************************/
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

// ����¾���ѿ���assign
$smarty->assign("var", array(
    "html_header"   => "$html_header",
    "page_menu"     => "$page_menu",
    "page_header"   => "$page_header",
    "html_footer"   => "$html_footer",
));

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
