<?php
$page_title = "���ʰ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//HTML���᡼������������
require_once(PATH."include/html_quick.php");

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

//GET�ǡ���
$place = $_GET['place'];
$link = $_GET['link'];
$display = $_GET['display'];

//DisplayCode����Ƚ��
if($display == 1){
	$row0 = "'00000001','5','��','5','(0)','6','(0)'";
	$row1 = "'00000002','10','��','5','(0)','46','(0)'";
	$row2 = "'00000003','15','��','5','(0)','36','(0)'";
	$row3 = "'00000004','20','��','5','(0)','26','(0)'";
	$row4 = "'00000005','25','��','5','(0)','16','(0)'";
}else{
	$row0 = "'00000001','����1'";
	$row1 = "'00000002','����2'";
	$row2 = "'00000003','����3'";
	$row3 = "'00000004','����4'";
	$row4 = "'00000005','����5'";
}

/****************************/
//�ڡ�������
/****************************/
//���η��
$total_count = 100;

//ɽ���ϰϻ���
$range = "20";

//�ڡ����������
$page_count = $_POST["f_page1"];

$html_page = Html_Page($total_count,$page_count,1,$range);
$html_page2 = Html_Page($total_count,$page_count,2,$range);

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
	'html_page'     => "$html_page",
	'html_page2'    => "$html_page2",
	'row0'    => "$row0",
	'row1'    => "$row1",
	'row2'    => "$row2",
	'row3'    => "$row3",
	'row4'    => "$row4",
));
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
