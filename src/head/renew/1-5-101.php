<?php
/*******************************************
 *  �ѹ�����
 *      ��20060811�������������оݥơ��֥�˹�������Ĥ��������ɲá�watanabe-k��
 *  2007-04-13              fukuda      ����ɽ����30�狼��60����ѹ�
 *
 *
 *
********************************************/

/*******************************************/
// �ڡ��������
/*******************************************/

// �ڡ��������ȥ�
$page_title = "������������";

// �Ķ�����ե�����
require_once("ENV_local.php");

// DB��³����
$conn = Db_Connect();

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// ���¥����å�
$auth       = Auth_Check($conn);

/****************************/
// HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
// ��˥塼����
/****************************/
$page_menu = Create_Menu_h('renew','1');

/****************************/
// ���̥إå�������
/****************************/
$page_header = Create_Header($page_title);

/****************************/
// �ե�����ѡ������
/****************************/

/*******************************************/
// �ڡ����ɹ�������
/*******************************************/

/****************************/
// �������
/****************************/
// DB�ǡ�������
$sql  = "SELECT     to_date(renew_time, 'YYYY-MM-DD') || ' ' || to_char(renew_time, 'hh24:mi:ss'), \n";
$sql .= "           close_day, \n";
$sql .= "           operation_staff_name \n";
$sql .= "FROM       t_sys_renew \n";
$sql .= "WHERE      renew_div = '1' \n";      // renew_div = '1' : ����
$sql .= "AND        shop_id = ".$_SESSION["client_id"]." \n";
$sql .= "ORDER BY   renew_time DESC \n";
$sql .= "LIMIT      60 \n";
$sql .= "OFFSET     0 \n";
$sql .= ";";
$res  = Db_Query($conn, $sql);

// �����ѥǡ�������
$rec_data = Get_Data($res, "2");

// ���˥�������
if (count($rec_data) > 0){
    foreach ($rec_data as $key => $value){
        $rec_data[$key][2] = htmlspecialchars($value[2]);
    }
}

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'       => "$html_header",
    'page_menu'         => "$page_menu",
    'page_header'       => "$page_header",
    'html_footer'       => "$html_footer",
));

// �����ѥ쥳���ɥǡ�����ƥ�ץ졼�Ȥ��Ϥ�
$smarty->assign("rec_data", $rec_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
