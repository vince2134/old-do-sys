<?php
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007/09/10                  kajioka-h   ������ޥ����ؤ����ܥܥ����ʤ���
 *
 */


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
"csvh8"  => "�ȼ�ޥ���",
"csvh20" => "���֥ޥ���",
"csvh21" => "���ߥޥ���",
"csvh1"  => "�����ӥ��ޥ���",
"csvh17" => "�����ʥޥ���",

"csvh5"  => "�����åեޥ���",
"csvh11" => "�Ͷ�ʬ�ޥ���",
"csvh10" => "������ʬ�ޥ���",
"csvh4"  => "����ʬ��ޥ���",
"csvh15" => "���ʥޥ���",

"csvh6"  => "����ޥ���",
"csvh7"  => "�Ҹ˥ޥ���",
"csvh12" => "�϶�ޥ���",
"csvh9"  => "��ԥޥ���",
"csvh16" => "��¤�ʥޥ���",

"csvh2"  => "FC�������ޥ���",
"csvh19" => "�ƣö�ʬ�ޥ���",
"csvh3"  => "������ޥ���",
//"csvh13" => "������ޥ���",
"csvh14" => "ľ����ޥ���",
"csvh18" => "�����ȼԥޥ���",
);

//�����ޥ���
$button[] = $form->createElement("button","csvh1","���ϲ��̤�", "onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-231.php')\"");
$button[] = $form->createElement("button","csvh2","���ϲ��̤�", "onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-101.php')\"");
$button[] = $form->createElement("button","csvh3","���ϲ��̤�", "onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-113.php')\"");
$button[] = $form->createElement("button","csvh4","���ϲ��̤�", "onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-235.php')\"");
$button[] = $form->createElement("button","csvh5","���ϲ��̤�", "onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-107.php')\"");
$button[] = $form->createElement("button","csvh6","���ϲ��̤�", "onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-201.php')\"");
$button[] = $form->createElement("button","csvh7","���ϲ��̤�", "onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-203.php')\"");
$button[] = $form->createElement("button","csvh8","���ϲ��̤�", "onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-205.php')\"");
$button[] = $form->createElement("button","csvh9","���ϲ��̤�", "onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-207.php')\"");
$button[] = $form->createElement("button","csvh10","���ϲ��̤�","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-209.php')\"");
$button[] = $form->createElement("button","csvh11","���ϲ��̤�","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-211.php')\"");
$button[] = $form->createElement("button","csvh12","���ϲ��̤�","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-213.php')\"");
//$button[] = $form->createElement("button","csvh13","���ϲ��̤�","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-215.php')\"");
$button[] = $form->createElement("button","csvh14","���ϲ��̤�","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-218.php')\"");
$button[] = $form->createElement("button","csvh15","���ϲ��̤�","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-220.php')\"");
$button[] = $form->createElement("button","csvh16","���ϲ��̤�","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-223.php')\"");
$button[] = $form->createElement("button","csvh17","���ϲ��̤�","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-229.php')\"");
$button[] = $form->createElement("button","csvh18","���ϲ��̤�","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-225.php')\"");
$button[] = $form->createElement("button","csvh19","���ϲ��̤�","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-227.php')\"");
$button[] = $form->createElement("button","csvh20","���ϲ��̤�","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-234.php')\"");
$button[] = $form->createElement("button","csvh21","���ϲ��̤�","onClick=\"javascript:location.href('".HEAD_DIR."system/1-1-233.php')\"");

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
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
