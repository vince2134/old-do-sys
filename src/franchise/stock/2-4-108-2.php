<?php
/**
 * �߸˾Ȳ�ʴ�λ���
 *
 * �߸˾Ȳ�λ��˥�å�������ɽ����������β���
 * �߸�Ĵ���δְ㤤ȯ����WATANABE-K��
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/07/12)
 *
 */
/*
 * �ѹ�����
 *
 *
 */

$page_title = "�߸�Ĵ��";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);

/****************************/
//�����ѿ�����
/****************************/
$done_flg = $_GET["done_flg"];           //��λ����

if($done_flg == null){
//    header("Location: 2-4-112.php");
    header("Location: ../top.php");
}

/****************************/
//�������
/****************************/
//OK�ܥ���
$form->addElement("button","ok_button","�ϡ���","onClick=\"location.href='2-4-108.php'\"");
//���
//$form->addElement("button","return_button","�ᡡ��","onClick=\"javascript:history.back()\"");


//$html = NULL;     //HTMLɽ���ǡ��������


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
//$page_menu = Create_Menu_h('sale','1');

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
	//'html'          => "$html",
	'freeze_flg'    => "$freeze_flg",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
