<?php
/****************************/
//
// �� (2006/05/31)����������watanabe-k��
//
/****************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007-02-06                  watanabe-k  �ϣ˥ܥ����ɲ�
 */


$page_title = "����ǡ�������";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

/****************************/
//�ե��������
/****************************/
$form->addElement("button", "form_ok_button", "�ϡ���","onClick=\"location.href='./2-2-301.php'\"");


/****************************/
//�����ѿ�����
/****************************/
$shop_id = $_SESSION["client_id"];

if($_GET[add_flg] != true){
    header("Location:../top.php");
}

/***************************/
//GET��������
/***************************/
$get_data = $_SESSION["get_data"];
if(count($get_data) > 0){

    $warning = "�� ̤�����������򹹿����ʤ�����������񤬺�������ޤ���";

    $judge_id = implode(",",$get_data);

    $sql  = "SELECT";
    $sql .= "   client_cd1,";
    $sql .= "   client_cd2,";
    $sql .= "   client_cname";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_id IN ($judge_id)";
    $sql .= " ORDER BY client_cd1, client_cd2 ";
    $sql .= ";"; 

    $result = Db_Query($db_con, $sql);
    $get_judge_data = pg_fetch_all($result);

    for($i = 0; $i < count($get_judge_data); $i++){
        $err_msg[$i]  = $get_judge_data[$i]["client_cd1"]."-";
        $err_msg[$i] .= $get_judge_data[$i]["client_cd2"]."��";
        $err_msg[$i] .= $get_judge_data[$i]["client_cname"];
        $err_msg[$i] .= "�������ϡ�̤����������񤬤��ä���������Ǥ��ޤ���Ǥ�����";
    }
}

/*
$made_data = $_SESSION["made_data"];
if(count($made_data) > 0){
    $judge_id = implode(",",$made_data);

    $sql  = "SELECT";
    $sql .= "   client_cd1,";
    $sql .= "   client_cd2,";
    $sql .= "   client_cname";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_id IN ($judge_id)";
    $sql .= ";"; 

    $result = Db_Query($db_con, $sql);
    $get_judge_data = pg_fetch_all($result);

    for($i = 0; $i < count($get_judge_data); $i++){
        $err_msg4[$i]  = $get_judge_data[$i]["client_cd1"]."-";
        $err_msg4[$i] .= $get_judge_data[$i]["client_cd2"]."��";
        $err_msg4[$i] .= $get_judge_data[$i]["client_cname"];
        $err_msg4[$i] .= "�������ϡ����˺����ѤߤǤ���";
    }
}

$no_sheet_data = $_SESSION["no_sheet_data"];
if(count($no_sheet_data) > 0){
    $no_sheet_id = implode(",",$no_sheet_data);

    $sql  = "SELECT";
    $sql .= "   client_cd1,";
    $sql .= "   client_cd2,";
    $sql .= "   client_cname";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_id IN ($no_sheet_id)";
    $sql .= ";"; 
    $result = Db_Query($db_con, $sql);
    $get_no_sheet_data = pg_fetch_all($result);

    for($i = 0; $i < count($get_no_sheet_data); $i++){
        $err_msg2[$i]  = $get_no_sheet_data[$i]["client_cd1"]."-";
        $err_msg2[$i] .= $get_no_sheet_data[$i]["client_cd2"]."��";
        $err_msg2[$i] .= $get_no_sheet_data[$i]["client_cname"];
        $err_msg2[$i] .= "�������ϡ������ե����ޥå������ԤäƤ��ʤ���������Ǥ��ޤ���Ǥ�����";
    }
}


$renew_data = $_SESSION["renew_data"];
if(count($renew_data) > 0){
    $renew_data_id = implode(",",$renew_data);
    $sql  = "SELECT";
    $sql .= "   client_cd1,";
    $sql .= "   client_cd2,";
    $sql .= "   client_cname";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_id IN ($renew_data_id)";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $get_renew_data = pg_fetch_all($result);

    for($i = 0; $i < count($get_renew_data); $i++){

        $err_msg3[$i]  = $get_renew_data[$i]["client_cd1"]."-";
        $err_msg3[$i] .= $get_renew_data[$i]["client_cd2"]."��";
        $err_msg3[$i] .= $get_renew_data[$i]["client_cname"];
        $err_msg3[$i] .= "�������ϡ���������ṹ�������������դ���ꤷ�Ƥ�����������Ǥ��ޤ���Ǥ�����";
    }
}

//�����줫�Υ��顼�����ä����
if(count($err_msg) > 0 || count($err_msg2) > 0 || count($err_msg3) > 0 || count($err_msg4) > 0){
    $err_flg = true;
}
*/
unset($_SESSION["get_data"]);
unset($_SESSION["no_sheet_data"]);
unset($_SESSION["renew_data"]);
unset($_SESSION["made_data"]);
/*
if($_SESSION[get_data] != null){


        $array_id = $_SESSION[get_data];

        $sql  = "SELECT";
        $sql .= "   client_cd1,";
        $sql .= "   client_cd2,";
        $sql .= "   client_cname";
        $sql .= " FROM";
        $sql .= "   t_client";
        $sql .= " WHERE";
//            $sql .= "   client_id = $array_id[$i]";
        $sql .= "   client_id IN ($array_id) ";
        $sql .= "ORDER BY client_cd1, client_cd2";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        $count = pg_num_rows($result);

    for($i = 0; $i < $count; $i++){

            $get_judge_data = @pg_fetch_array($result, $i);
            $err_msg[$i]  = $get_judge_data["client_cd1"]."-";
            $err_msg[$i] .= $get_judge_data["client_cd2"]."��";
            $err_msg[$i] .= $get_judge_data["client_cname"];
            $err_msg[$i] .= "�������ϡ�̤����������񤬤��ä���������Ǥ��ޤ���Ǥ�����";
        }
//    }
    unset($_SESSION["get_data"]);
}
*/
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
$page_menu = Create_Menu_h('sale','3');
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
	'err_flg'       => "$err_flg",
    'warning'        => "$warning",
));

$smarty->assign("err_msg",$err_msg);
$smarty->assign("err_msg2",$err_msg2);
$smarty->assign("err_msg3",$err_msg3);
$smarty->assign("err_msg4",$err_msg4);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
