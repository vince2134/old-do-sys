<?php
$page_title = "��������";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB��³
$db_con = Db_Connect();

/*****************************/
// ���´�Ϣ����
/*****************************/
// ���¥����å�
$auth   = Auth_Check($db_con);

/****************************/
// �ե�����ѡ��ĺ���
/****************************/
// ����ܥ��󲡲����κǽ����顼�����å��ˤҤä����ä����
if ($_GET["err"] == "1"){

    $err_msg = "��ɼ�ѹ�������������������Ԥ�줿���ᡢ�ѹ��Ǥ��ޤ���";
    $form->addElement("button","ok_button","�ϡ���", "onClick=\"location.href='2-2-403.php?search=1'\"");

}else
// ����ܥ��󲡲����κǽ����顼�����å��ˤҤä����ä����
if ($_GET["err"] == "2"){

    $err_msg = "����񤬺�����줿���ᡢ����Ǥ��ޤ���";
    $form->addElement("button","ok_button","�ϡ���", "onClick=\"location.href='2-2-403.php?search=1'\"");

}else
// ����ܥ��󲡲����κǽ����顼�����å��ˤҤä����ä����
if ($_GET["err"] == "3"){

    $err_msg = "��ɼ�ѹ������ɼ��������줿���ᡢ�ѹ��Ǥ��ޤ���";
    $form->addElement("button","ok_button","�ϡ���", "onClick=\"location.href='2-2-403.php?search=1'\"");

}else{

    if ($_GET["flg"] == "get"){
        $form->addElement("button","ok_button","�ϡ���", "onClick=\"location.href='2-2-403.php?search=1'\"");
    }else{
        $form->addElement("button","ok_button","�ϡ���", "onClick=\"location.href='2-2-405.php'\"");
    }

}

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
$page_menu = Create_Menu_h("buy", "3");

/****************************/
//���̥إå�������
/****************************/
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

//����¾���ѿ���assign
$smarty->assign("var",array(
    "html_header"   => "$html_header",
    "page_menu"     => "$page_menu",
    "page_header"   => "$page_header",
    "html_footer"   => "$html_footer",
    "err_msg"       => "$err_msg",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>

