<?php

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/13      10-015      suzuki      ����ޥ����إܥ��󲡲������������ѹ�
*/

$page_title = "��󥿥�TO��󥿥�";

// �Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);

/****************************/
//�����ѿ�����
/****************************/
$rental_id = $_GET["rental_id"];   //��󥿥�ID
$disp_stat = $_GET["disp_stat"];   //��󥿥����
$stat_flg  = $_GET["stat_flg"];    //����ѥǡ���¸��Ƚ��ե饰
$client_id = $_GET["client_id"];   //������ID
$online_flg= $_GET["flg"];   //����饤��ե饰
Get_Id_Check2($disp_stat);

//�ܥ���̾Ƚ��
if($rental_id != NULL){
	//�ѹ�����
	$form->addElement("button","input_btn","�ѹ����̤�","onClick=\"location.href='".FC_DIR."system/2-1-141.php?rental_id=$rental_id'\"");
}else{
	//��Ͽ����
	$form->addElement("button","input_btn","��Ͽ���̤�","onClick=\"location.href='".FC_DIR."system/2-1-141.php'\"");
}
if ($disp_stat != "1"){
	//��������
	$form->addElement("button","disp_btn","�������̤�","onClick=\"location.href='".FC_DIR."system/2-1-142.php?search=1'\"");
}else{
	//��������
	$form->addElement("button","disp_btn","�������̤�","onClick=\"location.href='".FC_DIR."system/2-1-142.php'\"");
}
//����ޥ���
$form->addElement("button","con_btn","����ޥ�����","onClick=\"location.href='".FC_DIR."system/2-1-115.php?client_id=$client_id'\"");

//����Ƚ��
Get_ID_Check3($rental_id);
Get_ID_Check3($client_id);

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
$page_menu = Create_Menu_h('sale','2');

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
	'disp_stat'     => "$disp_stat",
	'stat_flg'      => "$stat_flg",
	'online_flg'      => "$online_flg"
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
