<?php
$page_title = "����";

//������ե�����̾�����
$f_name = $_FILES['File']['name'];
//���åץ�����Υѥ�����
$path = "../../../data/";
$up_file = $path.$f_name;
//���åץ���
move_uploaded_file( $_FILES['File']['tmp_name'],$up_file);

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB����³
$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);

//HTML���᡼������������
//require_once(PATH."include/html_quick.php");

/****************************/
// �ե�����ѡ��ĺ���
/****************************/
// �Ĥ���ܥ���
$form->addElement("button", "form_close_button", "�Ĥ���", "onClick=\"window.close()\"");

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
$page_menu = Create_Menu_h('system','1');
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
