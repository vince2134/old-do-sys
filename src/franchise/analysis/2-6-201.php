<?php
$page_title = "�ޥ����ǡ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);


//ɽ������ѹ�������ϡ���������ν��֤��ѹ����ޤ���
$page_list = array(
"csvf1"  => "��Ź�ޥ���",
"csvf2"  => "����ޥ���",
"csvf3"  => "�Ҹ˥ޥ���",
"csvf4"  => "�϶�ޥ���",
"csvf5"  => "��ԥޥ���",
"csvf6"  => "���롼�ץޥ���",
"csvf7"  => "������ޥ���",
"csvf8"  => "����ޥ���",
"csvf9"  => "������ޥ���",
"csvf10" => "ľ����ޥ���",
"csvf11" => "�����ȼԥޥ���",
"csvf12" => "�����åեޥ���",
"csvf13" => "�Ͷ�ʬ�ޥ���",
"csvf14" => "������ʬ�ޥ���",
"csvf15" => "����ʬ��ޥ���",
"csvf16" => "���ʥޥ���",
"csvf17" => "�ȼ�ޥ���",
"csvf18" => "���֥ޥ���",
"csvf19" => "���ߥޥ���",
"csvf20" => "�����ӥ��ޥ���",
"csvf21" => "�����ʥޥ���",

);


//FC�ޥ���
$button[] = $form->createElement("button","csvf1","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-200.php')\"");
$button[] = $form->createElement("button","csvf2","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-201.php')\"");
$button[] = $form->createElement("button","csvf3","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-203.php')\"");
$button[] = $form->createElement("button","csvf4","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-213.php')\"");
$button[] = $form->createElement("button","csvf5","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-207.php')\"");
$button[] = $form->createElement("button","csvf6","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-113.php')\"");
$button[] = $form->createElement("button","csvf7","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-101.php')\"");
$button[] = $form->createElement("button","csvf8","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-111.php')\"");
$button[] = $form->createElement("button","csvf9","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-215.php')\"");
$button[] = $form->createElement("button","csvf10","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-218.php')\"");
$button[] = $form->createElement("button","csvf11","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-225.php')\"");
$button[] = $form->createElement("button","csvf12","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-107.php')\"");
$button[] = $form->createElement("button","csvf13","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-211.php')\"");
$button[] = $form->createElement("button","csvf14","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-209.php')\"");
$button[] = $form->createElement("button","csvf15","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-241.php')\"");
$button[] = $form->createElement("button","csvf16","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-220.php')\"");
$button[] = $form->createElement("button","csvf17","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-231.php')\"");
$button[] = $form->createElement("button","csvf18","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-234.php')\"");
$button[] = $form->createElement("button","csvf19","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-233.php')\"");
$button[] = $form->createElement("button","csvf20","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-232.php')\"");
$button[] = $form->createElement("button","csvf21","���ϲ��̤�","onClick=\"javascript:location.href('".FC_DIR."system/2-1-229.php')\"");
$form->addGroup($button, "button", "");

/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
//���̥إå�������
/****************************/
$page_header = Create_Header($page_title);

/****************************/
//�ڡ�������
/****************************/
// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//�����ꥹ��
$smarty->assign('page_list',$page_list);

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'html_page'     => "$html_page",
	'html_page2'    => "$html_page2",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
