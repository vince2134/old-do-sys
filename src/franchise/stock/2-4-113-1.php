<?php
$page_title = "�߸˼�ʧ����";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB��³
$db_con = Db_Connect();

/****************************/
//�����ѿ�����
/****************************/
$shop_div = $_SESSION["shop_div"];                      //�ܼҡ��ټҶ�ʬ

//HTML���᡼������������
require_once(PATH."include/html_quick.php");

//select����������
require_once(PATH."include/select_part.php");


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
$page_menu = Create_Menu_f('stock','1');
/****************************/
//���̥إå�������
/****************************/
$page_header = Create_Header($page_title);


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
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
