<?php

$page_title = "��������";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm( "dateForm","POST");

/**************HTML���᡼������������********************/

//���̤ν�
$array_week = array(
	"" => "",
	"1" => "1",
	"2" => "2",
	"3" => "3",
	"4" => "4"
);
$form->addElement('select', 'test', '���쥯�ȥܥå���',$array_week);

//��Ͽ�ܥ���
$form->addElement("submit","button","�С�Ͽ");

//���ꥢ
$form->addElement("button","form_clear","���ꥢ",
        "onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\""
);

print_r ($_POST);
/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'html_footer'   => "$html_footer",
	'java_sheet'        => "$java_sheet",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
