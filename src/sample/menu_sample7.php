<?php
$page_title = "��˥塼����ץ�";

// �ѥ������
define(PATH , "../../");
require_once(PATH."config/global.php");
require_once(PATH."config/config.php");
require_once(PATH."config/define.php");
require_once(PATH."function/session.fnc");
require_once(PATH."function/function.fnc");
require_once(PATH."function/func_qf_rule.inc");
require_once(PATH."function/html.fnc");
require_once(PATH."function/menu_ver6.fnc");
require_once(PATH."function/db.fnc");
// Smarty+QuickForm
require_once("Smarty/Smarty.class.php");
require_once("HTML/QuickForm.php");
require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';
$smarty = new Smarty();   // Smarty���֥������Ȥ�����
$smarty->template_dir = "templates";
$smarty->compile_dir = "templates_c";

//HTML_QuickForm�����
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB��³
$db_con = Db_Connect();

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

$page_menu = Create_Menu_h('analysis','1');

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
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
